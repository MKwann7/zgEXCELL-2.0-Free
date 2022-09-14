<?php

namespace Http\Cards\Controllers;

use App\Utilities\Database;
use App\Utilities\Excell\ExcellHttpModel;
use App\Utilities\Http\Http;
use App\Utilities\Transaction\ExcellTransaction;
use Http\Cards\Controllers\Base\CardController;
use Entities\Cards\Models\AppInstancesModel;

class CardPageAppController extends CardController
{
    public function createAndAddToPage(ExcellHttpModel $objData) : bool
    {
        return false;
    }

    protected function callToWidgetApi($verb, $url, $data) : ExcellTransaction
    {
        $objHttp = new Http();

        try
        {
            $objHttpRequest = $objHttp->newRequest(
                $verb,
                $this->app->objCustomPlatform->getFullPortalDomainName() . $url,
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
}