<?php

namespace Http\Tasks\Controllers;

use App\Utilities\Database;
use App\Utilities\Excell\ExcellDatabaseModel;
use App\Utilities\Excell\ExcellHttpModel;
use App\Utilities\Http\Http;
use App\Utilities\Transaction\ExcellTransaction;
use Entities\Cards\Classes\Cards;
use Entities\Cards\Classes\CardConnections;
use Entities\Cards\Classes\CardRels;
use Entities\Cards\Classes\CardPageRels;
use Entities\Cards\Classes\CardPage;
use Entities\Cards\Models\CardConnectionModel;
use Entities\Cards\Models\CardModel;
use Entities\Cards\Models\CardPageModel;
use Entities\Cards\Models\CardPageRelModel;
use Entities\Media\Classes\Images;
use Entities\Mobiniti\Models\MobinitiContactModel;
use Http\Tasks\Controllers\Base\TaskController;
use Entities\Users\Classes\Connections;
use Entities\Users\Classes\UserAddress;
use Entities\Users\Classes\UserClass;
use Entities\Users\Classes\Users;
use Entities\Users\Models\UserAddressModel;
use Entities\Users\Models\UserClassModel;
use stdClass;
use Vendors\Mobiniti\Main\V100\Classes\MobinitiContactsApiModule;

class IndexController extends TaskController
{
    public function testIpAddress() : bool
    {
        $headers = apache_request_headers();
        dump($headers);
        dd($_SERVER);
    }

    public function index(ExcellHttpModel $objData) : bool
    {
        if(!$this->app->isAuthorizedAdminUrlRequest())
        {
            $this->app->redirectToLogin();
        }

        $this->AppEntity->renderAppPage("view_all_tasks", $this->app->strAssignedPortalTheme,  [
            "objTemplateCards" => [],
        ]);
    }

    public function SaveShareTabsOnCardsWithoutOne(ExcellHttpModel $objData) : bool
    {
        ini_set('memory_limit', '-1');
        set_time_limit(300);

        $objCardPageRelDataResult = (new CardPageRels())->getWhere(["card_tab_id" => 193854]);

        if ($objCardPageRelDataResult->result->Count === 0)
        {
            dd("No card_tab_id's of 193854 where found.");
        }

        $arShareSaveTabsCardIds = $objCardPageRelDataResult->getData()->FieldsToArray(["card_id"]);
        $colCardsWithoutShareSaveTabs = (new Cards())->getWhere(["card_id", "NOT IN", $arShareSaveTabsCardIds]);

        foreach($colCardsWithoutShareSaveTabs->data as $currCard)
        {
            echo $currCard->card_id . PHP_EOL;
            continue;

//            $objCardPage = new CardPageRelModel();
//            $objCardPage->card_tab_id = 193854;
//            $objCardPage->card_id = $currCard->card_id;
//            $objCardPage->user_id = $currCard->owner_id;
//            $objCardPage->rel_sort_order = 1;
//            $objCardPage->rel_visibility = 1;
//            $objCardPage->card_tab_rel_type = "mirror";
//
//            $objNewCardPageRelResult = (new CardPageRelsModule())->getFks()->CreateNew($objCardPage);
        }

        dd("->DONE!");
    }

    public function TurnOnAllSaveShareTabs(ExcellHttpModel $objData) : bool
    {
        ini_set('memory_limit', '-1');
        set_time_limit(300);

        $pageLimit = $objData->Data->Params["count"] ?? 5;
        $pageOffset = (($objData->Data->Params["offset"] ?? 1 )-1) * $pageLimit;

        $objCardPageRelDataResult = (new CardPageRels())->getWhere(["card_tab_id" => 193854, "rel_visibility" => false]);

        dump($objCardPageRelDataResult->result);

        $arCardsHiddenSaveShareTabs = [];
        $arRevisedCardsWithDuplicateSaveShareTabs = [];

        foreach($objCardPageRelDataResult->data as $currCardPageRel)
        {
            if ($currCardPageRel->rel_visibility == false)
            {
                $currCardPageRel->rel_visibility = EXCELL_TRUE;
                (new CardPageRels())->update($currCardPageRel);
            }

            $arCardsHiddenSaveShareTabs[] = $currCardPageRel->card_tab_rel_id;
        }

        ksort($arCardsHiddenSaveShareTabs);

        echo("DONE! COUNT = " . COUNT($arCardsHiddenSaveShareTabs));

        dd($arCardsHiddenSaveShareTabs);
    }

    public function CheckSaveShareTabsPosition(ExcellHttpModel $objData) : bool
    {
        ini_set('memory_limit', '-1');
        set_time_limit(300);

        $pageLimit = $objData->Data->Params["count"] ?? 5;
        $pageOffset = (($objData->Data->Params["offset"] ?? 1 )-1) * $pageLimit;

        $objCardPageRelDataResult = (new CardPageRels())->getWhere(["card_tab_id" => 193854],[$pageOffset, $pageLimit]);

        $arCardsHiddenSaveShareTabs = [];
        $arRevisedCardsWithDuplicateSaveShareTabs = [];

        foreach($objCardPageRelDataResult->data as $currCardPageRel)
        {
            $arCardsHiddenSaveShareTabs[$currCardPageRel->rel_sort_order]++;
        }

        ksort($arCardsHiddenSaveShareTabs);

        echo("DONE! COUNT = " . COUNT($arCardsHiddenSaveShareTabs));

        dd($arCardsHiddenSaveShareTabs);
    }

    public function CheckSaveShareTabsVisibility(ExcellHttpModel $objData) : void
    {
        ini_set('memory_limit', '-1');
        set_time_limit(300);

        $pageLimit = $objData->Data->Params["count"] ?? 5;
        $pageOffset = (($objData->Data->Params["offset"] ?? 1 )-1) * $pageLimit;

        $objCardPageRelDataResult = (new CardPageRels())->getWhere(["card_tab_id" => 193854],[$pageOffset, $pageLimit]);

        $arCardsHiddenSaveShareTabs = [];
        $arRevisedCardsWithDuplicateSaveShareTabs = [];

        foreach($objCardPageRelDataResult->data as $currCardPageRel)
        {
            if ($currCardPageRel->rel_visibility == 0)
            {
                $arCardsHiddenSaveShareTabs[] = $currCardPageRel->card_id;
            }
        }

        echo("DONE! COUNT = " . COUNT($arCardsHiddenSaveShareTabs));

        dd($arCardsHiddenSaveShareTabs);
    }

    public function FindDuplicateSaveShareTabs(ExcellHttpModel $objData) : void
    {
        ini_set('memory_limit', '-1');
        set_time_limit(300);

        $pageLimit = $objData->Data->Params["count"] ?? 5;
        $pageOffset = (($objData->Data->Params["offset"] ?? 1 )-1) * $pageLimit;

        $objCardPageRelDataResult = (new CardPageRels())->getWhere(["card_tab_id" => 193854]);

        $arCardsWithDuplicateSaveShareTabs = [];
        $arRevisedCardsWithDuplicateSaveShareTabs = [];

        foreach($objCardPageRelDataResult->data as $currCardPageRel)
        {
            $arCardsWithDuplicateSaveShareTabs[$currCardPageRel->card_id][] = $currCardPageRel->card_tab_rel_id;
        }

        $objCardPageRelsModule = new CardPageRels();

        foreach($arCardsWithDuplicateSaveShareTabs as $intCardId => $currCard)
        {
            if (count($currCard) === 4)
            {
                $arRevisedCardsWithDuplicateSaveShareTabs[] = $intCardId;
                $objCardPageRelsModule->deleteById($currCard[1]);
                $objCardPageRelsModule->deleteById($currCard[2]);
                $objCardPageRelsModule->deleteById($currCard[3]);
            }
            elseif (count($currCard) === 5)
            {
                $arRevisedCardsWithDuplicateSaveShareTabs[] = $intCardId;
                $objCardPageRelsModule->deleteById($currCard[1]);
                $objCardPageRelsModule->deleteById($currCard[2]);
                $objCardPageRelsModule->deleteById($currCard[3]);
                $objCardPageRelsModule->deleteById($currCard[4]);
            }
        }

        echo("DONE! COUNT = " . COUNT($arRevisedCardsWithDuplicateSaveShareTabs));

        dd($arRevisedCardsWithDuplicateSaveShareTabs);

        $objCardDataResult = (new Cards())->getWhere(null,[$pageOffset, $pageLimit]);
        $arCardsWithDuplicateSaveShareTabs = [];


        foreach($objCardDataResult->data as $currCard)
        {
            /** @var CardModel $currCard */
            $currCard->LoadCardPages();

            if (empty($currCard->Tabs))
            {
                continue;
            }

            $intDuplicateSaveShareCardCount = 0;

            foreach($currCard->Tabs as $currCardPage)
            {
                if ($currCardPage->card_tab_id !== 193854)
                {
                    continue;
                }

                $intDuplicateSaveShareCardCount++;

                if ($intDuplicateSaveShareCardCount > 1)
                {
                    $arCardsWithDuplicateSaveShareTabs[] = $currCard->card_id;
                }
            }
        }

        dd($arCardsWithDuplicateSaveShareTabs);
    }

    public function cloneCardConnections(ExcellHttpModel $objData) : bool
    {
        $objParams = $objData->Data->PostData;

        if (!$this->validate($objParams, [
            "source_card_id" => "required|integer",
            "destination_card_id" => "required|integer",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $intSourceCardId = (int) $objParams->source_card_id;
        $intDestinationCardId = (int) $objParams->destination_card_id;

        $intDestinationCardId = preg_replace("/((\r?\n)|(\r\n?))/", ',', $intDestinationCardId);
        $arDestinationCardIds = explode(',', $intDestinationCardId);

        $objCards = new Cards();
        $objSourceCardResult = $objCards->getWhere(["card_num" => $intSourceCardId]);

        if($objSourceCardResult->result->Count === 0)
        {
            return $this->renderReturnJson(false, null, "Source card {$intSourceCardId} was not found for cloning.");
        }

        foreach($arDestinationCardIds as $currDestinationCardId)
        {
            if ($intSourceCardId === $currDestinationCardId)
            {
                continue;
            }

            $objDestinationCardResult = $objCards->getWhere(["card_num" => $currDestinationCardId]);

            if($objDestinationCardResult->result->Count === 0)
            {
                return $this->renderReturnJson(false, null, "Destination card {$currDestinationCardId} was not found for cloning.");
            }

            $result = $objCards->CloneCardConnections($objSourceCardResult->getData()->first()->card_id, $objDestinationCardResult->getData()->first()->card_id);

            if ($result->result->Success === false)
            {
                return $this->renderReturnJson(false, null, $result->result->Message);

            }
        }

        return $this->renderReturnJson(true, null, "Card connnections cloned successfully.");
    }

    public function cloneCardPrimaryImage(ExcellHttpModel $objData) : bool
    {
        $objParams = $objData->Data->PostData;

        if (!$this->validate($objParams, [
            "source_card_id" => "required|integer",
            "destination_card_id" => "required|integer",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $intSourceCardId = (int) $objParams->source_card_id;
        $intDestinationCardId = (int) $objParams->destination_card_id;

        $intDestinationCardId = preg_replace("/((\r?\n)|(\r\n?))/", ',', $intDestinationCardId);
        $arDestinationCardIds = explode(',', $intDestinationCardId);

        $objCards = new Cards();
        $objSourceCardResult = $objCards->getWhere(["card_num" => $intSourceCardId]);

        if($objSourceCardResult->result->Count === 0)
        {
            return $this->renderReturnJson(false, null, "Source card {$intSourceCardId} was not found for cloning.");
        }

        foreach($arDestinationCardIds as $currDestinationCardId)
        {
            if ($intSourceCardId === $currDestinationCardId)
            {
                continue;
            }

            $objDestinationCardResult = $objCards->getWhere(["card_num" => $currDestinationCardId]);

            if($objDestinationCardResult->result->Count === 0)
            {
                return $this->renderReturnJson(false, null, "Destination card {$currDestinationCardId} was not found for cloning.");
            }

            $result1 = $objCards->CloneCardPrimaryImage($objSourceCardResult->getData()->first()->card_id, $objDestinationCardResult->getData()->first()->card_id);
            $result2 = $objCards->CloneCardSettings($objSourceCardResult->getData()->first()->card_id, $objDestinationCardResult->getData()->first()->card_id);

            if ($result->Result->Success === false)
            {
                return $this->renderReturnJson(false, null, $result->Result->Message);

            }
        }

        return $this->renderReturnJson(true, null, "Card primary image cloned successfully.");
    }

    public function copyAllCardPagesToCard(ExcellHttpModel $objData) : bool
    {
        ini_set('memory_limit', '-1');
        set_time_limit(300);

        $objParams = $objData->Data->PostData;

        if (!$this->validate($objParams, [
            "src" => "required|integer",
            "dst" => "required|integer",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $intSourceCardId = (int) $objParams->src;
        $intDestinationCardId = (int) $objParams->dst;

        $intDestinationCardId = preg_replace("/((\r?\n)|(\r\n?))/", ',', $intDestinationCardId);
        $arDestinationCardIds = explode(',', $intDestinationCardId);

        $objCards = new Cards();
        $objSourceCardResult = $objCards->getWhere(["card_num" => $intSourceCardId]);

        if($objSourceCardResult->result->Count === 0)
        {
            return $this->renderReturnJson(false, null, "Source card {$intSourceCardId} was not found for cloning.");
        }

        foreach($arDestinationCardIds as $currDestinationCardId)
        {
            if ($intSourceCardId === $currDestinationCardId)
            {
                continue;
            }

            $objDestinationCardResult = $objCards->getWhere(["card_num" => $currDestinationCardId]);

            if($objDestinationCardResult->result->Count === 0)
            {
                return $this->renderReturnJson(false, null, "Destination card {$currDestinationCardId} was not found for cloning.");
            }

            $objCards = new Cards();
            $result = $objCards->CloneCardPages($objSourceCardResult->getData()->first()->card_id, $objDestinationCardResult->getData()->first()->card_id, true, true);

            if ($result->result->Success === false)
            {
                return $this->renderReturnJson(false, null, $result->result->Message);

            }
        }

        return $this->renderReturnJson(true, null, "Card tabs copied successfully.");
    }

    public function GetNewTabsForCards(ExcellHttpModel $objData) : bool
    {
        ini_set('memory_limit', '-1');
        set_time_limit(300);

        $dbhost = "localhost";
        $dbname = "ezdigita_8ap98ewra";
        $dbpass = "ezT7tupvW2EZ9C23j92RZx";
        $dbuser = "root";

        $objOldDatabase = new ExcellDatabaseModel();
        $objOldDatabase->Host = $dbhost;
        $objOldDatabase->Database = $dbname;
        $objOldDatabase->Username = $dbuser;
        $objOldDatabase->Password = $dbpass;

        $objCardResult = (new Cards())->getWhere(["card_id", ">", "29421"],"card_id.DESC");

        foreach($objCardResult->data as $currCard)
        {
            $strGetCardPageQuery = "SELECT * FROM `tabs` WHERE customerId = {$currCard->card_num};";

            Database::setDbConnection($objOldDatabase);
            $lstV1CardPageResult = Database::getSimple($strGetCardPageQuery);

            if ($lstV1CardPageResult->result->Count === 0)
            {
                continue;
            }

            foreach ($lstV1CardPageResult->data as $currCardKey => $currCardPageData)
            {
                $objV2CardPageResult = (new CardPage())->getWhere(["old_card_tab_id" => $currCardPageData->id], 1);

                if ( $objV2CardPageResult->result->Count > 0)
                {
                    continue;
                }

                $objCardPage = new CardPageModel();
                $objCardPage->user_id = $currCard->owner_id;
                $objCardPage->company_id = $currCard->company_id;
                $objCardPage->division_id = $currCard->division_id;
                $objCardPage->card_tab_type_id = 1;
                $objCardPage->title = $currCardPageData->title;
                $objCardPage->content = base64_encode(Database::forceUtf8(html_entity_decode($currCardPageData->content)));
                $objCardPage->library_tab = false;
                $objCardPage->permanent = false;
                $objCardPage->order_number = $currCardPageData->orderNumber;
                $objCardPage->visibility = $currCardPageData->status == "On" ? true : false;
                $objCardPage->created_on = date("Y-m-d H:i:s");
                $objCardPage->created_by = 1001;
                $objCardPage->updated_by = 1001;
                $objCardPage->last_updated = date("Y-m-d H:i:s");

                $objNewCardPageResult = (new CardPage())->getFks()->createNew($objCardPage);

                if ($objNewCardPageResult->result->Success === false)
                {
                    $objJsonReturn = array(
                        "success" => false,
                        "message" => "We were unable to save this card tab: " .$objNewCardPageResult->result->Message
                    );

                    die(json_encode($objJsonReturn));
                }

                $objCardPageRel = new CardPageRelModel();
                $objCardPageRel->card_tab_id = $objNewCardPageResult->getData()->first()->card_tab_id;
                $objCardPageRel->card_id = $currCard->card_id;
                $objCardPageRel->user_id = $currCard->owner_id;
                $objCardPageRel->rel_sort_order = $currCardPageData->orderNumber;
                $objCardPageRel->rel_visibility = $currCardPageData->status == "On" ? true : false;
                $objCardPageRel->card_tab_rel_type = "default";

                $objNewCardPageRelResult = (new CardPageRels())->getFks()->createNew($objCardPageRel);

                if ($objNewCardPageRelResult->result->Success === false)
                {
                    $objJsonReturn = array(
                        "success" => false,
                        "message" => "We were unable to save this card tab rel: " .$objNewCardPageRelResult->result->Message
                    );

                    die(json_encode($objJsonReturn));
                }
            }
        }

        die("done");
    }

    public function AddOldCardIdToCardPages(ExcellHttpModel $objData) : bool
    {
        ini_set('memory_limit', '-1');
        set_time_limit(300);

        $objCardDataResult = (new Cards())->getAllRows();

        foreach ($objCardDataResult->data as $currCard)
        {
            $this->AddOldCardIntoCardPagesRoutine($currCard);
        }

        die("done");
    }

    public function AddOldCardIdToCardPagesByCardId(ExcellHttpModel $objData) : bool
    {
        $intV1CardId = $objData->Data->Params["card_num"];

        $this->AddOldCardIntoCardPagesRoutine($intV1CardId);

        die("done");
    }

    public function AddOldCardIntoCardPagesRoutine($intV1CardId) : void
    {
        ini_set('memory_limit', '-1');
        set_time_limit(300);

        $dbhost = "localhost";
        $dbname = "ezdigita_8ap98ewra";
        $dbpass = "ezT7tupvW2EZ9C23j92RZx";
        $dbuser = "root";

        $objOldDatabase = new ExcellDatabaseModel();
        $objOldDatabase->Host = $dbhost;
        $objOldDatabase->Database = $dbname;
        $objOldDatabase->Username = $dbuser;
        $objOldDatabase->Password = $dbpass;

        $objCardDataResult = (new Cards())->getWhere(["card_num" =>$intV1CardId]);

        foreach($objCardDataResult->data as $currCard)
        {
            $objV2Card = $objCardDataResult->getData()->first();
            /** @var CardModel $currCard */
            $currCard->LoadCardPages();

            if (empty($currCard->Tabs))
            {
                continue;
            }

            $strGetCardPageQuery = "SELECT * FROM `tabs` where customerId = {$objV2Card->card_num};";

            Database::setDbConnection($objOldDatabase);
            $lstV1CardPagesResult = Database::getSimple($strGetCardPageQuery);

            foreach($currCard->Tabs as $currCardPage)
            {
                if ($currCardPage->card_tab_rel_type != "default")
                {
                    continue;
                }

                $currCardPage->old_card_id = $objV2Card->card_num;

                $intTotalTabs = 0;

                if ($lstV1CardPagesResult->result->Count > 0)
                {
                    foreach($lstV1CardPagesResult->data as $currV1CardPage)
                    {
                        //echo strtolower($currV1CardPage->title) . " != " . strtolower($currCardPage->title) . PHP_EOL;
                        if (strtolower($currV1CardPage->title) == strtolower($currCardPage->title))
                        {
                            $currCardPage->old_card_tab_id = $currV1CardPage->id;
                            break;
                        }
                    }
                }

                $objUpateCardPageResult = (new CardPage())->update($currCardPage);
                //echo(" old_card_id = " . $currCardPage->old_card_id . " AND old_tab_id = ". $currCardPage->old_card_tab_id).PHP_EOL;
            }
        }
    }

    /* Copy Tabs and Images */
    public function CopyV1TabsToV2Card(ExcellHttpModel $objData) : bool
    {
        $intV1CardId = $objData->Data->Params["card_num"];
        $intCardPageCount = $objData->Data->Params["count"] ?? 25;

        $this->AddOldCardIntoCardPagesRoutine($intV1CardId);
        $this->CopyOldTabsToNewCardPages($intV1CardId, $intCardPageCount);
        $this->AssignMirrorTabs($intV1CardId);

        die('{"success":true,"message":"This processs successfully ran."}');
        die;
    }

    /* Update V1 Connection Values to V2 Card */
    public function InsertV1ConnectionValues(ExcellHttpModel $objData) : bool
    {
        $intV1CardId = $objData->Data->Params["card_num"];

        $this->UpdateV2ConnectionValuesFromV1Card($intV1CardId);

        die('{"success":true,"message":"This processs successfully ran."}');

        return true;
    }

    public function UpdateV2ConnectionValuesFromV1Card($intV1CardId): void
    {
        ini_set('memory_limit', '-1');
        set_time_limit(300);

        $dbhost = "localhost";
        $dbname = "ezdigita_8ap98ewra";
        $dbpass = "ezT7tupvW2EZ9C23j92RZx";
        $dbuser = "root";

        $objOldDatabase = new ExcellDatabaseModel();
        $objOldDatabase->Host = $dbhost;
        $objOldDatabase->Database = $dbname;
        $objOldDatabase->Username = $dbuser;
        $objOldDatabase->Password = $dbpass;

        $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

        $strGetCardConnectionQuery = "SELECT * FROM `customerConnection` WHERE customerId = ". $intV1CardId;

        Database::setDbConnection($objOldDatabase);
        $lstConnection = Database::getSimple($strGetCardConnectionQuery);

        if ($lstConnection->result->Count === 0)
        {
            return;
        }

        $objCardResult = (new Cards())->getWhere(["card_num" => $intV1CardId],1);

        $objCard = $objCardResult->getData()->first();

        foreach ($lstConnection->data as $currConnectionKey => $currConnectionData)
        {

            if ($objCardResult->result->Count === 0)
            {
                //echo "Can't find card for : {$currConnectionData->customerId}".PHP_EOL;
                continue;
            }

            $objConnectionValueCheck = (new Connections())->getWhere(["connection_value" => strtolower($currConnectionData->value), "user_id" => $objCard->owner_id]);

            if ( $objConnectionValueCheck->result->Count === 0)
            {
                if (empty($currConnectionData->value) || $currConnectionData->value ===  null)
                {
                    continue;
                }

                $intNewConnectionValue = $this->getV2ConnectionData($currConnectionData->connectionTypeId);

                $objNewConnectionValue = new ConnectionModel();

                $objNewConnectionValue->company_id = 0;
                $objNewConnectionValue->division_id = 0;
                $objNewConnectionValue->user_id = $objCard->owner_id;
                $objNewConnectionValue->connection_type_id = $intNewConnectionValue["NewConnectionTypeId"];
                $objNewConnectionValue->connection_value = strtolower($currConnectionData->value);
                $objNewConnectionValue->is_primary = 0;
                $objNewConnectionValue->connection_class = "user";

                $objConnectionCreationResult = (new Connections())->createNew($objNewConnectionValue);

                if ($objConnectionCreationResult->result->Success === false)
                {
                    //dd($objConnectionCreationResult->Result);
                }
            }
        }

        $strGetCardConnectionQuery = "SELECT id, iconOneId, iconTwoId, iconThreeId, iconFourId FROM `customers` where id = " . $intV1CardId;

        Database::setDbConnection($objOldDatabase);
        $lstV1Cards = Database::getSimple($strGetCardConnectionQuery);

        if ($lstV1Cards->result->Count === 0)
        {
            return;
        }

        foreach ($lstV1Cards->data as $currV1CardKey => $currV1CardData)
        {
            $objCardResult = (new Cards())->getWhere(["card_num" => $currV1CardData->id]);
            $objConnection[1] = $this->getV2ConnectionData($currV1CardData->iconOneId);
            $objConnection[2] = $this->getV2ConnectionData($currV1CardData->iconTwoId);
            $objConnection[3] = $this->getV2ConnectionData($currV1CardData->iconThreeId);
            $objConnection[4] = $this->getV2ConnectionData($currV1CardData->iconFourId);

            foreach($objConnection as $intConnectionIndex => $objConnectionData)
            {
                $objV2Connection = (new Connections())->getWhere(["connection_type_id" => $objConnectionData["NewConnectionTypeId"], "user_id" => $objCardResult->getData()->first()->owner_id]);

                if ( $objV2Connection->result->Count === 0)
                {
                    continue;
                }

                $objCardConnectionCheck = (new CardConnections())->getWhere(["card_id" => $objCard->card_id, "connection_id" => $objV2Connection->getData()->first()->connection_id, "display_order" => $intConnectionIndex],1);

                if ($objCardConnectionCheck->result->Count > 0)
                {
                    (new CardConnections())->deleteWhere(["card_id" => $objCard->card_id, "connection_id" => $objV2Connection->getData()->first()->connection_id, "display_order" => $intConnectionIndex]);
                }

                $objNewCardConnection = new CardConnectionModel();

                $objNewCardConnection->connection_id = $objV2Connection->getData()->first()->connection_id;
                $objNewCardConnection->card_id = $objCardResult->getData()->first()->card_id;
                $objNewCardConnection->status = "Active";
                $objNewCardConnection->action = $objConnectionData["CustomAction"];
                $objNewCardConnection->display_order = $intConnectionIndex;

                $objCardUpdateResult = (new CardConnections())->createNew($objNewCardConnection);

                if ($objCardUpdateResult->result->Success === false)
                {
                    dd($objCardUpdateResult->result);
                }
            }
        }
    }

    public function UpdateAllV2CardPageMediaServerUrls(ExcellHttpModel $objData) : bool
    {
        ini_set('memory_limit', '-1');
        set_time_limit(300);

        $lstV2CardsResult = (new Cards())->getAllRows();

        if ($lstV2CardsResult->result->Count === 0)
        {
            die('{"success":false,"message":"No V2 Cards Found."}');
        }

        $intCardCount = 0;

        foreach($lstV2CardsResult->data as $objV2Card)
        {
            /** @var CardModel $objV2Card */
            $objV2Card->LoadCardPages();

            if (empty($objV2Card->Tabs))
            {
                continue;
            }

            foreach($objV2Card->Tabs as $objV2CardPage)
            {
                $strContent = Database::forceUtf8(base64_decode($objV2CardPage->content));
                $strContent = str_replace("http://app.ezcardmedia.com","https://app.ezcardmedia.com", $strContent);
                $objV2CardPage->content = base64_encode($strContent);
                $result = (new CardPage())->update($objV2CardPage);
            }
            $intCardCount++;
        }

        die('{"success":true,"message":"This process successfully ran over '.$intCardCount.' cards."}');

        return true;
    }

    public function UpdateAllV2ConnectionValuesWithV1Data(ExcellHttpModel $objData) : bool
    {
        ini_set('memory_limit', '-1');
        set_time_limit(300);

        $lstV2CardsResult = (new Cards())->getAllRows();

        if ($lstV2CardsResult->result->Count === 0)
        {
            die('{"success":false,"message":"No V2 Cards Found."}');
        }

        $intCardCount = 0;

        foreach($lstV2CardsResult->data as $objV2Card)
        {
            $this->UpdateV2ConnectionValuesFromV1Card($objV2Card->card_num);
            $intCardCount++;
        }

        die('{"success":true,"message":"This processs successfully ran over '.$intCardCount.' cards."}');

        return true;
    }

    public function UpdateAllAffiliateCards(ExcellHttpModel $objData) : bool
    {
        $intAffiliateId = $objData->Data->Params["affiliate_id"];

        $lstCardsResult = (new Cards())->GetCardsByAffiliateId($intAffiliateId);

        if ($lstCardsResult->result->Count === 0)
        {
            die("No cards for this affiliate.");
        }

        dd($lstCardsResult->result);

        foreach($lstCardsResult->data as $currCard)
        {
            $this->CopyOldTabsToNewCardPages($currCard->card_id);
        }
    }

    public function CopyOldTabsToNewCardPages($intV1CardId, $intCardPageCount = 100) : bool
    {
        ini_set('memory_limit', '-1');
        set_time_limit(300);

        $dbhost = "localhost";
        $dbname = "ezdigita_8ap98ewra";
        $dbpass = "ezT7tupvW2EZ9C23j92RZx";
        $dbuser = "root";

        $objOldDatabase = new ExcellDatabaseModel();
        $objOldDatabase->Host = $dbhost;
        $objOldDatabase->Database = $dbname;
        $objOldDatabase->Username = $dbuser;
        $objOldDatabase->Password = $dbpass;

        $strGetCardConnectionQuery = "SELECT * FROM `customers` where id = {$intV1CardId}";

        Database::setDbConnection($objOldDatabase);
        $lstV1CardsResult = Database::getSimple($strGetCardConnectionQuery);

        if ($lstV1CardsResult->result->Count === 0)
        {
            die("No v1 card!");
        }

        $lstV1Card = $lstV1CardsResult->getData()->first();

        $objV2CardResult = (new Cards())->getWhere(["card_num" => $lstV1Card->id],1);

        if ($objV2CardResult->result->Count === 0)
        {
            die("No v2 card!");
        }

        $objV2Card = $objV2CardResult->getData()->first();

        $objV2Card->LoadFullCard();

        $strGetCardPageQuery = "SELECT * FROM `tabs` where customerId = {$objV2Card->card_num};";

        Database::setDbConnection($objOldDatabase);
        $lstV1CardPagesResult = Database::getSimple($strGetCardPageQuery);

        if ($lstV1CardPagesResult->result->Count === 0)
        {
            die("No v1 card tab for :" . $objV2Card->card_num. PHP_EOL);
        }

        $intTotalTabs = 0;

        foreach($lstV1CardPagesResult->data as $currV1CardPage)
        {
            if ($intCardPageCount == 0)
            {
                die("DONE with " . $intTotalTabs . " Tabs.");
            }

            $intV1CardPageId = $currV1CardPage->id;

            $objV2CardPageResult = (new CardPage())->getWhere(["old_card_tab_id" => $intV1CardPageId],1);

            if ($objV2CardPageResult->result->Count === 0)
            {
                // Create a new card tab.

                $objCardPage = new CardPageModel();
                $objCardPage->user_id = $objV2Card->owner_id;
                $objCardPage->company_id = $objV2Card->company_id;
                $objCardPage->division_id = $objV2Card->division_id;
                $objCardPage->card_tab_type_id = 1;
                $objCardPage->title = $currV1CardPage->title;
                $objCardPage->content = base64_encode(Database::forceUtf8(html_entity_decode($currV1CardPage->content)));
                $objCardPage->library_tab = false;
                $objCardPage->permanent = false;
                $objCardPage->order_number = $currV1CardPage->orderNumber;
                $objCardPage->visibility = $currV1CardPage->status == "On" ? true : false;
                $objCardPage->created_on = date("Y-m-d H:i:s");
                $objCardPage->created_by = 1001;
                $objCardPage->updated_by = 1001;
                $objCardPage->last_updated = date("Y-m-d H:i:s");
                $objCardPage->old_card_id = $currV1CardPage->customerId;
                $objCardPage->old_card_tab_id = $intV1CardPageId;

                $objNewCardPageResult = (new CardPage())->getFks()->createNew($objCardPage);

                if ($objNewCardPageResult->result->Success === false)
                {
                    $objJsonReturn = array(
                        "success" => false,
                        "message" => "We were unable to save this card tab: " .$objNewCardPageResult->result->Message
                    );

                    die(json_encode($objJsonReturn));
                }

                $objCardPageRel = new CardPageRelModel();
                $objCardPageRel->card_tab_id = $objNewCardPageResult->getData()->first()->card_tab_id;
                $objCardPageRel->card_id = $objV2Card->card_id;
                $objCardPageRel->user_id = $objV2Card->owner_id;
                $objCardPageRel->rel_sort_order = $currV1CardPage->orderNumber;
                $objCardPageRel->rel_visibility = $currV1CardPage->status == "On" ? true : false;
                $objCardPageRel->card_tab_rel_type = "default";

                $objNewCardPageRelResult = (new CardPageRels())->getFks()->createNew($objCardPageRel);

                if ($objNewCardPageRelResult->result->Success === false)
                {
                    $objJsonReturn = array(
                        "success" => false,
                        "message" => "We were unable to save this card tab rel: " .$objNewCardPageRelResult->result->Message
                    );

                    die(json_encode($objJsonReturn));
                }

                echo("Created: " . $objNewCardPageResult->getData()->first()->card_tab_id . " for card: " . $objV2Card->card_id . PHP_EOL);

                $this->ParseAndManageTabImage($objCardPage, $objV2Card);

                $intCardPageCount--;
                $intTotalTabs++;
                continue;
            }

            $objV2CardPage = $objV2CardPageResult->getData()->first();

            $objV2CardPage->user_id = $objV2Card->owner_id;
            $objV2CardPage->company_id = $objV2Card->company_id;
            $objV2CardPage->division_id = $objV2Card->division_id;
            $objV2CardPage->card_tab_type_id = 1;
            $objV2CardPage->title = $currV1CardPage->title;
            $objV2CardPage->content = base64_encode(Database::forceUtf8(html_entity_decode($currV1CardPage->content)));
            $objV2CardPage->library_tab = false;
            $objV2CardPage->permanent = false;
            $objV2CardPage->order_number = $currV1CardPage->orderNumber;
            $objV2CardPage->visibility = $currV1CardPage->status == "On" ? true : false;
            $objV2CardPage->old_card_id = $currV1CardPage->customerId;
            $objV2CardPage->old_card_tab_id = $intV1CardPageId;

            $objNewCardPageResult = (new CardPage())->update($objV2CardPage);

            if ($objNewCardPageResult->result->Count === 0)
            {
                die("Unable to Update Card :" . $intV1CardPageId. PHP_EOL);
            }

            //echo("Updated: " . $objV2CardPage->card_tab_id . " for card: " . $objV2Card->card_id . PHP_EOL);

            $this->ParseAndManageTabImage($objV2CardPage, $objV2Card);

            $intCardPageCount--;
            $intTotalTabs++;
        }

        return true;
    }

    protected function ParseAndManageTabImage(CardPageModel $objCardPage, CardModel $objV2Card) : void
    {
        $intUserId = $objCardPage->user_id;

        $strContent = Database::forceUtf8(base64_decode($objCardPage->content));

        $strContent = str_replace("src=\"../uploads/","src=\"https://ezcard.com/uploads/",$strContent);

        $arImagesFromTab = [];
        preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $strContent, $arImagesFromTab);

        if (empty($arImagesFromTab[0]) || !is_array($arImagesFromTab[0]) ||  count($arImagesFromTab[0]) === 0)
        {
            return;
        }

        $intProcessedImages = 0;

        foreach($arImagesFromTab[0] as $strTabUrl)
        {
            $arFileSplitOnPeriod = explode(".", $strTabUrl);
            $arFilePath = explode("/", $strTabUrl);
            $strFileExtension = mb_strtolower(end($arFileSplitOnPeriod));
            $strFileNameWithExtension = end($arFilePath);
            $strFileName = ucwords(str_replace([".","-","_"], " ", str_replace(".". $strFileExtension,"", str_replace("." . $strFileExtension, "",$strFileNameWithExtension))));

            if (strpos($strFileExtension, "?") !== false)
            {
                $arFileExtension = explode("?", $strFileExtension);
                $strFileExtension = $arFileExtension[0];
            }

            if (strpos($strFileExtension, "&") !== false)
            {
                $arFileExtension = explode("&", $strFileExtension);
                $strFileExtension = $arFileExtension[0];
            }

            if( strpos($strTabUrl, "ezcard.com") === false || strpos($strTabUrl, "app.ezcardmedia.com") !== false)
            {
                continue;
            }

            $strFileType = false;

            switch(strtolower($strFileExtension))
            {
                case 'jpg':
                case 'jpeg':
                case 'png':
                case 'bmp':
                case 'gif':
                    $strFileTyp = "image";
                    break;
                case 'doc':
                case 'docx':
                case 'pptx':
                case 'pdf':
                    $strFileTyp = "file";
                    break;
                case 'mp3':
                    $strFileTyp = "music";
                    break;
                default:
                    continue 2;
            }

            // check to see if exists in media server
            $objImageResult = (new Images())->getWhere(["title" => $strFileName, "entity_id" => $intUserId],1);

            $strLink = $this->UploadFileToImagesServer($strFileType, $strTabUrl, $intUserId, $strFileName, $intBatchCount);

            $strContent = str_replace($strTabUrl, $strLink, $strContent);

            $intProcessedImages++;

            $arFileTypes[$strFileExtension][] = $strFileExtension;
            $arFileTypeCounts[$strFileExtension] = count($arFileTypes[$strFileExtension]);
        }

        $objCardPage->content = base64_encode($strContent);
        $result = (new CardPage())->update($objCardPage);
    }

    public function MigrateTabImages(ExcellHttpModel $objData) : bool
    {
        ini_set('memory_limit', '-1');
        set_time_limit(300);

        $pageLimit = $objData->Data->Params["count"];
        $pageOffset = ($objData->Data->Params["offset"]-1) * $pageLimit;

        $lstV2CardPages = (new CardPage())->getWhere(null,[$pageOffset, $pageLimit]);

        if ($lstV2CardPages->result->Count === 0)
        {
            dd($lstV2CardPages);
        }

        $intBatchCount = 0;

        $arFileTypes = [];
        $arAllFileTypes = [];
        $arFileTypeCounts = [];

        foreach($lstV2CardPages->data as $intV2CardsIndex => $objCardPage)
        {
            $intUserId = $objCardPage->user_id;

            $strContent = Database::forceUtf8(base64_decode($objCardPage->content));

            $arImagesFromTab = [];
            preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $strContent, $arImagesFromTab);

            if (empty($arImagesFromTab[0]) || !is_array($arImagesFromTab[0]) ||  count($arImagesFromTab[0]) === 0)
            {
                continue;
            }

            $intProcessedImages = 0;

            foreach($arImagesFromTab[0] as $strTabUrl)
            {
                $arFileSplitOnPeriod = explode(".", $strTabUrl);
                $arFilePath = explode("/", $strTabUrl);
                $strFileExtension = mb_strtolower(end($arFileSplitOnPeriod));
                $strFileNameWithExtension = end($arFilePath);
                $strFileName = ucwords(str_replace([".","-","_"], " ", str_replace(".". $strFileExtension,"", str_replace("." . $strFileExtension, "",$strFileNameWithExtension))));

                if (strpos($strFileExtension, "?") !== false)
                {
                    $arFileExtension = explode("?", $strFileExtension);
                    $strFileExtension = $arFileExtension[0];
                }

                if (strpos($strFileExtension, "&") !== false)
                {
                    $arFileExtension = explode("&", $strFileExtension);
                    $strFileExtension = $arFileExtension[0];
                }

                if( strpos($strTabUrl, "ezcard.com") === false || strpos($strTabUrl, "app.ezcardmedia.com") !== false)
                {
                    continue;
                }

                $strFileType = false;

                switch(strtolower($strFileExtension))
                {
                    case 'jpg':
                    case 'jpeg':
                    case 'png':
                    case 'bmp':
                    case 'gif':
                        $strFileTyp = "image";
                        break;
                    case 'doc':
                    case 'docx':
                    case 'pptx':
                    case 'pdf':
                        $strFileTyp = "file";
                        break;
                    case 'mp3':
                        $strFileTyp = "music";
                        break;
                    default:
                        continue 2;
                }

                // check to see if exists in media server

                $result = $this->UploadFileToImagesServer($strFileType, $strTabUrl, $intUserId, $strFileName, $intBatchCount);

                $objResultBody = json_decode($result->body);

                $strContent = str_replace($strTabUrl, $objResultBody->link, $strContent);

                $intProcessedImages++;

                $arFileTypes[$strFileExtension][] = $strFileExtension;
                $arFileTypeCounts[$strFileExtension] = count($arFileTypes[$strFileExtension]);
            }

            if ($intProcessedImages > 0)
            {
                $objCardPage->content = base64_encode($strContent);

                $result = (new CardPage())->update($objCardPage);
            }

        }

        return true;
    }

    public function AssignMirrorTabs($intV1CardId) : bool
    {
        $objV2Card = (new Cards())->getWhere(["card_num" => $intV1CardId],1)->getData()->first();

        $objV2CardId = $objV2Card->card_id;

        $objV2Card->LoadCardPages();

        $duplicateCardPages = [];

        $intContactInfoCount = 0;
        $intHowToSaveThisCardCount = 0;
        $intShareThisCardCount = 0;

        $intContactInfoTabId = 0;
        $intHowToSaveThisCardPageId = 0;
        $intShareThisCardPageId = 0;

        foreach($objV2Card->Tabs as $currTabIndex => $currCardPage)
        {
            if ($currCardPage->title == "How To Save This Card")
            {
                $intHowToSaveThisCardPageId = $currCardPage->card_tab_id;
                $intHowToSaveThisCardCount++;
            }

            if ($currCardPage->title == "Contact Info")
            {
                $intContactInfoTabId = $currCardPage->card_tab_id;
                $intContactInfoCount++;
            }

            if ($currCardPage->title == "Share This Card")
            {
                $intShareThisCardPageId = $currCardPage->card_tab_id;
                $intShareThisCardCount++;
            }
        }

        if ($intHowToSaveThisCardCount === 1 && $intHowToSaveThisCardPageId !== 0)
        {
            $objCardPageRelResult = (new CardPageRels())->getWhere(["card_tab_id" => $intHowToSaveThisCardPageId], 1);
            $objCardPageRel = $objCardPageRelResult->getData()->first();

            $objCardPageRel->card_tab_id = 109614;
            $objCardPageRel->card_tab_rel_type = "mirror";

            (new CardPageRels())->update($objCardPageRel);
        }

        if ($intContactInfoCount === 1 && $intContactInfoTabId !== 0)
        {
            $objCardPageRelResult = (new CardPageRels())->getWhere(["card_tab_id" => $intContactInfoTabId], 1);
            $objCardPageRel = $objCardPageRelResult->getData()->first();

            $objCardPageRel->card_tab_id = 109617;
            $objCardPageRel->card_tab_rel_type = "mirror";

            (new CardPageRels())->update($objCardPageRel);
        }
        if ($intShareThisCardCount === 1 && $intShareThisCardPageId !== 0)
        {
            $objCardPageRelResult = (new CardPageRels())->getWhere(["card_tab_id" => $intShareThisCardPageId], 1);
            $objCardPageRel = $objCardPageRelResult->getData()->first();

            $objCardPageRel->card_tab_id = 109620;
            $objCardPageRel->card_tab_rel_type = "mirror";

            (new CardPageRels())->update($objCardPageRel);
        }

        return true;
    }

    public function FixdNonDuplicatePermanentTabs(ExcellHttpModel $objData) : bool
    {
        ini_set('memory_limit', '-1');
        set_time_limit(300);

        $objAllCards = (new Cards())->getWhere(null, "card_num.DESC")->getData();

        $duplicateCardPages = [];

        foreach($objAllCards as $intCardIndex => $currCardData)
        {
            $currCardData->LoadCardPages();

            $intContactInfoCount = 0;
            $intHowToSaveThisCardCount = 0;
            $intShareThisCardCount = 0;

            $intContactInfoTabId = 0;
            $intHowToSaveThisCardPageId = 0;
            $intShareThisCardPageId = 0;

            foreach($currCardData->Tabs as $currTabIndex => $currCardPage)
            {
                if ($currCardPage->title == "How To Save This Card")
                {
                    $intHowToSaveThisCardPageId = $currCardPage->card_tab_id;
                    $intHowToSaveThisCardCount++;
                }

                if ($currCardPage->title == "Contact Info")
                {
                    $intContactInfoTabId = $currCardPage->card_tab_id;
                    $intContactInfoCount++;
                }

                if ($currCardPage->title == "Share This Card")
                {
                    $intShareThisCardPageId = $currCardPage->card_tab_id;
                    $intShareThisCardCount++;
                }
            }

            if ($intHowToSaveThisCardCount === 1)
            {
                $duplicateCardPages["How To Save This Card"]["count"]++;
                $duplicateCardPages["How To Save This Card"]["tab_ids"][] = $intHowToSaveThisCardPageId;
            }

            if ($intContactInfoCount == 1)
            {
                $duplicateCardPages["Contact Info"]["count"]++;
                $duplicateCardPages["Contact Info"]["tab_ids"][] = $intContactInfoTabId;
            }
            if ($intShareThisCardCount === 1)
            {
                $duplicateCardPages["Share This Card"]["count"]++;
                $duplicateCardPages["Share This Card"]["tab_ids"][] = $intShareThisCardPageId;
            }
        }

        foreach($duplicateCardPages["How To Save This Card"]["tab_ids"] as $currCardId)
        {
            $objCardPageRelResult = (new CardPageRels())->getWhere(["card_tab_id" => $currCardId], 1);
            $objCardPageRel = $objCardPageRelResult->getData()->first();

            $objCardPageRel->card_tab_id = 109614;
            $objCardPageRel->card_tab_rel_type = "mirror";

            (new CardPageRels())->update($objCardPageRel);
        }

        foreach($duplicateCardPages["Contact Info"]["tab_ids"] as $currCardId)
        {
            $objCardPageRelResult = (new CardPageRels())->getWhere(["card_tab_id" => $currCardId], 1);
            $objCardPageRel = $objCardPageRelResult->getData()->first();

            $objCardPageRel->card_tab_id = 109617;
            $objCardPageRel->card_tab_rel_type = "mirror";

            (new CardPageRels())->update($objCardPageRel);
        }

        foreach($duplicateCardPages["Share This Card"]["tab_ids"] as $currCardId)
        {
            $objCardPageRelResult = (new CardPageRels())->getWhere(["card_tab_id" => $currCardId], 1);
            $objCardPageRel = $objCardPageRelResult->getData()->first();

            $objCardPageRel->card_tab_id = 109620;
            $objCardPageRel->card_tab_rel_type = "mirror";

            (new CardPageRels())->update($objCardPageRel);
        }

        print_r($duplicateCardPages);
        die;
    }

    public function RegisterAddressesFromOldCards(ExcellHttpModel $objData) : bool
    {
        ini_set('memory_limit', '-1');
        set_time_limit(300);

        $dbhost = "localhost";
        $dbname = "ezdigita_8ap98ewra";
        $dbpass = "ezT7tupvW2EZ9C23j92RZx";
        $dbuser = "root";

        $objOldDatabase = new ExcellDatabaseModel();
        $objOldDatabase->Host = $dbhost;
        $objOldDatabase->Database = $dbname;
        $objOldDatabase->Username = $dbuser;
        $objOldDatabase->Password = $dbpass;

        $objCardResult = (new Cards())->getWhere(["card_id", ">", "29429"],"card_id.DESC");

        foreach($objCardResult->data as $currCard)
        {
            $strV1CardsQuery = "SELECT * FROM `customers` WHERE id = {$currCard->card_num};";

            Database::setDbConnection($objOldDatabase);
            $lstV1CardResult = Database::getSimple($strV1CardsQuery);

            if ($lstV1CardResult->result->Count === 0)
            {
                echo "No Old Card Found for: ". $currCard->card_num.PHP_EOL;
                continue;
            }

            $objUserResult = (new Users())->getById($currCard->owner_id);

            if ($objUserResult->result->Count === 0)
            {
                echo "No User Found for: ". $currCard->id.PHP_EOL;
                continue;
            }

            $objAddressCheck = (new UserAddress())->getWhere(["user_id" => $objUserResult->getData()->first()->user_id]);

            $blnIsPrimary = EXCELL_FALSE;

            if ($objAddressCheck->result->Count === 0)
            {
                $blnIsPrimary = EXCELL_TRUE;
            }

            $objV1Card = $lstV1CardResult->getData()->first();

            $objNewAddress = new UserAddressModel();

            $objNewAddress->user_id = $objUserResult->getData()->first()->user_id;
            $objNewAddress->display_name = "My Address";
            $objNewAddress->address_1 = $objV1Card->address1;
            $objNewAddress->address_2 = $objV1Card->address2;
            $objNewAddress->city = $objV1Card->city;
            $objNewAddress->state = $objV1Card->state;
            $objNewAddress->zip = $objV1Card->zipCode;
            $objNewAddress->country = $objV1Card->country;
            $objNewAddress->is_primary = $blnIsPrimary;
            $objNewAddress->type = "shipping";

            $objAddressResult = (new UserAddress())->createNew($objNewAddress);

            if ($objUserResult->result->Success === false)
            {
                dump($objAddressResult);
            }
        }

        die("done!");
    }

    public function FixTabs(ExcellHttpModel $objData) : bool
    {
        ini_set('memory_limit', '-1');
        set_time_limit(300);

        $pageLimit = $objData->Data->Params["count"];
        $pageOffset = ($objData->Data->Params["offset"]-1) * $pageLimit;

        $objCardPages = (new CardPage())->getWhere(null,[$pageOffset, $pageLimit]);

        foreach($objCardPages->data as $intCardPageIndex => $objCardPage)
        {
            $strContent = Database::forceUtf8(html_entity_decode(base64_decode($objCardPage->content)));

            //$strContent = str_replace("src=\"uploads/tinyMCEUploads/","src=\"https://ezcard.com/uploads/tinyMCEUploads/",$strContent);
            $strContent = str_replace("src=\"../uploads/","src=\"https://ezcard.com/uploads/",$strContent);
            $objCardPages->getData()->{$intCardPageIndex}->content = base64_encode($strContent);
            $objCardPageUpdateResult = (new CardPage())->update($objCardPages->getData()->{$intCardPageIndex});
        }

        return true;
    }

    public function FixConnectionValues(ExcellHttpModel $objData) : bool
    {
        $dbhost = "localhost";
        $dbname = "ezdigita_8ap98ewra";
        $dbpass = "ezT7tupvW2EZ9C23j92RZx";
        $dbuser = "root";

        $objOldDatabase = new ExcellDatabaseModel();
        $objOldDatabase->Host = $dbhost;
        $objOldDatabase->Database = $dbname;
        $objOldDatabase->Username = $dbuser;
        $objOldDatabase->Password = $dbpass;

        $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

        $strGetCardConnectionQuery = "SELECT * FROM `customerConnection` WHERE connectionTypeId = 4";

        Database::setDbConnection($objOldDatabase);
        $lstConnection = Database::getSimple($strGetCardConnectionQuery);

        if ($lstConnection->result->Count === 0)
        {
            return true;
        }

        foreach ($lstConnection->data as $currConnectionKey => $currConnectionData)
        {
            $strConnectionTypeId = $currConnectionData->connectionTypeId;
            $strConnectionValue  = $currConnectionData->value;

            if ( empty($strConnectionValue) )
            {
                continue;
            }

            $strConnectionValue = preg_replace('/[^0-9.]+/', '', $strConnectionValue);

            $strUpdateConnectionQuery = "UPDATE `customerConnection` SET value = '{$strConnectionValue}' WHERE customerConnectionId = {$currConnectionData->customerConnectionId} LIMIT 1";

            $lstConnection = Database::update($strUpdateConnectionQuery);
        }

        return true;
    }

    public function RegisterAllCardAffiliates(ExcellHttpModel $objData) : bool
    {

        $objCardRelResult = (new CardRels())->getWhere(["card_rel_type_id" => 9]);

        $arAffiliateIds = [];

        foreach($objCardRelResult->data as $currCardRel)
        {
            $arAffiliateIds[$currCardRel->user_id] = $currCardRel->user_id;
        }


        foreach($arAffiliateIds as $intAffiliateId)
        {
            $objUserClassCheck = (new UserClass())->getWhere(["user_id" => $intAffiliateId, "user_class_type_id" => 15]);

            if ($objUserClassCheck->result->Count > 0)
            {
                continue;
            }

            $objUserClassModel = new UserClassModel();

            $objUserClassModel->user_id = $intAffiliateId;
            $objUserClassModel->user_class_type_id = 15;

            $objUserClassCreation = (new UserClass())->createNew($objUserClassModel);

            if ($objUserClassCreation->result->Success === false)
            {
                echo "We were unable to create an affiliate user class for user: " . $intAffiliateId . PHP_EOL;
            }
        }

        die("done!");
    }

    public function UpdateCardDataMainColor(ExcellHttpModel $objData) : bool
    {
        ini_set('memory_limit', '-1');
        set_time_limit(300);

        $dbhost = "localhost";
        $dbname = "ezdigita_8ap98ewra";
        $dbpass = "ezT7tupvW2EZ9C23j92RZx";
        $dbuser = "root";

        $objOldDatabase = new ExcellDatabaseModel();
        $objOldDatabase->Host = $dbhost;
        $objOldDatabase->Database = $dbname;
        $objOldDatabase->Username = $dbuser;
        $objOldDatabase->Password = $dbpass;

        $strGetCardConnectionQuery = "SELECT id, colorSchemeRed, colorSchemeGreen, colorSchemeBlue, show_footer FROM `customers` where id > 9417";

        Database::setDbConnection($objOldDatabase);
        $lstV1Cards = Database::getSimple($strGetCardConnectionQuery);

        if ($lstV1Cards->result->Count === 0)
        {
            echo "no cards!";
            return true;
        }

        foreach ($lstV1Cards->data as $currV1CardKey => $currV1CardData)
        {
            $objV2CardCheck = (new Cards())->getWhere(["card_num" => $currV1CardData->id]);

            if ( $objV2CardCheck->result->Count === 0)
            {
                continue;
            }



            $objV2Card = $objV2CardCheck->getData()->first();

            if (empty($objV2Card->card_data)) {

                $objV2Card->card_data = new stdClass();
            }

            $objV2Card->card_data->style->card->color->main = $this->rgba2hex("{$currV1CardData->colorSchemeRed},{$currV1CardData->colorSchemeGreen},{$currV1CardData->colorSchemeBlue}");
            $objV2Card->card_data->style->card->toggle->footer = $currV1CardData->show_footer;

            $objCardUpdateResult = (new Cards())->update($objV2Card);

            if ($objCardUpdateResult->result->Success === false)
            {
                dd($objCardUpdateResult->result);
            }
        }

        return true;
    }

    public function UpdateCardFonts(ExcellHttpModel $objData) : bool
    {
        ini_set('memory_limit', '-1');
        set_time_limit(300);

        $dbhost = "localhost";
        $dbname = "ezdigita_8ap98ewra";
        $dbpass = "ezT7tupvW2EZ9C23j92RZx";
        $dbuser = "root";

        $objOldDatabase = new ExcellDatabaseModel();
        $objOldDatabase->Host = $dbhost;
        $objOldDatabase->Database = $dbname;
        $objOldDatabase->Username = $dbuser;
        $objOldDatabase->Password = $dbpass;

        $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

        $strGetCardConnectionQuery = "SELECT id, font FROM `customers` where id > 9417";

        Database::setDbConnection($objOldDatabase);
        $lstV1Cards = Database::getSimple($strGetCardConnectionQuery);

        if ($lstV1Cards->result->Count === 0)
        {
            return true;
        }

        foreach ($lstV1Cards->data as $currV1CardKey => $currV1CardData)
        {
            $objV2CardCheck = (new Cards())->getWhere(["card_num" => $currV1CardData->id]);

            if ( $objV2CardCheck->result->Count === 0)
            {
                continue;
            }

            $objV2Card = $objV2CardCheck->getData()->first();

            if (empty($objV2Card->card_data)) {

                $objV2Card->card_data = new stdClass();
            }

            $objV2Card->card_data->style->card->font->main = $currV1CardData->font;

            $objCardUpdateResult = (new Cards())->update($objV2Card);

            if ($objCardUpdateResult->result->Success === false)
            {
                dd($objCardUpdateResult->result);
            }
        }

        return true;
    }

    public function UpdateCardPageVisibility(ExcellHttpModel $objData) : bool
    {
        ini_set('memory_limit', '-1');
        set_time_limit(300);

        $dbhost = "localhost";
        $dbname = "ezdigita_8ap98ewra";
        $dbpass = "ezT7tupvW2EZ9C23j92RZx";
        $dbuser = "root";

        $objOldDatabase = new ExcellDatabaseModel();
        $objOldDatabase->Host = $dbhost;
        $objOldDatabase->Database = $dbname;
        $objOldDatabase->Username = $dbuser;
        $objOldDatabase->Password = $dbpass;

        $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

        $strGetCardConnectionQuery = "SELECT id, colorSchemeRed, colorSchemeGreen, colorSchemeBlue, show_footer FROM `customers` where id > 9417";

        Database::setDbConnection($objOldDatabase);
        $lstV1Cards = Database::getSimple($strGetCardConnectionQuery);

        if ($lstV1Cards->result->Count === 0)
        {
            dd($lstV1Cards);
            return true;
        }

        foreach ($lstV1Cards->data as $currV1CardKey => $currV1CardData)
        {
            $objV2CardCheck = (new Cards())->getWhere(["card_num" => $currV1CardData->id]);

            if ( $objV2CardCheck->result->Count === 0)
            {
                continue;
            }

            $objV2Card = $objV2CardCheck->getData()->first();
            $objV2Card->LoadCardPages();

            foreach($objV2Card->Tabs as $currCardPageIndex => $currCardPage)
            {
                $strGetCardPageQuery = "SELECT * FROM `tabs` where customerId = {$currV1CardData->id} and title = '{$currCardPage->title}'";

                Database::setDbConnection($objOldDatabase);
                $lstV1CardPage = Database::getSimple($strGetCardPageQuery);

                if ( $lstV1CardPage->result->Count === 0 || $lstV1CardPage->result->Count > 1)
                {
                    continue;
                }

                switch($currCardPage->card_tab_rel_type)
                {
                    case "mirror":
                        $objCardPageRel = (new CardPageRels())->getById($currCardPage->card_tab_rel_id)->getData()->first();
                        $objCardPageRel->rel_visibility = ( $lstV1CardPage->getData()->first()->status == "On" ) ? EXCELL_TRUE : EXCELL_FALSE;
                        (new CardPageRels())->update($objCardPageRel);
                        break;
                    default:
                        $currCardPage->visibility = ( $lstV1CardPage->getData()->first()->status == "On" ) ? EXCELL_TRUE : EXCELL_FALSE;
                        $result = (new CardPage())->update($currCardPage);
                        break;
                }
            }
        }

        return true;
    }

    public function UpdateCardConnections(ExcellHttpModel $objData) : bool
    {
        ini_set('memory_limit', '-1');
        set_time_limit(300);

        $dbhost = "localhost";
        $dbname = "ezdigita_8ap98ewra";
        $dbpass = "ezT7tupvW2EZ9C23j92RZx";
        $dbuser = "root";

        $objOldDatabase = new ExcellDatabaseModel();
        $objOldDatabase->Host = $dbhost;
        $objOldDatabase->Database = $dbname;
        $objOldDatabase->Username = $dbuser;
        $objOldDatabase->Password = $dbpass;

        $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

        $strGetCardConnectionQuery = "SELECT id, iconOneId, iconTwoId, iconThreeId, iconFourId FROM `customers` where id > 9417";

        Database::setDbConnection($objOldDatabase);
        $lstV1Cards = Database::getSimple($strGetCardConnectionQuery);

        if ($lstV1Cards->result->Count === 0)
        {
            return true;
        }

        foreach ($lstV1Cards->data as $currV1CardKey => $currV1CardData)
        {
            $objConnection[1] = $this->getV2ConnectionData($currV1CardData->iconOneId);
            $objConnection[2] = $this->getV2ConnectionData($currV1CardData->iconTwoId);
            $objConnection[3] = $this->getV2ConnectionData($currV1CardData->iconThreeId);
            $objConnection[4] = $this->getV2ConnectionData($currV1CardData->iconFourId);

            foreach($objConnection as $intConnectionIndex => $objConnectionData)
            {
                $objCardResult = (new Cards())->getWhere(["card_num" => $currV1CardData->id]);
                $objV2Connection = (new Connections())->getWhere(["connection_type_id" => $objConnectionData["NewConnectionTypeId"], "user_id" => $objCardResult->getData()->first()->owner_id]);

                if ( $objV2Connection->result->Count === 0)
                {
                    continue;
                }

                $objNewCardConnection = new CardConnectionModel();

                $objNewCardConnection->connection_id = $objV2Connection->getData()->first()->connection_id;
                $objNewCardConnection->card_id = $objCardResult->getData()->first()->card_id;
                $objNewCardConnection->status = "Active";
                $objNewCardConnection->action = $objConnectionData["CustomAction"];
                $objNewCardConnection->display_order = $intConnectionIndex;

                $objCardUpdateResult = (new CardConnections())->createNew($objNewCardConnection);

                if ($objCardUpdateResult->result->Success === false)
                {
                    dd($objCardUpdateResult->result);
                }
            }
        }

        return true;
    }

    public function MigrateMainImages(ExcellHttpModel $objData) : bool
    {
        ini_set('memory_limit', '-1');
        set_time_limit(300);

        $lstV2Cards = (new Cards())->getWhere(["card_num", "=", "1452"]);

        if ($lstV2Cards->result->Count === 0)
        {
            dd($lstV2Cards);
        }

        $intBatchCount = 0;

        foreach($lstV2Cards->data as $intV2CardsIndex => $objV2CardData)
        {
            $intEzCardId = $objV2CardData->card_id;
            $intOldEzCardNum = $objV2CardData->card_num;
            $lstCardImages = (new Images())->getWhere([["entity_name" => "card", "image_class" =>"main-image"], "AND", ["entity_id" => $intEzCardId]]);

            if ($lstCardImages->result->Count > 0)
            {
                echo("ALREADY DONE: " . $intEzCardId . PHP_EOL);
                continue;
            }

            $intBatchCount++;

            if ($intBatchCount === 1000)
            {
                die("Finished batch of {$intBatchCount} Cards.");
            }

            $strMainImagePath = "https://ezcard.com/ioffice/uploads/customers/" . $intOldEzCardNum . "/mainImage.jpg";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $strMainImagePath);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.1 Safari/537.11');
            $objMainImage = curl_exec($ch);
            $rescode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $arFilePath = explode(".", $strMainImagePath);
            $strFileExtension = end($arFilePath);
            $strTempFileNameAndPath = APP_STORAGE . '/uploads/'. sha1(microtime()) . "." . $strFileExtension;

            file_put_contents($strTempFileNameAndPath, $objMainImage);

            $strPostUrl = "https://app.ezcardmedia.com/upload-image/cards/" . $objV2CardData->card_id;
            $objHttp = new Http();
            $objFileForCurl = curl_file_create($strTempFileNameAndPath);
            $objHttpResponse = $objHttp->rawPost(
                $strPostUrl,
                ["file" => $objFileForCurl, "user_id" => $objV2CardData->owner_id, "image_class" => "main-image", "title" => "Main Image"]
            );
        }

        die("Done!");

        return true;
    }



    public function MigrateFavicons(ExcellHttpModel $objData) : bool
    {
        ini_set('memory_limit', '-1');
        set_time_limit(300);

        $lstV2Cards = (new Cards())->getAllRows();

        if ($lstV2Cards->result->Count === 0)
        {
            dd($lstV2Cards);
        }

        $intBatchCount = 0;

        foreach($lstV2Cards->data as $intV2CardsIndex => $objV2CardData)
        {
            $intEzCardId = $objV2CardData->card_id;
            $intOldEzCardNum = $objV2CardData->card_num;
            $lstCardImages = (new Images())->getWhere([["entity_name" => "card", "image_class" =>"favicon-image"], "AND", ["entity_id" => $intEzCardId]]);

            if ($lstCardImages->result->Count > 0)
            {
                //echo("ALREADY DONE: " . $intEzCardId . PHP_EOL);
                continue;
            }

            $lstCardExistingMainImage = APP_CORE . "uploads/cards/" . $intOldEzCardNum . "/mainImage.jpg";

            if (!is_file($lstCardExistingMainImage))
            {
                logText("MigrateV1MainImagesToFavicons.Error.log", "Card {$intEzCardId} does not have a main image.");
                continue;
            }

            $intBatchCount++;

            if ($intBatchCount === 1)
            {
                die("Finished batch of {$intBatchCount} Cards.");
            }

            echo $intEzCardId . " => " . $intOldEzCardNum . PHP_EOL;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $lstCardExistingMainImage->getData()->first()->url);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.1 Safari/537.11');
            $objMainImage = curl_exec($ch);
            $rescode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $arFilePath = explode(".", $lstCardExistingMainImage->getData()->first()->url);
            $strFileExtension = end($arFilePath);
            $strTempFileNameAndPath = APP_CORE . '/uploads/'. sha1(microtime()) . "." . $strFileExtension;

            file_put_contents($strTempFileNameAndPath, $objMainImage);

            try {
                $strPostUrl = "https://app.ezcardmedia.com/upload-image/cards/" . $intEzCardId;
                $objHttp = new Http();
                $objFileForCurl = curl_file_create($strTempFileNameAndPath);
                $objHttpRequest = $objHttp->newRawRequest(
                    "post",
                    $strPostUrl,
                    [
                        "file" => $objFileForCurl,
                        "entity_id" => $intEzCardId,
                        "user_id" => $objV2CardData->owner_id,
                        "image_class" => "favicon-image"
                    ]
                )
                    ->setOption(CURLOPT_CAINFO, '/etc/ssl/ca-bundle.crt')
                    ->setOption(CURLOPT_SSL_VERIFYPEER, false);

                $objHttpResponse = $objHttpRequest->send();
            } catch(\Exception $ex)
            {
                logText("MigrateV1MainImagesToFavicons.Error.log", "Card {$intEzCardId} failed to migrate its Favicon.");
                //unlink($strTempFileNameAndPath);
                //dd("fail");
            }
        }

        die("Done!");

        return true;
    }

    protected function getV2ConnectionData($strConnectionTypeId)
    {
        $intNewConnectionTypeId = 0;
        $strCustomAction = "link";

        switch($strConnectionTypeId)
        {
            case 2:
                $intNewConnectionTypeId = 3;
                $strCustomAction = "phone";
                break;
            case 3:
                $intNewConnectionTypeId = 4;
                $strCustomAction = "phone";
                break;
            case 4:
                $intNewConnectionTypeId = 1;
                $strCustomAction = "phone";
                break;
            case 5:
                $intNewConnectionTypeId = $strConnectionTypeId;
                $strCustomAction = "fax";
                break;
            case 6:
                $intNewConnectionTypeId = $strConnectionTypeId;
                $strCustomAction = "email";
                break;
            case 7:
            case 30:
            case 27:
            case 21:
                $intNewConnectionTypeId = 2;
                $strCustomAction = "link";
                break;
            case 22:
                $intNewConnectionTypeId = 8;
                $strCustomAction = "link";
                break;
            case 36:
                $strCustomAction = "sms";
                $intNewConnectionTypeId = 1;
                break;
            case 8:
            case 9:
            case 10:
            case 11:
            case 12:
            case 13:
            case 14:
            case 15:
            case 16:
            case 17:
            case 18:
            case 19:
            case 20:
                $intNewConnectionTypeId = $strConnectionTypeId - 1;
                $strCustomAction = "link";
                break;
        }

        return [
            "NewConnectionTypeId" => $intNewConnectionTypeId,
            "CustomAction" => $strCustomAction,
        ];
    }

    public function TestRgba(ExcellHttpModel $objData) : bool
    {
        $r = $objData->Data->Params["r"];
        $g = $objData->Data->Params["g"];
        $b = $objData->Data->Params["b"];

        $rr = sprintf("%02s", dechex($r));
        $gg = sprintf("%02s", dechex($g));
        $bb = sprintf("%02s", dechex($b));
        $aa = '';

        die(strtoupper("$aa$rr$gg$bb"));
    }

    protected function rgba2hex($string) : string
    {
        $rgba  = array();
        $hex   = '';
        $regex = '#\((([^()]+|(?R))*)\)#';
        if (preg_match_all($regex, $string ,$matches)) {
            $rgba = explode(',', implode(' ', $matches[1]));
        } else {
            $rgba = explode(',', $string);
        }

        $rr = sprintf("%02s", dechex($rgba['0']));
        $gg = sprintf("%02s", dechex($rgba['1']));
        $bb = sprintf("%02s", dechex($rgba['2']));
        $aa = '';

        if (array_key_exists('3', $rgba)) {
            $aa = dechex($rgba['3'] * 255);
        }

        return strtoupper("$aa$rr$gg$bb");
    }

    public function UpdateUserPassword(ExcellHttpModel $objData) : bool
    {
        $intUserId = $objData->Data->Params["user_id"];

        if (!empty($intUserId))
        {
            $objUserToUpdateResult = (new Users())->getById($intUserId);

            if ($objUserToUpdateResult->result->Count === 0)
            {
                die("Cannot find User By Id: " . $intUserId);
            }

            $objUser = $objUserToUpdateResult->getData()->first();

            $objUser->password = "secret2019";

            dd((new Users())->update($objUser));
        }
        else
        {
            $objUserToUpdateResult = (new Users())->getWhere(["password" => EXCELL_NULL]);

            if ($objUserToUpdateResult->result->Count === 0)
            {
                die("Cannot find any Users with Null password.");
            }

            foreach($objUserToUpdateResult->data as $currUser)
            {
                $currUser->password = "secret2019";

                (new Users())->update($currUser);
            }

            echo $objUserToUpdateResult->result->Count;
            die();
        }
    }

    public function FixCardIntegers(ExcellHttpModel $objData) : bool
    {
        ini_set('memory_limit', '-1');
        set_time_limit(3000);

        $intCardNum = $objData->Data->Params["card_num"] ?? null;

        $trnCardResult = new ExcellTransaction();

        if ($intCardNum === null)
        {
            $trnCardResult = (new Cards())->getAll(3000,1);
        }
        else
        {
            $trnCardResult = (new Cards())->getWhere(["card_num" => $intCardNum]);
        }

        if ($trnCardResult->result->Success === false || $trnCardResult->result->Count === 0)
        {
            die("unable to find card with number: " . $intCardNum);
        }

        foreach($trnCardResult->data as $currCard)
        {
            if (empty($currCard->card_data->style->tab->height))
            {
                continue;
            }

            if (empty($currCard->card_data->style->card->width))
            {
                continue;
            }

            $strCardPageHeight = $currCard->card_data->style->tab->height;
            $strCardWidth = $currCard->card_data->style->card->width;

            $strCardPageHeightCorrected = $this->RecursiveIntFixer($strCardPageHeight);
            $strCardWidthCorrected = $this->RecursiveIntFixer($strCardWidth);

            $currCard->card_data->style->tab->height = $strCardPageHeightCorrected;
            $currCard->card_data->style->card->width = $strCardWidthCorrected;

            (new Cards())->update($currCard);
        }

        dump($trnCardResult->result);
        dump($trnCardResult->getData()->first());

        return true;
    }

    public function FixCardMainColor(ExcellHttpModel $objData) : bool
    {
        ini_set('memory_limit', '-1');
        set_time_limit(3000);

        $intCardNum = $objData->Data->Params["card_num"] ?? null;

        $trnCardResult = new ExcellTransaction();

        if ($intCardNum === null)
        {
            $trnCardResult = (new Cards())->getAll(3000,1);
        }
        else
        {
            $trnCardResult = (new Cards())->getWhere(["card_num" => $intCardNum]);
        }

        if ($trnCardResult->result->Success === false || $trnCardResult->result->Count === 0)
        {
            die("unable to find card with number: " . $intCardNum);
        }

        foreach($trnCardResult->data as $currCard)
        {
            if (empty($currCard->card_data->style->card->color->main))
            {
                continue;
            }

            $strCardMainColor = $currCard->card_data->style->card->color->main;

            $strCardMainColorCorrected = $this->RecursiveHexColorFixer($strCardMainColor);

            $currCard->card_data->style->card->color->main = $strCardMainColorCorrected;

            (new Cards())->update($currCard);
        }

        dump($trnCardResult->result);
        dump($trnCardResult->getData()->first());

        return true;
    }

    public function RecursiveIntFixer($intValue) : string
    {
        if ( isInteger($intValue) || $intValue == "NaN")
        {
            return $intValue;
        }

        return $this->RecursiveIntFixer(base64_decode($intValue));
    }

    protected function RecursiveHexColorFixer($strHexColor) : string
    {
        if ( strlen($strHexColor) <= 6)
        {
            return $strHexColor;
        }

        return $this->RecursiveHexColorFixer(base64_decode($strHexColor));
    }

    public function TestMobiniti()
    {
        $objMobinitiContact = new MobinitiContactsApiModule();

        $objGroupResult = $objMobinitiContact->GetContactsByGroupId("18abac52-b03b-41b4-a69d-da4fb8903fc8");

        dump($objGroupResult);

        die;


//        $objMobinitiContact = new MobinitiContactsApiModule(MobinitiToken);
//        $objGroupContact = $objMobinitiContact->getById("b2722298-4792-478a-9739-9dd477c63c13");
//        $objMobinitiCoupons = new MobinitiCouponsApiModule(MobinitiToken);
//        $objGroupCoupons = $objMobinitiCoupons->getAll(10);
//        $objMobinitiOptin = new MobinitiOptInApiModule(MobinitiToken);
//        $objMobinitiOptins = $objMobinitiOptin->getAll(10);
//        $objMobinitiContact = new MobinitiContactsApiModule(MobinitiToken);
//        $objGroupContact = $objMobinitiContact->GetContactsByGroupId("18abac52-b03b-41b4-a69d-da4fb8903fc8");

//        dd($objMobinitiOptins);
//        dd($objGroupCoupons);
//        dd($objGroupContact);
        //dd($objGroupResult);

        $objMobinitiContact = new MobinitiContactsApiModule();

        $objNewContact = new MobinitiContactModel();
        $objNewContact->first_name = "Micah";
        $objNewContact->last_name = "Zak";
        $objNewContact->gender = "Male";
        $objNewContact->birth_date = "1981-04-15 00:00:00";
        $objNewContact->phone_number = "314-699-4925";
        $objNewContact->email = "micah@zakgraphix.com";
        $objNewContact->groups = [
            "18abac52-b03b-41b4-a69d-da4fb8903fc8"
        ];

        $objResult = $objMobinitiContact->CreateNew($objNewContact);

        dd($objResult);
    }
}
