<?php

namespace Http\Contactme\Controllers\Api\V1;

use App\Utilities\Excell\ExcellHttpModel;
use Http\Contactme\Controllers\Base\ContactMeController;

class ApiController extends ContactMeController
{
    public function configMain(ExcellHttpModel $objData) : bool
    {
        return $this->renderReturnJson(true, [], "Widget processed.", 200, "widget");
    }
}