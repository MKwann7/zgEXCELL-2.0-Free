<?php

namespace Entities\Companies\Controllers;

use App\Utilities\Database;
use App\Utilities\Excell\ExcellHttpModel;
use Entities\Cards\Components\Vue\CardWidget\ManageCardWidget;
use Entities\Companies\Classes\Base\CompanyController;
use Entities\Companies\Classes\Companies;
use Entities\Companies\Classes\Departments\Departments;
use Entities\Companies\Classes\Departments\DepartmentTicketQueues;
use Entities\Companies\Components\Vue\PlatformMainApp;
use Entities\Companies\Components\Vue\PlatformWidget\ManagePlatformWidget;
use Entities\Companies\Components\Vue\PlatformWidget\RegistrationWidget;
use Entities\Companies\Models\CompanyModel;
use Entities\Users\Components\Vue\UserWidget\ManageCustomerProfileWidget;

class IndexController extends CompanyController
{
    public function index(ExcellHttpModel $objData) : void
    {
        if($this->app->strActivePortalBinding !== "account/admin" || !$this->app->isAdminUrlRequest() || !$this->app->isUserLoggedIn())
        {
            $this->app->redirectToLogin();
        }

        if (!$this->app->userAuthentication() || !userCan("manage-platforms"))
        {
            $this->app->redirectToLogin();
        }

        switch ($this->AppEntity->strAliasName)
        {
            case "platforms":
                $this->RenderCustomPlatformList($objData);
                break;
            default:
                $this->RenderRenderCompanyList($objData);
                break;
        }
    }

    public function getPlatformInfo(ExcellHttpModel $objData) : bool
    {
        $objCart = new Companies();
        $content = $objCart->getView("public.platform_info", $this->app->strAssignedPortalTheme, []);

        die($content);
    }

    public function getCustomPlatformManagerComponent(ExcellHttpModel $objData) : bool
    {
        return $this->renderReturnJson(true, base64_encode((new RegistrationWidget())->renderComponentForAjaxDelivery()), "Here's what we got.", 200, "widget");
    }

    protected function RenderCustomPlatformList(ExcellHttpModel $objData)
    {
        $vueApp = (new PlatformMainApp("vueApp"))
            ->setUriBase($objData->PathControllerBase)
            ->registerComponentAbstracts([
                ManagePlatformWidget::getStaticId() => ManagePlatformWidget::getStaticUriAbstract(),
            ]);

        (new Companies())->renderApp(
            "admin.view_platforms",
            $this->app->strAssignedPortalTheme,
            $vueApp
        );
    }

    protected function RenderRenderCompanyList(ExcellHttpModel $objData)
    {
        $this->AppEntity->renderAppPage("admin.view_companies", $this->app->strAssignedPortalTheme);
    }

    public function getPlatformBatches(ExcellHttpModel $objData) : bool
    {
        if (!userCan("manage-platforms"))
        {
            return $this->renderReturnJson(false, [], "Unauthorized", 401);
        }

        $pageIndex = $objData->Data->Params["offset"] ?? 1;
        $batchCount = $objData->Data->Params["batch"] ?? 500;
        $pageIndex = ($pageIndex - 1) * $batchCount;
        $arFields = explode(",", $objData->Data->Params["fields"]);
        $strEnd = "false";

        $objWhereClause = "
            SELECT company.*,
            platform_name AS platform,
            domain_portal AS portal_domain,
            domain_public AS public_domain,
            (SELECT CONCAT(user.first_name, ' ', user.last_name) FROM `ezdigital_v2_main`.`user` WHERE user.user_id = company.owner_id LIMIT 1) AS owner,
            (SELECT COUNT(*) FROM `ezdigital_v2_main`.`card` cd WHERE cd.company_id = company.company_id) AS cards
            FROM `company` WHERE status != 'deleted'";

        $objWhereClause .= " ORDER BY company.company_id ASC LIMIT {$pageIndex}, {$batchCount}";

        $objCards = Database::getSimple($objWhereClause,"company_id");

        if ($objCards->Data->Count() < $batchCount)
        {
            $strEnd = "true";
        }

        $objCards->Data->HydrateModelData(CompanyModel::class, true);

        $arUserDashboardInfo = array(
            "list" => $objCards->Data->FieldsToArray($arFields),
        );

        return $this->renderReturnJson(true, $arUserDashboardInfo, "We found " . $objCards->Data->Count() . " companies in this batch.", 200, "data", $strEnd);
    }

    public function getCompanyDataForUserManagement(ExcellHttpModel $objData) : bool
    {
        if (!userCan("manage-system"))
        {
            return $this->renderReturnJson(false, [], "Unauthorized", 401);
        }

        if (!$this->validateRequestType('GET'))
        {
            return false;
        }

        $arCompanyData = array(
            "departments" => (new Departments())->getWhere(["company_id" => $this->app->objCustomPlatform->getCompanyId()])->Data->ToPublicArray(),
            "departmentQueues" => (new DepartmentTicketQueues())->getWhere(["company_id" => $this->app->objCustomPlatform->getCompanyId()])->Data->ToPublicArray(),
        );


        return $this->renderReturnJson(true, $arCompanyData, "We have data.", 200);
    }
}