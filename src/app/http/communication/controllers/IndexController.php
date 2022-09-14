<?php

namespace Http\Communication\Controllers;

use App\Utilities\Excell\ExcellHttpModel;
use Http\Communication\Controllers\Base\CommunicationController;
use Entities\Communication\Classes\Communications;
use Entities\Communication\Components\Vue\CommunicationMainApp;
use Entities\Modules\Components\Vue\AppsWidget\ManageModuleAppsWidget;
use Entities\Notes\Classes\Notes;
use Entities\Notes\Components\Vue\NotesAdminApp;
use Entities\Notes\Components\Vue\NotesMainApp;
use Entities\Notes\Components\Vue\NotesWidget\ManageNotesAdminWidget;
use Entities\Notes\Components\Vue\NotesWidget\ManageNotesWidget;

class IndexController extends CommunicationController
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
        $vueApp = (new CommunicationMainApp("vueApp"))
            ->setUriBase($objData->PathControllerBase);

        (new Communications())->renderApp(
            "user.list_communications",
            $this->app->strAssignedPortalTheme,
            $vueApp
        );
    }
}