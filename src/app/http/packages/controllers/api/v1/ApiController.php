<?php

namespace Entities\Packages\Controllers\Api\V1;

use App\Utilities\Excell\ExcellHttpModel;
use Entities\Packages\Classes\Base\PackageController;
use Entities\Packages\Classes\Packages;

class ApiController extends PackageController
{
    public function GetPackagesForCartCdn(ExcellHttpModel $objData): void
    {
        $objActivePackages = (new Packages())->GetAllActiveProducts();

        header("Access-Control-Allow-Origin: *");

        echo ($objActivePackages->Data->FieldsToJson(["product_id", "title", "quantity", "value", "billing_count", "cycle", "promo_value", "promo_cycle_duration"]));

        die();
    }
}