<?php

namespace Entities\Packages\Classes\Base;

use App\Core\AppController;
use Entities\Packages\Classes\Packages;

class PackageController extends AppController
{
    public function __construct($app)
    {
        $this->AppEntity = new Packages();
        parent::__construct($app);
    }
}