<?php

namespace Entities\Emails\Controllers\Api\V1;

use App\Utilities\Excell\ExcellHttpModel;
use Entities\Emails\Classes\Base\EmailController;
use Entities\Emails\Classes\Emails;
use Entities\Users\Classes\Users;

class ApiController extends EmailController
{
    public function sendResetPasswordRequest(ExcellHttpModel $objData) : bool
    {
        if (!$this->validateRequestType('POST'))
        {
            return false;
        }

        $objParams = $objData->Data->Params;

        if (!$this->validate($objParams, [
            "email" => "required|email",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $email = $objParams["email"];

        $objUser = new Users();
        $userResult = $objUser->getByEmail($email);

        if ($userResult->Result->Count === 0)
        {
            return $this->renderReturnJson(false, [], "Completed!");
        }

        $user = $userResult->Data->First();
        $user->password_reset_token = $objUser->generatePasswordResetToken();
        $objUser->update($user);

        // Look up user by email address.
        // Generate Token and Save it somewhere.
        // Send password reset to email.
        $customPlatformName = $this->app->objCustomPlatform->getPortalName();
        $customPlatformUrl = $this->app->objCustomPlatform->getFullPortalDomain();

        (new Emails())->SendEmail(
            $customPlatformName . " Support <noreply@".getPortalUrl().">",
            ["{$user->first_name} {$user->last_name} <{$email}>"],
            "Password Reset For {$user->first_name} {$user->last_name}",
            '<p>A password reset request has made for your account. If you didn\'t request this, please ignore it.</p><p><a href="'.$customPlatformUrl.'/reset-your-password/'.$user->password_reset_token.'" style="display:block;color:#fff;background-color:#0083ff;padding:7px 10px 5px;border-radius:3px;">Click here!</a></p><p>Again, ignore it if you didn\'t request it.</p><p>Thank you,<br>The ' . $customPlatformName . ' App</p>'
        );

        return $this->renderReturnJson(true, [], "Completed!");
    }

    public function send(ExcellHttpModel $objData) : bool
    {
        $email = $objData->Data->PostData->email;
        $subject = $objData->Data->PostData->subject;
        $body = $objData->Data->PostData->body;
        $from = $objData->Data->PostData->from;

        $objUser = new Users();
        $userResult = $objUser->getWhere(["email " => $email]);

        if ($userResult->Result->Count === 1)
        {
            $user = $userResult->Data->First();
            $user->password_reset_token = $objUser->generatePasswordResetToken();
            $objUser->update($user);

            // Look up user by email address.
            // Generate Token and Save it somewhere.
            // Send password reset to email.

            (new Emails())->SendEmail(
                "EZcard Test <test@ezcard.com>",
                ["Micah Zak <micah@zakgraphix.com>"],
                "This is a test",
                "<p>Here is your password reset email.</p><p>Here is the details.</p>"
            );

        }
    }
}