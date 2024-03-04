<?php

namespace Http\Modules\Controllers;

use App\Utilities\Caret\ExcellCarets;
use App\Utilities\Excell\ExcellCollection;
use App\Utilities\Excell\ExcellHttpModel;
use App\Utilities\Transaction\ExcellTransaction;
use Entities\Modules\Classes\AppInstanceRels;
use Entities\Modules\Classes\AppInstanceRelSettings;
use Entities\Modules\Models\AppInstanceRelSettingModel;
use Http\Modules\Controllers\Base\ModulesController;
use Entities\Modules\Classes\LocalModuleWidgets;
use Entities\Modules\Classes\ModuleApps;

class WidgetController extends ModulesController
{
    public const MainConfigType = 1000;
    public const CardConfigType = 1001;
    public const PageConfigType = 1002;

    public function config(ExcellHttpModel $objData) : bool
    {
        if (!$this->validateRequestType('GET'))
        {
            return false;
        }

//        if (!$this->validateActiveSession($objData))
//        {
//            return false;
//        }

        $objParams = $this->app->objHttpRequest->Data->Params;

        if (!$this->validate($objParams, [
            "widget_id" => "required",
            "user_id" => "required",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        if (!isGuid($objParams["user_id"]) && $objParams["user_id"] !== "visitor") {
            return $this->renderReturnJson(false, ["user_id" => "user_id is invalid"], "Validation errors.");
        }

        $props = $this->setProps($objParams, $objData);

        $configType = self::MainConfigType;

        switch($objParams["type"] ?? "page")
        {
            case "page":
                $configType = self::PageConfigType; break;
            case "card":
                $configType = self::CardConfigType; break;
        }

        $widgetId = $objParams["widget_id"];
        if (str_contains($widgetId, "_")) {
            $widgetId = explode("_", $objParams["widget_id"])[0];
            $configType = explode("_", $objParams["widget_id"])[1];
        }

        return $this->getModuleWidgetConfiguration($widgetId, $configType, $objParams["user_id"], $props);
    }

    protected function setProps($objParams, $objData) : ?\stdClass
    {
        $props = null;

        if (!empty($objParams["props"])) {
            $props = json_decode(base64_decode(str_replace("_","=", $objParams["props"])));
            if ($props === false) {
                $props = null;
            }
        }

        if (!empty($objParams["site_id"])) {
            if ($props === null) {
                $props = new \stdClass();
            }
            $props->site_id = $objParams["site_id"];
        }

        return $props;
    }

    protected function getModuleWidgetConfiguration($moduleWidgetId, $type, $userId, $props = null) : bool
    {
        $localWidgets = (new LocalModuleWidgets())->getWidgets();
        $companyId = $this->app->objCustomPlatform->getCompanyId();

        if ($this->getLocalWidgetCopy($moduleWidgetId, $userId, $companyId, $props)) {
            return true;
        }

        if (!empty($localWidgets[$moduleWidgetId])) {
            $moduleWidget = $localWidgets[$moduleWidgetId]->renderComponentForAjaxDelivery($props);
            $this->saveModuleWidgetInCash($moduleWidget, $moduleWidgetId, $userId, $companyId);

            return $this->getLocalWidgetConfiguration($moduleWidget);
        }

        return $this->getRemoteWidgetConfiguration($moduleWidgetId, $type, $userId, $props);
    }

    protected function saveModuleWidgetInCash($moduleWidget, $moduleWidgetId, $userId, $companyId)
    {
        if (env("MODULE_WIDGET_CASH") === 'true' || env("MODULE_WIDGET_CASH") === 'refresh') {
            $storageLocation = APP_STORAGE . "modules/company/" . $companyId . "/user/" . $userId ."/" . $moduleWidgetId . ".widget";

            $fileStorageErrors = [];

            if (!is_dir($concurrentDirectory = APP_STORAGE . "modules") && !mkdir($concurrentDirectory)) {
                logText("LocalWidgetRetrieval.log", "Unable to create Modules folder.");
                $fileStorageErrors[] = "Unable to create Modules folder.";
            }

            if (!is_dir($concurrentDirectory = APP_STORAGE . "modules/company") && !mkdir($concurrentDirectory)) {
                logText("LocalWidgetRetrieval.log", "Unable to create Modules/User folder.");
                $fileStorageErrors[] = "Unable to create Modules/Company folder.";
            }

            if (!is_dir($concurrentDirectory = APP_STORAGE . "modules/company/". $companyId) && !mkdir($concurrentDirectory)) {
                logText("LocalWidgetRetrieval.log", "Unable to create Modules/User folder.");
                $fileStorageErrors[] = "Unable to create Modules/Company/Id folder.";
            }

            if (!is_dir($concurrentDirectory = APP_STORAGE . "modules/company/". $companyId ."/user") && !mkdir($concurrentDirectory))
            {
                logText("LocalWidgetRetrieval.log", "Unable to create Modules/User folder.");
                $fileStorageErrors[] = "Unable to create Modules/Company/Id/User folder.";
            }

            if (!is_dir($concurrentDirectory = APP_STORAGE . "modules/company/". $companyId ."/user/" . $userId) && !mkdir($concurrentDirectory)) {
                logText("LocalWidgetRetrieval.log", "Unable to create Modules/User/UserId folder.");
                $fileStorageErrors[] = "Unable to create Modules/Company/Id/User/UserId folder.";
            }

            if (count($fileStorageErrors) === 0) {
                $result = file_put_contents($storageLocation, base64_encode($moduleWidget));
            }
        }
    }

    protected function getLocalWidgetCopy($moduleWidgetId, $userId, $companyId, $props) : bool
    {
        if (env("MODULE_WIDGET_CASH") === 'true')
        {
            $storageLocation = APP_STORAGE . "modules/company/" . $companyId . "/user/" . $userId ."/" . $moduleWidgetId . ".widget";

            if (is_file($storageLocation))
            {
                $result = file_get_contents($storageLocation);
                $result = base64_encode((new ExcellCarets())->processExternalCarets(base64_decode($result), $props));

                $this->renderReturnJson(true, $result, "I found widget data.", 200, "widget");
                return true;
            }
        }

        return false;
    }

    protected function getRemoteWidgetConfiguration($moduleWidgetId, $type, $userId, $props = null) : bool
    {
        $objConfigurationResults = $this->getConfigurationResults($moduleWidgetId, $type, $props);

        if ($objConfigurationResults->getResult()->Success === false || $objConfigurationResults->getData()->first() === null) {
            $this->renderReturnJson(false, $objConfigurationResults->getResult()->Message);
        }

        return $this->renderReturnJson($objConfigurationResults->getData()->first()->widget !== null ?? false, $objConfigurationResults->getData()->first()->widget, $objConfigurationResults->getData()->first()->widget !== null ? $objConfigurationResults->getResult()->Message : ($objConfigurationResults->getData()->first()), $objConfigurationResults->getData()->first()->widget !== null ? 200 : 500, "widget");
    }

    protected function getConfigurationResults($moduleWidgetId, $type, $props = null) : ExcellTransaction
    {
        $objModuleApps = new ModuleApps();
        $objModuleWidgetResults = $objModuleApps->getLatestModuleAppsByUuid($moduleWidgetId);

        if ($objModuleWidgetResults->result->Count === 0) {
            return new ExcellTransaction(false, "Module Widget Not Found: " . $moduleWidgetId);
        }

        $objModuleWidget = $objModuleWidgetResults->getData()->first();

        return $objModuleApps->getLatestConfiguration($objModuleWidget, $type, $props);
    }

    protected function getLocalWidgetConfiguration($vueComponent) : bool
    {
        $this->renderReturnJson(true, base64_encode($vueComponent), "I found widget data.", 200, "widget");
    }

    public function widgetRealEstateTakeoff(ExcellHttpModel $objData) : bool
    {
        die('<div class="protoio-embed-prototype" data-code="R7I330" data-show-sidebuttons="0" style="width: 100%; height: 800px;"></div>
<script async src="https://static.proto.io/api/widget-embed.js"></script>');
    }

    public function cardWidget(ExcellHttpModel $objData) : bool
    {
        if (!$this->validateRequestType('GET'))
        {
            return false;
        }

        $objParams = $objData->Data->Params;

        if (!$this->validate($objParams, [
            "id" => "required|number",
            "modules" => "required"
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $objModuleApp = new AppInstanceRels();
        $objCardWidgets = $objModuleApp->getByCardId($objParams["id"],[1003]);

        //dd($objCardWidgets);

        $moduleIds = explode("|", $objParams["modules"]);

        foreach($objCardWidgets->data as $moduleWidget)
        {
            if (!in_array($moduleWidget->instance_uuid, $moduleIds, true))
            {
                $this->renderReturnJson(false, "Error in module request.");
            }
        }

        $modulesForCard = new ExcellCollection();

        foreach($objCardWidgets->data as $moduleWidget)
        {
            $objModuleApps        = new ModuleApps();
            $objModuleWidgetResults = $objModuleApps->getLatestWidgetContentForCard($objParams["id"], $moduleWidget);

            if ($objModuleWidgetResults->result->Success === false)
            {
                $response = new \stdClass();
                $response->type = "vue";
                $response->content = "";
                $response->error = true;
                $response->message = "Drat. There was an error loading this module: " . $objModuleWidgetResults->result->Message;

                $modulesForCard->Add($moduleWidget->instance_uuid, $response);

                continue;
            }

            $response = $objModuleWidgetResults->getData()->first();

            if (empty($response->data) || empty($response->data->type) || empty($response->getData()->content))
            {
                $response = new \stdClass();
                $response->type = "vue";
                $response->content = "";
                $response->error = true;
                $response->message = "Oops! This module has no content to render!";

                $modulesForCard->Add($moduleWidget->instance_uuid, $response);

                continue;
            }

            $modulesForCard->Add($moduleWidget->instance_uuid, $response->data);
        }

        return $this->renderReturnJson(true, $modulesForCard->ToPublicArray(null, true), "We did it!", 200);
    }

    public function updateSetting(ExcellHttpModel $objData) : bool
    {
        if (!$this->validateRequestType('POST'))
        {
            return false;
        }

        $objParams = $objData->Data->Params;
        $objPost = $objData->Data->PostData;

        if (!$this->validate($objParams, [
            "id" => "required|number"
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $settings = json_decode(json_encode($objPost), true);
        $appInstanceRelSettings = new AppInstanceRelSettings();
        $appInstanceRelResult = $appInstanceRelSettings->getWhere(["app_instance_rel_id" => $objParams["id"]]);

        foreach ($settings as $currLabel => $currValue) {
            $appInstanceRelModel = $appInstanceRelResult->getData()->FindEntityByValue("label", $currLabel);
            if (empty($appInstanceRelModel)) {
                $appInstanceRelModel = new AppInstanceRelSettingModel(["app_instance_rel_id" => $objParams["id"], "label" => $currLabel, "value" => $currValue]);
                $appInstanceRelSettings->createNew($appInstanceRelModel);
                continue;
            }
            $appInstanceRelModel->value = $currValue;
            $appInstanceRelSettings->update($appInstanceRelModel);
        }

        return $this->renderReturnJson(true, ["batch" => $objPost->desk_max_row_count]);
    }
}