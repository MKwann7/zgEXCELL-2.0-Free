<?php
/**
 * THEME _site_core Extention for zgWeb.Solutions Web.CMS.App
 */

$cardTitle = "Card";
$portalLogoTitle = $this->app->objCustomPlatform->getPortalName();
$portalLogo = $this->app->objCustomPlatform->getCompanySettings()->portal_logo ?? "/website/images/ezcard_logo-new-full-color.png";

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
                <a class="navbar-brand" href="/" style="<?php echo $cssTweak; ?>"><img src="<?php echo $portalLogo; ?>" alt="" width="64"></a>
            </div>
        </div>
    </nav>
</header>
