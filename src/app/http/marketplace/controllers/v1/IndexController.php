<?php

namespace Http\Marketplace\Controllers\V1;

use App\Utilities\Database;
use App\Utilities\Excell\ExcellHttpModel;
use App\Utilities\Http\Http;
use App\Utilities\Transaction\ExcellTransaction;
use Entities\Cards\Classes\Cards;
use Entities\Emails\Classes\Emails;
use Entities\Media\Classes\Images;
use Modules\Ezcard\Widgets\Marketplace\Classes\Base\MarketPlaceController;
use Modules\Ezcard\Widgets\Marketplace\Classes\MarketPlaceColumns;
use Modules\Ezcard\Widgets\Marketplace\Classes\MarketPlacePackages;
use Modules\Ezcard\Widgets\Marketplace\Classes\MarketPlacePackageValues;
use Modules\Ezcard\Widgets\Marketplace\Classes\MarketPlaces;
use Modules\Ezcard\Widgets\Marketplace\Models\MarketPlaceColumnModel;
use Modules\Ezcard\Widgets\Marketplace\Models\MarketplaceModel;
use Modules\Ezcard\Widgets\Marketplace\Models\MarketplacePackageModel;
use Modules\Ezcard\Widgets\Marketplace\Models\MarketplacePackageValueModel;

class IndexController extends MarketPlaceController
{
    public const MARKETPLACE_UUID = "a47166f6-a493-44d4-9d13-f0caf0b734f6";

    public function publicFullPage(ExcellHttpModel $objData) : bool
    {
        if (!$this->validateRequestType('GET'))
        {
            return false;
        }

        $objParams = $objData->Data->Params;

        if (!$this->validate($objParams, [
            "widget_id" => "required|uuid",
            "instance_id" => "required|uuid",
            "card_id" => "required|integer",
            "user_id" => "required|uuid",
            "platform_id" => "required|uuid",
            "platform_url" => "required",
            "platform_name" => "required",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $objCards = new Cards();
        $objCardResult = $objCards->getById($objParams["card_id"]);

        if ($objCardResult->Result->Count === 0)
        {
            return $this->renderReturnJson(false, [], "Card ".$objParams["card_id"]." not found!");
        }

        $card = $objCardResult->Data->First();

        $objMemberDirectories = new MarketPlaces();
        $objDirectoryResult = $objMemberDirectories->getFullRecordByUuid($objParams["instance_id"]);

        $recordQuery = "SELECT emdr.* FROM ezdigital_v2_apps.marketplace_package emdr LEFT JOIN ezdigital_v2_apps.marketplace emd ON emd.marketplace_id = emdr.marketplace_id WHERE emd.instance_uuid = '" . $objParams["instance_id"] . "' AND emdr.status = 'active';";
        $objDirectoryRecordResult = Database::getSimple($recordQuery);

        $objDirectoryRecordResult->Data->HydrateModelData(MarketplacePackageModel::class);

        $recordValueQuery = "SELECT emdrv.marketplace_package_value_id, emdrv.marketplace_package_id, emdrv.marketplace_column_id, emdrc.name, emdrc.label, emdrv.type, emdrv.value FROM ezdigital_v2_apps.marketplace_package_value emdrv LEFT JOIN ezdigital_v2_apps.marketplace_column emdrc ON emdrc.marketplace_column_id = emdrv.marketplace_column_id WHERE emdrv.marketplace_package_id IN (" . implode(",", $objDirectoryRecordResult->Data->FieldsToArray(["marketplace_package_id"])) . ");";
        $objDirectoryValueResult = Database::getSimple($recordValueQuery);

        if ($objDirectoryValueResult->Result->Count > 0)
        {
            $objDirectoryRecordResult->Data->HydrateChildModelData("custom", ["marketplace_package_id" => "marketplace_package_id"], $objDirectoryValueResult->Data);
        }

        $content = $objMemberDirectories->getView("v1.theme.v1", $this->app->strAssignedPortalTheme, [
            "cardId" => $card->card_vanity_url ?? $card->card_num,
            "objDirectory" => $objDirectoryResult->Data->First(),
            "objDirectoryRecordResult" => $objDirectoryRecordResult,
            "platformId" => $objParams["platform_id"],
            "customPlatformUrl" => $objParams["platform_url"],
            "customPlatformName" => $objParams["platform_name"],
        ]);

        return $this->renderReturnJson(true, ["type" => "html","content" => $content], "We made it.");
    }

    public function configMain(ExcellHttpModel $objData) : bool
    {
        // Return Vue Object for Module Configuration.
        if (!$this->validateRequestType('GET'))
        {
            return false;
        }

        $objParams = $objData->Data->Params;

        if (!$this->validate($objParams, [
            "widget_id" => "required|uuid",
            "user_id" => "required|uuid",
            "platform_id" => "required|uuid",
            "platform_url" => "required",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $mainComponentId = getGuid();
        $mainComponentName = "comp" . preg_replace("/[^A-Za-z0-9]/", '', $mainComponentId);

        $marketplaces = new MarketPlaces();

        $mainComponent = $marketplaces->getView("v1.config.main", $this->app->strAssignedPortalTheme, [
            "mainComponentId" => $mainComponentId,
            "mainComponentName" => $mainComponentName,
            "platformId" => $objParams["platform_id"],
            "customPlatformUrl" => $objParams["platform_url"],
        ]);

        $editPackageComponent = $marketplaces->getView("v1.config.edit_package", $this->app->strAssignedPortalTheme, [
            "mainComponentId" => $mainComponentId,
            "mainComponentName" => $mainComponentName,
            "platformId" => $objParams["platform_id"],
            "customPlatformUrl" => $objParams["platform_url"],
        ]);

        $manageMarketplaceComponent = $marketplaces->getView("v1.config.manage_marketplace", $this->app->strAssignedPortalTheme, [
            "mainComponentId" => $mainComponentId,
            "mainComponentName" => $mainComponentName,
            "platformId" => $objParams["platform_id"],
            "customPlatformUrl" => $objParams["platform_url"],
        ]);

        $packageDataSelectorComponent = $marketplaces->getView("v1.config.package_data_selector", $this->app->strAssignedPortalTheme, [
            "mainComponentId" => $mainComponentId,
            "mainComponentName" => $mainComponentName,
            "platformId" => $objParams["platform_id"],
            "customPlatformUrl" => $objParams["platform_url"],
        ]);

        $result = 'return {
            main: ' . $mainComponent . ',
            helpers: [
                ' . $editPackageComponent . ',
                ' . $manageMarketplaceComponent . ',
                ' . $packageDataSelectorComponent . '
            ]
        }';

        return $this->renderReturnJson(true, base64_encode($result), "Widget processed.", 200, "widget");
    }

    public function createInstanceForPage(ExcellHttpModel $objData) : bool
    {
        $objParams = $objData->Data->PostData;

        if (!$this->validate($objParams, [
            "instance_uuid" => "required|uuid",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $marketplaceModel = new MarketplaceModel();

        $marketplaceModel->instance_uuid = $objParams->instance_uuid;
        $marketplaceModel->template_id = 1;

        $result = (new MarketPlaces())->createNew($marketplaceModel);

        if ($result->Result->Success === false)
        {
            return $this->renderReturnJson(false, ["error" => $result->Result->Query], $result->Result->Message);
        }

        return $this->renderReturnJson(true, [], "Widget processed.");
    }

    public function getMarketplaceId(ExcellHttpModel $objData) : bool
    {
        $objParams = $objData->Data->Params;

        if (!$this->validate($objParams, [
            "id" => "required|uuid",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $marketplaces = new MarketPlaces();
        $marketplaceResult = $marketplaces->getWhere(["instance_uuid" => $objParams["id"]]);

        return $this->renderReturnJson($marketplaceResult->Result->Success, ["id" => ($marketplaceResult->Data->First()->marketplace_id ?? null), "message" => $marketplaceResult->Result->Message], "Where's what we found.");
    }

    public function saveMarketplacePackageImageUrl(ExcellHttpModel $objData) : bool
    {
        $objParams = $objData->Data->Params;

        if (!$this->validate($objParams, [
            "package" => "required|integer",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $packageUrl = $objData->Data->PostData->package_url;

        if (empty($packageUrl))
        {
            return $this->renderReturnJson(false, ["package_url" => "Field is required."], "Validation errors.");
        }

        $marketplacePackages = new MarketPlacePackages();
        $marketplacePackageResult = $marketplacePackages->getById($objParams["package"]);

        $marketplacePackage = $marketplacePackageResult->Data->First();
        $marketplacePackage->profile_image_url = $packageUrl;

        $marketplacePackageResult = $marketplacePackages->update($marketplacePackage);

        return $this->renderReturnJson($marketplacePackageResult->Result->Success, ["package_url" => $marketplacePackage->profile_image_url], "Here's what I got.");
    }

    public function getMarketplaceColumns(ExcellHttpModel $objData) : bool
    {
        $objParams = $objData->Data->Params;

        if (!$this->validate($objParams, [
            "id" => "required|integer",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $marketplaceColumnResult = (new MarketPlaceColumns())->getColumnsByMarketplaceId($objParams["id"]);

        if (!empty($objParams["package"]) && $objParams["package"] !== "null")
        {
            $marketplacePackageValues = new MarketPlacePackageValues();
            $marketplacePackageValuesResult = $marketplacePackageValues->getWhere(["marketplace_package_id" => $objParams["package"]]);

            $marketplaceColumnResult->Data->MergeFields($marketplacePackageValuesResult->Data,["type" => "typeInstance","value","marketplace_package_value_id"],["marketplace_column_id" => "marketplace_column_id"]);
            $marketplaceColumnResult->Data->AddFieldToAllEntities("marketplace_id", $objParams["id"]);
            $marketplaceColumnResult->Data->AddFieldToAllEntities("marketplace_package_id", $objParams["package"]);
        }

        return $this->renderReturnJson(true, $marketplaceColumnResult->Data->ToPublicArray(), "Here's what I got.");
    }

    public function upsertMarketplacePackageRecord(ExcellHttpModel $objData) : bool
    {
        $objParams = $objData->Data->Params;
        $objPost = $objData->Data->PostData;

        if (!$this->validate($objParams, [
            "marketplaceId" => "required|integer",
            "package" => "required",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        switch($objParams["package"])
        {
            case "new":
                return $this->createPackage($objParams["marketplaceId"], $objPost);
            default:
                return $this->updatePackage($objParams["marketplaceId"], $objParams["package"], $objPost);
        }
    }

    public function createPackage($marketplaceId, $data) : bool
    {
        $marketplacePackage = new MarketplacePackageModel();
        $marketplacePackage->marketplace_id = $marketplaceId;
        
        $marketplacePackage->name = $data->package->name;
        $marketplacePackage->order = $data->package->order;
        $marketplacePackage->description = $data->package->description;
        $marketplacePackage->regular_price = $data->package->regular_price ?? ExcellNull;
        $marketplacePackage->promo_price = $data->package->promo_price ?? ExcellNull;
        $marketplacePackage->status = "disabled";

        if ($data->package->package_image_url === "__remove__")
        {
            $marketplacePackage->package_image_url = ExcellEmptyString;
        }

        $marketplacePackages = new MarketPlacePackages();
        $marketplacePackageCreationResult = $marketplacePackages->createNew($marketplacePackage);

        if ($marketplacePackageCreationResult->Result->Success === false)
        {
            return $this->renderReturnJson(false, ["error" => $marketplacePackageCreationResult->Result->Message], "Error saving new package.");
        }

        $data->package->marketplace_package_id = $marketplacePackageCreationResult->Data->First()->marketplace_package_id;
        $this->upsertCustomPackageFields($data, $marketplacePackageCreationResult->Data->First()->marketplace_package_id, $marketplaceId);

        return $this->renderReturnJson($marketplacePackageCreationResult->Result->Success, $data, "Marketplace package successfully created.");
    }

    public function updatePackage($marketplaceId, $packageId, $data) : bool
    {
        $marketplacePackages = new MarketPlacePackages();
        $marketplacePackageResult = $marketplacePackages->getById($packageId);

        if ($marketplacePackageResult->Result->Count === 0)
        {
            return $this->renderReturnJson(false, [], "No directory member record found for id $packageId for updating.");
        }

        $marketplacePackage = $marketplacePackageResult->Data->First();

        $marketplacePackage->name = $data->package->name;
        $marketplacePackage->order = $data->package->order;
        $marketplacePackage->description = $data->package->description;
        $marketplacePackage->AddUnvalidatedValue("regular_price", (!empty($data->package->regular_price) && $data->package->regular_price > 0) ? $data->package->regular_price : ExcellNull);
        $marketplacePackage->AddUnvalidatedValue("promo_price", (!empty($data->package->promo_price) && $data->package->promo_price > 0) ? $data->package->promo_price : ExcellNull);

        if ($data->package->package_image_url === "__remove__")
        {
            $marketplacePackage->package_image_url = ExcellEmptyString;
        }

        $objMemberDirectoryRecordUpdateResult = $marketplacePackages->update($marketplacePackage);

        $this->upsertCustomPackageFields($data, $packageId, $marketplaceId);

        return $this->renderReturnJson($objMemberDirectoryRecordUpdateResult->Result->Success, $data, "Member directory record successfully updated.");
    }

    protected function upsertCustomPackageFields($data, $packageId, $marketplaceId) : void
    {
        if (empty($data->customFields))
        {
            return;
        }

        $marketplacePackageValues = new MarketPlacePackageValues();

        foreach($data->customFields as $currField)
        {
            if (!empty($currField->file))
            {
                $objImage = new Images();
                $objImageResult = $objImage->uploadBase64ImageToMediaServer(
                    $currField->file,
                    $currField->marketplace_package_id,
                    "ezcarddirectorymemberrecords",
                    $currField->label . "_" . $currField->marketplace_column_id);

                if ($objImageResult->Result->Success === false)
                {
                    // TODO - Return Error
                    continue;
                }

                $currField->value = $objImageResult->Data;
            }

            $valueResult = $marketplacePackageValues->getWhere(["marketplace_column_id" => $currField->marketplace_column_id, "marketplace_package_id" => $packageId, "marketplace_id" => $marketplaceId]);

            if ($valueResult->Result->Count === 0)
            {
                if (empty($currField->value))
                {
                    continue;
                }

                $packageValue = new MarketplacePackageValueModel();
                $packageValue->marketplace_column_id = $currField->marketplace_column_id;
                $packageValue->marketplace_package_id = $packageId;
                $packageValue->marketplace_id = $marketplaceId;
                $packageValue->type = $this->setPackageValueType($currField);
                $packageValue->value = $currField->value;
                $marketplacePackageValues->createNew($packageValue);

                continue;
            }

            $packageValue = $valueResult->Data->First();

            $packageValue->marketplace_column_id = $currField->marketplace_column_id;
            $packageValue->marketplace_package_id = $packageId;
            $packageValue->marketplace_id = $marketplaceId;
            $packageValue->type = $this->setPackageValueType($currField);
            $packageValue->value = (empty($currField->value) ? ExcellEmptyString : $currField->value);

            $marketplacePackageValues->update($packageValue);
        }
    }

    protected function setPackageValueType($packageColumn) : string
    {
        if ($packageColumn->type === "connection")
        {
            return $packageColumn->typeInstance ?? "default";
        }

        return $packageColumn->type;
    }

    public function getMarketplacePackages(ExcellHttpModel $objData) : bool
    {
        $objParamsForSync = $objData->Data->Params;

        if (!$this->validate($objParamsForSync, [
            "id" => "required|uuid"
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $recordQuery = "SELECT emdr.* FROM ezdigital_v2_apps.marketplace_package emdr LEFT JOIN ezdigital_v2_apps.marketplace emd ON emd.marketplace_id = emdr.marketplace_id WHERE emd.instance_uuid = '" . $objParamsForSync["id"] . "';";
        $marketplaceResult = Database::getSimple($recordQuery);

        if ($marketplaceResult->Result->Count === 0)
        {
            return $this->renderReturnJson(true, [], "No Rows Returned.");
        }

        $marketplaceResult->Data->HydrateModelData(MarketplacePackageModel::class);

        return $this->renderReturnJson(true, $marketplaceResult->Data->ToPublicArray(), "Here's what I got.");
    }

    public function createMarketplacePackage(ExcellHttpModel $objData) : bool
    {
        $objParamsForSync = $objData->Data->Params;

        if (!$this->validate($objParamsForSync, [
            "id" => "required|uuid"
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $recordQuery = "SELECT emdr.* FROM ezdigital_v2_apps.marketplace_package emdr LEFT JOIN ezdigital_v2_apps.marketplace emd ON emd.marketplace_id = emdr.marketplace_id WHERE emd.instance_uuid = '" . $objParamsForSync["id"] . "';";

        $marketplaceResult = Database::getSimple($recordQuery);

        if ($marketplaceResult->Result->Count === 0)
        {
            return $this->renderReturnJson(false, ["query" => $recordQuery], "No Rows Returned.");
        }

        $marketplaceResult->Data->HydrateModelData(MarketplacePackageModel::class);

        return $this->renderReturnJson(true, $marketplaceResult->Data->ToPublicArray(), "Here's what I got.");
    }

    public function readMarketplacePackage(ExcellHttpModel $objData) : bool
    {
        $objParamsForSync = $objData->Data->Params;

        if (!$this->validate($objParamsForSync, [
            "id" => "required|uuid"
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $recordQuery = "SELECT emdr.* FROM ezdigital_v2_apps.marketplace_package emdr LEFT JOIN ezdigital_v2_apps.marketplace emd ON emd.marketplace_id = emdr.marketplace_id WHERE emd.instance_uuid = '" . $objParamsForSync["id"] . "';";

        $marketplaceResult = Database::getSimple($recordQuery);

        if ($marketplaceResult->Result->Count === 0)
        {
            return $this->renderReturnJson(false, ["query" => $recordQuery], "No Rows Returned.");
        }

        $marketplaceResult->Data->HydrateModelData(EzcardMemberDirectoryRecordModel::class);

        return $this->renderReturnJson(true, $marketplaceResult->Data->ToPublicArray(), "Here's what I got.");
    }

    public function updateMarketplacePackage(ExcellHttpModel $objData) : bool
    {
        $objParamsForSync = $objData->Data->Params;

        if (!$this->validate($objParamsForSync, [
            "id" => "required|uuid"
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $recordQuery = "SELECT emdr.* FROM ezdigital_v2_apps.marketplace_package emdr LEFT JOIN ezdigital_v2_apps.marketplace emd ON emd.marketplace_id = emdr.marketplace_id WHERE emd.instance_uuid = '" . $objParamsForSync["id"] . "';";

        $marketplaceResult = Database::getSimple($recordQuery);

        if ($marketplaceResult->Result->Count === 0)
        {
            return $this->renderReturnJson(false, ["query" => $recordQuery], "No Rows Returned.");
        }

        $marketplaceResult->Data->HydrateModelData(MarketplacePackageModel::class);

        return $this->renderReturnJson(true, $marketplaceResult->Data->ToPublicArray(), "Here's what I got.");
    }

    public function deleteMarketplacePackage(ExcellHttpModel $objData) : bool
    {
        $objParams = $objData->Data->Params;

        if (!$this->validate($objParams, [
            "package" => "required|integer"
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $marketplacePackages = new MarketPlacePackages();
        $result = $marketplacePackages->deleteById($objParams["package"]);

        $marketplacePackageValues = new MarketPlacePackageValues();
        $resultValues = $marketplacePackageValues->deleteWhere(["marketplace_package_id" => $objParams["package"]]);

        return $this->renderReturnJson(true, ["package" => $result->Result->Message,"packageValues" => $resultValues->Result->Message,], "Here's what we got.");
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

            $objApiResult = json_decode($objHttpResponse->body);

            return new ExcellTransaction(true, "Success", $objApiResult, 1, [], getFullUrl() . $url);

        } catch(\Exception $ex)
        {
            return new ExcellTransaction(false,"Exception Throw: " . $ex);
        }
    }

    public function updateMarketplacePageData(ExcellHttpModel $objData) : bool
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

        $objMemberDirectories = new MarketPlaces();
        $objMemberDirectoryResult = $objMemberDirectories->getWhere(["instance_uuid" => $objParams["id"]]);

        if ($objMemberDirectoryResult->Result->Count === 0)
        {
            return $this->renderReturnJson(false, [], "No directory Found.");
        }

        $objResult = $this->callToEzcardApi("post", "/api/v1/modules/update-card-page-data?company_id=0", [
                "app_uuid" => $objParams["id"],
                "title" => $objPost->title,
                "user_id" => $objPost->ownerId,
            ]
        );

        return $this->renderReturnJson($objResult->Result->Success, $objResult->Data->data, $objResult->Result->Message);
    }

    public function updatePackageVisibility(ExcellHttpModel $objData) : bool
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

        $marketplacePackages = new MarketPlacePackages();
        $marketplacePackageResult = $marketplacePackages->getById($objParams["id"]);

        if ($marketplacePackageResult->Result->Count === 0)
        {
            return $this->renderReturnJson(false, [], "No directory member record found for id ".$objParams["id"]." for updating.");
        }

        $marketplacePackage = $marketplacePackageResult->Data->First();

        $marketplacePackage->status = $objParams["status"];

        $objMemberDirectoryRecordUpdateResult = $marketplacePackages->update($marketplacePackage);

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

        $recordQuery = "SELECT emdc.* FROM ezdigital_v2_apps.marketplace_column emdc LEFT JOIN ezdigital_v2_apps.marketplace_template emdt ON emdt.marketplace_template_id = emdc.template_id LEFT JOIN ezdigital_v2_apps.marketplace emd ON emd.template_id = emdt.marketplace_template_id WHERE emd.instance_uuid = '" . $objParams["id"] . "' ORDER BY emdc.order;";
        $marketplaceColumnResult = Database::getSimple($recordQuery);

        if ($marketplaceColumnResult->Result->Count === 0)
        {
            return $this->renderReturnJson(false, ["query" => $recordQuery], "No Rows Returned.");
        }

        $marketplaceColumnResult->Data->HydrateModelData(MarketPlaceColumnModel::class);

        $columns = ["first_name", "last_name", "title", "mobile_phone", "email", "profile_image_url", "hex_color"];

        /** @var MarketPlaceColumnModel $currColumn */
        foreach($marketplaceColumnResult->Data as $currColumn)
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

        $recordQuery = "SELECT emdc.* FROM ezdigital_v2_apps.marketplace_column emdc LEFT JOIN ezdigital_v2_apps.marketplace_template emdt ON emdt.marketplace_template_id = emdc.template_id LEFT JOIN ezdigital_v2_apps.marketplace emd ON emd.template_id = emdt.marketplace_template_id WHERE emd.instance_uuid = '" . $objParams["id"] . "' ORDER BY emdc.order;";
        $objMemberDirectoryColumnResult = Database::getSimple($recordQuery);

        if ($objMemberDirectoryColumnResult->Result->Count === 0)
        {
            return $this->renderReturnJson(false, ["query" => $recordQuery], "No Rows Returned.");
        }

        $objMemberDirectoryColumnResult->Data->HydrateModelData(MarketPlaceColumnModel::class);

        $columns = ["first_name", "last_name", "title", "mobile_phone", "email", "profile_image_url", "hex_color"];

        /** @var MarketPlaceColumnModel $currColumn */
        foreach($objMemberDirectoryColumnResult->Data as $currColumn)
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

        $objDirectoryResult = (new MarketPlaces())->getWhere(["instance_uuid" => $objParams["id"]]);

        if ($objDirectoryResult->Result->Count !== 1)
        {
            return $this->renderReturnJson(false, [], "Directory not found. " . $objDirectoryResult->Result->Message);
        }

        $objDirectory = $objDirectoryResult->Data->First();

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

        $objMemberRecord = new MarketPlacePackages();
        $objMemberDirectoryColumnResult = (new EzcardMemberDirectoryColumns())->getColumnsByDirectoryId($objDirectory->marketplace_id);

        $errors = [];

        foreach($csvResult as $currNewMember)
        {
            if (!$this->validate($currNewMember, [
                "first_name" => "required",
                "last_name" => "required",
                //"mobile_phone" => "required",
                "email" => "required|email",
            ] ))
            {
                $errors[] = $currNewMember;
                continue;
            }

            $currNewMember["mobile_phone"] = preg_replace("/[^0-9\+]/", '', $currNewMember["mobile_phone"]);
            $currNewMember["hex_color"] = preg_replace("/[^A-Za-z0-9]/", '', $currNewMember["hex_color"]);

            $newMember = new EzcardMemberDirectoryRecordModel($currNewMember);
            $newMember->marketplace_id = $objDirectory->marketplace_id;
            $newMember->status = "disabled";
            $newMemberResult = $objMemberRecord->createNew($newMember);
            $newMemberRecord = $newMemberResult->Data->First();
            $newRecords[] = $newMemberResult->Data->First()->ToArray();

            $data = new \stdClass();
            $data->customFields = [];

            /** @var MarketPlaceColumnModel $currColumn */
            foreach($objMemberDirectoryColumnResult->Data as $currColumn)
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

            $this->upsertCustomPackageFields($data, $newMemberRecord->marketplace_package_id, $objDirectory->marketplace_id);
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

    public function getMarketplaceData(ExcellHttpModel $objData) : bool
    {
        $objParams = $objData->Data->Params;

        if (!$this->validate($objParams, [
            "id" => "required|uuid",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $objDirectoryResult = (new MarketPlaces())->getFullRecordByUuid($objParams["id"]);

        $objDirectory = $objDirectoryResult->Data->First();

        return $this->renderReturnJson(true, [
            "marketplaceName" => $objDirectory->defaults->FindEntityByValue("label", "directory_name")->value ?? "",
            "marketplaceSortBy" => $objDirectory->defaults->FindEntityByValue("label", "sort_by")->value ?? "first_name",
            "marketplaceSortOrder" => $objDirectory->defaults->FindEntityByValue("label", "sort_order")->value ?? "asc",
            "marketplaceTemplate" => $objDirectory->template->marketplace_template_id ?? "1",
            "marketplaceHeaderImage" => $objDirectory->defaults->FindEntityByValue("label", "header_image")->value ?? "",
            "marketplaceHeaderText" => $objDirectory->defaults->FindEntityByValue("label", "header_html")->value ?? "",
            "marketplaceFooterImage" => $objDirectory->defaults->FindEntityByValue("label", "footer_image")->value ?? "",
            "marketplaceHexColor" => $objDirectory->defaults->FindEntityByValue("label", "main_color")->value ?? "",
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

        $objDirectoryResult = (new MarketPlaces())->getWhere(["instance_uuid" => $objParams["id"]]);

        $objDirectory = $objDirectoryResult->Data->First();

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
        (new MarketPlaces())->update($objDirectory);

        return $this->renderReturnJson(true, $objData->Data->PostData, "We got this.");
    }

    protected function updateDirectoryDefault($fieldName, $value, $directory) : void
    {
        $objDirectoryDefaults = new EzcardMemberDirectoryDefaults();
        $objDirectoryResults = $objDirectoryDefaults->getWhere(["label" => $fieldName, "marketplace_id" => $directory->marketplace_id]);

        if ($objDirectoryResults->Result->Count === 1)
        {
            $objDirectory = $objDirectoryResults->Data->First();
            $objDirectory->value = $value;
            $objDirectoryDefaults->update($objDirectory);
            return;
        }

        $directoryModel = new EzcardMemberDirectoryDefaultModel();
        $directoryModel->directory_id = $directory->marketplace_id;
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

        $objMemberDirectory = new MarketPlacePackages();
        $objMemberDirectoryResult = $objMemberDirectory->getWhere(["sys_row_id" => $objParams["id"]]);

        if ($objMemberDirectoryResult->Result->Count !== 1)
        {
            return false;
        }

        /** @var EzcardMemberDirectoryRecordModel $marketplacePackage */
        $marketplacePackage = $objMemberDirectoryResult->Data->First();

        $objDirectory = new MarketPlaces();
        $objDirectoryResult = $objDirectory->getById($marketplacePackage->marketplace_id);

        if ($objDirectoryResult->Result->Count !== 1)
        {
            return false;
        }

        $objMemberDirectories = new MarketPlaces();
        $content = $objMemberDirectories->getView("v1.member.public_edit_profile", $this->app->strAssignedPortalTheme, [
            "directoryId" => $objDirectoryResult->Data->First()->instance_uuid,
            "memberData" => $marketplacePackage,
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
            "package" => "required|integer",
            "column" => "required|integer",
            "directory" => "required|integer",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $objRecordValueResult = (new MarketPlacePackageValues())->getById($objParams["id"]);

        if ($objRecordValueResult->Result->Count !== 1)
        {
            $newRecordValue = new EzcardMemberDirectoryRecordValueModel();

            $newRecordValue->marketplace_id = $objParams["directory"];
            $newRecordValue->marketplace_package_id = $objParams["package"];
            $newRecordValue->marketplace_column_id = $objParams["column"];
            $newRecordValue->type = "image";
            $newRecordValue->value = "";

            $objRecordValueResult = (new MarketPlacePackageValues())->createNew($newRecordValue);
        }

        $objRecordValue = $objRecordValueResult->Data->First();


        if (!move_uploaded_file($strTempFilePath, $tempFilePathAndName))
        {
            return $this->renderReturnJson(false, [], "Server Error: File could not be moved: " . $arFile["name"]);
        }
    }

    public function loadManageUserProfile() : bool
    {
        $mainComponentId = getGuid();
        $mainComponentName = "comp" . preg_replace("/[^A-Za-z0-9]/", '', $mainComponentId);

        $objMemberDirectories = new MarketPlaces();

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

        $marketplacePackages = new MarketPlacePackages();
        $result = $marketplacePackages->getById($objParams["id"]);

        if ($result->Result->Success === false)
        {
            return $this->renderReturnJson(false, [], $result->Result->Message);
        }

        $this->sendCustomFieldRequestEmail($result->Data->First(), "Here is your private directory member management link! You can fill out the applicable fields immediately, and then save the link for future reference to manage your membership information.");
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

        return $this->renderReturnJson($objResult->Result->Success, $objResult->Data->data, $objResult->Result->Message);
    }
}