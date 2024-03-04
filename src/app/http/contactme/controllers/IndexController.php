<?php

namespace Http\Contactme\Controllers;

use App\Utilities\Excell\ExcellHttpModel;
use Http\Contactme\Controllers\Base\ContactMeController;

class IndexController extends ContactMeController
{
    public function index(ExcellHttpModel $objData): bool
    {
        if ($this->app->isAdminUrlRequest()) {
            if ($this->app->isUserLoggedIn()) {
                if ($this->app->strActivePortalBinding === "account") {
                    die("account page");
                } elseif ($this->app->strActivePortalBinding === "account/admin") {
                    die("account/admin page");
                }
            } else {
                $this->app->redirectToLogin();
            }
        }

        return false;
    }
}