<?php

namespace Entities\Cards\Controllers;

use App\Core\App;
use App\Utilities\Excell\ExcellHttpModel;
use Entities\Cards\Classes\Base\CardController;

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