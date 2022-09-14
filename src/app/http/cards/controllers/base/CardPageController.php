<?php

namespace Http\Cards\Controllers\Base;

use App\Core\AppController;
use Entities\Cards\Classes\CardRels;
use Entities\Cards\Classes\CardPage;

class CardPageController extends AppController
{
    public function __construct($app)
    {
        $this->AppEntity = new CardPage();
        parent::__construct($app);
    }
}