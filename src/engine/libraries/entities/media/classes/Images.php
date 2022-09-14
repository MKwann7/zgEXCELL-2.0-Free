<?php

namespace Entities\Media\Classes;

use App\Core\AppController;
use App\Core\AppEntity;
use App\Utilities\Excell\ExcellCollection;
use App\Utilities\Http\Http;
use App\Utilities\Transaction\ExcellTransaction;
use Entities\Media\Models\ImageModel;

class Images extends AppEntity
{
    public string $strEntityName       = "Media";
    public $strDatabaseTable    = "image";
    public $strDatabaseName     = "Media";
    public $strMainModelName    = ImageModel::class;
    public $strMainModelPrimary = "image_id";

    public function uploadBase64ImageToMediaServer($base64, $entityId, $entityName, $imageClass = "editor") : ExcellTransaction
    {
        $imageResult = $this->decodeBase64ImageStringToLocalFile($base64);

        if ($imageResult->result->Success === false)
        {
            return $imageResult;
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $imageResult->getData()->first()->getFullFileName());

        if (
            !in_array(strtolower($imageResult->getData()->first()->getFileExtension()), ["gif", "jpeg", "jpg", "png","svg"])
            && ($mime != "image/gif")
            && ($mime != "image/jpeg")
            && ($mime != "image/pjpeg")
            && ($mime != "image/x-png")
            && ($mime != "image/svg+xml")
            && ($mime != "image/png")
        )
        {
            return new ExcellTransaction(false, "You can only upload an image file: "  . $mime);
        }

        $localFile = $imageResult->getData()->first();
        $tempFilePathAndName = $localFile->getFullFileName();
        $userId = $this->app->getActiveLoggedInUser()->sys_row_id ?? "73a0d8b4-57e9-11ea-b088-42010a522005";
        $link = null;
        $result = null;

        register_shutdown_function('unlink', $tempFilePathAndName);

        try
        {
            $strPostUrl = "https://app.ezcardmedia.com/upload-image/{$entityName}/" . $entityId;
            $objHttp = new Http();
            $objFileForCurl = curl_file_create($tempFilePathAndName);
            $objHttpRequest = $objHttp->newRawRequest(
                "post",
                $strPostUrl,
                [
                    "file" => $objFileForCurl,
                    "user_id" => $userId,
                    "image_class" => $imageClass
                ]
            )
                ->setOption(CURLOPT_CAINFO, '/etc/ssl/ca-bundle.crt')
                ->setOption(CURLOPT_SSL_VERIFYPEER, false);

            $objHttpResponse = $objHttpRequest->send();

            $result = json_decode($objHttpResponse->body);

            $link = $result->link;
        }
        catch(\Exception $ex)
        {
            new ExcellTransaction(false, $ex->getMessage(), ["error" => $ex]);
        }

        if ($link === null)
        {
            new ExcellTransaction(false,"Unable to save the image", ["error" => $result]);
        }

        return new ExcellTransaction(true, "Upload Successful", $link);
    }

    public function decodeBase64ImageStringToLocalFile($data) : ExcellTransaction
    {
        $type = "txt";

        if (preg_match('/^data:image\/(\w+);base64,/', $data, $type))
        {
            $data = substr($data, strpos($data, ',') + 1);
            $type = strtolower($type[1]); // jpg, png, gif

            if (!in_array($type, [ 'jpg', 'jpeg', 'gif', 'png', 'svg' ]))
            {
                return new ExcellTransaction(false, 'invalid image type');
            }

            $data = base64_decode($data);

            if ($data === false)
            {
                return new ExcellTransaction(false, 'base64_decode failed');
            }
        }
        else
        {
            return new ExcellTransaction(false, 'did not match data URI with image data');
        }

        $localFile = new LocalFile(getGuid() . ".{$type}" );
        $localFile->addFileData($data);

        $colImageData = new ExcellCollection();
        $colImageData->Add($localFile);

        return new ExcellTransaction(true, 'base64_decode decoded', $colImageData);
    }

    public function buildImageBatchWhereClause($filterIdField = null, $filterEntity = null, int $typeId = 1) : string
    {
        $objWhereClause = $this->cardListPrimaryDataForDisplay($filterIdField, $filterEntity);

        if ($filterEntity !== null)
        {
            $objWhereClause .= "AND usr.{$filterIdField} = {$filterEntity} "; // 9 = card affiliate
        }

        $objWhereClause .= " AND img.image_class = 'image' GROUP BY(img.image_id) ORDER BY img.image_id DESC";

        return $objWhereClause;
    }

    public function buildLogoBatchWhereClause($filterIdField = null, $filterEntity = null, int $typeId = 1) : string
    {
        $objWhereClause = $this->cardListPrimaryDataForDisplay($filterIdField, $filterEntity);

        if ($filterEntity !== null)
        {
            $objWhereClause .= "AND usr.{$filterIdField} = {$filterEntity} "; // 9 = card affiliate
        }

        $objWhereClause .= " AND img.image_class = 'logo' GROUP BY(img.image_id) ORDER BY img.image_id DESC";

        return $objWhereClause;
    }

    private function cardListPrimaryDataForDisplay($filterIdField = null, $filterEntity = null)
    {
        $objWhereClause = "SELECT img.* FROM excell_media.image img ";

        if ($filterEntity !== null)
        {
            $objWhereClause .= "LEFT JOIN excell_main.user usr ON usr.user_id = img.user_id ";
        }

        //$objWhereClause .= "WHERE card.company_id = {$this->app->objCustomPlatform->getCompanyId()} AND card.status != 'Deleted' ";
        $objWhereClause .= "WHERE img.company_id = {$this->app->objCustomPlatform->getCompanyId()} ";

        return $objWhereClause;
    }
}