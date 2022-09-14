<?php

namespace Http\Directories\Controllers\Api\V1;

use App\Utilities\Database;
use App\Utilities\Excell\ExcellHttpModel;
use Entities\Cards\Classes\Cards;
use Entities\Directories\Classes\Directories;
use Entities\Directories\Models\DirectoryModel;
use Http\Directories\Controllers\Base\DirectoryController;

class ApiController extends DirectoryController
{
    public function configMain(ExcellHttpModel $objData) : bool
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
            "widget_id" => "required|uuid",
            "instance_id" => "required",
            "site_id" => "required|integer",
            "user_id" => "required|uuid",
            "platform_id" => "required|uuid",
            "platform_url" => "required",
            "platform_name" => "required",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $objCards = new Cards();
        $objCardResult = $objCards->getById($objParams["site_id"]);

        if ($objCardResult->getResult()->Count === 0)
        {
            return $this->renderReturnJson(false, [], "Site ".$objParams["site_id"]." not found!");
        }

        $directories = new Directories();
        $directoryResult = $directories->getFullRecordByUuid($objParams["instance_id"]);
        $directory = $directoryResult->getData()->first();

        $mainComponentId = getGuid();
        $mainComponentName = "comp" . preg_replace("/[^A-Za-z0-9]/", '', $mainComponentId);

        $mainComponent = $directories->getView("v1.config.main", $this->app->strAssignedPortalTheme, [
            "mainComponentId" => $mainComponentId,
            "mainComponentName" => $mainComponentName,
            "platformId" => $objParams["platform_id"],
            "customPlatformUrl" => $objParams["platform_url"],
        ]);

        $editMemberComponent = $directories->getView("v1.config.edit_member", $this->app->strAssignedPortalTheme, [
            "mainComponentId" => $mainComponentId,
            "mainComponentName" => $mainComponentName,
            "platformId" => $objParams["platform_id"],
            "customPlatformUrl" => $objParams["platform_url"],
        ]);

        $emailMemberComponent = $directories->getView("v1.config.email_member", $this->app->strAssignedPortalTheme, [
            "mainComponentId" => $mainComponentId,
            "mainComponentName" => $mainComponentName,
            "platformId" => $objParams["platform_id"],
            "customPlatformUrl" => $objParams["platform_url"],
        ]);

        $uploadMemberRecordComponent = $directories->getView("v1.config.upload_member_record", $this->app->strAssignedPortalTheme, [
            "mainComponentId" => $mainComponentId,
            "mainComponentName" => $mainComponentName,
            "platformId" => $objParams["platform_id"],
            "customPlatformUrl" => $objParams["platform_url"],
        ]);

        $manageDirectoryComponent = $directories->getView("v1.config.manage_directory", $this->app->strAssignedPortalTheme, [
            "mainComponentId" => $mainComponentId,
            "mainComponentName" => $mainComponentName,
            "platformId" => $objParams["platform_id"],
            "customPlatformUrl" => $objParams["platform_url"],
        ]);

        $memberDataSelectorComponent = $directories->getView("v1.config.member_data_selector", $this->app->strAssignedPortalTheme, [
            "mainComponentId" => $mainComponentId,
            "mainComponentName" => $mainComponentName,
            "platformId" => $objParams["platform_id"],
            "customPlatformUrl" => $objParams["platform_url"],
        ]);

        $result = 'return {
            main: ' . $mainComponent . ',
            helpers: [
                ' . $uploadMemberRecordComponent . ',
                ' . $manageDirectoryComponent . ',
                ' . $memberDataSelectorComponent . ',
                ' . $emailMemberComponent . ',
                ' . $editMemberComponent . ',
            ]
        }';

        return $this->renderReturnJson(true, base64_encode($result), "Widget processed.", 200, "widget");
    }

    public function publicFullPage(ExcellHttpModel $objData) : bool
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
            "widget_id" => "required|uuid",
            "instance_id" => "required",
            "site_id" => "required|integer",
            "user_id" => "required|uuid",
            "platform_id" => "required|uuid",
            "platform_url" => "required",
            "platform_name" => "required",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $objCards = new Cards();
        $objCardResult = $objCards->getById($objParams["site_id"]);

        if ($objCardResult->getResult()->Count === 0)
        {
            return $this->renderReturnJson(false, [], "Site ".$objParams["site_id"]." not found!");
        }

        $directories = new Directories();
        $directoryResult = $directories->getFullRecordByUuid($objParams["instance_id"]);
        $directory = $directoryResult->getData()->first();

        $mainComponentId = getGuid();
        $mainComponentName = "comp" . preg_replace("/[^A-Za-z0-9]/", '', $mainComponentId);

        $mainComponent = $directories->getView("v1.publicfullpage.main", $this->app->strAssignedPortalTheme, [
            "mainComponentId" => $mainComponentId,
            "mainComponentName" => $mainComponentName,
            "platformId" => $objParams["platform_id"],
            "customPlatformUrl" => $objParams["platform_url"],
        ]);

        $registerNewMemberComponent = $directories->getView("v1.publicfullpage.register_for_directory", $this->app->strAssignedPortalTheme, [
            "mainComponentId" => $mainComponentId,
            "mainComponentName" => $mainComponentName,
            "platformId" => $objParams["platform_id"],
            "customPlatformUrl" => $objParams["platform_url"],
        ]);

        $memberPersonaComponent = $directories->getView("v1.publicfullpage.member_persona", $this->app->strAssignedPortalTheme, [
            "mainComponentId" => $mainComponentId,
            "mainComponentName" => $mainComponentName,
            "platformId" => $objParams["platform_id"],
            "customPlatformUrl" => $objParams["platform_url"],
        ]);

        $memberDataSelectorComponent = $directories->getView("v1.publicfullpage.member_data_selector", $this->app->strAssignedPortalTheme, [
            "mainComponentId" => $mainComponentId,
            "mainComponentName" => $mainComponentName,
            "platformId" => $objParams["platform_id"],
            "customPlatformUrl" => $objParams["platform_url"],
        ]);

        $result = 'return {
            main: ' . $mainComponent . ',
            helpers: [
                ' . $memberDataSelectorComponent . ',
                ' . $memberPersonaComponent . ',
                ' . $registerNewMemberComponent . ',
            ]
        }';

        return $this->renderReturnJson(true, base64_encode($result), "Widget processed.", 200, "widget");
    }

    public function getDirectoryBatches(ExcellHttpModel $objData) : bool
    {
        $pageIndex  = $objData->Data->Params["offset"] ?? 1;
        $batchCount = $objData->Data->Params["batch"] ?? 500;
        $filterEntity = $objData->Data->Params["filterEntity"] ?? null;
        $pageIndex  = ($pageIndex - 1) * $batchCount;
        $arFields   = explode(",", $objData->Data->Params["fields"]);
        $strEnd     = "false";

        $filterIdField = "user_id";

        if ($filterEntity !== null && !isInteger($filterEntity))
        {
            $filterIdField = "sys_row_id";
            $filterEntity = "'".$filterEntity."'";
        }

        $objWhereClause = (new Directories())->buildBatchWhereClause($filterIdField, $filterEntity);

        $objWhereClause .= " LIMIT {$pageIndex}, {$batchCount}";

        $directories = Database::getSimple($objWhereClause, "card_id");

        if ($directories->getData()->Count() < $batchCount)
        {
            $strEnd = "true";
        }

        $directories->getData()->HydrateModelData(DirectoryModel::class, true);

        $arUserDashboardInfo = array(
            "list" => $directories->getData()->FieldsToArray($arFields),
            "query" => $objWhereClause,
        );

        return $this->renderReturnJson(true, $arUserDashboardInfo, "We found " . $directories->getData()->Count() . " directories in this batch.", 200, "data", $strEnd);
    }

    public function createInstanceForPage(ExcellHttpModel $objData) : bool
    {
        if (!$this->validateRequestType('POST'))
        {
            return false;
        }

        $objParams = $objData->Data->PostData;

        if (!$this->validate($objParams, [
            "instance_uuid" => "required|uuid",
            "user_id" => "required|integer",
            "company_id" => "required|integer",
            "division_id" => "required|integer",
            "type_id" => "required|integer",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $directoryModel = new DirectoryModel();
        $directoryModel->user_id = $objParams->user_id;
        $directoryModel->type_id = $objParams->type_id;
        $directoryModel->company_id = $objParams->company_id;
        $directoryModel->division_id = $objParams->division_id;
        $directoryModel->instance_uuid = $objParams->instance_uuid;
        $directoryModel->template_id = 1;
        $directoryModel->title = "Member Directory";

        $result = (new Directories())->createNew($directoryModel);

        if ($result->getResult()->Success === false)
        {
            return $this->renderReturnJson(false, ["error" => $result->getResult()->Query], $result->getResult()->Message);
        }

        return $this->renderReturnJson(true, [], "Widget processed.");
    }
}