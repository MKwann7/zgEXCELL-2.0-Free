<?php
/**
 * ENGINECORE _site_core Extention for zgWeb.Solutions Web.CMS.App
 */

$blnPurchaseComplete = false;

if ( strtolower($_SERVER['REQUEST_METHOD']) != "post" )
{
    die("How did you get here?");
}

$intDefaultSponsor = 726;

$intSponsorNum = User::GetSponsorFromSession();

if ( $intSponsorNum == 0 )
{
    $intSponsorNum = $intDefaultSponsor;
}

$objSponsorResult = User::GetSponsorById($intSponsorNum, $connection);
$objSponsor = $objSponsorResult["Result"]["Sponsor"];

$intSponsorId = $objSponsor["id"];

$dcSubPlanPrice = 0;
$dcInitialPlanPrice = 0;

$objPlanResult = Card::GetCardPlanById($intPlanId, $connection);
$objPlan = $objPlanResult["Result"]["Plan"];

$objSetupPlanResult = Card::GetCardPlanById($intSetupId, $connection);
$objSetupPlan = $objSetupPlanResult["Result"]["Plan"];

// $intPlanId comes in from /modules/users/controllers/register-ezcard-products.php

if (!empty($objPlan["planPrice"]))
{
    $dcSubPlanPrice = $objPlan["planPrice"];
}

if (!empty($objSetupPlan["planPrice"]))
{
    $dcInitialPlanPrice = $objSetupPlan["planPrice"];
}

$strHostingPlan = "MONTHLY";

if (!empty($objPlan["paymentSchedule"]))
{
    $strHostingPlan = $objPlan['paymentSchedule'];
}

$intProfitSharingId = 0; // This is static for now

$intDefaultTemplate = 6885;

//    $hostingPlan = $_POST['hostingPlan'];

$objNewCustomer = array();

$objNewCustomer["firstname"]   = $_SESSION["cart"]["checkout"]["payment"]["firstname"];
$objNewCustomer["lastname"]    = $_SESSION["cart"]["checkout"]["payment"]["lastname"];
$objNewCustomer["company"]     = $_SESSION["cart"]["checkout"]["payment"]["company"];
$objNewCustomer["username"]    = $_SESSION["cart"]["checkout"]["payment"]["username"];
$objNewCustomer["password"]    = $_SESSION["cart"]["checkout"]["payment"]["password"];
$objNewCustomer["email"]       = $_SESSION["cart"]["checkout"]["payment"]["email"];
$objNewCustomer["phone"]       = $_SESSION["cart"]["checkout"]["payment"]["phone"];
$objNewCustomer["planId"]      = $intPlanId;
$objNewCustomer["hostingPlan"] = $strHostingPlan;
$objNewCustomer["sponsorId"]   = $intSponsorId;

if ( !empty($_SESSION["cart"]["brand_partner"]["code-type"]))
{
    switch(strtolower($_SESSION["cart"]["brand_partner"]["code-type"]))
    {
        case "bp":
            $objNewCustomer["cardTypeId"]   = 2;
            break;
        default:
            $objNewCustomer["cardTypeId"]   = 1;
            break;
    }
}
else
{
    $objNewCustomer["cardTypeId"]   = 1;
}

$objNewCustomer["cardstatus"]   = 1; // 1=pending, 2=active
$objNewCustomer["street"]      = $_SESSION["cart"]["checkout"]["payment"]["street"];
$objNewCustomer["city"]        = $_SESSION["cart"]["checkout"]["payment"]["city"];
$objNewCustomer["state"]       = $_SESSION["cart"]["checkout"]["payment"]["state"];
$objNewCustomer["zip"]         = $_SESSION["cart"]["checkout"]["payment"]["zip"];
$objNewCustomer["country"]     = $_SESSION["cart"]["checkout"]["payment"]["country"];

$objCustomer = User::CreateNewUser($objNewCustomer, $connection);

if ( $objCustomer["Result"]["success"] == false)
{
    die('{"success":false,"message":"Unable to create new EZcard user for our records: '.mysqli_error($connection).'"}');
}

$customerId  = $objCustomer["Result"]["User"]["id"];
$_SESSION["cart"]["checkout"]["payment"]["User"]["customerId"] = $customerId;
$customerVer = $objCustomer["Result"]["User"]["ver"];
$customerPassword = $objCustomer["Result"]["User"]["password"];

$ownerFname  = $_SESSION["cart"]["checkout"]["payment"]["firstname"];

$ccToken           = $_SESSION["cart"]["checkout"]["payment"]["token"];
$strStripeCard     = $_SESSION["cart"]["checkout"]["payment"]["card"];
$ccCardLast4       = $_SESSION["cart"]["checkout"]["payment"]["last4"];
$ccCardM           = $_SESSION["cart"]["checkout"]["payment"]["month"];
$ccCardY           = $_SESSION["cart"]["checkout"]["payment"]["year"];
$ccName            = $_SESSION["cart"]["checkout"]["payment"]["name"];
$strStripeCustomer = $_SESSION["cart"]["checkout"]["payment"]["customer"];
$ccStreet          = $_SESSION["cart"]["checkout"]["payment"]["street"];
$ccCity            = $_SESSION["cart"]["checkout"]["payment"]["city"];
$ccState           = $_SESSION["cart"]["checkout"]["payment"]["state"];
$ccZip             = $_SESSION["cart"]["checkout"]["payment"]["zip"];
$ccCountry         = $_SESSION["cart"]["checkout"]["payment"]["country"];

// Check to see if this is a brand partner and register it
if ( !empty($_SESSION["cart"]["brand_partner"]["code-type"]) && $_SESSION["cart"]["brand_partner"]["code-type"] == "bp" )
{
    User::CreateNewBrandPartnerByCustomerId($customerId, $intPlanId, $connection);
}

$sql = 'insert into customerPaymentMethod '
    . '('
    .     'id, owner_customer_id, paymentAccount_id, paymentCard_id, token, tokenType, '
    .     ' identifier, expiresMonth, expiresYear, default_TF, created, paymentMethod_id, paymentMethodType_id, '
    .     ' billingName, billingAddressLine1, billingAddressLine2, billingAddressCity, '
    .     ' billingAddressState_id, billingAddressCountry, billingAddressCountryAbbr, '
    .     ' billingAddressZip, dateTimeAdded, dateTimeModified'
    . ') '
    . 'values '
    . '('
    .     'NULL, ' . $customerId . ', "' . $strStripeCustomer . '",'
    .         ' "' . $strStripeCard . '", '
    .         ' "' . $ccToken . '",'
    .         ' "card",'
    .   ' "' . $ccCardLast4 . '", '
    .   ' "' . $ccCardM . '", '
    .   ' "' . $ccCardY . '", '
    .   ' 1, '
    .   ' "' . strtotime("now") . '", '
    .         ' (select id from paymentMethod where name = "Stripe"),'
    .         ' (select id from paymentMethodType where name = "Card"),'
    .   ' "' . $ccName . '",'
    .         ' "' . $ccStreet . '",'
    .         ' "",'
    .         ' "' . $ccCity . '",'
    .   ' (select id from states where state_abbr = "' . $ccState . '"),'
    .         ' "' . $ccCountry . '",'
    .         ' "",'
    .   ' "' . $ccZip . '",'
    .         ' NOW(),'
    .         ' NOW()'
    . ')';

$rs = mysqli_query($connection, $sql);

if ( ! $rs )
{
    die('{"success":false,"message":"Unable to insert successful payment method into EZcard Database for our records: '.mysqli_error($connection).'"}');
}

$customerPaymentMethod_id = mysqli_insert_id($connection);

$sql = 'update customers set ownerId = ' . $customerId . ', customerPaymentMethod_id = "' . $strStripeCustomer . '" '
    . 'where  id = ' . $customerId;
$rs = mysqli_query($connection, $sql);

if ( ! $rs )
{
    die('{"success":false,"message":"Unable to update EZcard customer with payment customer token in Database for our records: '.mysqli_error($connection).'"}');
}

$date  = new DateTime();
$year  = $date->format("Y");
$month = $date->format("m");
$week  = $date->format("W");

$sql = 'insert into trans '
    . '  (id, customer_id, totalSale, paymentStatus_id, commissionsPaid_TF, commissionsPaidComplete_TF,'
    .    'fullyPaid_TF, reconciled_TF, dateYear, dateMonth, dateWeek, dtm) '
    . 'values (NULL,' . $customerId . ', "' . ($dcSubPlanPrice + $dcInitialPlanPrice) . '", '
    .         '(select id from paymentStatus where name = "Initialized"), 0, 0, 0, 0, '
    .         $year . ', ' . $month . ', ' . $week . ', NULL)';

$rs = mysqli_query($connection, $sql);

if ( ! $rs )
{
    die('{"success":false,"message":"Database queryInsertTrans failed for our records: '.mysqli_error($connection).'"}');
}

$trans_id = mysqli_insert_id( $connection );

$sql = 'INSERT INTO transLineItem '
    . '  (trans_id,transType_id,refTable_id,table_id) '
    . 'VALUES (' . $trans_id . ', '
    .         ' (select id from transType where name = "Sign-up"), '
    .         ' (select id from refTable where name = "plan"), '
    .          $intPlanId . ')';
$rs = mysqli_query($connection, $sql);

if ( ! $rs )
{
    die('{"success":false,"message":"Database queryInsertTransLineItem failed for our records: '.mysqli_error($connection).'"}');
}

$sql      = 'INSERT INTO transPayment ' . '  (trans_id, paymentType_id, paymentMethod_id, paymentStatus_id, paymentAmount, fee, identifier, dtm) ' . 'VALUES (' . $trans_id . ', ' . ' (select id from paymentType where name = "Auto"), ' . ' (select id from paymentMethod where name = "Stripe"), ' . ' (select id from paymentStatus where name = "Complete"), ' . $dcSubPlanPrice . ', ' . '"0", ' . '"' . $_SESSION["cart"]["checkout"]["payment"]["subscription"] . '", ' . 'NULL)';
$rs = mysqli_query($connection, $sql);

if ( !$rs )
{
    die('{"success":false,"message":"Database queryInsertTransPayment failed for our records: '.mysqli_error($connection).'"}');
}

$sql      = 'INSERT INTO transPayment ' . '  (trans_id, paymentType_id, paymentMethod_id, paymentStatus_id, paymentAmount, fee, identifier, dtm) ' . 'VALUES (' . $trans_id . ', ' . ' (select id from paymentType where name = "Auto"), ' . ' (select id from paymentMethod where name = "Stripe"), ' . ' (select id from paymentStatus where name = "Complete"), ' . $dcInitialPlanPrice . ', ' . '"0", ' . '"' . $_SESSION["cart"]["checkout"]["payment"]["initial-purchase"] . '", ' . 'NULL)';
$rs = mysqli_query($connection, $sql);

if ( !$rs )
{
    die('{"success":false,"message":"Database queryInsertTransPayment failed for our records: '.mysqli_error($connection).'"}');
}

// We're cloning the template card to the newly created card
Card::CopyAllTabsToCard($intDefaultTemplate, $customerId, $connection);
Card::CloneCardPrimaryImage($intDefaultTemplate, $customerId, $connection);
Card::CloneCardConnectionTypes($intDefaultTemplate, $customerId, $connection);

$sql = 'update trans set paymentStatus_id = (select id from paymentStatus where name = "Complete"), '
    .                  'fullyPaid_TF = 1 '
    . 'where  id = ' . $trans_id;
$rs  = mysqli_query( $connection, $sql );

$_SESSION["account"]["active"][rand(1000,9999)] = array("id" => $customerId, "ver" => $customerVer, "password" => $customerPassword, "start_time" => date("Y-m-d h:i:s", strtotime("now")));
$_SESSION["account"]["primary"] = $customerVer;

die('{"success":true,"name":"'.$ownerFname.'","message":"The creation of your EZcard was successful."}');