<?php
/**
 * ENGINECORE _site_core Extention for zgWeb.Solutions Web.CMS.App
 */

require(dirname(__FILE__) . '/../../../_includes/init.php');
session_start();
require(dirname(__FILE__) . '/../../../../lib/stripe-php/init.php');
//require(dirname(__FILE__) . '/../../../util/purchase-functions.php');
require(dirname(__FILE__) . '/../../../_connections/db.php');
require(dirname(__FILE__) . '/../../../modules/cards/classes/main.class.php');
require(dirname(__FILE__) . '/../../../modules/users/classes/UsersModule.php');
require(dirname(__FILE__) . '/../../../plugins/stripe/includes/stripe.keys.php');

if ( !empty($_SERVER['PHP_AUTH_USER']) && !empty($_SERVER['PHP_AUTH_PW']) && ( $_SERVER['PHP_AUTH_USER'] != $_SESSION["session"]["authentication"]["username"] || $_SERVER['PHP_AUTH_PW'] != $_SESSION["session"]["authentication"]["password"] ) )
{
    die('{"success":false,"message":"You are not authorized to access this."}');
}

if ( strtolower($_SERVER['REQUEST_METHOD']) != "post" )
{
    die('{"success":false,"message":"You are not authorized to access this."}');
}

error_reporting(E_ALL);
ini_set('display_errors', 1);


\Stripe\Stripe::setApiKey($stripe["secret_key"]);

$intPlanId = floatval($_POST["planId"]);
$intSetupId = floatval($_POST["setupPlanId"]);

// This forces the Executive Plans to have a Deluxe Setup
if ($intPlanId == 71 || $intPlanId == 73)
{
    $intSetupId = 57;
}

$objSetupPlan = array();

if ( $intSetupId != 0 )
{
    $objSetupPlanResult = (new Card())->GetCardPlanById($intSetupId, $connection);
    $objSetupPlan = $objSetupPlanResult["Result"]["Plan"];
}

$objNewSubscription = array(
    "customer" => $_SESSION["cart"]["checkout"]["payment"]["customer"],
    "items" => array(
        array(
            "plan" => $intPlanId,
        ),
    )
);

try
{
    $objStripeSubscriptionToken = \Stripe\Subscription::create($objNewSubscription);
}
catch(\Stripe\Error\Card $e)
{

    // Since it's a decline, \Stripe\Error\Card will be caught
    $body = $e->getJsonBody();
    $err  = $body['error'];

    //CODE: send an email
    die('{"success":false,"message":"An unexpected card error occurred while registering your purchase. Please try again! Error code: ' . $err . '"}');
}
catch (\Stripe\Error\RateLimit $e)
{
    // Too many requests made to the API too quickly
    die('{"success":false,"message":"Oh, no! The server was overload and was unable to process this request. Please try again in just a moment!"}');
}
catch (\Stripe\Error\InvalidRequest $e)
{
    // Invalid parameters were supplied to Stripe's API
    die('{"success":false,"message":"Oops. The purchase information was rejected by our merchant. Please check your input and then try again: ' . $e->getMessage() . '"}');
}
catch (\Stripe\Error\Authentication $e)
{
    // Authentication with Stripe's API failed
    // (maybe you changed API keys recently)
    die('{"success":false,"message":"Oh, no! We failed to authenticate with the merchant. Please try again in just a moment!  If this error continues to occur, please notify the administrator."}');
    //CODE: send an email
}
catch (\Stripe\Error\ApiConnection $e)
{
    // Network communication with Stripe failed
    die('{"success":false,"message":"Oh, no! We failed to connect with our merchant. This could be a temporary networking issue.  Please try again momentarily."}');
}
catch (\Stripe\Error\Base $e)
{
    // Display a very generic error to the user, and maybe send
    // yourself an email
    die('{"success":false,"message":"Oh, no! A merchant services error occurred.  We will be looking into it.  Please try again momentarily."}');
    //CODE: send an email
}
catch (Exception $e)
{
    // Something else happened, completely unrelated to Stripe
    die('{"success":false,"message":"Oh, drat! An unknown error occurred.  We will be looking into it.  Please try again momentarily."}');
    //CODE: send an email
}

if ( $intSetupId != 0 )
{

    $objNewInitialPurchase = array(
        "amount"               => ($objSetupPlan["planPrice"] * 100),
        "currency"             => "usd",
        "customer"             => $_SESSION["cart"]["checkout"]["payment"]["customer"],
        "description"          => $objSetupPlan["descr"],
        "statement_descriptor" => substr(str_replace(" ", "", $objSetupPlan["name"]), 0, 21),
        // 22 character limit
        "receipt_email"        => $_SESSION["cart"]["checkout"]["payment"]["email"],
        "expand"               => array("balance_transaction")
    );

    try
    {
        $objStripeInitialPurchaseToken = \Stripe\Charge::create($objNewInitialPurchase);
    }
    catch ( \Stripe\Error\Card $e )
    {

        // Since it's a decline, \Stripe\Error\Card will be caught
        $body = $e->getJsonBody();
        $err  = $body['error'];

        //CODE: send an email
        die('{"success":false,"message":"An unexpected card error occurred while registering your purchase. Please try again! Error code: ' . $err . '"}');
    }
    catch ( \Stripe\Error\RateLimit $e )
    {
        // Too many requests made to the API too quickly
        die('{"success":false,"message":"Oh, no! The server was overload and was unable to process this request. Please try again in just a moment!"}');
    }
    catch ( \Stripe\Error\InvalidRequest $e )
    {
        // Invalid parameters were supplied to Stripe's API
        die('{"success":false,"message":"Oops. The purchase information was rejected by our merchant. Please check your input and then try again: ' . $e->getMessage() . '"}');
    }
    catch ( \Stripe\Error\Authentication $e )
    {
        // Authentication with Stripe's API failed
        // (maybe you changed API keys recently)
        die('{"success":false,"message":"Oh, no! We failed to authenticate with the merchant. Please try again in just a moment!  If this error continues to occur, please notify the administrator."}');
        //CODE: send an email
    }
    catch ( \Stripe\Error\ApiConnection $e )
    {
        // Network communication with Stripe failed
        die('{"success":false,"message":"Oh, no! We failed to connect with our merchant. This could be a temporary networking issue.  Please try again momentarily."}');
    }
    catch ( \Stripe\Error\Base $e )
    {
        // Display a very generic error to the user, and maybe send
        // yourself an email
        die('{"success":false,"message":"Oh, no! A merchant services error occurred.  We will be looking into it.  Please try again momentarily."}');
        //CODE: send an email
    }
    catch ( Exception $e )
    {
        // Something else happened, completely unrelated to Stripe
        die('{"success":false,"message":"Oh, drat! An unknown error occurred.  We will be looking into it.  Please try again momentarily."}');
        //CODE: send an email
    }

    $_SESSION["cart"]["checkout"]["payment"]["initial-purchase"] = $objStripeInitialPurchaseToken->id;
}
else
{
    $_SESSION["cart"]["checkout"]["payment"]["initial-purchase"] = 0;
}

$_SESSION["cart"]["checkout"]["payment"]["subscription"] = $objStripeSubscriptionToken->id;

//$_SESSION["cart"]["checkout"]["payment"]["initial-purchase-fee"] = $objStripeInitialPurchaseToken->balance_transaction->fee;

require(dirname(__FILE__) . '/register-ezcard.php');

echo '{"success":true,"name":"'.$_SESSION["cart"]["checkout"]["payment"]["name"].'","message":"We successfully created your subscription and payment account, ' . $_SESSION["cart"]["checkout"]["payment"]["name"]  . '! Let\'s get your card setup!."}';
die();