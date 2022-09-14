<?php

namespace Vendors\Mobiniti\Main\V100\Classes;

use Entities\Mobiniti\Models\MobinitiCarrierModel;
use Vendors\Mobiniti\Main\V100\Classes\Base\MobinitiBase;

class MobinitiCarriersApiModule extends MobinitiBase
{
    protected $resource = "carriers";
    protected $model = MobinitiCarrierModel::class;
}
