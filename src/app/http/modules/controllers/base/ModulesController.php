<?php

namespace Entities\Modules\Classes\Base;

use App\Core\AppController;
use App\Utilities\Excell\ExcellHttpModel;
use Entities\Modules\Classes\Modules;
use Entities\Visitors\Classes\VisitorBrowser;
use Entities\Visitors\Models\VisitorBrowserModel;

class ModulesController extends AppController
{
    public function __construct($app)
    {
        $this->AppEntity = new Modules();
        parent::__construct($app);
    }

    protected function validateActiveSession(ExcellHttpModel $objData) : bool
    {
        if (empty($objData->Password)) { return false; }

        $strBrowserCookie = $objData->Password;
        $objBrowserCookieResult = (new VisitorBrowser())->getWhere(["browser_cookie" => $strBrowserCookie]);

        if ($objBrowserCookieResult->Result->Count === 0)
        {
            return false;
        }

        return true;
    }
}