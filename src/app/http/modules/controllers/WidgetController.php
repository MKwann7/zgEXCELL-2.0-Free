<?php

namespace Entities\Modules\Controllers;

use App\Utilities\Caret\ExcellCarets;
use App\Utilities\Excell\ExcellCollection;
use App\Utilities\Excell\ExcellHttpModel;
use App\Utilities\Transaction\ExcellTransaction;
use Entities\Modules\Classes\AppInstanceRels;
use Entities\Modules\Classes\Base\ModulesController;
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
            "widget_id" => "required|uuid",
            "user_id" => "required|uuid",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $props = $this->setProps($objParams, $objData);

        $configType = self::MainConfigType;

        switch($objParams["type"])
        {
            case "page":
                $configType = self::PageConfigType; break;
            case "card":
                $configType = self::CardConfigType; break;
        }

        return $this->getModuleWidgetConfiguration($objParams["widget_id"], $configType, $objParams["user_id"], $props);
    }

    protected function setProps($objParams, $objData) : ?\stdClass
    {
        $props = null;

        if (!empty($objParams["props"])) {
            $props = json_decode(base64_decode(str_replace("_","=", $objParams["props"])));
        }

        return $props;
    }

    protected function getModuleWidgetConfiguration($moduleWidgetId, $type, $userId, $props = null) : bool
    {
        $localWidgets = (new LocalModuleWidgets())->getWidgets();
        $companyId = $this->app->objCustomPlatform->getCompanyId();

        if ($this->getLocalWidgetCopy($moduleWidgetId, $userId, $companyId, $props))
        {
            return true;
        }

        if (!empty($localWidgets[$moduleWidgetId]))
        {
            $moduleWidget = $localWidgets[$moduleWidgetId]->renderComponentForAjaxDelivery($props);

            $this->saveModuleWidgetInCash($moduleWidget, $moduleWidgetId, $userId, $companyId);

            return $this->getLocalWidgetConfiguration($moduleWidget);
        }

        return $this->getRemoteWidgetConfiguration($moduleWidgetId, $type, $userId, $props);
    }

    protected function saveModuleWidgetInCash($moduleWidget, $moduleWidgetId, $userId, $companyId)
    {
        if (env("MODULE_WIDGET_CASH") === 'true' || env("MODULE_WIDGET_CASH") === 'refresh')
        {
            $storageLocation = AppStorage . "modules/company/" . $companyId . "/user/" . $userId ."/" . $moduleWidgetId . ".widget";

            $fileStorageErrors = [];

            if (!mkdir($concurrentDirectory = AppStorage . "modules") && !is_dir($concurrentDirectory))
            {
                logText("LocalWidgetRetrieval.log", "Unable to create Modules folder.");
                $fileStorageErrors[] = "Unable to create Modules folder.";
            }

            if (!mkdir($concurrentDirectory = AppStorage . "modules/company") && !is_dir($concurrentDirectory))
            {
                logText("LocalWidgetRetrieval.log", "Unable to create Modules/User folder.");
                $fileStorageErrors[] = "Unable to create Modules/Company folder.";
            }

            if (!mkdir($concurrentDirectory = AppStorage . "modules/company/". $companyId) && !is_dir($concurrentDirectory))
            {
                logText("LocalWidgetRetrieval.log", "Unable to create Modules/User folder.");
                $fileStorageErrors[] = "Unable to create Modules/Company/Id folder.";
            }

            if (!mkdir($concurrentDirectory = AppStorage . "modules/company/". $companyId ."/user") && !is_dir($concurrentDirectory))
            {
                logText("LocalWidgetRetrieval.log", "Unable to create Modules/User folder.");
                $fileStorageErrors[] = "Unable to create Modules/Company/Id/User folder.";
            }

            if (!mkdir($concurrentDirectory = AppStorage . "modules/company/". $companyId ."/user/" . $userId) && !is_dir($concurrentDirectory))
            {
                logText("LocalWidgetRetrieval.log", "Unable to create Modules/User/UserId folder.");
                $fileStorageErrors[] = "Unable to create Modules/Company/Id/User/UserId folder.";
            }

            if (count($fileStorageErrors) === 0)
            {
                $result = file_put_contents($storageLocation, base64_encode($moduleWidget));
            }
        }
    }

    protected function getLocalWidgetCopy($moduleWidgetId, $userId, $companyId, $props) : bool
    {
        if (env("MODULE_WIDGET_CASH") === 'true')
        {
            $storageLocation = AppStorage . "modules/company/" . $companyId . "/user/" . $userId ."/" . $moduleWidgetId . ".widget";

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

    protected function getRemoteWidgetConfiguration($moduleWidgetId, $type, $userId, $props) : bool
    {
        $objConfigurationResults = $this->getConfigurationResults($moduleWidgetId, $type);

        if ($objConfigurationResults->Result->Success === false)
        {
            $this->renderReturnJson(false, $objConfigurationResults->Result->Message);
        }

        $this->renderReturnJson($objConfigurationResults->Data->success, $objConfigurationResults->Data->widget, $objConfigurationResults->Data->message, 200, "widget");
    }

    protected function getConfigurationResults($moduleWidgetId, $type) : ExcellTransaction
    {
        $objModuleApps = new ModuleApps();
        $objModuleWidgetResults = $objModuleApps->getLatestModuleWidgetsByUuid($moduleWidgetId);

        if ($objModuleWidgetResults->Result->Count === 0)
        {
            return new ExcellTransaction(false, "Module Widget Not Found: " . $moduleWidgetId);
        }

        $objModuleWidget = $objModuleWidgetResults->Data->First();

        return $objModuleApps->getLatestConfiguration($objModuleWidget, $type);
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

        dd($objCardWidgets);

        $moduleIds = explode("|", $objParams["modules"]);

        foreach($objCardWidgets->Data as $moduleWidget)
        {
            if (!in_array($moduleWidget->widget_instance_uuid, $moduleIds, true))
            {
                $this->renderReturnJson(false, "Error in module request.");
            }
        }

        $modulesForCard = new ExcellCollection();

        foreach($objCardWidgets->Data as $moduleWidget)
        {
            $objModuleApps        = new ModuleApps();
            $objModuleWidgetResults = $objModuleApps->getLatestWidgetContentForCard($objParams["id"], $moduleWidget);

            if ($objModuleWidgetResults->Result->Success === false)
            {
                $response = new \stdClass();
                $response->type = vue;
                $response->content = "";
                $response->error = true;
                $response->message = "Drat. There was an error loading this module: " . $objModuleWidgetResults->Result->Message;

                $modulesForCard->Add($moduleWidget->widget_instance_uuid, $response);

                continue;
            }

            $response = $objModuleWidgetResults->Data;

            if (empty($response->data) || empty($response->data->type) || empty($response->data->content))
            {
                $response = new \stdClass();
                $response->type = vue;
                $response->content = "";
                $response->error = true;
                $response->message = "Oops! This module has no content to render!";

                $modulesForCard->Add($moduleWidget->widget_instance_uuid, $response);

                continue;
            }

            $modulesForCard->Add($moduleWidget->widget_instance_uuid, $response->data);
        }

        $this->renderReturnJson(true, $modulesForCard->ToPublicArray(null, true), "We did it!", 200);
    }
}