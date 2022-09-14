<?php

namespace Http\Contacts\Controllers\Base;

use App\Core\AppController;
use Entities\Contacts\Classes\ContactGroups;

class ContactGroupController extends AppController
{
    public function __construct($app)
    {
        $this->AppEntity = new ContactGroups();
        parent::__construct($app);
    }
}