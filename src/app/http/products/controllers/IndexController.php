<?php

namespace Http\Products\Controllers;

use App\Utilities\Database;
use App\Utilities\Excell\ExcellHttpModel;
use Entities\Cards\Classes\Cards;
use Entities\Cards\Models\CardModel;
use Http\Products\Controllers\Base\ProductController;
use Entities\Products\Classes\Products;
use Entities\Products\Components\Vue\MyProductsApp;
use Entities\Products\Components\Vue\ProductsWidget\ManageMyProductsWidget;
use Entities\Tickets\Classes\Journey\Journeys;

class IndexController extends ProductController
{
    public function index(ExcellHttpModel $objData) : bool
    {
        if($this->app->isAdminUrlRequest())
        {
            if($this->app->isUserLoggedIn())
            {
                if($this->app->strActivePortalBinding === "account")
                {
                    $this->RenderProductList($objData);
                }
                elseif($this->app->strActivePortalBinding === "account/admin")
                {
                    $this->RenderCardAdminDashboard($objData);
                }
            }
            else
            {
                $this->app->redirectToLogin();
            }
        }
        else
        {
            return $this->RenderCardOrWebsite($objData);
        }

        return false;
    }

    private function RenderProductList(ExcellHttpModel $objData) : void
    {
        $vueApp = (new MyProductsApp("vueApp"))
            ->setUriBase($objData->PathControllerBase)
            ->registerComponentAbstracts([
                ManageMyProductsWidget::getStaticId() => ManageMyProductsWidget::getStaticUriAbstract(),
            ]);

        (new Products())->renderApp(
            "users.view_my_products",
            $this->app->strAssignedPortalTheme,
            $vueApp
        );
    }

    private function RenderPackagesAdminList(ExcellHttpModel $objData, $strApproach = "list") : void
    {
        $objActivePackages = $this->AppEntity->GetAllActiveProducts();

        foreach($objActivePackages->Data as $currPackageId => $currPackageData)
        {
            $objActivePackages->getData()->{$currPackageId}->last_updated = date("m/d/Y",strtotime($currPackageData->last_updated));
        }

        require APP_ENTITIES . "cards/classes/main.class" . XT;

        $objPackage = null;
        $colPackageCards = null;

        if ( $strApproach === "view")
        {
            $intPackageId = $objData->Data->Params["id"] ?? 0;
            $objPackage = $this->AppEntity->getFks()->getById($intPackageId)->getData()->first();
            $colPackageCards = (new Cards())->getFks()->getWhere("product_id", "=", $intPackageId)->getData();
        }

        $this->AppEntity->renderAppPage("admin_view_all_packages", $this->app->strAssignedPortalTheme, [
            "objActivePackages" => $objActivePackages,
            "strApproach" => $strApproach,
            "objPackage" => $objPackage,
            "colPackageCards" => $colPackageCards,
        ]);
    }

    public function getProductBatches(ExcellHttpModel $objData) : bool
    {
        $pageIndex  = $objData->Data->Params["offset"] ?? 1;
        $batchCount = $objData->Data->Params["batch"] ?? 500;
        $filterEntity = $objData->Data->Params["filterEntity"] ?? null;
        $pageIndex  = ($pageIndex - 1) * $batchCount;
        $arFields   = explode(",", $objData->Data->Params["fields"]);
        $strEnd     = "false";

        $filterIdField = "user_id";

        if ($filterEntity !== null && !isInteger($filterEntity))
        {
            $filterIdField = "sys_row_id";
            $filterEntity = "'".$filterEntity."'";
        }

        $objWhereClause = "SELECT card.*,
            (SELECT platform_name FROM `excell_main`.`company` WHERE company.company_id = card.company_id LIMIT 1) AS platform, 
            (SELECT url FROM `excell_media`.`image` WHERE image.entity_id = card.card_id AND image.entity_name = 'card' AND image_class = 'main-image' ORDER BY image_id DESC LIMIT 1) AS banner, 
            (SELECT thumb FROM `excell_media`.`image` WHERE image.entity_id = card.card_id AND image.entity_name = 'card' AND image_class = 'favicon-image' ORDER BY image_id DESC LIMIT 1) AS favicon,
            (SELECT CONCAT(user.first_name, ' ', user.last_name) FROM `excell_main`.`user` WHERE user.user_id = card.owner_id LIMIT 1) AS card_owner_name,
            (SELECT CONCAT(user.first_name, ' ', user.last_name) FROM `excell_main`.`user` WHERE user.user_id = card.card_user_id LIMIT 1) AS card_user_name,
            (SELECT title FROM `excell_main`.`product` WHERE product.product_id = card.product_id LIMIT 1) AS product, 
            (SELECT COUNT(*) FROM `excell_main`.`contact_card_rel` mcgr WHERE mcgr.card_id = card.card_id) AS card_contacts
            FROM excell_main.card ";

        if ($filterEntity !== null)
        {
            $objWhereClause .= "LEFT JOIN `excell_main`.`user` cowner ON cowner.user_id = card.owner_id ";
            $objWhereClause .= "LEFT JOIN `excell_main`.`user` cuser ON cuser.user_id = card.card_user_id ";
            $objWhereClause .= "LEFT JOIN `excell_main`.`card_rel` ON card_rel.card_id = card.card_id ";
        }

        $objWhereClause .= "WHERE card.company_id = {$this->app->objCustomPlatform->getCompanyId()} AND card.status != 'Deleted' ";

        if ($filterEntity !== null)
        {
            $objWhereClause .= "AND ( (cowner.{$filterIdField} = {$filterEntity} OR cuser.{$filterIdField} = {$filterEntity})";
            $objWhereClause .= " OR (card_rel.{$filterIdField} = {$filterEntity} AND card_rel.status = 'Active') AND card_rel.card_rel_type_id != 9)"; // 9 = card affiliate
        }

        if (!in_array($this->app->getActiveLoggedInUser()->user_id, [1000, 1001, 90990]))
        {
            $objWhereClause .= " AND (card.template_card = 0) ";
        }

        $objWhereClause .= " GROUP BY(card.card_id) ORDER BY card.card_num DESC LIMIT {$pageIndex}, {$batchCount}";

        $objCards = Database::getSimple($objWhereClause, "card_id");

        if ($objCards->getData()->Count() < $batchCount)
        {
            $strEnd = "true";
        }

        $objCards->getData()->HydrateModelData(CardModel::class, true);

        $arUserDashboardInfo = array(
            "list" => $objCards->getData()->FieldsToArray($arFields),
            "query" => $objWhereClause,
        );

        return $this->renderReturnJson(true, $arUserDashboardInfo, "We found " . $objCards->getData()->Count() . " cards in this batch.", 200, "data", $strEnd);
    }
}