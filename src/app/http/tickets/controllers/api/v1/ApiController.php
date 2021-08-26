<?php

namespace Entities\Tickets\Controllers\Api\V1;

use App\Utilities\Database;
use App\Utilities\Excell\ExcellHttpModel;
use Entities\Tickets\Classes\Base\TicketsController;
use Entities\Tickets\Classes\Tickets;
use Entities\Tickets\Models\TicketModel;

class ApiController extends TicketsController
{
    public function getTicketByUuid(ExcellHttpModel $objData): bool
    {
        //        if (!$this->validateAuthentication($objData))
        //        {
        //            return $this->renderReturnJson(false, [], "Unauthorized", 401);
        //        }

        if (!$this->validateRequestType('GET'))
        {
            return false;
        }

        $objParams = $objData->Data->Params;

        if (!$this->validate($objParams, [
            "uuid" => "required|uuid",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $ticketResult = (new Tickets())->getByUuid($objParams["uuid"]);

        if ($ticketResult->Result->Count !== 1)
        {
            return $this->renderReturnJson(false, ["errors" => "No tickets found by uuid.", "message" => $ticketResult->Result->Message], "No ticket found.");
        }

        /** @var TicketModel $ticket */
        $ticket = $ticketResult->Data->First();

        if (isset($objParams["addons"]))
        {
            $addons = explode("|", $objParams["addons"]);
            foreach($addons as $currAddon)
            {
                $ticket->LoadAddons($currAddon);
            }
        }

        return $this->renderReturnJson(true, ["ticket" => $ticket->ToPublicArray()], "We made it.");
    }

    public function getTicketBatches(ExcellHttpModel $objData) : bool
    {
        $pageIndex  = $objData->Data->Params["offset"] ?? 1;
        $batchCount = $objData->Data->Params["batch"] ?? 500;
        $filterEntity = $objData->Data->Params["filterEntity"] ?? null;
        $pageIndex  = ($pageIndex - 1) * $batchCount;
        $arFields   = explode(",", $objData->Data->Params["fields"]);
        $strEnd     = "false";

        $objWhereClause = "
            SELECT 
                tk.*,
                tkq.name AS queue_name,
                tkq.ticket_queue_id AS queue_id,
                (SELECT platform_name FROM `ezdigital_v2_main`.`company` cp WHERE cp.company_id = tk.company_id LIMIT 1) AS platform, 
                (SELECT label FROM `ezdigital_v2_main`.`company_department` cd WHERE cd.company_department_id = tkq.company_department_id LIMIT 1) AS department, 
                (SELECT CONCAT(ur.first_name, ' ', ur.last_name) FROM `ezdigital_v2_main`.`user` ur WHERE ur.user_id = tk.assignee_id LIMIT 1) AS owner
            FROM 
                `ezdigital_v2_crm`.`ticket` tk
            LEFT JOIN `ezdigital_v2_crm`.`ticket_queue` tkq ON tkq.ticket_queue_id = tk.ticket_queue_id
            ";

        $objWhereClause .= "WHERE tk.company_id = {$this->app->objCustomPlatform->getCompanyId()}";

        if ($filterEntity !== null)
        {
            $objWhereClause .= " AND tk.assignee_id = {$filterEntity}";
        }

        $objWhereClause .= " ORDER BY tk.ticket_opened DESC LIMIT {$pageIndex}, {$batchCount}";

        $appInstanceResult = Database::getSimple($objWhereClause, "ticket_id");

        if ($appInstanceResult->Data->Count() < $batchCount)
        {
            $strEnd = "true";
        }

        $appInstanceResult->Data->HydrateModelData(TicketModel::class, true);

        $arUserDashboardInfo = array(
            "list" => $appInstanceResult->Data->FieldsToArray($arFields),
            "query" => $objWhereClause,
            "result" => $appInstanceResult->Result->Message,
        );

        return $this->renderReturnJson(true, $arUserDashboardInfo, "We found " . $appInstanceResult->Data->Count() . " apps in this batch.", 200, "data", $strEnd);
    }
}