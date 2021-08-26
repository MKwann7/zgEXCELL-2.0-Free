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
        Cookie.set('user', auth.user);
        Cookie.set('userNum', auth.userNum);
        Cookie.set('userInfo', JSON.stringify(auth.userInfo));
    }

    this.clearAuth = function()
    {
        const autoUrl = "process/login/logout";

        vueApp.isLoggedIn = "inactive"
        vueApp.authUserId = null
        if (typeof vueApp.updateAllChildrenAuth === "function") {
            vueApp.updateAllChildrenAuth(vueApp.isLoggedIn, vueApp.authUserId)
        }

        ajax.Send(autoUrl, null,function(objLogoutRequest) {

            Cookie.set('instance', null);
            Cookie.set('user', null);
            Cookie.set('userNum', null);
            Cookie.set('userInfo', null);

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

        if (typeof Cookie.get('user') !== "undefined" && Cookie.get('user') !== "visitor" && (typeof Cookie.get('userNum') === "undefined" || Cookie.get('userNum') === "undefined"))
        {
            preAuthenticate();
        }

        userId = Cookie.get('user')
        userNum = Cookie.get('userNum')
        user = Cookie.get('userInfo')

        vueApp.isLoggedIn = (userId !== "visitor") ? "active" : "inactive"
        vueApp.authUserId = Cookie.get("user")

        propagateAuthentication(vueApp, this.userId, this.userNum, this.user);

        if (typeof vueApp.updateAllChildrenAuth === "function")
        {
            setTimeout( function()
            {
                vueApp.updateAllChildrenAuth(vueApp.isLoggedIn, vueApp.authUserId)
            }, 250)
        }
    }

    const preAuthenticate = function()
    {
        const authUrl = "security/get-auth"

        ajax.Post(authUrl, null, function(objResult)
        {
            if (objResult.success === false) { return; }
            if (typeof objResult.response !== "undefined") { objResult = objResult.response; }

            Cookie.set("hash", objResult.data.hash)
            Cookie.set("instance", objResult.data.instance)
            Cookie.set("user", objResult.data.authId)

            if (typeof objResult.data.userInfo !== "undefined")
            {
                Cookie.set("userNum", objResult.data.userNum)
                Cookie.set("userInfo", objResult.data.userInfo)
            }
        });
    }

    const propagateAuthentication = function(vue)
    {
        if (vue === null || typeof vue.$children === "undefined" || vue.$children.length === 0) return;

        if (typeof vue.vc !== "undefined") { vue.vc.setUserId(userId) }

        for (let componentIndex in vue.$children)
        {
            vue.$children[componentIndex].userId = userId
            vue.$children[componentIndex].userNum = userNum
            vue.$children[componentIndex].user = user
            vue.$children[componentIndex].isLoggedIn = "active";
            vue.$children[componentIndex].authUserId = Cookie.get("user")

            propagateAuthentication(vue.$children[componentIndex]);
        }
    }

    this.clear = function()
    {

    }

    __construct();
}
