<?php

namespace Entities\Contacts\Classes\Base;

use App\Core\AppController;
use Entities\Contacts\Classes\ContactUserRels;

class ContactUserRelController extends AppController
{
    public function __construct($app)
    {
        $this->AppEntity = new ContactUserRels();
        parent::__construct($app);
    }
}