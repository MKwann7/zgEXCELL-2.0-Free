<?php

namespace Entities\Notes\Controllers;

use App\Utilities\Excell\ExcellHttpModel;
use Entities\Modules\Components\Vue\AppsWidget\ManageModuleAppsWidget;
use Entities\Notes\Classes\Base\NotesController;
use Entities\Notes\Classes\Notes;
use Entities\Notes\Components\Vue\NotesAdminApp;
use Entities\Notes\Components\Vue\NotesMainApp;
use Entities\Notes\Components\Vue\NotesWidget\ManageNotesAdminWidget;
use Entities\Notes\Components\Vue\NotesWidget\ManageNotesWidget;

class IndexController extends NotesController
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
                    $this->renderNotesList($objData);
                }
                elseif($this->app->strActivePortalBinding === "account/admin")
                {
                    $this->renderNotesAdminList($objData);
                }
            }
            else
            {
                $this->app->redirectToLogin();
            }
        }

        return false;
    }

    protected function renderNotesList(ExcellHttpModel $objData) : void
    {
        $vueApp = (new NotesMainApp("vueApp"))
            ->setUriBase($objData->PathControllerBase)
            ->registerComponentAbstracts([
                ManageNotesWidget::getStaticId() => ManageNotesWidget::getStaticUriAbstract(),
            ]);

        (new Notes())->renderApp(
            "user.view_my_notes",
            $this->app->strAssignedPortalTheme,
            $vueApp
        );
    }

    protected function renderNotesAdminList(ExcellHttpModel $objData) : void
    {
        $vueApp = (new NotesAdminApp("vueApp"))
            ->setUriBase($objData->PathControllerBase)
            ->registerComponentAbstracts([
                ManageNotesAdminWidget::getStaticId() => ManageNotesAdminWidget::getStaticUriAbstract(),
            ]);

        (new Notes())->renderApp(
            "admin.list_notes",
            $this->app->strAssignedPortalTheme,
            $vueApp
        );
    }
}