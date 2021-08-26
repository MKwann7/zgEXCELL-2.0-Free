<?php

namespace Vendors\Mobiniti\Main\V100\Classes;

use Entities\Mobiniti\Models\MobinitiOptInModel;
use Vendors\Mobiniti\Main\V100\Classes\Base\MobinitiBase;

class MobinitiOptInsApiModule extends MobinitiBase
{
    protected $resource = "opt-ins";
    protected $model = MobinitiOptInModel::class;
}
