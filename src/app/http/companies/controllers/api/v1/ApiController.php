<?php

namespace Entities\Companies\Controllers\Api\V1;

use App\Utilities\Excell\ExcellHttpModel;
use Entities\Cards\Classes\Base\CardController;
use Entities\Companies\Classes\Companies;
use Entities\Companies\Models\CompanyModel;

class ApiController extends CardController
{
    public function getCustomPlatformByUuid(ExcellHttpModel $objData): bool
    {
        if (!$this->validateRequestType('GET'))
        {
            return false;
        }

        $objParams = $objData->Data->Params;

        if (!$this->validate($objParams, [
            "uuid" => "required|uuid",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $customPlatformResult = (new Companies())->getByUuid($objParams["uuid"]);

        if ($customPlatformResult->Result->Count !== 1)
        {
            return $this->renderReturnJson(false, $customPlatformResult->Data["errors"], "No custom platform found.");
        }

        /** @var CompanyModel $customPlatform */
        $customPlatform = $customPlatformResult->Data->First();

        if (isset($objParams["addons"]))
        {
            $addons = explode("|", $objParams["addons"]);
            foreach($addons as $currAddon)
            {
                $customPlatform->LoadAddons($currAddon);
            }
        }

        return $this->renderReturnJson(true, ["customPlatform" => $customPlatform->ToPublicArray()], "We made it.");
    }
}