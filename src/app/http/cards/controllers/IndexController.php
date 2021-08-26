<?php

namespace Entities\Cards\Controllers;

use App\Utilities\Excell\ExcellHttpModel;
use Entities\Cards\Classes\Cards;
use Entities\Cards\Classes\Base\CardController;
use Entities\Cards\Classes\CardPage;
use Entities\Cards\Classes\EzDigital\EzDigitalCardFactory;
use Entities\Cards\Components\Vue\CardMainApp;
use Entities\Cards\Components\Vue\CardWidget\ManageCardWidget;
use Entities\Cards\Components\Vue\MyCardMainApp;
use Entities\Media\Classes\Images;
use Entities\Users\Classes\Users;

class IndexController extends CardController
{
    public function index(ExcellHttpModel $objData) : bool
    {
        if($this->app->isAdminUrlRequest())
        {
            if($this->app->isUserLoggedIn())
            {
                if($this->app->strActivePortalBinding === "account")
                {
                    $this->RenderCardDashboard($objData);
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
        $vueApp = (new MyCardMainApp("vueApp"))
            ->setUriBase($objData->PathControllerBase)
            ->registerComponentAbstracts([
                ManageCardWidget::getStaticId() => ManageCardWidget::getStaticUriAbstract(),
            ]);

        (new Cards())->renderApp(
            "user.view_my_cards",
            $this->app->strAssignedPortalTheme,
            $vueApp
        );
    }

    public function RenderCardAdminDashboard(ExcellHttpModel $objData) : void
    {
        $vueApp = (new CardMainApp("vueApp"))
            ->setUriBase($objData->PathControllerBase)
            ->registerComponentAbstracts([
                ManageCardWidget::getStaticId() => ManageCardWidget::getStaticUriAbstract(),
            ]);

        (new Cards())->renderApp(
            "admin.admin_view_all_cards_new",
            $this->app->strAssignedPortalTheme,
            $vueApp
        );
    }

    public function RenderCardOrWebsite(ExcellHttpModel $objData, $myHub = false) : bool
    {
        if (!empty($objData->Uri[0]))
        {
            $ezDigitalFactory = new EzDigitalCardFactory($objData, $this->app);

            if ($myHub === false && !$ezDigitalFactory->process($objData))
            {
                if (empty($objData->Params[0]))
                {
                    return false;
                }

                $objCardResult = (new Cards())->getById($objData->Params[0]);

                if ($objCardResult->Result->Success === true)
                {
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
                    $lstImagesFromUser = (new Images())->getWhere([["user_id", "=", $objUser->user_id], "AND", ["image_class", "!=", "user-avatar"]])->Data;

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
                    $lstLibraryTabs = (new CardPage())->getFks()->getRelations(['card_count'])->getWhere([["user_id", "=", $objUser->user_id], "AND", ["library_tab", "=", true]])->Data;
                    $lstLibraryTabs->ConvertDatesToFormat("m/d/Y");

                    (new Cards())->renderAppPage("widget_library", $this->app->strAssignedPortalTheme, [
                        "lstLibraryTabs" => $lstLibraryTabs,
                    ]);
                }
                elseif($this->app->strActivePortalBinding === "account/admin")
                {
                    $lstLibraryTabs = (new CardPage())->getFks()->getWhere([["library_tab", "=", true]])->Data;
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

        $user = $users->getWhere(["password_reset_token" => $passwordResetRequestId])->Data->First();

        if ($user === null)
        {
            return $users->renderWebsitePage("public.password_reset_bad_token", $this->app->strAssignedWebsiteTheme);
        }

        return $users->renderWebsitePage("public.password_reset", $this->app->strAssignedWebsiteTheme, ["resetPasswordToken" => $passwordResetRequestId, "user" => $user ]);
    }

    public function healthCheck()
    {
        die('{"success":true}');
    }
}
