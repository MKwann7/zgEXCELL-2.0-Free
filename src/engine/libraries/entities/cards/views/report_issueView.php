<?php
/**
 * Created by PhpStorm.
 * User: Micah.Zak
 * Date: 10/11/2018
 * Time: 9:43 AM
 */

$this->CurrentPage->BodyId            = "report-issue-page";
$this->CurrentPage->BodyClasses       = ["admin-page", "report-issue-page", "two-columns", "left-side-column"];
$this->CurrentPage->Meta->Title       = "Report A Problem | Admin | " . $this->app->objCustomPlatform->getPortalName();
$this->CurrentPage->Meta->Description = "Welcome to the NEW AMAZING WORLD of EZ Digital Cards, where you can create and manage your own cards!";
$this->CurrentPage->Meta->Keywords    = "";
$this->CurrentPage->SnipIt->Title     = "Report A Problem";
$this->CurrentPage->SnipIt->Excerpt   = "Welcome to the NEW AMAZING WORLD of EZ Digital Cards, where you can create and manage your own cards!";
$this->CurrentPage->Columns           = 0;

?>
<div class="breadCrumbs">
    <div class="breadCrumbsInner">
        <a href="/account" class="breadCrumbHomeImageLink">
            <img src="/media/images/home-icon-01_white.png" class="breadCrumbHomeImage" width="15" height="15" />
        </a> &#187;
        <a href="/account" class="breadCrumbHomeImageLink">
            <span class="breadCrumbPage">Home</span>
        </a> &#187;
        <a href="/account/cards" class="breadCrumbHomeImageLink">
            <span class="breadCrumbPage">Cards</span>
        </a> &#187;
        <span class="breadCrumbPage">Report An Issue</span>
    </div>
</div>
<?php $this->RenderPortalComponent("content-left-menu"); ?>
<div class="BodyContentBox">

</div>


