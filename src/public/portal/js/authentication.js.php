<?php
?>

const ExcellAuthentication = function(vue)
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

    this.clearAuth = function()
    {
        const autoUrl = "process/login/logout";

        vueApp.isLoggedIn = "inactive"
        vueApp.authUserId = null
        if (typeof vueApp.updateAllChildrenAuth === "function") {
            vueApp.updateAllChildrenAuth(vueApp.isLoggedIn, vueApp.authUserId, null, null, null)
        }

        ajax.Post(autoUrl, null,function(objLogoutRequest) {

            Cookie.set('instance', null);
            Cookie.set('user', null);
            Cookie.set('userNum', null);
            Cookie.set('userId', null);

            if (typeof objLogoutRequest.redirect === "undefined")
            {
                location.href = "/login";
                return;
            }

            location.href = objLogoutRequest.redirect;
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
            preAuthenticate(this.authenticate);
            return;
        }

        this.authenticate()
    }

    this.authenticate = function()
    {
        userId = Cookie.get('userId')
        userNum = Cookie.get('userNum')
        user = Cookie.get('user')

        vueApp.isLoggedIn = (userId !== "visitor") ? "active" : "inactive"
        vueApp.authUserId = Cookie.get("userId")

        propagateAuthentication(vueApp, this.userId, this.userNum, this.user);

        if (typeof vueApp.updateAllChildrenAuth === "function") {
            vueApp.updateAllChildrenAuth(vueApp.isLoggedIn, vueApp.authUserId, userId, userNum, JSON.parse(user))
        }
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

            callback();
        });
    }

    const propagateAuthentication = function(vue)
    {
        const userData = {
            userId: userId,
            userNum: userNum,
            user: typeof user === "string" ? user : JSON.stringify(user),
            isLoggedIn: "active",
            authUserId: Cookie.get("userId")
        }

        dispatch.broadcast("user_auth", userData)
    }

    this.clear = function()
    {

    }

    __construct();
}