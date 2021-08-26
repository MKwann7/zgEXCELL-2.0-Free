<?php

namespace Entities\Products\Controllers\Api\V1;

use App\Utilities\Excell\ExcellHttpModel;
use Entities\Products\Classes\Base\ProductController;
use Entities\Products\Classes\Products;

class ApiController extends ProductController
{
    public function GetProductsForCartCdn (ExcellHttpModel $objData): void
    {
        $objActivePackages = (new Products())->GetAllActiveProducts();

        header("Access-Control-Allow-Origin: *");

        echo ($objActivePackages->Data->FieldsToJson(["product_id", "title", "quantity", "value", "billing_count", "cycle", "promo_value", "promo_cycle_duration"]));

        die();
    }
}