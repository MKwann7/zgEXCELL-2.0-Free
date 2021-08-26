<?php

if ($this->app->isUserLoggedIn())
{
    $this->app->executeUrlRedirect(getFullPortalUrl() . "/account");
}

$this->CurrentPage->BodyId = "login-page";
$this->CurrentPage->BodyClasses       = ["page", "login-page", "no-columns"];
$this->CurrentPage->Meta->Title       = "Login To Your Account | " . $this->app->objCustomPlatform->getPortalDomain();
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
        height: calc(100vh - 140px);
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
    <div class="content">
        <a class="login-portal-logo" href="/"><img src="<?php echo $portalLogo; ?>" alt="" width="150"></a>
        <div class="loginMainfloat">
            <div class="siteLoginFloat">
                <h1 class="page-title-main">Login</h1>
                <?php require __DIR__ . "../../../_shared/components/login.form" . XT; ?>
            </div>
        </div>
    </div>
</div>

