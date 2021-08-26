<?php

namespace Entities\Orders\Classes\Base;

use App\Core\AppController;
use Entities\Orders\Classes\Orders;

class OrderController extends AppController
{
    public function __construct($app)
    {
        $this->AppEntity = new Orders();
        parent::__construct($app);
    }
}