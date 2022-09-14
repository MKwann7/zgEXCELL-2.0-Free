<?php

namespace Http\Contacts\Controllers;

use App\Utilities\Excell\ExcellHttpModel;
use Http\Contacts\Controllers\Base\ContactController;

class HelpController extends ContactController
{
    public function index(ExcellHttpModel $objData): bool
    {
        if( !$this->app->isAuthorizedAdminUrlRequest())
        {
            $this->app->redirectToLogin();
        }

        return $this->AppEntity->renderAppPage("help", $this->app->strAssignedPortalTheme);
    }
}