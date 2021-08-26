<?php

namespace Entities\Tickets\Controllers;

use App\Utilities\Excell\ExcellHttpModel;
use Entities\Tickets\Classes\Base\TicketsController;
use Entities\Tickets\Classes\Tickets;
use Entities\Tickets\Components\Vue\TicketsAdminApp;
use Entities\Tickets\Components\Vue\TicketsMainApp;
use Entities\Tickets\Components\Vue\TicketsWidget\ManageTicketsAdminWidget;
use Entities\Tickets\Components\Vue\TicketsWidget\ManageTicketsWidget;

class IndexController extends TicketsController
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
                    $this->RenderNotesList($objData);
                }
                elseif($this->app->strActivePortalBinding === "account/admin")
                {
                    $this->RenderNotesAdminList($objData);
                }
            }
            else
            {
                $this->app->redirectToLogin();
            }
        }

        return false;
    }

    protected function RenderNotesList(ExcellHttpModel $objData) : void
    {
        $vueApp = (new TicketsMainApp("vueApp"))
            ->setUriBase($objData->PathControllerBase)
            ->registerComponentAbstracts([
                ManageTicketsWidget::getStaticId() => ManageTicketsWidget::getStaticUriAbstract(),
            ]);

        (new Tickets())->renderApp(
            "user.view_my_tickets",
            $this->app->strAssignedPortalTheme,
            $vueApp
        );
    }

    protected function RenderNotesAdminList(ExcellHttpModel $objData) : void
    {
        $vueApp = (new TicketsAdminApp("vueApp"))
            ->setUriBase($objData->PathControllerBase)
            ->registerComponentAbstracts([
                ManageTicketsAdminWidget::getStaticId() => ManageTicketsAdminWidget::getStaticUriAbstract(),
            ]);

        (new Tickets())->renderApp(
            "admin.list_tickets",
            $this->app->strAssignedPortalTheme,
            $vueApp
        );
    }
}