<?php

namespace Http\Notes\Controllers\Api\V1;

use App\Utilities\Database;
use App\Utilities\Excell\ExcellHttpModel;
use Http\Notes\Controllers\Base\NotesController;
use Entities\Notes\Classes\Notes;
use Entities\Notes\Models\NoteModel;

class ApiController extends NotesController
{
    public function create(ExcellHttpModel $objData) : bool
    {
        if (!$this->validateRequestType('POST'))
        {
            return false;
        }

        $objPost = $objData->Data->PostData;

        if (!$this->validate($objPost, [
            "summary" => "required",
            "description" => "required",
            "visibility" => "required",
            "type" => "required",
            "creator_id" => "required|integer",
            "entity_id" => "required|integer",
            "entity_name" => "required",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $objNotes = new Notes();
        $noteModel = new NoteModel();
        $noteModel->company_id = $this->app->objCustomPlatform->getCompanyId();
        $noteModel->division_id = 0;
        $noteModel->summary = $objPost->summary;
        $noteModel->description = $objPost->description;
        $noteModel->visibility = $objPost->visibility;
        $noteModel->type = $objPost->type;
        $noteModel->entity_id = $objPost->entity_id;
        $noteModel->entity_name = $objPost->entity_name;
        $noteModel->note_owner_id = $objPost->creator_id;

        $result = $objNotes->createNew($noteModel);

        if  ($result->result->Success === false)
        {
            return $this->renderReturnJson(false, ["error" => $result->result->Message], "There was an error creating this note.");
        }

        $arEntityResult = array(
            "note" => $result->getData()->first()->ToPublicArray(["note_id", "company_id", "division_id", "created_on" => "date", "summary", "description", "visibility", "type"]),
        );
        $arEntityResult["note"]["creator"] = $this->app->getActiveLoggedInUser()->first_name . " " . $this->app->getActiveLoggedInUser()->last_name;

        return $this->renderReturnJson(true, $arEntityResult, "Note created.", 200);
    }

    public function update(ExcellHttpModel $objData) : bool
    {
        if (!$this->validateRequestType('POST'))
        {
            return false;
        }

        $objPost = $objData->Data->PostData;

        if (!$this->validate($objPost, [
            "note_id" => "required",
            "summary" => "required",
            "description" => "required",
            "visibility" => "required",
            "type" => "required",
            "entity_id" => "required|integer",
            "entity_name" => "required",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $objNotes = new Notes();
        $noteModel = $objNotes->getById($objPost->note_id)->getData()->first();
        $noteModel->summary = $objPost->summary;
        $noteModel->description = $objPost->description;
        $noteModel->visibility = $objPost->visibility;
        $noteModel->type = $objPost->type;

        $result = $objNotes->update($noteModel);

        if  ($result->result->Success === false)
        {
            return $this->renderReturnJson(false, ["error" => $result->result->Message], "There was an error updating this note.");
        }

        $arEntityResult = array(
            "note" => $result->getData()->first()->ToPublicArray(["note_id", "company_id", "division_id", "created_on" => "date", "summary", "description", "visibility", "type"]),
        );
        $arEntityResult["note"]["creator"] = $this->app->getActiveLoggedInUser()->first_name . " " . $this->app->getActiveLoggedInUser()->last_name;

        return $this->renderReturnJson(true, $arEntityResult, "Note updated.", 200);
    }

    public function delete(ExcellHttpModel $objData) : bool
    {

    }

    public function getNoteBatches(ExcellHttpModel $objData) : bool
    {
        $pageIndex  = $objData->Data->Params["offset"] ?? 1;
        $batchCount = $objData->Data->Params["batch"] ?? 500;
        $pageIndex  = ($pageIndex - 1) * $batchCount;
        $arFields   = explode(",", $objData->Data->Params["fields"]);
        $strEnd     = "false";

        $objWhereClause = "
            SELECT 
                nt.*,
                nt.created_on AS date,
                nt.note_id AS id,
                nt.ticket_id AS ticket,
                (SELECT CONCAT(user.first_name, ' ', user.last_name) FROM `excell_main`.`user` WHERE user.user_id = nt.note_owner_id LIMIT 1) AS creator,
            FROM 
                `excell_crm`.`note` nt
            ";

        $objWhereClause .= "WHERE nt.company_id = {$this->app->objCustomPlatform->getCompanyId()}";

        $objWhereClause .= " ORDER BY nt.created_on DESC LIMIT {$pageIndex}, {$batchCount}";

        return $this->requestNoteData($objWhereClause, $batchCount, $arFields, $strEnd);
    }

    public function getCustomerNoteBatches(ExcellHttpModel $objData) : bool
    {
        $pageIndex  = $objData->Data->Params["offset"] ?? 1;
        $batchCount = $objData->Data->Params["batch"] ?? 500;
        $filterEntity = $objData->Data->Params["filterEntity"] ?? null;
        $pageIndex  = ($pageIndex - 1) * $batchCount;
        $arFields   = explode(",", $objData->Data->Params["fields"]);
        $strEnd     = "false";

        $objWhereClause = "
            SELECT 
                nt.*,
                nt.created_on AS date,
                nt.note_id AS id,
                nt.ticket_id AS ticket,
                (SELECT CONCAT(user.first_name, ' ', user.last_name) FROM `excell_main`.`user` WHERE user.user_id = nt.note_owner_id LIMIT 1) AS creator,
            FROM 
                `excell_crm`.`note` nt
            ";

        $objWhereClause .= "WHERE nt.company_id = {$this->app->objCustomPlatform->getCompanyId()}";

        if ($filterEntity !== null)
        {
            $objWhereClause .= " AND nt.entity_id = {$filterEntity} AND nt.entity_name = 'customer'";
        }

        $objWhereClause .= " ORDER BY nt.created_on DESC LIMIT {$pageIndex}, {$batchCount}";

        return $this->requestNoteData($objWhereClause, $batchCount, $arFields, $strEnd);
    }

    public function getTicketNoteBatches(ExcellHttpModel $objData) : bool
    {
        $pageIndex  = $objData->Data->Params["offset"] ?? 1;
        $batchCount = $objData->Data->Params["batch"] ?? 500;
        $filterEntity = $objData->Data->Params["filterEntity"] ?? null;
        $pageIndex  = ($pageIndex - 1) * $batchCount;
        $arFields   = explode(",", $objData->Data->Params["fields"]);
        $strEnd     = "false";

        $objWhereClause = "
            SELECT 
                nt.*,
                nt.created_on AS date,
                nt.note_id AS id,
                nt.ticket_id AS ticket,
                (SELECT CONCAT(user.first_name, ' ', user.last_name) FROM `excell_main`.`user` WHERE user.user_id = nt.note_owner_id LIMIT 1) AS creator
            FROM 
                `excell_crm`.`note` nt
            ";

        $objWhereClause .= "WHERE nt.company_id = {$this->app->objCustomPlatform->getCompanyId()}";

        $objWhereClause .= " AND ((nt.entity_id = {$filterEntity} AND nt.entity_name = 'ticket' )";
        $objWhereClause .= " OR (nt.ticket_id = {$filterEntity}))";

        $objWhereClause .= " ORDER BY nt.created_on DESC LIMIT {$pageIndex}, {$batchCount}";

        return $this->requestNoteData($objWhereClause, $batchCount, $arFields, $strEnd);
    }

    public function getCardNoteBatches(ExcellHttpModel $objData) : bool
    {
        $pageIndex  = $objData->Data->Params["offset"] ?? 1;
        $batchCount = $objData->Data->Params["batch"] ?? 500;
        $filterEntity = $objData->Data->Params["filterEntity"] ?? null;
        $pageIndex  = ($pageIndex - 1) * $batchCount;
        $arFields   = explode(",", $objData->Data->Params["fields"]);
        $strEnd     = "false";

        $objWhereClause = "
            SELECT 
                nt.*,
                nt.created_on AS date,
                nt.note_id AS id,
                nt.ticket_id AS ticket,
                (SELECT CONCAT(user.first_name, ' ', user.last_name) FROM `excell_main`.`user` WHERE user.user_id = nt.note_owner_id LIMIT 1) AS creator
            FROM 
                `excell_crm`.`note` nt
            ";

        $objWhereClause .= "WHERE nt.company_id = {$this->app->objCustomPlatform->getCompanyId()}";

        if ($filterEntity !== null)
        {
            $objWhereClause .= " AND nt.entity_id = {$filterEntity} AND nt.entity_name = 'card'";
        }

        $objWhereClause .= " ORDER BY nt.created_on DESC LIMIT {$pageIndex}, {$batchCount}";

        return $this->requestNoteData($objWhereClause, $batchCount, $arFields, $strEnd);
    }

    private function requestNoteData(string $whereclause, int $batchCount, array $arFields = [], string $strEnd = "false") : bool
    {
        $appInstanceResult = Database::getSimple($whereclause, "note_id");

        if ($appInstanceResult->getData()->Count() < $batchCount)
        {
            $strEnd = "true";
        }

        $appInstanceResult->getData()->HydrateModelData(NoteModel::class, true);

        $arUserDashboardInfo = array(
            "list" => $appInstanceResult->getData()->FieldsToArray($arFields),
            "end"     => $strEnd,
            //"query" => $objWhereClause,
        );

        return $this->renderReturnJson(true, $arUserDashboardInfo, "We found " . $appInstanceResult->getData()->Count() . " notes in this batch.", 200, "data", $strEnd);
    }
}