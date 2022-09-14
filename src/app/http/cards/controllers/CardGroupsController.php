<?php

namespace Http\Cards\Controllers;

use App\Utilities\Excell\ExcellHttpModel;
use Entities\Cards\Classes\Cards;
use Http\Card\Controllers\Base\CardController;
use Entities\Cards\Classes\CardGroupsModule;
use Entities\Users\Classes\Users;

class CardGroupsController extends CardController
{
    public function index(ExcellHttpModel $objData) : void
    {
        if($this->app->isAdminUrlRequest())
        {
            if($this->app->isUserLoggedIn())
            {
                if($this->app->strActivePortalBinding === "account")
                {
                    $this->RenderCardGroupDashboard($objData);
                }
                elseif($this->app->strActivePortalBinding === "account/admin")
                {
                    $this->RenderCardGroupAdminDashboard($objData);
                }
            }
            else
            {
                $this->app->redirectToLogin();
            }
        }
        else
        {
            $this->app->redirectToLogin();
        }
    }

    public function ViewCardGroup(ExcellHttpModel $objData) : void
    {
        if($this->app->isAdminUrlRequest())
        {
            if($this->app->isUserLoggedIn())
            {
                if( $this->app->strActivePortalBinding === "account/admin")
                {
                    self::RenderCardGroupAdminDashboard($objData, "view");
                }
                else
                {
                    self::RenderCardGroupDashboard($objData, "view");
                }
            }
            else
            {
                $this->app->redirectToLogin();
            }
        }
        else
        {
            $this->app->redirectToLogin();
        }
    }

    public function RenderCardGroupAdminDashboard(ExcellHttpModel $objData, $strApproach = "list") : void
    {
        $objActiveCardGroups = (new CardGroupsModule())->getFks()->GetAllCardGroupsForDisplay($objData);

        foreach($objActiveCardGroups->Data as $currCardGroupIndex => $currCardGroupData)
        {
            $objActiveCardGroups->getData()->{$currCardGroupIndex}->created_on = date("m/d/Y", strtotime($currCardGroupData->created_on));
            $objActiveCardGroups->getData()->{$currCardGroupIndex}->last_updated = date("m/d/Y", strtotime($currCardGroupData->last_updated));
        }

        $objCardGroup = null;
        $colCardGroupUser = null;
        $objCard = null;

        if ( $strApproach === "view")
        {
            $intCardGroupId = $objData->Data->Params["id"];

            $objCardGroup = (new CardGroupsModule())->getFks()->getById($intCardGroupId)->getData()->first();
            $colCardGroupUser = (new Users())->getFks()->GetUsersByCardGroupId($intCardGroupId)->getData();
            $objCard = (new Cards())->getFks()->GetCardByGroupId($intCardGroupId)->getData()->first();

            $objCardGroup->created_on = date("m/d/Y", strtotime($objCardGroup->created_on));
            $objCardGroup->last_updated = date("m/d/Y", strtotime($objCardGroup->last_updated));

            foreach($colCardGroupUser as $currCardGroupIndex => $currCardGroupUserData)
            {
                $colCardGroupUser->{$currCardGroupIndex}->created_on = date("m/d/Y", strtotime($currCardGroupUserData->created_on));
                $colCardGroupUser->{$currCardGroupIndex}->last_updated = date("m/d/Y", strtotime($currCardGroupUserData->last_updated));
            }
        }

        $this->AppEntity->renderAppPage("admin.admin_view_all_card_groups", $this->app->strAssignedPortalTheme, [
            "objActiveCards" => $objActiveCardGroups,
            "strApproach" => $strApproach,
            "objCardGroup" => $objCardGroup,
            "colCardGroupUser" => $colCardGroupUser,
            "objCard" => $objCard,
        ]);
    }

    public function RenderCardGroupDashboard(ExcellHttpModel $objData) : void
    {

    }
}