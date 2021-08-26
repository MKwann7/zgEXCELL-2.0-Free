<?php
/**
 * Created by PhpStorm.
 * User: Micah.Zak
 * Date: 10/11/2018
 * Time: 9:43 AM
 */

$this->CurrentPage->BodyId            = "get-new-card-page";
$this->CurrentPage->BodyClasses       = ["admin-page", "get-new-card-page", "two-columns", "left-side-column"];
$this->CurrentPage->Meta->Title       = "Get New Card | " . $this->app->objCustomPlatform->getPortalDomain();
$this->CurrentPage->Meta->Description = "Welcome to the NEW AMAZING WORLD of EZ Digital Cards, where you can create and manage your own cards!";
$this->CurrentPage->Meta->Keywords    = "";
$this->CurrentPage->SnipIt->Title     = "Get New Card";
$this->CurrentPage->SnipIt->Excerpt   = "Welcome to the NEW AMAZING WORLD of EZ Digital Cards, where you can create and manage your own cards!";
$this->CurrentPage->Columns           = 2;

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
        <span class="breadCrumbPage">Get New Card</span>
    </div>
</div>
<?php $this->RenderPortalComponent("content-left-menu"); ?>
<div class="BodyContentBox">
    <div id="app" class="formwrapper">
        <div class="formwrapper-outer">
            <div class="formwrapper-control">
                <div class="fformwrapper-header">
                    <table class="table header-table" style="margin-bottom:0px;">
                        <tbody>
                        <tr>
                            <td>
                                <h3 class="account-page-title">Get A New Card</h3>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="processWorkflow">
                    <div class="width100 entityDetails">
                        <div class="width100">
                            <div class="card-tile-100">
                                <p>To begin, select a template.</p>
                                <div id="auto-generated-services" class="divTable sub-pages-inner sub-page-count-5 sub-page-horizontal auto-generated-thumbnails sub-page-desc sub-page-readmore default-sub-page-theme sub-page-no-llp">                                    <div class="divRow">
                                        <div class="divCell zgSubpage_thumb">
                                            <a class="zgSubpage_thumb_link pointer">
                                                <img class="autoMargin bordered-03 divCell zgSubpage_thumb_image" src="https://ezcard.com/ioffice/uploads/customers/6885/mainImage.jpg?1536949524" width="250" height="250" border="0">
                                            </a>
                                        </div>
                                        <div class="divCell zgSubpage_text">
                                            <h3 style="margin-top:10px;margin-bottom:5px;"><a class="sub-pages-title pointer" ondblclick="" style="display:block;text-decoration:none;">EZcard Default</a></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="application/javascript">

    function getNewCard()
    {
        var _ = this;

        this.load = function ()
        {
            _.registerGetNewScreens();
        }

        this.registerGetNewScreens = function (className)
        {
            $('.process-workflow-tab').on("click",function() {
                if ($(this).hasClass("active")) { return; }
                let strScreenForActivatuion = $(this).data("block");
                dash.processTabDisplay(strScreenForActivatuion);
            });
        }

        this.processTabDisplay = function (strScreenForActivatuion) {

            if (!strTabForActivatuion) { strTabForActivatuion = "template"; }
            $('.entityTab').removeClass("showTab");
            $("[data-tab='" + strTabForActivatuion + "']").addClass("showTab");
            $('.dashboard-tab').removeClass("active");
            $("[data-block='" + strTabForActivatuion + "']").addClass("active");
            sessionStorage.setItem('dashboard-tab', strTabForActivatuion)
        }
    }

    var newCard = new getNewCard();

    $(document).ready(function() {
        newCard.load();
    });

</script>


