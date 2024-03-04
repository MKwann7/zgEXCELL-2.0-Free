<?php

use App\Utilities\Database;
use Entities\Users\Classes\Users;

$this->CurrentPage->BodyId            = "password-reset-page";
$this->CurrentPage->BodyClasses       = ["page", "loginwidget-page", "no-columns"];
$this->CurrentPage->Meta->Title       = "Reset Your Password | " . $this->app->objCustomPlatform->getPortalDomainName();
$this->CurrentPage->Meta->Description = "Your digital card is one step away. Login now to manage it!";
$this->CurrentPage->Meta->Keywords    = "Digital Cards, Online Business Cards, Greg Sanders";
$this->CurrentPage->SnipIt->Title     = "Reset Your Password";
$this->CurrentPage->SnipIt->Excerpt   = "Your digital card is one step away. Login now to manage it!";
$this->CurrentPage->Columns           = 0;

$resetPasswordToken = Database::forceUtf8($this->app->objHttpRequest->Data->Params["request"]);
$objUserResult = (new Users())->getWhere(["password_reset_token" => $resetPasswordToken], 1);

?>
<div class="wrapper loggedOutBody">
    <div class="content">
        <h1 class="page-title-main">Reset Your Password</h1>

        <div class="space10"></div>
        <?php if ( $objUserResult->result->Success === false || $objUserResult->result->Count === 0)
            { ?>
                <h2>Woops.</h2>
                <hr>
                <p style="text-align:center;">Looks like we are missing an active reset token.</p>
                <hr>
                <h3>Need to Reset your Password?</h3>
                <p>You can try <a href="<?php getFullUrl(); ?>/login" >resetting your password</a> again to get a new one via your primary EZcard account email.</p>
        <?php
            }
            else
            { ?>
        <div class="loginMainfloat">
            <div class="aboutUsSectionTitleText" style="margin-bottom: 12px; text-align: center;">
                Setup Your New Password
            </div>
            <div class="siteLoginFloat">
                <?php require __DIR__ . "../../_shared/components/resetpassword.form" . XT; ?>
            </div>
        </div>
            <?php } ?>
    </div>

</div>

