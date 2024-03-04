<?php

namespace Http\Media\Controllers\Api\V1;

use App\Utilities\Database;
use App\Utilities\Excell\ExcellHttpModel;
use Exception;
use Http\Media\Controllers\Base\MediaController;
use Entities\Media\Classes\Images;
use Entities\Media\Models\ImageModel;
use Entities\Users\Classes\Users;
use Slim;
use SlimStatus;

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

    public function insertImage(ExcellHttpModel $objData): bool
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

        $objNewImageData->created_by = $objNewImageData->user_id ?? 1001;
        $objNewImageData->updated_by = $objNewImageData->user_id ?? 1001;

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

    public function deleteImage(ExcellHttpModel $objData): bFool
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

    public function uploadBase64Image(ExcellHttpModel $objData): bool
    {
        $params = $objData->Data->Params;
        if (!$this->validate($params, [
            "uuid" => "required|uuid",
            "entity_name" => "required",
            "entity_id" => "required|integer",
            "user_id" => "required|integer",
            "class" => "required",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }
        $post = $objData->Data->PostData;
        if (!$this->validate($post, [
            "image" => "required",
            "filename" => "required",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $images = new Images();
        $existingImage = $images->getWhere([["url", "LIKE", "%" . $post->filename]])->getData()->first();

        $objImageResult = $images->uploadBase64ImageToMediaServer(
            $post->image,
            $params["uuid"],
            (int)$params["user_id"],
            (int)$params["entity_id"],
            $params["entity_name"],
            $params["class"],
            $existingImage
        );

        $response['file'] = $objImageResult->getData()->first()['name'];
        $response['path'] = $objImageResult->getData()->first()['path'];
        $response['id'] = $objImageResult->getData()->first()['id'];
        $response['type'] = $objImageResult->getData()->first()['type'];

        return $this->renderReturnJson(true, $response, "Success");
    }

    public function uploadImage(ExcellHttpModel $objData): bool
    {
        $params = $objData->Data->Params;
        if (!$this->validate($params, [
            "uuid" => "required|uuid",
            "entity_name" => "required",
            "entity_id" => "required",
            "user_id" => "required",
            "class" => "required",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $userId = $params["uuid"];

        require APP_VENDORS . "slim/main/v4.5.1/process/slim" . XT;

        $slim = new Slim($this->app, $userId);

        // Get posted data, if something is wrong, exit
        try {
            $images = $slim
                ->setFiles($_FILES)
                ->setPost($_POST)
                ->getImages();
        }
        catch (Exception $e) {
            return $this->renderReturnJson(false, [], $e->getMessage());
        }

        if ($images === false) {
            return $this->renderReturnJson(false, [], "No image data");
        }

        // Should always be one image (when posting async), so we'll use the first on in the array (if available)
        $image = array_shift($images);

        // Something was posted but no images were found
        if (!isset($image)) {
            return $this->renderReturnJson(false, [], "No images found");
        }

        // If image found but no output or input data present
        if (!isset($image['output']['data']) && !isset($image['input']['data'])) {
            return $this->renderReturnJson(false, [], "No image data");
        }

        // if we've received output data save as file
        if (isset($image['output']['data'])) {

            // get the name of the file
            $name = 'mainImage.jpg';

            // get the crop data for the output image
            $data = $image['output']['data'];

            // If you want to store the file in another directory pass the directory name as the third parameter.
            // $file = Slim::saveFile($data, $name, 'my-directory/');

            // If you want to prevent Slim from adding a unique id to the file name add false as the fourth parameter.
            // $file = Slim::saveFile($data, $name, 'tmp/', false);

            $intEntityName = $params["entity_name"];
            $intEntityId = $params["entity_id"];
            $intUserId = $params["user_id"];
            $strClass = $params["class"];

            $input = $slim->saveFile($data, $name, $intEntityName, $intEntityId, $intUserId, $strClass, false);
        }

        // if we've received input data (do the same as above but for input data)
        if (isset($image['input']['data'])) {

            // get the name of the file
            $name = 'mainImage.jpg';

            // get the crop data for the output image
            $data = $image['input']['data'];

            logText("Slim.SaveFile.Process.log","Upload Image Input" . json_encode($image));
            logText("Slim.SaveFile.Process.log","Upload Image name" . json_encode($name));
            logText("Slim.SaveFile.Process.log","Upload Image data" . json_encode($data));

            // If you want to store the file in another directory pass the directory name as the third parameter.
            // $file = Slim::saveFile($data, $name, 'my-directory/');

            // If you want to prevent Slim from adding a unique id to the file name add false as the fourth parameter.
            // $file = Slim::saveFile($data, $name, 'tmp/', false);

            $intEntityName = $params["entity_name"];
            $intEntityId = $params["entity_id"];
            $intUserId = $params["user_id"];
            $strClass = $params["class"];

            $input = $slim->saveFile($data, $name, $intEntityName, $intEntityId, $intUserId, $strClass, false);
        }

        $response = [];

        logText("Slim.Process.log", "output: " . json_encode($output ?? []));
        logText("Slim.Process.log", "input: " . json_encode($input ?? []));

        if (isset($output) && isset($input)) {

            $response['output'] = array(
                'file' => $output['name'],
                'path' => $output['path']
            );

            $response['input'] = array(
                'file' => $input['name'],
                'path' => $input['path']
            );

        }
        else {
            $response['file'] = isset($output) ? $output['name'] : $input['name'];
            $response['path'] = isset($output) ? $output['path'] : $input['path'];
            $response['id'] = isset($output) ? $output['id'] : $input['id'];
            $response['type'] = isset($output) ? $output['type'] : $input['type'];
        }

        return $this->renderReturnJson(true, $response, "Success");
    }

    public function batchImageUpload(ExcellHttpModel $objData): bool
    {
        $params = $objData->Data->Params;
        if (!$this->validate($params, [
            "uuid" => "required|uuid",
            "entity_name" => "required",
            "entity_id" => "required",
            "user_id" => "required",
            "class" => "required",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $post = $objData->Data->PostData;
        if (!$this->validate($post, [
            "files" => "required",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $userId = $params["uuid"];

        require APP_VENDORS . "slim/main/v4.5.1/process/slim" . XT;

        $slim = new Slim($this->app, $userId);
        $response = [];

        // Upload to Media Storage
        foreach($_FILES as $currFile) {
            $tempData = file_get_contents($currFile["tmp_name"]);

            $imageResult = $slim->saveFile(
                $tempData,
                $currFile["name"],
                $params["entity_name"],
                $params["entity_id"],
                $params["user_id"],
                $params["class"],
                false
            );

            $response[] = [
                'file'  => $imageResult['file'],
                'path'  => $imageResult['path'],
                'id'    => $imageResult['id'],
                'type'  => $imageResult['type'],
            ];
        }

        // Return new paths.
        return $this->renderReturnJson(true, $response, "Success");
    }
}
