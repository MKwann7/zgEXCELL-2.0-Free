<?php

namespace Http\Cards\Controllers\Base;

use App\Core\AppController;
use Entities\Cards\Classes\CardPageRels;
use Entities\Cards\Classes\CardPage;

class CardPageRelController extends AppController
{
    public function __construct($app)
    {
        $this->AppEntity = new CardPageRels();
        parent::__construct($app);
    }
}