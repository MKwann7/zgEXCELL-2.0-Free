<fieldset class="fieldsetGrouping siteCrmLogin">
    <form id="frmLogin" method="post" action="/process/login/authenticate-login-request" novalidate="novalidate" _lpchecked="1"><input name="__RequestVerificationToken" type="hidden" value="ylLQGWa6w_wFQJQD0AaB5iWCmVk2YmQpKdaD0TeCrHPKJ7QbxKC9SJOH8jevUICVu6UTLLOpsmNyGSKkPVi6ev9HTcQdyI1D6gxuO-lO9X01">
        <input id="browserId"  name="browserId" type="hidden"/>
        <div class="login-field-table">
            <div class="login-field-row">
                <div class="editor-label">
                    <label for="Username">Username</label>
                </div>
                <div class="editor-field">
                    <input data-val="true" data-val-length="The field Username must be a string with a maximum length of 50." data-val-length-max="50" data-val-required="The Username field is required." id="usernameLogin" name="username" type="text" value="" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR4nGP6zwAAAgcBApocMXEAAAAASUVORK5CYII=&quot;); cursor: auto;" class="valid">
                    <span class="field-validation-valid" data-valmsg-for="Username" data-valmsg-replace="true"></span>
                </div>
                <div class="clear"></div>
            </div>
            <div class="login-field-row">
                <div class="editor-label">
                    <label for="Password">Password</label>
                </div>
                <div class="editor-field">
                    <input data-val="true" data-val-length="The field Password must be a string with a maximum length of 50." data-val-length-max="50" data-val-required="The Password field is required." id="passwordLogin" name="password" type="password" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR4nGP6zwAAAgcBApocMXEAAAAASUVORK5CYII=&quot;); cursor: auto;" class="valid">
                    <span class="field-validation-valid" data-valmsg-for="Password" data-valmsg-replace="true"></span>
                </div>
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
                <button type="button" id="loginbtn" value="Log In" class="form-submit-buttons css3button pointer">Log In</button>
            </div>
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
                        Cookie.set('user', objAccountAuthResult.data.user);
                        Cookie.set('userNum', objAccountAuthResult.data.userNum);
                        Cookie.set('userInfo', JSON.stringify(objAccountAuthResult.data.userInfo));

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
</fieldset>
