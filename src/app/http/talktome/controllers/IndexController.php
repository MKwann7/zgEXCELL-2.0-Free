<?php

namespace Http\Sharesave\Controllers;

use App\Utilities\Excell\ExcellHttpModel;
use Http\Sharesave\Controllers\Base\ShareSaveController;

class IndexController extends ShareSaveController
{
    public function index(ExcellHttpModel $objData): bool
    {
        if ($this->app->isAdminUrlRequest()) {
            if ($this->app->isUserLoggedIn()) {
                if ($this->app->strActivePortalBinding === "account") {
                    die("account page");
                } elseif ($this->app->strActivePortalBinding === "account/admin") {
                    die("account page");
                }
            } else {
                $this->app->redirectToLogin();
            }
        }

        return false;
    }
}