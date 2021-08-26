<?php

namespace Vendors\Mobiniti\Main\V100\Classes;

use Entities\Mobiniti\Models\MobinitiGroupModel;
use Vendors\Mobiniti\Main\V100\Classes\Base\MobinitiBase;

class MobinitiGroupsApiModule extends MobinitiBase
{
    protected $resource = "groups";
    protected $model = MobinitiGroupModel::class;
    protected $include = ["keyword"];
}
