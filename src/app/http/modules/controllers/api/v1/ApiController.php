<?php

namespace Http\Modules\Controllers\Api\V1;

use App\Utilities\Database;
use App\Utilities\Excell\ExcellHttpModel;
use App\Utilities\Transaction\ExcellTransaction;
use Entities\Cards\Classes\CardAddon;
use Entities\Cards\Classes\CardPage;
use Entities\Cards\Classes\CardPageRels;
use Entities\Cards\Classes\Cards;
use Entities\Emails\Classes\Emails;
use Entities\Modules\Classes\AppInstanceRels;
use Entities\Modules\Classes\AppInstances;
use Entities\Cards\Models\CardAddonModel;
use Entities\Companies\Classes\Companies;
use Entities\Modules\Classes\Authorizations;
use Http\Modules\Controllers\Base\ModulesController;
use Entities\Modules\Classes\ModuleAppWidgets;
use Entities\Modules\Classes\ModuleAppEndpoints;
use Entities\Modules\Classes\ModuleApps;
use Entities\Modules\Models\AppInstanceRelModel;
use Entities\Modules\Models\AuthorizationModel;
use Entities\Modules\Models\ModuleMainModel;
use Entities\Modules\Classes\Modules;
use Entities\Modules\Models\ModuleAppModel;
use Entities\Orders\Classes\OrderLines;
use Entities\Orders\Classes\Orders;
use Entities\Users\Classes\Users;
use Entities\Orders\Models\OrderLineModel;

class ApiController extends ModulesController
{
    /*
     *  -------------- API Routing
     */

    /**
     * @param ExcellHttpModel $objData
     * @return bool
     */
    public function index(ExcellHttpModel $objData) : bool
    {
        switch ($this->getRequestType())
        {
            case 'get';
                return $this->read($objData);
            case 'post';
                return $this->create($objData);
            case 'put';
                return $this->update($objData);
            case 'delete';
                return $this->delete($objData);
        }
    }

    /**
     * @param ExcellHttpModel $objData
     * @return bool
     */
    public function authorize(ExcellHttpModel $objData) : bool
    {
        switch ($this->getRequestType())
        {
            case 'get';
                return $this->readAuthorization($objData);
            case 'post';
                return $this->createAuthorization($objData);
        }
    }

    public function widget(ExcellHttpModel $objData) : bool
    {
        switch ($this->getRequestType())
        {
            case 'get';
                return $this->readWidget($objData);
            case 'post';
                return $this->createWidget($objData);
            case 'put';
                return $this->updateWidget($objData);
            case 'delete';
                return $this->deleteWidget($objData);
        }
    }


    /*
     *  -------------- Module
     */

    /**
     * @param ExcellHttpModel $objData
     * @return bool
     */
    protected function read(ExcellHttpModel $objData) : bool
    {
        $objJsonForSync = $this->app->objHttpRequest->Data->Params;

        if (!$this->validate($objJsonForSync, [
            "id" => "required|uuid",
            "version" => "required",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $guidId = $objJsonForSync["id"];
        $version = $objJsonForSync["version"];

        $objModuleResult = $this->getModule($guidId, $version);

        /** @var ModuleMainModel $module */
        $module = $objModuleResult->getData()->first();

        return $this->renderReturnJson(true, $module->ToPublicArray(), "Module found.");
    }

    /**
     * @param ExcellHttpModel $objData
     * @return bool
     */
    protected function create(ExcellHttpModel $objData) : bool
    {
        $objJsonForSync = $objData->Data->PostData;

        if (!$this->validate($objJsonForSync, [
            "authorization_token" => "required|uuid",
            "name" => "required",
            "version" => "required"
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $objAuthorization = new Authorizations();
        $objAuthorizationResult = $objAuthorization->getWhere(["authorization_uuid" => $objJsonForSync->authorization_token]);

        if ($objAuthorizationResult->result->Count === 0)
        {
            return $this->renderReturnJson(false, null, "There is no Authorization request for this token. Id: {$objJsonForSync->authorization_token}");
        }

        $objModule = new Modules();
        $objModuleResult = $objModule->getWhere(["module_uuid" => $objAuthorizationResult->getData()->first()->record_uuid, "version" => $objJsonForSync->version]);

        if ($objModuleResult->result->Count > 0)
        {
            return $this->renderReturnJson(false, ["module_version_exists" => ["token" => $objAuthorizationResult->getData()->first()->record_uuid, "version" => $objJsonForSync->version]], "There is already an existing module with this name and version. Module Id: {$objAuthorizationResult->getData()->first()->record_uuid}, version: {$objJsonForSync->version}");
        }

        $module = new ModuleMainModel();
        $module->name = $objJsonForSync->name;
        $module->module_uuid= $objAuthorizationResult->getData()->first()->record_uuid;
        $module->company_id = $objAuthorizationResult->getData()->first()->company_id;
        $module->author = $objJsonForSync->author;
        $module->version = $objJsonForSync->version;
        $module->category = $objJsonForSync->category;
        $module->tags = $objJsonForSync->tags;

        $objNewModuleResult = $objModule->createNew($module);

        if ($objModuleResult->result->Success === false)
        {
            return $this->renderReturnJson(false, ["query" => $objNewModuleResult->result->Query], $objNewModuleResult->result->Message);
        }

        return $this->renderReturnJson(true, $objNewModuleResult->getData()->first()->ToPublicArray(), $objNewModuleResult->result->Message);
    }

    /**
     * @param ExcellHttpModel $objData
     * @return bool
     */
    protected function update(ExcellHttpModel $objData) : bool
    {
        $objJsonForSync = $this->app->objHttpRequest->Data->PostData;

        if (!$this->validate($objJsonForSync, [
            "id" => "required|uuid",
            "version" => "required"
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $objAuthorization = new Authorizations();
        $objAuthorizationResult = $objAuthorization->getWhere(["record_uuid" => $objJsonForSync->id]);

        if ($objAuthorizationResult->result->Count === 0)
        {
            return $this->renderReturnJson(false, null, "There is no Authorization request for this token. Module Id: {$objJsonForSync->id}");
        }

        $objModuleResult = $this->getModule($objJsonForSync->id, $objJsonForSync->version);

        $module = $objModuleResult->getData()->first();
        $module->name = $objJsonForSync->name ?? $module->name;
        $module->author = $objJsonForSync->author ?? $module->author;
        $module->version = $objJsonForSync->version ?? $module->version;
        $module->category = $objJsonForSync->category ?? $module->category;
        $module->tags = $objJsonForSync->tags ?? $module->tags;

        $objModule = new Modules();
        $objNewModuleResult = $objModule->update($module);

        if ($objModuleResult->result->Success === false)
        {
            return $this->renderReturnJson(false, ["query" => $objNewModuleResult->result->Query], $objNewModuleResult->result->Message);
        }

        return $this->renderReturnJson(true, $objNewModuleResult->getData()->first()->ToPublicArray(), $objNewModuleResult->result->Message);
    }

    protected function delete(ExcellHttpModel $objData) : bool
    {
        // Delete with deletion authorization?
    }

    /*
     *  -------------- Authorization
     */

    /**
     * @param ExcellHttpModel $objData
     * @return bool
     */
    protected function readAuthorization(ExcellHttpModel $objData) : bool
    {
        $objJsonForSync = $this->app->objHttpRequest->Data->Params;

        if (!$this->validate($objJsonForSync, [
            "id" => "required|uuid"
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $guidId = $objJsonForSync["id"];

        $objAuthorizationResult = $this->getAuthorization($guidId);

        /** @var ModuleMainModel $authorization */
        $authorization = $objAuthorizationResult->getData()->first();

        return $this->renderReturnJson(true, $authorization->ToPublicArray(), "Authorization found.");
    }

    /**
     * @param ExcellHttpModel $objData
     * @return bool
     */
    protected function createAuthorization(ExcellHttpModel $objData) : bool
    {
        $objJsonForSync = $this->app->objHttpRequest->Data->PostData;

        if (!$this->validate($objJsonForSync, [
            "id" => "required|uuid",
            "company_id" => "required|integer",
            "type" => "required",
            "name" => "required",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $objAuthorization = new Authorizations();
        $objAuthorizationResult = $objAuthorization->getWhere(["authorization_uuid" => $objJsonForSync->id]);

        if ($objAuthorizationResult->result->Count > 0)
        {
            return $this->renderReturnJson(false, null, "An authorization already exists for this token. Id: {$objJsonForSync->id}");
        }

        $objCompany = new Companies();
        $objCompanyResult = $objCompany->getwhere(["company_id" => $objJsonForSync->company_id]);

        if ($objCompanyResult->result->Count === 0)
        {
            return $this->renderReturnJson(false, null, "No company exists for id: {$objJsonForSync->company_id}");
        }

        $authorization = new AuthorizationModel();
        $authorization->authorization_uuid = $objJsonForSync->id;
        $authorization->company_id = $objJsonForSync->company_id;
        $authorization->type = $objJsonForSync->type;
        $authorization->record_uuid = getGuid();
        $authorization->name = $objJsonForSync->name;
        $authorization->description = $objJsonForSync->description ?? null;

        $objNewAuthorizationResult = $objAuthorization->createNew($authorization);

        if ($objNewAuthorizationResult->result->Success === false)
        {
            return $this->renderReturnJson(false, ["query" => $objNewAuthorizationResult->result->Query], $objNewAuthorizationResult->result->Message);
        }

        return $this->renderReturnJson(true, $objNewAuthorizationResult->getData()->first()->ToPublicArray(), "Authorization created.");
    }

    /*
     *  -------------- Widget
     */

    /**
     * @param ExcellHttpModel $objData
     * @return bool
     */
    protected function readWidget(ExcellHttpModel $objData) : bool
    {
        $objJsonForSync = $this->app->objHttpRequest->Data->Params;

        if (!$this->validate($objJsonForSync, [
            "id" => "required|uuid",
            "version" => "required",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $guidId = $objJsonForSync["id"];
        $version = $objJsonForSync["version"];

        $objModuleResult = $this->getModuleWidget($guidId, $version);

        /** @var ModuleMainModel $module */
        $module = $objModuleResult->getData()->first();

        $objModule = new Modules();
        $objModuleResult = $objModule->getWhere(["module_id" => $module->module_id]);
        $objModuleResult->getData();

        if ($objModuleResult->result->Count !== 1)
        {
            return $this->renderReturnJson(false, null, "Widget installed incorrectly. No parent module found.");
        }

        $module->AddUnvalidatedValue("module_version", $objModuleResult->getData()->first()->version,true);
        $module->AddUnvalidatedValue("module", $objModuleResult->getData()->first()->module_uuid,true);

        $objWidgetEndpoints = new ModuleAppEndpoints();
        $module->AddUnvalidatedValue("endpoints", $objWidgetEndpoints->getWhere(["module_app_id" => $module->module_id])->getData()->ToPublicArray());

        $objWidgetComponents = new ModuleAppWidgets();
        $module->AddUnvalidatedValue("components", $objWidgetComponents->getWhere(["module_app_id" => $module->module_id])->getData()->ToPublicArray());

        return $this->renderReturnJson(true, $module->ToPublicArray(), "Widget found.");
    }

    protected function createWidget(ExcellHttpModel $objData) : bool
    {
        $objJsonForSync = $this->app->objHttpRequest->Data->PostData;

        if (!$this->validate($objJsonForSync, [
            "authorization_token" => "required|uuid",
            "module_version" => "required",
            "name" => "required",
            "domain" => "required",
            "version" => "required",
            "ui_type" => "required",
            "category" => "required"
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $objAuthorization = new Authorizations();
        $objAuthorizationResult = $objAuthorization->getWhere(["authorization_uuid" => $objJsonForSync->authorization_token]);

        if ($objAuthorizationResult->result->Count === 0)
        {
            return $this->renderReturnJson(false, null, "There is no Authorization request for this token. Id: {$objJsonForSync->authorization_token}");
        }

        $objModule = new Modules();
        $objModuleResult = $objModule->getWhere(["module_uuid" => $objAuthorizationResult->getData()->first()->parent_uuid, "version" => $objJsonForSync->module_version]);

        if ($objModuleResult->result->Count === 0)
        {
            return $this->renderReturnJson(false, [], "No module exists with this name and version. Module Id: {$objAuthorizationResult->getData()->first()->parent_uuid}, version: {$objJsonForSync->module_version}");
        }

        $objModuleWidget = new ModuleApps();
        $objModuleWidgetResult = $objModuleWidget->getWhere(["app_uuid" => $objAuthorizationResult->getData()->first()->record_uuid, "version" => $objJsonForSync->version]);

        if ($objModuleWidgetResult->result->Count > 0)
        {
            return $this->renderReturnJson(false, ["widget_version_exists" => ["token" => $objAuthorizationResult->getData()->first()->record_uuid, "version" => $objJsonForSync->version]], "There is already an existing widget with this name and version. Widget Id: {$objAuthorizationResult->getData()->first()->record_uuid}, version: {$objJsonForSync->version}");
        }

        $moduleWidget = new ModuleAppModel();
        $moduleWidget->module_id = $objModuleResult->getData()->first()->module_id;
        $moduleWidget->company_id = $objModuleResult->getData()->first()->company_id;
        $moduleWidget->app_uuid = $objAuthorizationResult->getData()->first()->record_uuid;
        $moduleWidget->name = $objJsonForSync->name;
        $moduleWidget->author = $objJsonForSync->author ?? $objModuleResult->getData()->first()->author;
        $moduleWidget->version = $objJsonForSync->version;
        $moduleWidget->domain = $objJsonForSync->domain;
        $moduleWidget->ui_type = $objJsonForSync->ui_type;
        $moduleWidget->category = $objJsonForSync->category;
        $moduleWidget->tags = $objJsonForSync->tags;

        $objNewModuleWidgetResult = $objModuleWidget->createNew($moduleWidget);

        if ($objModuleResult->result->Success === false)
        {
            return $this->renderReturnJson(false, ["query" => $objNewModuleWidgetResult->result->Query], $objNewModuleWidgetResult->result->Message);
        }

        return $this->renderReturnJson(true, $objNewModuleWidgetResult->getData()->first()->ToPublicArray(), "Widget created.");
    }

    /**
     * @param ExcellHttpModel $objData
     * @return bool
     */
    protected function updateWidget(ExcellHttpModel $objData) : bool
    {
        $objJsonForSync = $this->app->objHttpRequest->Data->PostData;

        if (!$this->validate($objJsonForSync, [
            "id" => "required|uuid",
            "version" => "required"
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $objAuthorization = new Authorizations();
        $objAuthorizationResult = $objAuthorization->getWhere(["record_uuid" => $objJsonForSync->id]);

        if ($objAuthorizationResult->result->Count === 0)
        {
            return $this->renderReturnJson(false, null, "There is no Authorization request for this token. Widget Id: {$objJsonForSync->id}");
        }

        $objModuleResult = $this->getModuleWidget($objJsonForSync->id, $objJsonForSync->version);

        $moduleWidget = $objModuleResult->getData()->first();
        $moduleWidget->name = $objJsonForSync->name;
        $moduleWidget->author = $objJsonForSync->author;
        $moduleWidget->domain = $objJsonForSync->domain ?? $moduleWidget->domain;
        $moduleWidget->version = $objJsonForSync->version ?? $moduleWidget->version;
        $moduleWidget->domain = $objJsonForSync->domain ?? $moduleWidget->domain;
        $moduleWidget->ui_type = $objJsonForSync->ui_type ?? $moduleWidget->ui_type;
        $moduleWidget->category = $objJsonForSync->category ?? $moduleWidget->category;
        $moduleWidget->tags = $objJsonForSync->tags ?? $moduleWidget->tags;

        $objModuleApps = new ModuleApps();
        $objNewModuleResult = $objModuleApps->update($moduleWidget);

        if ($objModuleResult->result->Success === false)
        {
            return $this->renderReturnJson(false, ["query" => $objNewModuleResult->result->Query], $objNewModuleResult->result->Message);
        }

        return $this->renderReturnJson(true, $objNewModuleResult->getData()->first()->ToPublicArray(), $objNewModuleResult->result->Message);
    }

    /*
     *  -------------- Helpers
     */

    /**
     * @param $uuid
     * @param $version
     * @return ExcellTransaction
     */

    protected function getModule($uuid, $version) : ExcellTransaction
    {
        $objModule = new Modules();
        $objModuleResult = $objModule->getWhere(["module_uuid" => $uuid, "version" => $version]);
        $objModuleResult->getData();

        if ($objModuleResult->result->Count !== 1)
        {
            return $this->renderReturnJson(false, null, "No module found for id: $uuid, version: $version");
        }

        return $objModuleResult;
    }

    /**
     * @param $uuid
     * @return ExcellTransaction
     */
    protected function getAuthorization($uuid) : ExcellTransaction
    {
        $objModule = new Authorizations();
        $objModuleResult = $objModule->getWhere(["authorization_uuid" => $uuid]);
        $objModuleResult->getData();

        if ($objModuleResult->result->Count === 0)
        {
            return $this->renderReturnJson(false, null, "No module authorization found for token: $uuid,");
        }

        return $objModuleResult;
    }

    protected function getModuleWidget($uuid, $version) : ExcellTransaction
    {
        $objModuleWidget = new ModuleApps();
        $objModuleWidgetResult = $objModuleWidget->getWhere(["app_uuid" => $uuid, "version" => $version]);
        $objModuleWidgetResult->getData();

        if ($objModuleWidgetResult->result->Count !== 1)
        {
            return $this->renderReturnJson(false, null, "No widget found for id: $uuid, version: $version");
        }

        return $objModuleWidgetResult;
    }

    public function getUserList(ExcellHttpModel $objData) : bool
    {
        $customPlatformId = $this->app->objCustomPlatform->getCompany()->company_id;

        $objUsersResult = (new Users())->getWhere(["company_id" => $customPlatformId, "status" => "Active"]);
        $users = $objUsersResult->getData()->ToPublicArray(["user_id", "first_name", "last_name"]);

        return $this->renderReturnJson(true, $users, "We found these users in the system.");
    }

    public function updateCardPageData(ExcellHttpModel $objData) : bool
    {
        $objParams = $objData->Data->Params;

        if (!$this->validate($objParams, [
            "company_id" => "required|integer",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $objPost = $objData->Data->PostData;

        if (!$this->validate($objPost, [
            "app_uuid" => "required|uuid",
            "title" => "required",
            "user_id" => "required|integer"
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $objPageWidgets = new AppInstances();
        $objPageWidgetResult = $objPageWidgets->getWhere(["instance_uuid" => $objPost->app_uuid]);

        if ($objPageWidgetResult->result->Count !== 1)
        {
            return $this->renderReturnJson(false, [], "Widget not found.");
        }

        $objCardPage = new CardPage();
        $objCardPageResult = $objCardPage->getWhere(["card_tab_id" => $objPageWidgetResult->getData()->first()->card_tab_id]);

        if ($objCardPageResult->result->Count !== 1)
        {
            return $this->renderReturnJson(false, [], "Card page not found.");
        }

        $cardPage = $objCardPageResult->getData()->first();

        $cardPage->title = $objPost->title;
        $cardPage->user_id = $objPost->user_id;
        $updateResult = $objCardPage->update($cardPage);

        return $this->renderReturnJson($updateResult->result->Success, [], "Request processed.");
    }

    public function getAppBatches(ExcellHttpModel $objData) : bool
    {
        $pageIndex  = $objData->Data->Params["offset"] ?? 1;
        $batchCount = $objData->Data->Params["batch"] ?? 500;
        $filterEntity = $objData->Data->Params["filterEntity"] ?? null;
        $pageIndex  = ($pageIndex - 1) * $batchCount;
        $arFields   = explode(",", $objData->Data->Params["fields"]);
        $strEnd     = "false";

        $objWhereClause = "
            SELECT 
                air.*,
                air.app_instance_rel_id AS id,
                air.card_page_rel_id AS on_page,
                air.card_id AS on_card,
                (SELECT platform_name FROM `excell_main`.`company` WHERE company.company_id = air.company_id LIMIT 1) AS platform,
                (SELECT display_name FROM `excell_main`.`product` WHERE product.product_id = ai.product_id ORDER BY product_id DESC LIMIT 1) AS display_name,
                (SELECT CONCAT(user.first_name, ' ', user.last_name) FROM `excell_main`.`user` WHERE user.user_id = air.user_id LIMIT 1) AS user_name,
                ca.order_line_id,
                (SELECT source_uuid FROM `excell_main`.`product` WHERE product.product_id = ai.product_id ORDER BY product_id DESC LIMIT 1) AS app_uuid,
                ai.module_app_id AS app_id,
                air.module_app_widget_id AS app_widget_id,
                ai.instance_uuid
            FROM 
                `excell_main`.`app_instance_rel` air
            LEFT JOIN `excell_main`.app_instance ai ON ai.app_instance_id = air.app_instance_id
            LEFT JOIN `excell_main`.card_addon ca ON ca.card_addon_id = air.card_addon_id
            ";

        $objWhereClause .= "WHERE air.company_id = {$this->app->objCustomPlatform->getCompanyId()}";

        if ($filterEntity !== null)
        {
            $objWhereClause .= " AND air.card_id = {$filterEntity}";
        }

        $objWhereClause .= " ORDER BY air.app_instance_rel_id DESC LIMIT {$pageIndex}, {$batchCount}";

        $appInstanceResult = Database::getSimple($objWhereClause, "app_instance_rel_id");

        if ($appInstanceResult->getData()->Count() < $batchCount)
        {
            $strEnd = "true";
        }

        $appInstanceResult->getData()->HydrateModelData(AppInstanceRelModel::class, true);

        $arUserDashboardInfo = array(
            "list" => $appInstanceResult->getData()->FieldsToArray($arFields),
            //"query" => $objWhereClause,
        );

        return $this->renderReturnJson(true, $arUserDashboardInfo, "We found " . $appInstanceResult->getData()->Count() . " apps in this batch.", 200, "data", $strEnd);
    }

    public function sendModuleOwnerNotification(ExcellHttpModel $objData) : bool
    {
        if (!$this->validateRequestType('POST'))
        {
            return false;
        }

        $objPost = $objData->Data->PostData;

        if (!$this->validate($objPost, [
            "module_app_uuid" => "required|uuid",
            "instance_uuid" => "required|uuid",
            "subject" => "required",
            "body" => "required",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $moduleAppResult = (new ModuleApps())->getLatestModuleAppsByUuid($objPost->module_app_uuid);

        if ($moduleAppResult->result->Count !== 1)
        {
            return $this->renderReturnJson(false, [], "Module app page not found.");
        }

        //$appInstanceRel =

        $customPlatformName = $this->app->objCustomPlatform->getPortalName();
        $customPlatformNoReplyEmail = $this->app->objCustomPlatform->getCompanySettings()->FindEntityByValue("label", "noreply_email")->value ?? "noreply@ezdigital.com";
        $customPlatformSupportEmail = $this->app->objCustomPlatform->getCompanySettings()->FindEntityByValue("label", "customer_support_email")->value ?? "support@ezdigital.com";

        $strEmailFullName = "Micah Zak";
        $strUserEmail = "micah@zakgraphix.com";
        $strSubject = $objPost->subject;
        $strBody = "<p>Hi Micah,</p>" .
            $objPost->body .
            "<p>Your {$customPlatformName} App Team<br>{$customPlatformSupportEmail}</p>";

        (new Emails())->SendEmail(
            $customPlatformName . " Support <{$customPlatformNoReplyEmail}>",
            ["{$strEmailFullName} <{$strUserEmail}>"],
            $strSubject,
            $strBody
        );

        return $this->renderReturnJson(true, [], "Message sent successfully.");
    }

    public function getUserModules(ExcellHttpModel $objData) : bool
    {
        
    }
}