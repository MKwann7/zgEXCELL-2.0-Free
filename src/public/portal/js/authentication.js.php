<?php
?>

function ExcellAuthentication(vue)
{
    const self = this;
    const vueApp = vue;
    let userId = null;
    let userNum = null;
    let user = null;

    const __construct = function()
    {

    }


    this.registerAuth = function(auth)
    {
        Cookie.set('instance', auth.instance);
        Cookie.set('user', JSON.stringify(auth.user));
        Cookie.set('userNum', auth.userNum);
        Cookie.set('userId', auth.userId);
    }

    this.clearAuth = function(noRedirect)
    {
        const autoUrl = "process/login/logout";

        vueApp.isLoggedIn = "inactive"
        vueApp.authUserId = null
        if (typeof vueApp.updateAllChildrenAuth === "function") {
            vueApp.updateAllChildrenAuth(vueApp.isLoggedIn, vueApp.authUserId, null, null, null)
        }

        ajax.Post(autoUrl, null,function(objLogoutRequest) {

            //Cookie.set('instance', '');
            Cookie.set('user', "visitor");
            Cookie.set('userNum', '');
            Cookie.set('userId', '');
            Cookie.set('username', '');
            Cookie.set('activeLogin', '');

            if (typeof noRedirect === "undefined") {
                if (typeof objLogoutRequest.redirect === "undefined") {
                    location.href = "/login";
                    return;
                }
                location.href = objLogoutRequest.redirect;
            } else {
                propagateClearAuth()
            }
            return;

        },"POST");
    }

    this.validate = function()
    {
        if (Cookie.get('instance') === null || Cookie.get('instance') === "") {
            setTimeout(function() {
                self.validate()
            }, 100);
            return;
        }

        if (Cookie.get('user') === null) Cookie.set('user', "visitor")

        if (typeof Cookie.get('user') !== "undefined" && Cookie.get('user') !== "visitor" && (typeof Cookie.get('userNum') === "undefined" || Cookie.get('userNum') === "undefined" || Cookie.get('user') === "[object Object]"))
        {
            preAuthenticate(self.authenticate);
            return;
        }

        self.authenticate()
    }

    this.authenticate = function()
    {
        userId = Cookie.get('userId')
        userNum = Cookie.get('userNum')
        user = Cookie.get('user')

        vueApp.isLoggedIn = "inactive"
        vueApp.authUserId = Cookie.get("userId")

        propagateAuthentication();
    }

    const preAuthenticate = function(callback)
    {
        const authUrl = "security/get-auth"

        ajax.Post(authUrl, null, function(objResult)
        {
            if (objResult.success === false) { return; }
            if (typeof objResult.response !== "undefined") { objResult = objResult.response; }

            Cookie.set("hash", objResult.data.hash)
            Cookie.set("instance", objResult.data.instance)
            Cookie.set("userId", objResult.data.userId)

            if (typeof objResult.data.user !== "undefined")
            {
                Cookie.set("userNum", objResult.data.userNum)

                try {
                    Cookie.set("user", JSON.stringify(objResult.data.user))
                } catch(e) {
                    console.log(e);
                }
            }
            if (typeof callback === "function") callback();
        });
    }

    const propagateAuthentication = function()
    {
        const userData = {
            userId: userId,
            userNum: userNum,
            user: typeof user === "string" ? user : JSON.stringify(user),
            isLoggedIn: user !== "visitor" ? "active" : "inactive",
            authUserId: Cookie.get("userId")
        }

        dispatch.broadcast("user_auth", userData)
    }

    const propagateClearAuth = function()
    {
        const userData = {
            userId: "",
            userNum: "",
            user: "visitor",
            isLoggedIn: "inactive",
            authUserId: ""
        }

        dispatch.broadcast("user_auth", userData)
    }

    this.clear = function()
    {

    }

    __construct();
}