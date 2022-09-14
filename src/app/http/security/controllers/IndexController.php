<?php

namespace Http\Security\Controllers;

use App\Utilities\Excell\ExcellCollection;
use App\Utilities\Excell\ExcellHttpModel;
use Entities\Companies\Classes\Departments\Departments;
use Entities\Companies\Classes\Departments\DepartmentTicketQueues;
use Entities\Users\Classes\UserClass;
use Http\Security\Controllers\Base\SecurityController;
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
            $userArray = $user->toArray(["first_name","last_name","user_email","user_phone"]);
            $userArray["Roles"] = $user->Roles->ToPublicArray();
            $userArray["Departments"] = $user->Departments->ToPublicArray();

            $visitorBrowser = new VisitorBrowser();
            $objBrowserCookie = $visitorBrowser->getWhere(["browser_cookie" => $_COOKIE["instance"]])->getData()->first();
            $objBrowserCookie->logged_in_at = date("Y-m-d H:i:s");
            $visitorBrowser->update($objBrowserCookie);

            $this->renderReturnJson(
                true,
                [
                    "hash" => md5($this->app->objAppSession["Core"]["Session"]["IpAddress"]),
                    "instance" => $_COOKIE["instance"],
                    "userNum" => $userNum,
                    "user" => $userArray,
                    "userId" => $userId],
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

        if ($objBrowserCookieResult->result->Count === 0)
        {
            $objNewBrowserCookie->browser_cookie = $strBrowserCookie;
            $objNewBrowserCookie->created_on = date("Y-m-d H:i:s");
            $objBrowserCookieResult = (new VisitorBrowser())->createNew($objNewBrowserCookie);
            $objNewBrowserCookie = $objBrowserCookieResult->getData()->first();
        }
        else
        {
            $objNewBrowserCookie = $objBrowserCookieResult->getData()->first();
        }

        if (empty($objNewBrowserCookie->logged_in_at))
        {
            $this->renderReturnJson(false, [], "Vistor session active");
        }

        $objUsers = new Users();
        $userResult = $objUsers->getByUuid($objParams->authId);

        if ($userResult->result->Count === 0)
        {
            $this->renderReturnJson(false, [], "User not found!");
        }

        $user = $userResult->getData()->first();

        $userClassResult = (new UserClass())->getFks()->getWhere(["user_id" => $user->user_id]);

        if ($userClassResult->result->Success === true && $userClassResult->result->Count > 0)
        {
            $user->AddUnvalidatedValue("Roles", $userClassResult->data);
        }

        $companyDepartmentResult = (new Departments())->getByUserId($user->user_id);
        if ($companyDepartmentResult->result->Success === true && $userClassResult->result->Count > 0)
        {
            $user->AddUnvalidatedValue("Departments", $companyDepartmentResult->data);

            $ticketQueues = new DepartmentTicketQueues();
            $ticketQueueResult = $ticketQueues->getByUserAndDepartmentIds($user->user_id, $user->Departments->FieldsToArray(["company_department_id"]));

            if ($ticketQueueResult->result->Count > 0)
            {
                $user->Departments->Foreach(function($currDepartment) use ($ticketQueueResult)
                {
                    foreach($ticketQueueResult->data as $currTicketQueue)
                    {
                        if ($currTicketQueue->company_department_id === $currDepartment->company_department_id)
                        {

                            if (!is_a($currDepartment->ticketQueue, ExcellCollection::class))
                            {
                                $currDepartment->AddUnvalidatedValue("ticketQueue", new ExcellCollection());
                            }

                            $currDepartment->ticketQueue->Add($currTicketQueue);
                        }
                    }

                    return $currDepartment;
                });

                $user->AddUnvalidatedValue("departmentTicketQueuesCount", $ticketQueueResult->result->Count);
            }
        }

        $loginId = $objUsers->setUserLoginSessionData($user, $this->app->objHttpRequest->Data->PostData->browserId, $this->app);
        $objUsers->setUserLoginCookies($user, $this->app);
        $objUsers->setUserActiveCookies($loginId, $this->app);

        $this->app->setActiveLoggedInUser($user);

        /** @var UserModel $user */
        $arUser = $user->ToPublicArray(["sys_row_id", "first_name", "last_name", "user_email", "user_phone", "user_id","Roles","Departments"]);

        $arUser["id"] = $arUser["sys_row_id"];
        $arUser["user_phone"] = $user->user_phone_value;
        $arUser["user_email"] = $user->user_email_value;
        unset($arUser["sys_row_id"]);

        $this->renderReturnJson(true, ["user" => $arUser], "Authentication complete.");
    }
}