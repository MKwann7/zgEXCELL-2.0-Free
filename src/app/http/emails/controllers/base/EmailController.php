<?php

namespace Entities\Emails\Classes\Base;

use App\Core\AppController;
use Entities\Emails\Classes\Emails;

class EmailController extends AppController
{
    public function __construct($app)
    {
        $this->AppEntity = new Emails();
        parent::__construct($app);
    }
}