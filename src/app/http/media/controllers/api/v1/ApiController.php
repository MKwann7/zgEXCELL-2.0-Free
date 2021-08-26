<?php

namespace Entities\Media\Controllers\Api\V1;

use App\Utilities\Database;
use App\Utilities\Excell\ExcellHttpModel;
use Entities\Media\Classes\Base\MediaController;
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

            if ($objUserResult->Result->Count === 0) {
                $this->RenderReturnJson(false, $objUserResult->Result->Errors, $objUserResult->Result->Query, "errors");
            }

            $objNewImageData->user_id = $objUserResult->Data->First()->user_id;
        }

        $objNewImageData->created_by = $objNewImageData->user_id ?? 70726;
        $objNewImageData->updated_by = $objNewImageData->user_id ?? 70726;

        $objNewImage = new ImageModel($objNewImageData);

        $objNewImageResult = (new Images())->CreateNew($objNewImage);

        if ($objNewImageResult->Result->Success === false)
        {
            logText("InsertImage.Process.log","objNewImage creation Error: " . $objNewImageResult->Result->Message);
            logText("InsertImage.Process.log","objNewImage creation QUERY: " . $objNewImageResult->Result->Query);
        }

        $this->RenderReturnJson($objNewImageResult->Result->Success, null, $objNewImageResult->Result->Message);
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
            FROM ezdigital_v2_media.image img 
            LEFT JOIN ezdigital_v2_main.user usr ON usr.user_id = img.user_id  
            WHERE usr.sys_row_id = '" . $intUserId . "'";

        $lstUserImagesResult = Database::getSimple($whereClause,"image_id");
        $lstUserImagesResult->Data->HydrateModelData(ImageModel::class, true);

        if ( $lstUserImagesResult->Result->Success === false || $lstUserImagesResult->Result->Count === 0)
        {
            return $this->renderReturnJson(false, [], $lstUserImagesResult->Result->Message);
        }

        $arUserImages = $lstUserImagesResult->Data->ConvertToArray();

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

        if( $objImageResult->Result->Success === false)
        {
            $this->renderReturnJson(false);
        }

        $objImage = $objImageResult->Data->First();

        $objImageDeletionResult = (new Images())->deleteById($intImageId);

        logText("DeleteImage.Process.log",json_encode($objImageDeletionResult));

        $this->renderReturnJson($objImageDeletionResult->Result->Success,$objImage->url, $objImageDeletionResult->Result->Message,"url");
    }
}
