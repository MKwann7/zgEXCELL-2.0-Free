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
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle navbar-toggle-arch" >
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/" style="<?php echo $cssTweak; ?>"><img src="<?php echo $portalLogo; ?>" alt="" width="64"></a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="/">Home</a></li>
                    <li><a href="/purchase" style="background:#ccc;color:#000;border-radius:10px;">Purchase</a></li>
                    <li><a href="/about">About</a></li>
                    <li><a href="/contact-us">Contact Us</a></li>
                    <li><a href="/login">Login</a></li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>
</header>
