<?php

namespace Http\Dashboard\Controllers;

use App\Utilities\Excell\ExcellHttpModel;
use Http\Dashboard\Controllers\Base\DashboardController;
use Entities\Dashboard\Classes\Dashboard;
use Entities\Dashboard\Components\Vue\DashboardMainApp;

class IndexController extends DashboardController
{
    public function index(ExcellHttpModel $objData) : void
    {
        if(!$this->app->isAuthorizedAdminUrlRequest())
        {
            $this->app->redirectToLogin();
        }

        $this->RenderDashboard($objData);
    }

    public function dashboard(ExcellHttpModel $objData) : void
    {
        if(!$this->app->isAuthorizedAdminUrlRequest())
        {
            $this->app->redirectToLogin();
        }

        $this->AppEntity->renderAppPage("dashboard", $this->app->strAssignedPortalTheme);
    }

    private function RenderDashboard(ExcellHttpModel $objData) : void
    {
        $vueApp = (new DashboardMainApp("vueApp"))
            ->setUriBase($objData->PathControllerBase);

        (new Dashboard())->renderApp(
            "admin.dashboard",
            $this->app->strAssignedPortalTheme,
            $vueApp
        );
    }
}
