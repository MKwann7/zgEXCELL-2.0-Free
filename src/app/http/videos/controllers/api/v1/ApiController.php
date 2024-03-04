<?php

namespace Http\Gallery\Controllers\Api\V1;

use App\Utilities\Excell\ExcellHttpModel;
use Http\Gallery\Controllers\Base\GalleryController;

class ApiController extends GalleryController
{
    public function configMain(ExcellHttpModel $objData) : bool
    {
        return $this->renderReturnJson(true, [], "Widget processed.", 200, "widget");
    }
}