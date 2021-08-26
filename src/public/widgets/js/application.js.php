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
        _.CheckForLoggedInUser();
        _.BindBrowserFunctions();
        _.CheckBrowser();
        _.CheckIpInfo();
        _.ClickToReload();
        _.GetAuthToken();
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

    this.enableSearch = function () {

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

    this.ToggleMenu = function() {
        var menuLeft = document.getElementById('cbp-spmenu-s1');
        var menuLeftback = document.getElementById('cbp-spmenu-s1-back');
        classie.toggle(menuLeft, 'cbp-spmenu-open');
        classie.toggle(menuLeftback, 'cbp-spmenu-s1-back-open');
    };

    this.TextBoxAutoResize = function () {
        $(".auto-resize").each(function () {
            var offset = this.offsetHeight - this.clientHeight;
            var resizeTextarea = function (el) {
                $(el).css('height', 'auto').css('height', el.scrollHeight + offset);
            };
            $(this).on('keyup input', function () { resizeTextarea(this); }).removeClass('auto-resize');
        });
    };

    this.ClickToReload = function()
    {
        $(document).on("click",".click-to-reload", function(e) {
            location.reload();
        });
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

        ajax.SendExternal("https://ipinfo.io/geo/?token=560edb5e009a3d","","get","json",false, function(objResultData) {

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
                ajax.Send("process/sessions/register-visitor-ip-info", objResultData, function (objRegistrationResult) {
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

    this.EditMyAccount = function() {
        location.href = "/account/profile/";
    };

    this.EditMySettings = function() {
        location.href = "/account/settings/";
    };

    this.ToggleMenu = function() {
        var menuLeft = document.getElementById('cbp-spmenu-s1');
        var menuLeftback = document.getElementById('cbp-spmenu-s1-back');
        classie.toggle(menuLeft, 'cbp-spmenu-open');
        classie.toggle(menuLeftback, 'cbp-spmenu-s1-back-open');
    };

    this.RefineVisibleList = function() {
        var strQueryText = $('#customer_list_search').val().toLowerCase();

        if ( strQueryText != "" )
        {
            $('.zgXL-tb-resp .zgXL-li').each(function() {
                var strColumn2Text = $(this).children('.zgXL-xY-2').text().toLowerCase();
                var strColumn3Text = $(this).children('.zgXL-xY-3').text().toLowerCase();
                var strColumn4Text = $(this).children('.zgXL-xY-4').text().toLowerCase();

                if ( !strColumn2Text.includes(strQueryText) && !strColumn3Text.includes(strQueryText) && !strColumn4Text.includes(strQueryText) )
                {
                    $(this).hide();
                }
                else
                {
                    $(this).show();
                }
            });
        }
        else
        {
            $('.zgXL-tb-resp .zgXL-li').show();
        }
    };

    this.Search = function(strUriPath, strElementId, strEntity, arSearchFields, arDisplayModel, objCallBack)
    {
        $(strElementId).autocomplete(
            {
                minLength: 1,
                source: function( req, add ) {
                    let searchQueryClean = $(strElementId).val();

                    let strSearchUri = strUriPath + "?";

                    for(let intSearchIndex in arSearchFields)
                    {
                        strSearchUri += "field[" + arSearchFields[intSearchIndex] + "]=" + encodeURI(searchQueryClean);
                        if ( intSearchIndex < (arSearchFields.length - 1))
                        {
                            strSearchUri += "&";
                        }
                    }

                    console.log(strSearchUri);

                    ajax.Send(strSearchUri, null, function(objSearchResult) {
                        if(objSearchResult.success == false)
                        {
                            return false;
                        }
                        add( $.map( objSearchResult.data[strEntity], function( item ) {

                            let objReturn = {};

                            for(let intSearchIndex in arSearchFields)
                            {
                                objReturn[arSearchFields[intSearchIndex]] = item[arSearchFields[intSearchIndex]];
                            }

                            return objReturn;
                        }));
                    });
                },
                change: function( event, ui ) {
                    if ($(strElementId).val() == "")
                    {
                        $(strElementId + "_id").val("");
                    }
                },
                select: function( event, ui ) {
                    let strItemValue = arDisplayModel[0];
                    let arItemLabel = arDisplayModel[1].split(".");
                    let strItemLabel = "";
                    $(strElementId + "_id").val(ui.item[strItemValue]);
                    for(let intDisplayIndex in arItemLabel)
                    {
                        strItemLabel += ui.item[arItemLabel[intDisplayIndex]] + " ";
                    }
                    strItemLabel = strItemLabel.trim();

                    $(strElementId).val(strItemLabel);

                    if (typeof objCallBack === "function")
                    {
                        objCallBack(ui.item[strItemValue]);
                        return;
                    }

                    return false;
                }
            })
            .autocomplete( "instance" )._renderItem = function( ul, item ) {
            let strItemValue = arDisplayModel[0];
            let arItemLabel = arDisplayModel[1].split(".");
            let strItemLabel = "";
            $(strElementId + "_id").val(item[strItemValue]);
            for(let intDisplayIndex in arItemLabel)
            {
                strItemLabel += item[arItemLabel[intDisplayIndex]] + " ";
            }
            strItemLabel = strItemLabel.trim();

            return $( "<li>" )
                .append( "<div><b>" + strItemLabel + "</b><br>ID: " + item[strItemValue] + "</div>" )
                .appendTo( ul );
        };
    };

    this.GetAuthToken = function()
    {
        const authUrl = "security/get-auth";
        const instance = Cookie.get('instance');
        const user = Cookie.get('user');

        if (user !== 'null' && instance !== 'null' && user !== null && instance !== null) { return; }

        ajax.Send(authUrl, null, function(objResult)
        {
            if (objResult.success === false) { return; }

            Cookie.set('hash', objResult.data.hash)
            Cookie.set('instance', objResult.data.instance)
            Cookie.set('user', objResult.data.authId)

            if (typeof objResult.data.userInfo !== "undefined")
            {
                Cookie.set('userNum', objResult.data.userNum)
                Cookie.set('userInfo', objResult.data.userInfo)
            }
        });
    };

    this.Impersonate = function(user_id)
    {
        let strAuthUrl = "users/impersonate-user?user_id=" + user_id;
        ajax.Send(strAuthUrl, null, function(objResult) {
            if(objResult.success == false)
            {
                console.log(objResult.message);
                return;
            }

            window.location.href = "/account";
        });
    };
}
