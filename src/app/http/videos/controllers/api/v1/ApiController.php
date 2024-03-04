<?php

namespace Http\Videos\Controllers\Api\V1;

use App\Utilities\Excell\ExcellHttpModel;
use Http\Videos\Controllers\Base\VideosController;

class ApiController extends VideosController
{
    public function configMain(ExcellHttpModel $objData) : bool
    {
        return $this->renderReturnJson(true, [], "Widget processed.", 200, "widget");
    }
}