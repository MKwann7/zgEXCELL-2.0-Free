<?php

if ($this->app->isUserLoggedIn())
{
    $this->app->executeUrlRedirect(getFullPortalUrl() . "/account");
}

$this->CurrentPage->BodyId = "loginwidget-page";
$this->CurrentPage->BodyClasses       = ["page", "loginwidget-page", "no-columns"];
$this->CurrentPage->Meta->Title       = "Login To Your Account | " . $this->app->objCustomPlatform->getPortalDomainName();
$this->CurrentPage->Meta->Description = "Your digital card is one step away. Login now to manage it!";
$this->CurrentPage->Meta->Keywords    = "Digital Cards, Online Business Cards, Greg Sanders";
$this->CurrentPage->SnipIt->Title     = "Login";
$this->CurrentPage->SnipIt->Excerpt   = "Your digital card is one step away. Login now to manage it!";
$this->CurrentPage->Columns           = 0;

$portalLogo = $this->app->objCustomPlatform->getCompanySettings()->FindEntityByValue("label","website_logo")->value ?? "/website/logos/ez-card-logo-green.svg";
$portalLogoCss = $this->app->objCustomPlatform->getCompanySettings()->FindEntityByValue("label","website_logo_css")->value ?? "";
$portalLogoLink = $this->app->objCustomPlatform->getCompanySettings()->FindEntityByValue("label","website_logo_link")->value ?? "/";

?>
<style type="text/css">
    body > header { display: none; }
    body {
        background: #ccc;
    }
    .wrapper.loggedOutBody {
        display: flex;
        height: 100vh;
        justify-content: center;
        align-content: center;
    }
    .loggedOutBody .content {
        text-align: center;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 0px 85px 0 !important;
    }
    .loginMainfloat {
        width: 550px;
    }
    .public-page footer,
    .loginMainfloat {
        box-shadow: rgba(0, 0, 0, .2) 0 0 10px;
    }
    body .page-title-main {
        width: 100%;
        text-align: center;
    }
    .flex-container {
        width:100%;
        display:flex;
        height:100%;
    }
    .flex-item {
        flex: 1;
    }
    .left-back {
        background: url(/portal/images/login-background-3.jpg) no-repeat center center;
    }
    .loginBlockOuter {
        justify-content: center;
        align-items: center;
        display: flex;
    }
    .loginBlockInner {
        display: flex;
        flex-direction: column;
        max-height: 100vh;
        max-height: -webkit-fill-available;
    }
    .loginBlock {
        width: 500px;
    }
    body .login-field-table, body .login-field-table .login-field-row, body .login-field-table .login-field-row > div {
        display:block;
    }
    body .fieldsetGrouping input:not([type="checkbox"]) {
        float: none;
        clear: both;
    }
    body .siteCrmLogin {
        box-shadow:none !important;
        background: transparent;
        border:0;
        padding:0 !important;
    }
    body .login-button-box {
        text-align:center;
    }
    body .form-submit-buttons {
        background: #5f105a;
        color: #fff;
        border-radius: 5px;
        border: 0;
        width: 50%;
    }
    body .form-submit-buttons:active {
        background: #440f40;
    }
    body .form-submit-buttons:focus {
        background: #2f092d;
    }
    .reset-password-row {
        text-align: right;
    }
    @media (max-width:850px) {
        .content {
            padding: 30px 35px 0;
        }
        .public-page footer {
            position: relative !important;
        }
    }
    @media (max-width: 767px)
    {
        .copyrights {
            margin: 0 0 0 0 !important;
        }
    }
    @media (max-width: 650px)
    {
        .loggedOutBody .content {
            padding: 0 0 0 !important;
        }
        .loginMainfloat {
            width: 100%;
        }
    }
</style>
<div class="wrapper loggedOutBody">
    <div class="flex-container ">
        <div class="flex-item left-back"></div>
        <div class="flex-item loginBlockOuter">
            <div class="loginBlockInner">
                <div class="loginBlock">
                    <a class="login-portal-logo" href="/"><img src="<?php echo $portalLogo; ?>" alt="" width="150"></a>
                    <div class="">
                        <h1 class="page-title-main">Welcome to MaxR</h1>
                        <?php require __DIR__ . "../../../_shared/components/login.form" . XT; ?>
                        <div style="text-align: center;">--- or ----</div>
                        <div>Create Account</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

