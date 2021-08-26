<?php

namespace Entities\Cards\Classes\Base;

use App\Core\AppController;
use Entities\Cards\Classes\CardConnections;

class CardConnectionController extends AppController
{
    public function __construct($app)
    {
        $this->AppEntity = new CardConnections();
        parent::__construct($app);
    }
}