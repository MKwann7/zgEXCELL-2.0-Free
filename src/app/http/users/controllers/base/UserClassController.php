<?php

namespace Http\Users\Controllers\Base;

use App\Core\AppController;
use Entities\Users\Classes\UserClass;

class UserClassController extends AppController
{
    public function __construct($app)
    {
        $this->AppEntity = new UserClass();
        parent::__construct($app);
    }
}