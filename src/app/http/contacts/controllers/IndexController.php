<?php

namespace Entities\Contacts\Controllers;

use App\Utilities\Excell\ExcellHttpModel;
use Entities\Contacts\Classes\Base\ContactController;
use Entities\Contacts\Classes\Contacts;
use Entities\Contacts\Components\Vue\MyContactsMainApp;
use Entities\Notes\Components\Vue\NotesWidget\ManageNotesWidget;

class IndexController extends ContactController
{
    public function index(ExcellHttpModel $objData) : void
    {
        if($this->app->isAdminUrlRequest())
        {
            if($this->app->isUserLoggedIn())
            {
                if($this->app->strActivePortalBinding === "account")
                {
                    $this->RenderContactDashboard($objData);
                }
                elseif($this->app->strActivePortalBinding === "account/admin")
                {
                    $this->RenderContactAdminDashboard($objData);
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
    }
    public function MyGroups(ExcellHttpModel $objData) : void
    {
        if($this->app->isAdminUrlRequest())
        {
            if($this->app->isUserLoggedIn())
            {
                if($this->app->strActivePortalBinding === "account")
                {
                    $this->RenderGroupDashboard($objData);
                }
                elseif($this->app->strActivePortalBinding === "account/admin")
                {
                    $this->RenderGroupAdminDashboard($objData);
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
    }

    public function ViewContact(ExcellHttpModel $objData) : void
    {
        if($this->app->isAdminUrlRequest())
        {
            if($this->app->isUserLoggedIn())
            {
                if( $this->app->strActivePortalBinding === "account/admin")
                {
                    self::RenderContactAdminDashboard($objData, "view");
                }
                else
                {
                    self::RenderContactDashboard($objData, "view");
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
    }


    public function Upload(ExcellHttpModel $objData) : void
    {
        if($this->app->isAdminUrlRequest())
        {
            if($this->app->isUserLoggedIn())
            {
                if( $this->app->strActivePortalBinding === "account/admin")
                {
                    self::RenderUploadContactAdminDashboard($objData, "view");
                }
                else
                {
                    self::RenderUploadContactDashboard($objData, "view");
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
    }

    public function RenderContactDashboard(ExcellHttpModel $objData, $strApproach = "list") : void
    {
        $vueApp = (new MyContactsMainApp("vueApp"))
            ->setUriBase($objData->PathControllerBase)
            ->registerComponentAbstracts([
                ManageNotesWidget::getStaticId() => ManageNotesWidget::getStaticUriAbstract(),
            ]);

        (new Contacts())->renderApp(
            "user.view_my_contacts",
            $this->app->strAssignedPortalTheme,
            $vueApp
        );
    }

    public function RenderContactAdminDashboard(ExcellHttpModel $objData, $strApproach = "list") : void
    {
        $this->AppEntity->renderAppPage("admin_view_all_contacts", $this->app->strAssignedPortalTheme, [
            "strApproach" => "",
        ]);
    }

    public function RenderGroupDashboard(ExcellHttpModel $objData, $strApproach = "list") : void
    {
        $this->AppEntity->renderAppPage("view_user_groups", $this->app->strAssignedPortalTheme, [
            "strApproach" => "",
        ]);
    }

    public function RenderGroupAdminDashboard(ExcellHttpModel $objData, $strApproach = "list") : void
    {
        $this->AppEntity->renderAppPage("admin_view_all_groups", $this->app->strAssignedPortalTheme, [
            "strApproach" => "",
        ]);
    }

    public function RenderUploadContactDashboard(ExcellHttpModel $objData, $strApproach = "list") : void
    {
        $this->AppEntity->renderAppPage("upload_contacts", $this->app->strAssignedPortalTheme, [
            "strApproach" => "",
        ]);
    }

    public function RenderUploadContactAdminDashboard(ExcellHttpModel $objData, $strApproach = "list") : void
    {
        $this->AppEntity->renderAppPage("admin_upload_contacts", $this->app->strAssignedPortalTheme, [
            "strApproach" => "",
        ]);
    }
}