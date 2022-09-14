<?php

header('Content-Type:text/javascript');
header('Cache-Control: public, max_age=3600');

?>
function Application()
{
    let _ = this;
    this.objObserver = null;
    this.strBowser = "Other";

    this.load = function () {
        _.BindBrowserFunctions();
        _.CheckBrowser();
        _.CheckIpInfo();
    };

    this.CheckForLoggedInUser = function()
    {
        if (Cookie.get('instance') !== null && Cookie.get('instance') !== "")
        {
            const authUrl = "security/authenticate-user"
            const authData = {browserId: Cookie.get('instance'), authId: Cookie.get('user')}

            ajax.Post(authUrl, authData, function(objResult)
            {
                if (objResult.success === false) { return; }
            });
        }
    }

    this.enableAvatarMenu = function () {
        $(".DialogTransparentShield").show();
        $(".AvatarMenu").show();
    };

    this.enableNotifications = function () {
        $(".DialogTransparentShield").show();
        $(".NotificationModal").show();
    };

    this.disableFloats = function()
    {
        disableNotifications();
        disableSearch();
        disableAvatarMenu();
    }

    const disableNotifications = function () {
        $(".DialogTransparentShield").hide();
        $(".NotificationModal").hide();
    };

    const disableSearch = function () {
        $(".DialogTransparentShield").hide();
        $(".SearchModal").hide();
    };

    const disableAvatarMenu = function () {
        $(".DialogTransparentShield").hide();
        $(".AvatarMenu").hide();
    };

    this.GotoPage = function (url) {
        location.href = _.SiteRoot() + url;
    };

    this.isNumber = function (n) {
        return !isNaN(parseFloat(n)) && isFinite(n);
    };

    this.BindBrowserFunctions = function ()
    {
        document.addEventListener("keydown", function (e) {
            if ((window.navigator.platform.match("Mac") ? e.metaKey : e.ctrlKey) && e.keyCode == 83) {
                e.preventDefault();
                alert(window.location.href.replace(_.SiteRoot(), ""));
            }
        }, false);
    };

    this.Form = function (strDomId, objBeforeSubmit, objCallback, objValidate, objErrorCallBack)
    {
        $('#' + strDomId + ' input[type=submit]').addClass('ajax-submit-button');

        var strFormAction = $('#' + strDomId).attr('action');

        $('#' + strDomId).ajaxForm({

            url: strFormAction,

            dataType: 'json',

            beforeSerialize: function ($form, options) {
                $('.ajax-submit-button').attr('disabled', 'disabled').removeClass('pointer').css('opacity', '.3');
                $(':focus').blur();
            },

            beforeSend: function(xhr) {
                var strUsername = $("#x").val(); var strPassword = $("#y").val();
                //console.log(strUsername);
                //console.log(strPassword);
                xhr.setRequestHeader ("Authorization", "Basic " + btoa(strUsername + ":" + strPassword));
            },

            beforeSubmit: function (arr, $form, options) {
                if (typeof objValidate === 'function') {
                    var objValidation = objValidate(arr, $form, options);
                    if (objValidation === false) {
                        return false;
                    }
                }
                if (typeof objBeforeSubmit === 'function') {
                    var objBeforeSubmitResult = objBeforeSubmit(strDomId);
                    if (objBeforeSubmitResult === false) {
                        return false;
                    }
                }
            },

            uploadProgress: function (event, position, total, percentComplete) {
                if (typeof _.UploadProgress === 'function') {
                    _.UploadProgress(event, position, total, percentComplete);
                }
            },

            success: function (objReturnedData) {
                _.FormSubmit(objReturnedData, strDomId, objCallback, objValidate);
                _.UnlockForm(strDomId);
            },

            error: function (xhr, ajaxOptions, thrownError) {
                try {
                    var objResult = JSON.parse( xhr.responseText);
                }
                catch(e) {
                    console.log('app[form->ID[' + strDomId + ']]::' + xhr.responseText + ': ' + thrownError + ' [' + strFormAction + ']');
                }
                _.UnlockForm(strDomId);

                if (typeof objErrorCallBack === 'function')
                {
                    objErrorCallBack(xhr, ajaxOptions, thrownError);
                }
            }
        });
    };

    this.FormSubmit = function (objReturnedData, strDomId, objCallback, objValidate)
    {
        if (typeof objCallback === 'function')
        {
            objCallback(objReturnedData);
        }

        delete _.UploadProgress;
    };

    this.UnlockForm = function (strDomId)
    {
        if (!strDomId) {
            strDomId = '';
        } else {
            strDomId = '#' + strDomId + ' ';
        }

        $(strDomId + '.ajax-submit-button').removeAttr('disabled').addClass('pointer').css('opacity', '1');
    };

    this.UploadProgress = null;

    this.SiteRoot = function()
    {
        let url = `${window.location.protocol}//${window.location.hostname}`;
        let port = window.location.port;

        if ((port !== '80' || port !== '443') && (port !== ''))
        {
            url += `:${port}`
        }

        return url + "/";
    };

    this.GetIpInfo = function()
    {
        var intCardId = $("#card_id").val();
        var intUserId = $("#user_id").val();

        ajax.GetExternal("https://ipinfo.io/geo/?token=560edb5e009a3d","",false, function(objResultData) {
            objResultData.browser = _.strBowser;

            if ( $("#browser_id").length > 0 )
            {
                objResultData.browser_id = $("#browser_id").val();
            }

            if ( intCardId != 0 )
            {
                objResultData.card_id = intCardId;
                objResultData.user_id = intUserId;
            }

            if ( objResultData.city && objResultData.city != "Mountain View" ) {
                ajax.Get("process/sessions/register-visitor-ip-info", objResultData, function (objRegistrationResult) {
                    //console.log(JSON.stringify(objRegistrationResult));
                    if ($("#ip_info").val() === "") {

                        $("#ip_info").val(objRegistrationResult.guid)
                    }
                }, "POST");
            }
        });
    };

    this.CheckBrowser = function()
    {
        // Is Opera
        if ((!!window.opr && !!opr.addons) || !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0)
        {
            _.strBowser = "Opera";
        }
        // Firefox 1.0+
        else if (typeof InstallTrigger !== 'undefined')
        {
            _.strBowser = "Firefox";
        }
        // Safari 3.0+ "[object HTMLElementConstructor]"
        else if (/constructor/i.test(window.HTMLElement) || (function (p) { return p.toString() === "[object SafariRemoteNotification]"; })(!window['safari'] || (typeof safari !== 'undefined' && safari.pushNotification)))
        {
            _.strBowser = "Safari";
        }
        // Internet Explorer 6-11
        else if (/*@cc_on!@*/false || !!document.documentMode)
        {
            _.strBowser = "IE";
        }
        // Edge 20+
        else if (typeof isIE === "undefined" && !!window.StyleMedia)
        {
            _.strBowser = "Edge";
        }
        // Chrome 1 - 71
        else if (!!window.chrome && (!!window.chrome.webstore || !!window.chrome.runtime))
        {
            _.strBowser = "Chrome";
        }
        // Blink engine detection
        else if (typeof isChrome !== "undefined" && (isChrome || isOpera) && !!window.CSS)
        {
            _.strBowser = "Blink";
        }
    };

    this.CheckIpInfo = function()
    {
        if ( $("#ip_info").length == 0) {
            return;
        }

        var intCardId = $("#card_id").val();
        var intCardIdLegacy = $("#card_id_legacy").val();
        if ( $("#ip_info").val() === "" || ( intCardId != intCardIdLegacy && intCardId != 0 ) ) {
            _.GetIpInfo();
        }
    };

    this.Logout = function () {
        vueApplication.logout()
    };

    this.GetAuthToken = function()
    {
        const authUrl = "security/get-auth";
        const instance = Cookie.get('instance');
        const user = Cookie.get('user');

        if (user !== 'null' && instance !== 'null' && user !== null && instance !== null) { return; }

        ajax.Post(authUrl, null, function(objResult)
        {
            if (objResult.success === false) { return; }

            Cookie.set('hash', objResult.data.hash)
            Cookie.set('instance', objResult.data.instance)
            Cookie.set('userId', objResult.data.userId)

            if (typeof objResult.data.userInfo !== "undefined")
            {
                Cookie.set('userNum', objResult.data.userNum)
                Cookie.set('user', JSON.stringify(objResult.data.user))
            }
        });
    };

    this.Impersonate = function(user_id)
    {
        let strAuthUrl = "users/impersonate-user?user_id=" + user_id;
        ajax.Post(strAuthUrl, null, function(objResult) {
            if(objResult.success == false)
            {
                console.log(objResult.message);
                return;
            }

            window.location.href = "/account";
        });
    };
}
