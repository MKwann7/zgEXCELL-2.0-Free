<?php
?>
function ModalApp()
{
    let _ = this;
    this.objAjaxRequestData = {};

    this.EngageFloatShield = function (objCallback)
    {
        let htmlTag = document.querySelectorAll("html")[0];
        htmlTag.classList.add('html-no-scroll');
        let htmlBody = document.querySelectorAll("body")[0];
        let floatShieldNode = createNode("div", [".universal-float-shield"], "<div class=\"vue-float-shield-inner\"></div>");
        appendToNode(htmlBody, floatShieldNode);
        let floatShieldList = document.querySelectorAll(".universal-float-shield");
        let floatShield = floatShieldList[floatShieldList.length - 1];
        floatShield.style.display = "none";

        fadeNodeTo(floatShield, 150, 1, function(node) {
            if (typeof objCallback === 'function') {
                objCallback(floatShield);
            }
        });
    }

    this.getLastFloatShield = function()
    {
        let floatShieldList = document.querySelectorAll(".universal-float-shield:not(.vue-float-shield)");
        if (floatShieldList.length === 0) return null;
        return floatShieldList[floatShieldList.length - 1];
    }

    this.CloseFloatShield = function (objCallback, intTimeout)
    {
        let intTimeOutLength = 0;
        if ( intTimeout ) {
            intTimeOutLength = intTimeout; }
        window.setTimeout(function ()
        {
            let floatShield = _.getLastFloatShield();
            if (floatShield !== null)
            {
                fadeNodeTo(floatShield, 150, 0, function(node) {
                    node.parentNode.removeChild(node);
                    let htmlTag = document.querySelectorAll("html")[0];
                    htmlTag.classList.remove('html-no-scroll');
                    if (typeof objCallback === 'function') {
                        objCallback();
                    }
                });
            }
        }, intTimeOutLength);
    }

    this.EngagePopUpDialog = function (objDialogData, width, height, close, method, active, widget, callback)
    {
        if (!method) {
            method = "default";
        }

        if (!objDialogData.html) {
            objDialogData.html = ""; }

        let intRandDomId = randomIntFromInterval(1000, 9999);
        let closeActionVisibility = "display:none;";
        if (typeof close === 'undefined' || close == null || close == true) {
            closeActionVisibility = 'display:block;';
        }

        let closeAction = '<div style="right:16px;top:16px !important;' + closeActionVisibility + '" id="general-dialog-close" class="general-dialog-close" onclick="modal.CloseFloatShield(null);" title="Close Pop-Up Editor"></div>';;

        let floatShield = _.getLastFloatShield();
        let floatShieldInner = getChildOfNode(floatShield, ".vue-float-shield-inner");

        let dialogBox = createNode("div", [".zgpopup-dialog-box", ("#zgpopup-dialog-box_" + intRandDomId), ("data-popupid=" + method), ("data-width=" + width)], '<div id="zgpopup-dialog-box-inner_' + intRandDomId + '" class="zgpopup-dialog-box-inner" data-popupid="' + method + '_inner" ><div class="zgpopup-dialog-header" data-popupid="' + method + '_header" ><h2 class="offset-slidedown-box pop-up-dialog-main-title"><span class="pop-up-dialog-main-title-text">' + objDialogData.title + '</span>' + closeAction + '</h2></div><div id="zgpopup-dialog-body" class="zgpopup-dialog-body" data-popupid="' + method + '_body"><div class="zgpopup-dialog-body-inner">' + objDialogData.html + '</div><div class="zgpopup-dialog-body-widget"><component ref="refDialogWidgetComponent" :is="dialogWidgetComponent"></component></div></div></div>');
        dialogBox.style.width = width + "px";
        dialogBox.style.position = "relative";
        appendToNode(floatShieldInner, dialogBox)
        if (active) {
            setTimeout(function() {
                floatShield.classList.add("activeModal");
            },200);
        }
        if (typeof widget !== "undefined") {
            const bodyWidget = getChildOfNode(dialogBox, ".zgpopup-dialog-body-widget")
            const bodyWidgetId = "widget_" + intRandDomId;
            bodyWidget.id = bodyWidgetId;
            let vueModalWidget = new Vue({
                el: '#' + bodyWidgetId,
                data() {
                    return {
                        dialogWidgetComponent: null
                    }
                }
            });
            vueModalWidget.dialogWidgetComponent = widget.rawInstance;
            if (typeof callback === "function") {
                callback(dialogBox, widget, vueModalWidget);
            }
        } else {
            if (typeof callback === "function") {
                callback(dialogBox, widget);
            }
        }
    }

    this.EngagePopUpConfirmation = function(objDialogData, fnConfirm, width, height,  method)
    {
        let intRandConfirmId = randomIntFromInterval(100, 999);
        let intRandCancelId = randomIntFromInterval(100, 999);
        objDialogData.html += '<div class="zgpopup-dialog-body-inner-append-fullwidth"><table style="width:100%;margin-top:10px;"><tbody><tr><td><button id="' + intRandConfirmId+'" class="btn btn-primary" style="width: 100%;">Continue</button></td><td style="width:5px;"></td><td><button id="'+intRandCancelId+'" class="btn" style="width: 100%;">Cancel</button></div></td></tr></tbody></table>';
        _.EngagePopUpDialog(objDialogData, width, height, false, method);

        let touchEvent = 'ontouchstart' in window ? 'touchend' : 'click';
        elm(intRandConfirmId).addEventListener(touchEvent, function(event){ fnConfirm(event); });
        elm(intRandCancelId).addEventListener(touchEvent, function(event){ _.CloseFloatShield(null); });
    }

    this.EngagePopUpAlert = function(objDialogData, fnConfirm, width, height,  method)
    {
        let intRandConfirmId = randomIntFromInterval(100, 999);
        let strContinueText = "Continue";

        if (objDialogData.continueText) {
            strContinueText = objDialogData.continueText;
        }

        objDialogData.html += '<div class="zgpopup-dialog-body-inner-append-fullwidth"><table style="width:100%;margin-top:10px;"><tbody><tr><td><button id="'+intRandConfirmId+'" class="btn btn-primary" style="width: 100%;">' + strContinueText +'</button></td></tr></tbody></table>';
        _.EngagePopUpDialog(objDialogData, width, height, false, method);

        let touchEvent = 'ontouchstart' in window ? 'touchend' : 'click';
        elm(intRandConfirmId).addEventListener(touchEvent, function(event){ fnConfirm(event); });
    }

    this.ShowCloseDialogOnLastModal = function()
    {
        let lastFloatShield = _.getLastFloatShield();
        let childInnerElm = getChildOfNode(lastFloatShield, "span.general-dialog-close");
        if(childInnerElm.style.display === "none") childInnerElm.style.removeProperty("display");

        if(childInnerElm.style.opacity !== 1) childInnerElm.style.opacity = 1;
    }

    this.AddFloatDialogMessage = function (objDialogData, strIconType)
    {
        if (typeof objDialogData.title !== "undefined" && objDialogData.title != "") {
            _.SetLastModalElementHtml(".pop-up-dialog-main-title-text", objDialogData.title);
        }

        let blnShowIcon = false;
        let strIconClass = [];

        switch(strIconType)
        {
            case "checkbox":
                strIconClass.push(".zgpopup-dialog-body-inner-checked");
                blnShowIcon = true;
                break;
            case "error":
                strIconClass.push(".zgpopup-dialog-body-inner-error");
                blnShowIcon = true;
                break;
        }

        if (blnShowIcon == true)
        {
            strIconClass.push(".zgpopup-dialog-body-inner-append");
            let appendNode = createNode("div", strIconClass, objDialogData.html);
            _.ApppendLastModalElementHtml(".zgpopup-dialog-body", appendNode);
        }
        else
        {
            let appendNode = createNode("div", [".zgpopup-dialog-body-inner-append-fullwidth"], objDialogData.html);
            _.ApppendLastModalElementHtml(".zgpopup-dialog-body", appendNode);
        }
    }

    this.AssignViewToPopup = function (strViewPath, strViewRequestParameter, objBeforeSubmit, objCallback, objValidate, strContentPrefix, objFormLoad)
    {
        if(strContentPrefix) { $(".zgpopup-dialog-body-inner").html(strContentPrefix);  }

        ajax.Send(strViewPath, strViewRequestParameter, function(objViewResult)
        {
            if (objViewResult.success == false)
            {
                console.log(objViewResult);
                let data = {};
                data.title = "Customer Conversion to V2 Error...";
                data.html = objViewResult.message;
                _.AddFloatDialogMessage(data);
                return false;
            }

            let data = {};
            data.html = atob(objViewResult.data.view);
            $(".zgpopup-dialog-box-inner").last().attr("data-view", strViewPath);
            _.AddFloatDialogMessage(data, false);

            if (typeof objViewResult.action !== "undefined" && objViewResult.action == "login")
            {
                let objPopUpTitle = $(".zgpopup-dialog-box-inner").last().find(".pop-up-dialog-main-title-text");
                objPopUpTitle.attr("data-original",objPopUpTitle.text());
                objPopUpTitle.text("Login To Continue...");
                _.objAjaxRequestData.view = strViewPath;
                _.objAjaxRequestData.parameters = strViewRequestParameter;
                _.objAjaxRequestData.beforeSubmit = objBeforeSubmit;
                _.objAjaxRequestData.formload = objFormLoad;
                _.objAjaxRequestData.callback = objCallback;
                _.objAjaxRequestData.validate = objValidate;
            }

            _.EngagePopUpForms(objCallback, objValidate, objBeforeSubmit, objFormLoad);
        });
    }

    this.ReplaceFloatDialogMessage = function (objDialogData)
    {
        if (typeof objDialogData.title !== undefined && objDialogData.title != "") {
            $(".zgpopup-dialog-box-inner").last().find(".pop-up-dialog-main-title-text").text(objDialogData.title);
        }

        $(".universal-float-shield").last().find(".zgpopup-dialog-body").html(objDialogData.html);
    }

    this.AddFloatDialogCloseButton = function ()
    {
        let closeAction = '<div style="right:16px;top:16px !important;" id="general-dialog-close" class="general-dialog-close" onclick="modal.CloseFloatShield(null);" title="Close Pop-Up Editor"></div>';;
        $(".universal-float-shield").last().find(".pop-up-dialog-main-title").append(closeAction);
    }

    this.EngagePopUpForms = function(objCallback, objValidate, objBeforeSubmit, objFormLoad)
    {
        $(".universal-float-shield").last().find(".zgpopup-dialog-body").find("form").each(function(index, objForm)
        {
            if(!$(objForm).attr("action")) { return; }
            let strFormId = objForm.id;

            app.Form(strFormId, objBeforeSubmit, objCallback, objValidate);
            if (typeof objFormLoad === "function")
            {
                objFormLoad(strFormId);
            }
        });
    };

    this.SetLastModalClass = function(query, className)
    {
        let lastFloatShield = _.getLastFloatShield();
        let childInnerElm = getChildOfNode(lastFloatShield, query);
        childInnerElm.classList.add(className);
    }

    this.RemoveLastModalClass = function(query, className)
    {
        let lastFloatShield = _.getLastFloatShield();
        let childInnerElm = getChildOfNode(lastFloatShield, query);
        childInnerElm.classList.remove(className);
    }

    this.SetLastModalElementHtml = function(query, text)
    {
        let lastFloatShield = _.getLastFloatShield();
        let childInnerElm = getChildOfNode(lastFloatShield, query);
        childInnerElm.innerHTML = text;
    }

    this.ApppendLastModalElementHtml = function(query, node)
    {
        let lastFloatShield = _.getLastFloatShield();
        let childInnerElm = getChildOfNode(lastFloatShield, query);
        appendToNode(childInnerElm, node);
    }

    this.DisplayAlert = function(data)
    {
        _.EngageFloatShield();
        _.EngagePopUpDialog(data,350,150);
    };
}
