<?php

namespace Entities\Communication\Classes\Base;

use App\Core\AppController;
use App\Utilities\Excell\ExcellHttpModel;
use Entities\Communication\Classes\Communications;

class CommunicationController extends AppController
{
    public function __construct($app)
    {
        $this->AppEntity = new Communications();
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

        if ($objData->UserName === $userId && $objData->Password === $this->app->objAppSession["Core"]["Session"]["Browser"])
        {
            return true;
        }

        return false;
    }
}