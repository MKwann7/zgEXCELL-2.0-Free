<?php

use App\Core\AppController;
use Entities\Cards\Models\CardModel;
use Entities\Cards\Models\CardPageModel;
use Entities\Cards\Models\CardPageRelModel;

class Tabs_CognitoTabController extends AppController
{
    public $Description = "Cognito Page";

    public $_ThisIsNew = true;
    public $_ShowFullName = true;
    public $_ShowTitle = false;
    public $_ShowBusinessName = false;
    public $_ShowPrimaryNumber = true;
    public $_ShowPrimaryEmail = true;
    public $_ShowPrimaryAddress = false;
    public $_ShowFacebookPage = false;

    public function render(CardPageRelModel $objCardPageRel, CardPageModel $objCardPage, CardModel $objCard) : string
    {
        return "Test";
    }
}
