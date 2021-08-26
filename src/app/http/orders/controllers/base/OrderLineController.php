<?php

namespace Entities\Orders\Classes\Base;

use App\Core\AppController;
use Entities\Orders\Classes\OrderLines;

class OrderLineController extends AppController
{
    public function __construct($app)
    {
        $this->AppEntity = new OrderLines();
        parent::__construct($app);
    }
}