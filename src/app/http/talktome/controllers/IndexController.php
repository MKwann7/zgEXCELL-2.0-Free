<?php

namespace Http\Talktome\Controllers;

use App\Utilities\Excell\ExcellHttpModel;
use Http\Talktome\Controllers\Base\TalkToMeController;

class IndexController extends TalkToMeController
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