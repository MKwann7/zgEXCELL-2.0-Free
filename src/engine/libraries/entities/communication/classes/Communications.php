<?php

namespace Entities\Communication\Classes;

use App\Core\AppEntity;

class Communications extends AppEntity
{
    public $strEntityName       = "Communication";
    public $isPrimaryModule     = true;

    public function __construct()
    {
        parent::__construct();
    }
}