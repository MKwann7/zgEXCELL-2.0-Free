<?php
/**
 * ENGINECORE _site_core Extention for zgWeb.Solutions Web.CMS.App
 */

require(dirname(__FILE__) . '/../../../engine/process/sessions/includes/check-for-ezcard-loginwidget.php');

if ( !empty($_SERVER['PHP_AUTH_USER']) && !empty($_SERVER['PHP_AUTH_PW']) && ( $_SERVER['PHP_AUTH_USER'] != $_SESSION["session"]["authentication"]["username"] || $_SERVER['PHP_AUTH_PW'] != $_SESSION["session"]["authentication"]["password"] ) )
{
    die('{"success":false,"message":"You are not authorized to access this."}');
}

if ( strtolower($_SERVER['REQUEST_METHOD']) != "post" )
{
    die('{"success":false,"message":"You are not authorized to access this."}');
}

require(dirname(__FILE__) . '/../../../../lib/stripe-php/init.php');
require(dirname(__FILE__) . '/../../../plugins/stripe/includes/stripe.keys.php');

if (empty($_SESSION["cart"]["checkout"]["payment"]["token"]))
{
    die('{"success":false,"message":"Your Payment Account did not process correctly on our end. Please try again!"}');
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ( !filter_var($_POST['ownerEmail'], FILTER_VALIDATE_EMAIL) )
{
    die('{"success":false,"message":"Please enter a valid email address: ' . $_POST['ownerEmail'] . '"}');
}

$sql = 'select ownerId from ownerEmail where email = "' . $_POST['ownerEmail'] . '"';

$rs = mysqli_query($connection, $sql);

if (!$rs) {
    die('{"success":false,"message":"Database owner email query failed: '.mysqli_error($connection).'"}');
}

$row = mysqli_fetch_assoc($rs);

if ( isset($row['ownerId']) )
{
    die('{"success":false,"message":"' . $_POST['ownerEmail'] . ' is already registered with our system. If you believe this to be in error, or need help recovering your account, please contact EZcard today!');
}

\Stripe\Stripe::setApiKey($stripe["secret_key"]);

$objCustomer = array(
    "description"    => $_POST['ownerFname'] . " " . $_POST['ownerLname'] . " <" . $_POST['ownerEmail'] . ">",
    "email"          => $_POST['ownerEmail'],
    "source"         => $_SESSION["cart"]["checkout"]["payment"]["token"]
);

try
{
    $objStripeCustomerToken = \Stripe\Customer::create($objCustomer);
}
catch(\Stripe\Error\Card $e)
{
    // Since it's a decline, \Stripe\Error\Card will be caught
    $body = $e->getJsonBody();

    //CODE: send an email
    $errDesc = '{"success":false,"message":"An unexpected card error occurred while registering your account. Please try again! Error code: ' . $e->getMessage() . '"}';
}
catch (\Stripe\Error\RateLimit $e)
{
    // Too many requests made to the API too quickly
    $body = $e->getJsonBody();

    $errDesc = '{"success":false,"message":"Oh, no! The server was overload and was unable to process this request. Please try again in just a moment!"}';
}
catch (\Stripe\Error\InvalidRequest $e)
{
    // Invalid parameters were supplied to Stripe's API
    $body = $e->getJsonBody();

    $errDesc = '{"success":false,"message":"Oops. The payment account information was rejected by our merchant. Please check your input and then try again: ' . $e->getMessage() . '"}';
}
catch (\Stripe\Error\Authentication $e)
{
    // Authentication with Stripe's API failed
    // (maybe you changed API keys recently)
    $body = $e->getJsonBody();

    $errDesc = '{"success":false,"message":"Oh, no! We failed to authenticate with the merchant. Please try again in just a moment!  If this error continues to occur, please notify the administrator."}';
    //CODE: send an email
}
catch (\Stripe\Error\ApiConnection $e)
{
    // Network communication with Stripe failed
    $body = $e->getJsonBody();

    $errDesc = '{"success":false,"message":"Oh, no! We failed to connect with our merchant. This could be a temporary networking issue.  Please try again momentarily."}';
}
catch (\Stripe\Error\Base $e)
{
    // Display a very generic error to the user, and maybe send
    // yourself an email
    $body = $e->getJsonBody();

    $errDesc = '{"success":false,"message":"Oh, no! A merchant services error occurred.  We will be looking into it.  Please try again momentarily."}';
    //CODE: send an email
}
catch (Exception $e)
{
    // Something else happened, completely unrelated to Stripe
    $body = $e->getJsonBody();

    $errDesc = '{"success":false,"message":"Oh, drat! An unknown error occurred.  We will be looking into it.  Please try again momentarily."}';
    //CODE: send an email
}

if (!empty($errDesc))
{
    $strErrorMessage1 = "ERROR CREATING CUSTOMER FOR: " . $_SESSION["cart"]["checkout"]["payment"]["name"];
    $strErrorMessage1 .= " Name: " . $_POST['ownerFname'] . " " . $_POST["ownerLname"] . " <" . $_POST['username'] . ">, " . $_POST["ownerEmail"] . ", " . $_POST["phone"];
    logText("register-new-account_ERROR.log", $strErrorMessage1);

    if ( !empty($body) && is_array($body))
    {
        $strErrorMessage2 = "Error From Stripe: " . json_encode($body);
        logText("register-new-account_ERROR.log", $strErrorMessage1);
    }

    die($errDesc);
}

$_SESSION["cart"]["checkout"]["payment"]["customer"] = $objStripeCustomerToken->id;
$_SESSION["cart"]["checkout"]["payment"]["card"] = $objStripeCustomerToken->default_source;
$_SESSION["cart"]["checkout"]["payment"]["email"] = $_POST['ownerEmail'];
$_SESSION["cart"]["checkout"]["payment"]["firstname"] = $_POST['ownerFname'];
$_SESSION["cart"]["checkout"]["payment"]["lastname"] = $_POST['ownerLname'];
$_SESSION["cart"]["checkout"]["payment"]["phone"] = $_POST['phone'];
$_SESSION["cart"]["checkout"]["payment"]["username"] = $_POST['username'];
$_SESSION["cart"]["checkout"]["payment"]["password"] = $_POST['password'];
$_SESSION["cart"]["checkout"]["payment"]["company"] = $_POST['companyName'];
$_SESSION["cart"]["checkout"]["payment"]["country"] = $objStripeCustomerToken->sources->data[0]->country;

echo '{"success":true,"message":"We successfully registered your payment account, ' . $_SESSION["cart"]["checkout"]["payment"]["name"] . '! Hold on while we setup your card subscription."}';
die();