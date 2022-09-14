<?php
/**
 * THEME _site_core Extention for zgWeb.Solutions Web.CMS.App
 */

$cardTitle = "Card";
$portalLogoTitle = $this->app->objCustomPlatform->getPortalName();

$portalLogo = $this->app->objCustomPlatform->getCompanySettings()->FindEntityByValue("label","website_logo")->value ?? "/website/logos/ez-card-logo-green.svg";
$portalLogoCss = $this->app->objCustomPlatform->getCompanySettings()->FindEntityByValue("label","website_logo_css")->value ?? "";
$portalLogoLink = $this->app->objCustomPlatform->getCompanySettings()->FindEntityByValue("label","website_logo_link")->value ?? "/";

switch($this->app->objCustomPlatform->getCompanyId())
{
    case 0:
        $cardTitle = "EZcard";
        $portalLogoTitle = $cardTitle;
        break;
    case 2:
        $cssTweak = "top:-2px;position:relative;";
        break;
}

?>
<header>
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="<?php echo $portalLogoLink; ?>" style="<?php echo $cssTweak; ?>"><img src="<?php echo $portalLogo; ?>" alt="" width="64" style="<?php echo $portalLogoCss; ?>"></a>
            </div>
        </div>
    </nav>
</header>
