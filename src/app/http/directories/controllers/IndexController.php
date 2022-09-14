<?php

namespace Http\Directories\Controllers;

use App\Utilities\Excell\ExcellHttpModel;
use App\Website\Vue\Classes\VueProps;
use Entities\Companies\Classes\Companies;
use Entities\Directories\Classes\Directories;
use Entities\Directories\Components\Vue\Directorywidget\ManageDirectoryWidget;
use Entities\Directories\Components\Vue\Maxtech\Directorywidget\ListMaxDirectoryWidget;
use Entities\Directories\Components\Vue\Maxtech\Directorywidget\ManageMaxDirectoryWidget;
use Entities\Directories\Components\Vue\Maxtech\MyMaxDirectoryMainApp;
use Entities\Directories\Components\Vue\Maxtech\Purchase\PurchaseMaxDirectoryWidget;
use Entities\Directories\Components\Vue\MyDirectoryMainApp;
use Http\Directories\Controllers\Base\DirectoryController;

class IndexController extends DirectoryController
{
    public function index(ExcellHttpModel $objData): bool
    {
        if ($this->app->isAdminUrlRequest()) {
            if ($this->app->isUserLoggedIn()) {
                if ($this->app->strActivePortalBinding === "account") {
                    $this->RenderDirectoryDashboard($objData);
                } elseif ($this->app->strActivePortalBinding === "account/admin") {
                    $this->RenderDirectoryAdminDashboard($objData);
                }
            } else {
                $this->app->redirectToLogin();
            }
        }

        return false;
    }

    private function RenderDirectoryDashboard(ExcellHttpModel $objData) : void
    {
        $vueApp = null;
        switch ($this->app->objCustomPlatform->getApplicationType())
        {
            case Companies::APP_TYPE_MAXTECH:
                $this->maxDirectories($objData);
                return;
            default:
                $vueApp = (new MyDirectoryMainApp("vueApp"))
                    ->setUriBase($objData->PathControllerBase)
                    ->registerComponentAbstracts([
                        ManageDirectoryWidget::getStaticId() => ManageDirectoryWidget::getStaticUriAbstract(),
                    ]);
                break;
        }

        (new Directories())->renderApp(
            "user.view_my_directories",
            $this->app->strAssignedPortalTheme,
            $vueApp
        );
    }

    private function maxDirectories(ExcellHttpModel $objData) : void
    {
        if (!$this->app->isAdminUrlRequest() || !$this->app->isUserLoggedIn() || $this->app->strActivePortalBinding !== "account") {
            $this->app->redirectToLogin();
            return;
        }

        $vueApp = null;
        switch ($objData->Uri[2]) {
            case "purchase":
                $vueApp = (new MyMaxDirectoryMainApp("vueApp"))
                    ->setDefaultComponentId(PurchaseMaxDirectoryWidget::getStaticId())->setDefaultComponentAction("view")
                    ->setDefaultComponentProps([
                        new VueProps("productGroup", "string", "'directory'"),
                        new VueProps("inModal", "boolean", "false"),
                        new VueProps("loggedInUserId", "number", $this->app->getActiveLoggedInUser()->user_id),
                    ])
                    ->setUriBase($objData->PathControllerBase);
                break;
            default:
                $vueApp = (new MyMaxDirectoryMainApp("vueApp"))
                    ->setDefaultComponentId(ListMaxDirectoryWidget::getStaticId())->setDefaultComponentAction("view")
                    ->setUriBase($objData->PathControllerBase)
                    ->registerComponentAbstracts([
                        ManageMaxDirectoryWidget::getStaticId() => ManageMaxDirectoryWidget::getStaticUriAbstract(),
                    ]);
                break;
        }

        (new Directories())->renderApp(
            "user.view_my_directories",
            $this->app->strAssignedPortalTheme,
            $vueApp
        );
    }
}