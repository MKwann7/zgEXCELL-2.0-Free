<?php

namespace Entities\Media\Classes\Base;

use App\Core\AppController;
use Entities\Media\Classes\Media;

class MediaController extends AppController
{
    public function __construct($app)
    {
        $this->AppEntity = new Media();
        parent::__construct($app);
    }
}