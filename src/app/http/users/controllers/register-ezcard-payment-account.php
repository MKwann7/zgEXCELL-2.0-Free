<?php
/**
 * ENGINECORE _site_core Extention for zgWeb.Solutions Web.CMS.App
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

require(dirname(__FILE__) . '/../../../engine/process/sessions/includes/check-for-ezcard-loginwidget.php');

if ( !empty($_SERVER['PHP_AUTH_USER']) && !empty($_SERVER['PHP_AUTH_PW']) && ( $_SERVER['PHP_AUTH_USER'] != $_SESSION["session"]["authentication"]["username"] || $_SERVER['PHP_AUTH_PW'] != $_SESSION["session"]["authentication"]["password"] ) )
{
    die('{"success":false,"message":"You are not authorized to access this: '.json_encode($_SERVER).'"}');
}

if ( strtolower($_SERVER['REQUEST_METHOD']) != "post" )
{
    die('{"success":false,"message":"You are not authorized to access this."}');
}

require(dirname(__FILE__) . '/../../../../lib/stripe-php/init.php');
require(dirname(__FILE__) . '/../../../plugins/stripe/includes/stripe.keys.php');

$_SESSION["cart"]["checkout"]["payment"] = array();

\Stripe\Stripe::setApiKey($stripe["secret_key"]);

$card = array(
    "card" => array(
        "number" => $_POST["creditcard"],
        "cvc" => $_POST["securitycode"],
        "name" => $_POST["nameoncard"],
        "exp_month" => floatval($_POST["expirationM"]),
        "exp_year" => floatval($_POST["expirationY"]),
        "address_line1" => $_POST["billingstreetaddress"],
        "address_city" => $_POST["billingcity"],
        "address_state" => $_POST["billingstate"],
        "address_zip" => $_POST["billingzip"]
    )
);

try
{
    $objStripeCardToken = \Stripe\Token::create($card);
}
catch(\Stripe\Error\Card $e)
{
    // Since it's a decline, \Stripe\Error\Card will be caught
    $rStatus = 'failed';
    $body = $e->getJsonBody();
    $err  = $body['error'];
    $errStat = $e->getHttpStatus();
    $errDesc = 'Declined';
}
catch (\Stripe\Error\RateLimit $e)
{
    // Too many requests made to the API too quickly
    $rStatus = 'failed';
    $body = $e->getJsonBody();
    $err  = $body['error'];
    $errStat = $e->getHttpStatus();
    $errDesc = 'Turbo';
}
catch (\Stripe\Error\InvalidRequest $e)
{
    // Invalid parameters were supplied to Stripe's API
    $rStatus = 'failed';
    $body = $e->getJsonBody();
    $err  = $body['error'];
    $errStat = $e->getHttpStatus();
    $errDesc = 'Invalid Parameters';
}
catch (\Stripe\Error\Authentication $e)
{
    // Authentication with Stripe's API failed
    // (maybe you changed API keys recently)
    $rStatus = 'failed';
    $body = $e->getJsonBody();
    $err  = $body['error'];
    $errStat = $e->getHttpStatus();
    $errDesc = 'API Key Fail';
}
catch (\Stripe\Error\ApiConnection $e)
{
    // Network communication with Stripe failed
    $rStatus = 'failed';
    $body = $e->getJsonBody();
    $err  = $body['error'];
    $errStat = $e->getHttpStatus();
    $errDesc = 'No API';
}
catch (\Stripe\Error\Base $e)
{
    // Display a very generic error to the user, and maybe send
    // yourself an email
    $rStatus = 'failed';
    $body = $e->getJsonBody();
    $err  = $body['error'];
    $errStat = $e->getHttpStatus();
    $errDesc = 'Generic';
}
catch (Exception $e)
{
    // Something else happened, completely unrelated to Stripe
    $rStatus = 'failed';
    $body = $e->getJsonBody();
    $err  = $body['error'];
    $errStat = $e->getHttpStatus();
    $errDesc = 'Other';
}

if (!empty($errDesc))
{
    $strErrorMessage1 = $_POST["nameoncard"]. " [" . $_POST["creditcard"] . "] [" . floatval($_POST["expirationM"]) . "/" . floatval($_POST["expirationY"]) . "]";
    $strErrorMessage1 .= "] Address: " . $_POST["billingstreetaddress"] . ", " . $_POST["billingcity"] . ", " . $_POST["billingstate"] . " " . $_POST["billingzip"];
    logText("register-new-payment_ERROR.log", $strErrorMessage1);

    $strErrorMessage = "";

    if ( !empty($body) && is_array($body))
    {
        if (!empty($body["error"]["message"]))
        {
            $strErrorMessage = $body["error"]["message"];
        }
        else
        {
            $strErrorMessage = "A card error occurred. Please try another card.";
        }

        logText("register-new-payment_ERROR.log", $strErrorMessage . " : " . json_encode($body));
    }

    echo '{"success":false,"message":" Payment Error: ' . $strErrorMessage . '"}';
    die();
}

$_SESSION["cart"]["checkout"]["payment"]["token"] = $objStripeCardToken->id;
$_SESSION["cart"]["checkout"]["payment"]["last4"] = substr($_POST["creditcard"],-4);
$_SESSION["cart"]["checkout"]["payment"]["month"] = floatval($_POST["expirationM"]);
$_SESSION["cart"]["checkout"]["payment"]["year"] = floatval($_POST["expirationY"]);
$_SESSION["cart"]["checkout"]["payment"]["name"] = $_POST["nameoncard"];
$_SESSION["cart"]["checkout"]["payment"]["street"] = $_POST["billingstreetaddress"];
$_SESSION["cart"]["checkout"]["payment"]["city"] = $_POST["billingcity"];
$_SESSION["cart"]["checkout"]["payment"]["state"] = $_POST["billingstate"];
$_SESSION["cart"]["checkout"]["payment"]["zip"] = $_POST["billingzip"];

echo '{"success":true,"token":"'.$_SESSION["cart"]["checkout"]["payment"]["token"].'","message":"Your payment account has been authorized!"}';
die();