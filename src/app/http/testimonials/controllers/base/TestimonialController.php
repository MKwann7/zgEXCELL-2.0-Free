<?php

namespace Http\Testimonials\Controllers\Base;

use App\Core\AppController;
use Entities\Testimonials\Classes\Testimonials;

class TestimonialController extends AppController
{
    public function __construct($app)
    {
        $this->AppEntity = new Testimonials();
        parent::__construct($app);
    }
}