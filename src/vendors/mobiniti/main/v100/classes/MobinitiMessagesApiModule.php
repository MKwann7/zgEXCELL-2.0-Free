<?php

namespace Vendors\Mobiniti\Main\V100\Classes;

use App\Core\AppModel;
use Entities\Mobiniti\Models\MobinitiMessageModel;
use Vendors\Mobiniti\Main\V100\Classes\Base\MobinitiBase;

class MobinitiMessagesApiModule extends MobinitiBase
{
    protected $resource = "messages";
    protected $model = MobinitiMessageModel::class;

    public function SendMessage(AppModel $objEntity)
    {
        return parent::CreateNew($objEntity);
    }
}
