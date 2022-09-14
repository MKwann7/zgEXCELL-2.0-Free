<?php

namespace Vendors\Mobiniti\Main\V100\Classes\Base;

use App\Utilities\Excell\ApiClass;
use App\Utilities\Excell\ExcellCollection;
use App\Utilities\Excell\ExcellModel;
use App\Utilities\Http\Http;
use App\Utilities\Transaction\ExcellTransaction;
use Entities\Mobiniti\Models\MobinitiModel;

class MobinitiBase implements ApiClass
{
    protected $api_url = 'https://api.mobiniti.com';
    protected $api_version = 'v1';
    protected $access_token;
    protected $errors;
    protected $resource;
    protected $model;
    protected $include = [];

    public function __construct()
    {
        $this->access_token = MobinitiToken;
    }

    protected function BuildMobinityApiUrl()
    {
        return $this->api_url . "/" . $this->api_version . "/" .  $this->resource . "/";
    }

    protected function BuildHttp()
    {
        $objHttp = new Http();

        $objHttp->setDefaultHeaders([
            "Authorization" => "Bearer {$this->access_token}",
            "Content-Type" => "application/json"
        ]);

        return $objHttp;
    }

    public function GetById($strGuid): ExcellTransaction
    {
        try
        {
            return $this->GetMobinitiData(1, 1, 1, 1, "", $strGuid);
        }
        catch(\Exception $ex)
        {
            $objTransaction = new ExcellTransaction();

            $objTransaction->result->Success = false;
            $objTransaction->result->Count = 0;
            $objTransaction->result->Errors = [0 => $ex];
            $objTransaction->result->Message = "There was an error processing this request";

            return $objTransaction;
        }
    }

    public function GetAll($record_count = 10000, $page_offset = 1, $page_limit = 100): ExcellTransaction
    {
        $objTransaction = new ExcellTransaction();

        if ($page_limit > 100)
        {
            $objTransaction->result->Success = false;
            $objTransaction->result->Count = 0;
            $objTransaction->result->Message = "The record count request cannot be less than the offset of " . $page_limit;
        }

        list($intRecordCount, $intPageCount, $intPageOffset, $intPageLimit, $strQuery) = $this->ParseFilterOrderAndPagination($record_count, $page_offset, $page_limit);

        try
        {
            $objTransaction = $this->GetMobinitiData($intRecordCount, $intPageCount, $intPageOffset, $intPageLimit, $strQuery);
            $objTransaction->result->Depth = ($page_limit * ($intPageOffset - 1));

            return $objTransaction;
        }
        catch(\Exception $ex)
        {
            return $objTransaction;
        }
    }

    public function GetWhere (): ExcellTransaction
    {
        // TODO: Implement GetWhere() method.
    }

    public function CreateNew(ExcellModel $objEntity): ExcellTransaction
    {
        $objTransaction = new ExcellTransaction();
        $objHttp = $this->BuildHttp();
        $strMobinitiUrl = $this->BuildMobinityApiUrl();

        $objHttpRequest = $objHttp->newJsonRequest(
            "post",
            $strMobinitiUrl,
            $objEntity->ToArray()
        )
            ->setOption(CURLOPT_CAINFO, '/etc/ssl/ca-bundle.crt')
            ->setOption(CURLOPT_SSL_VERIFYPEER, false);

        $objHttpResponse = $objHttpRequest->send();

        if ($objHttpResponse->statusCode != 200)
        {
            if (empty($objHttpResponse->body))
            {
                $objTransaction->result->Success = false;
                $objTransaction->result->Count = 0;
                $objTransaction->result->Message = $objHttpResponse->statusText;
                $objTransaction->result->Query = $strMobinitiUrl . " POST: " . $objEntity->ToJson();
                return $objTransaction;
            }

            $objEntityList = json_decode($objHttpResponse->body);

            $objTransaction->result->Success = false;
            $objTransaction->result->Count = 0;
            $objTransaction->result->Message = "FROM Mobiniti: " . $objEntityList->message;
            $objTransaction->result->Query = $strMobinitiUrl  . " POST: " . $objEntity->ToJson();
            $objTransaction->result->Errors = $objEntityList->errors;
            return $objTransaction;
        }

        if (empty($objHttpResponse->body))
        {
            $objTransaction->result->Success = false;
            $objTransaction->result->Count = 0;
            $objTransaction->result->Message = "No body returned from Mobiniti API endpint.";
            return $objTransaction;
        }

        $objEntityList = json_decode($objHttpResponse->body);

        $objTransaction->result->Success = true;
        $objTransaction->result->Count = 1;
        $objTransaction->data = $objEntityList;

        return $objTransaction;
    }

    public function Update(ExcellModel $objEntity): ExcellTransaction
    {
        $objTransaction = new ExcellTransaction();
        $objHttp = $this->BuildHttp();
        $strMobinitiUrl = $this->BuildMobinityApiUrl() . "/" . $objEntity->id;

        $objHttpRequest = $objHttp->newJsonRequest(
            "put",
            $strMobinitiUrl,
            $objEntity->ToArray()
        )
            ->setOption(CURLOPT_CAINFO, '/etc/ssl/ca-bundle.crt')
            ->setOption(CURLOPT_SSL_VERIFYPEER, false);

        $objHttpResponse = $objHttpRequest->send();

        if ($objHttpResponse->statusCode != 200)
        {
            if (empty($objHttpResponse->body))
            {
                $objTransaction->result->Success = false;
                $objTransaction->result->Count = 0;
                $objTransaction->result->Message = $objHttpResponse->statusText;
                $objTransaction->result->Query = $strMobinitiUrl . " PUT    : " . $objEntity->ToJson();
                return $objTransaction;
            }

            $objEntityList = json_decode($objHttpResponse->body);

            $objTransaction->result->Success = false;
            $objTransaction->result->Count = 0;
            $objTransaction->result->Message = "FROM Mobiniti: " . $objEntityList->message;
            $objTransaction->result->Query = $strMobinitiUrl  . " PUT: " . $objEntity->ToJson();
            $objTransaction->result->Errors = $objEntityList->errors;
            return $objTransaction;
        }

        if (empty($objHttpResponse->body))
        {
            $objTransaction->result->Success = false;
            $objTransaction->result->Count = 0;
            $objTransaction->result->Message = "No body returned from Mobiniti API endpint.";
            return $objTransaction;
        }

        $objEntityList = json_decode($objHttpResponse->body);

        $objTransaction->result->Success = true;
        $objTransaction->result->Count = 1;
        $objTransaction->data = $objEntityList;

        return $objTransaction;
    }

    public function Delete (ExcellModel $objModel): ExcellTransaction
    {
        // TODO: Implement Delete() method.
    }

    protected function ParseFilterOrderAndPagination($record_count, $page_offset, $page_limit)
    {
        if ($record_count < $page_limit)
        {
            $page_limit = $record_count;
        }

        $intPageCount = floor($record_count / $page_limit);

        $strQuery = "";
        $arQuery = [];

        if ($page_offset > 1)
        {
            $arQuery[] = "page=" . $page_offset;
        }

        if ($page_limit < 100)
        {
            $arQuery[] = "limit=" . $page_limit;
        }

        if (count($arQuery) > 0)
        {
            $strQuery = "?" . implode("&", $arQuery);
        }

        return [
            $record_count,
            $intPageCount,
            $page_offset,
            $page_limit,
            $strQuery
        ];
    }

    protected function GetMobinitiData($record_count, $page_count = 10, $offset = 1, $page_limit = 100, $strQuery = "", $strUri = "") : ExcellTransaction
    {
        $objTransaction = new ExcellTransaction();
        $objHttp = $this->BuildHttp();
        $strMobinitiUrl = $this->BuildMobinityApiUrl() . $strUri . $strQuery . $this->buildIncludeRequests($strQuery);

        $objHttpRequest = $objHttp->newRequest(
            "get",
            $strMobinitiUrl
        )
            ->setOption(CURLOPT_CAINFO, '/etc/ssl/ca-bundle.crt')
            ->setOption(CURLOPT_SSL_VERIFYPEER, false);

        $objHttpResponse = $objHttpRequest->send();

        if ($objHttpResponse->statusCode != 200)
        {
            if (empty($objHttpResponse->body))
            {
                $objTransaction->result->Success = false;
                $objTransaction->result->Count = 0;
                $objTransaction->result->Message = $objHttpResponse->statusText ?? "";
                $objTransaction->result->Query = $strMobinitiUrl;
                return $objTransaction;
            }

            $objEntityList = json_decode($objHttpResponse->body);

            $objTransaction->result->Success = false;
            $objTransaction->result->Count = 0;
            $objTransaction->result->Message = !empty($objEntityList->message) ? $objEntityList->message : "Unknown message.";
            $objTransaction->result->Query = $strMobinitiUrl;
            return $objTransaction;
        }

        if (empty($objHttpResponse->body))
        {
            $objTransaction->result->Success = false;
            $objTransaction->result->Count = 0;
            $objTransaction->result->Message = "No body returned from Mobiniti API endpint.";
            return $objTransaction;
        }

        $objEntityList = json_decode($objHttpResponse->body);

        if (empty($objEntityList->data))
        {
            $objTransaction->result->Success = false;
            $objTransaction->result->Count = 0;
            $objTransaction->result->Message = "No data returned from Mobiniti API endpint in body.";
            return $objTransaction;
        }

        $page_count--;

        $colGroups = new ExcellCollection();

        if (!empty($objEntityList->meta) && !empty($objEntityList->meta->pagination))
        {
            foreach($objEntityList->data as $currEntity)
            {
                $colGroups->Add($this->AssignMobinitiDate($currEntity, new $this->model()));
            }

            $strCurrentPage = $objEntityList->meta->pagination->current_page ?? 1;
            $strTotalPages = $objEntityList->meta->pagination->total_pages ?? 1;
            $objTransaction->result->Total = $objEntityList->meta->pagination->total ?? 1;

            if ($strTotalPages > $strCurrentPage && $page_count > 0)
            {
                $offset = $strCurrentPage + 1;

                $arQuery = [];

                if ($offset > 1)
                {
                    $arQuery[] = "page=" . $offset;
                }

                if ($page_limit < 100)
                {
                    $arQuery[] = "limit=" . $page_limit;
                }

                if (count($arQuery) > 0)
                {
                    $strQuery = "?" . implode("&", $arQuery);
                }

                $objNextDataPageResult = $this->GetMobinitiData($record_count, $page_count, $offset, $page_limit, $strQuery, $strUri);

                if ($objNextDataPageResult->result->Count > 0)
                {
                    $colGroups->Merge($objNextDataPageResult->data);
                }
            }
        }
        else
        {
            $colGroups->Add($this->AssignMobinitiDate($objEntityList->data, new $this->model()));
        }

        if ($record_count < $colGroups->Count())
        {
            $colGroups->Trim(0, $record_count);
        }

        $objTransaction->result->Success = true;
        $objTransaction->result->Count = $colGroups->Count();
        $objTransaction->result->Message = "We found " . $colGroups->Count() . " {$this->resource}.";
        $objTransaction->data = $colGroups;

        return $objTransaction;
    }

    protected function buildIncludeRequests($strQuery) : string
    {
        $arIncludeStatement = [];

        if (!empty($this->include) && count($this->include) > 0)
        {
            foreach($this->include as $currInclude)
            {
                $arIncludeStatement[] = "include[]=" . $currInclude;
            }
        }

        return (!empty($strQuery) ? "&" : "?" ) . implode("&", $arIncludeStatement);
    }

    protected function AssignMobinitiDate($objEntityData = null, $objModel = null) : ?MobinitiModel
    {
        if (empty($objEntityData) || empty($objModel))
        {
            return null;
        }

        foreach($objEntityData as $currKey => $currEntityField)
        {
            $strFieldType = $objModel->getFieldType($currKey);

            if (strpos($strFieldType, ":") !== false)
            {
                $arFieldType = explode(":", $strFieldType);

                switch($arFieldType[0])
                {
                    case "collection":
                        $objModel->$currKey = $this->BuildCollectionFromData($currEntityField, $arFieldType[1]);
                        break;
                    case "entity":
                        $objModel->$currKey = $this->BuildEntityFromData($currEntityField, $arFieldType[1]);
                        break;
                }
            }
            else
            {
                $objModel->$currKey  = $currEntityField;
            }
        }

        return $objModel;
    }

    protected function BuildCollectionFromData($currEntityField, $strCollectionType) : ExcellCollection
    {
        if (!empty($currEntityField->data) && count($currEntityField->data) > 0)
        {
            $colSubCollection = new ExcellCollection();

            foreach($currEntityField->data as $currSubKey => $currSubEntity)
            {
                $colSubCollection->Add($this->AssignMobinitiDate($currSubEntity, new $strCollectionType));
            }

            return $colSubCollection;
        }
        elseif (count($currEntityField) > 0)
        {
            $colSubCollection = new ExcellCollection();

            foreach($currEntityField as $currSubKey => $currSubEntity)
            {
                $colSubCollection->Add($this->AssignMobinitiDate($currSubEntity, new $strCollectionType));
            }

            return $colSubCollection;
        }
    }

    protected function BuildEntityFromData($currEntityField, $strEntityType) : MobinitiModel
    {
        if (!empty($currEntityField->data) && count($currEntityField->data) > 0)
        {
            return $this->AssignMobinitiDate($currEntityField->data, new $strEntityType);
        }
        elseif (is_array($currEntityField) && count($currEntityField) > 0)
        {
            return $this->AssignMobinitiDate($currEntityField, new $strEntityType);
        }
    }
}
