<?php

namespace Http\Cards\Controllers;

use App\Utilities\Excell\ExcellHttpModel;
use Http\Cards\Controllers\Base\CardController;

class ReportIssueController extends CardController
{
    public function index(ExcellHttpModel $objData): void
    {
        if( !$this->app->isAuthorizedAdminUrlRequest())
        {
            $this->app->redirectToLogin();
        }

        $this->AppEntity->renderAppPage("report_issue", $this->app->strAssignedPortalTheme);
    }
}