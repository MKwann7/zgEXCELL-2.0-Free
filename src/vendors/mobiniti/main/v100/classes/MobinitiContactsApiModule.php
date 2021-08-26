<?php

namespace Vendors\Mobiniti\Main\V100\Classes;

use App\Utilities\Transaction\ExcellTransaction;
use Entities\Mobiniti\Models\MobinitiContactModel;
use Vendors\Mobiniti\Main\V100\Classes\Base\MobinitiBase;

class MobinitiContactsApiModule extends MobinitiBase
{
    protected $resource = "contacts";
    protected $model = MobinitiContactModel::class;

    public function GetContactsByGroupId($group_id, $record_count = 10000, $page_offset = 1, $page_limit = 100) : ExcellTransaction
    {
        $objTransaction = new ExcellTransaction();

        if ($page_limit > 100)
        {
            $objTransaction->Result->Success = false;
            $objTransaction->Result->Count = 0;
            $objTransaction->Result->Message = "The record count request cannot be less than the offset of " . $page_limit;
        }

        list($intRecordCount, $intPageCount, $intPageOffset, $intPageLimit, $strQuery) = $this->ParseFilterOrderAndPagination($record_count, $page_offset, $page_limit);

        try
        {
            $this->resource = "groups";
            return $this->GetMobinitiData($intRecordCount, $intPageCount, $intPageOffset, $intPageLimit, $strQuery, "{$group_id}/contacts/");
        }
        catch(\Exception $ex)
        {
            $objTransaction->Result->Success = false;
            $objTransaction->Result->Count = 0;
            $objTransaction->Result->Message = "Error processing: " . $ex;
            return $objTransaction;
        }
    }
}
