<?php

header('Content-Type:text/javascript');
header('Cache-Control: public, max_age=3600');

?>

function dashboardNavigation()
{
    var _ = this;

    this.load = function ()
    {
        _.loadDashboardTabs();
    }

    this.expand = function (className)
    {
        if ($("." + className).is(":visible"))
        {
            $("." + className).slideUp("fast");
        }
        else
        {
            $("." + className).slideDown("fast");
        }
    }

    this.closeall = function (className)
    {
        $(".NavigationModule ul").slideUp("fast");
    }

    this.loadDashboardTabs = function()
    {
        $('.dashboard-tab').on("click",function() {
            if ($(this).hasClass("active")) { return; }
            let strTabForActivatuion = $(this).data("block");
            dash.processTabDisplay(strTabForActivatuion);
        });
    }

    this.processTabDisplay = function (strTabForActivatuion) {

        if (!strTabForActivatuion) { strTabForActivatuion = "profile"; }

        let blnTabIdentified = false;
        $('.dashboard-tab').each(function(index, tab) {
            if ($(this).attr("data-block") == strTabForActivatuion)
            {
                blnTabIdentified = true;
            }
        });

        if (blnTabIdentified == false)
        {
            strTabForActivatuion = "profile";
        }

        $('.entityTab').removeClass("showTab");
        $("[data-tab='" + strTabForActivatuion + "']").addClass("showTab");
        $('.dashboard-tab').removeClass("active");
        $("[data-block='" + strTabForActivatuion + "']").addClass("active");
        sessionStorage.setItem('dashboard-tab', strTabForActivatuion)
    }

    this.goBackToEntityList = function (strTargetUrl) {
        let objPageEntrace = $("#entity-page-entrance");
        var stateObj = { foo: "bar" };

        $(".formwrapper-outer .formwrapper-control").css("opacity", 1).show();

        switch(objPageEntrace.attr("data-source"))
        {
            case "edit-entity":
                history.pushState(stateObj, "View Card", strTargetUrl);
                $(".formwrapper-outer").removeClass("edit-entity");
                $(".breadCrumbsInner").removeClass("edit-entity");
                break;
            default:
                history.go(-1);
                $(".formwrapper-outer").removeClass("edit-entity");
                $(".breadCrumbsInner").removeClass("edit-entity");
                break;
        }
    }
}

var dash = new dashboardNavigation();

function mobileNavigation()
{
    var _ = this;

    this.load = function ()
    {
        _.loadMobileTabs();
    }

    this.expand = function (className)
    {
        if ($("." + className).is(":visible"))
        {
            $("." + className).slideUp("fast");
        }
        else
        {
            $("." + className).slideDown("fast");
        }
    }

    this.closeall = function (className)
    {
        $(".MobileNavModule ul").slideUp("fast");
    }

    this.loadMobileTabs = function()
    {
        $('.dashboard-tab').on("click",function() {
            if ($(this).hasClass("active")) { return; }
            let strTabForActivatuion = $(this).data("block");
            dash.processTabDisplay(strTabForActivatuion);
        });
    }

    this.processTabDisplay = function (strTabForActivatuion) {

        if (!strTabForActivatuion) { strTabForActivatuion = "profile"; }

        let blnTabIdentified = false;
        $('.dashboard-tab').each(function(index, tab) {
            if ($(this).attr("data-block") == strTabForActivatuion)
            {
                blnTabIdentified = true;
            }
        });

        if (blnTabIdentified == false)
        {
            strTabForActivatuion = "profile";
        }

        $('.entityTab').removeClass("showTab");
        $("[data-tab='" + strTabForActivatuion + "']").addClass("showTab");
        $('.dashboard-tab').removeClass("active");
        $("[data-block='" + strTabForActivatuion + "']").addClass("active");
        sessionStorage.setItem('dashboard-tab', strTabForActivatuion)
    }

    this.goBackToEntityList = function (strTargetUrl) {
        let objPageEntrace = $("#entity-page-entrance");
        var stateObj = { foo: "bar" };

        console.log(strTargetUrl);

        $(".formwrapper-outer .formwrapper-control").css("opacity", 1).show();

        switch(objPageEntrace.attr("data-source"))
        {
            case "edit-entity":
                history.pushState(stateObj, "View Card", strTargetUrl);
                $(".formwrapper-outer").removeClass("edit-entity");
                $(".breadCrumbsInner").removeClass("edit-entity");
                break;
            default:
                history.go(-1);
                $(".formwrapper-outer").removeClass("edit-entity");
                $(".breadCrumbsInner").removeClass("edit-entity");
                break;
        }
    }
}

var mobileNav = new mobileNavigation();

$(document).ready(function() {
    mobileNav.load();
    dash.load();
});

<?php require(PUBLIC_PORTAL . "js/general.js" . XT); ?>

<?php require(PUBLIC_PORTAL . "js/dispatch.js" . XT); ?>

<?php require(PUBLIC_PORTAL . "js/componentRepo.js" . XT); ?>

<?php require(PUBLIC_PORTAL . "js/authentication.js" . XT); ?>

<?php require(PUBLIC_PORTAL . "js/history.js" . XT); ?>

<?php require(PUBLIC_PORTAL . "js/vueComponent.js" . XT); ?>

<?php require(PUBLIC_PORTAL . "js/cart.js" . XT); ?>

<?php require(PUBLIC_WEBSITE . "js/archmenu/arch.menu.js" . XT); ?>

<?php require(PUBLIC_PORTAL . "js/menu.js" . XT); ?>
