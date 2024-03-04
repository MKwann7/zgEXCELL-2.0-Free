<?php

namespace Http\Tickets\Controllers\Api\V1;

use App\Utilities\Database;
use App\Utilities\Excell\ExcellHttpModel;
use Entities\Cards\Classes\Cards;
use Entities\Tickets\Classes\TicketChecklistResults;
use Entities\Tickets\Models\TicketChecklistResultModel;
use Http\Tickets\Controllers\Base\TicketsController;
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

        if ($ticketResult->result->Count !== 1)
        {
            return $this->renderReturnJson(false, ["errors" => "No tickets found by uuid.", "message" => $ticketResult->getResult()->Message], "No ticket found.");
        }

        /** @var TicketModel $ticket */
        $ticket = $ticketResult->getData()->first();

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

    public function updateTicketStatusValue(ExcellHttpModel $objData) : bool
    {
        if (!$this->validateRequestType('POST'))
        {
            return false;
        }

        $objParams = $objData->Data->Params;

        if (!$this->validate($objParams, [
            "ticket" => "required",
            "val" => "required",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $tickets = new Tickets();
        $ticketResults = $tickets->getById($objParams["ticket"]);

        if ($ticketResults->getResult()->Count !== 1) {
            return $this->renderReturnJson(false, [], "No ticket found by that id.");
        }

        $ticket = $ticketResults->getData()->First();
        $ticket->status = $objParams["val"];

        $tickets->update($ticket);

        if ($ticket->status === "complete" && $ticket->entity_name === "card") {
            $cards = new Cards();
            $cardResult = $cards->getById($ticket->entity_id);

            if ($cardResult->getResult()->Success === true) {
                $card = $cardResult->getData()->First();
                $card->status = "Active";
                $updateResult = $cards->update($card);
            }
        }

        return $this->renderReturnJson(true, [], "We made it.");
    }

    public function updateTicketChecklistValue(ExcellHttpModel $objData) : bool
    {
        if (!$this->validateRequestType('POST'))
        {
            return false;
        }

        $objParams = $objData->Data->Params;

        if (!$this->validate($objParams, [
            "ticket" => "required",
            "num" => "required",
            "val" => "required",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $ticketChecklistResults = new TicketChecklistResults();
        $checklistResult = $ticketChecklistResults->getWhere(["ticket_id" => $objParams["ticket"], "journey_checklist_id" => $objParams["num"]]);

        if ($checklistResult->Result->Count > 0) {
            $checklistItem = $checklistResult->Data->First();
            $checklistItem->result = $objParams["val"];
            $ticketChecklistResults->update($checklistItem);
        } else {
            $tickets = new Tickets();
            $ticketResults = $tickets->getById($objParams["ticket"]);

            if ($ticketResults->getResult()->Count !== 1) {
                return $this->renderReturnJson(false, [], "No ticket found by that id.");
            }
            $ticket = $ticketResults->getData()->First();
            $newTicketChecklist = new TicketChecklistResultModel();
            $newTicketChecklist->journey_checklist_id = $objParams["num"];
            $newTicketChecklist->ticket_id = $objParams["ticket"];
            $newTicketChecklist->journey_id = $ticket->journey_id;
            $newTicketChecklist->owner_id = $ticket->assignee_id;
            $newTicketChecklist->result = $objParams["val"];

            $ticketChecklistResults->createNew($newTicketChecklist);
        }

        return $this->renderReturnJson(true, [], "We made it.");
    }

    public function getMyTicketBatches(ExcellHttpModel $objData) : bool
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
                (SELECT CONCAT(ur.first_name, ' ', ur.last_name) FROM `ezdigital_v2_main`.`user` ur WHERE ur.user_id = tk.assignee_id LIMIT 1) AS owner,
                cd.sys_row_id AS card_uuid
            FROM 
                `ezdigital_v2_crm`.`ticket` tk
            LEFT JOIN `ezdigital_v2_crm`.`ticket_queue` tkq ON tkq.ticket_queue_id = tk.ticket_queue_id
            LEFT JOIN `ezdigital_v2_main`.`company_department_user_ticketqueue_role` cdutr ON cdutr.ticket_queue_id = tk.ticket_queue_id AND cdutr.user_id = '{$filterEntity}'
            LEFT JOIN `ezdigital_v2_main`.`card` cd ON tk.entity_id = cd.card_id
            ";

        $objWhereClause .= "WHERE tk.company_id = {$this->app->objCustomPlatform->getCompanyId()} AND tk.status != 'complete'";

        if ($filterEntity !== null)
        {
            $objWhereClause .= " AND (( tk.assignee_id = {$filterEntity} AND cdutr.department_user_role = 1) OR (cdutr.department_user_role = 2))";
        }

        $objWhereClause .= " ORDER BY tk.ticket_opened DESC LIMIT {$pageIndex}, {$batchCount}";

        $appInstanceResult = Database::getSimple($objWhereClause, "ticket_id");

        if ($appInstanceResult->getData()->Count() < $batchCount)
        {
            $strEnd = "true";
        }

        $appInstanceResult->getData()->HydrateModelData(TicketModel::class, true);

        $arUserDashboardInfo = array(
            "list" => $appInstanceResult->getData()->FieldsToArray($arFields),
            "query" => str_replace(["\n","\t"], "", $objWhereClause),
            "result" => $appInstanceResult->getResult()->Message,
        );

        return $this->renderReturnJson(true, $arUserDashboardInfo, "We found " . $appInstanceResult->getData()->Count() . " apps in this batch.", 200, "data", $strEnd);
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
                (SELECT CONCAT(ur.first_name, ' ', ur.last_name) FROM `ezdigital_v2_main`.`user` ur WHERE ur.user_id = tk.assignee_id LIMIT 1) AS owner,
                cd.sys_row_id AS card_uuid
            FROM 
                `ezdigital_v2_crm`.`ticket` tk
            LEFT JOIN `ezdigital_v2_crm`.`ticket_queue` tkq ON tkq.ticket_queue_id = tk.ticket_queue_id
            LEFT JOIN `ezdigital_v2_main`.`card` cd ON tk.entity_id = cd.card_id
            ";

        $objWhereClause .= "WHERE tk.company_id = {$this->app->objCustomPlatform->getCompanyId()} ORDER BY tk.ticket_opened DESC LIMIT {$pageIndex}, {$batchCount}";

        $appInstanceResult = Database::getSimple($objWhereClause, "ticket_id");

        if ($appInstanceResult->getData()->Count() < $batchCount)
        {
            $strEnd = "true";
        }

        $appInstanceResult->getData()->HydrateModelData(TicketModel::class, true);

        $arUserDashboardInfo = array(
            "list" => $appInstanceResult->getData()->FieldsToArray($arFields),
            "query" => $objWhereClause,
            "result" => $appInstanceResult->getResult()->Message,
        );

        return $this->renderReturnJson(true, $arUserDashboardInfo, "We found " . $appInstanceResult->getData()->Count() . " apps in this batch.", 200, "data", $strEnd);
    }
}