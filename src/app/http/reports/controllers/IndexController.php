<?php

namespace Http\Reports\Controllers;

use App\Utilities\Excell\ExcellHttpModel;
use Http\Reports\Controllers\Base\ReportController;
use Entities\Reports\Classes\Reports;

class IndexController extends ReportController
{
    public function index(ExcellHttpModel $objData) : void
    {
        if(!$this->app->isAdminUrlRequest() || !$this->app->isUserLoggedIn())
        {
            $this->app->redirectToLogin();
        }

        (new Reports())->renderAppPage("admin_view_all_reports", $this->app->strAssignedPortalTheme);
    }
}