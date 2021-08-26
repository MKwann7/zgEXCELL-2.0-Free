<?php
/**
 * THEME _site_core Extention for zgWeb.Solutions Web.CMS.App
 */

switch($this->app->objCustomPlatform->getCompanyId())
{
    case 0:
        $cardTitle = "EZcard";
        $portalLogo = "/website/images/ezcard_logo-new-black.svg";
        $cssTweak = "width: 100px;margin-bottom: 30px;";
        $portalLogoTitle = $cardTitle;
        break;
    case 2:
        $portalLogo = "/website/logos/espace-75-full-color-logo.png";
        $cssTweak = "width: 100px;margin-bottom: 30px;top:12px;position:relative;";
        break;
}

?>
<footer>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
            </div>
            <div class="col-sm-6">
                <div class="copyrights" style="margin-bottom:15px;">
                    <img src="<?php echo $portalLogo; ?>" style="<?php echo $cssTweak; ?>"/>
                    <h6>Copyright <?php echo date("Y"); ?> <?php echo $this->app->objCustomPlatform->getPortalName(); ?> - All Rights Reserved</h6>
                    <div class="policy-links">
                        <a href="">Privacy Policy</a> |
                        <a href="">Privacy Policy</a> |
                        <a href="">Support Policy</a> |
                        <a href="">Customer Privacy</a> |
                        <a href="">Cookies Privacy</a>
                    </div>
                </div>
            </div>
            <input id="x" type="hidden" value="<?php echo (isset($this->app->objAppSession["Core"]["Session"]["Authentication"]["username"]) ? $this->app->objAppSession["Core"]["Session"]["Authentication"]["username"] : ""); ?>" />
            <input id="y" type="hidden" value="<?php echo (isset($this->app->objAppSession["Core"]["Session"]["Authentication"]["password"]) ? $this->app->objAppSession["Core"]["Session"]["Authentication"]["password"] : ""); ?>" />
            <input id="ip_info" type="hidden" value="<?php echo (isset($this->app->objAppSession["Core"]["Session"]["IpInfo"]->guid) ? $this->app->objAppSession["Core"]["Session"]["IpInfo"]->guid : ""); ?>" />
            <input id="card_id" type="hidden" value="0" />
            <input id="user_id" type="hidden" value="0" />
            <input id="browser_id" type="hidden" value="<?php echo (isset($this->app->objAppSession["Core"]["Session"]["Browser"]) ? $this->app->objAppSession["Core"]["Session"]["Browser"] : ""); ?>" />
            <div class="col-sm-3">
                <div class="copyrights fda pull-right">
                    <a href="#">&nbsp;</a>
                </div>
            </div>
            <?php //print_r($_SESSION["session"]["card"]); ?>
        </div>
    </div>
</footer>
