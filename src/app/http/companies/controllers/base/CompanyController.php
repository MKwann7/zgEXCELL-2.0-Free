<?php

namespace Entities\Companies\Classes\Base;

use App\Core\AppController;
use Entities\Companies\Classes\Companies;

class CompanyController extends AppController
{
    public function __construct($app)
    {
        $this->AppEntity = new Companies();
        parent::__construct($app);
    }
}
