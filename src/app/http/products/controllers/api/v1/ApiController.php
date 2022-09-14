<?php

namespace Http\Products\Controllers\Api\V1;

use App\Utilities\Excell\ExcellHttpModel;
use Http\Products\Controllers\Base\ProductController;
use Entities\Products\Classes\Products;

class ApiController extends ProductController
{
    public function GetProductsForCartCdn (ExcellHttpModel $objData): void
    {
        $objActivePackages = (new Products())->GetAllActiveProducts();

        header("Access-Control-Allow-Origin: *");

        echo ($objActivePackages->getData()->FieldsToJson(["product_id", "title", "quantity", "value", "billing_count", "cycle", "promo_value", "promo_cycle_duration"]));

        die();
    }
}