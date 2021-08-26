<?php

namespace Entities\Dashboard\Classes\Base;

use App\Core\AppController;
use Entities\Dashboard\Classes\Dashboard;

class DashboardController extends AppController
{
    public function __construct($app)
    {
        $this->AppEntity = new Dashboard();
        parent::__construct($app);
    }
}