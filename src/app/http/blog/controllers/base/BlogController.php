<?php

namespace Http\Tasks\Controllers\Base;

use App\Core\AppController;
use Entities\Tasks\Classes\Tasks;

class TaskController extends AppController
{
    public function __construct($app)
    {
        $this->AppEntity = new Tasks();
        parent::__construct($app);
    }
}