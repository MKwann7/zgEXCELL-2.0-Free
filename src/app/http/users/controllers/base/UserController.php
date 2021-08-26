<?php

namespace Entities\Users\Classes\Base;

use App\Core\AppController;
use Entities\Users\Classes\Users;

class UserController extends AppController
{
    public function __construct($app)
    {
        $this->AppEntity = new Users();
        parent::__construct($app);
    }
}