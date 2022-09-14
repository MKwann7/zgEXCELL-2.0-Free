<?php

use App\Core\AppController;
use App\Utilities\MobileDetect;
use Entities\Cards\Models\CardModel;
use Entities\Cards\Models\CardPageModel;
use Entities\Cards\Models\CardPageRelModel;

class Tabs_ContactInfoTabController extends AppController
{
    public $Description = "Contact Info";
    public $_ThisIsNew = true;
    public $_ShowFullName = true;
    public $_ShowTitle = false;
    public $_ShowBusinessName = false;
    public $vShowPrimaryNumber = true;
    public $_ShowPrimaryEmail = true;
    public $_ShowPrimaryAddress = false;
    public $_ShowFacebookPage = false;

    public function render(CardPageRelModel $objCardPageRel, CardPageModel $objCardPage, CardModel $objCard) : string
    {
        $detect = new MobileDetect();

        ob_start();

        $strViewPath = PUBLIC_DATA . "_ez/tabs/v1/views/contact_info_tabView" . XT;

        if(!is_file($strViewPath))
        {
            return "";
        }

        $strUserAddress = $objCard->Addresses->first()->address_1 ?? "";
        if(!empty($objCard->Addresses->first()->address_2)) { $strUserAddress .= "<br>" . $objCard->Addresses->first()->address_2 ?? ""; }
        if(!empty($objCard->Addresses->first()->address_3)) { $strUserAddress .= "<br>" . $objCard->Addresses->first()->address_3 ?? ""; }
        if ($strUserAddress !== "") { $strUserAddress .= "<br>"; }
        $strUserAddress .= $objCard->Addresses->first()->city ?? "";
        if ($objCard->Addresses->first()->city !== "" && $objCard->Addresses->first()->state !== "") { $strUserAddress .= ", "; }
        $strUserAddress .= $objCard->Addresses->first()->state ?? "";
        if ($objCard->Addresses->first()->state !== "" && $objCard->Addresses->first()->zip !== "") { $strUserAddress .= " "; }
        $strUserAddress .= $objCard->Addresses->first()->zip ?? "";

        require $strViewPath;

        $strContent = ob_get_clean();

        return $strContent;
    }
}
