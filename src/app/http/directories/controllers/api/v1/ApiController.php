<?php

namespace Http\Directories\Controllers\Api\V1;

use App\entities\packages\classes\PackageVariations;
use App\entities\packages\models\PackageVariationModel;
use App\Utilities\Database;
use App\Utilities\Excell\ExcellHttpModel;
use Entities\Cards\Classes\Cards;
use Entities\Directories\Classes\Directories;
use Entities\Directories\Classes\DirectoryPackages;
use Entities\Directories\Classes\DirectorySettings;
use Entities\Directories\Models\DirectoryModel;
use Entities\Directories\Models\DirectoryPackageModel;
use Entities\Directories\Models\DirectorySettingModel;
use Entities\Packages\Classes\PackageLines;
use Entities\Packages\Classes\Packages;
use Entities\Packages\Models\PackageLineModel;
use Entities\Packages\Models\PackageModel;
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
        // Why did we add this? Instance ID is ALWAYS coming across as "new" from ModuleApps::112.
        //$directoryResult = $directories->getFullRecordByUuid($objParams["instance_id"]);
        //$directory = $directoryResult->getData()->first();

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

    public function getDirectoryByUuid(ExcellHttpModel $objData) : bool
    {
        if (!$this->validateRequestType('GET')) {
            return false;
        }

        $objParams = $objData->Data->Params;

        if (!$this->validate($objParams, [
            "uuid" => "required|uuid",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $directories = new Directories();
        $directoriesResult = $directories->getFullRecordAndMembersByUuid($objParams["uuid"], $objParams["addons"]);

        if ($directoriesResult->getResult()->Count === 0) {
            $this->renderReturnJson(false, [], "No directory found.");
        }

        return $this->renderReturnJson(true, ["directory" => $directoriesResult->getData()->first()->ToPublicArray()], "We made it.");
    }

    public function getDirectoryPackages(ExcellHttpModel $objData) : bool
    {
        if (!$this->validateRequestType('GET')) {
            return false;
        }

        $params = $objData->Data->Params;

        if (!$this->validate($params, [
            "id" => "required|uuid",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $directories = new Directories();
        $directoryResult = $directories->getWhere(["instance_uuid" => $params["id"]]);

        if ($directoryResult->getResult()->Count !== 1) {
            return $this->renderReturnJson(false, [], "No directory Found.");
        }

        $directoryPackages = new DirectoryPackages();
        $directoryPackageResult = $directoryPackages->getAllByDirectoryId($directoryResult->getData()->first()->directory_id);

        return $this->renderReturnJson(true, ["list" => $directoryPackageResult->getData()->toPublicArray()], "We made it.");
    }

    public function createNewPackage(ExcellHttpModel $objData) : bool
    {
        if (!$this->validateRequestType('POST')) {
            return false;
        }

        $params = $objData->Data->Params;
        $postData = $objData->Data->PostData;

        if (!$this->validate($params, [
            "id" => "required|uuid",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        if (!$this->validate($postData, [
            "title" => "required",
            "description" => "required",
            "cycleType" => "required|integer",
            "price" => "required",
            "status" => "required",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        if ($postData->promoPrice > 0 && $postData->promoCycle == "0") {
            return $this->renderReturnJson(false, ["promoCycle" => ["Promo cycle must be higher than 0"]], "Validation errors.");
        }

        if ($postData->cycleType !== 8 && $postData->price > 0 && empty($postData->cycleLength) && $postData->cycleLength !== 0) {
            return $this->renderReturnJson(false, ["cycleLength" => ["Price cycle length must present. Zero for infinite."]], "Validation errors.");
        }

        $directories = new Directories();
        $directoryResult = $directories->getWhere(["instance_uuid" => $params["id"]]);

        if ($directoryResult->getResult()->Count !== 1) {
            return $this->renderReturnJson(false, [], "No directory Found.");
        }

        $directoryPackages = new DirectoryPackages();
        $directoryPackageResult = $directoryPackages->getAllByDirectoryId($directoryResult->getData()->first()->directory_id);

        foreach($directoryPackageResult->getData() as $currPacakge) {
            if ($postData->title === $currPacakge->name) {
                return $this->renderReturnJson(false, ["package_exists" => "a directory package with this title already exists"], "Validation errors.");
            }
        }

        $packageModel = new PackageModel([
            "type" => PackageModel::TYPE_DEFAULT,
            "source" => "directory",
            "company_id" => $this->app->getCustomPlatform()->getCompanyId(),
            "division_d" => "0",
            "name" => $postData->title,
            "description" => $postData->description,
            "enduser_id" => 1,
            "currency" => "usd",
            "max_quantity" => 100,
            "order" => 1,
            "hide_line_items" => 1,
            "image_url" => "",
        ]);

        $packages = new Packages();
        $packageCreationResult = $packages->createNew($packageModel);

        $packageVariationModel = new PackageVariationModel([
            "name" => $postData->title,
            "description" => $postData->description,
            "promo_price" => $postData->promoPrice,
            "regular_price" => $postData->price,
            "order" => 1,
        ]);

        $packageVariations = new PackageVariations();
        $packageVariationCreationResult = $packageVariations->createNew($packageVariationModel);

        if ($packageCreationResult->getResult()->Success !== true) {
            return $this->renderReturnJson(false, ["package_creation_fail" => $packageCreationResult->getResult()->Message], "Unable to save package.");
        }

        $newPackage = $packageCreationResult->getData()->first();
        $newPackageVariation = $packageVariationCreationResult->getData()->first();

        $packageLineModel = new PackageLineModel([
            "package_id" => $newPackage->package_id,
            "package_variation_id" => $newPackageVariation->package_variation_id,
            "company_id" => $this->app->getCustomPlatform()->getCompanyId(),
            "division_d" => "0",
            "product_entity" => "product",
            "product_entity_id" => "1500",
            // "journey_id" => "1500",
            "name" => $postData->title,
            "description" => $postData->description,
            "quantity" => $postData->quantity,
            "cycle_type" => $postData->cycleType,
            "promo_price" => $postData->promoPrice,
            "promo_price_duration" => $postData->promoLength,
            "regular_price" => $postData->price,
            "regular_price_duration" => $postData->cycleLength,
            "currency" => "usd",
            "order" => "1",
        ]);

        $packageLines = new PackageLines();
        $packageLineResult = $packageLines->createNew($packageLineModel);

        if ($packageLineResult->getResult()->Success !== true) {
            return $this->renderReturnJson(false, ["package_creation_fail" => $packageLineResult->getResult()->Message], "Unable to save package.");
        }

        $directoryPackageModel = new DirectoryPackageModel([
            "directory_id" => $directoryResult->getData()->first()->directory_id,
            "package_id" => $newPackage->package_id,
            "status" => $postData->status ?? "inactive"
        ]);

        $directoryPackages = new DirectoryPackages();

        $directoryPackageResult = $directoryPackages->createNew($directoryPackageModel);
        $fullDirectoryPackageResult = $directoryPackages->getFullById($directoryPackageResult->getData()->first()->directory_package_id);

        return $this->renderReturnJson(true, ["package" => $fullDirectoryPackageResult->getData()->first()->toPublicArray()], "We made it.");
    }

    public function updateFreePackage(ExcellHttpModel $objData) : bool
    {
        if (!$this->validateRequestType('POST')) {
            return false;
        }

        $params = $objData->Data->Params;
        $postData = $objData->Data->PostData;

        if (!$this->validate($params, [
            "id" => "required|uuid",
        ])) {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        if (!$this->validate($postData, [
            "free_package_title" => "required",
            "free_package_description" => "required",
            "free_package_status" => "required",
        ])) {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $directories = new Directories();
        $directoryResult = $directories->getWhere(["instance_uuid" => $params["id"]]);

        if ($directoryResult->getResult()->Count !== 1) {
            return $this->renderReturnJson(false, [], "No directory Found.");
        }

        $directory = $directoryResult->getData()->first();

        $directorySettings = new DirectorySettings();
        $directorySettingResult = $directorySettings->getWhere(["directory_id" => $directory->directory_id]);

        foreach($postData as $label => $value) {
            $matchingSetting = $directorySettingResult->getData()->FindEntityByValue("label", $label);
            if ($matchingSetting === null) {
                $newSetting = new DirectorySettingModel([
                    "directory_id" => $directory->directory_id,
                    "label" => $label,
                    "value" => $value,
                ]);
                $directorySettings->createNew($newSetting);
            } else {
                $matchingSetting->value = $value;
                $directorySettings->update($matchingSetting);
            }
        }

        return $this->renderReturnJson(true, [], "We made it.");
    }

    public function updatePackage(ExcellHttpModel $objData) : bool
    {
        if (!$this->validateRequestType('POST')) {
            return false;
        }

        $params = $objData->Data->Params;
        $postData = $objData->Data->PostData;

        if (!$this->validate($params, [
            "id" => "required|uuid",
        ])) {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        if (!$this->validate($postData, [
            "directory_package_id" => "required|integer",
            "title" => "required",
            "description" => "required",
            "cycleType" => "required|integer",
            "price" => "required",
            "status" => "required",
        ])) {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        if ($postData->cycleType !==  8 && $postData->promoPrice > 0 && (empty($postData->promoLength) || $postData->promoLength == "0")) {
            return $this->renderReturnJson(false, ["promoLength" => ["Promo count must be higher than 0"]], "Validation errors.");
        }

        if ($postData->cycleType !==  8 && $postData->price > 0 && empty($postData->cycleLength) && $postData->cycleLength !== 0) {
            return $this->renderReturnJson(false, ["cycleLength" => ["Price cycle length must present. Zero for infinite."]], "Validation errors.");
        }

        $directories = new Directories();
        $directoryResult = $directories->getWhere(["instance_uuid" => $params["id"]]);

        if ($directoryResult->getResult()->Count !== 1) {
            return $this->renderReturnJson(false, [], "No directory Found.");
        }

        $directoryPackages = new DirectoryPackages();
        $directoryPackageResult = $directoryPackages->getById($postData->directory_package_id);

        if ($directoryPackageResult->getResult()->Count !== 1) {
            return $this->renderReturnJson(false, [], "No package directory found for update.");
        }

        $packageLines = new PackageLines();
        $packages = new Packages();

        $directoryPackage = $directoryPackageResult->getData()->first();
        $packageLineResult = $packageLines->getWhere(["package_id" => $directoryPackage->package_id]);
        $packageResult = $packages->getById($directoryPackage->package_id);

        if ($packageLineResult->getResult()->Count !== 1) {
            return $this->renderReturnJson(false, [], "No package line found for update.");
        }

        $packageLine = $packageLineResult->getData()->first();

        if ($packageResult->getResult()->Count !== 1) {
            return $this->renderReturnJson(false, [], "No package found for update.");
        }

        $package = $packageResult->getData()->first();

        $packageLine->name = $postData->title;
        $packageLine->description = $postData->description;
        $packageLine->quantity = $postData->quantity;
        $packageLine->cycle_type = $postData->cycleType;
        $packageLine->promo_price = $postData->promoPrice;
        $packageLine->promo_price_duration = $postData->promoLength;
        $packageLine->regular_price = $postData->price;
        $packageLine->regular_price_duration = $postData->cycleLength;

        $packageLines->update($packageLine);

        $package->name = $postData->title;
        $package->description = $postData->description;
        $package->quantity = $postData->quantity;
        $package->cycle_type = $postData->cycleType;
        $package->promo_price = $postData->promoPrice;
        $package->regular_price = $postData->price;

        $packages->update($package);

        $directoryPackage->status = $postData->status;
        $result = $directoryPackages->update($directoryPackage);

        $directoryPackageResult = $directoryPackages->getFullById($directoryPackage->directory_package_id);

        return $this->renderReturnJson(true, ["package" => $directoryPackageResult->getData()->first()->toPublicArray()], "We made it.");
    }

    public function deleteDirectoryPackages(ExcellHttpModel $objData) : bool
    {
        if (!$this->validateRequestType('POST')) {
            return false;
        }

        $params = $objData->Data->Params;

        if (!$this->validate($params, [
            "id" => "required|uuid",
        ])) {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $directoryPackages = new DirectoryPackages();
        $directoryPackageResult = $directoryPackages->getBySysRowId($params["id"]);

        if ($directoryPackageResult->getResult()->Count !== 1) {
            return $this->renderReturnJson(false, [], "No directory package found for deletion.");
        }

        $directoryPackageResult = $directoryPackages->deleteById($directoryPackageResult->getData()->first()->directory_package_id);

        return $this->renderReturnJson($directoryPackageResult->getResult()->Success, [], "We made it.");
    }
}