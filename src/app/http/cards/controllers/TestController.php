<?php

namespace Entities\Cards\Controllers;

use App\Utilities\Excell\ExcellHttpModel;
use Entities\Cards\Classes\Base\CardController;

class TestController extends CardController
{
    public function index(ExcellHttpModel $objData) : void
    {
        dd("This is a test.");
    }

    public function test(ExcellHttpModel $objData) : void
    {
        dd("This is a test2.");
    }
}