<?php

namespace Http\Cards\Controllers\Base;

use App\Core\AppController;
use App\Utilities\Excell\ExcellHttpModel;
use Entities\Cards\Classes\Cards;

class CardController extends AppController
{
    public function __construct($app)
    {
        $this->AppEntity = new Cards();
        parent::__construct($app);
    }

    protected function validateAuthentication(ExcellHttpModel $objData) : bool
    {
        $user = $this->app->getActiveLoggedInUser();
        $userId = "visitor";

        if ($user !== null)
        {
            $userId = $user->toArray(["sys_row_id"])["sys_row_id"];
        }

        if ($objData->UserName === $userId && $objData->Password === $_COOKIE['instance'])
        {
            return true;
        }

        return false;
    }
}