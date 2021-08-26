<?php

namespace Entities\Quotes\Classes\Base;

use App\Core\AppController;
use Entities\Quotes\Classes\Quotes;

class QuoteController extends AppController
{
    public function __construct($app)
    {
        $this->AppEntity = new Quotes();
        parent::__construct($app);
    }
}