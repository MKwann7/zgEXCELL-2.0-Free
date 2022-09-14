<?php

namespace Http\Directories\Controllers\Api\V1;

use App\Utilities\Database;
use App\Utilities\Excell\ExcellHttpModel;
use App\Utilities\Http\Http;
use App\Utilities\Transaction\ExcellTransaction;
use Entities\Directories\Classes\Directories;
use Entities\Directories\Classes\DirectoryMemberRels;
use Entities\Emails\Classes\Emails;
use Entities\Media\Classes\Images;
use Http\Directories\Controllers\Base\DirectoryController;

class PublicFullPageController extends DirectoryController
{
    public function getDirectoryId(ExcellHttpModel $objData) : bool
    {
        $objParams = $objData->Data->Params;

        if (!$this->validate($objParams, [
            "id" => "required|uuid",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $objMemberDirectories = new Directories();
        $objMemberDirectoryResult = $objMemberDirectories->getWhere(["instance_uuid" => $objParams["id"]]);

        return $this->renderReturnJson($objMemberDirectoryResult->getResult()->Success, ["id" => ($objMemberDirectoryResult->getData()->first()->directory_id ?? null), "message" => $objMemberDirectoryResult->getResult()->Message], "Where's what we found.");
    }

    public function saveDirectoryRecordAvatarUrl(ExcellHttpModel $objData) : bool
    {
        $objParams = $objData->Data->Params;

        if (!$this->validate($objParams, [
            "member" => "required|integer",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $avatarUrl = $objData->Data->PostData->avatar_url;

        if (empty($avatarUrl))
        {
            return $this->renderReturnJson(false, ["avatar_url" => "Field is required."], "Validation errors.");
        }

        $objMemberDirectoryRecords = new EzcardMemberDirectoryRecords();
        $objMemberDirectoryRecordResult = $objMemberDirectoryRecords->getById($objParams["member"]);

        $memberRecord = $objMemberDirectoryRecordResult->getData()->first();
        $memberRecord->profile_image_url = $avatarUrl;

        $objMemberDirectoryRecordUpdateResult = $objMemberDirectoryRecords->update($memberRecord);

        return $this->renderReturnJson($objMemberDirectoryRecordUpdateResult->getResult()->Success, ["avatar_url" => $memberRecord->profile_image_url], "Here's what I got.");
    }

    public function getDirectoryColumns(ExcellHttpModel $objData) : bool
    {
        $objParams = $objData->Data->Params;

        if (!$this->validate($objParams, [
            "id" => "required|integer",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $objMemberDirectoryColumnResult = (new EzcardMemberDirectoryColumns())->getColumnsByDirectoryId($objParams["id"]);

        if (!empty($objParams["member"]) && $objParams["member"] !== "null")
        {
            $objMemberDirectoryRecordValues = new EzcardMemberDirectoryRecordValues();
            $objMemberDirectoryRecordValuesResult = $objMemberDirectoryRecordValues->getWhere(["member_directory_record_id" => $objParams["member"]]);

            $objMemberDirectoryColumnResult->getData()->MergeFields($objMemberDirectoryRecordValuesResult->getData(),["type" => "typeInstance","value","member_directory_record_value_id"],["member_directory_column_id" => "member_directory_column_id"]);
            $objMemberDirectoryColumnResult->getData()->AddFieldToAllEntities("member_directory_id", $objParams["id"]);
            $objMemberDirectoryColumnResult->getData()->AddFieldToAllEntities("member_directory_record_id", $objParams["member"]);
        }

        return $this->renderReturnJson(true, $objMemberDirectoryColumnResult->getData()->ToPublicArray(), "Here's what I got.");
    }

    public function upsertDirectoryMemberRecord(ExcellHttpModel $objData) : bool
    {
        $objParams = $objData->Data->Params;
        $objPost = $objData->Data->PostData;

        if (!$this->validate($objParams, [
            "directoryId" => "required|integer",
            "member" => "required",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        switch($objParams["member"])
        {
            case "new":
                return $this->createMemberRecord($objParams["directoryId"], $objPost);
            default:
                return $this->updateMemberRecord($objParams["directoryId"], $objParams["member"], $objPost);
        }
    }

    public function createMemberRecord($directoryId, $data) : bool
    {
        $memberRecord = new EzcardMemberDirectoryRecordModel();
        $memberRecord->member_directory_id = $directoryId;
        $memberRecord->first_name = $data->member->first_name;
        $memberRecord->last_name = $data->member->last_name;
        $memberRecord->mobile_phone = $data->member->mobile_phone;
        $memberRecord->email = $data->member->email;
        $memberRecord->status = "disabled";

        if ($data->member->profile_image_url === "__remove__")
        {
            $memberRecord->profile_image_url = EXCELL_EMPTY_STRING;
        }

        $objMemberDirectoryRecords = new EzcardMemberDirectoryRecords();
        $objMemberDirectoryRecordCreationResult = $objMemberDirectoryRecords->createNew($memberRecord);

        if ($objMemberDirectoryRecordCreationResult->getResult()->Success === false)
        {
            return $this->renderReturnJson(false, ["error" => $objMemberDirectoryRecordCreationResult->getResult()->Message], "Error saving new member record.");
        }

        $data->member->member_directory_record_id = $objMemberDirectoryRecordCreationResult->getData()->first()->member_directory_record_id;
        $this->upsertCustomMemberFields($data, $objMemberDirectoryRecordCreationResult->getData()->first()->member_directory_record_id, $directoryId);

        return $this->renderReturnJson($objMemberDirectoryRecordCreationResult->getResult()->Success, $data, "Member directory record successfully created.");
    }

    public function updateMemberRecord($directoryId, $memberID, $data) : bool
    {
        $objMemberDirectoryRecords = new EzcardMemberDirectoryRecords();
        $objMemberDirectoryRecordResult = $objMemberDirectoryRecords->getById($memberID);

        if ($objMemberDirectoryRecordResult->getResult()->Count === 0)
        {
            return $this->renderReturnJson(false, [], "No directory member record found for id $memberID for updating.");
        }

        $memberRecord = $objMemberDirectoryRecordResult->getData()->first();

        $memberRecord->first_name = $data->member->first_name;
        $memberRecord->last_name = $data->member->last_name;
        $memberRecord->mobile_phone = $data->member->mobile_phone;
        $memberRecord->email = $data->member->email;

        if ($data->member->profile_image_url === "__remove__")
        {
            $memberRecord->profile_image_url = EXCELL_EMPTY_STRING;
        }

        $objMemberDirectoryRecordUpdateResult = $objMemberDirectoryRecords->update($memberRecord);

        $this->upsertCustomMemberFields($data, $memberID, $directoryId);

        return $this->renderReturnJson($objMemberDirectoryRecordUpdateResult->getResult()->Success, $data, "Member directory record successfully updated.");
    }

    protected function upsertCustomMemberFields($data, $memberID, $directoryId) : void
    {
        if (empty($data->customFields))
        {
            return;
        }

        $objMemberDirectoryRecordValues = new EzcardMemberDirectoryRecordValues();

        foreach($data->customFields as $currField)
        {
            if (!empty($currField->file))
            {
                $objImage = new Images();
                $objImageResult = $objImage->uploadBase64ImageToMediaServer(
                    $currField->file,
                    $currField->member_directory_record_id,
                    "ezcarddirectorymemberrecords",
                    $currField->label . "_" . $currField->member_directory_column_id);

                if ($objImageResult->getResult()->Success === false)
                {
                    // TODO - Return Error
                    continue;
                }

                $currField->value = $objImageResult->getData();
            }

            $valueResult = $objMemberDirectoryRecordValues->getWhere(["member_directory_column_id" => $currField->member_directory_column_id, "member_directory_record_id" => $memberID, "member_directory_id" => $directoryId]);

            if ($valueResult->getResult()->Count === 0)
            {
                if (empty($currField->value))
                {
                    continue;
                }

                $memberValue = new EzcardMemberDirectoryRecordValueModel();
                $memberValue->member_directory_column_id = $currField->member_directory_column_id;
                $memberValue->member_directory_record_id = $memberID;
                $memberValue->member_directory_id = $directoryId;
                $memberValue->type = $this->setRecordValueType($currField);
                $memberValue->value = $currField->value;
                $objMemberDirectoryRecordValues->createNew($memberValue);

                continue;
            }

            $memberValue = $valueResult->getData()->first();

            $memberValue->member_directory_column_id = $currField->member_directory_column_id;
            $memberValue->member_directory_record_id = $memberID;
            $memberValue->member_directory_id = $directoryId;
            $memberValue->type = $this->setRecordValueType($currField);
            $memberValue->value = (empty($currField->value) ? EXCELL_EMPTY_STRING : $currField->value);

            $objMemberDirectoryRecordValues->update($memberValue);
        }
    }

    protected function setRecordValueType($recordColumn) : string
    {
        if ($recordColumn->type === "connection")
        {
            return $recordColumn->typeInstance ?? "default";
        }

        return $recordColumn->type;
    }

    public function getDirectoryRecords(ExcellHttpModel $objData) : bool
    {
        $objParamsForSync = $objData->Data->Params;

        if (!$this->validate($objParamsForSync, [
            "id" => "required|uuid"
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $recordQuery = "SELECT emdr.* 
            FROM ezdigital_v2_apps.ezcard_member_directory_record emdr 
            LEFT JOIN ezdigital_v2_apps.ezcard_member_directory emd ON emd.member_directory_id = emdr.member_directory_id 
            WHERE emd.instance_uuid = '" . $objParamsForSync["id"] . "';";

        $objDirectoryResult = Database::getSimple($recordQuery);

        if ($objDirectoryResult->getResult()->Count === 0)
        {
            return $this->renderReturnJson(true, [], "No Rows Returned.");
        }

        $objDirectoryResult->getData()->HydrateModelData(DirectoryMemberRels::class);

        return $this->renderReturnJson(true, $objDirectoryResult->getData()->ToPublicArray(), "Here's what I got.");
    }

    public function createDirectoryRecord(ExcellHttpModel $objData) : bool
    {
        $objParamsForSync = $objData->Data->Params;

        if (!$this->validate($objParamsForSync, [
            "id" => "required|uuid"
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $recordQuery = "SELECT emdr.* FROM ezdigital_v2_apps.ezcard_member_directory_record emdr LEFT JOIN ezdigital_v2_apps.ezcard_member_directory emd ON emd.member_directory_id = emdr.member_directory_id WHERE emd.instance_uuid = '" . $objParamsForSync["id"] . "';";

        $objDirectoryResult = Database::getSimple($recordQuery);

        if ($objDirectoryResult->getResult()->Count === 0)
        {
            return $this->renderReturnJson(false, ["query" => $recordQuery], "No Rows Returned.");
        }

        $objDirectoryResult->getData()->HydrateModelData(EzcardMemberDirectoryRecordModel::class);

        return $this->renderReturnJson(true, $objDirectoryResult->getData()->ToPublicArray(), "Here's what I got.");
    }

    public function readDirectoryRecord(ExcellHttpModel $objData) : bool
    {
        $objParamsForSync = $objData->Data->Params;

        if (!$this->validate($objParamsForSync, [
            "id" => "required|uuid"
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $recordQuery = "SELECT emdr.* FROM ezdigital_v2_apps.ezcard_member_directory_record emdr LEFT JOIN ezdigital_v2_apps.ezcard_member_directory emd ON emd.member_directory_id = emdr.member_directory_id WHERE emd.instance_uuid = '" . $objParamsForSync["id"] . "';";

        $objDirectoryResult = Database::getSimple($recordQuery);

        if ($objDirectoryResult->getResult()->Count === 0)
        {
            return $this->renderReturnJson(false, ["query" => $recordQuery], "No Rows Returned.");
        }

        $objDirectoryResult->getData()->HydrateModelData(EzcardMemberDirectoryRecordModel::class);

        return $this->renderReturnJson(true, $objDirectoryResult->getData()->ToPublicArray(), "Here's what I got.");
    }

    public function updateDirectoryRecord(ExcellHttpModel $objData) : bool
    {
        $objParamsForSync = $objData->Data->Params;

        if (!$this->validate($objParamsForSync, [
            "id" => "required|uuid"
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $recordQuery = "SELECT emdr.* FROM ezdigital_v2_apps.ezcard_member_directory_record emdr LEFT JOIN ezdigital_v2_apps.ezcard_member_directory emd ON emd.member_directory_id = emdr.member_directory_id WHERE emd.instance_uuid = '" . $objParamsForSync["id"] . "';";

        $objDirectoryResult = Database::getSimple($recordQuery);

        if ($objDirectoryResult->getResult()->Count === 0)
        {
            return $this->renderReturnJson(false, ["query" => $recordQuery], "No Rows Returned.");
        }

        $objDirectoryResult->getData()->HydrateModelData(EzcardMemberDirectoryRecordModel::class);

        return $this->renderReturnJson(true, $objDirectoryResult->getData()->ToPublicArray(), "Here's what I got.");
    }

    public function deleteDirectoryRecord(ExcellHttpModel $objData) : bool
    {
        $objParams = $objData->Data->Params;

        if (!$this->validate($objParams, [
            "member" => "required|integer"
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $objDirectoryRecord = new EzcardMemberDirectoryRecords();
        $result = $objDirectoryRecord->deleteById($objParams["member"]);

        $objDirectoryRecordValues = new EzcardMemberDirectoryRecordValues();
        $resultValues = $objDirectoryRecordValues->deleteWhere(["member_directory_record_id" => $objParams["member"]]);

        return $this->renderReturnJson(true, ["member" => $result->getResult()->Message,"memberValues" => $resultValues->getResult()->Message,], "Here's what we got.");
    }

    public function signInUserAccount(ExcellHttpModel $objData) : bool
    {
        // Return Vue Object for Module Configuration.
        if (!$this->validateRequestType('POST'))
        {
            return false;
        }

        $objParams = $objData->Data->PostData;

        if (!$this->validate($objParams, [
            "directory_id" => "required|integer",
            "username" => "required",
            "password" => "required",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $objResult = $this->callToEzcardApi("post", "/api/v1/users/validate-existing-user-credentials", [
                "username" => $objParams->username,
                "password" => $objParams->password,
            ]
        );

        if (!isset($objResult->getData()->success))
        {
            return $this->renderReturnJson(false, [], "Unable to complete your request: " . $this->app->objCustomPlatform->getFullPortalDomain() . ": " . $objResult->getResult()->Message);
        }

        if ($objResult->getData()->success === false || empty($objResult->getData()->data->user))
        {
            return $this->renderReturnJson(false, [], $objResult->getData()->message);
        }

        $result = $this->createNewMemberRecordFromApiResult($objResult->getData()->data->user, $objParams->directory_id, $objParams->consideration);

        if ($result->getResult()->Success === false)
        {
            return $this->renderReturnJson(false, [], $result->getResult()->Message);
        }

        $directory = (new EzcardMemberDirectories())->getById($objParams->directory_id)->getData()->first();

        $this->sendCustomFieldRequestEmail($result->getData()->first());
        $this->sendCardOwnerDirectoryRequestEmail($result->getData()->first(), $directory->instance_uuid, static::MemberDirectoryUuid);

        return $this->renderReturnJson(true, ["user" => $result->getData()->first()], "We got this.");
    }

    protected function createNewMemberRecordFromApiResult($user, $directoryId, $message = null) : ExcellTransaction
    {
        $objMemberRecords = new EzcardMemberDirectoryRecords();

        $objMemberRecordCheckResult = $objMemberRecords->getWhere(["member_directory_id" => $directoryId, "user_id" => $user->id]);

        if ($objMemberRecordCheckResult->getResult()->Count > 0)
        {
            if ($objMemberRecordCheckResult->getData()->first()->status === "pending")
            {
                return $this->renderReturnJson(false, [], "You are waiting on approval from the owner.");
            }
            if ($objMemberRecordCheckResult->getData()->first()->status === "active")
            {
                return $this->renderReturnJson(false, [], "You've already registered for this directory.");
            }

            return $this->renderReturnJson(false, [], "It looks like you've tried to register with this directory before, but there is an error.");
        }

        $memberRecord = new EzcardMemberDirectoryRecordModel();

        $memberRecord->first_name = $user->first_name;
        $memberRecord->last_name = $user->last_name;
        $memberRecord->email = $user->email;
        $memberRecord->mobile_phone = $user->phone;
        $memberRecord->user_id = $user->id;
        $memberRecord->member_directory_id = $directoryId;
        $memberRecord->status = "disabled";

        if (!empty($message))
        {
            $memberRecord->consideration_message = $message;
        }

        return $objMemberRecords->createNew($memberRecord);
    }

    public function createUserAccount(ExcellHttpModel $objData) : bool
    {
        // Return Vue Object for Module Configuration.
        if (!$this->validateRequestType('POST'))
        {
            return false;
        }

        $objParams = $objData->Data->PostData;

        if (!$this->validate($objParams, [
            "first_name" => "required",
            "last_name" => "required",
            "email" => "required|email",
            "phone" => "required",
            "username" => "required",
            "password" => "required|passwordComplex",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $objResult = $this->callToEzcardApi("post", "/api/v1/users/create-new-user", [
                "first_name" => $objParams->first_name,
                "last_name" => $objParams->last_name,
                "email" => $objParams->email,
                "phone" => $objParams->phone,
                "username" => $objParams->username,
                "password" => $objParams->password,
            ]
        );

        if (!isset($objResult->getData()->success))
        {
            return $this->renderReturnJson(false, [], "Unable to complete your request: " . $this->app->objCustomPlatform->getFullPortalDomain() . ": " . $objResult->getResult()->Message);
        }

        if ($objResult->getData()->success === false || empty($objResult->getData()->data->user))
        {
            return $this->renderReturnJson(false, [], $objResult->getData()->message);
        }

        $result = $this->createNewMemberRecordFromApiResult($objResult->getData()->data->user, $objParams->directory_id, $objParams->consideration);

        if ($result->getResult()->Success === false)
        {
            return $this->renderReturnJson(false, [], $result->getResult()->Message);
        }

        $directory = (new EzcardMemberDirectories())->getById($objParams->directory_id)->getData()->first();

        $this->sendCustomFieldRequestEmail($result->getData()->first());
        $this->sendCardOwnerDirectoryRequestEmail($result->getData()->first(), $directory->instance_uuid, static::MemberDirectoryUuid);

        return $this->renderReturnJson(true, ["user" => $result->getData()->first()], "We got this.");
    }

    public function createUserAccountDrLydie(ExcellHttpModel $objData) : bool
    {
        // Return Vue Object for Module Configuration.
        if (!$this->validateRequestType('POST'))
        {
            return false;
        }

        $objParams = $objData->Data->PostData;

        if (!$this->validate($objParams, [
            "first_name" => "required",
            "last_name" => "required",
            "email" => "required|email",
            "phone" => "required",
            "username" => "required",
            "password" => "required|passwordComplex",
            "company" => "required",
            "title" => "required",
            "industry" => "required",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $objResult = $this->callToEzcardApi("post", "/api/v1/users/create-new-user", [
                "first_name" => $objParams->first_name,
                "last_name" => $objParams->last_name,
                "email" => $objParams->email,
                "phone" => $objParams->phone,
                "username" => $objParams->username,
                "password" => $objParams->password,
            ]
        );

        if (!isset($objResult->getData()->success))
        {
            return $this->renderReturnJson(false, [], "Unable to complete your request.");
        }

        if ($objResult->getData()->success === false || empty($objResult->getData()->data->user))
        {
            return $this->renderReturnJson(false, [], $objResult->getData()->message);
        }

        $result = $this->createNewMemberRecordFromApiResult($objResult->getData()->data->user, $objParams->directory_id, $objParams->consideration);

        if ($result->getResult()->Success === false)
        {
            return $this->renderReturnJson(false, [], $result->getResult()->Message);
        }

        $directory = (new EzcardMemberDirectories())->getById($objParams->directory_id)->getData()->first();

        $this->sendCustomFieldRequestEmailWithAttachments($result->getData()->first(), "Thank you for signing up with Dr. Lydie!", [AppCore . "public/media/legal/resources/ND-NC-NC-NS-Agreement-VIP-Resource.pdf"]);
        $this->sendCardOwnerDirectoryRequestEmail($result->getData()->first(), $directory->instance_uuid, static::MemberDirectoryUuid);

        return $this->renderReturnJson(true, ["user" => $result->getData()->first()], "We got this.");
    }

    protected function callToEzcardApi($verb, $url, $data) : ExcellTransaction
    {
        $objHttp = new Http();

        try
        {
            $objHttpRequest = $objHttp->newRequest(
                $verb,
                $this->app->objCustomPlatform->getFullPortalDomain() . $url,
                $data
            );

            $objHttpResponse = $objHttpRequest->send();

            if ($objHttpResponse->statusCode !== 200)
            {
                return new ExcellTransaction(false,"Received [{$objHttpResponse->statusCode}] status code from module configuration endpoint " . getFullUrl() . $url . "." );
            }

            if (empty($objHttpResponse->body))
            {
                return new ExcellTransaction(false,"No body returned from module configuration endpoint " . getFullUrl() . $url . "." );
            }

            $objUserCreationResult = json_decode($objHttpResponse->body);

            return new ExcellTransaction(true, "Success", $objUserCreationResult, 1, [], getFullUrl() . $url);

        } catch(\Exception $ex)
        {
            return new ExcellTransaction(false,"Exception Throw: " . $ex);
        }
    }

    public function updateDirectoryPageData(ExcellHttpModel $objData) : bool
    {
        // Return Vue Object for Module Configuration.
        if (!$this->validateRequestType('POST'))
        {
            return false;
        }

        $objParams = $objData->Data->Params;

        if (!$this->validate($objParams, [
            "id" => "required|uuid",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $objPost = $objData->Data->PostData;

        if (!$this->validate($objPost, [
            "title" => "required",
            "ownerId" => "required|integer"
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $objMemberDirectories = new EzcardMemberDirectories();
        $objMemberDirectoryResult = $objMemberDirectories->getWhere(["instance_uuid" => $objParams["id"]]);

        if ($objMemberDirectoryResult->getResult()->Count === 0)
        {
            return $this->renderReturnJson(false, [], "No directory Found.");
        }

        $objResult = $this->callToEzcardApi("post", "/api/v1/modules/update-card-page-data?company_id=0", [
                "app_uuid" => $objParams["id"],
                "title" => $objPost->title,
                "user_id" => $objPost->ownerId,
            ]
        );

        return $this->renderReturnJson($objResult->getResult()->Success, $objResult->getData()->data, $objResult->getResult()->Message);
    }

    public function updateMemberVisibility(ExcellHttpModel $objData) : bool
    {
        // Return Vue Object for Module Configuration.
        if (!$this->validateRequestType('POST'))
        {
            return false;
        }

        $objParams = $objData->Data->Params;

        if (!$this->validate($objParams, [
            "id" => "required|integer",
            "status" => "required"
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $objMemberDirectoryRecords = new EzcardMemberDirectoryRecords();
        $objMemberDirectoryRecordResult = $objMemberDirectoryRecords->getById($objParams["id"]);

        if ($objMemberDirectoryRecordResult->getResult()->Count === 0)
        {
            return $this->renderReturnJson(false, [], "No directory member record found for id ".$objParams["id"]." for updating.");
        }

        $memberRecord = $objMemberDirectoryRecordResult->getData()->first();

        $memberRecord->status = $objParams["status"];

        $objMemberDirectoryRecordUpdateResult = $objMemberDirectoryRecords->update($memberRecord);

        return $this->renderReturnJson(true, ["status" => $objParams["status"]], "We got this.");
    }

    public function downloadMemberRecordCsv(ExcellHttpModel $objData) : bool
    {
        $objParams = $objData->Data->Params;

        if (!$this->validate($objParams, [
            "id" => "required|uuid",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $recordQuery = "SELECT emdc.* FROM ezdigital_v2_apps.ezcard_member_directory_column emdc LEFT JOIN ezdigital_v2_apps.ezcard_member_directory_template emdt ON emdt.member_directory_template_id = emdc.template_id LEFT JOIN ezdigital_v2_apps.ezcard_member_directory emd ON emd.template_id = emdt.member_directory_template_id WHERE emd.instance_uuid = '" . $objParams["id"] . "' ORDER BY emdc.order;";
        $objMemberDirectoryColumnResult = Database::getSimple($recordQuery);

        if ($objMemberDirectoryColumnResult->getResult()->Count === 0)
        {
            return $this->renderReturnJson(false, ["query" => $recordQuery], "No Rows Returned.");
        }

        $objMemberDirectoryColumnResult->getData()->HydrateModelData(EzcardMemberDirectoryColumnModel::class);

        $columns = ["first_name", "last_name", "title", "mobile_phone", "email", "profile_image_url", "hex_color"];

        /** @var EzcardMemberDirectoryColumnModel $currColumn */
        foreach($objMemberDirectoryColumnResult->getData() as $currColumn)
        {
            $columns[] = $currColumn->label;
            if ($currColumn->type === "connection")
            {
                $columns[] = $currColumn->label . "_type";
            }
        }

        $tempFilePathAndName = AppTmp . getGuid() . '.csv';
        register_shutdown_function('unlink', $tempFilePathAndName);

        $new_csv = fopen($tempFilePathAndName, 'w');
        fputcsv($new_csv, $columns);
        fclose($new_csv);

        header("Content-type: text/csv");
        header("Cache-Control: must-revalidate");
        header("Pragma: public");
        header('Content-Length: ' . filesize($tempFilePathAndName));
        header("Content-disposition: attachment; filename = UploadTemplateForDirectoryMembers.csv");

        flush();

        readfile($tempFilePathAndName);

        die;
    }

    public function downloadTemplateCsvForMemberRecords(ExcellHttpModel $objData) : bool
    {
        $objParams = $objData->Data->Params;

        if (!$this->validate($objParams, [
            "id" => "required|uuid",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $recordQuery = "SELECT emdc.* FROM ezdigital_v2_apps.ezcard_member_directory_column emdc LEFT JOIN ezdigital_v2_apps.ezcard_member_directory_template emdt ON emdt.member_directory_template_id = emdc.template_id LEFT JOIN ezdigital_v2_apps.ezcard_member_directory emd ON emd.template_id = emdt.member_directory_template_id WHERE emd.instance_uuid = '" . $objParams["id"] . "' ORDER BY emdc.order;";
        $objMemberDirectoryColumnResult = Database::getSimple($recordQuery);

        if ($objMemberDirectoryColumnResult->getResult()->Count === 0)
        {
            return $this->renderReturnJson(false, ["query" => $recordQuery], "No Rows Returned.");
        }

        $objMemberDirectoryColumnResult->getData()->HydrateModelData(EzcardMemberDirectoryColumnModel::class);

        $columns = ["first_name", "last_name", "title", "mobile_phone", "email", "profile_image_url", "hex_color"];

        /** @var EzcardMemberDirectoryColumnModel $currColumn */
        foreach($objMemberDirectoryColumnResult->getData() as $currColumn)
        {
            $columns[] = $currColumn->label;
            if ($currColumn->type === "connection")
            {
                $columns[] = $currColumn->label . "_type";
            }
        }

        $tempFilePathAndName = AppTmp . getGuid() . '.csv';
        register_shutdown_function('unlink', $tempFilePathAndName);

        $new_csv = fopen($tempFilePathAndName, 'w');
        fputcsv($new_csv, $columns);
        fclose($new_csv);

        header("Content-type: text/csv");
        header("Cache-Control: must-revalidate");
        header("Pragma: public");
        header('Content-Length: ' . filesize($tempFilePathAndName));
        header("Content-disposition: attachment; filename = UploadTemplateForDirectoryMembers.csv");

        flush();

        readfile($tempFilePathAndName);

        die;
    }

    public function uploadTemplateCsvIntoMemberRecords(ExcellHttpModel $objData) : bool
    {
        $objParams = $objData->Data->Params;

        if (!$this->validate($objParams, [
            "id" => "required|uuid",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $objDirectoryResult = (new EzcardMemberDirectories())->getWhere(["instance_uuid" => $objParams["id"]]);

        if ($objDirectoryResult->getResult()->Count !== 1)
        {
            return $this->renderReturnJson(false, [], "Directory not found. " . $objDirectoryResult->getResult()->Message);
        }

        $objDirectory = $objDirectoryResult->getData()->first();

        $arFile = $_FILES["file"];
        $arFilePath = explode(".", $arFile["name"]);
        $strFileExtension = end($arFilePath);
        $strTempFilePath = $arFile["tmp_name"];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $strTempFilePath);

        if (
            strtolower($strFileExtension) !== "csv"
            || ($mime != "text/plain")
        )
        {
            return $this->renderReturnJson(false, [], "You can only upload a CSV file: "  . $mime);
        }

        $tempFilePathAndName = AppTmp . getGuid() . '.csv';
        register_shutdown_function('unlink', $strTempFilePath);
        register_shutdown_function('unlink', $tempFilePathAndName);

        if (!move_uploaded_file($strTempFilePath, $tempFilePathAndName))
        {
            return $this->renderReturnJson(false, [], "Server Error: File could not be moved: " . $arFile["name"]);
        }

        $handle = null;

        if (($handle = fopen($tempFilePathAndName, "r")) === false)
        {
            return $this->renderReturnJson(false, [], "Server Error: File could not be opened: " . $arFile["name"]);
        }

        $row = 1;
        $csvFields = [];
        $csvResult = [];

        while (($data = fgetcsv($handle, 1000, ",")) !== false)
        {
            $num = count($data);

            if ($row === 1)
            {
                for ($c=0; $c < $num; $c++)
                {
                    $csvFields[$c] = $data[$c];
                }
                $row++;
                continue;
            }

            for ($c=0; $c < $num; $c++)
            {
                $csvResult[($row - 1)][$csvFields[$c]] = $data[$c];
            }
            $row++;
        }

        fclose($handle);

        list($newRecords, $errors) = $this->generateNewMembershipRecords($objDirectory, $csvResult);

        return $this->renderReturnJson(true, ["newRecords" => $newRecords, "errors" => $errors], "We got this.");
    }

    protected function generateNewMembershipRecords(EzcardMemberDirectoryModel $objDirectory, $csvResult) : array
    {
        $newRecords = [];

        $objMemberRecord = new EzcardMemberDirectoryRecords();
        $objMemberDirectoryColumnResult = (new EzcardMemberDirectoryColumns())->getColumnsByDirectoryId($objDirectory->member_directory_id);

        $errors = [];

        foreach($csvResult as $currNewMember)
        {
            if (!$this->validate($currNewMember, [
                "first_name" => "required",
                //"last_name" => "required",
                //"mobile_phone" => "required",
                //"email" => "required|email",
            ] ))
            {
                $errors[] = $currNewMember;
                continue;
            }

            $currNewMember["mobile_phone"] = preg_replace("/[^0-9\+]/", '', $currNewMember["mobile_phone"]);
            $currNewMember["hex_color"] = preg_replace("/[^A-Za-z0-9]/", '', $currNewMember["hex_color"]);

            $newMember = new EzcardMemberDirectoryRecordModel($currNewMember);
            $newMember->member_directory_id = $objDirectory->member_directory_id;
            $newMember->status = "disabled";
            $newMemberResult = $objMemberRecord->createNew($newMember);
            $newMemberRecord = $newMemberResult->getData()->first();
            $newRecords[] = $newMemberResult->getData()->first()->ToArray();

            $data = new \stdClass();
            $data->customFields = [];

            /** @var EzcardMemberDirectoryColumnModel $currColumn */
            foreach($objMemberDirectoryColumnResult->getData() as $currColumn)
            {
                if (!empty($currNewMember[$currColumn->label]))
                {
                    $currColumn->AddUnvalidatedValue("value", $currNewMember[$currColumn->label]);

                    if ($currColumn->type === "connection")
                    {
                        $currColumn->AddUnvalidatedValue("typeInstance", strtolower($currNewMember[$currColumn->label . "_type"] ?? "default"));
                    }

                    $data->customFields[] = $currColumn;
                }
            }

            $this->upsertCustomMemberFields($data, $newMemberRecord->member_directory_record_id, $objDirectory->member_directory_id);
        }

        return [$newRecords, $errors];
    }

    public function customFieldRequestEmail(ExcellHttpModel $objData) : bool
    {
        $this->sendCustomFieldRequestEmail(new EzcardMemberDirectoryRecordModel($objData->Data->PostData));

        return true;
    }

    private function sendCardOwnerDirectoryRequestEmail(EzcardMemberDirectoryRecordModel $user, $instanceUuid, $moduleAppUuid, $message = null) : void
    {
        if (empty($message)) { $message = "You have received a record request for a membership directory on card [CARD_ID]."; }

        $strBody = "<p>{$message}</p>".
            "<p>Name: ".$user->first_name. " " . $user->last_name."<br/>".
            "E-Mail: ".$user->email."<br/>".
            "Phone: ".$user->mobile_phone."<br/></p>".
            "<p><a style='color:#fff; background: #1e88e5;display: inline-block;padding:5px 12px;' href='" . getFullUrl() . "/api/v1/directories/public-full-page/approve-directory-member?id=" . $user->sys_row_id . "'>Approve it!</a></p>" .
            "<p>You may also ignore it, or <a href='" . getFullUrl() . "/api/v1/directories/public-full-page/approve-directory-member?id=" . $user->sys_row_id . "'>delete it!</a></p>";

        $objResult = $this->callToEzcardApi("post", "/api/v1/modules/send-module-owner-notification", [
                "module_app_uuid" => $moduleAppUuid,
                "instance_uuid" => $instanceUuid,
                "subject" => "Directory Membership Request for " . $user->first_name. " " . $user->last_name,
                "body" => $strBody
            ]
        );
    }

    private function sendCustomFieldRequestEmail(EzcardMemberDirectoryRecordModel $user, $message = "") : void
    {
        $strCustomMessage = $objData->Data->PostData->msg ?? "";
        $customPlatformName = $this->app->objCustomPlatform->getPortalName();
        $customPlatformNoReplyEmail = $this->app->objCustomPlatform->getCompanySettings()->FindEntityByValue("label", "noreply_email")->value ?? "noreply@ezdigital.com";
        $customPlatformSupportEmail = $this->app->objCustomPlatform->getCompanySettings()->FindEntityByValue("label", "customer_support_email")->value ?? "support@ezdigital.com";
        if (empty($message)) { $message = "Thank you for requesting a directory membership. This directory has additional fields you may want to fill out to make your membership display more robust!"; }

        $strEmailFullName = $user->first_name. " " . $user->last_name;
        $strUserEmail = $user->email;
        $strSubject = $user->first_name. " " . $user->last_name. "'s Directory Membership Request - Additional Data Requested";
        $strBody = "<p>Hi {$user->first_name},</p>" .
            "<p>{$message}</p>".
            "<p><a href='" . getFullUrl() . "/api/v1/directories/public-full-page/member-profile?id=" . $user->sys_row_id . "'>Click here</a> to manage your profile!</p>" .
            "<p>Your {$customPlatformName} App Team<br>{$customPlatformSupportEmail}</p>";

        (new Emails())->SendEmail(
            $customPlatformName . " Support <{$customPlatformNoReplyEmail}>",
            ["{$strEmailFullName} <{$strUserEmail}>"],
            $strSubject,
            $strBody
        );
    }

    private function sendCustomFieldRequestEmailWithAttachments(EzcardMemberDirectoryRecordModel $user, string $message = "", array $attachments = []) : void
    {
        $strCustomMessage = $objData->Data->PostData->msg ?? "";
        $customPlatformName = $this->app->objCustomPlatform->getPortalName();
        $customPlatformNoReplyEmail = $this->app->objCustomPlatform->getCompanySettings()->FindEntityByValue("label", "noreply_email")->value ?? "noreply@ezdigital.com";
        $customPlatformSupportEmail = $this->app->objCustomPlatform->getCompanySettings()->FindEntityByValue("label", "customer_support_email")->value ?? "support@ezdigital.com";
        if (empty($message)) { $message = "Thank you for requesting a directory membership. This directory has additional fields you may want to fill out to make your membership display more robust!"; }

        $strEmailFullName = $user->first_name. " " . $user->last_name;
        $strUserEmail = $user->email;
        $strSubject = $user->first_name. " " . $user->last_name. "'s Registration With Dr. Lydie";
        $strBody = "<p>Hi {$user->first_name},</p>" .
            "<p>{$message}</p>".
            "<p>Please find attached your free business resource valued at $750. We appreciate the opportunity to serve you!</p>".
            "<p>Sincerely,<br>Team Dr. Lydie<br>{$customPlatformSupportEmail}</p>";

        $to = ["{$strEmailFullName} <{$strUserEmail}>"];

        (new Emails())->SendEmail(
            $customPlatformName . " Support <{$customPlatformNoReplyEmail}>",
            $to,
            $strSubject,
            $strBody,
            $attachments
        );
    }

    public function getDirectoryData(ExcellHttpModel $objData) : bool
    {
        $objParams = $objData->Data->Params;

        if (!$this->validate($objParams, [
            "id" => "required|uuid",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $objDirectoryResult = (new EzcardMemberDirectories())->getFullRecordByUuid($objParams["id"]);

        $objDirectory = $objDirectoryResult->getData()->first();

        return $this->renderReturnJson(true, [
            "directoryName" => $objDirectory->defaults->FindEntityByValue("label", "directory_name")->value ?? "",
            "directorySortBy" => $objDirectory->defaults->FindEntityByValue("label", "sort_by")->value ?? "first_name",
            "directorySortOrder" => $objDirectory->defaults->FindEntityByValue("label", "sort_order")->value ?? "asc",
            "directoryTemplate" => $objDirectory->template->member_directory_template_id ?? "1",
            "directoryHeaderImage" => $objDirectory->defaults->FindEntityByValue("label", "header_image")->value ?? "",
            "directoryHeaderText" => $objDirectory->defaults->FindEntityByValue("label", "header_html")->value ?? "",
            "directoryFooterImage" => $objDirectory->defaults->FindEntityByValue("label", "footer_image")->value ?? "",
            "directoryHexColor" => $objDirectory->defaults->FindEntityByValue("label", "main_color")->value ?? "",
        ], "We got this.");
    }

    public function saveDirectoryData(ExcellHttpModel $objData) : bool
    {
        $objParams = $objData->Data->Params;

        if (!$this->validate($objParams, [
            "id" => "required|uuid",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $objDirectoryResult = (new EzcardMemberDirectories())->getWhere(["instance_uuid" => $objParams["id"]]);

        $objDirectory = $objDirectoryResult->getData()->first();

        foreach($objData->Data->PostData as $currField => $currData )
        {
            switch($currField)
            {
                case "directoryName": $this->updateDirectoryDefault("directory_name", $currData, $objDirectory); break;
                case "directorySortBy": $this->updateDirectoryDefault("sort_by", $currData, $objDirectory); break;
                case "directorySortOrder": $this->updateDirectoryDefault("sort_order", $currData, $objDirectory); break;
                case "directoryHeaderImage": $this->updateDirectoryDefault("header_image", $currData, $objDirectory); break;
                case "directoryHeaderText": $this->updateDirectoryDefault("header_html", $currData, $objDirectory); break;
                case "directoryFooterImage": $this->updateDirectoryDefault("footer_image", $currData, $objDirectory); break;
                case "directoryHexColor": $this->updateDirectoryDefault("main_color", str_replace("#", "", strtolower($currData)), $objDirectory); break;
            }
        }

        $objDirectory->template_id = $objData->Data->PostData->directoryTemplate;
        (new EzcardMemberDirectories())->update($objDirectory);

        return $this->renderReturnJson(true, $objData->Data->PostData, "We got this.");
    }

    protected function updateDirectoryDefault($fieldName, $value, $directory) : void
    {
        $objDirectoryDefaults = new EzcardMemberDirectoryDefaults();
        $objDirectoryResults = $objDirectoryDefaults->getWhere(["label" => $fieldName, "directory_id" => $directory->member_directory_id]);

        if ($objDirectoryResults->getResult()->Count === 1)
        {
            $objDirectory = $objDirectoryResults->getData()->first();
            $objDirectory->value = $value;
            $objDirectoryDefaults->update($objDirectory);
            return;
        }

        $directoryModel = new EzcardMemberDirectoryDefaultModel();
        $directoryModel->directory_id = $directory->member_directory_id;
        $directoryModel->template_id = $directory->template_id;
        $directoryModel->label = $fieldName;
        $directoryModel->value = $value;

        $objDirectoryDefaults->createNew($directoryModel);
    }

    public function memberProfile(ExcellHttpModel $objData) : bool
    {
        $objParams = $objData->Data->Params;

        if (!$this->validate($objParams, [
            "id" => "required|uuid",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $objMemberDirectory = new EzcardMemberDirectoryRecords();
        $objMemberDirectoryResult = $objMemberDirectory->getWhere(["sys_row_id" => $objParams["id"]]);

        if ($objMemberDirectoryResult->getResult()->Count !== 1)
        {
            return false;
        }

        /** @var EzcardMemberDirectoryRecordModel $memberRecord */
        $memberRecord = $objMemberDirectoryResult->getData()->first();

        $objDirectory = new EzcardMemberDirectories();
        $objDirectoryResult = $objDirectory->getById($memberRecord->member_directory_id);

        if ($objDirectoryResult->getResult()->Count !== 1)
        {
            return false;
        }

        $objMemberDirectories = new EzcardMemberDirectories();
        $content = $objMemberDirectories->getView("v1.member.public_edit_profile", $this->app->strAssignedPortalTheme, [
            "directoryId" => $objDirectoryResult->getData()->first()->instance_uuid,
            "memberData" => $memberRecord,
        ]);

        die($content);
    }

    public function updateMemberProfileFromPublicLink(ExcellHttpModel $objData) : bool
    {
        $objParams = $objData->Data->Params;

        if (!$this->validate($objParams, [
            "id" => "required|uuid",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }
    }

    public function uploadCustomImageMemberRecords(ExcellHttpModel $objData): bool
    {
        $objParams = $objData->Data->Params;

        if (!$this->validate($objParams, [
            "id" => "required|integer",
            "member" => "required|integer",
            "column" => "required|integer",
            "directory" => "required|integer",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $objRecordValueResult = (new EzcardMemberDirectoryRecordValues())->getById($objParams["id"]);

        if ($objRecordValueResult->getResult()->Count !== 1)
        {
            $newRecordValue = new EzcardMemberDirectoryRecordValueModel();

            $newRecordValue->member_directory_id = $objParams["directory"];
            $newRecordValue->member_directory_record_id = $objParams["member"];
            $newRecordValue->member_directory_column_id = $objParams["column"];
            $newRecordValue->type = "image";
            $newRecordValue->value = "";

            $objRecordValueResult = (new EzcardMemberDirectoryRecordValues())->createNew($newRecordValue);
        }

        $objRecordValue = $objRecordValueResult->getData()->first();


        if (!move_uploaded_file($strTempFilePath, $tempFilePathAndName))
        {
            return $this->renderReturnJson(false, [], "Server Error: File could not be moved: " . $arFile["name"]);
        }
    }

    public function loadManageUserProfile() : bool
    {
        $mainComponentId = getGuid();
        $mainComponentName = "comp" . preg_replace("/[^A-Za-z0-9]/", '', $mainComponentId);

        $objMemberDirectories = new EzcardMemberDirectories();

        $editMemberComponent = $objMemberDirectories->getView("v1.config.edit_member", $this->app->strAssignedPortalTheme, [
            "mainComponentId" => $mainComponentId,
            "mainComponentName" => $mainComponentName,
        ]);

        $memberDataSelectorComponent = $objMemberDirectories->getView("v1.config.member_data_selector", $this->app->strAssignedPortalTheme, [
            "mainComponentId" => $mainComponentId,
            "mainComponentName" => $mainComponentName,
        ]);

        $result = 'return {
            main: ' . $editMemberComponent . ',
            helpers: [
                ' . $memberDataSelectorComponent . ',
            ]
        }';

        return $this->renderReturnJson(true, base64_encode($result), "Widget processed.", 200, "widget");
    }

    public function sendMemberRecordPublicManagementLink(ExcellHttpModel $objData) : bool
    {
        $objParams = $objData->Data->Params;

        if (!$this->validate($objParams, [
            "id" => "required|integer",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $objMemberRecords = new EzcardMemberDirectoryRecords();
        $result = $objMemberRecords->getById($objParams["id"]);

        if ($result->getResult()->Success === false)
        {
            return $this->renderReturnJson(false, [], $result->getResult()->Message);
        }

        $this->sendCustomFieldRequestEmail($result->getData()->first(), "Here is your private directory member management link! You can fill out the applicable fields immediately, and then save the link for future reference to manage your membership information.");
    }

    public function getEzdigitalUsers(ExcellHttpModel $objData) : bool
    {
        $objParams = $objData->Data->Params;

        if (!$this->validate($objParams, [
            "id" => "required|uuid",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $objResult = $this->callToEzcardApi("post", "/api/v1/modules/get-user-list", [
                "module_id" => 12345,
            ]
        );

        return $this->renderReturnJson($objResult->getResult()->Success, $objResult->getData()->data, $objResult->getResult()->Message);
    }
}