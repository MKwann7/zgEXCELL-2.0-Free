<?php

namespace Entities\Security\Classes\Base;

use App\Core\AppController;
use Entities\Security\Classes\Security;

class SecurityController extends AppController
{
    public function __construct($app)
    {
        $this->AppEntity = new Security();
        parent::__construct($app);
    }
}