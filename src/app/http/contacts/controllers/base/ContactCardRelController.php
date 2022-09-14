<?php

namespace Http\Contacts\Controllers\Base;

use App\Core\AppController;
use Entities\Contacts\Classes\ContactCardRels;

class ContactCardRelController extends AppController
{
    public function __construct($app)
    {
        $this->AppEntity = new ContactCardRels();
        parent::__construct($app);
    }
}