<?php

namespace Entities\Security\Controllers;

use App\Utilities\Excell\ExcellHttpModel;
use Entities\Security\Classes\Base\SecurityController;
use Entities\Users\Classes\Users;
use Entities\Users\Models\UserModel;
use Entities\Visitors\Classes\VisitorBrowser;
use Entities\Visitors\Models\VisitorBrowserModel;

class IndexController extends SecurityController
{
    public function index(ExcellHttpModel $objData) : bool
    {
        $this->renderReturnJson(true, [], "This is what we got.");
    }

    public function getAuth(ExcellHttpModel $objData) : bool
    {
        $user = $this->app->getActiveLoggedInUser();
        $userId = "visitor";

        if ($user !== null)
        {
            $userId = $user->toArray(["sys_row_id"])["sys_row_id"];
            $userNum = $user->toArray(["user_id"])["user_id"];
            $userInfo = $user->toArray(["first_name","last_name","user_email","user_phone"]);

            $visitorBrowser = new VisitorBrowser();
            $objBrowserCookie = $visitorBrowser->getWhere(["browser_cookie" => $_COOKIE["instance"]])->Data->First();
            $objBrowserCookie->logged_in_at = date("Y-m-d H:i:s");
            $visitorBrowser->update($objBrowserCookie);

            $this->renderReturnJson(
                true,
                [
                    "hash" => md5($this->app->objAppSession["Core"]["Session"]["IpAddress"]),
                    "instance" => $_COOKIE["instance"],
                    "userNum" => $userNum,
                    "userInfo" => $userInfo,
                    "authId" => $userId],
                "Security authentication complete."
            );
        }

        $this->renderReturnJson(
            true,
            [
                "hash" => md5($this->app->objAppSession["Core"]["Session"]["IpAddress"]),
                "instance" => $_COOKIE["instance"],
                "authId" => $userId],
            "Security authentication complete."
        );
    }

    public function authenticateUser(ExcellHttpModel $objData) : bool
    {
        if (!$this->validateRequestType('POST'))
        {
            return false;
        }

        $objParams = $this->app->objHttpRequest->Data->PostData;

        if (!$this->validate($objParams, [
            "browserId" => "required",
            "authId" => "required",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $strBrowserCookie = $objParams->browserId;

        $objNewBrowserCookie = new VisitorBrowserModel();
        $objBrowserCookieResult = (new VisitorBrowser())->getWhere(["browser_cookie" => $strBrowserCookie]);

        if ($objBrowserCookieResult->Result->Count === 0)
        {
            $objNewBrowserCookie->browser_cookie = $strBrowserCookie;
            $objNewBrowserCookie->created_on = date("Y-m-d H:i:s");
            $objBrowserCookieResult = (new VisitorBrowser())->createNew($objNewBrowserCookie);
            $objNewBrowserCookie = $objBrowserCookieResult->Data->First();
        }
        else
        {
            $objNewBrowserCookie = $objBrowserCookieResult->Data->First();
        }

        if (empty($objNewBrowserCookie->logged_in_at))
        {
            $this->renderReturnJson(false, [], "Vistor session active");
        }

        $objUsers = new Users();
        $userResult = $objUsers->getByUuid($objParams->authId);

        if ($userResult->Result->Count === 0)
        {
            $this->renderReturnJson(false, [], "User not found!");
        }

        $user = $userResult->Data->First();

        $loginId = $objUsers->setUserLoginSessionData($user, $this->app->objHttpRequest->Data->PostData->browserId, $this->app);
        $objUsers->setUserLoginCookies($user, $this->app);
        $objUsers->setUserActiveCookies($loginId, $this->app);

        $this->app->setActiveLoggedInUser($user);

        /** @var UserModel $user */
        $arUser = $user->ToPublicArray(["sys_row_id", "first_name", "last_name", "user_email", "user_phone", "user_id"]);

        $arUser["id"] = $arUser["sys_row_id"];
        $arUser["user_phone"] = $user->user_phone_value;
        $arUser["user_email"] = $user->user_email_value;
        unset($arUser["sys_row_id"]);

        $this->renderReturnJson(true, ["user" => $arUser], "Authentication complete.");
    }
}