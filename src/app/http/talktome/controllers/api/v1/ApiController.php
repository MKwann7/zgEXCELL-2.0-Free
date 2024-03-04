<?php

namespace Http\Sharesave\Controllers\Api\V1;

use App\Utilities\Excell\ExcellHttpModel;
use Http\Sharesave\Controllers\Base\ShareSaveController;

class ApiController extends ShareSaveController
{
    public function configMain(ExcellHttpModel $objData) : bool
    {
        return $this->renderReturnJson(true, [], "Widget processed.", 200, "widget");
    }
}