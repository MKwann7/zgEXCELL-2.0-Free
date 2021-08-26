<?php

namespace Entities\Emails\Classes;

use App\Core\AppEntity;
use App\Utilities\Http\Http;
use Entities\Emails\Models\EmailModel;

class Emails extends AppEntity
{
    public $strEntityName       = "Emails";
    public $strDatabaseTable    = "email";
    public $strDatabaseName     = "Communication";
    public $strMainModelName    = EmailModel::class;
    public $strMainModelPrimary = "email_id";
    public $isPrimaryModule = true;

    // TODO - Pull out into ENV
    protected $strMainGunUrl    = "https://api.mailgun.net/v3/ezcard.com";
    protected $strMainGunKey    = "00163ce988da1f8ce05122a201311c35-2d27312c-6826fcc3";

    public function SendEmail($arFrom, array $arTo, $strTitle, $strMessage, $strEncoding = "text") : void
    {
        $objHttp = new Http();

        try {

            $objHttpRequest = $objHttp->newRequest(
                "post",
                $this->strMainGunUrl . "/messages",
                [
                    "from" => $arFrom,
                    "to" => $arTo,
                    "subject" => $strTitle,
                    "html" => $strMessage
                ]
            )
            ->setOption(CURLOPT_USERPWD, 'api:' . $this->strMainGunKey)
            ->setOption(CURLOPT_SSL_VERIFYPEER, false);

            $objHttpResponse = $objHttpRequest->send();

        } catch(\Exception $ex)
        {
        }
    }
}