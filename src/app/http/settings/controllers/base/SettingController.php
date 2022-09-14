<?php

namespace Http\Settings\Controllers\Base;

use App\Core\AppController;
use Entities\Users\Classes\UserSettings;

class SettingController extends AppController
{
    public function __construct($app)
    {
        $this->AppEntity = new UserSettings();
        parent::__construct($app);
    }
}