<?php

namespace Http\Products\Controllers;

use App\Utilities\Excell\ExcellHttpModel;
use Entities\Cards\Classes\Cards;
use Http\Products\Controllers\Base\ProductController;

class ProductDataController extends ProductController
{
    public function index(ExcellHttpModel $objData) : void
    {
        die('{"success":true,"message":"we made it1."}');
    }

    public function getPackageDashboardInfo(ExcellHttpModel $objData) : void
    {
        if(!$this->app->isUserLoggedIn() || !$this->app->isPortalWebsite())
        {
            $this->app->redirectToLogin();
        }

        $intPackageId = $objData->Data->PostData->product_id;

        require APP_ENTITIES . "cards/classes/main.class" . XT;

        $colUserCards =  (new Cards())->getFks()->getWhere("product_id", "=", $intPackageId)->getData();

        $arUserDashboardInfo = array(
            "cards" => $colUserCards->CollectionToArray(),
        );

        $objJsonReturn = array(
            "success" => true,
            "message" => "We information for product_id = " . $objData->Data->PostData->product_id . ".",
            "data" => $arUserDashboardInfo,
        );

        die(json_encode($objJsonReturn));
    }

    public function getPackageDashboardViews(ExcellHttpModel $objData) : void
    {
        if(!$this->app->isUserLoggedIn() || !$this->app->isPortalWebsite())
        {
            $this->app->redirectToLogin();
        }

        $strViewTitle = $objData->Data->PostData->view;

        $strView = "";

        switch($strViewTitle)
        {
            case "addPackage":
            case "editPackage":
            case "editProfile":
            case "editCustomerProfile":
            case "editLogistics":
                $strView = $this->AppEntity->getView("manage_package_data", $this->app->strAssignedPortalTheme, ["strViewTitle" => $strViewTitle]);
                break;
        }

        if (empty($strView))
        {
            $objJsonReturn = array(
                "success" => false,
                "message" => "We did not find the requested view.",
            );

            die(json_encode($objJsonReturn));
        }

        $arDataReturn = array(
            "view" => base64_encode($strView),
        );

        $objJsonReturn = array(
            "success" => true,
            "message" => "We found the requested view.",
            "data" => $arDataReturn,
        );

        die(json_encode($objJsonReturn));
    }
}