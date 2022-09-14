<?php
/**
 * THEME _site_core Extention for zgWeb.Solutions Web.CMS.App
 */

use App\Utilities\Minify\JavaScriptMinifier;
use App\Website\Website;
/** @var Website $this */

$appType = $this->app->objCustomPlatform->getCompanySettings()->FindEntityByValue("label", "application_type")->value ?? "default";

?>
<!DOCTYPE html>
<!--
//============================================================================
// EZ Digital CRM System
// Built on the Excell Web Framework
// Copyright <c> 2019. All rights reserved.
//============================================================================
-->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><?php echo $this->CurrentPage->Meta->Title; ?></title>
    <?php echo $this->strTemplateMeta; ?>
</head>
<?php flush(); ?>
<body id="dashboard" class="loggedInBody app-type-<?php echo $appType; ?> <?php echo $this->RenderBodyClasses(); ?>">
<?php echo $this->strTemplateMobileNav; ?>
<div id="vueApp" class="vueAppWrapper">
    <?php echo $this->strTemplateHeader; ?>
    <div id="content" class="BodyContentOuter">
        <?php echo $this->strPageView; ?>
    </div>
    <?php echo $this->strTemplateFooter; echo PHP_EOL; ?>
</div>
<script type="text/javascript">
    let appCart = null;
<?php
    if ($this->VueApp !== null) { echo $this->VueApp->renderAppJavascript(); }
    ?>
    Vue.component('v-style', {
        render: function (createElement) {
            return createElement('style', this.$slots.default)
        }
    })
</script>
<?php //echo JavaScriptMinifier::minify($this->RenderTemplateScripts()); ?>
<?php echo $this->RenderTemplateScripts(); ?>
</body>
</html>

