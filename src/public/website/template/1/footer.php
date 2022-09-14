<?php
/**
 * THEME _site_core Extention for zgWeb.Solutions Web.CMS.App
 */

switch($this->app->objCustomPlatform->getCompanyId())
{
    case 0:
        $cardTitle = "EZcard";
        $portalLogo = "/website/images/ezcard_logo-new-black.svg";
        $cssTweak = "width: 100px;margin-bottom: 5px;";
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
                    <h6>Copyright <?php echo date("Y"); ?> <?php echo $this->app->objCustomPlatform->getPortalName(); ?><br>All Rights Reserved</h6>
                    <div class="policy-links">
                        <a href="https://docs.google.com/document/d/129fl7NwkkxLYL68L77gEeCjK-fincBtal0Ajwc6KSeI/">Privacy Policy</a> |
                        <a href="https://docs.google.com/document/d/1uQ77ilk_IoYG-n_Dez4Enp4nLWCCy_49jzi5Lj3fliQ/">Privacy Policy</a> |
                        <a href="https://docs.google.com/document/d/1Cm99qnB9YuDsnQQYzUpEHABx0_OaP5S_OFvByMrnEKc/">Support Policy</a> |
                        <a href="https://docs.google.com/document/d/1Cc6Qj2nVz25ZBj8YMzyTicUUjs5GujHiPU1sBvkOx0o/">Customer Privacy</a> |
                        <a href="https://docs.google.com/document/d/1CAi0BVArcZgfS6bhKtfLtrTRM_7QWURg-Kx3RvGrukY/">Cookies Privacy</a>
                    </div>
                </div>
            </div>
            <input id="x" type="hidden" value="<?php echo (isset($this->app->objAppSession["Core"]["Session"]["Authentication"]["username"]) ? $this->app->objAppSession["Core"]["Session"]["Authentication"]["username"] : ""); ?>" />
            <input id="y" type="hidden" value="<?php echo (isset($this->app->objAppSession["Core"]["Session"]["Authentication"]["password"]) ? $this->app->objAppSession["Core"]["Session"]["Authentication"]["password"] : ""); ?>" />
            <input id="ip_info" type="hidden" value="<?php echo (isset($this->app->objAppSession["Core"]["Session"]["IpInfo"]->guid) ? $this->app->objAppSession["Core"]["Session"]["IpInfo"]->guid : ""); ?>" />
            <input id="card_id_legacy" type="hidden" value="<?php echo (isset($this->app->objAppSession["Core"]["Session"]["Card"]["ActiveCard"]) ? $this->app->objAppSession["Core"]["Session"]["Card"]["ActiveCard"] : "0"); ?>" />
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
