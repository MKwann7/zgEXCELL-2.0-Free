<?php
    $portalThemeMainColor = $this->app->objCustomPlatform->getCompanySettings()->FindEntityByValue("label","portal_theme_main_color")->value ?? "006666";
    $portalThemeMainColorLight = $this->app->objCustomPlatform->getCompanySettings()->FindEntityByValue("label","portal_theme_main_color_light")->value ?? "009c9c";
?>
<fieldset class="siteCrmLogin">
    <style>
        #frmLogin input.form-control {
            padding-left: 42px;
            width: 100%;
        }
        #frmLogin .form-input-row {
            position: relative;
            margin-bottom: 15px;
        }
        #frmLogin .form-input-row > .fa {
            position: absolute;
            top: 16px;
            left: 16px;
            color:#ccc;
        }
        #frmLogin .form-input-row > .form-control::placeholder {
            color:#777;
        }
        .loginMainfloat .page-title-main {
            text-align: center;
            width:100%;
            margin-top: 0;
        }
        .loginMainfloat .siteCrmLogin {
            box-shadow: none;
            border: 0;
            padding: 0 !important;
        }
        body {
            background: #ccc;
        }
        .siteLoginFloat {
            background: #fff;
            box-shadow: rgba(0,0,0,.2) 0 0 10px;
        }
        .form-submit-buttons {
            background-color: #<?php echo $portalThemeMainColor; ?>;
            border-color: #<?php echo $portalThemeMainColor; ?>;
        }
        .form-submit-buttons:hover {
            background-color: #<?php echo $portalThemeMainColorLight; ?>;
            border-color: #<?php echo $portalThemeMainColorLight; ?>;
        }
        @media (max-width: 650px)
        {
            .loginMainfloat {
                margin-top: 20px;
            }
            .login-portal-logo img {
                width: 125px;
                margin-top: -10px;
            }
            .siteLoginFloat {
                margin: 0 0;
            }
        }
     </style>
    <form id="frmLogin" method="post" action="/process/login/authenticate-login-request">
        <input id="browserId"  name="browserId" type="hidden"/>
        <div class="width100">
            <div class="width100 form-input-row">
                <span class="fa fa-user"></span>
                <input placeholder="Username" class="form-control input-lg" type="text" name="username">
            </div>
            <div class="width100 form-input-row ">
                <span class="fa fa-lock"></span>
                <input placeholder="Password" class="form-control input-lg" type="password" name="password">
            </div>
            <div class="login-field-row">
                <div class="editor-label">
                </div>
                <div class="editor-field">
                    <a class="small-capitalized-text reset-password-dialog pointer">Forgot Your Password?</a>
                </div>
            </div>
        </div>
        <div class="clear editor-label login-button-box">
            <button type="button" id="loginbtn" value="Log In" class="form-submit-buttons btn btn-primary">Log In</button>
        </div>
    </form>
    <script type="application/javascript">

        if (typeof Login !== "function")
        {
            function Login()
            {
                let _ = this;

                this.load = function () {
                    _.EngageLoginForm();
                    _.EngagePasswordReset();
                }

                this.EngageLoginForm = function () {
                    app.Form('frmLogin', null, function (objAccountAuthResult)
                    {
                        if (objAccountAuthResult.success == false)
                        {
                            let data = {};
                            data.title = "EZcard Login Error...";
                            data.html = objAccountAuthResult.message;
                            modal.AddFloatDialogMessage(data, "error");

                            data.html = '<input class="btn btn-primary width100" onclick="login.ResetPasswordModal();" style="margin-top:15px;" value="Reset Your Password?"/>';
                            modal.AddFloatDialogMessage(data);
                            modal.AddFloatDialogCloseButton();
                            $(".universal-float-shield").last().find(".zgpopup-dialog-box-inner").removeClass("dialog-right-loading-anim");

                            return false;
                        }

                        $(".universal-float-shield").last().find(".zgpopup-dialog-box-inner").removeClass("dialog-right-loading-anim");
                        $(".universal-float-shield").last().find("span.pop-up-dialog-main-title-text").html("Success!");

                        let data = {};
                        data.html = "You're authenticated! We're entering the portal...";
                        modal.AddFloatDialogMessage(data, "checkbox");

                        Cookie.set('instance', objAccountAuthResult.data.instance);
                        Cookie.set('user', JSON.stringify(objAccountAuthResult.data.user);
                        Cookie.set('userNum', objAccountAuthResult.data.userNum);
                        Cookie.set('userId', objAccountAuthResult.data.userId);

                        <?php if (empty($blnDoNotRedirect)) { ?>
                        window.location.href = objAccountAuthResult.url;
                        <?php } else { ?>
                        modal.CloseFloatShield(function()
                        {
                            let objPopUpTitle = $(".zgpopup-dialog-box-inner").last().find(".pop-up-dialog-main-title-text");
                            objPopUpTitle.text(objPopUpTitle.attr("data-original"));
                            $(".universal-float-shield").last().find(".zgpopup-dialog-box-inner").removeClass("dialog-right-loading-anim");
                            $(".zgpopup-dialog-box-inner").last().find(".zgpopup-dialog-body-inner-append-fullwidth").remove();

                            modal.AssignViewToPopup(
                                modal.objAjaxRequestData.view,
                                modal.objAjaxRequestData.parameters,
                                modal.objAjaxRequestData.beforeSubmit,
                                modal.objAjaxRequestData.callback,
                                modal.objAjaxRequestData.formLoad,
                                modal.objAjaxRequestData.validate
                            );
                        },500);
                        <?php } ?>
                    });

                    $('#frmLogin input').bind("keypress.key13", function(event) {
                        let objLoginForm = $('#frmLogin');
                        let eventKey = event.charCode || event.keyCode;
                        if (eventKey == 13) {
                            if (objLoginForm.hasClass("confirmed_click")) { return false; }
                            objLoginForm.addClass("confirmed_click");
                            objLoginForm.unbind("keypress.key13");
                            objLoginForm.removeClass("confirmed_click");
                            $("#loginbtn").click();
                        }
                    });

                    $("#loginbtn").on("click",function() {
                        modal.EngageFloatShield();
                        let data = {};
                        data.title = "Logging In...";
                        data.html = "We are logging you in.<br>Please wait a moment.";
                        modal.EngagePopUpDialog(data, 350, 115, false);
                        $(".zgpopup-dialog-box-inner").addClass("dialog-right-loading-anim");
                        document.getElementById("browserId").value = Cookie.get("me");
                        setTimeout(function() {
                            $('#frmLogin').submit();
                        },1000);
                    });
                }

                this.EngagePasswordReset = function()
                {
                    $(document).on("click",".reset-password-dialog", function() {
                        login.ResetPasswordModal();
                    });
                }

                this.ResetPasswordModal = function ()
                {
                    modal.EngageFloatShield();
                    let data = {};
                    data.title = "Reset My Password";
                    data.html = 'Need to reset your password?<br>We can take care of that for you.<br><div class="fieldsetGrouping login-field-table" style="margin-top:10px;"><div class="login-field-row"><div class="editor-label"><label for="Email">Email</label></div><div class="editor-field"><input id="email-for-password-reset" /></div></div></div></div><br><input class="btn btn-primary width100" onclick="login.SendResetPassword();" style="margin-top:10px;" value="Send Me an Email to Reset My Password"/>';
                    modal.EngagePopUpDialog(data, 450, 215, true);
                }

                this.SendResetPassword = function()
                {
                    let strResetRequestEmail = $("#email-for-password-reset").val();
                    modal.EngageFloatShield();
                    ajax.Send("api/v1/emails/send-reset-password-request?email=" + encodeURI(strResetRequestEmail), null, function(objResult) {
                        window.setTimeout(function () {
                            let data = {};
                            data.title = "Password Request Success!";
                            data.html = "<p><b>Check your email!</b></p><p>If we found a matching email address in our database, you'll have a password reset email waiting for you.</p>";
                            data.continueText = "Ok!";
                            modal.EngagePopUpAlert(data, function () {
                                modal.CloseFloatShield(function () {
                                    modal.CloseFloatShield();
                                });
                            }, 400, 115);
                        }, 1000);
                    });
                }
            }
        }


        if(typeof login == "undefined")
        {
            login = new Login();
        }

        $(document).ready(function () {
            login.load();
        });
    </script>
    <?php //dump($this->app->objAppSession["Core"]["Session"]["Browser"]); ?>
</fieldset>
