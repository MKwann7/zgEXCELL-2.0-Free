<?php

namespace Http\Contacts\Controllers\Api\V1;

use App\Utilities\Database;
use App\Utilities\Excell\ExcellHttpModel;
use Http\Contacts\Controllers\Base\ContactController;
use Entities\Modules\Models\AppInstanceRelModel;

class ApiController extends ContactController
{
    public function getContactBatches(ExcellHttpModel $objData) : bool
    {
        $pageIndex  = $objData->Data->Params["offset"] ?? 1;
        $batchCount = $objData->Data->Params["batch"] ?? 500;
        $filterEntity = $objData->Data->Params["filterEntity"] ?? null;
        $pageIndex  = ($pageIndex - 1) * $batchCount;
        $arFields   = explode(",", $objData->Data->Params["fields"]);
        $strEnd     = "false";

        $objWhereClause = "
            SELECT 
                air.*,
                air.app_instance_rel_id AS id,
                air.card_page_rel_id AS on_page,
                air.card_id AS on_card,
                (SELECT platform_name FROM `excell_main`.`company` WHERE company.company_id = air.company_id LIMIT 1) AS platform,
                (SELECT display_name FROM `excell_main`.`product` WHERE product.product_id = ai.product_id ORDER BY product_id DESC LIMIT 1) AS display_name,
                ca.order_line_id,
                (SELECT source_uuid FROM `excell_main`.`product` WHERE product.product_id = ai.product_id ORDER BY product_id DESC LIMIT 1) AS app_uuid,
                ai.module_app_id AS app_id,
                air.module_app_widget_id AS app_widget_id,
                ai.instance_uuid
            FROM 
                `excell_main`.`app_instance_rel` air
            LEFT JOIN `excell_main`.app_instance ai ON ai.app_instance_id = air.app_instance_id
            LEFT JOIN `excell_main`.card_addon ca ON ca.card_addon_id = air.card_addon_id
            ";

        $objWhereClause .= "WHERE air.company_id = {$this->app->objCustomPlatform->getCompanyId()}";

        if ($filterEntity !== null)
        {
            $objWhereClause .= " AND air.card_id = {$filterEntity}";
        }

        $objWhereClause .= " ORDER BY air.app_instance_rel_id DESC LIMIT {$pageIndex}, {$batchCount}";

        $appInstanceResult = Database::getSimple($objWhereClause, "app_instance_rel_id");

        if ($appInstanceResult->getData()->Count() < $batchCount)
        {
            $strEnd = "true";
        }

        $appInstanceResult->getData()->HydrateModelData(AppInstanceRelModel::class, true);

        $arUserDashboardInfo = array(
            "list" => $appInstanceResult->getData()->FieldsToArray($arFields),
            //"query" => $objWhereClause,
        );

        return $this->renderReturnJson(true, $arUserDashboardInfo, "We found " . $appInstanceResult->getData()->Count() . " apps in this batch.", 200, "data", $strEnd);
    }
}