<?php

namespace Http\Settings\Controllers;

use App\Utilities\Excell\ExcellHttpModel;
use Http\Settings\Controllers\Base\SettingController;
use Entities\Settings\Components\Vue\SettingsMainApp;
use Entities\Users\Classes\UserSettings;

class IndexController extends SettingController
{
    public function index(ExcellHttpModel $objData) : bool
    {
        if (!$this->validateRequestType('GET'))
        {
            return false;
        }

        if ($this->app->strActivePortalBinding === "account" && $this->app->isAdminUrlRequest() && $this->app->isUserLoggedIn())
        {
            $this->renderSettingsDashboard($objData);
        }

        return false;
    }

    protected function renderSettingsDashboard(ExcellHttpModel $objData) : void
    {
        $vueApp = (new SettingsMainApp("vueApp"))
            ->setUriBase($objData->PathControllerBase);

        (new UserSettings())->renderApp(
            "user.view_my_settings",
            $this->app->strAssignedPortalTheme,
            $vueApp
        );
    }
}