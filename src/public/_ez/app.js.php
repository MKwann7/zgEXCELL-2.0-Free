<?php
/**
 * Created by PhpStorm.
 * User: micah.zak
 * Date: 3/11/2019
 * Time: 1:21 PM
 */

header('Content-Type:text/javascript');

require PUBLIC_WEBSITE . "js/application.js.php";
?>

function EZcard()
{
    var _ = this;

    this.load = function ()
    {
        _.BindCardPages();
        _.LazyLoadTabs();
    }

    this.BindCardPages = function ()
    {
        $(document).on("click",".tabTitle",function (objTab) {
            if (!$(this).hasClass("data-loaded")) {
                let self = this;
                let intTabId = $(self).addClass("data-loaded").addClass("tab-open").addClass("ajax-loading-anim-inner").attr("id").replace("tab","");
                let intCardId = $("#card_id").val();
                $(".tab-open:not(#tab" + intTabId + ")").removeClass("tab-open");

                ajax.Get("cards/card-data/get-card-page-data?card_tab_rel_id=" + intTabId + "&card_id=" + intCardId, function(result)
                {
                    $(".tabContent:not(.tab-open)").slideUp(100);
                    try
                    {
                        $(self).removeClass("ajax-loading-anim-inner");
                        $("#content" + intTabId).addClass("tab-open").html(atob(result.data.content)).slideDown(100,function(){
                            let intTabTop = $("#tab" + intTabId).offset().top;
                            $('html,body').animate({scrollTop: intTabTop},500);
                        });
                    }
                    catch(err)
                    {
                        console.log(result);
                        $("#content" + intTabId).html("Error loading Page: " + err).slideDown(100,function(){
                            let intTabTop = $("#tab" + intTabId).offset().top;
                            $('html,body').animate({scrollTop: intTabTop},500);
                        });
                    }
                    return;
                });
            }
            else
            {
                if (!$(this).hasClass("tab-open"))
                {
                    let intTabId = $(this).addClass("tab-open").attr("id").replace("tab","");
                    $(".tab-open:not(#tab" + intTabId + ")").removeClass("tab-open");
                    $(".tabContent:not(.tab-open)").slideUp(100);
                    $("#content" + intTabId).addClass("tab-open").slideDown(100,function(){
                        let intTabTop = $("#tab" + intTabId).offset().top;
                        $('html,body').animate({scrollTop: intTabTop},500);
                    });
                }
                else
                {
                    let intTabId = $(this).removeClass("tab-open").attr("id").replace("tab","");
                    $("#content" + intTabId).slideUp(100).removeClass("tab-open");
                }
            }
        });
    };

    this.LazyLoadTabs = function()
    {
        setTimeout(function() {
                ez.LoadTabs(1);
            }
            ,100);
    };

    this.LoadTabs = function(intCardPage)
    {
        let objCardPage = $(".tabs ul li:nth-child(" + intCardPage + ") div.tabTitle");

        if (objCardPage.length == 0)
        {
            console.log(".tabs ul li:nth-child(" + intCardPage + ") is empty");
            return;
        }

        let intTabId = objCardPage.attr("id").replace("tab","");
        let intCardId = $("#card_id").val();

        if (objCardPage.hasClass("data-loaded"))
        {
            setTimeout(function() {
                    ez.LoadTabs(intCardPage + 1);
                }
                ,50);
            return;
        }

        ajax.Get("cards/card-data/get-card-page-data?card_tab_rel_id=" + intTabId + "&card_id=" + intCardId,function(result)
        {
            objCardPage.removeClass("ajax-loading-anim-inner");
            try
            {
                $("#content" + intTabId).html(atob(result.data.content));
                objCardPage.addClass("data-loaded");
            }
            catch(err)
            {
                console.log(result);
                $("#content" + intTabId).html("Error loading Page: " + err);
            }

            if ($(".tabs ul li:nth-child(" + (intCardPage + 1) + ") div.tabTitle").length > 0)
            {
                setTimeout(function() {
                    ez.LoadTabs(intCardPage + 1);
                }
                ,50);

            }
            return;
        });
    };
}

var ez = new EZcard();

$(document).ready(function ()
{
    ez.load();
});

if (typeof randomIntFromInterval === "undefined")
{
    function randomIntFromInterval(min,max)
    {
        return Math.floor(Math.random()*(max-min+1)+min);
    }
}
