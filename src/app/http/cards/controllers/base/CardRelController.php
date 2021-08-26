<?php

namespace Entities\Cards\Classes\Base;

use App\Core\AppController;
use Entities\Cards\Classes\CardRels;

class CardRelController extends AppController
{
    public function __construct($app)
    {
        $this->AppEntity = new CardRels();
        parent::__construct($app);
    }
}