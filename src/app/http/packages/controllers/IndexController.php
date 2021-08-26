<?php

namespace Entities\Packages\Controllers;

use App\Utilities\Database;
use App\Utilities\Excell\ExcellHttpModel;
use Entities\Companies\Models\CompanyModel;
use Entities\Packages\Classes\Base\PackageController;
use Entities\Packages\Models\PackageModel;

class IndexController extends PackageController
{
    public function index(ExcellHttpModel $objData) : void
    {
        if(!$this->app->isAdminUrlRequest() || !$this->app->isUserLoggedIn())
        {
            $this->app->redirectToLogin();
        }

        $this->RenderPackagesAdminList($objData);
    }

    public function ViewPackage(ExcellHttpModel $objData) : void
    {
        if(!$this->app->isAdminUrlRequest() || !$this->app->isUserLoggedIn())
        {
            $this->app->redirectToLogin();
        }

        self::RenderPackagesAdminList($objData, "view");
    }

    private function RenderPackagesAdminList(ExcellHttpModel $objData, $strApproach = "list") : void
    {
        $entityId = $objData->Data->Params["id"] ?? null;

        $this->AppEntity->renderAppPage("admin.view_packages", $this->app->strAssignedPortalTheme, [
            "entityId" => $entityId,
        ]);
    }

    public function getPackageBatches(ExcellHttpModel $objData) : bool
    {
        $pageIndex = $objData->Data->Params["offset"] ?? 1;
        $batchCount = $objData->Data->Params["batch"] ?? 500;
        $pageIndex = ($pageIndex - 1) * $batchCount;
        $arFields = explode(",", $objData->Data->Params["fields"]);
        $strEnd = "false";

        $objWhereClause = "
            SELECT package.*
            FROM `package` ";

        if (in_array($this->app->getActiveLoggedInUser()->user_id, [1002, 1003, 70726, 73837, 90999, 91003, 91015, 91014]))
        {
            $objWhereClause .= "WHERE company_id = {$this->app->objCustomPlatform->getCompanyId()} AND package_id != 27";
        }
        else
        {
            $objWhereClause .= "WHERE company_id = {$this->app->objCustomPlatform->getCompanyId()}";
        }

        $objWhereClause .= " ORDER BY package.package_id DESC LIMIT {$pageIndex}, {$batchCount}";

        $objCards = Database::getSimple($objWhereClause,"package_id");

        if ($objCards->Data->Count() < $batchCount)
        {
            $strEnd = "true";
        }

        $objCards->Data->HydrateModelData(PackageModel::class, true);

        $arUserDashboardInfo = array(
            "list" => $objCards->Data->FieldsToArray($arFields),
            "query" => $objWhereClause
        );

        return $this->renderReturnJson(true, $arUserDashboardInfo, "We found " . $objCards->Data->Count() . " packages in this batch.", 200, "data", $strEnd);
    }

    public function getCustomPlatformPackageBatches(ExcellHttpModel $objData) : bool
    {
        $pageIndex = $objData->Data->Params["offset"] ?? 1;
        $batchCount = $objData->Data->Params["batch"] ?? 500;
        $filterEntity = $objData->Data->Params["filterEntity"] ?? null;
        $pageIndex = ($pageIndex - 1) * $batchCount;
        $arFields = explode(",", $objData->Data->Params["fields"]);
        $strEnd = "false";

        $objWhereClause = "
            SELECT package.*
            FROM `package` ";

        $objWhereClause .= "WHERE company_id = {$filterEntity}";
        $objWhereClause .= " ORDER BY package.package_id DESC LIMIT {$pageIndex}, {$batchCount}";

        $objCards = Database::getSimple($objWhereClause,"package_id");

        if ($objCards->Data->Count() < $batchCount)
        {
            $strEnd = "true";
        }

        $objCards->Data->HydrateModelData(PackageModel::class, true);

        $arUserDashboardInfo = array(
            "list" => $objCards->Data->FieldsToArray($arFields),
            "query" => $objWhereClause
        );

        return $this->renderReturnJson(true, $arUserDashboardInfo, "We found " . $objCards->Data->Count() . " packages in this batch.", 200, "data", $strEnd);
    }
}