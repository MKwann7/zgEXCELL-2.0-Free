<?php

namespace Http\Users\Controllers;

use App\Utilities\Database;
use App\Utilities\Excell\ExcellHttpModel;
use Entities\Activities\Classes\UserLogs;
use Entities\Cards\Classes\Cards;
use Entities\Cards\Classes\CardConnections;
use Entities\Cards\Models\CardModel;
use Entities\Media\Classes\Images;
use Entities\Notes\Classes\Notes;
use Http\Users\Controllers\Base\UserController;
use Entities\Users\Classes\Connections;
use Entities\Users\Classes\UserAddress;
use Entities\Users\Classes\UserClass;
use Entities\Users\Classes\Users;
use Entities\Users\Models\ConnectionModel;
use Entities\Users\Models\UserAddressModel;
use Entities\Users\Models\UserClassModel;
use Entities\Users\Models\UserModel;

class UserDataController extends UserController
{
    public function index(ExcellHttpModel $objData) : void
    {
        die('{"success":true,"message":"we made it1."}');
    }

    public function getCustomerDashboardInfo(ExcellHttpModel $objData) : bool
    {
        if(!$this->app->isUserLoggedIn() || !$this->app->isPortalWebsite())
        {
            $this->app->redirectToLogin();
        }

        $intUserId = $objData->Data->PostData->user_id;
        $blnUserViewFound = false;

        $objUserResult = (new Users())->getFks(["user_phone", "user_email"])->getById($intUserId);

        if ($objUserResult->result->Count > 0)
        {
            $blnUserViewFound = true;
        }

        $objUser = $objUserResult->getData()->first();
        $lstUserCards = (new Cards())->getFks()->GetByUserId($intUserId);
        $colUserAddresses = (new Users())->getFks()->GetAddressesByUserId($intUserId);
        $colUserConnections = (new Users())->getFks()->GetConnectionsByUserId($intUserId);
        $colUserActivities = (new UserLogs())->GetUserActivity($intUserId);
        $lstUserNotes = (new Notes())->getWhere(["entity_name" => "user", "entity_id" => $intUserId]);

        $strCardMainImage = "/_ez/images/users/defaultAvatar.jpg";
        $strCardThumbImage = "/_ez/images/users/defaultAvatar.jpg";

        $objImageResult = (new Images())->noFks()->getWhere(["entity_id" => $intUserId, "image_class" => "user-avatar", "entity_name" => "user"],"image_id.DESC");

        if ($objImageResult->result->Success === true && $objImageResult->result->Count > 0)
        {
            $strCardMainImage = $objImageResult->getData()->first()->url;
            $strCardThumbImage = $objImageResult->getData()->first()->thumb;
        }

        $arUserCardsIds = $lstUserCards->getData()->FieldsToArray(["card_id"]);
        $lstCardImages = (new Images())->getWhere([["entity_name" => "card", "image_class" =>"main-image"], "AND", ["entity_id", "IN", $arUserCardsIds]]);
        $lstUserCards->getData()->MergeFields($lstCardImages->data,["url" => "main_image","thumb" => "main_thumb"],["entity_id" => "card_id"]);

        foreach($lstUserCards->data as $currCardId => $currCardData)
        {
            $lstUserCards->getData()->{$currCardId}->AddUnvalidatedValue("main_image", $currCardData->main_image ?? ("/_ez/templates/" . ($currCardData->template_id__value ?? "1") . "/images/mainImage.jpg"));
            $lstUserCards->getData()->{$currCardId}->AddUnvalidatedValue("main_thumb", $currCardData->main_thumb ?? ("/_ez/templates/" . ($currCardData->template_id__value ?? "1") . "/images/mainImage.jpg"));
        }

        if (!empty($objUser))
        {
            $objUser->AddUnvalidatedValue("main_image", $strCardMainImage);
            $objUser->AddUnvalidatedValue("main_thumb", $strCardThumbImage);
        }

        $arUserDashboardInfo = array(
            "user" => !empty($objUser) ? $objUser->ToArray() : "[]",
            "blnUserViewFound" => $blnUserViewFound,
            "addresses" => $colUserAddresses->getData()->CollectionToArray(),
            "connections" => $colUserConnections->getData()->CollectionToArray(),
            "notes" => $lstUserNotes->getData()->CollectionToArray(),
            "cards" => $lstUserCards->getData()->CollectionToArray(),
            "activities" => $colUserActivities->getData()->CollectionToArray(),
        );

        $objJsonReturn = array(
            "success" => true,
            "message" => "We found information for user_id = " . $objData->Data->PostData->user_id . ".",
            "data" => $arUserDashboardInfo,
        );

        die(json_encode($objJsonReturn));
    }

    public function getCustomerDashboardViews(ExcellHttpModel $objData) : void
    {
        if(!$this->app->isUserLoggedIn() || !$this->app->isPortalWebsite())
        {
            $this->app->redirectToLogin();
        }

        $strViewTitle = $objData->Data->PostData->view;

        $strView = $this->AppEntity->getView("component.manage_user_data", $this->app->strAssignedPortalTheme, ["strViewTitle" => $strViewTitle, "app" => $this->app]);

        if (empty($strView))
        {
            $objJsonReturn = array(
                "success" => false,
                "message" => "We did not find the requested view.",
            );

            die(json_encode($objJsonReturn));
        }

        $arDataReturn = array(
            "view" => base64_encode($strView),
        );

        $objJsonReturn = array(
            "success" => true,
            "message" => "We found the requested view.",
            "data" => $arDataReturn,
        );

        die(json_encode($objJsonReturn));
    }

    public function getAffiliateDashboardViews(ExcellHttpModel $objData) : void
    {
        if(!$this->app->isUserLoggedIn() || !$this->app->isPortalWebsite())
        {
            $this->app->redirectToLogin();
        }

        $strViewTitle = $objData->Data->PostData->view;

        $strView = $this->AppEntity->getView("component.manage_affiliate_data", $this->app->strAssignedPortalTheme, ["strViewTitle" => $strViewTitle]);

        if (empty($strView))
        {
            $objJsonReturn = array(
                "success" => false,
                "message" => "We did not find the requested view.",
            );

            die(json_encode($objJsonReturn));
        }

        $arDataReturn = array(
            "view" => base64_encode($strView),
        );

        $objJsonReturn = array(
            "success" => true,
            "message" => "We found the requested view.",
            "data" => $arDataReturn,
        );

        die(json_encode($objJsonReturn));
    }

    public function createAffiliateData(ExcellHttpModel $objData) : bool
    {
        $objAffiliateId = $objData->Data->PostData->sponsor_id;
        $objAffiliateUserResult = (new Users())->getById($objAffiliateId);
        $objAffiliateUser = $objAffiliateUserResult->getData()->first();

        $objUserClass = new UserClassModel();
        $objUserClass->user_id = $objAffiliateUser->user_id;
        $objUserClass->user_class_type_id = 15;

        $objNewUserResult = (new UserClass())->createNew($objUserClass);

        if ($objNewUserResult->result->Success === false)
        {
            $objJsonReturn = array(
                "success" => false,
                "message" => $objNewUserResult->result->Message,
                "query" => $objNewUserResult->result->Query,
            );

            die(json_encode($objJsonReturn));
        }

        $lstUserAvatars = (new Images())->getWhere([["entity_name" => "user", "image_class" => "user-avatar"], "AND", ["entity_id" => $objAffiliateUser->user_id]],"last_updated.DESC",1);
        $objAffiliateUserResult->getData()->MergeFields($lstUserAvatars->data,["url" => "main_image","thumb" => "main_thumb"],["entity_id" => "user_id"]);

        $arNewUserCreationResult = $objAffiliateUserResult->getData()->FieldsToArray([
            "main_thumb",
            "user_id",
            "username",
            "created_on",
            "status",
            "first_name",
            "last_name",
        ]);

        $objUserSearchResult = [
            "people" => $arNewUserCreationResult
        ];

        $objJsonReturn = ["success" => true, "data" => $objUserSearchResult];

        die(json_encode($objJsonReturn));
    }

    public function createUserData(ExcellHttpModel $objData) : bool
    {
        $objLoggedInUser = $this->app->getActiveLoggedInUser();
        $objUserCreate = new UserModel($objData->Data->PostData);

        $objUserCreate->company_id = $this->app->objCustomPlatform->getCompanyId();
        $objUserCreate->division_id = 0;

        $objNewUserResult = (new Users())->createNew($objUserCreate);

        if ($objNewUserResult->result->Success === false)
        {
            $objJsonReturn = array(
                "success" => false,
                "message" => $objNewUserResult->result->Message,
                "query" => $objNewUserResult->result->Query,
            );

            die(json_encode($objJsonReturn));
        }

        $objNewUser = $objNewUserResult->getData()->first();

        $strPrimaryEmail = $objData->Data->PostData->primary_email ?? null;
        $strPrimaryPhone = $objData->Data->PostData->primary_phone ?? null;

        if ($strPrimaryEmail !== null)
        {
            $objConnection = new ConnectionModel();

            $objConnection->user_id = $objNewUserResult->getData()->first()->user_id;
            $objConnection->connection_type_id = 6;
            $objConnection->division_id = 0;
            $objConnection->company_id = $this->app->objCustomPlatform->getCompanyId();
            $objConnection->connection_value = $strPrimaryEmail;
            $objConnection->is_primary = EXCELL_TRUE;
            $objConnection->connection_class = 'user';

            $objEmailResult = (new Connections())->createNew($objConnection);
            $objNewUser->user_email = $objEmailResult->getData()->first()->connection_id;
        }

        if ($strPrimaryPhone !== null)
        {
            $objConnection = new ConnectionModel();

            $objConnection->user_id = $objNewUserResult->getData()->first()->user_id;
            $objConnection->connection_type_id = 1;
            $objConnection->division_id = 0;
            $objConnection->company_id = $this->app->objCustomPlatform->getCompanyId();
            $objConnection->connection_value = $strPrimaryPhone     ;
            $objConnection->is_primary = EXCELL_TRUE;
            $objConnection->connection_class = 'user';

            $objPhoneResult = (new Connections())->createNew($objConnection);
            $objNewUser->user_phone = $objPhoneResult->getData()->first()->connection_id;
        }

        $objNewUser->sponsor_id = $objData->Data->PostData->card_affiliate;
        $objNewUserResult = (new Users())->update($objNewUser);

        $arNewUserCreationResult = $objNewUserResult->getData()->FieldsToArray([
            "main_thumb",
            "user_id",
            "username",
            "created_on",
            "status",
            "first_name",
            "last_name",
        ]);

        $objUserSearchResult = [
            "user" => $arNewUserCreationResult
        ];

        $objJsonReturn = ["success" => true, "data" => $objUserSearchResult];

        die(json_encode($objJsonReturn));
    }

    public function updateUserData(ExcellHttpModel $objData)
    {
        $intUserId = $objData->Data->Params["id"];

        if (empty($intUserId))
        {
            $objJsonReturn = array(
                "success" => false,
                "message" => "A valid `user i`d must be included in this update reqest1."
            );

            die(json_encode($objJsonReturn));
        }

        $objUser = (new Users())->getById($intUserId);

        if ($objUser->result->Success === false || $objUser->result->Count === 0)
        {
            $objJsonReturn = array(
                "success" => false,
                "message" => "A valid user id must be included in this update reqest2."
            );

            die(json_encode($objJsonReturn));
        }

        $strUpdateType = $objData->Data->Params["type"];

        // Update Custom fields.
        switch($strUpdateType)
        {
            case "profilewidget":
            case "profileAdmin":
            case "account":

                $objUserUpdate = new UserModel($objData->Data->PostData);
                $objUserUpdate->user_id = $intUserId;
                $objUserUpdate->sponsor_id = $objData->Data->PostData->card_affiliate;

                try
                {
                    $objUsersResult = (new Users())->update($objUserUpdate);

                    $arObjCardPageData = $objUsersResult->getData()->ConvertToArray();

                    $objUserForReturn = array_shift($arObjCardPageData);

                    $arResult = ["success" => true, "customer" => $objUserForReturn];

                    die(json_encode($arResult));
                }
                catch(\Exception $exception)
                {
                    $objJsonReturn = array(
                        "success" => false,
                        "message" => "An error occured during user update: " . json_encode($exception) . "."
                    );

                    die(json_encode($objJsonReturn));
                }

                break;

            case "connection":

                $intUserId = $objData->Data->Params["id"];
                $objCurrentUser = (new Users())->getById($intUserId)->getData()->first();
                $objConnectionId = $objData->Data->Params["connection_id"];

                if ($objConnectionId !== "new")
                {
                    $objConnectionUpdate = new ConnectionModel($objData->Data->PostData);
                    $objConnectionUpdate->connection_id = $objConnectionId;

                    try
                    {
                        $objConnectionCreationResult = (new Connections())->getFks()->update($objConnectionUpdate);

                        if ($objConnectionCreationResult->result->Success === false)
                        {
                            $objJsonReturn = array(
                                "success" => false,
                                "message" => "An error occured during user update: " . $objConnectionCreationResult->result->Message . "."
                            );

                            die(json_encode($objJsonReturn));
                        }

                        $arObjCardPageData = $objConnectionCreationResult->getData()->ConvertToArray();

                        $objUserForReturn = array_shift($arObjCardPageData);

                        $arResult = ["success" => true,"connection" => $objUserForReturn];

                        die(json_encode($arResult));
                    }
                    catch(\Exception $exception)
                    {
                        $objJsonReturn = array(
                            "success" => false,
                            "message" => "An error occured during user update: " . json_encode($exception) . "."
                        );

                        die(json_encode($objJsonReturn));
                    }
                }
                else
                {
                    unset($objData->Data->PostData->connection_id);
                    $objConnectionUpdate = new ConnectionModel($objData->Data->PostData);
                    $objConnectionUpdate->user_id = $objCurrentUser->user_id;
                    $objConnectionUpdate->company_id = $this->app->objCustomPlatform->getCompanyId();
                    $objConnectionUpdate->division_id = 0;
                    $objConnectionUpdate->is_primary = EXCELL_FALSE;
                    $objConnectionUpdate->connection_class = "user";

                    try
                    {
                        $objConnectionCreationResult = (new Connections())->getFks()->createNew($objConnectionUpdate);

                        if ($objConnectionCreationResult->result->Success === false)
                        {
                            $objJsonReturn = array(
                                "success" => false,
                                "data" => $objCurrentUser->ToArray(),
                                "message" => "An error occured during user update: " . $objConnectionCreationResult->result->Message . "."
                            );

                            die(json_encode($objJsonReturn));
                        }

                        $arObjCardPageData = $objConnectionCreationResult->getData()->ConvertToArray();

                        $objUserForReturn = array_shift($arObjCardPageData);

                        $arResult = ["success" => true,"connection" => $objUserForReturn];

                        die(json_encode($arResult));
                    }
                    catch(\Exception $exception)
                    {
                        $objJsonReturn = array(
                            "success" => false,
                            "message" => "An error occured during user update: " . json_encode($exception) . "."
                        );

                        die(json_encode($objJsonReturn));
                    }
                }

                break;

            case "delete-connection":

                $inConnectionId = $objData->Data->Params["connection_id"];

                try
                {
                    $objCardConnectionDeletionResult = (new CardConnections())->deleteWhere(["connection_id" => $inConnectionId]);

                    if ($objCardConnectionDeletionResult->result->Success === false)
                    {
                        $objJsonReturn = array(
                            "success" => false,
                            "message" => "An error occured during connection rel deletion: " . $objCardConnectionDeletionResult->result->Message . "."
                        );

                        die(json_encode($objJsonReturn));
                    }

                    $objConnectionDeletionResult = (new Connections())->deleteById($inConnectionId);

                    if ($objConnectionDeletionResult->result->Success === false)
                    {
                        $objJsonReturn = array(
                            "success" => false,
                            "message" => "An error occured during connection deletion: " . $objConnectionDeletionResult->result->Message . "."
                        );

                        die(json_encode($objJsonReturn));
                    }

                    $objJsonReturn = array(
                        "success" => true,
                        "message" => "Successful deletion."
                    );
                }
                catch(\Exception $exception)
                {
                    $objJsonReturn = array(
                        "success" => false,
                        "message" => "An error occured during user update: " . json_encode($exception) . "."
                    );

                    die(json_encode($objJsonReturn));
                }

                $objJsonReturn = array(
                    "success" => true,
                    "message" => "Successful update."
                );

                die(json_encode($objJsonReturn));

                break;

            case "delete-address":

                $inAddressId = $objData->Data->Params["address_id"];

                try
                {
                    $objUserAddressDeletionResult = (new UserAddress())->deleteWhere(["address_id" => $inAddressId]);

                    if ($objUserAddressDeletionResult->result->Success === false)
                    {
                        $objJsonReturn = array(
                            "success" => false,
                            "message" => "An error occured during address deletion: " . $objUserAddressDeletionResult->result->Message . "."
                        );

                        die(json_encode($objJsonReturn));
                    }

                    $objJsonReturn = array(
                        "success" => true,
                        "message" => "Successful deletion."
                    );
                    die(json_encode($objJsonReturn));
                }
                catch(\Exception $exception)
                {
                    $objJsonReturn = array(
                        "success" => false,
                        "message" => "An error occured during user update: " . json_encode($exception) . "."
                    );

                    die(json_encode($objJsonReturn));
                }

                break;

            case "address":

                $intAddressId = $objData->Data->Params["address_id"];

                try
                {

                    $objUserAddressUpdate = new UserAddressModel($objData->Data->PostData);
                    if ($intAddressId !== "new")
                    {
                        $objUserAddressUpdate->address_id = $intAddressId;
                        $result = (new UserAddress())->update($objUserAddressUpdate);

                        $objJsonReturn = array(
                            "success" => true,
                            "message" => "Address Updated.",
                            "address"=> $result->getData()->first()->ToArray()
                        );

                        die(json_encode($objJsonReturn));
                    }
                    else
                    {
                        $result = (new UserAddress())->createNew($objUserAddressUpdate);

                        $objJsonReturn = array(
                            "success" => true,
                            "message" => "Address Created.",
                            "address"=> $result->getData()->first()->ToArray()
                        );

                        die(json_encode($objJsonReturn));
                    }
                }
                catch(\Exception $exception)
                {
                    $objJsonReturn = array(
                        "success" => false,
                        "message" => "An error occured during user update: " . json_encode($exception) . "."
                    );

                    die(json_encode($objJsonReturn));
                }

                // Update connection by id

                break;
        }
    }

    public function getUserNewBatches(ExcellHttpModel $objData) : bool
    {
        $pageIndex  = $objData->Data->Params["offset"] ?? 1;
        $batchCount = $objData->Data->Params["batch"] ?? 500;
        $pageIndex  = ($pageIndex - 1) * $batchCount;
        $arFields   = explode(",", $objData->Data->Params["fields"]);
        $strEnd     = "false";

        $objWhereClause = "
            SELECT user.*,
            (SELECT platform_name FROM `excell_main`.`company` WHERE company.company_id = user.company_id LIMIT 1) AS platform,
            (SELECT url FROM `excell_media`.`image` WHERE image.entity_id = user.user_id AND image.entity_name = 'user' AND image_class = 'user-avatar' ORDER BY image_id DESC LIMIT 1) AS avatar,
            (SELECT COUNT(*) FROM `excell_main`.`card` cd WHERE cd.owner_id = user.user_id) AS cards
            FROM `excell_main`.`user` 
            LEFT JOIN `excell_main`.`user_class` uc ON uc.user_id = user.user_id AND uc.user_class_type_id >= 5 AND uc.user_class_type_id <= 7 ";

        $objWhereClause .= "WHERE user.company_id = {$this->app->objCustomPlatform->getCompanyId()} AND uc.user_class_type_id >= 5 AND uc.user_class_type_id <= 7 ";

        $objWhereClause .= " ORDER BY user.user_id DESC LIMIT {$pageIndex}, {$batchCount}";

        $objCards = Database::getSimple($objWhereClause, "user_id");

        if ($objCards->getData()->Count() < $batchCount)
        {
            $strEnd = "true";
        }

        $objCards->getData()->HydrateModelData(UserModel::class, true);

        $arUserDashboardInfo = array(
            "list" => $objCards->getData()->FieldsToArray($arFields),
            "result" => $objCards->result->Message,
        );

        return $this->renderReturnJson(true, $arUserDashboardInfo, "We found " . $objCards->getData()->Count() . " users in this batch.", 200, "data", $strEnd);
    }

    public function getPersonaBatches(ExcellHttpModel $objData) : bool
    {
        $pageIndex  = $objData->Data->Params["offset"] ?? 1;
        $batchCount = $objData->Data->Params["batch"] ?? 500;
        $filterEntity = $objData->Data->Params["filterEntity"] ?? null;
        $pageIndex  = ($pageIndex - 1) * $batchCount;
        $arFields   = explode(",", $objData->Data->Params["fields"]);
        $strEnd     = "false";

        $filterIdField = "user_id";

        if ($filterEntity !== null && !isInteger($filterEntity))
        {
            $filterIdField = "sys_row_id";
            $filterEntity = "'".$filterEntity."'";
        }

        $objWhereClause = (new Cards())->buildCardBatchWhereClause($filterIdField, $filterEntity, 2);

        $objWhereClause .= " LIMIT {$pageIndex}, {$batchCount}";

        $objCards = Database::getSimple($objWhereClause, "card_id");

        if ($objCards->getData()->Count() < $batchCount)
        {
            $strEnd = "true";
        }

        $objCards->getData()->HydrateModelData(CardModel::class, true);

        $arUserDashboardInfo = array(
            "list" => $objCards->getData()->FieldsToArray($arFields),
            "query" => $objWhereClause,
        );

        return $this->renderReturnJson(true, $arUserDashboardInfo, "We found " . $objCards->getData()->Count() . " cards in this batch.", 200, "data", $strEnd);
    }

    public function getCustomPlatformUserBatches(ExcellHttpModel $objData) : bool
    {
        $pageIndex  = $objData->Data->Params["offset"] ?? 1;
        $batchCount = $objData->Data->Params["batch"] ?? 500;
        $filterEntity = $objData->Data->Params["filterEntity"] ?? null;
        $pageIndex  = ($pageIndex - 1) * $batchCount;
        $arFields   = explode(",", $objData->Data->Params["fields"]);
        $strEnd     = "false";

        $objWhereClause = "
            SELECT user.*,
            (SELECT platform_name FROM `excell_main`.`company` WHERE company.company_id = user.company_id LIMIT 1) AS platform,
            (SELECT url FROM `excell_media`.`image` WHERE image.entity_id = user.user_id AND image.entity_name = 'user' AND image_class = 'user-avatar' ORDER BY image_id DESC LIMIT 1) AS avatar,
            (SELECT COUNT(*) FROM `excell_main`.`card` cd WHERE cd.owner_id = user.user_id) AS cards
            FROM `excell_main`.`user` 
            LEFT JOIN `excell_main`.`user_class` uc ON uc.user_id = user.user_id AND uc.user_class_type_id >= 5 AND uc.user_class_type_id <= 7 ";

        $objWhereClause .= "WHERE user.company_id = {$filterEntity} AND uc.user_class_type_id >= 5 AND uc.user_class_type_id <= 7 ";
        $objWhereClause .= " ORDER BY user.user_id DESC LIMIT {$pageIndex}, {$batchCount}";

        $objCards = Database::getSimple($objWhereClause, "user_id");

        if ($objCards->getData()->Count() < $batchCount)
        {
            $strEnd = "true";
        }

        $objCards->getData()->HydrateModelData(UserModel::class, true);

        $arUserDashboardInfo = array(
            "list" => $objCards->getData()->FieldsToArray($arFields),
            "result" => $objCards->result->Message,
        );

        return $this->renderReturnJson(true, $arUserDashboardInfo, "We found " . $objCards->getData()->Count() . " users in this batch.", 200, "data", $strEnd);
    }

    public function getCustomerNewBatches(ExcellHttpModel $objData) : bool
    {
        $pageIndex  = $objData->Data->Params["offset"] ?? 1;
        $batchCount = $objData->Data->Params["batch"] ?? 500;
        $pageIndex  = ($pageIndex - 1) * $batchCount;
        $arFields   = explode(",", $objData->Data->Params["fields"]);
        $strEnd     = "false";

        $objWhereClause = "
            SELECT user.*,
            (SELECT platform_name FROM `excell_main`.`company` WHERE company.company_id = user.company_id LIMIT 1) AS platform,
            (SELECT url FROM `excell_media`.`image` WHERE image.entity_id = user.user_id AND image.entity_name = 'user' AND image_class = 'user-avatar' ORDER BY image_id DESC LIMIT 1) AS avatar,
            (SELECT COUNT(*) FROM `excell_main`.`card` cd WHERE cd.owner_id = user.user_id) AS cards
            FROM `user` ";

        $objWhereClause .= "WHERE user.company_id = {$this->app->objCustomPlatform->getCompanyId()} AND user.status != 'Deleted'";
        $objWhereClause .= " ORDER BY user.user_id DESC LIMIT {$pageIndex}, {$batchCount}";

        $objCards = Database::getSimple($objWhereClause, "user_id");

        if ($objCards->getData()->Count() < $batchCount)
        {
            $strEnd = "true";
        }

        $objCards->getData()->HydrateModelData(UserModel::class, true);

        $arUserDashboardInfo = array(
            "list" => $objCards->getData()->FieldsToArray($arFields),
        );

        return $this->renderReturnJson(true, $arUserDashboardInfo, "We found " . $objCards->getData()->Count() . " users in this batch.", 200, "data", $strEnd);
    }

    public function getCustomPlatformCustomerBatches(ExcellHttpModel $objData) : bool
    {
        $pageIndex  = $objData->Data->Params["offset"] ?? 1;
        $batchCount = $objData->Data->Params["batch"] ?? 500;
        $filterEntity = $objData->Data->Params["filterEntity"] ?? null;
        $pageIndex  = ($pageIndex - 1) * $batchCount;
        $arFields   = explode(",", $objData->Data->Params["fields"]);
        $strEnd     = "false";

        $objWhereClause = "
            SELECT user.*,
            (SELECT platform_name FROM `excell_main`.`company` WHERE company.company_id = user.company_id LIMIT 1) AS platform,
            (SELECT url FROM `excell_media`.`image` WHERE image.entity_id = user.user_id AND image.entity_name = 'user' AND image_class = 'user-avatar' ORDER BY image_id DESC LIMIT 1) AS avatar,
            (SELECT COUNT(*) FROM `excell_main`.`card` cd WHERE cd.owner_id = user.user_id) AS cards
            FROM `user` ";

        $objWhereClause .= "WHERE user.company_id = {$filterEntity}";
        $objWhereClause .= " ORDER BY user.user_id DESC LIMIT {$pageIndex}, {$batchCount}";

        $objCards = Database::getSimple($objWhereClause, "user_id");

        if ($objCards->getData()->Count() < $batchCount)
        {
            $strEnd = "true";
        }

        $objCards->getData()->HydrateModelData(UserModel::class, true);

        $arUserDashboardInfo = array(
            "list" => $objCards->getData()->FieldsToArray($arFields),
        );

        return $this->renderReturnJson(true, $arUserDashboardInfo, "We found " . $objCards->getData()->Count() . " users in this batch.", 200, "data", $strEnd);
    }

    public function getCustomerBatches(ExcellHttpModel $objData)
    {
        $intOffset = $objData->Data->Params["offset"];
        $strEnd = "false";

        $lstCustomers = (new Users())->getFks()->GetAllCustomers(1000, ($intOffset * 1000) - 750);

        if ($lstCustomers->getData()->Count() < 1000)
        {
            $strEnd = "true";
        }

        $arUserCardsIds = $lstCustomers->getData()->FieldsToArray(["user_id"]);
        $lstUserAvatars = (new Images())->getWhere([["entity_name" => "user", "image_class" => "user-avatar"], "AND", ["entity_id", "IN", $arUserCardsIds]]);
        $lstCustomers->getData()->MergeFields($lstUserAvatars->data,["url" => "main_image","thumb" => "main_thumb"],["entity_id" => "user_id"]);

        foreach($lstCustomers->data as $currCardId => $currCardData)
        {
            $lstCustomers->getData()->{$currCardId}->created_on = date("m/d/Y",strtotime($currCardData->created_on));
            $lstCustomers->getData()->{$currCardId}->last_updated = date("m/d/Y",strtotime($currCardData->last_updated));

            $lstCustomers->getData()->{$currCardId}->AddUnvalidatedValue("main_image", ($currCardData->main_image ?? "/_ez/images/users/defaultAvatar.jpg"));
            $lstCustomers->getData()->{$currCardId}->AddUnvalidatedValue("main_thumb", ($currCardData->main_thumb ?? "/_ez/images/users/defaultAvatar.jpg"));
        }

        $arUserDashboardInfo = array(
            "people" => $lstCustomers->getData()->CollectionToArray(),
        );

        $objJsonReturn = array(
            "success" => true,
            "message" => "We found " . $lstCustomers->getData()->Count() . " cards in this batch.",
            "end" => $strEnd,
            "data" => $arUserDashboardInfo,
        );

        die(json_encode($objJsonReturn));
    }


    public function getAffiliateDashboardInfo(ExcellHttpModel $objData) : bool
    {
        if(!$this->app->isUserLoggedIn() || !$this->app->isPortalWebsite())
        {
            $this->app->redirectToLogin();
        }

        $intUserId = $objData->Data->PostData->user_id;
        $blnUserViewFound = false;

        $objUserResult = (new Users())->getById($intUserId);

        if ($objUserResult->result->Count > 0)
        {
            $blnUserViewFound = true;
        }

        $objUser = $objUserResult->getData()->first();
        $lstUserCards = (new Cards())->GetCardsByAffiliateId($intUserId);

        $strCardMainImage = "/_ez/images/users/defaultAvatar.jpg";
        $strCardThumbImage = "/_ez/images/users/defaultAvatar.jpg";

        $objImageResult = (new Images())->noFks()->getWhere(["entity_id" => $intUserId, "image_class" => "user-avatar", "entity_name" => "user"],"image_id.DESC");

        if ($objImageResult->result->Success === true && $objImageResult->result->Count > 0)
        {
            $strCardMainImage = $objImageResult->getData()->first()->url;
            $strCardThumbImage = $objImageResult->getData()->first()->thumb;
        }

        $arUserCardsIds = $lstUserCards->getData()->FieldsToArray(["card_id"]);
        $lstCardImages = (new Images())->getWhere([["entity_name" => "card", "image_class" =>"main-image"], "AND", ["entity_id", "IN", $arUserCardsIds]]);
        $lstUserCards->getData()->MergeFields($lstCardImages->data,["url" => "main_image","thumb" => "main_thumb"],["entity_id" => "card_id"]);

        foreach($lstUserCards->data as $currCardId => $currCardData)
        {
            $lstUserCards->getData()->{$currCardId}->AddUnvalidatedValue("main_image", ($currCardData->main_image ?? "/_ez/templates/") . ($currCardData->template_id__value ?? "1") . "/images/mainImage.jpg");
            $lstUserCards->getData()->{$currCardId}->AddUnvalidatedValue("main_thumb", ($currCardData->main_thumb ?? "/_ez/templates/") . ($currCardData->template_id__value ?? "1") . "/images/mainImage.jpg");
        }

        if (!empty($objUser))
        {
            $objUser->AddUnvalidatedValue("main_image", $strCardMainImage);
            $objUser->AddUnvalidatedValue("main_thumb", $strCardThumbImage);
        }

        $arUserDashboardInfo = array(
            "user" => !empty($objUser) ? $objUser->ToArray() : "[]",
            "blnUserViewFound" => $blnUserViewFound,
            "cards" => $lstUserCards->getData()->CollectionToArray(),
        );

        $objJsonReturn = array(
            "success" => true,
            "message" => "We found information for user_id = " . $objData->Data->PostData->user_id . ".",
            "data" => $arUserDashboardInfo,
        );

        die(json_encode($objJsonReturn));
    }
}
