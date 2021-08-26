<?php

namespace Entities\Contacts\Classes\Base;

use App\Core\AppController;
use Entities\Contacts\Classes\Contacts;

class ContactController extends AppController
{
    public function __construct($app)
    {
        $this->AppEntity = new Contacts();
        parent::__construct($app);
    }
}