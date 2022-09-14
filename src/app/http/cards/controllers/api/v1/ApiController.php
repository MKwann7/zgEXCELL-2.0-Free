<?php

namespace Http\Cards\Controllers\Api\V1;

use App\Core\App;
use App\Utilities\Database;
use App\Utilities\Excell\ExcellHttpModel;
use App\Utilities\Transaction\ExcellTransaction;
use Entities\Activities\Classes\UserLogs;
use Entities\Cards\Classes\Browsing\CardBrowsingHistories;
use Entities\Cards\Classes\CardAddon;
use Entities\Cards\Classes\CardConnections;
use Entities\Cards\Classes\CardDomains;
use Entities\Cards\Classes\CardPage;
use Entities\Cards\Classes\CardPageRels;
use Entities\Cards\Classes\Versioning\CardPageVersionings;
use Entities\Cards\Classes\Cards;
use Entities\Cards\Models\CardAddonModel;
use Entities\Cards\Models\CardDomainModel;
use Entities\Modules\Classes\AppInstanceRels;
use Entities\Modules\Classes\AppInstances;
use Entities\Modules\Models\AppInstanceRelModel;
use Entities\Orders\Classes\OrderLines;
use Entities\Orders\Classes\Orders;
use Entities\Orders\Models\OrderLineModel;
use Entities\Orders\Models\OrderModel;
use Entities\Products\Classes\Products;
use Http\Cards\Controllers\Base\CardController;
use Entities\Cards\Classes\CardSocialMedia;
use Entities\Cards\Classes\CardTemplates;
use Entities\Cards\Classes\CardVersionings;
use Entities\Cards\Models\CardConnectionModel;
use Entities\Cards\Models\CardModel;
use Entities\Cards\Models\CardPageVersioningModel;
use Entities\Cards\Models\CardSocialMediaModel;
use Entities\Cards\Models\CardVersioningModel;
use Entities\Media\Classes\Images;
use Entities\Users\Classes\Connections;
use Entities\Users\Classes\Users;
use Entities\Users\Models\ConnectionModel;
use Entities\Users\Models\UserModel;
use QRcode;

class ApiController extends CardController
{
    public function index(ExcellHttpModel $objData) : bool
    {
        switch(strtolower($this->getRequestType()))
        {
            case "get":
                return $this->getPublicCard($objData);
            case "post":
                return $this->registerNewCard($objData);
            case "put":
                return $this->updatePublicCard($objData);
            case "delete":
                return $this->deletePublicCard($objData);
        }

        return false;
    }

    private function getPublicCard(ExcellHttpModel $objData) : bool
    {
        $objParams = $objData->Data->Params;

        if (!$this->validate($objParams, [
            "uuid" => "required|uuid",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $card = $this->cardByUuid($objParams["uuid"]);

        if ($card === null)
        {
            return $this->renderReturnJson(false, ["errors" => "No cards found by uuid."], "No card found.");
        }

        $card->LoadCardPages(false, false);
        $card->removeHiddenPages();

        if (isset($objParams["addons"]))
        {
            $addons = explode("|", $objParams["addons"]);
            foreach($addons as $currAddon)
            {
                $card->LoadAddons($currAddon);
            }
        }

        return $this->renderReturnJson(true, ["card" => $card->ToPublicArray()], "Card found.");
    }

    private function registerNewCard(ExcellHttpModel $objData) : bool
    {

    }

    private function updatePublicCard(ExcellHttpModel $objData) : bool
    {

    }

    private function deletePublicCard(ExcellHttpModel $objData) : bool
    {

    }

    private function cardByUuid(string $uuid) : ?CardModel
    {
        /** @var CardModel $card */
        $card = (new Cards())->getByUuid($uuid)->getData()->first();

        if ($card === null)
        {
            return null;
        }

        $card->LoadCardDomains(false);
        $card->LoadCardConnections(false);
        $card->LoadCardSocialMedia(false);

        return $card;
    }

    public function getCardByUuid(ExcellHttpModel $objData): bool
    {
//        if (!$this->validateAuthentication($objData))
//        {
//            return $this->renderReturnJson(false, [], "Unauthorized", 401);
//        }

        if (!$this->validateRequestType('GET'))
        {
            return false;
        }

        $objParams = $objData->Data->Params;

        if (!$this->validate($objParams, [
            "uuid" => "required|uuid",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $card = $this->cardByUuid($objParams["uuid"]);

        if ($card === null)
        {
            return $this->renderReturnJson(false, ["errors" => "No cards found by uuid."], "No card found.");
        }

        $includePageContent = true;

        if (isset($objParams["pageContent"])) {
            $includePageContent = $objParams["pageContent"] == 1;
        }

        $includePages = false;

        if (isset($objParams["pages"]))
        {
            $includePages = $objParams["pages"] == 1;
        }

        if (isset($objParams["addons"]))
        {
            $addons = explode("|", $objParams["addons"]);
            foreach($addons as $currAddon)
            {
                $card->LoadAddons($currAddon);
            }
        }

        $card->LoadCardPages(false, $includePageContent);

        if ($includePages === true)
        {
            $card->removeHiddenPages();
        }

        $card->LoadCardContacts();

        return $this->renderReturnJson(true, ["card" => $card->ToPublicArray()], "We made it.");
    }

    public function GetCards(ExcellHttpModel $objData): void
    {
        $objCardModule = new Cards();
        $colAllCards = $objCardModule->GetAllCardsForDisplay("all");

        if ( $colAllCards->result->Success === false)
        {
            die('{"success":false,"message":"'.$colAllCards->result->Message.'"}');
        }

        $arCardResult = $colAllCards->getData()->ConvertToArray();

        $arTransactionResult = [
            "success" => true,
            "message" => $colAllCards->result->Message,
            "data" => $arCardResult
        ];

        die(json_encode($arTransactionResult));
    }

    public function GetCardsForSearch(ExcellHttpModel $objData): void
    {
        $arRequestParams = $objData->Data->Params;

        if (empty($arRequestParams["field"]))
        {
            die('{"success":false,"message":"No fields passed in for query."}');
        }

        $arWhereClause = [];

        foreach($arRequestParams["field"] as $currFieldName => $currFieldValue)
        {
            $arWhereClause[] = [$currFieldName, "LIKE", $currFieldValue . "%"];
            $arWhereClause[] = ["OR"];
        }

        array_pop($arWhereClause);

        $objCardModule = new Cards();
        $objSearchResult = $objCardModule->getWhere($arWhereClause);

        $arSearchResult = $objSearchResult->getData()->FieldsToArray(["card_num","card_name","card_vanity_url"]);

        $objUserSearchResult = [
            "cards" => $arSearchResult
        ];

        $objResult = ["success" => true, "data" => $objUserSearchResult];
        die(json_encode($objResult));
    }

    public function checkDomain(ExcellHttpModel $objData): void
    {
        $objVanityUrlCheckResult = new ExcellTransaction();

        if (empty($objData->Data->Params["card_domain"]))
        {
            $objResult = ["success" => false, "match" => "NA"];
            die(json_encode($objResult));
        }

        $cardDomain = $objData->Data->Params["card_domain"];

        $objCardModule = new CardDomains();

        // TODO - MAKE SURE THIS WORKS
        if (empty($objData->Data->Params["card_id"]))
        {
            $objVanityUrlCheckResult = $objCardModule->getWhere(["domain_name" => $cardDomain, "company_id" => $this->app->objCustomPlatform->getCompany()->company_id]);
        }
        else
        {
            $objVanityUrlCheckResult = $objCardModule->getWhere([["domain_name", "=", $cardDomain], "AND", ["card_id", "!=", $objData->Data->Params["card_id"]], "AND", ["company_id" => $this->app->objCustomPlatform->getCompany()->company_id]]);
        }

        if ($objVanityUrlCheckResult->result === false || $objVanityUrlCheckResult->result->Count === 0)
        {
            $objResult = ["success" => true, "match" => false];
            die(json_encode($objResult));
        }

        $objResult = ["success" => true, "match" => true];
        die(json_encode($objResult));
    }

    public function checkVanityUrl(ExcellHttpModel $objData): void
    {
        $objVanityUrlCheckResult = new ExcellTransaction();

        if (empty($objData->Data->Params["vanity_url"]))
        {
            $objResult = ["success" => false, "match" => "NA"];
            die(json_encode($objResult));
        }

        $strVanityUrl = $objData->Data->Params["vanity_url"];

        $objCardModule = new Cards();

        // TODO - MAKE SURE THIS WORKS
        if (empty($objData->Data->Params["card_id"]))
        {
            $objVanityUrlCheckResult = $objCardModule->getWhere(["card_vanity_url" => $strVanityUrl, "company_id" => $this->app->objCustomPlatform->getCompany()->company_id]);
        }
        else
        {
            $objVanityUrlCheckResult = $objCardModule->getWhere([["card_vanity_url", "=", $strVanityUrl], "AND", ["card_id", "!=", $objData->Data->Params["card_id"]], "AND", ["company_id" => $this->app->objCustomPlatform->getCompany()->company_id]]);
        }

        if ($objVanityUrlCheckResult->result === false || $objVanityUrlCheckResult->result->Count === 0)
        {
            $objResult = ["success" => true, "match" => false];
            die(json_encode($objResult));
        }

        $objResult = ["success" => true, "match" => true];
        die(json_encode($objResult));
    }

    public function checkKeyword(ExcellHttpModel $objData): void
    {
        $objKeywordResult = new ExcellTransaction();

        if (empty($objData->Data->Params["keyword"]))
        {
            $objResult = ["success" => false, "match" => "NA"];
            die(json_encode($objResult));
        }

        $strVanityUrl = $objData->Data->Params["keyword"];

        $objCardModule = new Cards();

        if (empty($objData->Data->Params["card_id"]))
        {
            $objKeywordResult = $objCardModule->getWhere(["card_keyword" => $strVanityUrl]);
        }
        else
        {
            $objKeywordResult = $objCardModule->getWhere([["card_keyword", "=", $strVanityUrl], "AND", ["card_id", "!=", $objData->Data->Params["card_id"]]]);
        }

        if ($objKeywordResult->result === false || $objKeywordResult->result->Count === 0)
        {
            $objResult = ["success" => true, "match" => false];
            die(json_encode($objResult));
        }

        $objResult = ["success" => true, "match" => true];
        die(json_encode($objResult));
    }

    public function GetCardMainImage(ExcellHttpModel $objData)
    {
//        $intCardNum = $objData->Data->Params["card_id"];
//        $objImageResult = (new Images())->noFks()->getWhere(["entity_id" => $intCardId, "image_class" => "main-image", "entity_name" => "card"],"image_id.DESC");
//        dd($objImageResult);
    }

    public function GetMainCardImageLink(ExcellHttpModel $objData)
    {
        $intCardNum = $objData->Data->Params["card_id"];
        $objCardResult = (new Cards())->getWhere(["card_num" => $intCardNum]);

        if ($objCardResult->result->Count === 0)
        {
            die("null");
        }

        $objImageResult = (new Images())->noFks()->getWhere(["entity_id" => $objCardResult->getData()->first()->card_id, "image_class" => "main-image", "entity_name" => "card"],"image_id.DESC");

        die($objImageResult->getData()->first()->url);
    }

    public function GetCardFaviconImage(ExcellHttpModel $objData)
    {

    }

    public function GetCardFaviconImageLink(ExcellHttpModel $objData)
    {

    }

    public function RegisterAppUser(ExcellHttpModel $objData): void
    {
        $objNewUserData = (object) $objData->Data->PostData;

        if ( empty($objNewUserData->username))
        {
            die('{"success": false, "data":{"message":"You did not supply a username."}}');
        }

        if ( empty($objNewUserData->email))
        {
            die('{"success": false, "data":{"message":"You did not supply an email address."}}');
        }

        if ( empty($objNewUserData->phonenumber))
        {
            die('{"success": false, "data":{"message":"You did not supply a phone number."}}');
        }

        if ( empty($objNewUserData->password))
        {
            die('{"success": false, "data":{"message":"You did not supply a password."}}');
        }

        $objCreationNewUser = new UserModel();

        $objCreationNewUser->username = $objNewUserData->username;
        $objCreationNewUser->password = $objNewUserData->password;
        $objCreationNewUser->division_id = 0;
        $objCreationNewUser->company_id = $this->app->objCustomPlatform->getCompanyId();
        $objCreationNewUser->sponsor_id = 70726;

        $objNewUserResult = (new Users())->createNew($objCreationNewUser);

        $objEmailAddressResult = $this->AssignEmailAddress($objNewUserResult->getData()->first()->user_id, $objNewUserData->email);
        $objMobileNumberResult = $this->AssignMobileNumber($objNewUserResult->getData()->first()->user_id, $objNewUserData->phonenumber);

        $objCreationNewUser->user_email = $objEmailAddressResult->getData()->first()->connection_value;
        $objCreationNewUser->user_phone = $objMobileNumberResult->getData()->first()->connection_value;

        (new Users())->update($objCreationNewUser);

        logText("RegisterNewAppUser.log", json_encode($objData->Data->PostData));

        $objUserCreationResult = [
            "user_id" => $objNewUserResult->getData()->first()->user_id
        ];

        $objResult = ["success" => true, "data" => $objUserCreationResult];

        die(json_encode($objResult));
    }

    private function AssignEmailAddress($intUserId, $strConnectionValue) : ExcellTransaction
    {
        $objConnection = new ConnectionModel();

        $objConnection->user_id = $intUserId;
        $objConnection->connection_type_id = 6;
        $objConnection->division_id = 0;
        $objConnection->company_id = $this->app->objCustomPlatform->getCompanyId();
        $objConnection->connection_value = $strConnectionValue;
        $objConnection->is_primary = EXCELL_TRUE;
        $objConnection->connection_class = 'user';

        return (new Connections())->createNew($objConnection);
    }

    private function AssignMobileNumber($intUserId, $strConnectionValue) : ExcellTransaction
    {
        $objConnection = new ConnectionModel();

        $objConnection->user_id = $intUserId;
        $objConnection->connection_type_id = 1;
        $objConnection->division_id = 0;
        $objConnection->company_id = $this->app->objCustomPlatform->getCompanyId();
        $objConnection->connection_value = $strConnectionValue;
        $objConnection->is_primary = EXCELL_TRUE;
        $objConnection->connection_class = 'user';

        return (new Connections())->createNew($objConnection);
    }

    public function DownloadVcard(ExcellHttpModel $objData) : bool
    {
        $intCardId = $objData->Data->Params["card_id"];

        $objCardModule = new Cards();
        $objCardResult = $objCardModule->getWhere(["card_num" =>$intCardId]);

        if ($objCardResult->result->Success === false || $objCardResult->result->Count === 0)
        {
            die('{"success":false}');
        }

        $objCard = $objCardResult->getData()->first();

        $objCard->LoadFullCard();

        $strMainImageLocation = $objCard->card_image;

        $strVcardImageLocation = $this->downloadMainImage($strMainImageLocation);

        if (file_exists($strVcardImageLocation) && is_readable ($strVcardImageLocation)) {
            $objVcardImage = file_get_contents($strVcardImageLocation);
            $strVcardBase64 = base64_encode($objVcardImage);
        }

        $vcard = "BEGIN:VCARD\r";
        $vcard .= "VERSION:3.0\r";
        $vcard .= "FN:" . $objCard->Owner->first_name . " " . $objCard->Owner->last_name . "\r";
        $vcard .= "N:" . $objCard->Owner->last_name . ";" . $objCard->Owner->first_name . " ;;;\r";
//
//        if (isset($title))
//        {
//            $vcard .= "TITLE:" . $title . "\r";
//        }
//
//        if (isset($businessname))
//        {
//            $vcard .= "ORG:" . $businessname . "\r";
//        }

        if (!empty($objCard->Addresses->first()))
        {
            $vcard .= "ADR;TYPE=work:;;" . $objCard->Addresses->first()->address_1 . " " . $objCard->Addresses->first()->address_2 . ";" . $objCard->Addresses->first()->city . " ;" . $objCard->Addresses->first()->state . ";" . $objCard->Addresses->first()->zip . ";\r";
        }

        if (isset($objCard->Owner->user_email))
        {
            $vcard .= "EMAIL;TYPE=internet,pref:" . $objCard->Owner->user_email . "\r";
        }

//        if (isset($officephone))
//        {
//            $vcard .= "TEL;TYPE=work,voice:" . $officephone . "\r";
//        }

        //dd($objCard->Owner);

        if (isset($objCard->Owner->user_phone))
        {
            $vcard .= "TEL;TYPE=CELL,voice:" . $objCard->Owner->user_phone . "\r";
        }

        if ($strVcardBase64 != null)
        {
            $vcard .= "PHOTO;ENCODING=b;TYPE=JPEG:" . $strVcardBase64 . "\r";
        }

//        if (isset($url))
//        {
//            $vcard .= "URL;TYPE=work:" . $url . "\r";
//        }

        $vcard .= "item1.URL;type=pref:" . getFullUrl() ."/" . $objCard->card_num . "\r";
        $vcard .= "item1.X-ABLabel:Digital Business Card\r";

        $vcard .= "END:VCARD";
        //
        //		echo '<pre>';
        //		print_r($row_card);
        //		echo '</pre>';
        //		die();

        # Send correct headers
        header("Content-type: text/x-vcard; charset=utf-8");
        // Alternatively: application/octet-stream
        // Depending on the desired browser behaviour
        // Be sure to test thoroughly cross-browser

        header("Content-Disposition: attachment; filename=\"" . $objCard->Owner->first_name . " " . $objCard->Owner->last_name . "'s Contact Information.vcf\";");
        # Output file contents
        echo $vcard;
        exit();
    }

    protected function downloadMainImage($strMainImagePath)
    {
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
        $strTempFileNameAndPath = APP_CORE . '/uploads/'. sha1(microtime()) . "." . $strFileExtension;

        file_put_contents($strTempFileNameAndPath, $objMainImage);

        return $strTempFileNameAndPath;
    }

    public function copyAllTabsToCard(ExcellHttpModel $objData) : bool
    {

    }

    public function generateQrCodeForCard(ExcellHttpModel $objData) : void
    {
        require_once APP_VENDORS . "qrcode/main/v1.0.0/qrcode.class.php";

        $objCardResult = (new Cards())->getWhere(["card_num" => $objData->Data->Params["id"]]);

        if ($objCardResult->result->Success === false || $objCardResult->result->Count === 0)
        {
            header("HTTP/1.0 404 Not Found");
            die("Card not found.");
        }

        $objCard = $objCardResult->getData()->first();

        // TODO - This needs to be fixed.
        if (empty($this->app->objAppSession["Core"]["Session"]["IpInfo"]->guid))
        {
            $this->app->objAppSession["Core"]["Session"]["IpInfo"] = new \stdClass();
            $this->app->objAppSession["Core"]["Session"]["IpInfo"]->guid = getGuid();
        }

        QRcode::png(getFullUrl() . "/cards/qr-code-routing?id=" . $objCard->card_num . "&guid=" . $this->app->objAppSession["Core"]["Session"]["IpInfo"]->guid, false, QR_ECLEVEL_L, 10);
    }

    public function updateSiteProfile(ExcellHttpModel $objData) : bool
    {
        if (!$this->validateRequestType('POST'))
        {
            return false;
        }

        $objParams = $objData->Data->Params;
        $objPost = $objData->Data->PostData;

        if (!$this->validate($objParams, [
            "card_id" => "required|integer",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $objCard = new Cards();
        $intCardId = $objParams["card_id"];

        if (!empty($objPost->card_vanity_url))
        {
            $strVanityUrl            = $objPost->card_vanity_url;
            $objVanityUrlCheckResult = $objCard->getWhere([
                    [
                        "card_vanity_url",
                        "=",
                        $strVanityUrl
                    ],
                    "AND",
                    [
                        "card_id",
                        "!=",
                        $intCardId
                    ]
                ]
            );

            if ($objVanityUrlCheckResult->result === true && $objVanityUrlCheckResult->result->Count > 0)
            {
                return $this->renderReturnJson(false, $this->validationErrors, "This Vanity URL Already Exists.");
            }
        }
        else
        {
            $objPost->card_vanity_url = EXCELL_NULL;
        }

        if (!empty($objPost->card_keyword))
        {
            $strCardKeyword            = $objPost->card_keyword;
            $objCardKeywordCheckResult = $objCard->getWhere([
                    [
                        "card_keyword",
                        "=",
                        $strCardKeyword
                    ],
                    "AND",
                    [
                        "card_id",
                        "!=",
                        $intCardId
                    ]
                ]
            );

            if ($objCardKeywordCheckResult->result === true && $objCardKeywordCheckResult->result->Count > 0)
            {
                return $this->renderReturnJson(false, $this->validationErrors, "This Keyword Already Exists.");
            }
        }
        else
        {
            $objPost->card_keyword = EXCELL_NULL;
        }

        $objPost->card_id = $objParams["card_id"];

        $card = new CardModel();

        $card->card_id = $objPost->card_id;
        $card->owner_id = $objPost->owner_id;
        $card->card_user_id = $objPost->card_user_id;
        $card->card_name = $objPost->card_name;
        $card->status = $objPost->status;
        $card->card_vanity_url = $objPost->card_vanity_url;
        $card->card_keyword = $objPost->card_keyword;
        $card->template_id = $objPost->template_id;

        $cardResult = $objCard->update($card);

        $fullCardResult = (new Cards())->getByUuid($cardResult->getData()->first()->sys_row_id);

        /** @var CardModel $card */
        $card = $fullCardResult->getData()->first();

        if ($cardResult->result->Success === false)
        {
            return $this->renderReturnJson(false, null, $cardResult->result->Message);
        }

        $cardDomains = new CardDomains();

        $cardDomainResult = $cardDomains->getWhere(["card_id" => $card->card_id]);

        if ($cardDomainResult->getResult()->Count > 0) {
            if ($cardDomainResult->getData()->first()->domain_name !== $objPost->card_domain) {
                $cardDomain = $cardDomainResult->getData()->first();
                $cardDomain->domain_name = $objPost->card_domain;
                $cardDomains->update($cardDomain);
            }
            return $this->renderReturnJson(true, ["card" => $card->ToPublicArray()], $cardResult->result->Message);
        }

        $cardDomain = new CardDomainModel();
        $cardDomain->company_id = $card->company_id;
        $cardDomain->domain_name = $objPost->card_domain;
        $cardDomain->card_id = $card->card_id;
        $cardDomain->ssl = EXCELL_FALSE;
        $cardDomain->type = "site";
        $result = $cardDomains->createNew($cardDomain);

        return $this->renderReturnJson(true, ["card" => $card->ToPublicArray()], $cardResult->result->Message);
    }

    public function updateCardConnection(ExcellHttpModel $objData) : bool
    {
        if (!$this->validateRequestType('POST'))
        {
            return false;
        }

        $objParams = $objData->Data->Params;
        $objPost = $objData->Data->PostData;

        if (!$this->validate($objParams, [
            "card_id" => "required|integer",
            "action" => "required",
            "sourceType" => "required",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $actionType             = $objParams["action"];
        $sourceType             = $objParams["sourceType"];
        $intCardId              = $objParams["card_id"];
        $objLoggedInUser        = $this->app->getActiveLoggedInUser();

        if ($sourceType === "connections" || $sourceType === "shares")
        {
            $this->processUpdateCardConnection($intCardId, $objPost, $objLoggedInUser);
        }
        elseif ($sourceType === "socialmedia")
        {
            $this->processUpdateCardSocialMedia($intCardId, $objPost, $objLoggedInUser, $actionType);
        }

        return true;
    }

    protected function processUpdateCardConnection($intCardId, $objPost, $objLoggedInUser) : void
    {
        $intConnectionId        = $objPost->connection_id;
        $intConnectionRelId     = $objPost->connection_rel_id;
        $strConnectionRelAction = $objPost->action;
        $intUserId              = $objPost->user_id;
        $intDisplayOrder        = $objPost->connection_display_order;

        try
        {
            $objCurrentCardConnection = (new CardConnections())->getWhere([
                    [
                        "connection_id" => $intConnectionId,
                        "display_order" => EXCELL_NULL
                    ],
                    "OR",
                    ["connection_rel_id" => $intConnectionRelId]
                ]
            );

            if ($objCurrentCardConnection->result->Count === 0)
            {
                $objCardConnectionUpdateModel = new CardConnectionModel();

                $objCardConnectionUpdateModel->connection_id = $intConnectionId;
                $objCardConnectionUpdateModel->card_id       = $intCardId;
                $objCardConnectionUpdateModel->status        = "Active";
                $objCardConnectionUpdateModel->action        = $strConnectionRelAction;
                $objCardConnectionUpdateModel->display_order = $intDisplayOrder;

                $objResult              = (new CardConnections())->createNew($objCardConnectionUpdateModel)->getData()->ConvertToArray();
                $objConnectionForReturn = array_shift($objResult);

                $objConnection                                = (new Connections())->getFks()->getById($intConnectionId);
                $objConnectionForReturn["connection_value"]   = formatAsPhoneIfApplicable($objConnection->getData()->first()->connection_value);
                $objConnectionForReturn["connection_type_id"] = $objConnection->getData()->first()->connection_type_id;

                (new UserLogs())->RegisterActivity($objLoggedInUser->user_id, "updated_connection_rel", "Card Connection Relationship Updated", "connection_rel", $objConnectionForReturn["connection_rel_id"]);

                $arResult = [
                    "success"    => true,
                    "connection" => $objConnectionForReturn
                ];

                die(json_encode($arResult));
            }
            else
            {
                $objCurrentCardConnection->getData()->first()->connection_id = $intConnectionId;
                $objCurrentCardConnection->getData()->first()->action        = $strConnectionRelAction;
                $objCurrentCardConnection->getData()->first()->display_order = $intDisplayOrder;

                $objResult              = (new CardConnections())->update($objCurrentCardConnection->getData()->first())->getData()->ConvertToArray();

                //dd($objResult);

                $objConnectionForReturn = array_shift($objResult);

                $objConnection                                = (new Connections())->getFks()->getById($intConnectionId);
                $objConnectionForReturn["connection_value"]   = $objConnection->getData()->first()->connection_value;
                $objConnectionForReturn["connection_type_id"] = $objConnection->getData()->first()->connection_type_id;

                $arResult = [
                    "success"    => true,
                    "connection" => $objConnectionForReturn
                ];

                die(json_encode($arResult));
            }
        }
        catch (\Exception $exception)
        {
            $objJsonReturn = array(
                "success" => false,
                "message" => "An error occured during user update: " . json_encode($exception) . "."
            );

            die(json_encode($objJsonReturn));
        }
    }

    protected function processUpdateCardSocialMedia($intCardId, $objPost, $objLoggedInUser, $actionType) : bool
    {
        $intConnectionId       = $objPost->connection_id;
        $strConnectionRelAction = $objPost->action;
        $intUserId              = $objPost->user_id;
        $intDisplayOrder        = $objPost->connection_display_order;

        $objResult = new ExcellTransaction();

        if ($actionType === "new")
        {
            $objCardSocialMediaModel = new CardSocialMediaModel();

            $objCardSocialMediaModel->company_id            = $this->app->objCustomPlatform->getCompanyId();
            $objCardSocialMediaModel->division_id           = 0;
            $objCardSocialMediaModel->connection_id         = $intConnectionId;
            $objCardSocialMediaModel->card_id               = $intCardId;
            $objCardSocialMediaModel->user_id               = $intUserId;
            $objCardSocialMediaModel->status                = "active";
            $objCardSocialMediaModel->action                = $strConnectionRelAction;
            $objCardSocialMediaModel->display_order         = $intDisplayOrder;

            $objResult              = (new CardSocialMedia())->createNew($objCardSocialMediaModel);

            return $this->renderReturnJson(true, ["connection" => $objResult->getData()->first()->ToArray()], $objResult->result->Message);
        }

        $intSocialMediaId = $objPost->card_socialmedia_id;

        $socialMediaResult = (new CardSocialMedia())->getById($intSocialMediaId);

        if ($socialMediaResult->result->Count !== 1)
        {
            return $this->renderReturnJson(false, ["error" => $socialMediaResult->result->Errors], $socialMediaResult->result->Message);
        }

        $objCardSocialMedia = $socialMediaResult->getData()->first();
        $objCardSocialMedia->connection_id = $intConnectionId;
        $objCardSocialMedia->card_id       = $intCardId;
        $objCardSocialMedia->user_id       = $intUserId;
        $objCardSocialMedia->status        = "active";
        $objCardSocialMedia->action        = $strConnectionRelAction;
        $objCardSocialMedia->display_order = $intDisplayOrder;

        $objResult              = (new CardSocialMedia())->update($objCardSocialMedia);

        return $this->renderReturnJson(true, ["connection" => $objResult->getData()->first()->ToArray()], $objResult->result->Message);
    }

    public function getAllAvailableCardTemplates(ExcellHttpModel $objData) : bool
    {
        if (!$this->validateRequestType('GET'))
        {
            return false;
        }

        $cards = new Cards();
        $cardResults = $cards->getWhere(["template_card" => EXCELL_TRUE, "company_id" => $this->app->objCustomPlatform->getCompanyId()]);

        if ($cardResults->result->Success === false)
        {
            return $this->renderReturnJson(false, null, $cardResults->result->Message);
        }

        return $this->renderReturnJson(true, ["list" => $cardResults->getData()->ToPublicArray()], $cardResults->result->Message);
    }

    public function getSiteTemplates(ExcellHttpModel $objData) : bool
    {
        if (!$this->validateRequestType('GET'))
        {
            return false;
        }

        $objParams = $objData->Data->Params;

        if (!$this->validate($objParams, [
            "type" => "required",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $cardTemplates = new CardTemplates();
        $cardTemplateResults = $cardTemplates->getByCompanyId($this->app->objCustomPlatform->getCompanyId(), $objParams["type"]);

        if ($cardTemplateResults->result->Success === false)
        {
            return $this->renderReturnJson(false, null, $cardTemplateResults->result->Message);
        }

        return $this->renderReturnJson(true, ["list" => $cardTemplateResults->getData()->ToPublicArray()], $cardTemplateResults->result->Message);
    }

    public function getSiteThemes(ExcellHttpModel $objData) : bool
    {
        /** @var App $app  */
        global $app;
        $themeData = [
            0 => [
                "title" => "Excell",
                "description" => "The best theme for " .$app->objCustomPlatform->getCompany()->platform_name,
            ],
            1 => [
                "title" => "Galaxybiz",
                "description" => "Bring the wonder of creation into your " .$app->objCustomPlatform->getCompany()->platform_name . " universe."
            ],
            2 => [
                "title" => "ConsultPro",
                "description" => "Business and legal consulting collide with glorious web precision for the perfect " .$app->objCustomPlatform->getCompany()->platform_name . " experience."
            ],
        ];

        return $this->renderReturnJson(true, ["list" => $themeData], $cardTemplateResults->result->Message);
    }

    public function updateCardUserProfile(ExcellHttpModel $objData) : bool
    {
        if (!$this->validateRequestType('POST'))
        {
            return false;
        }

        $objParams = $objData->Data->Params;
        $objPost = $objData->Data->PostData;

        if (!$this->validate($objParams, [
            "card_id" => "required|number",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        if (!$this->validate($objPost, [
            "card_user_id" => "required|number",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $cardResult = (new Cards())->getById($objParams["card_id"]);
        $card = $cardResult->getData()->first();

        $card->card_user_id = $objPost->card_user_id;
        $card->card_data->card_user->title =  $objPost->card_user_title;

        $cardResult = (new Cards())->update($card);

        $fullCardResult = (new Cards())->getByUuid($cardResult->getData()->first()->sys_row_id);

        /** @var CardModel $card */
        $card = $fullCardResult->getData()->first();

        if ($cardResult->result->Success === false)
        {
            return $this->renderReturnJson(false, null, $cardResult->result->Message);
        }

        return $this->renderReturnJson(true, ["card" => $card->ToPublicArray()], $cardResult->result->Message);
    }

    public function autoSaveBuildFormData(ExcellHttpModel $objData) : bool
    {
        if (!$this->validateRequestType('POST'))
        {
            return false;
        }

        $objPost = $objData->Data->PostData;

        if (!$this->validate($objPost, [
            "card_id" => "required|number",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $cardData = (new Cards())->getById($objPost->card_id)->getData()->first();

        if ($cardData === null || $cardData->status !== "Build")
        {
            $this->sendSuccessfulResponseAndContinue("Card not in build stage...");
        }
        else
        {
            $this->sendSuccessfulResponseAndContinue("Auto saving....");
        }

        $objCardVersion = new CardVersionings();
        $versionResult = $objCardVersion->getWhere(["card_id" => $objPost->card_id, "card_version_status" => "build"]);

        if ($versionResult->result->Count === 0)
        {
            $this->createCardVersioning($objPost, $cardData);
            $this->processCardVersioning($cardData, $objPost);

            return true;
        }

        $this->updateCardVersioning($versionResult->getData()->first(), $objPost);
        $this->processCardVersioning($cardData, $objPost);

        return true;
    }

    private function createCardVersioning($objPost, $cardData) : void
    {
        $cardVersion = new CardVersioningModel();
        $cardVersion->card_id = $objPost->card_id;
        $cardVersion->company_id = $this->app->objCustomPlatform->getCompanyId();
        $cardVersion->division_id = 0;
        $cardVersion->card_num = $cardData->card_num;
        $cardVersion->owner_id = $cardData->owner_id;
        $cardVersion->card_user_id = $cardData->card_user_id;
        $cardVersion->card_type_id = $cardData->card_type_id;
        $cardVersion->status = $cardData->status;
        $cardVersion->template_card = $cardData->template_card;
        $cardVersion->order_line_id = $cardData->order_line_id;
        $cardVersion->product_id = $cardData->product_id;
        $cardVersion->template_id = $cardData->template_id;
        $cardVersion->card_name = $objPost->card_name;
        $cardVersion->card_vanity_url = $objPost->card_vanity_url;
        $cardVersion->card_keyword = $objPost->card_keyword;
        $cardVersion->card_version_status = "build";

        if (empty($cardVersion->card_data))
        {
            $cardVersion->card_data = new \stdClass();
        }

        $cardVersion->card_data->style->card->color->main =  base64_encode(str_replace('#', "", $objPost->main_color));
        $cardVersion->card_data->style->card->color->secondary =   base64_encode(str_replace('#', "", $objPost->secondary_color));

        $result = (new CardVersionings())->createNew($cardVersion);
    }

    private function updateCardVersioning($cardVersion, $objPost) : void
    {
        $cardVersion->card_name = $objPost->card_name;
        $cardVersion->card_vanity_url = $objPost->card_vanity_url;
        $cardVersion->card_keyword = $objPost->card_keyword;

        if (empty($cardVersion->card_data))
        {
            $cardVersion->card_data = new \stdClass();
        }

        $cardVersion->card_data->style->card->color->main =  base64_encode(str_replace('#', "", $objPost->main_color));
        $cardVersion->card_data->style->card->color->secondary =   base64_encode(str_replace('#', "", $objPost->secondary_color));

        $result = (new CardVersionings())->update($cardVersion);
    }

    private function processCardVersioning($cardData, $objPost) : void
    {
        if (empty($objPost->pages) || count($objPost->pages) === 0) { return; }

        $pageIds = [];

        foreach($objPost->pages as $currPage)
        {
            $pageIds[] = $currPage["page_id"];
        }

        $objCardPages = new CardPage();
        $pageResult = $objCardPages->getWhereIn("card_tab_id", $pageIds);

        $objCardPageVersion = new CardPageVersionings();
        $versionResult = $objCardPageVersion->getWhere([["card_page_id", "IN", $pageIds], "AND", ["card_page_version_status" => "build"]]);

        foreach($objPost->pages as $currPage)
        {
            $cardPage = $pageResult->getData()->FindEntityByValue("card_tab_id", $currPage["page_id"]);

            $pageVersion = $versionResult->getData()->FindEntityByValue("card_page_id", $currPage["page_id"]);

            if ($pageVersion === null)
            {
                $this->createNewCardPageVersioning($currPage, $cardPage, $cardData);
                continue;
            }

            $this->updatedCardPageVersioning($currPage, $pageVersion);
        }
    }

    private function createNewCardPageVersioning($currPage, $cardPage, $cardData) : void
    {
        $cardVersion = new CardPageVersioningModel();
        $cardVersion->card_page_id = $currPage["page_id"];
        $cardVersion->card_id = $cardData->card_id;
        $cardVersion->company_id = $this->app->objCustomPlatform->getCompanyId();
        $cardVersion->division_id = 0;
        $cardVersion->user_id = $cardData->owner_id;
        $cardVersion->card_tab_type_id = $cardPage->card_tab_type_id;
        $cardVersion->title = $currPage["title"];
        $cardVersion->content = $currPage["content"];
        $cardVersion->order_number = $cardPage->order_number;
        $cardVersion->url = $cardPage->url;
        $cardVersion->library_tab = $cardPage->library_tab;
        $cardVersion->visibility = $cardData->visibility;
        $cardVersion->card_page_version_status = "build";

        if (empty($cardVersion->card_tab_data))
        {
            $cardVersion->card_tab_data = new \stdClass();
        }

        $cardVersion->card_tab_data->custom->header = base64_encode($currPage["header"]);

        $result = (new CardPageVersionings())->createNew($cardVersion);
    }

    private function updatedCardPageVersioning($currPage, $cardVersion) : void
    {
        $cardVersion->title = $currPage["title"];
        $cardVersion->content = $currPage["content"];
        $cardVersion->card_page_version_status = "build";

        if (empty($cardVersion->card_tab_data))
        {
            $cardVersion->card_tab_data = new \stdClass();
        }

        $cardVersion->card_tab_data->custom->header = base64_encode($currPage["header"]);

        $result = (new CardPageVersionings())->update($cardVersion);
    }

    public function getAutoSaveForBuildForm(ExcellHttpModel $objData) : bool
    {
        if (!$this->validateRequestType('GET'))
        {
            return false;
        }

        $objParams = $objData->Data->Params;

        if (!$this->validate($objParams, [
            "card_id" => "required|number",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $objCardVersion = new CardVersionings();
        $versionResult = $objCardVersion->getWhere(["card_id" => $objParams["card_id"], "card_version_status" => "build"]);

        $objCardPageVersion = new CardPageVersionings();
        $versionPageResult = $objCardPageVersion->getWhere([["card_id"=> $objParams["card_id"]], "AND", ["card_page_version_status" => "build"]]);

        $card = $versionResult->getData()->first();
        $card->AddUnvalidatedValue("pages", $versionPageResult->data);


        return $this->renderReturnJson(true, ["card" => $card->ToArray()], $versionResult->result->Message);
    }

    public function submitBuildFormData(ExcellHttpModel $objData) : bool
    {
        if (!$this->validateRequestType('POST'))
        {
            return false;
        }

        $objPost = $objData->Data->PostData;

        if (!$this->validate($objPost, [
            "card_id" => "required|number",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $objCardVersion = new CardVersionings();
        $versionResult = $objCardVersion->getWhere(["card_id" => $objPost->card_id, "card_version_status" => "build"]);

        if ($versionResult->result->Count === 0)
        {
            return $this->renderReturnJson(false, ["error" => "No card build versioning for this card."], "Integrity errors.");
        }

        $cardVersion = $versionResult->getData()->first();

        $cardData = (new Cards())->getById($objPost->card_id)->getData()->first();
        $cardData->card_version_id = $cardVersion->card_version_id;
        $cardData->status = "BuildComplete";

        $cards = (new Cards())->update($cardData)->getData()->first();

        $objCardPageVersion = new CardPageVersionings();
        $versionPageResult = $objCardPageVersion->getWhere([["card_id"=> $objPost->card_id], "AND", ["card_page_version_status" => "build"]]);

        $objCardPages = new CardPage();
        $pageResult = $objCardPages->getWhereIn("card_tab_id", $versionPageResult->getData()->FieldsToArray(["card_page_id"]));

        $pageResult->getData()->Foreach(function($currPage) use ($versionPageResult)
        {
            $currPageVersion = $versionPageResult->getData()->FindEntityByValue("card_page_id", $currPage->card_tab_id);
            if ($currPageVersion === null) { return; }
            $currPage->card_page_version = $currPageVersion->card_page_version_id;
            $currPage->title = $currPageVersion->title;
            (new CardPage())->update($currPage);
        });

        return $this->renderReturnJson(true, ["card" => $cards->ToArray()], "Card form submission complete.");
    }

    public function addToUserFavorites(ExcellHttpModel $objData) : bool
    {
        if (!$this->validateRequestType('POST'))
        {
            return false;
        }

        $objPost = $objData->Data->PostData;

        if (!$this->validate($objPost, [
            "card_id" => "required|uuid",
            "user_id" => "required|uuid",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        return $this->renderReturnJson(true, [], "Card added to favorites.");
    }

    public function searchCards(ExcellHttpModel $objData) : bool
    {
        if (!$this->validateRequestType('POST'))
        {
            return false;
        }

        $objPost = $objData->Data->PostData;

        if (!$this->validate($objPost, [
            "text" => "required",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        // search for card based on first name, last name of card owner/user, card num and card vanity url... and: TODO: card classification.
        $searchText = preg_replace("/[^A-Za-z0-9]/", '', $objPost->text);

        $objWhereClause = "
            SELECT 
                cd.card_id,
                cd.card_num,
                cd.card_vanity_url,
                cd.card_name,
                cd.template_id,
                cd.sys_row_id,
            (SELECT thumb FROM `excell_media`.`image` WHERE image.entity_id = cd.card_id AND image.entity_name = 'card' AND image_class = 'main-image' ORDER BY image_id DESC LIMIT 1) AS banner,
            (SELECT thumb FROM `excell_media`.`image` WHERE image.entity_id = cd.card_id AND image.entity_name = 'card' AND image_class = 'favicon-image' ORDER BY image_id DESC LIMIT 1) AS ico 
            FROM excell_main.card cd
            LEFT JOIN excell_main.user ur1 ON cd.owner_id = ur1.user_id 
            LEFT JOIN excell_main.user ur2 ON cd.card_user_id = ur1.user_id ";

        $objWhereClause .= "WHERE cd.company_id = {$this->app->objCustomPlatform->getCompanyId()} AND (";
        $objWhereClause .= "cd.card_num LIKE '%{$searchText}%' OR ";
        $objWhereClause .= "cd.card_vanity_url LIKE '%{$searchText}%' OR ";
        $objWhereClause .= "CONCAT(ur1.first_name, ' ', ur1.last_name) LIKE '%{$searchText}%' OR ";
        $objWhereClause .= "CONCAT(ur2.first_name, ' ', ur2.last_name) LIKE '%{$searchText}%')";

        $objWhereClause .= " LIMIT 15";

        $cardResult = Database::getSimple($objWhereClause, "card_num");
        $cardResult->getData()->HydrateModelData(CardModel::class, true);

        if ($cardResult->result->Success === false)
        {
            return $this->renderReturnJson(false, ["query" => $cardResult->result->Query], $cardResult->result->Message);
        }

        if (!empty($cardResult->getData()->first()->card_data) && isJson($cardResult->getData()->first()->card_data)) { $cardResult->getData()->first()->card_data = json_decode($cardResult->getData()->first()->card_data); }

        return $this->renderReturnJson(true, ["cards" => $cardResult->getData()->ToPublicArray()], "We made it.");
    }

    public function registerCardInHistory(ExcellHttpModel $objData) : bool
    {
        if (!$this->validateRequestType('POST'))
        {
            return false;
        }

        $objPost = $objData->Data->PostData;

        if (!$this->validate($objPost, [
            "user_id" => "required|uuid",
            "card_id" => "required",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $userResult = (new Users())->getByUuid($objPost->user_id);

        if ($userResult->result->Count !== 1)
        {
            return $this->renderReturnJson(false, $this->validationErrors, "User not found.");
        }

        $result = (new CardBrowsingHistories())->upsertHistoryRecord($userResult->getData()->first()->user_id, $objPost->card_id);

        return $this->renderReturnJson($result->result->Success, [], $result->result->Message);
    }

    public function loadMyHubData(ExcellHttpModel $objData) : bool
    {
        if (!$this->validateRequestType('GET'))
        {
            return false;
        }

        $objParams = $objData->Data->Params;

        if (!$this->validate($objParams, [
            "user_id" => "required|uuid",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $userResult = (new Users())->getByUuid($objParams["user_id"]);

        if ($userResult->result->Count !== 1)
        {
            return $this->renderReturnJson(false, $this->validationErrors, "User not found.");
        }

        $historyResult = (new CardBrowsingHistories())->getWhere(["user_id" => $userResult->getData()->first()->user_id], "last_updated.DESC", 25);

        $objWhereClause = (new Cards())->buildCardWhereClauseWithIds($historyResult->getData()->FieldsToArray(["card_id"]), "user_id", $userResult->getData()->first()->user_id);
        $objCards = Database::getSimple($objWhereClause, "card_id");
        $objCards->getData()->HydrateModelData(CardModel::class, true);

        $objCards->getData()->Foreach(function($currCard) use ($historyResult) {
            $objCard = $historyResult->getData()->FindEntityByValue("card_id", $currCard->card_id);

            if ($objCard !== null)
            {
                $currCard->last_updated = $objCard->last_updated;
                return $currCard;
            }
        });


        return $this->renderReturnJson(true, [
            "favorites" => [],
            "history" => $objCards->getData()->ToPublicArray(),
        ], "success");
    }

    public function updateSitePageRelProfile(ExcellHttpModel $objData) : bool
    {
        if (!$this->validateRequestType('POST'))
        {
            return false;
        }

        $objParams = $objData->Data->Params;
        $objPost = $objData->Data->PostData;

        if (!$this->validate($objParams, [
            "site_id" => "required",
            "site_page_id" => "required",
            "site_page_rel_id" => "required",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $sitePages = new CardPage();
        $sitePageRels = new CardPageRels();

        $sitePageResult = $sitePages->getById($objParams["site_page_id"]);
        $sitePageRelResult = $sitePageRels->getById($objParams["site_page_rel_id"]);

        if ($sitePageResult->getResult()->Count !== 1) {
            return $this->renderReturnJson(false, ["error" => "unable to find page for update."], "Process errors.");
        }

        $sitePage = $sitePageResult->getData()->first();

        if ($sitePageRelResult->getResult()->Count !== 1) {
            return $this->renderReturnJson(false, ["error" => "unable to find page relation for update."], "Process errors.");
        }

        $sitePageRel = $sitePageRelResult->getData()->first();

        if (!empty($objPost->title)) {
            $sitePageRel->card_tab_rel_title = $objPost->title;
        }
        if (!empty($objPost->menu)) {
            $sitePageRel->card_tab_rel_menu_title = $objPost->menu;
        }
        if (!empty($objPost->url)) {
            $sitePageRel->card_tab_rel_url = $objPost->url;
        }

        $sitePageRels->update($sitePageRel);

        $appInstanceRels = new AppInstanceRels();
        $appInstanceRelResult = $appInstanceRels->getWhere(["card_page_rel_id" => $objParams["site_page_rel_id"], "page_box_id" => EXCELL_NULL]);

        if (str_contains($objPost->widget, "_")) {
            $appInstanceId = explode("_", $objPost->widget)[0];
            $appWidgetId = explode("_", $objPost->widget)[1];

            $appInstances = new AppInstances();
            $appInstanceResult = $appInstances->getById($appInstanceId);

            if ($appInstanceResult->getResult()->Success === false) {
                return $this->renderReturnJson(false, ["error" => "unable to find application instance for update."], "Process errors.");
            }

            $appInstance = $appInstanceResult->getData()->first();

            $appProduct = (new Products())->getById($appInstance->product_id)->getData()->first();

            if ($appInstanceRelResult->getResult()->Count !== 1) {
                // TODO - This is potentially billable, and so it needs a card addon and order line.

                // create new order and orderline, with empty values....
                $objOrders = new Orders();
                $order = new OrderModel();

                $order->company_id = $sitePage->company_id;
                $order->division_id = 0;
                $order->user_id = $sitePageRel->user_id;
                $order->total_price = 0;
                $order->title = "Page Widget Purchase on " . date("Y-m-d") . " at " . date("H:i:s");
                $order->status = "completed"; // TODO - Question for Cheryl

                $orderResult = $objOrders->createNew($order);

                $objOrderLines = new OrderLines();
                $orderLine = new OrderLineModel();

                $orderLine->order_id = $orderResult->getData()->first()->order_id;
                $orderLine->product_id = $appInstance->product_id;
                $orderLine->company_id = $sitePage->company_id;
                $orderLine->user_id = $sitePageRel->user_id;
                // TODO - Get Default billing account....
                // $orderLine->payment_account_id = $this->paymentAccountId;

                // TODO - This needs to come from the Custom Platform package data
                $orderLine->title = $appProduct->title;
                $orderLine->status = "started";
                $orderLine->billing_date = date("Y-m-d H:i:s");
                $orderLine->promo_price = 0;
                $orderLine->promo_fee = 0;
                $orderLine->price = 0;
                $orderLine->price_fee = 0;

                $orderLine->promo_duration = $appProduct->promo_cycle_duration;
                $orderLine->price_duration = $appProduct->value_duration;
                $orderLine->cycle_type = $appProduct->cycle_type;
                $orderLine->created_by = $sitePageRel->user_id;
                $orderLine->updated_by = $sitePageRel->user_id;

                $orderLineResult = $objOrderLines->createNew($orderLine);

                // create Page Addon....
                $objCardAddon = new CardAddon();

                $cardAddon = new CardAddonModel();
                $cardAddon->company_id = $sitePage->company_id;
                $cardAddon->division_id = 0;
                $cardAddon->user_id = $sitePageRel->user_id;
                $cardAddon->card_id = $sitePageRel->card_id;
                $cardAddon->order_line_id = $orderLineResult->getData()->first()->order_line_id;
                $cardAddon->order_id = $orderResult->getData()->first()->order_id;
                $cardAddon->product_type_id = $appProduct->product_type_id;
                $cardAddon->product_id = $appProduct->product_id;
                $cardAddon->status = "active";

                $cardAddonResult = $objCardAddon->createNew($cardAddon);

                $appInstanceRelModel = new AppInstanceRelModel();

                $appInstanceRelModel->app_instance_id = $appInstanceId;
                $appInstanceRelModel->company_id = $sitePage->company_id;
                $appInstanceRelModel->division_id = $sitePage->division_id;
                $appInstanceRelModel->user_id = $sitePageRel->user_id;
                $appInstanceRelModel->module_app_widget_id = $appWidgetId;
                $appInstanceRelModel->card_id = $sitePageRel->card_id;
                $appInstanceRelModel->card_page_id = $sitePageRel->card_tab_id;
                $appInstanceRelModel->card_page_rel_id = $sitePageRel->card_tab_rel_id;
                $appInstanceRelModel->card_addon_id = $cardAddonResult->getData()->first()->card_addon_id;
                $appInstanceRelModel->order_line_id = $orderLineResult->getData()->first()->order_line_id;

                $appInstanceRelResult = $appInstanceRels->createNew($appInstanceRelModel);

                // TODO - this should reflect an existing widget value that comes from the custom platform
            } else {
                $appInstanceRel = $appInstanceRelResult->getData()->first();

                if ($appInstanceRel->module_app_widget_id != $appWidgetId) {

                    // create new order and orderline, with empty values....
                    $objOrders = new Orders();
                    $order = new OrderModel();

                    $order->company_id = $sitePage->company_id;
                    $order->division_id = 0;
                    $order->user_id = $sitePageRel->user_id;
                    $order->total_price = 0;
                    $order->title = "Page Widget Purchase on " . date("Y-m-d") . " at " . date("H:i:s");
                    $order->status = "completed"; // TODO - Question for Cheryl

                    $orderResult = $objOrders->createNew($order);

                    $objOrderLines = new OrderLines();
                    $orderLine = new OrderLineModel();

                    $orderLine->order_id = $orderResult->getData()->first()->order_id;
                    $orderLine->product_id = $appInstance->product_id;
                    $orderLine->company_id = $sitePage->company_id;
                    $orderLine->user_id = $sitePageRel->user_id;
                    // TODO - Get Default billing account....
                    // $orderLine->payment_account_id = $this->paymentAccountId;

                    // TODO - This needs to come from the Custom Platform package data
                    $orderLine->title = $appProduct->title;
                    $orderLine->status = "started";
                    $orderLine->billing_date = date("Y-m-d H:i:s");
                    $orderLine->promo_price = 0;
                    $orderLine->promo_fee = 0;
                    $orderLine->price = 0;
                    $orderLine->price_fee = 0;

                    $orderLine->promo_duration = $appProduct->promo_cycle_duration;
                    $orderLine->price_duration = $appProduct->value_duration;
                    $orderLine->cycle_type = $appProduct->cycle_type;
                    $orderLine->created_by = $sitePageRel->user_id;
                    $orderLine->updated_by = $sitePageRel->user_id;

                    $orderLineResult = $objOrderLines->createNew($orderLine);

                    // create Page Addon....
                    $objCardAddon = new CardAddon();

                    $cardAddon = new CardAddonModel();
                    $cardAddon->company_id = $sitePage->company_id;
                    $cardAddon->division_id = 0;
                    $cardAddon->user_id = $sitePageRel->user_id;
                    $cardAddon->card_id = $sitePageRel->card_id;
                    $cardAddon->order_line_id = $orderLineResult->getData()->first()->order_line_id;
                    $cardAddon->order_id = $orderResult->getData()->first()->order_id;
                    $cardAddon->product_type_id = $appProduct->product_type_id;
                    $cardAddon->product_id = $appProduct->product_id;
                    $cardAddon->status = "active";

                    $cardAddonResult = $objCardAddon->createNew($cardAddon);

                    // Close out original card addon
                    $cardAddonForClose = (new CardAddon())->getById($appInstanceRel->card_addon_id)->getData()->first();
                    $cardAddonForClose->status = "closed";
                    (new CardAddon())->update($cardAddonForClose);

                    // Close out original order line
                    $orderLineForClose = (new OrderLines())->getById($appInstanceRel->order_line_id)->getData()->first();
                    $orderLineForClose->status = "closed";
                    (new OrderLines())->update($orderLineForClose);

                    $appInstanceRel->app_instance_id = $appInstanceId;
                    $appInstanceRel->module_app_widget_id = $appWidgetId;
                    $appInstanceRel->card_page_id = $sitePageRel->card_tab_id;
                    $appInstanceRel->card_page_rel_id = $sitePageRel->card_tab_rel_id;
                    $appInstanceRel->user_id = $sitePageRel->user_id;
                    $appInstanceRel->card_addon_id = $cardAddonResult->getData()->first()->card_addon_id;
                    $appInstanceRel->order_line_id = $orderLineResult->getData()->first()->order_line_id;
                    $appInstanceRel->status = "active";

                    $appInstanceRelResult = $appInstanceRels->update($appInstanceRel);
                }

                // get Page Addon and then close out the order line and create a new one....
                // TODO - this should reflect an existing widget value that comes from the custom platform
            }

        } else {
            if ($appInstanceRelResult->getResult()->Success === true) {
                $appInstanceRel = $appInstanceRelResult->getData()->first();
                $appInstanceRels->deleteById($appInstanceRel->app_instance_rel_id);
            }
        }


        return $this->renderReturnJson(true, [
            "result" => $objPost,
        ], "success");
    }
}
