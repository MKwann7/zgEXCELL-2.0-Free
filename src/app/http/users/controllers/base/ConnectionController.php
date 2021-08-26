<?php

namespace Entities\Users\Classes\Base;

use App\Core\AppController;
use Entities\Users\Classes\Connections;

class ConnectionController extends AppController
{
    public function __construct($app)
    {
        $this->AppEntity = new Connections();
        parent::__construct($app);
    }
}