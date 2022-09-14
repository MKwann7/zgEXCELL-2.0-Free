<?php

if ($this->app->isUserLoggedIn())
{
    $this->app->executeUrlRedirect(getFullPortalUrl() . "/account");
}

$this->CurrentPage->BodyId = "login-page";
$this->CurrentPage->BodyClasses       = ["page", "login-page", "no-columns"];
$this->CurrentPage->Meta->Title       = "Login To Your Account | " . $this->app->objCustomPlatform->getPortalDomainName();
$this->CurrentPage->Meta->Description = "Your digital card is one step away. Login now to manage it!";
$this->CurrentPage->Meta->Keywords    = "Digital Cards, Online Business Cards, Greg Sanders";
$this->CurrentPage->SnipIt->Title     = "Login";
$this->CurrentPage->SnipIt->Excerpt   = "Your digital card is one step away. Login now to manage it!";
$this->CurrentPage->Columns           = 0;

?>
<div class="wrapper loggedOutBody">
    <div class="content">
        <div class="loginMainfloat">
            <div class="aboutUsSectionTitleText" style="color:#000;margin-bottom: 12px; text-align: center;">
                Login to your account
            </div>
            <div class="siteLoginFloat">
                <?php require __DIR__ . "../../../_shared/components/login.form" . XT; ?>
            </div>
        </div>
    </div>
</div>

