<?php

namespace Entities\Modules\Controllers;

use App\Utilities\Excell\ExcellHttpModel;
use Entities\Modules\Classes\Base\ModulesController;
use Entities\Modules\Classes\Modules;
use Entities\Modules\Components\Vue\ModulesAdminApp;
use Entities\Modules\Components\Vue\ModulesMainApp;
use Entities\Modules\Components\Vue\AppsWidget\ManageModuleAppsAdminWidget;
use Entities\Modules\Components\Vue\AppsWidget\ManageModuleAppsWidget;

class IndexController extends ModulesController
{
    public function index(ExcellHttpModel $objData) : bool
    {
        if (!$this->validateRequestType('GET'))
        {
            return false;
        }

        if($this->app->isAdminUrlRequest())
        {
            if($this->app->isUserLoggedIn())
            {
                if($this->app->strActivePortalBinding === "account")
                {
                    $this->renderModuleDashboard($objData);
                }
                elseif($this->app->strActivePortalBinding === "account/admin")
                {
                    $this->renderModulesAdminList($objData);
                }
            }
            else
            {
                $this->app->redirectToLogin();
            }
        }

        return false;
    }

    protected function renderModuleDashboard(ExcellHttpModel $objData) : void
    {
        $vueApp = (new ModulesMainApp("vueApp"))
            ->setUriBase($objData->PathControllerBase)
            ->registerComponentAbstracts([
                ManageModuleAppsWidget::getStaticId() => ManageModuleAppsWidget::getStaticUriAbstract(),
            ]);

        (new Modules())->renderApp(
            "user.view_my_modules",
            $this->app->strAssignedPortalTheme,
            $vueApp
        );
    }

    protected function renderModulesAdminList(ExcellHttpModel $objData) : void
    {
        $vueApp = (new ModulesAdminApp("vueApp"))
            ->setUriBase($objData->PathControllerBase)
            ->registerComponentAbstracts([
                ManageModuleAppsAdminWidget::getStaticId() => ManageModuleAppsAdminWidget::getStaticUriAbstract(),
            ]);

        (new Modules())->renderApp(
            "admin.list_modules",
            $this->app->strAssignedPortalTheme,
            $vueApp
        );
    }

    public function register(ExcellHttpModel $objData) : bool
    {
        if (!$this->validateRequestType('POST'))
        {
            return false;
        }
    }

    public function sync(ExcellHttpModel $objData) : bool
    {
        if (!$this->validateRequestType('PUT'))
        {
            return false;
        }

        $objJsonForSync = $this->app->objHttpRequest->Data->PostData;

        if (!$this->validate($objJsonForSync, ["unique_id" => "required|uuid"]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $strUuid = $objJsonForSync->unique_id;

        $objModule = new Modules();
        $objModuleResult = $objModule->getWhere(["module_uuid" => $strUuid]);
        $objModuleResult->Data;

        if ($objModuleResult->Result->Count !== 1)
        {
            return $this->renderReturnJson(false, null, "No module found for unique id: {$strUuid}");
        }

        $objModuleSyncResult = $objModule->syncModule($objJsonForSync, $objModuleResult->Data->First());

        if ($objModuleSyncResult->Result->Success === false)
        {
            return $this->renderReturnJson(false, $objModuleSyncResult->Data, $objModuleSyncResult->Result->Message);
        }

        return $this->renderReturnJson(true, null, "This module synced successfully");
    }
}