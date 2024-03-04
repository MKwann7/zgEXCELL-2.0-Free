<?php

namespace Http\Users\Controllers\Api\V1;

use App\Utilities\Database;
use App\Utilities\Excell\ExcellCollection;
use App\Utilities\Excell\ExcellHttpModel;
use App\Utilities\Transaction\ExcellTransaction;
use Entities\Activities\Classes\UserLogs;
use Entities\Cards\Classes\Cards;
use Entities\Cards\Models\CardModel;
use Entities\Cart\Classes\CartEmails;
use Entities\Cart\Classes\CartProcess;
use Entities\Cart\Classes\CartTicketProcess;
use Entities\Cart\Classes\Factories\CartPurchaseFactory;
use Entities\Emails\Classes\Emails;
use Entities\Products\Classes\ProductProcessor;
use Entities\Users\Classes\Factories\PersonaFactory;
use Entities\Users\Classes\Factories\UserFactory;
use Http\Users\Controllers\Base\UserController;
use Entities\Users\Classes\Connections;
use Entities\Users\Classes\ConnectionTypes;
use Entities\Users\Classes\UserClass;
use Entities\Users\Classes\Users;
use Entities\Users\Integrations\Models\UsersIntegrationModel;
use Entities\Users\Integrations\UsersIntegrations;
use Entities\Users\Models\ConnectionModel;
use Entities\Users\Models\UserModel;
use http\Params;

class ApiController extends UserController
{
    public function getUserByUuid(ExcellHttpModel $objData): bool
    {
        //        if (!$this->validateAuthentication($objData))
        //        {
        //            return $this->renderReturnJson(false, [], "Unauthorized", 401);
        //        }

        if (!$this->validateRequestType('GET'))
        {
            return false;
        }

        $objParams = $objData->Data->Params;

        if (!$this->validate($objParams, [
            "uuid" => "required|uuid",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $userResult = (new Users())->getByUuid($objParams["uuid"]);

        /** @var UserModel $user */
        $user = $userResult->getData()->first();

        $user->LoadUserConnections(false);

        return $this->renderReturnJson(true, ["user" => $user->ToPublicArray(null, true)], "We made it.");
    }

    public function getUserPersonas(ExcellHttpModel $objData) : bool
    {
        if (!$this->validateRequestType('GET'))
        {
            return false;
        }

        $objParams = $objData->Data->Params;

        if (!$this->validate($objParams, [
            "id" => "required|integer",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $users = new Users();
        $user = $users->getById($objParams["id"])->getData()->first();

        $personaFactory = new PersonaFactory($this->app, new Users(), new Cards());
        $personasResult = $personaFactory->getPersonasForDirectoryRegistration($objParams["id"]);

        if ($personasResult->getResult()->Count === 0) {
            $personaFactory->processFreePersonaPurchase($objParams["id"], new CartPurchaseFactory(
                new CartProcess(),
                new ProductProcessor(),
                new CartTicketProcess(),
                new CartEmails(),
                new Cards()
            ));
            $personasResult = $personaFactory->getPersonasForDirectoryRegistration($objParams["id"]);
        }

        $activePersonas = new ExcellCollection();
        $personasResult->getData()->Foreach(function(CardModel $site) use (&$activePersonas) {
            if ($site->status === "Active" || $site->status === "Build") {
                $site->LoadFullCard();
                $activePersonas->Add($site);
            }
        });

        return $this->renderReturnJson(true, ["personas" => $activePersonas->ToPublicArray(), "user" => $user->ToPublicArray()], $personasResult->getResult()->Message);
    }

    public function logUserIntoCore(ExcellHttpModel $objData) : bool
    {
        if (!$this->validateRequestType('POST'))
        {
            return false;
        }

        $objParams = $this->app->objHttpRequest->Data->PostData;

        if (!$this->validate($objParams, [
            "username" => "required",
            "password" => "required",
            "browserId" => "required",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $objUsers = new Users();
        $objUser = new UserModel();
        $objUser->username = $objParams->username;
        $objUser->password = $objParams->password;

        $objUserAuthentication = $objUsers->AuthenticateUserForLogin($objUser);

        if ( $objUserAuthentication->result->Success === false)
        {
            $this->renderReturnJson(false, [], $objUserAuthentication->result->Message);
        }

        $user = $objUserAuthentication->getData()->first();

        $loginId = $objUsers->setUserLoginSessionData($user, $this->app->objHttpRequest->Data->PostData->browserId, $this->app);
        $objUsers->setUserLoginCookies($user, $this->app);
        $objUsers->setUserActiveCookies($loginId, $this->app);

        $this->app->setActiveLoggedInUser($user);

        /** @var UserModel $user */
        $arUser = $user->ToPublicArray(["sys_row_id", "first_name", "last_name", "user_email", "user_phone", "user_id"]);

        $arUser["id"] = $arUser["sys_row_id"];
        $arUser["phone"] = $arUser["user_phone"];
        $arUser["email"] = $arUser["user_email"];
        $arUser["Roles"] = $user->Roles->ToPublicArray();
        $arUser["Departments"] = $user->Departments->ToPublicArray();

        unset($arUser["sys_row_id"]);

        $this->renderReturnJson(true, ["user" => $arUser], "User has successfully logged into the system.");
    }

    public function validateExistingUserCredentials(ExcellHttpModel $objData) : bool
    {
        if (!$this->validateRequestType('POST'))
        {
            return false;
        }

        $objParams = $this->app->objHttpRequest->Data->PostData;

        if (!$this->validate($objParams, [
            "username" => "required",
            "password" => "required",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $objUser = new UserModel();
        $objUser->username = $objParams->username;
        $objUser->password = $objParams->password;

        $objUserAuthentication = (new Users())->AuthenticateUserForLogin($objUser);

        if ( $objUserAuthentication->result->Success === false)
        {
            $this->renderReturnJson(false, [], $objUserAuthentication->result->Message);
        }

        /** @var UserModel $user */
        $user = $objUserAuthentication->getData()->first();
        $arUser = $user->ToPublicArray(["sys_row_id", "first_name", "last_name", "user_email", "user_phone", "user_id"]);

        $arUser["id"] = $arUser["sys_row_id"];
        $arUser["phone"] = $arUser["user_phone"];
        $arUser["email"] = $arUser["user_email"];
        unset($arUser["sys_row_id"]);

        $this->renderReturnJson(true, ["user" => $arUser], "Valid User Credentials.");
    }

    public function validateExistingUserCredentialsOnCard(ExcellHttpModel $objData) : bool
    {
        if (!$this->validateRequestType('POST')) {
            return false;
        }

        $objPost = $this->app->objHttpRequest->Data->PostData;
        $objParams = $this->app->objHttpRequest->Data->Params;

        if (!$this->validate($objPost, [
            "username" => "required",
            "password" => "required",
        ])) {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        if (!$this->validate($objParams, [
            "card_id" => "required|uuid",
        ])) {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $objUser = new UserModel();
        $objUser->username = $objPost->username;
        $objUser->password = $objPost->password;

        $objUserAuthentication = (new Users())->AuthenticateUserForLogin($objUser);

        if ( $objUserAuthentication->result->Success === false) {
            $this->renderReturnJson(false, [], "Authentication failed.");
        }

        /** @var UserModel $user */
        $user = $objUserAuthentication->getData()->first();

        $cards = new Cards();
        $cardResult = $cards->getByUuid($objParams["card_id"])->getData()->first();

        if ($cardResult === null || ($cardResult->owner_id !== $user->user_id && $cardResult->card_user_id !== $user->user_id)) {
            $this->renderReturnJson(false, [], "User Does Not Own Card.");
        }

        $arUser = $user->ToPublicArray(["sys_row_id", "first_name", "last_name", "user_email", "user_phone", "user_id"]);

        $arUser["id"] = $arUser["sys_row_id"];
        $arUser["phone"] = $arUser["user_phone"];
        $arUser["email"] = $arUser["user_email"];
        unset($arUser["sys_row_id"]);

        $this->renderReturnJson(true, ["user" => $arUser], "Valid User Credentials.");
    }

    public function updateUser(ExcellHttpModel $objData) : bool
    {
        if (!$this->validateRequestType('POST')) {
            return false;
        }

        $objPost = $this->app->objHttpRequest->Data->PostData;
        $objParams = $this->app->objHttpRequest->Data->Params;

        if (!$this->validate($objPost, [
            "first_name" => "required",
            "last_name" => "required",
            "email" => "required|email",
            "phone" => "required",
            "username" => "required",
        ])) {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        if (!$this->validate($objParams, [
            "user_id" => "required|number"
        ])) {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $userId =  $objData->Data->Params["user_id"];

        $userFactory = new UserFactory($this->app, new Users(), new Connections());
        $userUpdateResult = $userFactory->updateUserFromDataIfMatch($userId, $objPost->first_name, $objPost->last_name, $objPost->email, $objPost->phone, $objPost->username, $objPost->status, $objPost->password ?? null, $objPost->affiliate_id ?? null);

        if ($userUpdateResult->result->Success === false) {
            return $this->renderReturnJson(false, ["error" => "update_failed"], $userUpdateResult->result->Message);
        }

        $userFactory->processIntegrationsUpdate($userUpdateResult->getData()->first());

        $arUser = $userUpdateResult->getData()->first()->ToPublicArray(["sys_row_id", "user_id", "first_name", "last_name", "user_email", "user_phone", "username"]);

        $arUser["id"] = $arUser["sys_row_id"];
        $arUser["email"] = $objPost->email ?? null;
        $arUser["phone"] = $objPost->phone ?? null;
        unset($arUser["sys_row_id"]);

        return $this->renderReturnJson(true, ["user" => $arUser], $userUpdateResult->result->Message);
    }

    public function createNewUser(ExcellHttpModel $objData) : bool
    {
        $objPost = $this->app->objHttpRequest->Data->PostData;

        if (!$this->validate($objPost, [
            "first_name" => "required",
            "last_name" => "required",
            "email" => "required|email",
            "phone" => "required",
            "username" => "required",
            "password" => "required|passwordComplex",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $userFactory = new UserFactory($this->app, new Users(), new Connections());
        $objNewUserResult = $userFactory->createUserFromData(
            $objPost->first_name,
            $objPost->last_name,
            $objPost->email,
            $objPost->phone,
            $objPost->username,
            $objPost->password,
        );

        if ($objNewUserResult->getResult()->Success === false) {
            $this->renderReturnJson(false, $userFactory->getErrors(), $userFactory->getMessage());
        }

        $userFactory->processIntegrationsCreate($objNewUserResult->getData()->first());
        $userArray = $userFactory->renderUserReturnArray($objNewUserResult->getData()->first(), $objPost->email, $objPost->phone);

        return $this->renderReturnJson(true, ["user" => $userArray], "Valid User Credentials.");
    }

    public function getUsers(ExcellHttpModel $objData): void
    {
        $arRequestParams = $objData->Data->Params;

        if (empty($arRequestParams["field"]))
        {
            die('{"success":false,"message":"No fields passed in for query."}');
        }

        $arWhereClause = [];

        foreach($arRequestParams["field"] as $currFieldName => $currFieldValue)
        {
            $arWhereClause[] = [$currFieldName, "LIKE", $currFieldValue . "%"];
            $arWhereClause[] = ["OR"];
        }

        array_pop($arWhereClause);

        $objSearchResult = (new Users())->getWhere($arWhereClause);

        $arSearchResult = $objSearchResult->getData()->FieldsToArray(["user_id","first_name","last_name"]);

        $objUserSearchResult = [
            "users" => $arSearchResult
        ];

        $objResult = ["success" => true, "data" => $objUserSearchResult];
        die(json_encode($objResult));
    }

    public function getAffiliates(ExcellHttpModel $objData): void
    {
        $arRequestParams = $objData->Data->Params;

        if (empty($arRequestParams["field"]))
        {
            die('{"success":false,"message":"No fields passed in for query."}');
        }

        $arWhereClause = [];

        foreach($arRequestParams["field"] as $currFieldName => $currFieldValue)
        {
            $arWhereClause[] = ["user." . $currFieldName, "LIKE", $currFieldValue . "%"];
            $arWhereClause[] = ["OR"];
        }

        array_pop($arWhereClause);

        $objSearchResult = (new UserClass())->leftJoin([Users::class => ["module" => "Users", "source-fk" => "user_id", "target-fk" => "user_id"]])->getWhere([["user_class_type_id" => 15], "AND", [$arWhereClause]]);
        $arSearchResult = $objSearchResult->getData()->FieldsToArray(["user_id","first_name","last_name"]);

        $objUserSearchResult = [
            "users" => $arSearchResult
        ];

        $objResult = ["success" => true, "data" => $objUserSearchResult];
        die(json_encode($objResult));
    }

    public function getConnectionTypes(ExcellHttpModel $objData): bool
    {
        if (!$this->validateRequestType('GET'))
        {
            return false;
        }

        $connectionType = new ConnectionTypes();

        $connectionTypeResult = $connectionType->getAllRows();

        return $this->renderReturnJson(true, ["list" => $connectionTypeResult->getData()->ToPublicArray()], "Available connection types.");
    }

    public const connectionTypeWebsite = 2;
    public const connectionTypeBlog = 7;

    public function getShareTypes(ExcellHttpModel $objData): bool
    {
        if (!$this->validateRequestType('GET'))
        {
            return false;
        }

        $connectionType = new ConnectionTypes();

        $connectionTypeResult = $connectionType->getWhere([["action", "IN", ["phone", "sms", "fax", "email"]], "OR", ["connection_type_id", "IN", [static::connectionTypeWebsite, static::connectionTypeBlog]]]);

        return $this->renderReturnJson(true, ["list" => $connectionTypeResult->getData()->ToPublicArray()], "Available connection types.");
    }

    public function getAvailableConnectionsForCard(ExcellHttpModel $objData) : bool
    {
        if (!$this->validateRequestType('GET'))
        {
            return false;
        }

        $objParams = $objData->Data->Params;

        if (!$this->validate($objParams, [
            "card_id" => "required|integer",
            "owner_id" => "required|integer",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $objLoggedInUser = $this->app->getActiveLoggedInUser();
        $colCardConnectionsResult = (new Connections())->getByCardId($objParams["card_id"]);
        $colCardConnections = $colCardConnectionsResult->getData();

        $colUserConnections = (new Connections())->getByUserIds([$objParams["owner_id"]],$objLoggedInUser->user_id, $this->app->objCustomPlatform->getCompanyId())->getData();
        $colUserConnections->MergeWithoutDuplicates($colCardConnections, "connection_id");

        return $this->renderReturnJson(true, ["list" => $colUserConnections->ToPublicArray()], "Available connections.");
    }

    public function getAvailableSharesForCard(ExcellHttpModel $objData) : bool
    {
        if (!$this->validateRequestType('GET'))
        {
            return false;
        }

        $objParams = $objData->Data->Params;

        if (!$this->validate($objParams, [
            "card_id" => "required|integer",
            "owner_id" => "required|integer",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $objLoggedInUser = $this->app->getActiveLoggedInUser();
        $colCardConnectionsResult = (new Connections())->getSharesByCardId($objParams["card_id"]);
        $colCardConnections = $colCardConnectionsResult->getData();

        $colUserConnections = (new Connections())->getSharesByUserIds([$objParams["owner_id"]], $objLoggedInUser->user_id, $this->app->objCustomPlatform->getCompanyId())->getData();
        $colUserConnections->MergeWithoutDuplicates($colCardConnections, "connection_id");

        return $this->renderReturnJson(true, ["list" => $colUserConnections->ToPublicArray()], "Available shares.");
    }

    public function getAvailableSocialsForCard(ExcellHttpModel $objData) : bool
    {
        if (!$this->validateRequestType('GET'))
        {
            return false;
        }

        $objParams = $objData->Data->Params;

        if (!$this->validate($objParams, [
            "card_id" => "required|integer",
            "owner_id" => "required|integer",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $objLoggedInUser = $this->app->getActiveLoggedInUser();
        $colCardConnectionsResult = (new Connections())->getSocialMediaByCardId($objParams["card_id"]);
        $colCardConnections = $colCardConnectionsResult->getData();

        $colUserConnections = (new Connections())->getSocialMediaByUserIds([$objParams["owner_id"]], $objLoggedInUser->user_id, $this->app->objCustomPlatform->getCompanyId())->getData();
        $colUserConnections->MergeWithoutDuplicates($colCardConnections, "connection_id");

        return $this->renderReturnJson(true, ["list" => $colUserConnections->ToPublicArray()], "Available shares.");
    }

    public function updateUserConnection(ExcellHttpModel $objData) : bool
    {
        if (!$this->validateRequestType('POST'))
        {
            return false;
        }

        $objParams = $objData->Data->Params;
        $objPost = $objData->Data->PostData;

        if (!$this->validate($objParams, [
            "connection_id" => "required|number",
            "action" => "required",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        if (!$this->validate($objPost, [
            "connection_type_id" => "required|integer",
            "connection_value" => "required",
            "user_id" => "required|integer",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $objConnectionModel = new ConnectionModel();

        $objConnectionModel->connection_type_id = $objPost->connection_type_id;
        $objConnectionModel->connection_value = $objPost->connection_value;

        try
        {
            if ($objParams["action"] === "add")
            {
                $objConnectionModel->company_id = $this->app->objCustomPlatform->getCompanyId();
                $objConnectionModel->division_id = 0;
                $objConnectionModel->user_id = $objPost->user_id;
                $objConnectionModel->is_primary = 0;
                $objConnectionModel->connection_class = "user";

                $result = (new Connections())->createNew($objConnectionModel);

                $intConnectionId = $result->getData()->first()->connection_id;
                $objConnectionModel->connection_id = $intConnectionId;
                (new UserLogs())->RegisterActivity($this->app->getActiveLoggedInUser()->user_id, "updated_connection", "Connection Successfully Created: #" . $intConnectionId . " with value: " . $objConnectionModel->connection_value, "connection", $intConnectionId);
            }
            else
            {
                $intConnectionId = $objParams["connection_id"];
                $objConnectionModel->connection_id = $intConnectionId;
                $result = (new Connections())->update($objConnectionModel);
                (new UserLogs())->RegisterActivity($this->app->getActiveLoggedInUser()->user_id, "updated_connection", "Connection Updated Successfully: #" . $intConnectionId . " with value: " . $objConnectionModel->connection_value, "connection", $intConnectionId);
            }

            $cardResult = (new Connections())->getById($objConnectionModel->connection_id);

            return $this->renderReturnJson(true, ["connection" => $cardResult->getData()->first()->ToPublicArray()], "User connection updated.");
        }
        catch (\Exception $exception)
        {
            return $this->renderReturnJson(false, $this->validationErrors, "An error occured during user update: " . $exception->getMessage() . ".");
        }
    }

    public function loginAppUser(ExcellHttpModel $objData): void
    {
        $objNewUserData = (object) $objData->Data->PostData;

        if ( empty($objNewUserData->username))
        {
            die('{"success": false, "data":{"message":"You did not supply a username."}}');
        }

        if ( empty($objNewUserData->password))
        {
            die('{"success": false, "data":{"message":"You did not supply a password."}}');
        }

        $objUser = new UserModel();

        $objUser->username = $objNewUserData->username;
        $objUser->password = $objNewUserData->password;

        $objUserAuthentication = (new Users())->AuthenticateUserForLogin($objUser);

        if ( $objUserAuthentication->result->Success === false)
        {
            die('{"success":false,"message":"'.$objUserAuthentication->result->Message.'"}');
        }

        die('{"success":true,"message":"'.$objUserAuthentication->result->Message.'"}');
    }

    public function registerAppUser(ExcellHttpModel $objData): void
    {
        $objNewUserData = (object) $objData->Data->PostData;

        if ( empty($objNewUserData->username))
        {
            die('{"success": false, "data":{"message":"You did not supply a username."}}');
        }

        if ( empty($objNewUserData->email))
        {
            die('{"success": false, "data":{"message":"You did not supply an email address."}}');
        }

        if ( empty($objNewUserData->phonenumber))
        {
            die('{"success": false, "data":{"message":"You did not supply a phone number."}}');
        }

        if ( empty($objNewUserData->password))
        {
            die('{"success": false, "data":{"message":"You did not supply a password."}}');
        }

        $objCreationNewUser = new UserModel();

        $objCreationNewUser->username = $objNewUserData->username;
        $objCreationNewUser->password = $objNewUserData->password;
        $objCreationNewUser->division_id = 0;
        $objCreationNewUser->company_id = 0;
        $objCreationNewUser->sponsor_id = 1001;

        $objNewUserResult = (new Users())->createNew($objCreationNewUser);

        $objEmailAddressResult = $this->assignEmailAddress($objNewUserResult->getData()->first()->user_id, $objNewUserData->email);
        $objMobileNumberResult = $this->assignMobileNumber($objNewUserResult->getData()->first()->user_id, $objNewUserData->phonenumber);

        $objCreationNewUser->user_email = $objEmailAddressResult->getData()->first()->connection_value;
        $objCreationNewUser->user_phone = $objMobileNumberResult->getData()->first()->connection_value;

        (new Users())->update($objCreationNewUser);

        logText("RegisterNewAppUser.log", json_encode($objData->Data->PostData));

        $objUserCreationResult = [
            "user_id" => $objNewUserResult->getData()->first()->user_id
        ];

        $objResult = ["success" => true, "data" => $objUserCreationResult];

        die(json_encode($objResult));
    }

    private function assignEmailAddress($intUserId, $strConnectionValue) : ExcellTransaction
    {
        $objConnection = new ConnectionModel();

        $objConnection->user_id = $intUserId;
        $objConnection->connection_type_id = 6;
        $objConnection->division_id = 0;
        $objConnection->company_id = 0;
        $objConnection->connection_value = $strConnectionValue;
        $objConnection->is_primary = EXCELL_TRUE;
        $objConnection->connection_class = 'user';

        return (new Connections())->createNew($objConnection);
    }

    private function assignMobileNumber($intUserId, $strConnectionValue) : ExcellTransaction
    {
        $objConnection = new ConnectionModel();

        $objConnection->user_id = $intUserId;
        $objConnection->connection_type_id = 1;
        $objConnection->division_id = 0;
        $objConnection->company_id = 0;
        $objConnection->connection_value = $strConnectionValue;
        $objConnection->is_primary = EXCELL_TRUE;
        $objConnection->connection_class = 'user';

        return (new Connections())->createNew($objConnection);
    }

    public function checkUserUsername(ExcellHttpModel $objData): void
    {
        $objUsersResult = new ExcellTransaction();

        if (empty($objData->Data->Params["username"]))
        {
            $objResult = ["success" => false, "match" => "NA"];
            die(json_encode($objResult));
        }

        $strUsername = $objData->Data->Params["username"];
        $companyId = $this->app->objCustomPlatform->getCompanyId();

        if (empty($objData->Data->Params["user_id"]) || $objData->Data->Params["user_id"] === "undefined")
        {
            $objUsersResult = (new Users())->getWhere(["username" => $strUsername, "company_id" => $companyId]);
        }
        else
        {
            $objUsersResult = (new Users())->getWhere([["username", "=", $strUsername], "AND", ["user_id", "!=", $objData->Data->Params["user_id"]], "AND", ["company_id", "=", $companyId]]);
        }

        if ($objUsersResult->result === false || $objUsersResult->result->Count === 0)
        {
            $objResult = ["success" => true, "match" => false];
            die(json_encode($objResult));
        }

        $objResult = ["success" => true, "match" => true];
        die(json_encode($objResult));
    }

    public function sendEmailToUser(ExcellHttpModel $objData) : bool
    {
        $objParams = $this->app->objHttpRequest->Data->Params;

        if (!$this->validate($objParams, [
            "name" => "required",
            "email" => "required|email",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $name = $objParams["name"];
        $email = $objParams["email"];

        (new Emails())->SendEmail(
            "EZcard Sharing <info@ezcard.com>",
            ["{$name} <{$email}>"],
            "This is a test email.",
            "<p>{$name} is getting an email.</p>"
        );

        return $this->renderReturnJson(true, [], "We sent an email.");
    }

    public function resetPasswordFromSite(ExcellHttpModel $objData) : bool
    {
        $objPost = $objData->Data->PostData;

        if (!$this->validate($objPost, [
            "request_token" => "required|uuid",
            "__RequestVerificationToken" => "required",
            "password_for_reset" => "required",
            "password_for_reset_reenter" => "required",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $users = new Users();
        $user = $users->getWhere(["password_reset_token" => $objPost->request_token])->getData()->first();

        if ($user === null)
        {
            return $this->renderReturnJson(false, [], "Password reset for user.");
        }

        $passwordFiltered = str_replace(["'",'"', " ", "--", "`", "/"], "", $objPost->password_for_reset);

        $user->password = $passwordFiltered;
        $user->password_reset_token = EXCELL_NULL;
        $users->update($user);

        return $this->renderReturnJson(true, [], "Password reset for user.");
    }

    public function checkUsersPrimaryPhone(ExcellHttpModel $objData) : bool
    {
        $objPost = $objData->Data->Params;

        if (!$this->validate($objPost, [
            "phone" => "required|integer"
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $blnMatch = (new Users())->findMatchingPrimaryPhone($objPost["phone"], $this->app->objCustomPlatform->getCompanyId(), $objData->Data->Params["user_id"]);

        if ($blnMatch->data["match"] === true)
        {
            return $this->renderReturnJson(true, ["match" => true], "Match Found.");
        }

        return $this->renderReturnJson(true, ["match" => false], "Match not found.");
    }

    public function checkUsersPrimaryEmail(ExcellHttpModel $objData) : bool
    {
        $objPost = $objData->Data->Params;

        if (!$this->validate($objPost, [
            "email" => "required|email"
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $blnMatch = (new Users())->findMatchingPrimaryEmail($objPost["email"], $this->app->objCustomPlatform->getCompanyId(), $objData->Data->Params["user_id"]);

        if ($blnMatch->data["match"] === true)
        {
            return $this->renderReturnJson(true, ["match" => true], "Match Found.");
        }

        return $this->renderReturnJson(true, ["match" => false], "Match not found.");
    }
}
