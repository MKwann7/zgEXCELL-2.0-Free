<?php

namespace Http\Users\Controllers;

use App\Utilities\Excell\ExcellHttpModel;
use App\Website\Vue\Classes\VueProps;
use Entities\Activities\Classes\UserLogs;
use Entities\Cards\Classes\Cards;
use Entities\Cards\Components\Vue\Maxtech\Purchase\PurchasePersonaWidget;
use Entities\Users\Components\Vue\CustomerMainApp;
use Entities\Media\Classes\Images;
use Entities\Notes\Classes\Notes;
use Entities\Users\Components\Vue\MyPersonasApp;
use Entities\Users\Components\Vue\PersonaWidget\ManagePersonaWidget;
use Http\Users\Controllers\Base\UserController;
use Entities\Users\Classes\UserClass;
use Entities\Users\Classes\Users;
use Entities\Users\Components\Vue\MyProfileApp;
use Entities\Users\Components\Vue\UserMainApp;
use Entities\Users\Components\Vue\UserWidget\ManageCustomerWidget;
use Entities\Users\Components\Vue\UserWidget\ManageUserWidget;

class IndexController extends UserController
{
    public function index(ExcellHttpModel $objData) : bool
    {
        if($this->app->isAdminUrlRequest())
        {
            if($this->app->isUserLoggedIn())
            {
                if( $this->app->strActivePortalBinding === "account/admin")
                {
                    // TODO - This needs to be fixed. Doesn't work.
                    switch ($this->AppEntity->strAliasName)
                    {
                        case "users":
                            $this->RenderUsersAdminList($objData);
                            break;
                        case "customers":
                            $this->RenderCustomersAdminList($objData);
                            break;
                        case "members":
                            $this->RenderAffiliatesAdminList($objData);
                            break;
                        case "personas":
                            $this->RenderPersonas($objData);
                            break;
                    }
                }
                elseif($this->app->strActivePortalBinding === "account")
                {
                    switch ($this->AppEntity->strAliasName)
                    {
                        case "profile":
                            $this->RenderProfile($objData);
                            break;
                        case "my-personas":
                            $this->RenderMyPersonas($objData);
                            break;
                    }

                    $this->app->redirectToLogin();
                }
                else
                {
                    $this->app->redirectToLogin();
                }
            }
            else
            {
                $this->app->redirectToLogin();
            }
        }
        else
        {
            $this->app->redirectToLogin();
        }

        return false;
    }

    public function old(ExcellHttpModel $objData) : bool
    {
        if($this->app->isAdminUrlRequest())
        {
            if($this->app->isUserLoggedIn())
            {
                if($this->app->strActivePortalBinding === "account/admin")
                {
                    $this->RenderOldCustomersAdminList($objData);
                }
            }
            else
            {
                $this->app->redirectToLogin();
            }
        }

        return false;
    }

    public function viewCustomer(ExcellHttpModel $objData) : bool
    {
        if($this->app->isAdminUrlRequest())
        {
            if($this->app->isUserLoggedIn())
            {
                if( $this->app->strActivePortalBinding === "account/admin")
                {
                    $this->RenderCustomersAdminList($objData, "view");
                }
                else
                {
                    $this->app->redirectToLogin();
                }
            }
            else
            {
                $this->app->redirectToLogin();
            }
        }
        else
        {
            $this->app->redirectToLogin();
        }

        return false;
    }

    private function RenderUsersAdminList(ExcellHttpModel $objData) : void
    {
        $vueApp = (new UserMainApp("vueApp"))
            ->setUriBase($objData->PathControllerBase)
            ->registerComponentAbstracts([
                ManageUserWidget::getStaticId() => ManageUserWidget::getStaticUriAbstract(),
            ]);

        (new Users())->renderApp(
            "admin.list_users",
            $this->app->strAssignedPortalTheme,
            $vueApp
        );
    }

    private function RenderCustomersAdminList(ExcellHttpModel $objData, $strApproach = "list") : void
    {
        $vueApp = (new CustomerMainApp("vueApp"))
            ->setUriBase($objData->PathControllerBase)
            ->registerComponentAbstracts([
                ManageCustomerWidget::getStaticId() => ManageCustomerWidget::getStaticUriAbstract(),
            ]);

        (new Users())->renderApp(
            "admin.view_users_new",
            $this->app->strAssignedPortalTheme,
            $vueApp
        );
    }

    private function RenderOldCustomersAdminList(ExcellHttpModel $objData, $strApproach = "list") : void
    {
        $lstCustomers = $this->AppEntity->GetAllCustomers(250);

        $arUserCardsIds = $lstCustomers->getData()->FieldsToArray(["user_id"]);
        $lstUserAvatars = (new Images())->getWhere([["entity_name" => "user", "image_class" => "user-avatar"], "AND", ["entity_id", "IN", $arUserCardsIds]]);
        $lstCustomers->getData()->MergeFields($lstUserAvatars->data,["url" => "main_image","thumb" => "main_thumb"],["entity_id" => "user_id"]);

        foreach($lstCustomers->Data as $currUserId => $currUserData)
        {
            $lstCustomers->getData()->{$currUserId}->created_on = date("m/d/Y",strtotime($currUserData->created_on));
            $lstCustomers->getData()->{$currUserId}->last_updated = date("m/d/Y",strtotime($currUserData->last_updated));

            $lstCustomers->getData()->{$currUserId}->AddUnvalidatedValue("main_image", ($currUserData->main_image ?? "/_ez/images/users/defaultAvatar.jpg"));
            $lstCustomers->getData()->{$currUserId}->AddUnvalidatedValue("main_thumb", ($currUserData->main_thumb ?? "/_ez/images/users/defaultAvatar.jpg"));
        }

        $objUser = null;
        $lstUserCards = null;
        $colUserClasses = null;
        $colUserAddresses = null;
        $colUserConnections = null;
        $objUserBusiness = null;
        $colUserActivities = null;
        $blnUserViewFound = false;

        if ( $strApproach === "view")
        {
            $intUserId = $objData->Data->Params["id"];

            $objUserResult = (new Users())->getFks(["user_phone", "user_email"])->getById($intUserId);

            if ($objUserResult->result->Count > 0)
            {
                $blnUserViewFound = true;
            }

            $objUser = $objUserResult->getData()->first();
            $lstUserCards = (new Cards())->getFks()->GetByUserId($intUserId);
            $colUserClasses = (new Users())->GetUserClassesByUserId($intUserId)->getData();
            $colUserAddresses = (new Users())->getFks()->GetAddressesByUserId($intUserId)->getData();
            $colUserConnections = (new Users())->getFks()->GetConnectionsByUserId($intUserId)->getData();
            $objUserBusiness = (new Users())->GetPrimaryBusinessByUserId($intUserId)->getData()->first();
            $colUserActivities = (new UserLogs())->GetUserActivity($intUserId)->getData();
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
                $lstUserCards->getData()->{$currCardId}-PurchaseSiteWidget>AddUnvalidatedValue("main_image", $currCardData->main_image ?? ("/_ez/templates/" . ($currCardData->template_id__value ?? "1")  . "/images/mainImage.jpg"));
                $lstUserCards->getData()->{$currCardId}->AddUnvalidatedValue("main_thumb", $currCardData->main_thumb ?? ("/_ez/templates/" . ($currCardData->template_id__value ?? "1") . "/images/mainImage.jpg"));
            }

            if (!empty($objUser))
            {
                $objUser->AddUnvalidatedValue("main_image", $strCardMainImage);
                $objUser->AddUnvalidatedValue("main_thumb", $strCardThumbImage);
            }
        }

        $this->AppEntity->renderAppPage("view_all_customers", $this->app->strAssignedPortalTheme, [
            "objActiveCustomers" => $lstCustomers,
            "strApproach" => $strApproach,
            "objUser" => $objUser,
            "blnUserViewFound" => $blnUserViewFound,
            "objUserBusiness" => $objUserBusiness,
            "colUserCards" => $lstUserCards->data,
            "colNotes" => $lstUserNotes->data,
            "colUserClasses" => $colUserClasses,
            "colUserAddresses" => $colUserAddresses,
            "colUserConnections" => $colUserConnections,
            "colUserActivities" => $colUserActivities,
        ]);
    }

    private function RenderAffiliatesAdminList(ExcellHttpModel $objData, $strApproach = "list") : void
    {
        $objActiveAffiliates = $this->AppEntity->GetAllActiveAffiliates();

        $objActiveAffiliates->getData()->ConvertDatesToFormat("m/d/Y");

        $arUserCardsIds = $objActiveAffiliates->getData()->FieldsToArray(["user_id"]);
        $lstUserAvatars = (new Images())->getWhere([["entity_name" => "user", "image_class" => "user-avatar"], "AND", ["entity_id", "IN", $arUserCardsIds]]);
        $objActiveAffiliates->getData()->MergeFields($lstUserAvatars->data,["url" => "main_image","thumb" => "main_thumb"],["entity_id" => "user_id"]);

        foreach($objActiveAffiliates->Data as $currUserId => $currUserData)
        {
            $objActiveAffiliates->getData()->{$currUserId}->created_on = date("m/d/Y",strtotime($currUserData->created_on));
            $objActiveAffiliates->getData()->{$currUserId}->last_updated = date("m/d/Y",strtotime($currUserData->last_updated));

            $objActiveAffiliates->getData()->{$currUserId}->AddUnvalidatedValue("main_image", ($currUserData->main_image ?? "/_ez/images/users/defaultAvatar.jpg"));
            $objActiveAffiliates->getData()->{$currUserId}->AddUnvalidatedValue("main_thumb", ($currUserData->main_thumb ?? "/_ez/images/users/defaultAvatar.jpg"));
        }

        if ( $strApproach === "view")
        {
            $intUserId = $objData->Data->Params["id"];
            $objUserResult = (new Users())->getById($intUserId);

            if ($objUserResult->result->Count > 0)
            {
                $blnUserViewFound = true;
            }

            $objUser = $objUserResult->getData()->first();

            $lstUserCards = (new Cards())->GetCardsByAffiliateId($intUserId);

            $arUserCardsIds = $lstUserCards->getData()->FieldsToArray(["card_id"]);
            $lstCardImages = (new Images())->getWhere([["entity_name" => "card", "image_class" =>"main-image"], "AND", ["entity_id", "IN", $arUserCardsIds]]);
            $lstUserCards->getData()->MergeFields($lstCardImages->data,["url" => "main_image","thumb" => "main_thumb"],["entity_id" => "card_id"]);

            foreach($lstUserCards->data as $currCardId => $currCardData)
            {
                $lstUserCards->getData()->{$currCardId}->AddUnvalidatedValue("main_image", ($currCardData->main_image ?? "/_ez/templates/" . $currCardData->template_id ?? "1"  . "/images/mainImage.jpg"));
                $lstUserCards->getData()->{$currCardId}->AddUnvalidatedValue("main_thumb", ($currCardData->main_thumb ?? "/_ez/templates/" . $currCardData->template_id ?? "1" . "/images/mainImage.jpg"));
            }
        }

        $this->AppEntity->renderAppPage("view_all_affiliates", $this->app->strAssignedPortalTheme,  [
            "objActiveAffiliates" => $objActiveAffiliates,
            "blnUserViewFound" => $blnUserViewFound,
            "strApproach" => $strApproach,
            "objUser" => $objUser,
            "colUserCards" => $lstUserCards->data
        ]);
    }

    private function RenderProfile(ExcellHttpModel $objData) : void
    {
        $vueApp = (new MyProfileApp("vueApp"))
            ->setUriBase($objData->PathControllerBase);

        (new Users())->renderApp(
            "admin.view_users_new",
            $this->app->strAssignedPortalTheme,
            $vueApp
        );
    }

    private function RenderPersonas(ExcellHttpModel $objData) : void
    {
        $vueApp = (new MyPersonasApp("vueApp"))
            ->setUriBase($objData->PathControllerBase);

        (new Users())->renderApp(
            "admin.view_users_personas",
            $this->app->strAssignedPortalTheme,
            $vueApp
        );
    }

    private function RenderMyPersonas(ExcellHttpModel $objData) : void
    {
        $vueApp = match ($objData->Uri[2] ?? "") {
            "purchase" => (new MyPersonasApp("vueApp"))
                ->setDefaultComponentId(PurchasePersonaWidget::getStaticId())->setDefaultComponentAction("view")
                ->setDefaultComponentProps([
                    new VueProps("productGroup", "string", "'persona'"),
                    new VueProps("inModal", "boolean", "false"),
                    new VueProps("loggedInUserId", "number", $this->app->getActiveLoggedInUser()->user_id),
                ])
                ->setUriBase($objData->PathControllerBase),
            default => (new MyPersonasApp("vueApp"))
                ->setUriBase($objData->PathControllerBase)
                ->registerComponentAbstracts([
                    ManagePersonaWidget::getStaticId() => ManagePersonaWidget::getStaticUriAbstract(),
                ]),
        };

        (new Users())->renderApp(
            "user.view_users_personas",
            $this->app->strAssignedPortalTheme,
            $vueApp
        );
    }

    public function impersonateUser(ExcellHttpModel $objData) : bool
    {
        if(!$this->app->isUserLoggedIn() || !$this->app->isPortalWebsite())
        {
            $objJsonReturn = array(
                "success" => false,
                "message" => "You must be logged in to use this functionality."
            );

            die(json_encode($objJsonReturn));
        }

        $objLoggedInUser = $this->app->getActiveLoggedInUser();
        $userRoleClass = $objLoggedInUser->Roles !== null ? ($objLoggedInUser->Roles->FindEntityByKey("user_class_type_id")->user_class_type_id ?? null) : null;

        if (
            !userIsEzDigital($userRoleClass) &&
            !userIsCustomPlatform($userRoleClass)
        )
        {
            $objJsonReturn = array(
                "success" => false,
                "message" => "Only an admin can impersonate another user"
            );

            die(json_encode($objJsonReturn));
        }

        $intUserId = $objData->Data->Params["user_id"];
        $objUserResult = (new Users())->getById($intUserId);

        if ($objUserResult->result->Count === 0 ) {
            $objJsonReturn = array(
                "success" => false,
                "message" => "This user requested for impersonation does not exist."
            );

            die(json_encode($objJsonReturn));
        }

        $objUser = $objUserResult->getData()->first();

        $objUserClassResult = (new UserClass())->getFks()->getWhere(["user_id" => $objUser->user_id]);

        if ($objUserClassResult->result->Success === true && $objUserClassResult->result->Count > 0)
        {
            if (
                !userIsEzDigital($userRoleClass) &&
                userIsCustomPlatform($userRoleClass)
            )
            {
                $objJsonReturn = array(
                    "success" => false,
                    "message" => "You cannot impersonate an admin."
                );

                die(json_encode($objJsonReturn));
            }
        }

        $intRandomId = rand(1000,9999);

        $this->app->objAppSession["Core"]["Account"]["Active"][$intRandomId] = array("user_id" => $objUser->user_id, "preferred_name" => $objUser->preferred_name, "username" => $objUser->username, "password" => $objUser->password,  "impersonate" => $objLoggedInUser->user_id, "start_time" => date("Y-m-d h:i:s", strtotime("now")));
        $this->app->objAppSession["Core"]["Account"]["Primary"] = $objUser->user_id;

        // TODO - Check to see if this was causing the user switch....
//        $strBrowserCookie = $this->app->objAppSession["Core"]["Session"]["Browser"];
//        $objBrowserCookieResult = VisitorBrowserModule->getWhere(["browser_cookie" => $strBrowserCookie]);
//
//        if ($objBrowserCookieResult->Result->Success === true)
//        {
//            $objBrowserCookie = $objBrowserCookieResult->getData()->first();
//            $objBrowserCookie->user_id = ($objUser->user_id);
//            VisitorBrowserModule::Update($objBrowserCookie);
//        }

        $this->app->setActiveLoggedInUser($objUser);

        $objJsonReturn = array(
            "success" => true,
            "message" => "You are now impersonating this user."
        );

        die(json_encode($objJsonReturn));
    }
}
