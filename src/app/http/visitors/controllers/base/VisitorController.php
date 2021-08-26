<?php

namespace Entities\Visitors\Classes\Base;

use App\Core\AppController;
use Entities\Visitors\Classes\Visitors;

class VisitorController extends AppController
{
    public function __construct($app)
    {
        $this->AppEntity = new Visitors();
        parent::__construct($app);
    }
}