<?php

namespace Vendors\Mobiniti\Main\V100\Classes;

use Entities\Mobiniti\Models\MobinitiCampaignModel;
use Vendors\Mobiniti\Main\V100\Classes\Base\MobinitiBase;

class MobinitiCampaignsApiModule extends MobinitiBase
{
    protected $resource = "campaigns";
    protected $model = MobinitiCampaignModel::class;
}
