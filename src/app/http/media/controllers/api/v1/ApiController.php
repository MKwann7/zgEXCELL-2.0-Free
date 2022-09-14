<?php

namespace Http\Media\Controllers\Api\V1;

use App\Utilities\Database;
use App\Utilities\Excell\ExcellHttpModel;
use Http\Media\Controllers\Base\MediaController;
use Entities\Media\Classes\Images;
use Entities\Media\Models\ImageModel;
use Entities\Users\Classes\Users;

/**
 * Created by PhpStorm.
 * User: micah
 * Date: 9/24/2018
 * Time: 8:17 PM
 */

class ApiController extends MediaController
{
    public function getImageBatches(ExcellHttpModel $objData) : bool
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

        $objWhereClause = (new Images())->buildImageBatchWhereClause($filterIdField, $filterEntity);

        $objWhereClause .= " LIMIT {$pageIndex}, {$batchCount}";

        $objImages = Database::getSimple($objWhereClause, "image_id");

        if ($objImages->getData()->Count() < $batchCount)
        {
            $strEnd = "true";
        }

        $objImages->getData()->HydrateModelData(ImageModel::class, true);

        $arUserDashboardInfo = array(
            "list" => $objImages->getData()->FieldsToArray($arFields),
            "query" => $objWhereClause,
        );

        return $this->renderReturnJson(true, $arUserDashboardInfo, "We found " . $objImages->getData()->Count() . " images in this batch.", 200, "data", $strEnd);
    }

    public function getLogoBatches(ExcellHttpModel $objData) : bool
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

        $objWhereClause = (new Images())->buildLogoBatchWhereClause($filterIdField, $filterEntity);

        $objWhereClause .= " LIMIT {$pageIndex}, {$batchCount}";

        $objImages = Database::getSimple($objWhereClause, "image_id");

        if ($objImages->getData()->Count() < $batchCount)
        {
            $strEnd = "true";
        }

        $objImages->getData()->HydrateModelData(ImageModel::class, true);

        $arUserDashboardInfo = array(
            "list" => $objImages->getData()->FieldsToArray($arFields),
            "query" => $objWhereClause,
        );

        return $this->renderReturnJson(true, $arUserDashboardInfo, "We found " . $objImages->getData()->Count() . " images in this batch.", 200, "data", $strEnd);
    }

    public function insertImage(ExcellHttpModel $objData): void
    {
        if(empty($objData->Data->PostData->image))
        {
            $this->renderReturnJson(false);
        }

        $objNewImageData = (object) $objData->Data->PostData->image;

        if (!empty($objNewImageData->user_id) && !isInteger($objNewImageData->user_id))
        {
            $objUsers = new Users();
            $objUserResult = $objUsers->GetWhere(["sys_row_id" => $objNewImageData->user_id]);

            if ($objUserResult->result->Count === 0) {
                $this->RenderReturnJson(false, $objUserResult->result->Errors, $objUserResult->result->Query, "errors");
            }

            $objNewImageData->user_id = $objUserResult->getData()->first()->user_id;
        }

        $objNewImageData->created_by = $objNewImageData->user_id ?? 70726;
        $objNewImageData->updated_by = $objNewImageData->user_id ?? 70726;

        $objNewImage = new ImageModel($objNewImageData);

        $objNewImageResult = (new Images())->CreateNew($objNewImage);

        if ($objNewImageResult->result->Success === false)
        {
            logText("InsertImage.Process.log","objNewImage creation Error: " . $objNewImageResult->result->Message);
            logText("InsertImage.Process.log","objNewImage creation QUERY: " . $objNewImageResult->result->Query);
        }

        $this->RenderReturnJson($objNewImageResult->result->Success, null, $objNewImageResult->result->Message);
    }

    public function getUserImages(ExcellHttpModel $objData): bool
    {
        $params = $objData->Data->Params;
        if (!$this->validate($params, [
            "user_id" => "required|uuid",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $intUserId = $params["user_id"];

        $whereClause = "SELECT img.*
            FROM excell_media.image img 
            LEFT JOIN excell_main.user usr ON usr.user_id = img.user_id  
            WHERE usr.sys_row_id = '" . $intUserId . "'";

        $lstUserImagesResult = Database::getSimple($whereClause,"image_id");
        $lstUserImagesResult->getData()->HydrateModelData(ImageModel::class, true);

        if ( $lstUserImagesResult->result->Success === false || $lstUserImagesResult->result->Count === 0)
        {
            return $this->renderReturnJson(false, [], $lstUserImagesResult->result->Message);
        }

        $arUserImages = $lstUserImagesResult->getData()->ConvertToArray();

        return $this->renderReturnJson(true, $arUserImages, "","images");
    }

    public function deleteImage(ExcellHttpModel $objData): void
    {
        if(empty($objData->Data->PostData->image_id))
        {
            $this->renderReturnJson(false);
        }
        $intImageId = $objData->Data->PostData->image_id;

        $objImageResult = (new Images())->getById($intImageId);

        if( $objImageResult->result->Success === false)
        {
            $this->renderReturnJson(false);
        }

        $objImage = $objImageResult->getData()->first();

        $objImageDeletionResult = (new Images())->deleteById($intImageId);

        logText("DeleteImage.Process.log",json_encode($objImageDeletionResult));

        $this->renderReturnJson($objImageDeletionResult->result->Success,$objImage->url, $objImageDeletionResult->result->Message,"url");
    }
}
