<?php

namespace Vendors\Mobiniti\Main\V100\Classes;

use Entities\Mobiniti\Models\MobinitiCouponModel;
use Vendors\Mobiniti\Main\V100\Classes\Base\MobinitiBase;

class MobinitiCouponsApiModule extends MobinitiBase
{
    protected $resource = "coupons";
    protected $model = MobinitiCouponModel::class;
}
