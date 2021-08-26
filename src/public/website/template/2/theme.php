<?php
/**
 * THEME _site_core Extention for zgWeb.Solutions Web.CMS.App
 */
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><?php echo $this->CurrentPage->Meta->Title; ?></title>
    <?php if ($this->CurrentPage->Template->ShowMeta) { echo $this->strTemplateMeta; } ?>
</head>
<?php flush(); ?>
<body id="<?php echo $this->CurrentPage->BodyId; ?>" class="public-page <?php echo $this->RenderBodyClasses(); ?>">
<?php if ($this->CurrentPage->Template->ShowMobileNavigation) { echo $this->strTemplateMobileNav; } ?>
<?php if ($this->CurrentPage->Template->ShowHeader) { echo $this->strTemplateHeader; } ?>
<?php if ($this->CurrentPage->Template->ShowPage) { echo $this->strPageView; } ?>
<?php if ($this->CurrentPage->Template->ShowFooter) { echo $this->strTemplateFooter; } echo PHP_EOL; ?>
<?php if ($this->CurrentPage->Template->ShowScripts) { echo $this->RenderTemplateScripts(); } ?>
</body>
</html>