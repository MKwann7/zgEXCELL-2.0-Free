<?php

namespace Http\Media\Controllers\Base;

use App\Core\AppController;
use Entities\Media\Classes\Images;

class ImageController extends AppController
{
    public function __construct($app)
    {
        $this->AppEntity = new Images();
        parent::__construct($app);
    }
}