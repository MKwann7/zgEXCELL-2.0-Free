<?php
?>
function AjaxApp()
{
    let _ = this;

    this.Get = function(strUrlQuery, objCallBack, objErrorCallback)
    {
        _.Send(strUrlQuery, null, objCallBack, "get", objErrorCallback);
    }

    this.Post = function(strUrlQuery, strQueryData, objCallBack, objErrorCallback)
    {
        _.Send(strUrlQuery, strQueryData, objCallBack, "post", objErrorCallback);
    }

    this.Send = function(strUrlQuery, strQueryData, objCallBack, strVerb, objErrorCallBack)
    {
        if ( !strVerb ) { strVerb = "POST"; }

        $.ajax({
            url: app.SiteRoot() + strUrlQuery,
            type: strVerb.toUpperCase(),
            dataType: "json",
            beforeSend: function (xhr)
            {
                let strUsername = $("#x").val();
                let strPassword = $("#y").val();
                xhr.setRequestHeader ("Authorization", "Basic " + btoa(strUsername + ":" + strPassword));
                xhr.setRequestHeader ("RequestType", "Ajax");
            },
            data: strQueryData,
            success: function (data)
            {
                if (data.success == false)
                {
                    data.errorType = 'methodlogic';
                    //_.OnAjaxReturnedError(data);

                    if ( typeof objErrorCallBack === 'function' )
                    {
                        objErrorCallBack(data);
                    }
                    else if ( typeof objCallBack === 'function' )
                    {
                        objCallBack(data);
                    }

                    return;
                }
                if ( data.title ) {
                    data.title = atob(data.title);
                }
                if ( data.html ) {
                    data.html = atob(data.html);
                }

                if ( typeof objCallBack === 'function' )
                {
                    objCallBack(data);
                }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                modal.CloseFloatShield();
                let data = {};
                data.errorType = 'methodlogic';
                data.errorMessage = 'There was an AJAX Form Submission Error (' + jqXHR.status + '): ' + errorThrown;

                //_.OnAjaxReturnedError(data);

                if ( typeof objErrorCallBack === 'function' )
                {
                    objErrorCallBack(jqXHR, textStatus, errorThrown);
                }
            }
        });
    }

    this.GetExternal = function(url, security, callback)
    {
        return this.SendExternal(url, "", "GET", "json", security, function(data) {
            callback({success: data.success, response: data})
        });
    }

    this.PostExternal = function(url, data, security, callback)
    {
        return this.SendExternal(url, data, "post", "json", security, callback);
    }

    this.SendExternal = function(strUrl, strData, strType, strDataType, blnSecurity, objCallBack, objErrorCallBack)
    {
        let processData = true;
        let contentType = "application/x-www-form-urlencoded; charset=UTF-8";
        let strVerb = strType;

        if (strType === "form")
        {
            processData = false;
            contentType = false;
            strVerb = "post";
        }

        $.ajax({
            url: strUrl,
            type: strVerb,
            dataType: strDataType.toUpperCase(),
            data: strData,
            processData: processData,
            contentType: contentType,
            beforeSend: function (xhr)
            {
                const username = Cookie.get('user');
                const password = Cookie.get('instance');

                if (blnSecurity && username != "visitor") {
                    xhr.setRequestHeader ("Authorization", "Basic " + btoa(username + ":" + password));
                    xhr.setRequestHeader ("RequestType", "Ajax");
                }
            },
            success: function (objReturnedData)
            {
                if ( typeof objCallBack === 'function' )
                {
                    objCallBack(objReturnedData);
                }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                if (jqXHR.status == 200)
                {
                    return;
                }

                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);

                if ( typeof objErrorCallBack === 'function' )
                {
                    objErrorCallBack(jqXHR, textStatus, errorThrown);
                }
            }
        });
    }

    this.OnAjaxReturnedError = function (data) {
        if (data.success == true) {
            // this function must have been accidentally called
            return;
        }

        console.log(data);

        if ( data.title ) {
            data.title = atob(data.title);
        }
        if ( data.html ) {
            data.html = atob(data.html);
        }


        if (data.errorType.toLowerCase() == "login" && data.redirectToUrl) {
            location.href = data.redirectToUrl;
            return;
        }

        if (data.errorType.toLowerCase() == "businesslogic"||
            data.errorType.toLowerCase() == "methodlogic") {

            if ( data.message ) {
                data.html = data.message;
            }

            if ( !data.title ) {
                data.title = "System Error";
            }

            if (typeof modal !== "undefined")
            {
                modal.DisplayAlert(data);
            }

            if (data.errors)
            {
                for(let errorIndex in data.errors)
                {
                    let data = {};
                    data.html = data.errors[errorIndex];
                    _.AddFloatDialogMessage(data,"error");
                }
            }
            $('.general-dialog-close').show();
            return;
        }
    }
}
