<?php

namespace Http\Cards\Controllers\Base;

use App\Core\AppController;
use Entities\Cards\Classes\CardGroupsModule;

class CardGroupController extends AppController
{
    public function __construct($app)
    {
        $this->AppEntity = new CardGroupsModule();
        parent::__construct($app);
    }
}