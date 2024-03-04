<?php

namespace Http\Cards\Controllers;

use Entities\Cards\Components\Vue\Maxtech\Groupwidget\ListMyGroupInactiveWidget;
use Entities\Cards\Components\Vue\Maxtech\Purchase\PurchaseGroupWidget;
use Entities\Cards\Components\Vue\Maxtech\Groupwidget\ListMyGroupWidget;
use Entities\Cards\Components\Vue\Maxtech\Groupwidget\ManageGroupWidget;
use Entities\Cards\Components\Vue\Maxtech\MyMaxGroupsApp;
use Entities\Cards\Components\Vue\Maxtech\MaxGroupsApp;
use App\Utilities\Excell\ExcellHttpModel;
use App\Website\Vue\Classes\VueProps;
use App\Website\Website;
use Entities\Cards\Components\Vue\Maxtech\Purchase\PurchaseSiteWidget;
use Entities\Cards\Classes\Cards;
use Entities\Cards\Components\Vue\Maxtech\MySiteMainApp;
use Entities\Cards\Components\Vue\Maxtech\SiteMainApp;
use Entities\Cards\Components\Vue\Maxtech\Sitewidget\ListMySiteInactiveWidget;
use Entities\Cards\Components\Vue\Maxtech\Sitewidget\ListMySiteWidget;
use Entities\Cards\Components\Vue\Maxtech\Sitewidget\ManageSiteWidget;
use Entities\Companies\Classes\Companies;
use Http\Cards\Controllers\Base\CardController;
use Entities\Cards\Classes\CardPage;
use Entities\Cards\Classes\EzDigital\ExcellCardFactory;
use Entities\Cards\Components\Vue\CardMainApp;
use Entities\Cards\Components\Vue\CardWidget\ManageCardWidget;
use Entities\Cards\Components\Vue\MyCardMainApp;
use Entities\Media\Classes\Images;
use Entities\Users\Classes\Users;

class IndexController extends CardController
{
    public function index(ExcellHttpModel $objData) : bool
    {
        if (!$this->app->isWhiteLabelAssigned()) {
            // If a domain is assigned that we have no knowledge of....
            (new Website($this->app))->showNotFoundPage();
        }

        if($this->app->isAdminUrlRequest())
        {
            if($this->app->isUserLoggedIn())
            {
                if($this->app->strActivePortalBinding === "account")
                {
                    switch ($this->AppEntity->strAliasName)
                    {
                        case "my-groups":
                            $this->myGroups($objData);
                            break;
                        case "max-groups":
                            $this->RenderMaxGroups($objData);
                            break;
                        default:
                            $this->RenderCardDashboard($objData);
                            break;
                    }


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

    public function mySites(ExcellHttpModel $objData) : bool
    {
        if (!$this->app->isAdminUrlRequest() || !$this->app->isUserLoggedIn() || $this->app->strActivePortalBinding !== "account") {
            $this->app->redirectToLogin();
            return false;
        }

        $vueApp = match ($objData->Uri[2] ?? "") {
            "purchase" => (new MySiteMainApp("vueApp"))
                ->setDefaultComponentId(PurchaseSiteWidget::getStaticId())->setDefaultComponentAction("view")
                ->setDefaultComponentProps([
                    new VueProps("productGroup", "string", "'card'"),
                    new VueProps("inModal", "boolean", "false"),
                    new VueProps("loggedInUserId", "number", $this->app->getActiveLoggedInUser()->user_id),
                ])
                ->setUriBase($objData->PathControllerBase),
            "inactive" => (new MySiteMainApp("vueApp"))
                ->setDefaultComponentId(ListMySiteInactiveWidget::getStaticId())->setDefaultComponentAction("view")
                ->setUriBase($objData->PathControllerBase)
                ->registerComponentAbstracts([
                    ManageSiteWidget::getStaticId() => ManageSiteWidget::getStaticUriAbstract(),
                ]),
            default => (new MySiteMainApp("vueApp"))
                ->setDefaultComponentId(ListMySiteWidget::getStaticId())->setDefaultComponentAction("view")
                ->setUriBase($objData->PathControllerBase)
                ->registerComponentAbstracts([
                    ManageSiteWidget::getStaticId() => ManageSiteWidget::getStaticUriAbstract(),
                ]),
        };

        (new Cards())->renderApp(
            "admin.admin_view_all_cards",
            $this->app->strAssignedPortalTheme,
            $vueApp
        );
        return true;
    }

    public function myGroups(ExcellHttpModel $objData) : bool
    {
        if (!$this->app->isAdminUrlRequest() || !$this->app->isUserLoggedIn() || $this->app->strActivePortalBinding !== "account") {
            $this->app->redirectToLogin();
            return false;
        }

        $vueApp = match ($objData->Uri[2]) {
            "purchase" => (new MyMaxGroupsApp("vueApp"))
                ->setDefaultComponentId(PurchaseGroupWidget::getStaticId())->setDefaultComponentAction("view")
                ->setDefaultComponentProps([
                    new VueProps("productGroup", "string", "'group'"),
                    new VueProps("inModal", "boolean", "false"),
                    new VueProps("loggedInUserId", "number", $this->app->getActiveLoggedInUser()->user_id),
                ])
                ->setUriBase($objData->PathControllerBase),
            "inactive" => (new MyMaxGroupsApp("vueApp"))
                ->setDefaultComponentId(ListMyGroupInactiveWidget::getStaticId())->setDefaultComponentAction("view")
                ->setUriBase($objData->PathControllerBase)
                ->registerComponentAbstracts([
                    ManageGroupWidget::getStaticId() => ManageGroupWidget::getStaticUriAbstract(),
                ]),
            default => (new MyMaxGroupsApp("vueApp"))
                ->setDefaultComponentId(ListMyGroupWidget::getStaticId())->setDefaultComponentAction("view")
                ->setUriBase($objData->PathControllerBase)
                ->registerComponentAbstracts([
                    ManageGroupWidget::getStaticId() => ManageGroupWidget::getStaticUriAbstract(),
                ]),
        };

        (new Cards())->renderApp(
            "user.view_my_groups",
            $this->app->strAssignedPortalTheme,
            $vueApp
        );
        return true;
    }

    public function myhub(ExcellHttpModel $objData) : bool
    {
        if(!$this->app->isPublicWebsite())
        {
            $this->app->executeUrlRedirect(getFullPublicUrl() . "/myhub" . ($objData->OriginalUriAndParams !== "" ? ("?". $objData->OriginalUriAndParams) : ""));
        }

        return $this->RenderCardOrWebsite($objData, true);
    }

    public function RenderCardDashboard(ExcellHttpModel $objData, $strApproach = "list") : void
    {

        $vueApp = match ($this->app->objCustomPlatform->getApplicationType()) {
            Companies::APP_TYPE_MAXTECH => (new MySiteMainApp("vueApp"))
                ->setUriBase($objData->PathControllerBase)
                ->registerComponentAbstracts([
                    ManageSiteWidget::getStaticId() => ManageSiteWidget::getStaticUriAbstract(),
                ]),
            default => (new MySiteMainApp("vueApp"))
                ->setDefaultComponentId(ListMySiteWidget::getStaticId())->setDefaultComponentAction("view")
                ->setUriBase($objData->PathControllerBase)
                ->registerComponentAbstracts([
                    ManageSiteWidget::getStaticId() => ManageSiteWidget::getStaticUriAbstract(),
                ]),
        };

        (new Cards())->renderApp(
            "user.view_my_cards",
            $this->app->strAssignedPortalTheme,
            $vueApp
        );
    }

    public function RenderMaxGroups(ExcellHttpModel $objData, $strApproach = "list") : void
    {
        $vueApp = (new MaxGroupsApp("vueApp"))
            ->setUriBase($objData->PathControllerBase)
            ->registerComponentAbstracts([
                ManageSiteWidget::getStaticId() => ManageSiteWidget::getStaticUriAbstract(),
            ]);

        (new Cards())->renderApp(
            "admin.view_max_groups",
            $this->app->strAssignedPortalTheme,
            $vueApp
        );
    }

    public function RenderCardAdminDashboard(ExcellHttpModel $objData) : void
    {
        $vueApp = match ($this->app->objCustomPlatform->getApplicationType()) {
            Companies::APP_TYPE_MAXTECH => (new SiteMainApp("vueApp"))
                ->setUriBase($objData->PathControllerBase)
                ->registerComponentAbstracts([
                    ManageSiteWidget::getStaticId() => ManageSiteWidget::getStaticUriAbstract(),
                ]),
            default => (new CardMainApp("vueApp"))
                ->setUriBase($objData->PathControllerBase)
                ->registerComponentAbstracts([
                    ManageCardWidget::getStaticId() => ManageCardWidget::getStaticUriAbstract(),
                ]),
        };

        (new Cards())->renderApp(
            "admin.admin_view_all_cards",
            $this->app->strAssignedPortalTheme,
            $vueApp
        );
    }

    public function RenderCardOrWebsite(ExcellHttpModel $objData, $myHub = false) : bool
    {
        if (
            (!empty($objData->Uri[0]) ||
            $this->app->getActiveDomain()->getType() !== "app") &&
            !in_array($objData->Uri[0] ?? "", ["api", "process", "module-widget"])
        )
        {
            $ezDigitalFactory = new ExcellCardFactory($this->app, $objData, new Cards());

            if ($myHub === false && !$ezDigitalFactory->process()) {
                if (empty($objData->Params[0])) {
                    return false;
                }

                $objCardResult = (new Cards())->getById($objData->Params[0]);

                if ($objCardResult->result->Success === true) {
                    $this->app->executeUrlRedirect(getFullUrl() . "/". $objData->Params[0]);
                }

                return false;
            }

            if ($ezDigitalFactory->render($myHub))
            {
                return true;
            }
        }

        return false;
    }

    public function imageLibrary(ExcellHttpModel $objData) : bool
    {
        if($this->app->isAdminUrlRequest())
        {
            if($this->app->isUserLoggedIn())
            {
                if($this->app->strActivePortalBinding === "account")
                {
                    $objUser = $this->app->getActiveLoggedInUser();
                    $lstImagesFromUser = (new Images())->getWhere([["user_id", "=", $objUser->user_id], "AND", ["image_class", "!=", "user-avatar"]])->getData();

                    $lstImagesFromUser->ConvertDatesToFormat("m/d/Y");

                    (new Cards())->renderAppPage("image_library", $this->app->strAssignedPortalTheme, [
                        "lstImagesFromUser" => $lstImagesFromUser,
                    ]);
                }

                $this->app->redirectToLogin();
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

        return false;
    }

    public function videoLibrary(ExcellHttpModel $objData) : bool
    {
        (new Cards())->renderAppPage("video_library", $this->app->strAssignedPortalTheme);
    }

    public function widgetLibrary(ExcellHttpModel $objData) : bool
    {
        if($this->app->isAdminUrlRequest())
        {
            if($this->app->isUserLoggedIn())
            {
                if($this->app->strActivePortalBinding === "account")
                {

                    $objUser = $this->app->getActiveLoggedInUser();
                    $lstLibraryTabs = (new CardPage())->getFks()->getRelations(['card_count'])->getWhere([["user_id", "=", $objUser->user_id], "AND", ["library_tab", "=", true]])->getData();
                    $lstLibraryTabs->ConvertDatesToFormat("m/d/Y");

                    (new Cards())->renderAppPage("widget_library", $this->app->strAssignedPortalTheme, [
                        "lstLibraryTabs" => $lstLibraryTabs,
                    ]);
                }
                elseif($this->app->strActivePortalBinding === "account/admin")
                {
                    $lstLibraryTabs = (new CardPage())->getFks()->getWhere([["library_tab", "=", true]])->getData();
                    $lstLibraryTabs->ConvertDatesToFormat("m/d/Y");

                    (new Cards())->renderAppPage("admin.admin_widget_library", $this->app->strAssignedPortalTheme, [
                        "lstLibraryTabs" => $lstLibraryTabs,
                    ]);
                }

                $this->app->redirectToLogin();
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

        return false;


    }

    public function socialMediaLibrary(ExcellHttpModel $objData) : bool
    {
        (new Cards())->renderAppPage("social_media_library", $this->app->strAssignedPortalTheme);
    }

    public function help(ExcellHttpModel $objData): bool
    {
        if( !$this->app->isAuthorizedAdminUrlRequest())
        {
            $this->app->redirectToLogin();
        }

        (new Cards())->renderAppPage("help", $this->app->strAssignedPortalTheme);
    }

    public function qrCodeRouting(ExcellHttpModel $objData) : bool
    {
        $intCardId = $objData->Data->Params["id"];
        $strVistiorActivityGuid = urldecode($objData->Data->Params["guid"]);

        // Load Visitor Activity

        $this->app->executeUrlRedirect(getFullUrl() . "/" . $intCardId);
    }

    public function resetYourPassword(ExcellHttpModel $objData)
    {
        $users = new Users();
        $passwordResetRequestId = $objData->Uri[1];

        if (!$this->validate(["token" => $passwordResetRequestId], [
            "token" => "required|uuid",
        ]))
        {
            return $users->renderWebsitePage("public.password_reset_bad_token", $this->app->strAssignedWebsiteTheme);
        }

        $user = $users->getWhere(["password_reset_token" => $passwordResetRequestId])->getData()->first();

        if ($user === null)
        {
            return $users->renderWebsitePage("public.password_reset_bad_token", $this->app->strAssignedWebsiteTheme);
        }

        return $users->renderWebsitePage("public.password_reset", $this->app->strAssignedWebsiteTheme, ["resetPasswordToken" => $passwordResetRequestId, "user" => $user ]);
    }

    public function healthCheck()
    {
        die('{"Success":true}');
    }
}
