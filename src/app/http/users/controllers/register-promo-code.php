<?php
/**
 * ENGINECORE _site_core Extention for zgWeb.Solutions Web.CMS.App
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

require(dirname(__FILE__) . '/../../../engine/process/sessions/includes/check-for-ezcard-login.php');
require(dirname(__FILE__) . '/../../../modules/users/classes/UsersModule.php');

if ( !empty($_SERVER['PHP_AUTH_USER']) && !empty($_SERVER['PHP_AUTH_PW']) && ( $_SERVER['PHP_AUTH_USER'] != $_SESSION["session"]["authentication"]["username"] || $_SERVER['PHP_AUTH_PW'] != $_SESSION["session"]["authentication"]["password"] ) )
{
    die('{"success":false,"message":"You are not authorized to access this: '.json_encode($_SERVER).'"}');
}

if ( strtolower($_SERVER['REQUEST_METHOD']) != "post" )
{
    die('{"success":false,"message":"You are not authorized to access this."}');
}

$intDefaultSponsor = 726;

$strPromoCode = $_POST['promo'];

if ( strtolower(substr($strPromoCode,0,2)) == "ez" )
{
    $strBrandPartnerId = substr($strPromoCode,2);

    if ( strtolower($strPromoCode) == "ez123" )
    {
        $strBrandPartnerId = 726;
    }

    $intDefaultSponsor = 726;
    $intSponsorNum = $intDefaultSponsor;

    $objBrandPartner = User::GetBrandPartnerById($strBrandPartnerId, $connection);

    if ( $objBrandPartner["Result"]["success"] == true )
    {
        $intSponsorNum = $objBrandPartner["Result"]["BrandPartner"]["customerId"];
    }

    $objSponsorResult = User::GetSponsorById($intSponsorNum, $connection);

    $_SESSION["cart"]["brand_partner"]["id"] = $objBrandPartner["Result"]["BrandPartner"]["bpId"];
    $_SESSION["cart"]["brand_partner"]["user_id"] = $objBrandPartner["Result"]["BrandPartner"]["customerId"];
    $_SESSION["cart"]["brand_partner"]["user_data"] = $objSponsorResult["Result"]["Sponsor"];
    $_SESSION["cart"]["brand_partner"]["type"] = "brand-partner";
    $_SESSION["cart"]["brand_partner"]["code-type"] = "ez";

    die('{"success":true,"message":"Found EZcard Sponsor!"}');
}
elseif ( strtolower(substr($strPromoCode,0,2)) == "np" )
{
    $strBrandPartnerId = substr($strPromoCode,2);

    $objBrandPartner = User::GetBrandPartnerById($strBrandPartnerId, $connection);

    if ( $objBrandPartner["Result"]["success"] == false )
    {
        die('{"success":false,"message":"Database query promo failed: '.mysqli_error($connection).'"}');
    }

    $objSponsorResult = User::GetSponsorById($objBrandPartner["Result"]["BrandPartner"]["customerId"], $connection);

    $_SESSION["cart"]["brand_partner"]["id"] = $objBrandPartner["Result"]["BrandPartner"]["bpId"];
    $_SESSION["cart"]["brand_partner"]["user_id"] = $objBrandPartner["Result"]["BrandPartner"]["customerId"];
    $_SESSION["cart"]["brand_partner"]["user_data"] = $objSponsorResult["Result"]["Sponsor"];
    $_SESSION["cart"]["brand_partner"]["type"] = "non-profit";
    $_SESSION["cart"]["brand_partner"]["code-type"] = "np";

    $_SESSION["cart"]["card_referral"]["card_id"] = $objBrandPartner["Result"]["BrandPartner"]["customerId"];


    die('{"success":true,"message":"Found Non-Profit Sponsor!"}');
}
elseif ( strtolower(substr($strPromoCode,0,2)) == "bp" )
{
    $strBrandPartnerId = substr($strPromoCode,2);

    $objBrandPartner = User::GetBrandPartnerById($strBrandPartnerId, $connection);

    if ( $objBrandPartner["Result"]["success"] == false )
    {
        die('{"success":false,"message":"Database query promo failed: '.mysqli_error($connection).'"}');
    }

    $objSponsorResult = User::GetSponsorById($objBrandPartner["Result"]["BrandPartner"]["customerId"], $connection);

    $_SESSION["cart"]["brand_partner"]["id"] = $objBrandPartner["Result"]["BrandPartner"]["bpId"];
    $_SESSION["cart"]["brand_partner"]["user_id"] = $objBrandPartner["Result"]["BrandPartner"]["customerId"];
    $_SESSION["cart"]["brand_partner"]["user_data"] = $objSponsorResult["Result"]["Sponsor"];
    $_SESSION["cart"]["brand_partner"]["type"] = "brand-partner";
    $_SESSION["cart"]["brand_partner"]["code-type"] = "bp";

    $_SESSION["cart"]["card_referral"]["card_id"] = $objBrandPartner["Result"]["BrandPartner"]["customerId"];

    die('{"success":true,"message":"Found Brand Partner Sponsor!"}');
}
else
{
    $sql = 'select plan_id from promo where promo_code = "' . $_POST['promo'] . '"' . '   and status_id = (select id from status where name = "Active")' . '   and ((start_dtm < NOW() and end_dtm > NOW()) or promo_type_id = (select id from promo_type where name = "One-time-use") or promo_type_id = (select id from promo_type where name = "Ongoing"))';

    $rs = mysqli_query($connection, $sql);

    if ( !$rs )
    {
        die('{"success":false,"message":"Database query promo failed: '.mysqli_error($connection).'"}');
    }

    $l_plan_type_name = 'Promo';

    while ( $row = mysqli_fetch_assoc($rs) )
    {
        if ( empty($l_plan_list) )
        {
            $l_plan_list = $row[plan_id];
        }
        else
        {
            $l_plan_list .= ',' . $row[plan_id];
        }
    }

    if ( empty($l_plan_list) )
    {
        $message = getErrorMessage("Sorry, the promo code entered is invalid.");
    }
    else
    {
        $l_hidden_promo_data = '<input type="hidden" name="promo" value="' . $_POST['promo'] . '">';
    }
}