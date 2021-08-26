<?php

namespace Tabs\Media\Commands;

use App\Core\AppController;
use App\Utilities\MobileDetect;
use Entities\Cards\Models\CardModel;
use Entities\Cards\Models\CardPageModel;
use Entities\Cards\Models\CardPageRelModel;

class Tabs_SaveTabController extends AppController
{
    public $Description = "Save This Page";
    public $__CustomTitle = "";

    public function render(CardPageRelModel $objCardPageRel, CardPageModel $objCardPage, CardModel $objCard) : string
    {
        $detect = new MobileDetect();

        ob_start();

        $strViewPath = PublicData . "_ez/tabs/v1/views/save_tabView" . XT;

        if(!is_file($strViewPath))
        {
            return "";
        }

        require $strViewPath;

        $strContent = ob_get_clean();

        return $strContent;
    }
}
