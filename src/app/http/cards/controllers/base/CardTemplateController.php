<?php

namespace Http\Cards\Controllers\Base;

use App\Core\AppController;
use Entities\Cards\Classes\CardTemplates;

class CardTemplateController extends AppController
{
    public function __construct($app)
    {
        $this->AppEntity = new CardTemplates();
        parent::__construct($app);
    }
}