<?php

namespace Entities\Cards\Controllers;

use App\Utilities\Database;
use App\Utilities\Excell\ExcellCollection;
use App\Utilities\Excell\ExcellHttpModel;
use App\Utilities\Http\Http;
use App\Utilities\Transaction\ExcellTransaction;
use Entities\Cards\Classes\CardSocialMedia;
use Entities\Modules\Classes\AppInstanceRels;
use Entities\Modules\Classes\ModuleApps;
use Entities\Modules\Models\ModuleAppModel;
use Module\Orders\Models\OrderLineModel;
use Module\Orders\Models\OrderModel;
use Entities\Activities\Classes\UserLogs;
use Entities\Cards\Classes\Cards;
use Entities\Cards\Classes\Base\CardController;
use Entities\Cards\Classes\CardConnections;
use Entities\Cards\Classes\CardGroupsModule;
use Entities\Cards\Classes\CardRels;
use Entities\Cards\Classes\CardPageRels;
use Entities\Cards\Classes\CardPage;
use Entities\Cards\Classes\CardTemplates;
use Entities\Cards\Models\CardConnectionModel;
use Entities\Cards\Models\CardModel;
use Entities\Cards\Models\CardRelModel;
use Entities\Cards\Models\CardPageModel;
use Entities\Cards\Models\CardPageRelModel;
use Entities\Emails\Classes\Emails;
use Entities\Media\Classes\Images;
use Entities\Mobiniti\Classes\MobinitiContacts;
use Entities\Mobiniti\Models\MobinitiContactModel;
use Entities\Mobiniti\Models\MobinitiMessageModel;
use Entities\Orders\Classes\OrderLines;
use Entities\Orders\Classes\Orders;
use Entities\Products\Classes\Products;
use Entities\Users\Classes\Connections;
use Entities\Users\Classes\UserAddress;
use Entities\Users\Classes\Users;
use Entities\Users\Models\ConnectionModel;
use Entities\Users\Models\UserAddressModel;
use Vendors\Mobiniti\Main\V100\Classes\MobinitiMessagesApiModule;

class CardDataController extends CardController
{
    public function index(ExcellHttpModel $objData): void
    {
        die('{"success":true,"message":"we made it."}');
    }

    public function getCardDashboardInfo(ExcellHttpModel $objData): void
    {
        //        if (!$this->app->isUserLoggedIn() || !$this->app->isPortalWebsite())
        //        {
        //            $this->app->redirectToLogin();
        //        }

        $intCardId = $objData->Data->PostData->card_id;

        if (empty($intCardId))
        {
            die('{"result":{"success":false, "message": "No card id passed in."}}');
        }

        $colCardDisplayConnections = new ExcellCollection;
        $blnCardViewFound          = false;

        $objCardResult = (new Cards())->getFks([
            "card_type_id",
            "template_id",
            "product_id"
        ]
        )->getById($intCardId);

        if ($objCardResult->Result->Count > 0)
        {
            $blnCardViewFound = true;
        }

        $objCard         = $objCardResult->Data->First();
        $objCardTemplate = (new CardTemplates())->getById($objCard->template_id__value)->Data->First();
        $colCardPages    = (new CardPage())->getFks()->GetByCardId($intCardId);
        $colCardPages->Data->ConvertDatesToFormat("m/d/Y");
        $colCardPages->Data->AssignCustomFieldsForAdminList($objCard);
        $colCardPages->Data->SortBy("rel_sort_order", "ASC");
        $colCardUsers = (new Users())->GetByCardId($intCardId);
        $objOwner     = (new Users())->getById($objCard->owner_id)->Data->First();
        //$colCardUsers->Data->DeleteEntityByValue("user_id", $this->app->$intActiveUserId);
        $colCardConnections = (new Cards())->getFks()->GetConnectionsByCardId($intCardId)->Data;

        for ($intConnectionIndex = 1; $intConnectionIndex <= $objCardTemplate->data->connections->count; $intConnectionIndex++)
        {
            $objConnection = $colCardConnections->FindEntityByValue("display_order", $intConnectionIndex);

            if ($objConnection !== null)
            {
                $objConnection->connection_value = formatAsPhoneIfApplicable($objConnection->connection_value);
                $colCardDisplayConnections->Add($intConnectionIndex, $objConnection);
            }
            else
            {
                $objBlankConnection = new CardConnectionModel();
                $objBlankConnection->AddUnvalidatedValue('display_order', $intConnectionIndex);
                $objBlankConnection->AddUnvalidatedValue('connection_type_id', 'blank');
                $colCardDisplayConnections->Add($intConnectionIndex, $objBlankConnection);
            }
        }

        $strCardMainImage    = "/_ez/templates/" . ($objCard->template_id__value ?? "1") . "/images/mainImage.jpg";
        $strCardThumbImage   = "/_ez/templates/" . ($objCard->template_id__value ?? "1") . "/images/mainImage.jpg";
        $strCardFaviconImage = $strCardMainImage;
        $strCardFaviconIco   = "/_ez/templates/" . ($objCard->template_id__value ?? "1") . "/images/mainImage.ico";

        $objImageResult   = (new Images())->noFks()->getWhere([
            "entity_id"   => $intCardId,
            "image_class" => "main-image",
            "entity_name" => "card"
        ], "image_id.DESC"
        );
        $objFaviconResult = (new Images())->noFks()->getWhere([
            "entity_id"   => $intCardId,
            "image_class" => "favicon-image",
            "entity_name" => "card"
        ], "image_id.DESC"
        );

        if ($objImageResult->Result->Success === true && $objImageResult->Result->Count > 0)
        {
            $strCardMainImage  = $objImageResult->Data->First()->url;
            $strCardThumbImage = $objImageResult->Data->First()->thumb;
        }

        if ($objFaviconResult->Result->Success === true && $objFaviconResult->Result->Count > 0)
        {
            $strCardFaviconImage = $objFaviconResult->Data->First()->url;
            $strCardFaviconIco   = $objFaviconResult->Data->First()->thumb;
        }

        if (!empty($objCard))
        {
            $objCard->AddUnvalidatedValue("card_image", $strCardMainImage);
            $objCard->AddUnvalidatedValue("card_thumb", $strCardThumbImage);
            $objCard->AddUnvalidatedValue("favicon_image", $strCardFaviconImage);
            $objCard->AddUnvalidatedValue("favicon_ico", $strCardFaviconIco);
            $objCard->AddUnvalidatedValue("card_primary_color", $objCard->card_data->style->card->color->main ?? "FF0000");
            $objCard->AddUnvalidatedValue("card_width", $objCard->card_data->style->card->width ?? "400");
            $objCard->AddUnvalidatedValue("card_tab_height", $objCard->card_data->style->tab->height ?? "55");
        }

        //$colCardContacts = ContactsModule::GetByCardId($intCardId)->Data;
        $colCardContacts = (new MobinitiContacts())->GetByCardId($intCardId)->Data;

        $arUserDashboardInfo = array(
            "card"             => !empty($objCard) ? $objCard->ToArray() : "[]",
            "blnCardViewFound" => $blnCardViewFound,
            "cardTabs"         => $colCardPages->Data->CollectionToArray(),
            "cardUsers"        => $colCardUsers->Data->CollectionToArray(),
            "cardContacts"     => $colCardContacts->CollectionToArray(),
            "owner"            => $objOwner->ToArray(),
            "cardConnections"  => $colCardDisplayConnections->CollectionToArray(),
        );

        $objJsonReturn = array(
            "success" => true,
            "message" => "We found information for card_id = " . $objData->Data->PostData->card_id . ".",
            "data"    => $arUserDashboardInfo,
        );

        $this->renderReturnJson(true, $arUserDashboardInfo, "We found information for card_id = " . $objData->Data->PostData->card_id . ".");
    }

    public function getCardGroupDashboardInfo(ExcellHttpModel $objData): void
    {
        if (!$this->app->isUserLoggedIn() || !$this->app->isPortalWebsite())
        {
            $this->app->redirectToLogin();
        }

        $intCardGroupId = $objData->Data->PostData->card_group_id;

        require AppEntities . "cards/classes/card_group.class" . XT;

        $objCardGroup     = (new CardGroupsModule())->getFks()->getById($intCardGroupId);
        $colCardGroupUser = (new Users())->getFks()->GetUsersByCardGroupId($intCardGroupId);
        $objCards         = (new Cards())->getFks()->GetCardByGroupId($intCardGroupId);

        $arCards = $objCards->Data->CollectionToArray();
        $objCard = array_shift($arCards);

        $arUserDashboardInfo = array(
            "cardGroup"      => $objCardGroup->Data->CollectionToArray(),
            "cardGroupUsers" => $colCardGroupUser->Data->CollectionToArray(),
            "card"           => $objCard,
        );

        $objJsonReturn = array(
            "success" => true,
            "message" => "We found information for card_group_id = " . $objData->Data->PostData->card_group_id . ".",
            "data"    => $arUserDashboardInfo,
        );

        die(json_encode($objJsonReturn));
    }

    private function log ($strClassName, $strLogText): void
    {
        if ($strClassName === "editConnection")
        {
            logText("LoadModule.Process.log", $strLogText);
        }
    }

    public function getCardDashboardViews(ExcellHttpModel $objData): void
    {
        if (!$this->app->isUserLoggedIn() || !$this->app->isPortalWebsite())
        {
            $this->app->redirectToLogin();
        }

        $strViewTitle = $objData->Data->PostData->view;

        $strView = (new Cards())->getView("component.manage_card_data", $this->app->strAssignedPortalTheme, [
            "strViewTitle" => $strViewTitle,
            "app"          => $this->app
        ]
        );

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
            "view"    => $strViewTitle,
            "message" => "We found the requested view.",
            "data"    => $arDataReturn,
        );

        die(json_encode($objJsonReturn));
    }

    public function getCardGroupDashboardViews(ExcellHttpModel $objData): void
    {
        if (!$this->app->isUserLoggedIn() || !$this->app->isPortalWebsite())
        {
            $this->app->redirectToLogin();
        }

        $strViewTitle = $objData->Data->PostData->view;

        $strView = (new Cards())->getView("component.manage_card_group_data", $this->app->strAssignedPortalTheme, ["strViewTitle" => $strViewTitle]);

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
            "data"    => $arDataReturn,
        );

        die(json_encode($objJsonReturn));
    }

    public function getCardTab(ExcellHttpModel $objData)
    {
        $objParamsForSync = $this->app->objHttpRequest->Data->Params;

        if (!$this->validate($objParamsForSync, [
            "card_tab_id" => "required|integer",
        ]
        ))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $objCardPage       = new CardPage();
        $objCardPageResult = $objCardPage->getById($objParamsForSync["card_tab_id"]);

        return $this->renderReturnJson($objCardPageResult->Result->Success, $objCardPageResult->Data->ToPublicArray(), $objCardPageResult->Result->Message);
    }

    public function getCardPageData(ExcellHttpModel $objData)
    {
        // Return Vue Object for Module Configuration.
        if (!$this->validateRequestType('GET'))
        {
            return false;
        }

        $objParamsForSync = $this->app->objHttpRequest->Data->Params;

        if (!$this->validate($objParamsForSync, [
            "card_tab_rel_id" => "required|integer",
            "card_id"         => "required|integer"
        ]
        ))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $intCardPageRelId = $objData->Data->Params["card_tab_rel_id"];
        $intCardId        = $objData->Data->Params["card_id"];

        $objCardPageRelResult = (new CardPageRels())->getCardPageAndRelWithWidgetByRelId($intCardPageRelId);
        $intCardPageId        = $objCardPageRelResult->Data->First()->card_tab_id;

        $strContent = "";

        if (!empty($objCardPageRelResult->Data->First()->__app))
        {
            $strContent = $this->RenderCardPageWidgetData($intCardId, $objCardPageRelResult->Data->First());
        }
        elseif ($objCardPageRelResult->Data->First()->card_tab_type_id !== 2)
        {
            $strContent = $this->RenderCardPageContentData($intCardId, $objCardPageRelResult->Data->First());
        }
        else
        {
            $strContent = $this->RenderCardPageClassData($intCardId, $objCardPageRelResult->Data->First());
        }

        if ($strContent === "")
        {
            $strContent = base64_encode("<p>Content coming soon!</p>");
        }

        $objJsonReturn = array(
            "tab_id"  => $objCardPageRelResult->Data->First()->card_tab_id,
            "content" => $strContent,
        );

        return $this->renderReturnJson(true, $objJsonReturn, "Card page # " . $intCardPageId . " was found in the system.");
    }

    protected function RenderCardPageWidgetData(int $intCardId, CardPageRelModel $objCardPageRel): string
    {
        $objModuleApps        = new ModuleApps();
        $objConfigurationResults = $objModuleApps->getLatestWidgetContentForPage($intCardId, $objCardPageRel);

        if ($objConfigurationResults->Result->Success === false)
        {
            return base64_encode("Drat. There was an error loading this page: " . $objConfigurationResults->Result->Message);
        }

        $response = $objConfigurationResults->Data;

        if (empty($response->data) || empty($response->data->type) || empty($response->data->content))
        {
            return base64_encode("Oops! This page has no content to display!");
        }

        if (($response->data->type ?? "") === "vue") { return ""; }

        return base64_encode($response->data->content);
    }

    protected function RenderCardPageContentData(int $intCardId, CardPageRelModel $objCardPageRel): string
    {
        /** @var CardModel $objCard */
        $objCard  = (new Cards())->getById($intCardId)->Data->First()->LoadCardOwner()->LoadCardAddress();
        $objOwner = (new Users())->getById($objCard->owner_id)->Data->First();

        return (new CardPage)->ReplaceCarotsWithCustomerData($objCardPageRel->content, $objCard, $objOwner, $objCard->Connections, $objCard->Addresses);
    }

    protected function RenderCardPageClassData(int $intCardId, CardPageRelModel $objCardPageRel): string
    {
        $objTabControllerClass = $objCardPageRel->content;

        $arContentClass       = explode("_", $objTabControllerClass);
        $intControllerRequest = buildUnderscoreLowercaseFromPascalCase(str_replace("Controller", "", $arContentClass[1]));

        $strControllerPath = PublicData . "_ez/tabs/v1/controllers/" . $intControllerRequest . "Controller" . XT;

        if (is_file($strControllerPath))
        {
            require($strControllerPath);

            $objTabController = new $objTabControllerClass($this->app);

            /** @var CardModel $objCard */
            $objCard     = (new Cards())->getById($intCardId)->Data->First()->LoadCardOwner()->LoadCardAddress();
            $objCardData = (new CardPage)->getById($objCardPageRel->card_tab_id)->Data->First();

            return base64_encode($objTabController->render($objCardPageRel, $objCardData, $objCard));
        }

        return base64_encode($strControllerPath);
    }

    public function emailCardToAddress(ExcellHttpModel $objData)
    {
        $intCardId     = $objData->Data->PostData->card_id;
        $objCardResult = (new Cards())->getById($intCardId);

        if ($objCardResult->Result->Count === 0)
        {
            die('{"success":false,"message":"' . $objCardResult->Result->Message . '"}');
        }

        $objCard = $objCardResult->Data->First();
        $objCard->LoadCardOwner();

        $strCustomMessage = $objData->Data->PostData->msg ?? "";

        $strEmailFullName = $objData->Data->PostData->email ?? "";
        $strUserEmail     = $objData->Data->PostData->email ?? "";
        $strSubject       = $objCard->Owner->first_name . "'s Digital Business Card.";
        $strBody          = "<p><a href='" . getFullUrl() . "/" . $objCard->card_num . "'>Click here</a> to open " . $objCard->Owner->first_name . " " . $objCard->Owner->last_name . "'s Digital Card.</p>" . (!empty($strCustomMessage) ? "<p>Message: {$strCustomMessage}</p>" : "");

        (new Emails())->SendEmail("EZcard Sharing <sharing@ezcard.com>", ["{$strEmailFullName} <{$strUserEmail}>"], $strSubject, $strBody
        );

        die('{"success":true}');
    }

    public function getCardNewBatches(ExcellHttpModel $objData) : bool
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

        $objWhereClause = (new Cards())->buildCardBatchWhereClause($filterIdField, $filterEntity);

        $objWhereClause .= " LIMIT {$pageIndex}, {$batchCount}";

        $objCards = Database::getSimple($objWhereClause, "card_id");

        if ($objCards->Data->Count() < $batchCount)
        {
            $strEnd = "true";
        }

        $objCards->Data->HydrateModelData(CardModel::class, true);

        $arUserDashboardInfo = array(
            "list" => $objCards->Data->FieldsToArray($arFields),
            "query" => $objWhereClause,
        );

        return $this->renderReturnJson(true, $arUserDashboardInfo, "We found " . $objCards->Data->Count() . " cards in this batch.", 200, "data", $strEnd);
    }

    public function getCustomPlatformCardBatches(ExcellHttpModel $objData) : bool
    {
        $pageIndex  = $objData->Data->Params["offset"] ?? 1;
        $batchCount = $objData->Data->Params["batch"] ?? 500;
        $filterEntity = $objData->Data->Params["filterEntity"] ?? null;
        $pageIndex  = ($pageIndex - 1) * $batchCount;
        $arFields   = explode(",", $objData->Data->Params["fields"]);
        $strEnd     = "false";

        $objWhereClause = "
            SELECT card.*,
            (SELECT platform_name FROM `ezdigital_v2_main`.`company` WHERE company.company_id = card.company_id LIMIT 1) AS platform, 
            (SELECT url FROM `ezdigital_v2_media`.`image` WHERE image.entity_id = card.card_id AND image.entity_name = 'card' AND image_class = 'main-image' ORDER BY image_id DESC LIMIT 1) AS banner, 
            (SELECT thumb FROM `ezdigital_v2_media`.`image` WHERE image.entity_id = card.card_id AND image.entity_name = 'card' AND image_class = 'favicon-image' ORDER BY image_id DESC LIMIT 1) AS favicon,
            (SELECT CONCAT(user.first_name, ' ', user.last_name) FROM `ezdigital_v2_main`.`user` WHERE user.user_id = card.owner_id LIMIT 1) AS card_owner_name,
            (SELECT CONCAT(user.first_name, ' ', user.last_name) FROM `ezdigital_v2_main`.`user` WHERE user.user_id = card.card_user_id LIMIT 1) AS card_user_name,
            (SELECT title FROM `ezdigital_v2_main`.`product` WHERE product.product_id = card.product_id LIMIT 1) AS product, 
            (SELECT COUNT(*) FROM `ezdigital_v2_main`.`mobiniti_contact_group_rel` mcgr WHERE mcgr.card_id = card.card_id) AS card_contacts
            FROM `card` ";

        $objWhereClause .= "WHERE card.company_id = {$filterEntity}";
        $objWhereClause .= " AND (card.template_card = 0) ";
        $objWhereClause .= " GROUP BY(card.card_id) ORDER BY card.card_num DESC LIMIT {$pageIndex}, {$batchCount}";

        $objCards = Database::getSimple($objWhereClause, "card_id");

        if ($objCards->Data->Count() < $batchCount)
        {
            $strEnd = "true";
        }

        $objCards->Data->HydrateModelData(CardModel::class, true);

        $arUserDashboardInfo = array(
            "list" => $objCards->Data->FieldsToArray($arFields),
            "query" => $objWhereClause,
        );

        return $this->renderReturnJson(true, $arUserDashboardInfo, "We found " . $objCards->Data->Count() . " cards in this batch.", 200, "data", $strEnd);
    }

    public function getCardBatches(ExcellHttpModel $objData)
    {
        $intOffset = $objData->Data->Params["offset"];
        $strEnd    = "false";

        $lstUserCards = (new Cards())->selectFields([
            "card_id",
            "owner_id",
            "card_type_id",
            "card_name",
            "status",
            "template_card",
            "product_id",
            "template_id",
            "card_vanity_url",
            "card_num",
            "created_on",
            "last_updated"
        ]
        )->getFks([
                "card_type_id",
                "template_id",
                "product_id"
            ]
            )->getRelations([
                "main_image",
                "main_thumb",
                "card_owner",
                "card_mobiniti_contacts"
            ]
            )->GetAllCardsForDisplay(1000, ($intOffset * 1000) - 750);

        if ($lstUserCards->Data->Count() < 1000)
        {
            $strEnd = "true";
        }

        foreach ($lstUserCards->Data as $currCardId => $currCardData)
        {
            $strPackageId = (empty($currCardData->product_id) || $currCardData->product_id === 0) ? "Unset" : $currCardData->product_id;
            $lstUserCards->Data->{$currCardId}->AddUnvalidatedValue("product_id", $strPackageId);

            $lstUserCards->Data->{$currCardId}->created_on   = date("m/d/Y", strtotime($currCardData->created_on));
            $lstUserCards->Data->{$currCardId}->last_updated = date("m/d/Y", strtotime($currCardData->last_updated));

            if (empty($currCardData->main_image))
            {
                $lstUserCards->Data->{$currCardId}->AddUnvalidatedValue("main_image", "/_ez/templates/" . ($currCardData->template_id__value ?? "1") . "/images/mainImage.jpg");
            }

            if (empty($currCardData->main_thumb))
            {
                $lstUserCards->Data->{$currCardId}->AddUnvalidatedValue("main_thumb", "/_ez/templates/" . ($currCardData->template_id__value ?? "1") . "/images/mainImage.jpg");
            }
        }

        $arUserDashboardInfo = array(
            "cards" => $lstUserCards->Data->FieldsToArray([
                "card_id",
                "owner_id",
                "card_type_id",
                "card_name",
                "status",
                "template_card",
                "product_id",
                "template_id",
                "card_vanity_url",
                "card_num",
                "card_contacts",
                "main_thumb",
                "card_owner_name",
                "created_on",
                "last_updated"
            ]
            ),
        );

        $objJsonReturn = array(
            "success" => true,
            "message" => "We found " . $lstUserCards->Data->Count() . " cards in this batch.",
            "end"     => $strEnd,
            "data"    => $arUserDashboardInfo,
        );

        die(json_encode($objJsonReturn));
    }

    public function getCardLibraryTabBatches(ExcellHttpModel $objData)
    {
        $intOffset = $objData->Data->Params["offset"];
        $arFields  = explode(",", $objData->Data->Params["fields"]);
        $strEnd    = "false";
        $companyId = $this->app->objCustomPlatform->getCompanyId();

        $lstLibraryTabs = (new CardPage())->getFks()->getBatchWhere([
            "library_tab" => true,
            "company_id"  => $companyId
        ], 1000, $intOffset
        );

        if ($lstLibraryTabs->Data->Count() < 1000)
        {
            $strEnd = "true";
        }

        $objModuleApp = new AppInstanceRels();
        $objCardWidgets = $objModuleApp->getByPageIds($lstLibraryTabs->Data->FieldsToArray(["card_tab_id"]));

        $lstLibraryTabs->Data->HydrateChildModelData("__app", ["card_page_rel_id" => "card_tab_rel_id"], $objCardWidgets->Data, true);

        $arUserDashboardInfo = array(
            "list" => $lstLibraryTabs->Data->FieldsToArray($arFields),
        );

        return $this->renderReturnJson(true, $arUserDashboardInfo, "We found " . $lstLibraryTabs->Data->Count() . " cards in this batch.", 200, "data", $strEnd);
    }

    public function createCardData(ExcellHttpModel $objData)
    {
        $strUpdateType = $objData->Data->Params["type"];

        switch ($strUpdateType)
        {
            case "addProfile":

                $objLoggedInUser  = $this->app->getActiveLoggedInUser();
                $objCurrentUser   = (new Users())->getById($objLoggedInUser->user_id)->Data->First();
                $objPackageResult = (new Products())->getById($objData->Data->PostData->product_id ?? 0);
                $intAffiliateId   = $objLoggedInUser->sponsor_id;

                if ($objPackageResult->Result->Success === false)
                {
                    $objJsonReturn = array(
                        "success" => false,
                        "message" => "An error occured during user update: " . $objPackageResult->Result->Message . "."
                    );

                    die(json_encode($objJsonReturn));
                }

                $objPackage = $objPackageResult->Data->First();

                $objCardNumCheck = (new Cards())->getWhere(null, "card_num.DESC", 1)->Data->First();
                $intNewCardNum   = $objCardNumCheck->card_num + 1;

                $objCardCreate                = new CardModel($objData->Data->PostData);
                $objCardCreate->owner_id      = $objData->Data->PostData->card_owner;
                $objCardCreate->company_id    = $this->app->objCustomPlatform->getCompanyId();
                $objCardCreate->division_id   = 0;
                $objCardCreate->template_id   = $objData->Data->PostData->template_id;
                $objCardCreate->template_card = ExcellFalse;
                $objCardCreate->card_type_id  = 1;
                $objCardCreate->card_num      = $intNewCardNum;
                $objCardCreate->created_by    = $objLoggedInUser->user_id;
                $objCardCreate->updated_by    = $objLoggedInUser->user_id;
                $objCardCreate->created_on    = date("Y-m-d H:i:s");
                $objCardCreate->last_updated  = date("Y-m-d H:i:s");

                $objOrderModel = new OrderModel();

                $objOrderModel->user_id      = $objData->Data->PostData->card_owner;
                $objOrderModel->total_price  = 0;
                $objOrderModel->title        = $objCurrentUser->first_name . " " . $objCurrentUser->last_name . " EZcard Purchase on " . date("Y-m-d");
                $objOrderModel->status       = "Complete";
                $objOrderModel->created_by   = $objLoggedInUser->user_id;
                $objOrderModel->created_on   = date("Y-m-d H:i:s");
                $objOrderModel->updated_by   = $objLoggedInUser->user_id;
                $objOrderModel->last_updated = date("Y-m-d H:i:s");
                $objOrderModel->closed_by    = $objLoggedInUser->user_id;
                $objOrderModel->closed_date  = date("Y-m-d H:i:s");

                $objNewOrderCreationResult = (new Orders())->createNew($objOrderModel);

                if ($objNewOrderCreationResult->Result->Success === false)
                {
                    $objJsonReturn = array(
                        "success" => false,
                        "message" => "An error occured during user update: " . $objNewOrderCreationResult->Result->Message . "."
                    );

                    die(json_encode($objJsonReturn));
                }

                $objNewOrderCreation = $objNewOrderCreationResult->Data->First();

                $objOrderLineModel = new OrderLineModel();

                $objOrderLineModel->order_id     = $objNewOrderCreation->order_id;
                $objOrderLineModel->product_id   = $objPackage->product_id;
                $objOrderLineModel->user_id      = $objData->Data->PostData->card_owner;
                $objOrderLineModel->price        = 0;
                $objOrderLineModel->title        = $objCurrentUser->first_name . " " . $objCurrentUser->last_name . " EZcard " . $objPackage->title;
                $objOrderLineModel->status       = "Active";
                $objOrderLineModel->created_by   = $objLoggedInUser->user_id;
                $objOrderLineModel->created_on   = date("Y-m-d H:i:s");
                $objOrderLineModel->updated_by   = $objLoggedInUser->user_id;
                $objOrderLineModel->last_updated = date("Y-m-d H:i:s");
                $objOrderLineModel->closed_by    = $objLoggedInUser->user_id;
                $objOrderLineModel->closed_date  = date("Y-m-d H:i:s");

                $objNewOrderLineCreationResult = (new OrderLines())->createNew($objOrderLineModel);

                if ($objNewOrderLineCreationResult->Result->Success === false)
                {
                    $objJsonReturn = array(
                        "success" => false,
                        "message" => "An error occured during user update: " . $objNewOrderLineCreationResult->Result->Message . "."
                    );

                    die(json_encode($objJsonReturn));
                }

                $objNewOrderLineCreation = $objNewOrderLineCreationResult->Data->First();

                $objCardCreate->order_line_id = $objNewOrderLineCreation->order_line_id;

                try
                {
                    $objCardCreationResult = (new Cards())->createNew($objCardCreate);

                    if ($objCardCreationResult->Result->Success === false)
                    {
                        $objJsonReturn = array(
                            "success" => false,
                            "message" => "An error occured during user update: " . $objCardCreationResult->Result->Message . "."
                        );

                        die(json_encode($objJsonReturn));
                    }

                    $objCardCreation = $objCardCreationResult->Data->First();

                    $objCardAffiliateModel                   = new CardRelModel();
                    $objCardAffiliateModel->card_id          = $objCardCreation->card_id;
                    $objCardAffiliateModel->user_id          = $intAffiliateId;
                    $objCardAffiliateModel->status           = "Active";
                    $objCardAffiliateModel->card_rel_type_id = 9;
                    $objCardAffiliateModel->created_on       = date("Y-m-d H:i:s");
                    $objCardAffiliateModel->created_by       = $objLoggedInUser->user_id;

                    $objCardAffiateCreationResult = (new CardRels())->createNew($objCardAffiliateModel);

                    if ($objCardAffiateCreationResult->Result->Success === false)
                    {
                        $objJsonReturn = array(
                            "success" => false,
                            "message" => "An error occured during user update: " . $objCardAffiateCreationResult->Result->Message . "."
                        );

                        die(json_encode($objJsonReturn));
                    }

                    $objCardCreationResult->Data->{$objCardCreation->card_id}->AddUnvalidatedValue("main_image", "/_ez/templates/" . $objData->Data->PostData->template_id . "/images/mainImage.jpg");
                    $objCardCreationResult->Data->{$objCardCreation->card_id}->AddUnvalidatedValue("main_thumb", "/_ez/templates/" . $objData->Data->PostData->template_id . "/images/mainImage.jpg");

                    $arNewCardCreationResult = $objCardCreationResult->Data->FieldsToArray([
                        "main_image",
                        "main_thumb",
                        "card_id",
                        "card_num",
                        "card_name",
                        "user_id",
                        "card_vanity_url",
                        "card_type_id",
                        "status",
                        "sponsor_id",
                        "product_id",
                        "main_thumb",
                        "created_on",
                        "last_updated"
                    ]
                    );

                    $objUserSearchResult = [
                        "card" => $arNewCardCreationResult[$objCardCreation->card_id]
                    ];

                    $objJsonReturn = [
                        "success" => true,
                        "data"    => $objUserSearchResult
                    ];

                    logText("CreateNewCardAdmin.Process.log", "DATA: " . json_encode($objJsonReturn));

                    die(json_encode($objJsonReturn));
                }
                catch (\Exception $exception)
                {
                    $objJsonReturn = array(
                        "success" => false,
                        "message" => "An error occured during user update: " . json_encode($exception) . "."
                    );

                    die(json_encode($objJsonReturn));
                }

                break;
        }
    }

    public function updateCardData(ExcellHttpModel $objData)
    {
        $intCardId       = $objData->Data->Params["id"];
        $objCard         = null;
        $objLoggedInUser = $this->app->getActiveLoggedInUser();

        if (empty($objData->Data->PostData->no_card_id))
        {
            if (empty($intCardId))
            {
                $objJsonReturn = array(
                    "success" => false,
                    "message" => "A valid card id must be included in this update reqest."
                );

                logText("CardData.UpdateCardData.Error.log", json_encode($objJsonReturn));

                die(json_encode($objJsonReturn));
            }

            $objCardResult = (new Cards())->noFks()->getById($intCardId);

            if ($objCardResult->Result->Success === false || $objCardResult->Result->Count === 0)
            {
                $objJsonReturn = array(
                    "success" => false,
                    "message" => "A valid card id must be included in this update reqest."
                );

                logText("CardData.UpdateCardData.Error.log", json_encode($objJsonReturn));

                die(json_encode($objJsonReturn));
            }

            $objCard = $objCardResult->Data->First();
        }

        $strUpdateType = $objData->Data->Params["type"];

        switch ($strUpdateType)
        {
            case "profile":
            case "editProfileAdmin":
            case "account":

                if (!empty($objData->Data->PostData->card_vanity_url))
                {
                    $strVanityUrl            = $objData->Data->PostData->card_vanity_url;
                    $objVanityUrlCheckResult = (new Cards())->getWhere([
                        [
                            "card_vanity_url",
                            "=",
                            $strVanityUrl
                        ],
                        "AND",
                        [
                            "card_id",
                            "!=",
                            $intCardId
                        ]
                    ]
                    );

                    if ($objVanityUrlCheckResult->Result === true && $objVanityUrlCheckResult->Result->Count > 0)
                    {
                        $objJsonReturn = array(
                            "success" => false,
                            "message" => "This Vanity URL Already Exists."
                        );

                        die(json_encode($objJsonReturn));
                    }
                }
                else
                {
                    $objData->Data->PostData->card_vanity_url = ExcellNull;
                }

                if (!empty($objData->Data->PostData->card_keyword))
                {
                    $strCardKeyword            = $objData->Data->PostData->card_keyword;
                    $objCardKeywordCheckResult = (new Cards())->getWhere([
                        [
                            "card_keyword",
                            "=",
                            $strCardKeyword
                        ],
                        "AND",
                        [
                            "card_id",
                            "!=",
                            $intCardId
                        ]
                    ]
                    );

                    if ($objCardKeywordCheckResult->Result === true && $objCardKeywordCheckResult->Result->Count > 0)
                    {
                        $objJsonReturn = array(
                            "success" => false,
                            "message" => "This Keyword Already Exists."
                        );

                        die(json_encode($objJsonReturn));
                    }
                }
                else
                {
                    $objData->Data->PostData->card_keyword = ExcellNull;
                }

                $objCardUpdate           = new CardModel($objData->Data->PostData);
                $objCardUpdate->card_id  = $intCardId;
                $objCardUpdate->owner_id = $objData->Data->PostData->card_owner ?? $objCard->owner_id;

                try
                {
                    $objCardProfileUpdateResult = (new Cards())->update($objCardUpdate);
                    $objResult                  = $objCardProfileUpdateResult->Data->First();

                    (new UserLogs())->RegisterActivity($objLoggedInUser->user_id, "updated_card", "Card Updated Successfully", "card", $intCardId);

                    $objOwner      = (new Users())->getById($objCardUpdate->owner_id)->Data->First();
                    $objJsonReturn = [
                        "success" => true,
                        "card"    => $objResult->ToArray([
                            "card_name",
                            "card_vanity_url"
                        ]
                        ),
                        "owner"   => $objOwner->ToArray([
                            "first_name",
                            "last_name",
                            "user_id"
                        ]
                        )
                    ];

                    die(json_encode($objJsonReturn));
                }
                catch (\Exception $exception)
                {
                    $objJsonReturn = array(
                        "success" => false,
                        "message" => "An error occured during user update: " . json_encode($exception) . "."
                    );

                    die(json_encode($objJsonReturn));
                }

                break;

            case "connection":

                $intConnectionId = $objData->Data->Params["connection_id"];

                $objConnectionUpdate                = new ConnectionModel($objData->Data->PostData);
                $objConnectionUpdate->connection_id = $intConnectionId;

                try
                {
                    $result = (new Connections())->update($objConnectionUpdate);

                    (new UserLogs())->RegisterActivity($objLoggedInUser->user_id, "updated_connection", "Connection Updated Successfully: #" . $intConnectionId . " with value: " . $objConnectionUpdate->value, "connection", $intConnectionId);
                }
                catch (\Exception $exception)
                {
                    $objJsonReturn = array(
                        "success" => false,
                        "message" => "An error occured during user update: " . json_encode($exception) . "."
                    );

                    die(json_encode($objJsonReturn));
                }

                break;

            case "card-connection":

                $intConnectionId        = $objData->Data->PostData->connection_id;
                $intConnectionRelId     = $objData->Data->PostData->connection_rel_id;
                $strConnectionRelAction = $objData->Data->PostData->connection_rel_action;
                $intDisplayOrder        = $objData->Data->PostData->connection_display_order;

                try
                {
                    $objCurrentCardConnection = (new CardConnections())->getWhere([
                        [
                            "connection_id" => $intConnectionId,
                            "display_order" => ExcellNull
                        ],
                        "OR",
                        ["connection_rel_id" => $intConnectionRelId]
                    ]
                    );

                    if ($objCurrentCardConnection->Result->Count === 0)
                    {
                        $objCardConnectionUpdateModel = new CardConnectionModel();

                        $objCardConnectionUpdateModel->connection_id = $intConnectionId;
                        $objCardConnectionUpdateModel->card_id       = $intCardId;
                        $objCardConnectionUpdateModel->status        = "Active";
                        $objCardConnectionUpdateModel->action        = $strConnectionRelAction;
                        $objCardConnectionUpdateModel->display_order = $intDisplayOrder;

                        $objResult              = (new CardConnections())->createNew($objCardConnectionUpdateModel)->Data->ConvertToArray();
                        $objConnectionForReturn = array_shift($objResult);

                        $objConnection                                = (new Connections())->getFks()->getById($intConnectionId);
                        $objConnectionForReturn["connection_value"]   = formatAsPhoneIfApplicable($objConnection->Data->First()->connection_value);
                        $objConnectionForReturn["connection_type_id"] = $objConnection->Data->First()->connection_type_id;

                        (new UserLogs())->RegisterActivity($objLoggedInUser->user_id, "updated_connection_rel", "Card Connection Relationship Updated", "connection_rel", $objConnectionForReturn["connection_rel_id"]);

                        $arResult = [
                            "success"    => true,
                            "connection" => $objConnectionForReturn
                        ];

                        die(json_encode($arResult));
                    }
                    else
                    {
                        $objCurrentCardConnection->Data->First()->connection_id = $intConnectionId;
                        $objCurrentCardConnection->Data->First()->action        = $strConnectionRelAction;
                        $objCurrentCardConnection->Data->First()->display_order = $intDisplayOrder;

                        $objResult              = (new CardConnections())->update($objCurrentCardConnection->Data->First())->Data->ConvertToArray();
                        $objConnectionForReturn = array_shift($objResult);

                        $objConnection                                = (new Connections())->getFks()->getById($intConnectionId);
                        $objConnectionForReturn["connection_value"]   = $objConnection->Data->First()->connection_value;
                        $objConnectionForReturn["connection_type_id"] = $objConnection->Data->First()->connection_type_id;

                        $arResult = [
                            "success"    => true,
                            "connection" => $objConnectionForReturn
                        ];

                        die(json_encode($arResult));
                    }
                }
                catch (\Exception $exception)
                {
                    $objJsonReturn = array(
                        "success" => false,
                        "message" => "An error occured during user update: " . json_encode($exception) . "."
                    );

                    die(json_encode($objJsonReturn));
                }

                break;

            case "reorder-connection":

                $lstConnections = json_decode(base64_decode($objData->Data->PostData->connections));

                try
                {
                    foreach ($lstConnections as $currConnection)
                    {
                        $socialMediaResult          = (new CardConnections())->getById($currConnection->connection_rel_id);
                        $socialMedia                = $socialMediaResult->Data->First();
                        $socialMedia->display_order = $currConnection->display_order;

                        $result = (new CardConnections())->update($socialMedia);
                    }

                }
                catch (\Exception $exception)
                {
                    $objJsonReturn = array(
                        "success" => false,
                        "message" => "An error occured during user update: " . json_encode($exception) . "."
                    );

                    die(json_encode($objJsonReturn));
                }

                $objJsonReturn = array(
                    "success" => true,
                    "message" => "Successful update.",
                    "data"    => $result
                );

                die(json_encode($objJsonReturn));

                break;

            case "remove-social-media":

                $intSocialMediaId = $objData->Data->Params["card_socialmedia_id"];

                try
                {
                    $result = (new CardSocialMedia())->deleteById($intSocialMediaId);

                    (new UserLogs())->RegisterActivity($objLoggedInUser->user_id, "removed_card_socialmedia", "Card Social Media Unlinked", "card_socialmedia", $intSocialMediaId);
                }
                catch (\Exception $exception)
                {
                    $objJsonReturn = array(
                        "success" => false,
                        "message" => "An error occured during user update: " . json_encode($exception) . "."
                    );

                    die(json_encode($objJsonReturn));
                }

                $objJsonReturn = array(
                    "success" => true,
                    "message" => "Successful update.",
                    "data"    => $result
                );

                die(json_encode($objJsonReturn));

                break;
            case "remove-connection":

                $intSocialMediaId = $objData->Data->Params["connection_rel_id"];

                try
                {
                    $socialMediaResult          = (new CardConnections())->getById($intSocialMediaId);
                    $socialMedia                = $socialMediaResult->Data->First();
                    $socialMedia->display_order = ExcellNull;

                    $result = (new CardConnections())->update($socialMedia);

                    (new UserLogs())->RegisterActivity($objLoggedInUser->user_id, "removed_connection_rel", "Card Connection Removed", "connection_rel", $socialMedia->connection_rel_id);
                }
                catch (\Exception $exception)
                {
                    $objJsonReturn = array(
                        "success" => false,
                        "message" => "An error occured during user update: " . json_encode($exception) . "."
                    );

                    die(json_encode($objJsonReturn));
                }

                $objJsonReturn = array(
                    "success" => true,
                    "message" => "Successful update.",
                    "data"    => $result
                );

                die(json_encode($objJsonReturn));

                break;

            case "remove-tab":

                $intCardPageId    = $this->app->objHttpRequest->Data->Params['card_tab_id'];
                $intCardPageRelId = $this->app->objHttpRequest->Data->Params['card_tab_rel_id'];

                try
                {
                    $objTabValidationResult    = (new CardPage())->getById($intCardPageId);
                    $objTabRelValidationResult = (new CardPageRels())->getById($intCardPageRelId);

                    if ($objTabValidationResult->Result->Count === 0)
                    {
                        $arResult = [
                            "success" => false,
                            "message" => "No tab with id of {$intCardPageId} found."
                        ];
                        die(json_encode($arResult));
                    }

                    if ($objTabValidationResult->Data->First()->permanent == 1)
                    {
                        $arResult = [
                            "success" => false,
                            "message" => "This tab cannot be removed."
                        ];
                        die(json_encode($arResult));
                    }

                    if ($objTabRelValidationResult->Result->Count === 0)
                    {
                        $arResult = [
                            "success" => false,
                            "message" => "No tab relationship for tab id {$intCardPageId} found."
                        ];
                        die(json_encode($arResult));
                    }

                    if ($objTabRelValidationResult->Data->First()->card_tab_rel_type !== "mirror")
                    {
                        $objTabDeletionResult = (new CardPage())->deleteById($intCardPageId);
                    }

                    $objTabRelDeletionResult = (new CardPageRels())->deleteById($intCardPageRelId);

                    (new UserLogs())->RegisterActivity($objLoggedInUser->user_id, "delete_card_tab", "Remove tab", "card_tab", $intCardPageId);

                    $arResult = ["success" => true];
                    die(json_encode($arResult));

                }
                catch (\Exception $exception)
                {
                    $objJsonReturn = array(
                        "success" => false,
                        "message" => "An error occured during tab update: " . json_encode($exception) . "."
                    );

                    die(json_encode($objJsonReturn));
                }

                break;

            case "remove-tab-rel":

                $intCardPageId    = $this->app->objHttpRequest->Data->Params['card_tab_id'];
                $intCardPageRelId = $this->app->objHttpRequest->Data->Params['card_tab_rel_id'];

                try
                {
                    $objTabRelValidationResult = (new CardPageRels())->getById($intCardPageRelId);

                    if ($objTabRelValidationResult->Result->Count === 0)
                    {
                        $arResult = [
                            "success" => false,
                            "message" => "No tab relationship for tab id {$intCardPageId} found."
                        ];
                        die(json_encode($arResult));
                    }

                    $objTabRelDeletionResult = (new CardPageRels())->deleteById($intCardPageRelId);

                    (new UserLogs())->RegisterActivity($objLoggedInUser->user_id, "delete_card_tab", "Remove tab", "card_tab", $intCardPageId);

                    $arResult = ["success" => true];
                    die(json_encode($arResult));

                }
                catch (\Exception $exception)
                {
                    $objJsonReturn = array(
                        "success" => false,
                        "message" => "An error occured during tab update: " . json_encode($exception) . "."
                    );

                    die(json_encode($objJsonReturn));
                }

                break;

            case "edit-card-library-tab":

                $intCardPageId = $this->app->objHttpRequest->Data->PostData->card_tab_id;

                try
                {
                    $objCardPageResult = (new CardPage())->getById($intCardPageId);

                    if ($objCardPageResult->Result->Success === false)
                    {
                        $objJsonReturn = array(
                            "success" => false,
                            "message" => "No tab data was found for this entry: "
                        );

                        die(json_encode($objJsonReturn));
                    }

                    $objUser = $this->app->getActiveLoggedInUser();

                    if (!empty($this->app->objHttpRequest->Data->PostData->user_id))
                    {
                        $objUserResult = (new Users())->getById($this->app->objHttpRequest->Data->PostData->user_id);

                        if ($objUserResult->Result->Count > 0)
                        {
                            $objUser = $objUserResult->Data->First();
                        }
                    }

                    $objCardPage       = $objCardPageResult->Data->First();
                    $objCardPageResult = new ExcellTransaction();

                    if ($objData->Data->Params["tab_type"] === "system-tab")
                    {
                        $strTabClassName       = $objData->Data->PostData->tab_class;
                        $lstTabClassProperties = new \stdClass();

                        $objCardPage->title         = $this->app->objHttpRequest->Data->PostData->tab_title;
                        $objCardPage->content       = $strTabClassName;
                        $objCardPage->card_tab_data = $lstTabClassProperties;
                        $objCardPage->updated_by    = $objUser->user_id;
                        $objCardPage->last_updated  = date("Y-m-d H:i:s");

                        $objCardPageResult = (new CardPage())->getFks()->update($objCardPage);
                    }
                    else
                    {
                        $blnLibraryTab = ExcellTrue;

                        if (empty($this->app->objHttpRequest->Data->PostData->tab_library) || $this->app->objHttpRequest->Data->PostData->tab_library != "true")
                        {
                            $blnLibraryTab = ($this->app->objHttpRequest->Data->PostData->library_tab === "on" ? ExcellTrue : ExcellFalse);
                        }

                        $objCardPage->title        = $this->app->objHttpRequest->Data->PostData->tab_title;
                        $objCardPage->content      = base64_encode($this->app->objHttpRequest->Data->PostData->tab_content);
                        $objCardPage->library_tab  = $blnLibraryTab;
                        $objCardPage->updated_by   = $objUser->user_id;
                        $objCardPage->last_updated = date("Y-m-d H:i:s");
                        $objCardPageResult         = (new CardPage())->getFks()->update($objCardPage);
                    }

                    $objCardPageResult->Data->ConvertDatesToFormat('m/d/Y');
                    $objResult = $objCardPageResult->Data->ConvertToArray();

                    $objCardPageForReturn = array_shift($objResult);

                    if ($objData->Data->Params["tab_type"] !== "system-tab")
                    {
                        $objCardPageForReturn["content"] = strip_tags(html_entity_decode(base64_decode($objCardPageForReturn["content"])));
                    }

                    (new UserLogs())->RegisterActivity($objLoggedInUser->user_id, "update_card_tab", "Card Library Tab Edited: " . $intCardPageId, "card_tab", $intCardPageId);

                    $arResult = [
                        "success" => true,
                        "tab"     => $objCardPageForReturn
                    ];

                    die(json_encode($arResult));

                }
                catch (\Exception $exception)
                {
                    $objJsonReturn = array(
                        "success" => false,
                        "message" => "An error occured during tab update: " . json_encode($exception) . "."
                    );

                    die(json_encode($objJsonReturn));
                }

                break;

            case "edit-card-tab":

                $intCardPageId = $this->app->objHttpRequest->Data->PostData->card_tab_id;

                try
                {
                    $objCardPageResult = (new CardPage())->getById($intCardPageId);

                    if ($objCardPageResult->Result->Success === false)
                    {
                        $objJsonReturn = array(
                            "success" => false,
                            "message" => "No tab data was found for this entry: "
                        );

                        die(json_encode($objJsonReturn));
                    }

                    $objCardPage          = $objCardPageResult->Data->First();
                    $objCardPageRelResult = null;
                    $objCardPage->title   = $this->app->objHttpRequest->Data->PostData->tab_title;
                    $objCardPage->content = base64_encode($this->app->objHttpRequest->Data->PostData->tab_content);

                    if (empty($this->app->objHttpRequest->Data->PostData->tab_library) || $this->app->objHttpRequest->Data->PostData->tab_library != "true")
                    {
                        $objCardPageRelResult = (new CardPageRels())->getWhere([
                            "card_tab_id" => $intCardPageId,
                            "card_id"     => $objCard->card_id
                        ], 1
                        );

                        $objCardPageRelResult->Data->First()->rel_visibility = $this->app->objHttpRequest->Data->PostData->visibility === "on" ? ExcellTrue : ExcellFalse;
                        $objCardPageRelUpdate                                = (new CardPageRels())->update($objCardPageRelResult->Data->First());

                        $objCardPage->library_tab = $this->app->objHttpRequest->Data->PostData->library_tab === "on" ? ExcellTrue : $objCardPage->library_tab;
                    }
                    else
                    {
                        $objCardPage->library_tab = $this->app->objHttpRequest->Data->PostData->library_tab === "on" ? ExcellTrue : ExcellFalse;
                    }

                    $objCardPageResult = (new CardPage())->getFks()->update($objCardPage);

                    if (empty($this->app->objHttpRequest->Data->PostData->tab_library) || $this->app->objHttpRequest->Data->PostData->tab_library != "true")
                    {
                        $objCardPageResult->Data->MergeFields($objCardPageRelUpdate->Data, [
                            "card_tab_rel_id",
                            "rel_sort_order",
                            "rel_visibility"
                        ], ["card_tab_id"]
                        );
                    }

                    $objCardPageResult->Data->ConvertDatesToFormat('m/d/Y');
                    $objResult = $objCardPageResult->Data->ConvertToArray();

                    $objCardPageForReturn            = array_shift($objResult);
                    $objCardPageForReturn["content"] = strip_tags(html_entity_decode(base64_decode($objCardPageForReturn["content"])));

                    (new UserLogs())->RegisterActivity($objLoggedInUser->user_id, "update_card_tab", "Card Tab Edited: " . $intCardPageId, "card_tab", $intCardPageId);

                    $arResult = [
                        "success" => true,
                        "tab"     => $objCardPageForReturn
                    ];

                    die(json_encode($arResult));

                }
                catch (\Exception $exception)
                {
                    $objJsonReturn = array(
                        "success" => false,
                        "message" => "An error occured during tab update: " . json_encode($exception) . "."
                    );

                    die(json_encode($objJsonReturn));
                }

                break;

            case "update-tab-rel-visibility":

                $intCardPageId    = $this->app->objHttpRequest->Data->Params["card_tab_id"];
                $intCardPageRelId = $this->app->objHttpRequest->Data->Params["card_tab_rel_id"];

                $objCardPageRelResult = (new CardPageRels())->getWhere([
                    "card_tab_id"     => $intCardPageId,
                    "card_tab_rel_id" => $intCardPageRelId
                ], 1
                );

                if ($objCardPageRelResult->Result->Success === false)
                {
                    $objJsonReturn = array(
                        "success" => false,
                        "message" => "An error occured during tab update: " . $objCardPageRelResult->Result->Message . "."
                    );

                    die(json_encode($objJsonReturn));
                }

                $objCardPageRel                 = $objCardPageRelResult->Data->First();
                $objCardPageRel->rel_visibility = $this->app->objHttpRequest->Data->Params["rel_visibility"] == "1" ? ExcellTrue : ExcellFalse;
                $objUpdateResult                      = (new CardPageRels())->update($objCardPageRel);


                if ($objCardPageRel->card_tab_rel_type !== "mirror" && $objUpdateResult->Result->Success === true)
                {
                    $objCardPageResult = (new CardPage())->getById($objCardPageRel->card_tab_id);

                    if ($objCardPageResult->Result->Count === 1)
                    {
                        $objCardPage = $objCardPageResult->Data->First();
                        $objCardPage->visibility = $this->app->objHttpRequest->Data->Params["rel_visibility"] == "1" ? ExcellTrue : ExcellFalse;

                        $result = (new CardPage())->update($objCardPage);
                    }
                }

                $arResult                             = [
                    "success" => $objUpdateResult->Result->Success,
                    "tab"     => $objUpdateResult->Data->First()->ToArray()
                ];

                die(json_encode($arResult));

                break;

            case "create-new-card-library-tab":

                break;

            case "edit-card-library-tab-rel":

                $objLoggedInUser      = $this->app->getActiveLoggedInUser();
                $lstCardPageRelResult = (new CardPageRels())->getById($this->app->objHttpRequest->Data->Params["card_tab_rel_id"]);

                if ($lstCardPageRelResult->Result->Count === 0)
                {
                    $objJsonReturn = array(
                        "success" => false,
                        "message" => "We were unable to find this card tab rel [" . $this->app->objHttpRequest->Data->Params["card_tab_rel_id"] . "]: " . $lstCardPageRelResult->Result->Message
                    );

                    die(json_encode($objJsonReturn));
                }

                /** @var CardPageRelModel $objCardPageRel */
                $objCardPageRel = $lstCardPageRelResult->Data->First();

                $objCardPageRel->card_tab_id    = $objData->Data->PostData->card_library_tab_id;
                $objCardPageRel->rel_visibility = ($objData->Data->PostData->visibility ?? null) ? ExcellTrue : ExcellFalse;

                $objCardPageResult = (new CardPage())->getById($objData->Data->PostData->card_library_tab_id);

                if ($objCardPageResult->Result->Count === 0)
                {
                    $objJsonReturn = array(
                        "success" => false,
                        "message" => "We were unable to find this card tab [" . $this->app->objHttpRequest->Data->PostData->card_library_tab_id . "]: " . $lstCardPageRelResult->Result->Message
                    );

                    die(json_encode($objJsonReturn));
                }

                if ($objCardPageResult->Data->First()->card_tab_type_id == 2)
                {
                    $objCardPageRel->card_tab_rel_type = "mirror";

                    $objCardPage     = $objCardPageResult->Data->First();
                    $strTabClassName = $objCardPage->content;

                    //                    $arTabClasses = (new CardPage())->LoadTabClasses();
                    //
                    //                    if (!in_array($strTabClassName, $arTabClasses))
                    //                    {
                    //                        $objJsonReturn = array(
                    //                            "success" => false,
                    //                            "message" => "System Tab Not Found [2]: " . $strTabClassName
                    //                        );
                    //
                    //                        die(json_encode($objJsonReturn));
                    //                    }

                    $lstTabRelProperties = ((object) $objCardPageRel->card_tab_rel_data) ?? new \stdClass();

                    //                    $objTabClass = new $strTabClassName($this->app);
                    //                    $objTabClassProperties = get_object_vars($objTabClass);
                    //
                    //                    foreach($objTabClassProperties as $currPropertyName => $currPropertyValue)
                    //                    {
                    //                        if ( substr($currPropertyName,0,1) !== "_" || strtolower($currPropertyName) === "description")
                    //                        {
                    //                            continue;
                    //                        }
                    //
                    //                        $currPropertyName = str_replace("_", "", $currPropertyName);
                    //
                    //                        if (empty($objData->Data->PostData->{$currPropertyName}))
                    //                        {
                    //                            continue;
                    //                        }
                    //
                    //                        if (empty($objCardPageRel->card_tab_rel_data->Properties->{$currPropertyName}) && !empty($objCardPage->card_tab_data->Properties->{$currPropertyName}))
                    //                        {
                    //                            $objCardPageRel->card_tab_rel_data->Properties->{$currPropertyName} = $objCardPage->card_tab_data->Properties->{$currPropertyName};
                    //                        }
                    //
                    //                        if (!empty($objData->Data->PostData->{$currPropertyName}))
                    //                        {
                    //                            $lstTabRelProperties->Properties->{$currPropertyName} = $objData->Data->PostData->{$currPropertyName};
                    //                        }
                    //                    }

                    $objCardPageRel->card_tab_rel_data = $lstTabRelProperties;
                }

                $objCardPageRelUpdatedResult = (new CardPageRels())->update($objCardPageRel);

                if ($objCardPageRelUpdatedResult->Result->Success === false)
                {
                    $objJsonReturn = array(
                        "success" => false,
                        "message" => "We were unable to save this card tab rel: " . $objCardPageRelUpdatedResult->Result->Message
                    );

                    die(json_encode($objJsonReturn));
                }

                $objNewCardPageResult = (new CardPage())->getFks()->getById($objData->Data->PostData->card_library_tab_id);

                $objNewCardPageResult->Data->First()->AddUnvalidatedValue("card_tab_rel_type", $objCardPageRel->card_tab_rel_type);
                $objNewCardPageResult->Data->First()->AddUnvalidatedValue("rel_sort_order", $objCardPageRel->rel_sort_order);
                $objNewCardPageResult->Data->First()->AddUnvalidatedValue("rel_visibility", ($objData->Data->PostData->visibility ?? null) === "on" ? true : false);
                $objNewCardPageResult->Data->ConvertDatesToFormat("m/d/Y");
                $arObjCardPageData = $objNewCardPageResult->Data->ConvertToArray();

                $objConnectionForReturn = array_shift($arObjCardPageData);

                (new UserLogs())->RegisterActivity($objLoggedInUser->user_id, "create_card_tab", "Card Tab Rel Updated: " . $objCardPageRel->card_tab_rel_id, "card_tab", $objCardPageRel->card_tab_id);

                $arResult = [
                    "success" => true,
                    "tab"     => $objConnectionForReturn
                ];

                logText("CardData.UpdateCardData.Process.log", "edit-card-library-tab-rel: [success] " . json_encode($arResult));

                die(json_encode($arResult));

                break;

            case "add-card-library-tab-rel":

                $objLoggedInUser    = $this->app->getActiveLoggedInUser();
                $colCardPagesResult = (new CardPageRels())->getWhere([
                    "card_id",
                    "=",
                    $intCardId
                ]
                );
                $objCardOwnerResult = (new Users())->GetCardOwnerByCardId($intCardId);

                if ($objCardOwnerResult->Result->Success === false)
                {
                    $objJsonReturn = array(
                        "success" => false,
                        "message" => "We were unable to get card owner for tab creation: " . $objCardOwnerResult->Result->Message
                    );

                    die(json_encode($objJsonReturn));
                }

                $objCardOwner  = $objCardOwnerResult->Data->First();
                $intCardPageId = $objData->Data->PostData->card_library_tab_id;

                $intNextCardOrder = 1;

                if ($colCardPagesResult->Result->Success === true && $colCardPagesResult->Result->Count > 0)
                {
                    $intNextCardOrder = $colCardPagesResult->Data->Count() + 1;
                }

                $objCardRelData       = null;
                $objNewCardPageResult = (new CardPage())->getFks()->getById($intCardPageId);

                if ($objNewCardPageResult->Result->Success === true)
                {
                    $objCardRelData = $objNewCardPageResult->Data->First()->card_tab_data;
                }

                $objCardPageRelResult                    = new CardPageRelModel();
                $objCardPageRelResult->card_tab_id       = $intCardPageId;
                $objCardPageRelResult->card_id           = $intCardId;
                $objCardPageRelResult->user_id           = $objLoggedInUser->user_id;
                $objCardPageRelResult->rel_sort_order    = $intNextCardOrder;
                $objCardPageRelResult->rel_visibility    = ($this->app->objHttpRequest->Data->PostData->visibility === "on") ? ExcellTrue : ExcellFalse;
                $objCardPageRelResult->card_tab_rel_data = $objCardRelData;
                $objCardPageRelResult->card_tab_rel_type = "mirror";

                $objNewCardPageRelResult = (new CardPageRels())->getFks()->createNew($objCardPageRelResult);

                if ($objNewCardPageRelResult->Result->Success === false)
                {
                    $objJsonReturn = array(
                        "success" => false,
                        "message" => "We were unable to save this card tab rel: " . $objCardOwnerResult->Result->Message
                    );

                    die(json_encode($objJsonReturn));
                }

                // We're handing back the card-tab model for display, but it needs the relationship from the rel and the rel sort order and type.
                $objNewCardPageResult->Data->First()->AddUnvalidatedValue("card_tab_rel_id", $objNewCardPageRelResult->Data->First()->card_tab_rel_id);
                $objNewCardPageResult->Data->First()->AddUnvalidatedValue("rel_sort_order", $intNextCardOrder);
                $objNewCardPageResult->Data->First()->AddUnvalidatedValue("card_tab_rel_type", $objNewCardPageRelResult->Data->First()->card_tab_rel_type);
                $objNewCardPageResult->Data->ConvertDatesToFormat("m/d/Y");
                $arObjCardPageData = $objNewCardPageResult->Data->ConvertToArray();

                $objConnectionForReturn = array_shift($arObjCardPageData);

                (new UserLogs())->RegisterActivity($objLoggedInUser->user_id, "create_card_tab", "Card Tab Created: " . $objCardPageRelResult->card_tab_id, "card_tab", $objCardPageRelResult->card_tab_id);

                $arResult = [
                    "success" => true,
                    "tab"     => $objConnectionForReturn
                ];

                die(json_encode($arResult));

                break;

            case "add-card-library-tab":

                $objUser = $this->app->getActiveLoggedInUser();

                if (!empty($this->app->objHttpRequest->Data->PostData->user_id))
                {
                    $objUserResult = (new Users())->getById($this->app->objHttpRequest->Data->PostData->user_id);

                    if ($objUserResult->Result->Count > 0)
                    {
                        $objUser = $objUserResult->Data->First();
                    }
                }

                $objNewCardPageResult = new ExcellTransaction();

                if ($objData->Data->Params["tab_type"] === "system-tab")
                {
                    $strTabClassName = $objData->Data->PostData->tab_class;

                    $arTabClasses = (new CardPage())->LoadTabClasses();

                    if (!in_array($strTabClassName, $arTabClasses))
                    {
                        $objJsonReturn = array(
                            "success" => false,
                            "message" => "System Tab Not Found [3]: " . $strTabClassName
                        );

                        die(json_encode($objJsonReturn));
                    }

                    $objTabClass           = new $strTabClassName($this->app);
                    $objTabClassProperties = get_object_vars($objTabClass);
                    $lstTabClassProperties = new \stdClass();

                    foreach ($objTabClassProperties as $currPropertyName => $currPropertyValue)
                    {
                        if (substr($currPropertyName, 0, 1) !== "_" || strtolower($currPropertyName) === "description" || empty($objData->Data->PostData->{$currPropertyName}))
                        {
                            continue;
                        }

                        $currPropertyName = str_replace("_", "", $currPropertyName);

                        $lstTabClassProperties->Properties->{$currPropertyName} = $objData->Data->PostData->{$currPropertyName};
                    }

                    $objCardPage                   = new CardPageModel();
                    $objCardPage->user_id          = $objUser->user_id;
                    $objCardPage->company_id       = $this->app->objCustomPlatform->getCompanyId();
                    $objCardPage->division_id      = $objUser->division_id;
                    $objCardPage->card_tab_type_id = $this->app->objHttpRequest->Data->PostData->card_tab_type_id;
                    $objCardPage->title            = $this->app->objHttpRequest->Data->PostData->tab_title;
                    $objCardPage->content          = $strTabClassName;
                    $objCardPage->library_tab      = ExcellTrue;
                    $objCardPage->permanent        = ExcellFalse;
                    $objCardPage->order_number     = 1;
                    $objCardPage->visibility       = ExcellTrue;
                    $objCardPage->card_tab_data    = $lstTabClassProperties;
                    $objCardPage->created_on       = date("Y-m-d H:i:s");
                    $objCardPage->created_by       = $objUser->user_id;
                    $objCardPage->updated_by       = $objUser->user_id;
                    $objCardPage->last_updated     = date("Y-m-d H:i:s");

                    $objNewCardPageResult = (new CardPage())->getFks()->createNew($objCardPage);
                }
                else
                {
                    $objCardPage                   = new CardPageModel();
                    $objCardPage->user_id          = $objUser->user_id;
                    $objCardPage->company_id       = $this->app->objCustomPlatform->getCompanyId();
                    $objCardPage->division_id      = 0;
                    $objCardPage->card_tab_type_id = $this->app->objHttpRequest->Data->PostData->card_tab_type_id;
                    $objCardPage->title            = $this->app->objHttpRequest->Data->PostData->tab_title;
                    $objCardPage->content          = base64_encode($this->app->objHttpRequest->Data->PostData->tab_content);
                    $objCardPage->library_tab      = ExcellTrue;
                    $objCardPage->permanent        = ExcellFalse;
                    $objCardPage->order_number     = 1;
                    $objCardPage->visibility       = ExcellTrue;
                    $objCardPage->created_on       = date("Y-m-d H:i:s");
                    $objCardPage->created_by       = $objUser->user_id;
                    $objCardPage->updated_by       = $objUser->user_id;
                    $objCardPage->last_updated     = date("Y-m-d H:i:s");

                    $objNewCardPageResult = (new CardPage())->getFks()->createNew($objCardPage);
                }

                if ($objNewCardPageResult->Result->Success === false)
                {
                    $objJsonReturn = array(
                        "success" => false,
                        "message" => "We were unable to save this card tab: " . $objNewCardPageResult->Result->Message
                    );

                    die(json_encode($objJsonReturn));
                }

                $objNewCardPageResult->Data->ConvertDatesToFormat("m/d/Y");
                $arObjCardPageData = $objNewCardPageResult->Data->ConvertToArray();

                $objConnectionForReturn = array_shift($arObjCardPageData);

                if ($objData->Data->Params["tab_type"] !== "system-tab")
                {
                    $objConnectionForReturn["content"] = strip_tags(base64_decode($objConnectionForReturn["content"]));
                }

                (new UserLogs())->RegisterActivity($objLoggedInUser->user_id, "create_card_tab", "Card Tab Created: " . $objNewCardPageResult->card_tab_id, "card_tab", $objNewCardPageResult->card_tab_id);
                $arResult = [
                    "success" => true,
                    "tab"     => $objConnectionForReturn
                ];

                die(json_encode($arResult));

                break;

            case "add-card-tab":

                try
                {
                    $objLoggedInUser    = $this->app->getActiveLoggedInUser();
                    $colCardPagesResult = (new CardPageRels())->getWhere([
                        "card_id",
                        "=",
                        $intCardId
                    ]
                    );
                    $objCardOwnerResult = (new Users())->GetCardOwnerByCardId($intCardId);

                    if ($objCardOwnerResult->Result->Success === false)
                    {
                        $objJsonReturn = array(
                            "success" => false,
                            "message" => "We were unable to get card owner for tab creation: " . $objCardOwnerResult->Result->Message
                        );

                        die(json_encode($objJsonReturn));
                    }

                    $objCardOwner = $objCardOwnerResult->Data->First();

                    $intNextCardOrder = 1;

                    if ($colCardPagesResult->Result->Success === true && $colCardPagesResult->Result->Count > 0)
                    {
                        $intNextCardOrder = $colCardPagesResult->Data->Count() + 1;
                    }

                    $objCardPage                   = new CardPageModel();
                    $objCardPage->user_id          = $objCardOwner->user_id;
                    $objCardPage->company_id       = $this->app->objCustomPlatform->getCompanyId();
                    $objCardPage->division_id      = 0;
                    $objCardPage->card_tab_type_id = $this->app->objHttpRequest->Data->PostData->card_tab_type_id ?? 1;
                    $objCardPage->title            = $this->app->objHttpRequest->Data->PostData->tab_title;
                    $objCardPage->content          = base64_encode($this->app->objHttpRequest->Data->PostData->tab_content);
                    $objCardPage->library_tab      = ExcellFalse;
                    $objCardPage->permanent        = ExcellFalse;
                    $objCardPage->order_number     = $intNextCardOrder;
                    $objCardPage->visibility       = ExcellTrue;
                    $objCardPage->created_on       = date("Y-m-d H:i:s");
                    $objCardPage->created_by       = $objLoggedInUser->user_id;
                    $objCardPage->updated_by       = $objLoggedInUser->user_id;
                    $objCardPage->last_updated     = date("Y-m-d H:i:s");

                    $objNewCardPageResult = (new CardPage())->getFks()->createNew($objCardPage);

                    if ($objNewCardPageResult->Result->Success === false)
                    {
                        $objJsonReturn = array(
                            "success" => false,
                            "message" => "We were unable to save this card tab: " . $objCardOwnerResult->Result->Message
                        );

                        die(json_encode($objJsonReturn));
                    }

                    $objCardPageRelResult                    = new CardPageRelModel();
                    $objCardPageRelResult->card_tab_id       = $objNewCardPageResult->Data->First()->card_tab_id;
                    $objCardPageRelResult->card_id           = $intCardId;
                    $objCardPageRelResult->user_id           = $objLoggedInUser->user_id;
                    $objCardPageRelResult->rel_sort_order    = $intNextCardOrder;
                    $objCardPageRelResult->rel_visibility    = ($this->app->objHttpRequest->Data->PostData->visibility === "on") ? ExcellTrue : ExcellFalse;
                    $objCardPageRelResult->card_tab_rel_type = "default";

                    $objNewCardPageRelResult = (new CardPageRels())->getFks()->createNew($objCardPageRelResult);

                    if ($objNewCardPageRelResult->Result->Success === false)
                    {
                        $objJsonReturn = array(
                            "success" => false,
                            "message" => "We were unable to save this card tab rel: " . $objCardOwnerResult->Result->Message
                        );

                        die(json_encode($objJsonReturn));
                    }

                    $objNewCardPageRelResult->Data->First()->AddUnvalidatedValue("title", $this->app->objHttpRequest->Data->PostData->tab_title);
                    $objNewCardPageRelResult->Data->First()->AddUnvalidatedValue("content", $this->app->objHttpRequest->Data->PostData->tab_content);
                    $objNewCardPageRelResult->Data->First()->AddUnvalidatedValue("card_tab_type_id", $objNewCardPageResult->Data->First()->card_tab_type_id);
                    $objNewCardPageRelResult->Data->First()->AddUnvalidatedValue("library_tab", $objNewCardPageResult->Data->First()->library_tab);
                    $objNewCardPageRelResult->Data->First()->AddUnvalidatedValue("permanent", $objNewCardPageResult->Data->First()->permanent);
                    $objNewCardPageRelResult->Data->First()->AddUnvalidatedValue("created_on", date("Y-m-d H:i:s"));
                    $objNewCardPageRelResult->Data->First()->AddUnvalidatedValue("last_updated", date("Y-m-d H:i:s"));
                    $objNewCardPageRelResult->Data->ConvertDatesToFormat("m/d/Y");
                    $arObjCardPageData = $objNewCardPageRelResult->Data->ConvertToArray();

                    $objConnectionForReturn = array_shift($arObjCardPageData);

                    (new UserLogs())->RegisterActivity($objLoggedInUser->user_id, "create_card_tab", "Card Tab Created: " . $objCardPageRelResult->card_tab_id, "card_tab", $objCardPageRelResult->card_tab_id);

                    $arResult = [
                        "success" => true,
                        "tab"     => $objConnectionForReturn
                    ];

                    die(json_encode($arResult));

                }
                catch (\Exception $exception)
                {
                    $objJsonReturn = array(
                        "success" => false,
                        "message" => "An error occured during tab update: " . json_encode($exception) . "."
                    );

                    die(json_encode($objJsonReturn));
                }

                break;

            case "reorder-tabs":

                $lstTabs  = json_decode(base64_decode($objData->Data->PostData->tabs));
                $arErrors = [];

                try
                {
                    foreach ($lstTabs as $currTabRel)
                    {
                        $objCardPageRelResult                 = (new CardPageRels())->getById($currTabRel->card_tab_rel_id);
                        $objCardPageRelResult                 = $objCardPageRelResult->Data->First();
                        $objCardPageRelResult->rel_sort_order = $currTabRel->rel_sort_order;

                        $result = (new CardPageRels())->update($objCardPageRelResult);

                        if ($result->Result->Success === false)
                        {
                            $arErrors[] = $result->Result->Message;
                        }
                    }
                }
                catch (\Exception $exception)
                {
                    $objJsonReturn = array(
                        "success" => false,
                        "message" => "An error occured during user update: " . json_encode($exception) . "."
                    );

                    die(json_encode($objJsonReturn));
                }

                if (count($arErrors) > 0)
                {
                    $objJsonReturn = array(
                        "success" => false,
                        "errors"  => $arErrors
                    );

                    die(json_encode($objJsonReturn));
                }

                $objJsonReturn = array(
                    "success" => true,
                    "message" => "Successful update.",
                    "data"    => $lstTabs
                );

                die(json_encode($objJsonReturn));

                break;

            case "card-data":

                $strFieldLabels = base64_decode($objData->Data->PostData->fieldlabels);
                $objDataValue   = base64_decode($objData->Data->PostData->value);

                $arFieldDataInfo = explode(".", str_replace([
                    "-",
                    ",",
                    " "
                ], "", $strFieldLabels
                )
                );

                if (empty($objCard->card_data))
                {
                    $objCard->card_data = new \stdClass();
                }

                switch (count($arFieldDataInfo))
                {
                    case 1:
                        $objCard->card_data->{$arFieldDataInfo[0]} = $objDataValue;
                        break;
                    case 2:
                        $objCard->card_data->{$arFieldDataInfo[0]}->{$arFieldDataInfo[1]} = $objDataValue;
                        break;
                    case 3:
                        $objCard->card_data->{$arFieldDataInfo[0]}->{$arFieldDataInfo[1]}->{$arFieldDataInfo[2]} = $objDataValue;
                        break;
                    case 4:
                        $objCard->card_data->{$arFieldDataInfo[0]}->{$arFieldDataInfo[1]}->{$arFieldDataInfo[2]}->{$arFieldDataInfo[3]} = $objDataValue;
                        break;
                    default:
                        $objJsonReturn = array(
                            "success" => false,
                            "message" => count($arFieldDataInfo) . " levels of card data have not been implemented."
                        );

                        die(json_encode($objJsonReturn));
                        break;
                }

                try
                {
                    $result = (new Cards())->update($objCard);

                    $this->renderReturnJson(true, ["card-data" => $result->Data->First()->ToPublicArray(["card_data"])["card_data"]], $result->Result->Message);
                }
                catch (\Exception $exception)
                {
                    $objJsonReturn = array(
                        "success" => false,
                        "message" => "An error occured during user update: " . json_encode($exception) . "."
                    );

                    die(json_encode($objJsonReturn));
                }

                break;

            case "add-user-role-to-card":

                $intUserIdForNewRole = $objData->Data->PostData->user_id;
                $intCardId           = $objData->Data->PostData->card_id;
                $intCardRole         = $objData->Data->PostData->card_role;

                if (empty($intCardId) || !isInteger($intCardId))
                {
                    $objJsonReturn = array(
                        "success" => false,
                        "message" => "You must supply a valid card id."
                    );

                    die(json_encode($objJsonReturn));
                }

                if (empty($intUserIdForNewRole) || !isInteger($intUserIdForNewRole))
                {
                    $objJsonReturn = array(
                        "success" => false,
                        "message" => "You must supply a valid user id."
                    );

                    die(json_encode($objJsonReturn));
                }

                if (empty($intCardRole) || !isInteger($intCardRole))
                {
                    $objJsonReturn = array(
                        "success" => false,
                        "message" => "You must supply a valid card role id."
                    );

                    die(json_encode($objJsonReturn));
                }

                $objUserResult = (new Users())->getById($intUserIdForNewRole);

                if ($objUserResult->Result->Count === 0)
                {
                    $objJsonReturn = array(
                        "success" => false,
                        "message" => "You must supply a valid user."
                    );

                    die(json_encode($objJsonReturn));
                }

                $objCardResult = (new Cards())->getById($intCardId);

                if ($objCardResult->Result->Count === 0)
                {
                    $objJsonReturn = array(
                        "success" => false,
                        "message" => "You must supply a valid card."
                    );

                    die(json_encode($objJsonReturn));
                }

                logText("AddUserRoleToCard.log", "userId = {$intUserIdForNewRole}; cardId = {$intCardId}; userRole = {$intCardRole};");

                $objCardRel                   = new CardRelModel();
                $objCardRel->card_id          = $intCardId;
                $objCardRel->user_id          = $intUserIdForNewRole;
                $objCardRel->status           = "Active";
                $objCardRel->card_rel_type_id = $intCardRole;
                $objCardRel->created_on       = date("Y-m-d H:i:s");
                $objCardRel->created_by       = $objLoggedInUser->user_id;

                try
                {
                    $objCardUserRoleCreationResult = (new CardRels())->createNew($objCardRel);

                    logText("AddUserRoleToCard.log", "Dump: " . json_encode(process_dump_value($objCardUserRoleCreationResult)));

                    //process_dump_value($objCardUserRoleCreationResult);

                    $colCardUsers = (new Users())->GetByCardId($intCardId);
                    $arCardUsers  = $colCardUsers->Data->CollectionToArray();

                    $objJsonReturn = array(
                        "success"   => true,
                        "message"   => "Successful image retrieval.",
                        "cardUsers" => $arCardUsers
                    );

                    die(json_encode($objJsonReturn));
                }
                catch (\Exception $exception)
                {
                    $objJsonReturn = array(
                        "success" => false,
                        "message" => "An error occured during user update: " . json_encode($exception) . "."
                    );

                    die(json_encode($objJsonReturn));
                }

                break;

            case "update-card-primary-color":


                break;

            case "image":

                $intAddressId                     = $objData->Data->Params["address_id"];
                $objUserAddressUpdate             = new UserAddressModel($objData->Data->PostData);
                $objUserAddressUpdate->address_id = $intAddressId;

                require AppEntities . "users/classes/user_address.class" . XT;

                try
                {
                    $result = (new UserAddress())->update($objUserAddressUpdate);
                }
                catch (\Exception $exception)
                {
                    $objJsonReturn = array(
                        "success" => false,
                        "message" => "An error occured during user update: " . json_encode($exception) . "."
                    );

                    die(json_encode($objJsonReturn));
                }

                break;
        }

        die('{"success": true}');
    }

    public function updateCardPageRelData(ExcellHttpModel $objData)
    {
        $intCardPageRelId     = $objData->Data->Params["id"];
        $objCardPageRelModule = new CardPageRels();
        $objCardPageRelResult = $objCardPageRelModule->getWhere("card_tab_rel_id", $intCardPageRelId);


        if (empty($objData->Data->PostData->value))
        {
            $objJsonReturn = array(
                "success" => false,
                "message" => "A color must be included in this update reqest.",
                "data"    => $objData->Data->PostData
            );

            die(json_encode($objJsonReturn));
        }

        if ($objCardPageRelResult->Result->Count !== 1)
        {
            $objJsonReturn = array(
                "success" => false,
                "message" => "A valid card tab rel id must be included in this update reqest."
            );

            die(json_encode($objJsonReturn));
        }

        $objCardPageRel = $objCardPageRelResult->Data->First();

        $objCardPageRel->card_tab_rel_data->Properties->TabCustomColor = $objData->Data->PostData->value ?? "";
        $objCardPageRelModule->update($objCardPageRel);

        $objJsonReturn = array(
            "success" => true,
            "message" => "Successful color update.",
            "color"   => $objData->Data->PostData->value
        );

        die(json_encode($objJsonReturn));
    }

    public function getCardImages(ExcellHttpModel $objData)
    {
        $intCardId = $objData->Data->Params["id"];

        if (empty($intCardId))
        {
            $objJsonReturn = array(
                "success" => false,
                "message" => "A valid card id must be included in this update reqest."
            );

            die(json_encode($objJsonReturn));
        }

        $objCardResult = (new Cards())->getById($intCardId);

        if ($objCardResult->Result->Success === false || $objCardResult->Result->Count === 0)
        {
            $objJsonReturn = array(
                "success" => false,
                "message" => "A valid card id must be included in this update reqest."
            );

            die(json_encode($objJsonReturn));
        }

        $objCard = $objCardResult->Data->First();

        $strImageType = $objData->Data->Params["type"];

        switch ($strImageType)
        {
            case "main-image":

                $strCardMainImage  = "/_ez/templates/" . ($objCard->template_id__value ?? "1") . "/images/mainImage.jpg";
                $strCardThumbImage = "/_ez/templates/" . ($objCard->template_id__value ?? "1") . "/images/mainImage.jpg";

                $objImageResult = (new Images())->noFks()->getWhere([
                    "entity_id"   => $intCardId,
                    "image_class" => "main-image",
                    "entity_name" => "card"
                ]
                );

                if ($objImageResult->Result->Success === true && $objImageResult->Result->Count > 0)
                {
                    $strCardMainImage  = $objImageResult->Data->First()->url;
                    $strCardThumbImage = $objImageResult->Data->First()->thumb;
                }

                $objJsonReturn = array(
                    "success" => true,
                    "message" => "Successful image retrieval.",
                    "image"   => $strCardMainImage
                );

                die(json_encode($objJsonReturn));

                break;

        }
    }

    public function getTabSetup(ExcellHttpModel $objData): bool
    {
        $strTabClassName = $objData->Data->Params["tab_class"];

        $arTabClasses = (new CardPage())->LoadTabClasses();

        if (!in_array($strTabClassName, $arTabClasses))
        {
            $objJsonReturn = array(
                "success" => false,
                "message" => "System Tab Not Found [4]: " . $strTabClassName
            );

            die(json_encode($objJsonReturn));
        }

        $objTabClass = new $strTabClassName($this->app);

        $objSetupHtml = $objTabClass->_userSetup($objData->Data->Params["card_tab_id"]);

        $objJsonReturn = array(
            "success" => true,
            "message" => "System Tab Found: X",
            "html"    => base64_encode($objSetupHtml)
        );

        header('Content-Type: application/json');
        die(json_encode($objJsonReturn));
    }

    public function getTabContentForDisplay(ExcellHttpModel $objData): bool
    {
        $objCardPageResult = (new CardPage())->getById($objData->Data->Params["card_tab_id"]);

        if ($objCardPageResult->Result->Count === 0)
        {
            $objJsonReturn = array(
                "success" => false,
                "message" => "We were unable to find this card tab [" . $objData->Data->Params["card_tab_id"] . "]: " . $objCardPageResult->Result->Message
            );

            die(json_encode($objJsonReturn));
        }

        $objCardPage = $objCardPageResult->Data->First();

        $objJsonReturn = array(
            "success" => true,
            "html"    => $objCardPage->content
        );

        die(json_encode($objJsonReturn));
    }

    public function getCustomTabRelAttributes(ExcellHttpModel $objData): bool
    {
        $strTabClassName = $objData->Data->Params["tab_class"];

        $objCardPageResult = (new CardPage())->getById($objData->Data->Params["card_tab_id"]);

        if ($objCardPageResult->Result->Count === 0)
        {
            $objJsonReturn = array(
                "success" => false,
                "message" => "We were unable to find this card tab [" . $objData->Data->Params["card_tab_id"] . "]: " . $objCardPageResult->Result->Message
            );

            die(json_encode($objJsonReturn));
        }

        $objCardPage     = $objCardPageResult->Data->First();
        $strTabClassName = $objCardPage->content;

        $arTabClasses = (new CardPage())->LoadTabClasses();

        if (!in_array($strTabClassName, $arTabClasses))
        {
            $objJsonReturn = array(
                "success" => true,
                "message" => "System Tab Not Found [5]: " . $strTabClassName
            );

            die(json_encode($objJsonReturn));
        }

        $objTabClass           = new $strTabClassName($this->app);
        $objTabClassProperties = get_object_vars($objTabClass);

        $arTabClassProperties = [];

        foreach ($objTabClassProperties as $currPropertyName => $currPropertyValue)
        {
            if (substr($currPropertyName, 0, 1) !== "_")
            {
                continue;
            }

            $currPropertyName = str_replace("_", "", $currPropertyName);

            if (!is_array($currPropertyValue))
            {
                if (is_bool($currPropertyValue))
                {
                    $arTabClassProperties[] = [
                        "name"    => $currPropertyName,
                        "label"   => ucwordsToSentences($currPropertyName),
                        "default" => $currPropertyValue ? 'True' : 'False',
                        "type"    => "radio",
                        "options" => [
                            "True",
                            "False"
                        ],
                    ];
                }
                else
                {
                    $arTabClassProperties[] = [
                        "name"    => $currPropertyName,
                        "label"   => ucwordsToSentences($currPropertyName),
                        "default" => $currPropertyValue,
                        "type"    => "text",
                        "max"     => 255,
                    ];
                }
            }
            else
            {
                $arOptions       = [];
                $strDefaultValue = "_none_";

                foreach ($currPropertyValue as $currIndex => $currValue)
                {
                    if (is_array($currValue))
                    {
                        if (isset($currValue["default"]) && isset($currValue["value"]) && $currValue["default"] === true)
                        {
                            $strDefaultValue = $currIndex;
                        }

                        if (isset($currValue["value"]))
                        {
                            $arOptions[$currIndex] = $currValue["value"];
                        }
                    }
                    else
                    {
                        $arOptions[$currIndex] = $currValue;
                    }

                }

                $arTabClassProperties[] = [
                    "name"    => $currPropertyName,
                    "label"   => ucwordsToSentences($currPropertyName),
                    "default" => $strDefaultValue,
                    "type"    => "select",
                    "options" => $arOptions,
                ];
            }
        }

        if (!empty($objData->Data->Params["card_tab_id"]))
        {
            if (isInteger($objData->Data->Params["card_tab_id"]))
            {
                $objCardPageResult = (new CardPage())->getById($objData->Data->Params["card_tab_id"]);

                if ($objCardPageResult->Result->Count === 1)
                {
                    $objCardPage = $objCardPageResult->Data->First();

                    if (!empty($objCardPage->card_tab_data->Properties))
                    {
                        foreach ($objCardPage->card_tab_data->Properties as $currPropertiyName => $currPropertyValue)
                        {
                            foreach ($arTabClassProperties as $currIndex => $currTabClassProperty)
                            {
                                if ($currTabClassProperty["name"] == $currPropertiyName)
                                {
                                    $arTabClassProperties[$currIndex]["default"] = $currPropertyValue;
                                }
                            }
                        }
                    }
                }
            }
        }

        if ($objData->Data->Params["action"] === "edit")
        {
            $lstCardPageRelResult = (new CardPageRels())->getById($this->app->objHttpRequest->Data->Params["card_tab_rel_id"]);

            if ($lstCardPageRelResult->Result->Count === 1)
            {
                $objCardPageRel = $lstCardPageRelResult->Data->First();

                if (!empty($objCardPageRel->card_tab_rel_data->Properties))
                {
                    foreach ($objCardPageRel->card_tab_rel_data->Properties as $currPropertiyName => $currPropertyValue)
                    {
                        foreach ($arTabClassProperties as $currIndex => $currTabClassProperty)
                        {
                            if ($currTabClassProperty["name"] == $currPropertiyName)
                            {
                                $arTabClassProperties[$currIndex]["default"] = $currPropertyValue;
                            }
                        }
                    }
                }
            }
        }

        $objJsonReturn = array(
            "success" => true,
            "message" => "System Tab Found: " . $strTabClassName,
            "tab"     => $arTabClassProperties
        );

        die(json_encode($objJsonReturn));
    }

    public function MessageContactModal(ExcellHttpModel $objData): bool
    {
        $intCardId    = $objData->Data->PostData->card_id;
        $strContactId = $objData->Data->PostData->contact_id;

        if (!isInteger($intCardId))
        {
            $objJsonReturn = array(
                "success" => false,
                "message" => "You must pass in a card id to access this modal: [{$intCardId}]",
            );

            die(json_encode($objJsonReturn));
        }

        $strView = (new Cards())->getView("message.message_contact_modal", $this->app->strAssignedPortalTheme, [
            "intCardId"    => $intCardId,
            "strContactId" => $strContactId
        ]
        );

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
            "data"    => $arDataReturn,
        );

        die(json_encode($objJsonReturn));
    }

    public function MessageContactsModal(ExcellHttpModel $objData): bool
    {
        $intCardId = $objData->Data->PostData->card_id;

        if (!isInteger($intCardId))
        {
            $objJsonReturn = array(
                "success" => false,
                "message" => "You must pass in a card id to access this modal: [{$intCardId}]",
            );

            die(json_encode($objJsonReturn));
        }

        $strView = (new Cards())->getView("message.message_contacts_modal", $this->app->strAssignedPortalTheme, ["intCardId" => $intCardId]);

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
            "data"    => $arDataReturn,
        );

        die(json_encode($objJsonReturn));
    }

    public function MessageSelectedContactsModal(ExcellHttpModel $objData): bool
    {
        if (empty($objData->Data->PostData->contact))
        {
            $objJsonReturn = array(
                "success" => false,
                "message" => "You have to hand in some contact guids to access this modal.",
            );

            die(json_encode($objJsonReturn));
        }

        $arContacts = $objData->Data->PostData->contact;
        $intCardId  = $objData->Data->PostData->card_id;

        if (!isInteger($intCardId))
        {
            $objJsonReturn = array(
                "success" => false,
                "message" => "You must pass in a card id to access this modal: [{$intCardId}]",
            );

            die(json_encode($objJsonReturn));
        }

        $strView = (new Cards())->getView("message.message_selected_contacts_modal", $this->app->strAssignedPortalTheme, [
            "intCardId"  => $intCardId,
            "arContacts" => $arContacts
        ]
        );

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
            "data"    => $arDataReturn,
        );

        die(json_encode($objJsonReturn));
    }

    public function SendTextMessageToCardContacts(ExcellHttpModel $objData): bool
    {
        $intCardId = $objData->Data->PostData->card_id;

        $objContactCardRelResult = (new MobinitiContacts())->GetByCardId($intCardId);

        if ($objContactCardRelResult->Result->Count === 0)
        {
            $objJsonReturn = array(
                "success" => false,
                "message" => "We were unable to send a text message because this card has no contacts associated with it.",
            );

            die(json_encode($objJsonReturn));
        }

        $objContactCardRelResult->Data->Each(function (MobinitiContactModel $currContact) use ($objData) {
            $objMobinitMessageModel             = new MobinitiMessageModel();
            $objMobinitMessageModel->message    = $objData->Data->PostData->text_message_data;
            $objMobinitMessageModel->contact_id = $currContact->id;

            (new MobinitiMessagesApiModule())->SendMessage($objMobinitMessageModel);
        }
        );


        $objJsonReturn = array(
            "success" => true,
            "message" => "Sending messages complete.",
        );

        die(json_encode($objJsonReturn));
    }

    public function SendTextMessageToSelectedCardContacts(ExcellHttpModel $objData): bool
    {
        $intCardId = $objData->Data->PostData->card_id;

        if (empty($objData->Data->PostData->contact))
        {
            $objJsonReturn = array(
                "success" => false,
                "message" => "You have to hand in some contact guids to access this modal.",
            );

            die(json_encode($objJsonReturn));
        }

        $arCardContacts = $objData->Data->PostData->contact;

        $objContactCardRelResult = (new MobinitiContacts())->getWhereIn("id", $arCardContacts);

        if ($objContactCardRelResult->Result->Count === 0)
        {
            $objJsonReturn = array(
                "success" => false,
                "message" => "We were unable to send a text message because this card has no contacts associated with it.",
            );

            die(json_encode($objJsonReturn));
        }

        $objContactCardRelResult->Data->Each(function (MobinitiContactModel $currContact) use ($objData) {
            $objMobinitMessageModel             = new MobinitiMessageModel();
            $objMobinitMessageModel->message    = $objData->Data->PostData->text_message_data;
            $objMobinitMessageModel->contact_id = $currContact->id;

            (new MobinitiMessagesApiModule())->SendMessage($objMobinitMessageModel);
        });

        $objJsonReturn = array(
            "success" => true,
            "message" => "Sending messages complete.",
        );

        die(json_encode($objJsonReturn));
    }

    public function SendTextMessageToCardContact(ExcellHttpModel $objData): bool
    {
        $intCardId    = $objData->Data->PostData->card_id;
        $strContactId = $objData->Data->PostData->contact_id;

        $objContactCardRelResult = (new MobinitiContacts())->getById($strContactId);

        if ($objContactCardRelResult->Result->Count !== 1)
        {
            $objJsonReturn = array(
                "success" => false,
                "message" => "We were unable to send a text message because this card has no contacts associated with it.",
            );

            die(json_encode($objJsonReturn));
        }

        $objContactCardRelResult->Data->Each(function (MobinitiContactModel $currContact) use ($objData) {
            $objMobinitMessageModel             = new MobinitiMessageModel();
            $objMobinitMessageModel->message    = $objData->Data->PostData->text_message_data;
            $objMobinitMessageModel->contact_id = $currContact->id;

            $objMobinitiMessageResult = (new MobinitiMessagesApiModule())->SendMessage($objMobinitMessageModel);

            $objJsonReturn = array(
                "success" => $objMobinitiMessageResult->Result->Success,
                "result"  => json_encode($objMobinitiMessageResult->Result),
                "message" => json_encode($objMobinitMessageModel->ToArray()),
            );

            die(json_encode($objJsonReturn));
        }
        );
    }

    // TODO - FIX!!!
    public function MessageCardContacts(ExcellHttpModel $objData): bool
    {
        //        $intCardId = $objData->Data->Params["card_id"];
        //
        //        $objContactUserRelResult = (new ContactCardRelsModule())->getWhere(["card_id" => $intCardId]);
        //
        //        if ($objContactUserRelResult->Result->Count === 0)
        //        {
        //            return $objContactUserRelResult;
        //        }
        //
        //        $arContactList = $objContactUserRelResult->Data->FieldsToArray(["contact_id"]);
        //        $objContactsResult = parent->getWhere(["contact_id", "IN", $arContactList]);
        //
        //        if ($objContactsResult->Result->Count === 0)
        //        {
        //            return $objContactsResult;
        //        }
        //
        //        $objMessageModule = new MobinitiMessagesApiModule();
        //
        //        $objMessageModel = new MobinitiGroupModel();
        //        $objMessageModel->
        //
        //        $objMessageModule->CreateNew();
    }

    public function saveCardPageAppContent(ExcellHttpModel $objData): bool
    {
        $objParams = $objData->Data->Params;
        $objPost   = $objData->Data->PostData;

        try
        {
            $objCardPageResult = (new CardPage())->getById($objParams["id"]);

            if ($objCardPageResult->Result->Success === false)
            {
                return $this->saveNewCardPageWidgetContent($objPost);
            }
            else
            {
                return $this->updateNewCardPageWidgetContent($objCardPageResult->Data->First(), $objPost);
            }
        }
        catch (\Exception $exception)
        {
            return $this->renderReturnJson(false, [], "An error occured during tab update: " . json_encode($exception) . ".");
        }
    }

    public function saveNewCardPageWidgetContent($objPost): bool
    {
        $objCardPage          = new CardPageModel();
        $objCardPage->title   = $objPost->title;
        $objCardPage->content = base64_encode(preg_replace( "/\r|\n/", "", $objPost->content));
        $objCardPage->company_id = $this->app->objCustomPlatform->getCompanyId();
        $objCardPage->division_id = 0;
        $objCardPage->user_id = $this->app->getActiveLoggedInUser()->user_id;
        $objCardPage->created_by = $this->app->getActiveLoggedInUser()->user_id;
        $objCardPage->updated_by = $this->app->getActiveLoggedInUser()->user_id;
        $objCardPage->library_tab = 1;
        $objCardPage->card_tab_type_id = 1;
        $objCardPage->order_number = 1;

        $objCardPageResult = (new CardPage())->getFks()->createNew($objCardPage);

        if ($objCardPageResult->Result->Success === false)
        {
            return $this->renderReturnJson($objCardPageResult->Result->Success, ["quert" => $objCardPageResult->Result->Query], $objCardPageResult->Result->Message);
        }

        return $this->renderReturnJson($objCardPageResult->Result->Success, ["card" => $objCardPageResult->Data->First()->ToPublicArray()], $objCardPageResult->Result->Message);
    }

    public function updateNewCardPageWidgetContent(CardPageModel $objCardPage,  $objPost): bool
    {
        $objCardPage->title   = $objPost->title;
        $objCardPage->content = base64_encode(preg_replace( "/\r|\n/", "", $objPost->content));
        $objCardPageResult = (new CardPage())->update($objCardPage);

        $cardUpdate = new CardModel();
        $cardUpdate->card_id = $objPost->card_id;
        $cardUpdate->last_updated = date("Y-m-d");

        $result = (new Cards())->update($cardUpdate);

        return $this->renderReturnJson($objCardPageResult->Result->Success, ["card" => $objCardPageResult->Data->First()->ToPublicArray()], $objCardPageResult->Result->Message);
    }

    public function getCardPageAppContent(ExcellHttpModel $objData) : bool
    {
        if (!$this->validateRequestType('POST'))
        {
            return false;
        }

//        if (!$this->validateAuthentication($objData))
//        {
//            return $this->renderReturnJson(false, [], "Unauthorized", 401);
//        }

        $objParams= $this->app->objHttpRequest->Data->Params;

        if (!$this->validate($objParams, [
            "id" => "required|integer",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $objCardPages = new CardPage();
        $objCardPagesResult = $objCardPages->getById($objParams["id"]);

        if ($objCardPagesResult->Result->Count !== 1)
        {
            return $this->renderReturnJson(false, $objCardPagesResult->Result->Errors, $objCardPagesResult->Result->Message);
        }

        return $this->renderReturnJson(true, $objCardPagesResult->Data->First()->content, "We got this.");
    }
}
