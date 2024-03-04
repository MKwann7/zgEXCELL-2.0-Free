<?php

namespace Http\Talktome\Controllers\Api\V1;

use App\Utilities\Excell\ExcellHttpModel;
use Http\Talktome\Controllers\Base\TalkToMeController;

class ApiController extends TalkToMeController
{
    public function configMain(ExcellHttpModel $objData) : bool
    {
        return $this->renderReturnJson(true, [], "Widget processed.", 200, "widget");
    }
}