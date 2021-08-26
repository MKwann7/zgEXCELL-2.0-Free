<?php

namespace Entities\Reports\Classes\Base;

use Entities\Media\Controllers\Api\V1\ApiController;
use Entities\Reports\Classes\Reports;

class ReportController extends ApiController
{
    public function __construct($app)
    {
        $this->AppEntity = new Reports();
        parent::__construct($app);
    }
}