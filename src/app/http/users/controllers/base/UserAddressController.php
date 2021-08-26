<?php

namespace Entities\Users\Classes\Base;

use App\Core\AppController;
use Entities\Users\Classes\UserAddress;

class UserAddressController extends AppController
{
    public function __construct($app)
    {
        $this->AppEntity = new UserAddress();
        parent::__construct($app);
    }
}