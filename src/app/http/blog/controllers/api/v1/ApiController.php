<?php

namespace Http\Blog\Controllers\Api\V1;

use App\Utilities\Excell\ExcellHttpModel;
use Http\Blog\Controllers\Base\BlogController;

class ApiController extends BlogController
{
    public function configMain(ExcellHttpModel $objData) : bool
    {
        return $this->renderReturnJson(true, [], "Widget processed.", 200, "widget");
    }
}