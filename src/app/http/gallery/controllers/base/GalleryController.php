<?php

namespace Http\Blog\Controllers\Base;

use App\Core\AppController;

class BlogController extends AppController
{
    public function __construct($app)
    {
        parent::__construct($app);
    }
}