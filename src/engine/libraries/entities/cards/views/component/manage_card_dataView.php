<?php
/**
 * Created by PhpStorm.
 * User: Micah.Zak
 * Date: 10/16/2018
 * Time: 11:29 AM
 */

use App\Core\App;
use App\Utilities\Excell\ExcellCollection;
use Entities\Cards\Classes\Cards;
use Entities\Cards\Classes\CardConnections;
use Entities\Cards\Classes\CardRels;
use Entities\Cards\Classes\CardPageRels;
use Entities\Cards\Classes\CardPage;
use Entities\Cards\Classes\CardTemplates;
use Entities\Media\Classes\Images;
use Entities\Products\Classes\Products;
use Entities\Users\Classes\Connections;
use Entities\Users\Classes\Users;

/** @var App $app */

?>
<?php

$objLoggedInUser = $this->app->GetActiveLoggedInUser();

if ($strViewTitle === "addCardAdmin" || $strViewTitle === "editCardAdmin")
{
    $strButtonText = "Create New EZcard";
    $strFormActionType = "addProfile";
    $strFormConroller = "create-card-data";

    $intOwnerId = "";
    $intAffiliateId = "";
    $strOwnerName = "";
    $strAffiliateName = "";
    $intCardId = null;
    $blnUserSpecificCardCreation = false;

    if ($strViewTitle === "addCardAdmin")
    {
        if(!empty($this->app->objHttpRequest->Data->PostData->user_id))
        {
            $objCardOwnerResult = (new Users())->getById($this->app->objHttpRequest->Data->PostData->user_id);

            if ($objCardOwnerResult->Result->Success === true && $objCardOwnerResult->Result->Count > 0)
            {
                $intOwnerId = $objCardOwnerResult->Data->First()->user_id;
                $blnUserSpecificCardCreation = true;

                $objUserAffiliateResult = (new Users())->GetAffiliateByUserId($intOwnerId);

                if ($objUserAffiliateResult->Result->Success === true && $objCardOwnerResult->Result->Count > 0)
                {
                    $intAffiliateId = $objUserAffiliateResult->Data->First()->user_id;
                }

                // Get SalesRep
            }
        }

        $lstPackagesResult = (new Products())->GetAllActiveProducts();
        $lstPackages = $lstPackagesResult->Data;
        $strSelectedPackage = 0;

        $lstTemplatesResult = (new CardTemplates())->getAllRows();
        $lstTemplates = $lstTemplatesResult->Data;
        $strSelectedTemplate = 0;
    }
    else
    {
        if (!empty($this->app->objHttpRequest->Data->PostData->card_id))
        {
            $intCardId     = $this->app->objHttpRequest->Data->PostData->card_id;
            $objCardResult = (new Cards())->getById($intCardId);

            if ( $objCardResult->Result->Success === false)
            {
                die("Error: No card was found for id: $intCardId.");
            }

            $objCard = $objCardResult->Data->First();
            $intOwnerId = $objCard->owner_id;
            $objCardOwnerResult = (new Users())->getById($intOwnerId);
            $objUserAffiliateResult = (new Users())->GetAffiliateByUserId($intOwnerId);
            $intAffiliateId = $objUserAffiliateResult->Result->Count > 0 ? $objUserAffiliateResult->Data->First()->user_id : "";

            $strOwnerName = $objCardOwnerResult->Result->Count > 0 ? $objCardOwnerResult->Data->First()->first_name . " " . $objCardOwnerResult->Data->First()->last_name : "";
            $strAffiliateName = $objUserAffiliateResult->Result->Count > 0 ? $objUserAffiliateResult->Data->First()->first_name . " " . $objUserAffiliateResult->Data->First()->last_name : "";

            $strButtonText = "Update Card Profile";
            $strFormActionType = "editProfileAdmin";
            $strFormConroller = "update-card-data";

            $lstPackagesResult = (new Products())->GetAllActiveProducts();
            $lstPackages = $lstPackagesResult->Data;
            $strSelectedPackage = $lstPackages->FindEntityByValue("product_id", $objCard->product_id);
            $strSelectedPackageId = !empty($strSelectedPackage->product_id) ? $strSelectedPackage->product_id : "0";

            $lstTemplatesResult = (new CardTemplates())->getAllRows();
            $lstTemplates = $lstTemplatesResult->Data;
            $strSelectedTemplate = $lstTemplates->FindEntityByValue("card_template_id", $objCard->template_id);
            $strSelectedTemplateId = !empty($strSelectedTemplate->card_template_id) ? $strSelectedTemplate->card_template_id : "0";
        }
    }

    $intOwnerRandId = time();
    $intAffiliateRandId = time();
    $intVanityRandId = time();
    $intKeywordRandId = time();

    ?>
    <form id= "<?php echo $strViewTitle; ?>Form" autocomplete="off" action="/cards/card-data/<?php echo $strFormConroller; ?>?type=<?php echo $strFormActionType; ?><?php echo  !empty($intCardId) ? '&id='.$intCardId : ''; ?>" method="post">
        <div class="augmented-form-items" style="<?php if ($blnUserSpecificCardCreation === true) { echo "display:none;"; } ?>">
            <table class="table" style="margin-bottom: 5px; margin-top:10px;">
                <tr>
                    <td style="width:100px;vertical-align: middle;">Customer</td>
                    <td>
                        <input autocomplete="off" id="co_<?php echo $intOwnerRandId; ?>" value="<?php echo $strOwnerName; ?>" placeholder="Start Typing..." class="form-control">
                        <input id="co_<?php echo $intOwnerRandId; ?>_id" name="card_owner" value="<?php echo $intOwnerId; ?>" type="hidden">
                    </td>
                </tr>
            </table>
        </div>
        <table class="table no-top-border">
            <tr>
                <td style="width:100px;vertical-align: middle;">Card Name</td>
                <td><input name="card_name" class="form-control" type="text" placeholder="Enter Card Name..." value="<?php echo $objCard->card_name ?? ''; ?>"/></td>
            </tr>
            <tr>
                <td style="width:100px;vertical-align: middle;">Vanity URL</td>
                <td><input name="card_vanity_url" id="vanity_<?php echo $intVanityRandId; ?>" class="form-control<?php if ($strViewTitle === "editCardAdmin") { echo " pass-validation"; } ?>" type="text" placeholder="Enter Vanity URL..." value="<?php echo $objCard->card_vanity_url ?? ''; ?>"/></td>
            </tr>
            <tr>
                <td style="width:100px;vertical-align: middle;">Keyword</td>
                <td><input name="card_keyword" id="keyword_<?php echo $intKeywordRandId; ?>" class="form-control<?php if ($strViewTitle === "editCardAdmin") { echo " pass-validation"; } ?>" type="text" placeholder="Enter Keyword..." value="<?php echo $objCard->card_keyword ?? ''; ?>"/></td>
            </tr>
            <tr>
                <td style="width:100px;vertical-align: middle;">Card Theme</td>
                <td>
                    <select name="template_id" class="form-control">
                        <option value="">--Select Theme--</option>
                        <?php foreach($lstTemplates as $currTemplate) { ?>
                            <option value="<?php echo $currTemplate->card_template_id; ?>"<?php if ($strViewTitle === "editCardAdmin") { echo returnSelectedIfValuesMatch($currTemplate->card_template_id, $strSelectedTemplateId); } ?>><?php echo $currTemplate->name; ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <?php if ($strViewTitle !== "editCardAdmin") { ?>
            <tr>
                <td style="width:100px;vertical-align: middle;">Clone From Card</td>
                <td><input id="clone_frome_card" class="form-control" type="text" placeholder="Enter A Template Id to Clone From..." />
                </td>
            </tr>
            <?php } ?>
            <tr>
                <td style="width:100px;vertical-align: middle;">Card Package</td>
                <td>
                    <select name="product_id" class="form-control">
                        <option value="">--Select Card Package--</option>
                        <?php foreach($lstPackages as $currPackagePlan) { ?>
                            <option value="<?php echo $currPackagePlan->product_id; ?>"<?php if ($strViewTitle === "editCardAdmin") { echo returnSelectedIfValuesMatch($currPackagePlan->product_id, $strSelectedPackageId); } ?>><?php echo $currPackagePlan->title; ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td style="width:100px;vertical-align: middle;">Status</td>
                <td>
                    <select name="status" class="form-control">
                        <option value="Pending" <?php if ($strViewTitle === "editCard") { echo returnSelectedIfValuesMatch($objCard->status ?? '', "Pending"); } ?>>Pending</option>
                        <option value="Active" <?php echo returnSelectedIfValuesMatch($objCard->status ?? 'Active', "Active"); ?>>Active</option>
                        <option value="Inactive" <?php if ($strViewTitle === "editCard") { echo returnSelectedIfValuesMatch($objCard->status ?? '', "Inactive"); } ?>>Inactive</option>
                        <option value="Cancelled" <?php if ($strViewTitle === "editCard") { echo returnSelectedIfValuesMatch($objCard->status ?? '', "Cancelled"); } ?>>Cancelled</option>
                        <option value="Disabled" <?php if ($strViewTitle === "editCard") { echo returnSelectedIfValuesMatch($objCard->status ?? '', "Disabled"); } ?>>Disabled</option>
                    </select>
                </td>
            </tr>
        </table>
        <button class="buttonID9234597e456 btn btn-primary w-100"><?php echo $strButtonText; ?></button>
    </form>
    <script type="text/javascript">
        $( function() {
            app.Search("api/v1/users/get-users","#co_<?php echo $intOwnerRandId; ?>", "users", ["user_id","first_name","last_name"],["user_id","first_name.last_name"]);
            <?php if ($strViewTitle === "editCardAdmin") { ?>
            $(document).on("blur", "#vanity_<?php echo $intVanityRandId; ?>",function(){
                let strVanityUrl = $(this).val();
                if ( strVanityUrl == "") { $("#vanity_<?php echo $intVanityRandId; ?>").removeClass("error-validation").removeClass("pass-validation"); $(".vanity_url-error").remove(); return; }
                ajax.Send("api/v1/cards/check-vanity-url?vanity_url=" + strVanityUrl + "&card_id=<?php echo $intCardId; ?>", null, function(objResult) {
                    switch(objResult.match) {
                        case true:
                            $("#vanity_<?php echo $intVanityRandId; ?>").addClass("error-validation").removeClass("pass-validation");
                            if( $(".vanity_url-error").length == 0) {
                                $("#vanity_<?php echo $intVanityRandId; ?>").after('<div class="error-text vanity_url-error">This Vanity URL Already Exists</div>');
                            }
                            break;
                        default:
                            $("#vanity_<?php echo $intVanityRandId; ?>").removeClass("error-validation").addClass("pass-validation");
                            $(".vanity_url-error").remove();
                            break;
                    }
                });
            });
            $(document).on("blur", "#keyword_<?php echo $intKeywordRandId; ?>",function(){
                let strKeyword = $(this).val();
                if ( strKeyword == "") { $("#keyword_<?php echo $intKeywordRandId; ?>").removeClass("error-validation").removeClass("pass-validation"); $(".keyword-error").remove(); return; }
                ajax.Send("api/v1/cards/check-keyword?keyword=" + strKeyword + "&card_id=<?php echo $intCardId; ?>", null, function(objResult) {
                    switch(objResult.match) {
                        case true:
                            $("#keyword_<?php echo $intKeywordRandId; ?>").addClass("error-validation").removeClass("pass-validation");
                            if( $(".keyword-error").length == 0) {
                                $("#keyword_<?php echo $intKeywordRandId; ?>").after('<div class="error-text keyword-error">This Keyword Already Exists</div>');
                            }
                            break;
                        default:
                            $("#keyword_<?php echo $intKeywordRandId; ?>").removeClass("error-validation").addClass("pass-validation");
                            $(".keyword-error").remove();
                            break;
                    }
                });
            });
            <?php } else { ?>
            $(document).on("blur", "#vanity_<?php echo $intVanityRandId; ?>",function(){
                let strVanityUrl = $(this).val();
                if ( strVanityUrl == "") { $("#vanity_<?php echo $intVanityRandId; ?>").removeClass("error-validation").removeClass("pass-validation"); $(".vanity_url-error").remove(); return; }
                ajax.Send("api/v1/cards/check-vanity-url?vanity_url=" + strVanityUrl, null, function(objResult) {
                    switch(objResult.match) {
                        case true:
                            $("#vanity_<?php echo $intVanityRandId; ?>").addClass("error-validation").removeClass("pass-validation");
                            if( $(".vanity_url-error").length == 0) {
                                $("#vanity_<?php echo $intVanityRandId; ?>").after('<div class="error-text vanity_url-error">This Vanity URL Already Exists</div>');
                            }
                            break;
                        default:
                            $("#vanity_<?php echo $intVanityRandId; ?>").removeClass("error-validation").addClass("pass-validation");
                            $(".vanity_url-error").remove();
                            break;
                    }
                });
            });
            <?php } ?>
        });
    </script>
<?php } ?>
<?php

if ($strViewTitle === "editCardProfile")
{
    if (empty($this->app->objHttpRequest->Data->PostData->card_id))
    {
        die("Error: You must supply a card id to this controller.");
    }

    $intCardId     = $this->app->objHttpRequest->Data->PostData->card_id;
    $objCardResult = (new Cards())->getById($intCardId);

    if ( $objCardResult->Result->Success === false)
    {
        die("Error: No user was found for id: $intUserId.");
    }

    $objCard = $objCardResult->Data->First();

    $lstPackagesResult = (new Products())->GetAllActiveProducts();
    $lstPackages = $lstPackagesResult->Data;
    $strSelectedPackage = $lstPackages->FindEntityByValue("product_id", $objCard->product_id);
    $strSelectedPackageId = !empty($strSelectedPackage->product_id) ? $strSelectedPackage->product_id : "0";

    $lstCardTypesResult = (new Cards())->GetAllCardTypes();
    $lstCardTypes = $lstCardTypesResult->Data;
    $strSelectedCardType = $lstCardTypes->FindEntityByValue("card_type_id", $objCard->card_type_id);
    $strSelectedCardTypeId = $strSelectedCardType->card_type_id;

    $intVanityRandId = time();

    ?>
    <form id= "<?php echo $strViewTitle; ?>Form" action="/cards/card-data/update-card-data?type=profile&id=<?php echo $intCardId; ?>" method="post">
        <table class="table no-top-border">
            <tr>
                <td style="width:100px;vertical-align: middle;">Card Name</td>
                <td><input name="card_name" class="form-control" type="text" placeholder="Enter Card Name..." value="<?php echo $objCard->card_name ?? ''; ?>"/></td>
            </tr>
            <tr>
                <td style="width:100px;vertical-align: middle;">Vanity URL</td>
                <td><input name="card_vanity_url" id="vanity_<?php echo $intVanityRandId; ?>" class="form-control pass-validation" type="text" placeholder="Enter Vanity URL..." value="<?php echo $objCard->card_vanity_url ?? ''; ?>"/></td>
            </tr>
        </table>
        <button class="buttonID12346534576 btn btn-primary w-100">Update Card Profile</button>
    </form>
    <script type="text/javascript">
        $( function() {
            $(document).on("blur", "#vanity_<?php echo $intVanityRandId; ?>",function(){
                let strVanityUrl = $(this).val();
                if ( strVanityUrl == "") { $("#vanity_<?php echo $intVanityRandId; ?>").removeClass("error-validation").removeClass("pass-validation"); $(".vanity_url-error").remove(); return; }
                ajax.Send("api/v1/cards/check-vanity-url?vanity_url=" + strVanityUrl + "&card_id=<?php echo $intCardId; ?>", null, function(objResult) {
                    switch(objResult.match) {
                        case true:
                            $("#vanity_<?php echo $intVanityRandId; ?>").addClass("error-validation").removeClass("pass-validation");
                            if( $(".vanity_url-error").length == 0) {
                                $("#vanity_<?php echo $intVanityRandId; ?>").after('<div class="error-text vanity_url-error">This Vanity URL Already Exists</div>');
                            }
                            break;
                        default:
                            $("#vanity_<?php echo $intVanityRandId; ?>").removeClass("error-validation").addClass("pass-validation");
                            $(".vanity_url-error").remove();
                            break;
                    }
                });
            });
        });
    </script>
<?php } ?>

<?php
if ($strViewTitle === "editConnection")
{
    $intUserConnectionId = "";
    $strSelectedConnectionName = "";
    $objCardConnection = null;
    $lstCardRelTypeResult = (new Users())->GetUserConnectionTypes();
    $lstCardRelType = $lstCardRelTypeResult->Data;
    $strButtonText = "Add Connection";
    $strUserIdField = PHP_EOL;

    if ($strViewTitle === "editConnection")
    {
        if (empty($this->app->objHttpRequest->Data->PostData->connection_rel_id))
        {
            die("Error: You must supply a user connection id to this controller.");
        }

        $intCardConnectionId = $this->app->objHttpRequest->Data->PostData->connection_rel_id;
        $objConnectionResult = (new CardConnections())->getById($intCardConnectionId);

        if ( $objConnectionResult->Result->Success === false)
        {
            die("Error: No card connection was found for id: $intCardConnectionId.");
        }

        $objCardConnection = $objConnectionResult->Data->First();

        $strSelectedConnection = $lstCardRelType->FindEntityByValue("connection_type_id", $objCardConnection->connection_type_id);

        $strSelectedConnectionid = $strSelectedConnection->connection_type_id;

        $strButtonText = "Edit Connection";

    }
?>
    <form id= "<?php echo $strViewTitle; ?>Form" action="/cards/card-data/update-card-data?type=connection&id=<?php echo $intCardConnectionId; ?>" method="post">
        <?php echo $strUserIdField; ?>
        <table class="table no-top-border">
            <tr>
                <td style="width:100px;vertical-align: middle;">Type</td>
                <td>
                    <select class="form-control">
                        <option>--Select Connection Type--</option>
                        <?php foreach($lstCardRelType as $currConnectionType) { ?>
                            <option value="<?php echo $currConnectionType->connection_type_id; ?>"<?php if ($strViewTitle === "editConnection") { echo returnSelectedIfValuesMatch($currConnectionType->connection_type_id, $strSelectedConnectionid); } ?>><?php echo $currConnectionType->name; ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td style="width:100px;vertical-align: middle;">Value</td>
                <td><input class="form-control" type="text" placeholder="Enter Connection Value..." value="<?php echo !empty($objUser->connection_value) ? $objUser->connection_value : ""; ?>"/></td>
            </tr>
        </table>
        <button class="buttonID066653454132"><?php echo $strButtonText; ?></button>
    </form>
<?php } ?>

<?php
if ($strViewTitle === "editConnectionRel")
{
    $intCardId = $this->app->objHttpRequest->Data->PostData->id;
    $intCardConnectionId = 0;
    $intConnectionId = 0;
    $strSelectedConnectionId = "";
    $strSelectedConnectionType = "";
    $objCardConnection = null;

    $objCardResult = (new Cards())->noFks()->getById($intCardId);
    $colConnectionTypeResult = (new Users())->GetUserConnectionTypes();
    $colConnectionType = $colConnectionTypeResult->Data;
    $colCardConnectionsResult = (new CardConnections())->GetByCardId($intCardId);
    $colCardConnections = $colCardConnectionsResult->Data;


    $objCardOwnerResult = (new Users())->getById($objCardResult->Data->First()->owner_id);
    $colLoggedInUserConnections = (new Connections())->getFks()->getWhere(["user_id" => $objLoggedInUser->user_id, "company_id" => $app->objCustomPlatform->getCompanyId()])->Data;
    $lstLoggedInUser = new ExcellCollection();
    $lstLoggedInUser->Add($objLoggedInUser);
    $colLoggedInUserConnections->MergeFields($lstLoggedInUser,["first_name","last_name"],["user_id" => "user_id__value"]);

    $colCardOwnerConnectionsResult = (new Connections())->getFks()->getWhere([["user_id", "=", $objCardResult->Data->First()->owner_id], "AND", ["company_id", "=", $app->objCustomPlatform->getCompanyId()], "AND", ["connection_id", "NOT IN", $colLoggedInUserConnections->FieldsToArray(["connection_id"])]]);
    $colCardOwnerConnections = $colCardOwnerConnectionsResult->Data;
    $colCardOwnerConnections->MergeFields($objCardOwnerResult->Data ,["first_name","last_name"],["user_id" => "user_id__value"]);

    $colCardOwnerConnections->Merge($colLoggedInUserConnections);
    $colUserConnections = $colCardOwnerConnections;

    foreach($colCardConnections as $currCardConnection)
    {
        $objUserConnection = $colUserConnections->FindEntityByValue("connection_id", $currCardConnection->connection_id);

        if ($objUserConnection === null)
        {
            $colUserConnections->Add($currCardConnection);
        }
    }

    $lstConnectionActions = array(
        "Phone" => ["action"=>"phone"],
        "SMS" => ["action"=>"phone"],
        "Fax" => ["action"=>"fax"],
        "Link" => ["action"=>"link"],
        "Email" => ["action"=>"email"],
    );

    $strButtonText = "Update Card Connection";
    $strCardConnectionIdField = '<input type="hidden" name="connection_display_order" value="'.$this->app->objHttpRequest->Data->PostData->display_order.'" />'.PHP_EOL;

    if (!empty($this->app->objHttpRequest->Data->PostData->connection_id))
    {
        $strCardConnectionIdField .= '<input type="hidden" name="connection_rel_id" value="'.$this->app->objHttpRequest->Data->PostData->connection_rel_id.'" />'.PHP_EOL;

        $objUserCurrentConnection = $colCardConnections->FindEntityByValue("connection_id", $this->app->objHttpRequest->Data->PostData->connection_id);
        $strSelectedConnectionId = $this->app->objHttpRequest->Data->PostData->connection_id;

        $strSelectedConnection = $colUserConnections->FindEntityByValue("connection_id", $strSelectedConnectionId);
        $strSelectedConnectionType = $strSelectedConnection->connection_type_id;
        $strSelectedConnectionAction = $colConnectionType->FindEntityByValue("connection_type_id", $strSelectedConnection->connection_type_id__value)->action;
    }

    $strButtonText = "Update Card Connection";

?>
    <form id= "<?php echo $strViewTitle; ?>Form" action="/cards/card-data/update-card-data?type=card-connection&id=<?php echo $intCardId; ?>" method="post">
        <?php echo $strCardConnectionIdField; ?>
        <table class="table no-top-border">
            <tr>
                <td style="width:100px;vertical-align: middle;">Connections</td>
                <td>
                    <input id="edit_connection_field" name="connection_id" autocomplete="false" value="<?php echo $strSelectedConnectionId; ?>" placeholder="--Select a Connection--" class="form-control select-connection-for-card">
                    <input id="edit_connection_action" type="hidden" value="<?php echo $objUserCurrentConnection->action; ?>">
                    <input id="edit_connection_type" type="hidden" value="<?php echo $strSelectedConnectionAction; ?>">
                </td>
            </tr>
            <tr>
                <td style="width:100px;vertical-align: middle;">Action</td>
                <td>
                    <select name="connection_rel_action" class="form-control select-action-for-card-connection">
                        <option data-type="default">--Select Action--</option>
                        <?php foreach($lstConnectionActions as $currActionName => $currActionValue) { ?>
                            <option data-type="<?php echo $currActionValue["action"]; ?>" value="<?php echo strtolower($currActionName); ?>"<?php echo returnSelectedIfValuesMatch($objUserCurrentConnection->action, strtolower($currActionName)); ?>><?php echo $currActionName; ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
        </table>
        <button class="buttonID98556456334 btn btn-primary w-100"><?php echo $strButtonText; ?></button>
    </form>
    <script type="application/javascript">
        if (typeof fnUpdateActionSelection == "undefined")
        {
            fnUpdateActionSelection = function(strChange)
            {
                if ($("#edit_connection_field").val() == "")
                {
                    $(".select-action-for-card-connection option[data-type!=default]").hide();
                    return;
                }

                let strCurrentCardAction = $('.select-action-for-card-connection').val();

                $(".select-action-for-card-connection option").show();
                $(".select-action-for-card-connection option[data-type!=" + strChange + "][data-type!=default]").hide();

                let blnMatchingValue = false;

                $.each($(".select-action-for-card-connection option[data-type=" + strChange + "][data-type!=default]"), function(index,el) {
                    if(strCurrentCardAction == $(el).val())
                    {
                        blnMatchingValue = true;
                    }
                });

                if ( blnMatchingValue != false)
                {
                    return;
                }

                let strFirstMatchingValue = $(".select-action-for-card-connection option[data-type=" + strChange + "][data-type!=default]:first").val();
                $(".select-action-for-card-connection").val(strFirstMatchingValue);
            }
        }

        setTimeout(function() {
            fnUpdateActionSelection($('#edit_connection_type').val());
        },10);

        $(document).on('change', '.select-connection-for-card', function(el, arDatafields) {
            if(arDatafields)
            {
                fnUpdateActionSelection(arDatafields.action);
                $(el).data('action', arDatafields.action);
            }
        });

        $(document).on('change', '.select-action-for-card-connection', function(e) {
            $("#editConnectionRelForm .alert").remove();
            $(this).removeClass("error-outline");
        });

        $('.select-connection-for-card').inputpicker({
            data:[
                <?php foreach($colUserConnections as $currLibrary) {
                $currConnectionType = $colConnectionType->FindEntityByValue("name", $currLibrary->connection_type_id);

                ?>
                {id:"<?php echo $currLibrary->connection_id; ?>", action: "<?php echo $currConnectionType->action; ?>", value:"<?php echo formatAsPhoneIfApplicable($currLibrary->connection_value); ?>", type: "<?php echo $currLibrary->connection_type_id; ?>", user: "<?php echo $currLibrary->first_name . " " . $currLibrary->last_name; ?>"},
                <?php } ?>
            ],
            fields:[
                {name:'type',text:'Type'},
                {name:'action',text:'Action'},
                {name:'value',text:'Value'},
                {name:'user',text:'User'}
            ],
            autoOpen: true,
            headShow: true,
            fieldText : 'value',
            filterOpen: true,
            fieldValue: 'id'
        });

    </script>
<?php } ?>
<?php
if ($strViewTitle === "editMainImage" )
{
    $intCardId = $this->app->objHttpRequest->Data->PostData->card_id;
    $strCardMainImage = "";

    $objCardResult = (new Cards())->getById($intCardId);
    $objImageResult = (new Images())->getWhere(["entity_id" => $intCardId, "image_class" => "main-image", "entity_name" => "card"],"image_id.DESC");

    if ($objImageResult->Result->Success === true && $objImageResult->Result->Count > 0)
    {
        $strCardMainImage = $objImageResult->Data->First()->url;
    }

    // Fire wall for bad card id.

    $objCard = $objCardResult->Data->First();

    $intCardNum = $objCard->card_num;

    if($objImageResult->Result->Success === true && $objImageResult->Result->Count > 0) { ?>
        <?php echo $success_message; ?>
        <div class="mainImage">
            <div class="slim" data-ratio="1:1" data-force-size="650,650" data-service="/process/slim/upload?entity_id=<?php echo $intCardId; ?>&user_id=<?php echo $objLoggedInUser->user_id; ?>&entity_name=card&class=main-image" id="my-cropper">
                <input type="file"/>
                <img src="<?php echo $strCardMainImage; ?>" alt="">
            </div>
        </div>
    <?php } else { ?>
        <?php echo $success_message; ?>
        <div class="mainImage">
            <div class="slim" data-ratio="1:1" data-force-size="650,650" data-service="/process/slim/upload?entity_id=<?php echo $intCardId; ?>&user_id=<?php echo $objLoggedInUser->user_id; ?>&entity_name=card&class=main-image" id="my-cropper">
                <input type="file"/>
            </div>
        </div>
    <?php } ?>
    <button class="buttonID9234597e456 btn btn-primary w-100" style="margin-top:10px;" onclick="slimBannerApp.saveAvatar();">Save Main Image</button>
    <script type="application/javascript">
        if (typeof slimBannerApp !== "function")
        {
            SlimBannerApplication = function()
            {
                let _ = this;

                this.updateEntityAvatar = function(url)
                {
                    document.getElementById("entityMainImage").src = url;
                    modal.CloseFloatShield();
                }

                this.saveAvatar = function()
                {
                    Slim.save(document.getElementById("my-cropper"), function() {
                    });
                }
            }

            slimBannerApp = new SlimBannerApplication();
        }

        objMyCropper = document.getElementById("my-cropper");
        Slim.destroy(objMyCropper);
        Slim.create(objMyCropper, Slim.getOptionsFromAttributes(objMyCropper, {browseButton: false, uploadButton: false}),
            {app: slimBannerApp, method: "updateEntityAvatar"})
    </script>
    <?php
}
?>
<?php
if ($strViewTitle === "editFaviconImage" )
{
    $intCardId = $this->app->objHttpRequest->Data->PostData->card_id;
    $strCardMainImage = "";

    $objCardResult = (new Cards())->getById($intCardId);
    $objImageResult = (new Images())->getWhere(["entity_id" => $intCardId, "image_class" => "favicon-image", "entity_name" => "card"],"image_id.DESC");

    if ($objImageResult->Result->Success === true && $objImageResult->Result->Count > 0)
    {
        $strCardMainImage = $objImageResult->Data->First()->url;
    }

    // Fire wall for bad card id.

    $objCard = $objCardResult->Data->First();

    $intCardNum = $objCard->card_num;

    if($objImageResult->Result->Success === true && $objImageResult->Result->Count > 0) { ?>
        <div class="mainImage">
            <div class="slim" data-ratio="1:1" data-force-size="180,180" data-service="/process/slim/upload?entity_id=<?php echo $intCardId; ?>&user_id=<?php echo $objLoggedInUser->user_id; ?>&entity_name=card&class=favicon-image" id="my-cropper">
                <input type="file"/>
                <img src="<?php echo $strCardMainImage; ?>" alt="">
            </div>
        </div>
    <?php } else { ?>
        <?php echo $success_message; ?>
        <div class="mainImage">
            <div class="slim" data-ratio="1:1" data-force-size="180,180" data-service="/process/slim/upload?entity_id=<?php echo $intCardId; ?>&user_id=<?php echo $objLoggedInUser->user_id; ?>&entity_name=card&class=favicon-image" id="my-cropper">
                <input type="file"/>
            </div>
        </div>
    <?php } ?>
    <button class="buttonID9234597e456 btn btn-primary w-100" style="margin-top:10px;" onclick="slimFaviconApp.saveAvatar();">Save Favicon Image</button>
    <script type="application/javascript">
        if (typeof slimFaviconApp !== "function")
        {
            SlimFaviconApplication = function()
            {
                let _ = this;

                this.updateEntityAvatar = function(url)
                {
                    document.getElementById("entityFavicon").src = url;
                    modal.CloseFloatShield();
                }

                this.saveAvatar = function()
                {
                    Slim.save(document.getElementById("my-cropper"), function() {
                    });
                }
            }

            slimFaviconApp = new SlimFaviconApplication();
        }

        objMyCropper = document.getElementById("my-cropper");
        Slim.destroy(objMyCropper);
        Slim.create(objMyCropper, Slim.getOptionsFromAttributes(objMyCropper, {browseButton: false, uploadButton: false}),
            {app: slimFaviconApp, method: "updateEntityAvatar"})
    </script>
    <?php
}

if (
        $strViewTitle === "editCardPageFromLibrary" ||
        $strViewTitle === "editCardPage" ||
        $strViewTitle === "addCardPage" ||
        $strViewTitle === "editCardPageAdmin" ||
        $strViewTitle === "addCardPageAdmin" ||
        $strViewTitle === "editLibraryTabAdmin" ||
        $strViewTitle === "addLibraryTabAdmin")
{

    $intCardId = $this->app->objHttpRequest->Data->PostData->id;
    $intOwnerId = null;

    if (empty($this->app->objHttpRequest->Data->PostData->owner_id))
    {
        $intOwnerId = (new Cards())->getById($intCardId)->Data->First()->owner_id;
    }
    else
    {
        $intOwnerId = $this->app->objHttpRequest->Data->PostData->owner_id;
    }

    $objCurrentUser = $this->app->GetActiveLoggedInUser();
    $strModalAction = (strpos($strViewTitle,"add") !== false) ? "add" : "edit";

    $strCardPageIdField = '';
    $strNoCardIdField = "";
    $strUpdateLimitations = "";
    $intCardPageId = "new";
    $strSource = "tabEditor";
    $objCardPage = null;
    $objCardPageType = 1;
    $objCardPageRel = null;
    $arTabClassProperties = [];

    $strUpdateDataMethod = "add-card-tab";
    $strUpdateRelDataMethod = "add-card-library-tab-rel";
    $strActionButtonText = "Add New Page";

    $objTemplateTabResults = null;

    if ($objCurrentUser->IsAdmin())
    {
        $objTemplateTabResults = (new CardPage())->getFks(["card_tab_type_id"])->getWhere(["library_tab" => 1, "company_id" => $app->objCustomPlatform->getCompanyId()]);
        $arCardUserId = $objTemplateTabResults->Data->FieldsToArray(["user_id"]);
        $lstCardOwner = (new Users())->getWhereIn("user_id", $arCardUserId)->Data;
        $objTemplateTabResults->Data->MergeFields($lstCardOwner,["first_name","last_name"],["user_id" => "user_id"]);
    }
    else
    {
        $objTemplateTabResults = (new CardPage())->getFks(["card_tab_type_id"])->getWhere(["user_id" => $intOwnerId, "library_tab" => 1, "company_id" => $app->objCustomPlatform->getCompanyId()]);
        $lstCardOwner = (new Users())->getById($intOwnerId)->Data;
        $objTemplateTabResults->Data->MergeFields($lstCardOwner,["first_name","last_name"],["user_id" => "user_id"]);
    }

    $lstLoggedInUser = new ExcellCollection();
    $lstLoggedInUser->Add($objLoggedInUser);
    $objTemplateTabFirst = $objTemplateTabResults->Data->First();
    $objModulesResult = (new \Entities\Modules\Classes\ModuleApps())->getLatestModuleWidgetsByNameAsc();
    $colModules = $objModulesResult->Data;
    $strFirstTabClass = $colModules->First();

    // Look up speciality tabs based on what??

    if ($strViewTitle === "addCardPageAdmin")
    {
        if ($strFirstTabClass === $objTemplateTabFirst->content)
        {
            // Get Properties for
            $arTabClassPropertiesResult = (new CardPage())->GetTabClassProperties($strFirstTabClass);

            if ($arTabClassPropertiesResult->Result->Count > 0)
            {
                $arTabClassProperties = $arTabClassPropertiesResult->Data;
            }
        }
    }

    if ($strViewTitle === "addLibraryTabAdmin")
    {
        $intCardId = "null";
        $strUpdateDataMethod = "add-card-library-tab";
        $strUpdateRelDataMethod = "add-card-library-tab";
        $strSource = "tabLibraryEditor";
        $strActionButtonText = "Add New Library Tab";
        $strNoCardIdField = '<input type="hidden" name="no_card_id" value="true" />' . PHP_EOL . '<input type="hidden" name="tab_library" value="true" />'.PHP_EOL;
    }

    if ($strViewTitle === "editCardPage" || $strViewTitle === "editCardPageAdmin")
    {
        $intCardPageId = $this->app->objHttpRequest->Data->PostData->card_tab_id;
        $intCardPageRelId = $this->app->objHttpRequest->Data->PostData->card_tab_rel_id;
        $objCardPageResult = (new CardPage())->getById($intCardPageId);

        if ($objCardPageResult->Result->Count === 1)
        {
            $objCardPage = $objCardPageResult->Data->First();

            $arTabClassPropertiesResult = (new CardPage())->GetTabInstanceClassProperties($arTabClassProperties, $objCardPage->card_tab_data->Properties ?? null);

            if ($arTabClassPropertiesResult->Result->Count > 0)
            {
                $arTabClassProperties = $arTabClassPropertiesResult->Data;
            }
        }

        if ($objCardPageResult->Result->Success === false)
        {
            die("Error: No tab data was found for this entry: " . $intCardPageId);
        }

        $strCardPageIdField .= '<input type="hidden" name="card_tab_id" value="'.$intCardPageId.'" />'.PHP_EOL;
        $objCardPage = $objCardPageResult->Data->First();

        if ($strFirstTabClass === $objCardPage->content)
        {
            // Get Properties for
            $arTabClassPropertiesResult = (new CardPage())->GetTabClassProperties($strFirstTabClass);

            if ($arTabClassPropertiesResult->Result->Count > 0)
            {
                $arTabClassProperties = $arTabClassPropertiesResult->Data;
            }
        }

        $objCardPageRelResult = (new CardPageRels())->getById($intCardPageRelId);

        if($objCardPageRelResult->Result->Count === 1)
        {
            $objCardPageRel = $objCardPageRelResult->Data->First();

            if (!empty($this->app->objHttpRequest->Data->PostData->source) && $this->app->objHttpRequest->Data->PostData->source == "tabLibrary")
            {
                $strSource = "tabLibraryEditor";
                $strUpdateDataMethod = "edit-card-library-tab&card_tab_rel_id=" . $objCardPageRel->card_tab_rel_id;
                $strActionButtonText = "Update Library Tab";
                $strNoCardIdField .= '<input type="hidden" name="no_card_id" value="true" />' . PHP_EOL . '<input type="hidden" name="tab_library" value="true" />'.PHP_EOL;
            }
            else
            {
                $strUpdateDataMethod = "edit-card-tab&card_tab_rel_id=" . $objCardPageRel->card_tab_rel_id;
                $strActionButtonText = "Update Tab";

                if ($objCardPage->library_tab == true)
                {
                    $strUpdateDataMethod = "edit-card-tab-rel";
                    $strUpdateRelDataMethod = "edit-card-library-tab-rel&card_tab_rel_id=" . $objCardPageRel->card_tab_rel_id;
                    $strActionButtonText = "Edit Library Tab";
                }
            }

            if ( $objCardPage->card_tab_type_id__value == 2 || $objCardPage->card_tab_type_id == 2)
            {
                $objCardPageType = 2;

                if ($objCardPageResult->Result->Count === 1)
                {
                    $objCardPage = $objCardPageResult->Data->First();

                    $arTabClassPropertiesResult = (new CardPage())->GetTabInstanceClassProperties($arTabClassProperties, $objCardPage->card_tab_data->Properties ?? null);

                    if ($arTabClassPropertiesResult->Result->Count > 0)
                    {
                        $arTabClassProperties = $arTabClassPropertiesResult->Data;
                    }
                }

                if ($objCardPageRelResult->Result->Count === 1)
                {
                    $objCardPageRel = $objCardPageRelResult->Data->First();

                    if(!empty($objCardPageRel->card_tab_rel_data))
                    {
                        $arTabClassPropertiesResult = (new CardPage())->GetTabInstanceClassProperties($arTabClassProperties, $objCardPageRel->card_tab_rel_data->Properties);

                        if ($arTabClassPropertiesResult->Result->Count > 0)
                        {
                            $arTabClassProperties = $arTabClassPropertiesResult->Data;
                        }
                    }
                }

                $strSystemTabCustomProperties = (new CardPage())->BuildTabClassPropertiesFields($arTabClassProperties);
            }
        }

        if ($strViewTitle === "editCardPage" ) {
            $strUpdateLimitations = "&limit=customer";
        }
    }

    $strManageSystemCardPage = "addLibraryTabSpecialAdminForm";

    if ($strViewTitle === "editCardPageFromLibrary")
    {
        $strManageSystemCardPage = "editLibraryTabSpecialAdminForm";

        $objCurrentUser = $this->app->GetActiveLoggedInUser();
        $intCardPageId = $this->app->objHttpRequest->Data->PostData->card_tab_id;
        $objCardPageResult = (new CardPage())->getById($intCardPageId);
        $objCardPage = $objCardPageResult->Data->First();
        $objCardWidgetResult = (new \Entities\Modules\Classes\AppInstances())->getWhere(["card_tab_id" => $objCardPage->card_tab_id]);
        $objCardWidget = $objCardWidgetResult->Data->First();
        $strCardPageIdField = '<input type="hidden" name="card_tab_id" value="'.$intCardPageId.'" />'.PHP_EOL;
        $strCardPageIdField .= '<input type="hidden" name="card_tab_type_id" value="'. $objCardPage->card_tab_type_id.'" />'.PHP_EOL;

        $strUpdateDataMethod = "edit-card-tab&card_tab_rel_id=" . $objCardPageRel->card_tab_rel_id;
        $strActionButtonText = "Update Tab";
        $strNoCardIdField .= '<input type="hidden" name="no_card_id" value="true" />' . PHP_EOL;

        if ($objCardPage->library_tab == true)
        {
            $strUpdateDataMethod = "edit-card-library-tab";
            $strUpdateRelDataMethod = "edit-card-library-tab&card_tab_rel_id=" . $objCardPageRel->card_tab_rel_id;
            $strActionButtonText = "Update Library Tab";
            $strNoCardIdField .= '<input type="hidden" name="tab_library" value="true" />' . PHP_EOL;
        }

        if ( $objCardPage->card_tab_type_id__value == 2 || $objCardPage->card_tab_type_id == 2)
        {
            $objCardPageType = 2;
        }
    }

    ?>
    <input id="card_tab_management_type" value="<?php echo $strViewTitle; ?>" type="hidden" />
    <?php
    if (
        (
            ($strViewTitle === "editCardPage" || $strViewTitle === "editCardPageAdmin")
            //&& (!empty($objCardPageRel) && $objCardPageRel->card_tab_rel_type != "mirror" )
        )
        || ($strViewTitle === "addCardPage" || $strViewTitle === "addCardPageAdmin")
        || ($strViewTitle === "editCardPageFromLibrary")
        || ($strViewTitle === "addLibraryTabAdmin")
    ) { ?>
    <form data-id="7323535464" <?php if ( $strViewTitle === "addCardPageAdmin" || $strViewTitle === "addCardPage" || ( $objCardPageType === 2 && ( $strViewTitle === "addCardPageFromLibrary" || $strViewTitle === "editCardPageFromLibrary" )) || $strViewTitle === "addLibraryTabAdmin" || $strUpdateDataMethod === "edit-card-tab-rel") { ?>style="display:none;"<?php } ?> id= "<?php echo $strViewTitle; ?>Form" action="/cards/card-data/update-card-data?type=<?php echo $strUpdateDataMethod; ?><?php echo $strUpdateLimitations; ?>&id=<?php echo $intCardId; ?>&card_tab_id=<?php echo $intCardPageId; ?>" method="post">
        <?php echo $strCardPageIdField; ?>
        <?php echo $strNoCardIdField; ?>
        <div class="divTable">
            <div class="divRow">
                <div class="divCell">
                    <input placeholder="Enter a tab title..." style="margin-bottom:10px;"  class="form-control" id="tab_title" name="tab_title" value="<?php echo str_replace('"','&#34;', $objCardPage->title ?? ""); ?>" />
                </div>
                <?php if ($strViewTitle != "addLibraryTabAdmin") { ?>
                <?php if ($strSource != "tabLibraryEditor") { ?>
                <div class="divCell desktop-125px desktop-padding-left-15px" style="vertical-align: middle;white-space:nowrap;">
                    <span style="font-weight:bold; position: relative;top: 5px;">Visibility</span>
                    <label class="switch">
                        <input name="visibility" type="checkbox" <?php if (!empty($objCardPageRel) && (($objCardPageRel->rel_visibility == true && $objCardPageRel->card_tab_rel_type == "default") || ($objCardPageRel->rel_visibility == true && $objCardPageRel->card_tab_rel_type == "mirror"))) { echo "checked"; } ?>>
                        <span class="slider round"></span>
                    </label>
                </div>
                <?php } ?>
                <?php if ($strSource == "tabLibraryEditor" || empty($objCardPage) || $objCardPage->library_tab != true ) { ?>
                <div class="divCell desktop-175px desktop-padding-left-15px" style="vertical-align: middle;white-space:nowrap;">
                    <span style="font-weight: bold; position: relative;top: 5px;">Library Widget</span>
                    <label class="switch">
                        <input name="library_tab" type="checkbox" <?php if (!empty($objCardPage) && $objCardPage->library_tab == true) { echo "checked"; } ?>>
                        <span class="slider round"></span>
                    </label>
                </div>
                <?php } ?>
                <?php if ($strSource != "tabLibraryEditor" && !empty($objCardPage) && $objCardPage->library_tab == true ) { ?>
                <div class="divCell desktop-115px desktop-padding-left-15px" style="vertical-align: middle;white-space:nowrap;">
                    <span class="btn btn-secondary" style="cursor: default;padding: 3px 10px;margin-bottom: 7px;">Library Widget</span>
                </div>
                <?php } ?>
                <?php } else { ?>
                    <input name="library_tab" type="checkbox" checked style="display:none;">
                    <input type="hidden" name="card_tab_type_id" value="1">
                    <input name="visibility" type="checkbox" checked style="display:none;">

                <?php } ?>
            </div>
        </div>
        <textarea name="tab_content"><?php echo base64_decode($objCardPage->content ?? ""); ?></textarea>
        <script>
            $(function() { $('textarea')
                .froalaEditor({
                    key: '<?php echo FroalaLicense; ?>',
                    heightMin: 150,
                    iconsTemplate: 'font_awesome_5',
                    imageManagerPreloader: '/website/images/LoadingIcon2.gif',
                    imageEditButtons: ['imageReplace', 'imageAlign', 'imageCaption', 'imageLink', 'linkOpen', 'linkEdit', 'linkRemove','imageDisplay', 'imageStyle', 'imageAlt', 'imageSize'],
                    imageUploadURL: 'https://app.ezcardmedia.com/upload-image/users/<?php echo $objLoggedInUser->user_id; ?>',
                    imagesLoadURL: 'https://app.ezcardmedia.com/upload-image/users/<?php echo $objLoggedInUser->user_id; ?>',
                    imageManagerDeleteURL: 'https://app.ezcardmedia.com/delete-image/users/<?php echo $objLoggedInUser->user_id; ?>',
                    imageManagerLoadURL: 'https://app.ezcardmedia.com/list-images/users/<?php echo $objLoggedInUser->user_id; ?>',
                    imageUploadRemoteUrls: true,
                    imageUploadMethod: 'POST',
                    imageManagerLoadMethod: "GET",
                    imageUploadParams: {
                        user_id: <?php echo $objLoggedInUser->user_id; ?>,
                        entity_id: <?php echo $objLoggedInUser->user_id; ?>,
                        image_class: 'editor'
                    },
                    inlineStyles: {
                        'Width100&': 'width: 100% !important; height: auto !important;'
                    }
                })
                .on('froalaEditor.image.uploaded', function (e, editor, response) {
                    // Image was uploaded to the server.
                    console.log(JSON.stringify(response));
                })
                .on('froalaEditor.image.inserted', function (e, editor, $img, response) {
                    // Image was inserted in the editor.
                    console.log(JSON.stringify(response));
                })
                .on('froalaEditor.image.replaced', function (e, editor, $img, response) {
                    // Image was replaced in the editor.
                    console.log(JSON.stringify(response));
                })
                .on('froalaEditor.image.removed', function (e, editor, $img) {
                    console.log(JSON.stringify($img));
                    $.ajax({
                            // Request method.
                        method: "POST",

                        // Request URL.
                        url: "https://app.ezcardmedia.com/delete-image/users/<?php echo $objLoggedInUser->user_id; ?>",

                        // Request params.
                        data: {
                            id: $img.data('id')
                        }
                    })
                    .done (function (data) {
                        console.log ('image was deleted');
                    })
                    .fail (function () {
                        console.log ('image delete problem');
                    })
                })
                .on('froalaEditor.image.error', function (e, editor, error, response) {
                    console.log(JSON.stringify(error));
                    console.log(JSON.stringify(response));
                })
                .on('froalaEditor.imageManager.error', function (e, editor, error, response) {
                    // Bad link. One of the returned image links cannot be loaded.
                    console.log(JSON.stringify(error));
                    console.log(JSON.stringify(response));
                })
            });
        </script>
        <button style="margin-top:10px;" class="buttonID5576785443523 btn btn-primary w-100"><?php echo $strActionButtonText; ?></button>
    </form>
    <form data-id="23453456345" <?php if ( ($strViewTitle === "editCardPage" || $strViewTitle === "editCardPageFromLibrary" || $objCardPageType === 2 || $strViewTitle === "editCardPageAdmin" ||  $strViewTitle === "addCardPage" || $strViewTitle === "addCardPageAdmin" || $strViewTitle === "addLibraryTabAdmin") && $strUpdateDataMethod !== "edit-card-tab-rel" ) { ?>style="display:none;"<?php } ?> id= "<?php echo $strViewTitle; ?>LibraryTabForm" action="/cards/card-data/update-card-data?type=<?php echo $strUpdateRelDataMethod; ?><?php echo $strUpdateLimitations; ?>&tab_type=html-tab&id=<?php echo $intCardId; ?>&card_tab_id=<?php echo $intCardPageId; ?>" method="post">
        <input type="hidden" name="no_card_id" value="true" />
        <input type="hidden" name="card_tab_type_id" value="<?php echo $objCardPageType; ?>" />
        <div class="divTable">
            <div class="divRow">
                <div class="divCell">
                    <input id="edit_card_tab_field" name="card_library_tab_id" autocomplete="false" value="<?php echo $intCardPageId !== "new" ? $intCardPageId : ""; ?>" placeholder="--Select a Library Widget--" class="form-control select-library-instance-tab-for-card">
                </div>
                <?php if ($strSource != "tabLibraryEditor") { ?>
                    <div class="divCell desktop-125px desktop-padding-left-15px" style="vertical-align: middle;white-space:nowrap;">
                        <span style="font-weight:bold; position: relative;top: 5px;">Visibility</span>
                        <label class="switch">
                            <input name="visibility" type="checkbox" <?php if (!empty($objCardPage) && (($objCardPageRel->rel_visibility == true && $objCardPageRel->card_tab_rel_type == "default") || ($objCardPageRel->rel_visibility == true && $objCardPageRel->card_tab_rel_type == "mirror"))) { echo "checked"; } ?>>
                            <span class="slider round"></span>
                        </label>
                    </div>
                <?php } ?>
            </div>
        </div>
        <hr/>
        <div id="tabLibraryInstanceCustomAttributes" style="<?php if ($objCardPage->card_tab_type_id != 2 ) { echo 'display:none;'; } ?>background:#ddd;padding: 0 8px 0;border-radius:5px;box-shadow:rgba(0,0,0,.2) 0 0 10px inset;margin-top:10px;">
            <div class="tabLibraryInstanceCustomAttributes_empty" style="padding:10px;">No Custom Attributes Found.</div>
            <div class="tabLibraryInstanceCustomAttributes_full" style="display:none;"></div>
        </div>
        <div id="tabLibraryInstanceHtmlPreview" style="pointer-events: none;<?php if ($objCardPage->card_tab_type_id == 2 ) { echo 'display:none;'; } ?>background:#fff;padding: 15px 15px 15px;border-radius:5px;box-shadow:rgba(0,0,0,.2) 0 0 10px inset;margin-top:10px;">
            <?php if (($objCardPage->card_tab_type_id ?? null) != 2 && !empty($objCardPage->content)) { echo base64_decode($objCardPage->content); } ?>
        </div>
        <script type="text/javascript">

            blnFunctionRestriction = false;

            if (typeof engageSelectLibraryTab !== "function" ) {
                function engageSelectLibraryTab() {
                    $('.select-library-instance-tab-for-card').inputpicker({
                        data:[
                            <?php foreach($objTemplateTabResults->Data as $currLibrary) {

                            ?>
                            {id:"<?php echo $currLibrary->card_tab_id; ?>", type: "<?php echo $currLibrary->card_tab_type_id; ?>", type_value: "<?php echo $currLibrary->card_tab_type_id__value; ?>", value:"<?php echo onlyAlphanumeric($currLibrary->title); ?>", content:"<?php echo ($currLibrary->card_tab_type_id === "Template File" ? $currLibrary->content : ""); ?>", user: "<?php echo onlyAlphanumeric($currLibrary->first_name) . " " . onlyAlphanumeric($currLibrary->last_name); ?>"},
                            <?php } ?>
                        ],
                        fields:[
                            {name:'value',text:'Value'},
                            {name:'type',text:'Type'},
                            {name:'type_value',text:'TypeValue'},
                            {name:'content',text:'Content'},
                            {name:'user',text:'User'}
                        ],
                        autoOpen: true,
                        headShow: true,
                        fieldText : 'value',
                        filterOpen: true,
                        fieldValue: 'id'
                    }).on("change", function(evt, arDatafields) {
                        if(arDatafields)
                        {
                            if ( blnFunctionRestriction === true) { return; }
                            blnFunctionRestriction = true;

                            $('#<?php echo $strViewTitle; ?>LibraryTabForm #card_tab_type_id').val(arDatafields.type_value);

                            console.log(arDatafields);

                            if (arDatafields.type_value == 2)
                            {
                                $("#tabLibraryInstanceCustomAttributes").show();
                                $("#tabLibraryInstanceHtmlPreview").hide().html('');;
                                changeTabInstanceCustomAttributes("<?php echo $strModalAction; ?>", arDatafields.value, <?php echo $objCardPageRel->card_tab_rel_id ?? "null"; ?>, arDatafields.type_value, 'tabLibraryInstanceCustomAttributes', arDatafields.content);
                                blnFunctionRestriction = false;
                            }
                            else
                            {
                                $("#tabLibraryInstanceHtmlPreview").show().html();
                                $("#tabLibraryInstanceCustomAttributes").hide();
                                $(".tabLibraryInstanceCustomAttributes_full").hide();
                                $(".tabLibraryInstanceCustomAttributes_empty").show();
                                blnFunctionRestriction = false;
                                updateTabInstanceHtmlDisplay("<?php echo $strModalAction; ?>", arDatafields.value, <?php echo $objCardPageRel->card_tab_rel_id ?? "null"; ?>, arDatafields.type_value, 'tabLibraryInstanceHtmlPreview');
                            }
                        }
                    });
                }
            }

            setTimeout(function() {
                $("#tabLibraryInstanceCustomAttributes").addClass("ajax-loading-anim").css("position","relative");
                changeTabInstanceCustomAttributes('edit', <?php echo $objCardPage->card_tab_id ?? "null"; ?>, <?php echo $objCardPageRel->card_tab_rel_id ?? "null"; ?>, <?php echo $objCardPage->card_tab_type_id ?? "1"; ?>,'tabLibraryInstanceCustomAttributes');
            }, 1000);
        </script>
        <button style="margin-top:10px;" class="buttonID73645675656 btn btn-primary w-100"><?php echo $strActionButtonText; ?></button>
    </form>
    <form data-id="54745673455" id="<?php echo $strManageSystemCardPage; ?>" <?php if ($objCardPageType !== 2 || ($strViewTitle !== "addCardPageFromLibrary" && $strViewTitle !== "editCardPageFromLibrary")) { ?>style="display:none;"<?php } ?> action="/cards/card-data/update-card-data?type=<?php echo $strUpdateRelDataMethod; ?><?php echo $strUpdateLimitations; ?>&tab_type=system-tab&id=<?php echo $intCardId; ?>&card_tab_id=<?php echo $intCardPageId; ?>" method="post">
        <input type="hidden" name="no_card_id" value="true" />
        <input type="hidden" name="card_tab_type_id" value="2">
        <?php echo $strCardPageIdField; ?>
        <?php $optGroup = ''; ?>
        <div class="divTable">
            <div class="divRow">
                <div class="divCell" style="width:125px;vertical-align: middle;">Module Widget</div>
                <div class="divCell">
                    <select id="tab_class" name="tab_class" class="form-control" onchange="changeTabCustomAttributes(<?php echo $objCardWidget->sys_row_id ?? "null"; ?>, 'tabLibraryCustomAttributes')">
                        <option value="X">--Select Module Widget--</option>
                        <?php
                            $colModules->Each(function($currModule) use (&$optGroup){
                                $optGroupStart = false;

                                if ($optGroup === '' || $currModule->module_name !== $optGroup)
                                {
                                    $optGroupStart = true;
                                    echo '<optgroup label="' . $currModule->module_name . '">';
                                    $optGroup = $currModule->module_name;
                                }

                                ?>
                            <option value="<?php echo $currModule->module_app_id; ?>"><?php echo $currModule->module_name . " | " .  $currModule->name; ?></option>
                            <?php
                                if ($optGroupStart === true)
                                {
                                    $optGroupStart = true;
                                    echo '</optgroup>';
                                }
                            ?>
                            <?php }); ?>
                    </select>
                </div>
            </div>
            <div class="divRow">
                <div class="divCell" style="width:125px;vertical-align: middle;">Module Title</div>
                <div class="divCell">
                    <input placeholder="Enter a tab title..." style="margin-top:10px;"  class="form-control" id="tab_title" name="tab_title" value="<?php echo str_replace('"','&#34;',$objCardPage->title ?? ""); ?>" />
                </div>
            </div>
        </div>
        <hr/>
        <div id="tabLibraryCustomAttributes" style="background:#ddd;padding: 0px 8px 0px;border-radius:5px;box-shadow:rgba(0,0,0,.2) 0 0 10px inset;margin-top:10px;">
            <?php if ($strModalAction === "edit" && ($strViewTitle === "editCardPageAdmin" || $strViewTitle === "addCardPageAdmin")) { ?>
                <div class="tabLibraryCustomAttributes_empty" style="padding:10px;">No Custom Attributes Found.</div>
                <div class="tabLibraryCustomAttributes_full" style="display:none;"></div>
            <?php } else { ?>
            <div class="tabLibraryCustomAttributes_empty" style="padding:10px;">No Custom Attributes Found.</div>
            <div class="tabLibraryCustomAttributes_full" style="display:none;"></div>
            <?php } ?>
        </div>
        <style>
            .tab-property-radio label {
                margin-right:10px;
            }
        </style>
        <script type="text/javascript">
            if (typeof createTabPropertyInputs !== "function" ) {
                function createTabPropertyInputs(objTabProperty) {

                    if (typeof objTabProperty === "undefined")
                    {
                        return "";
                    }

                    let strHtmlProperties = "";

                    switch(objTabProperty.type)
                    {
                        case "radio":
                            strHtmlProperties += '<div class="width50 tab-property-radio"><h5>'+objTabProperty.label+'</h5>';
                            strHtmlProperties += '<div style="margin-top:5px;margin-bottom: 10px;"><label for="'+objTabProperty.name+'_'+objTabProperty.options[0]+'"><input type="radio" name="'+objTabProperty.name+'" id="'+objTabProperty.name+'_'+objTabProperty.options[0]+'" value="'+objTabProperty.options[0]+'" ' + ( objTabProperty.options[0] == objTabProperty.default ? 'checked' : '') + ' /> '+objTabProperty.options[0] + '</label>';
                            strHtmlProperties += '<label for="'+objTabProperty.name+'_'+objTabProperty.options[1]+'"><input type="radio" name="'+objTabProperty.name+'" id="'+objTabProperty.name+'_'+objTabProperty.options[1]+'" value="'+objTabProperty.options[1]+'" ' + ( objTabProperty.options[1] == objTabProperty.default ? 'checked' : '') + ' /> '+objTabProperty.options[1] + '</label>';
                            strHtmlProperties += '</div></div>';
                            break;
                        case "select":
                            strHtmlProperties += '<div class="width50 tab-property-select"><h5>'+objTabProperty.label+'</h5>';
                            strHtmlProperties += '<label for="'+objTabProperty.name+'"><select class="form-control form-control-sm" name="'+objTabProperty.name+'" id="'+objTabProperty.name+'">';
                            for(let currIndex in objTabProperty.options)
                            {
                                const currOptionValue = objTabProperty.options[currIndex];
                                strHtmlProperties += '<option value="' + currIndex + '" ' + ( currIndex == objTabProperty.default ? 'selected' : '') + '>' + currOptionValue + '</option>';
                            }
                            strHtmlProperties += '</select></label>';
                            strHtmlProperties += '</div></div>';
                            break;
                        case "text":
                            strHtmlProperties += '<div class="width50 tab-property-text"><h5>'+objTabProperty.label+'</h5>';
                            strHtmlProperties += '<label for="'+objTabProperty.name+'" style="width:calc(100% - 25px)"><input type="text" value="' + objTabProperty.default + '" style="width:100%;" class="form-control form-control-sm" name="'+objTabProperty.name+'" id="'+objTabProperty.name+'" /></label>';
                            strHtmlProperties += '</div>';
                            break;
                    }

                    return strHtmlProperties;
                }
            }

            if (typeof changeTabCustomAttributes !== "function" ) {
                function changeTabCustomAttributes(gdInstanceId, strFormAttributeToggle) {
                    let strCustomTabClass = $('#tab_class').val();
                    if (strCustomTabClass === "X") { return; }
                    ajax.Send("cards/card-data/get-module-widget-configuration?module_app_id=" + strCustomTabClass + "&instance_id=" + gdInstanceId,
                        null,
                        function(objResult)
                        {
                            if (typeof objResult.tab === "undefined" || objResult.tab.length === 0)
                            {
                                $("#" + strFormAttributeToggle).removeClass("ajax-loading-anim");
                                $("." + strFormAttributeToggle + "_full").hide();
                                $("." + strFormAttributeToggle + "_empty").show();
                                return;
                            }

                            $("." + strFormAttributeToggle + "_full").show();
                            $("." + strFormAttributeToggle + "_empty").hide();

                            $("#" + strFormAttributeToggle).removeClass("ajax-loading-anim");

                            let strHtmlProperties = "<div style='padding:12px 10px;'>";

                            for(let currPropertyIndex in objResult.tab)
                            {
                                let objTabProperty = objResult.tab[currPropertyIndex];
                                strHtmlProperties += createTabPropertyInputs(objTabProperty);
                            }

                            strHtmlProperties += "<div style='clear:both;'></div></div>";
                            $("." + strFormAttributeToggle + "_full").html(strHtmlProperties);
                        },
                        "POST",
                        function(objError) {
                            $("#" + strFormAttributeToggle).removeClass("ajax-loading-anim");
                        });
                }
            }

            <?php echo "//" . $strViewTitle.PHP_EOL; ?>
            <?php if ($strModalAction === "edit") { ?>
                <?php if ($strViewTitle === "editCardPageFromLibrary" ) { ?>
            setTimeout(function() {
                $("#tabLibraryCustomAttributes").addClass("ajax-loading-anim").css("position","relative");
                changeTabCustomAttributes('<?php echo $objCardWidget->sys_row_id ?? "null"; ?>', 'tabLibraryCustomAttributes');
            }, 200);
                <?php } elseif ($strViewTitle === "editCardPageAdmin") { ?>
            setTimeout(function() {
                $("#tabLibraryInstanceCustomAttributes").addClass("ajax-loading-anim").css("position","relative");
                changeTabInstanceCustomAttributes('edit', <?php echo $objCardPage->card_tab_id ?? "null"; ?>, <?php echo $objCardPageRel->card_tab_rel_id ?? "null"; ?>, <?php echo $objCardPage->card_tab_type_id ?? "1"; ?>,'tabLibraryInstanceCustomAttributes');
            }, 1000);
                <?php }?>
            <?php } ?>
        </script>
        <button style="margin-top:10px;" class="buttonID23542445 btn btn-primary w-100"><?php echo $strActionButtonText; ?></button>
    </form>
    <script type="text/javascript">
        if (typeof createTabInstancePropertyInputs !== "function" ) {
            function createTabInstancePropertyInputs(objTabProperty) {

                if (typeof objTabProperty === "undefined")
                {
                    return "";
                }

                let strHtmlProperties = "";

                switch(objTabProperty.type)
                {
                    case "radio":
                        strHtmlProperties += '<div class="width50 tab-property-radio"><h5>'+objTabProperty.label+'</h5>';
                        strHtmlProperties += '<div style="margin-top:5px;margin-bottom: 10px;"><label for="'+objTabProperty.name+'_'+objTabProperty.options[0]+'"><input type="radio" name="'+objTabProperty.name+'" id="'+objTabProperty.name+'_'+objTabProperty.options[0]+'" value="'+objTabProperty.options[0]+'" ' + ( objTabProperty.options[0] == objTabProperty.default ? 'checked' : '') + ' /> '+objTabProperty.options[0] + '</label>';
                        strHtmlProperties += '<label for="'+objTabProperty.name+'_'+objTabProperty.options[1]+'"><input type="radio" name="'+objTabProperty.name+'" id="'+objTabProperty.name+'_'+objTabProperty.options[1]+'" value="'+objTabProperty.options[1]+'" ' + ( objTabProperty.options[1] == objTabProperty.default ? 'checked' : '') + ' /> '+objTabProperty.options[1] + '</label>';
                        strHtmlProperties += '</div></div>';
                        break;
                    case "select":
                        strHtmlProperties += '<div class="width50 tab-property-select"><h5>'+objTabProperty.label+'</h5>';
                        strHtmlProperties += '<label for="'+objTabProperty.name+'"><select class="form-control form-control-sm" name="'+objTabProperty.name+'" id="'+objTabProperty.name+'">';
                        for(let currIndex in objTabProperty.options)
                        {
                            const currOptionValue = objTabProperty.options[currIndex];
                            strHtmlProperties += '<option value="' + currIndex + '" ' + ( currIndex == objTabProperty.default ? 'selected' : '') + '>' + currOptionValue + '</option>';
                        }
                        strHtmlProperties += '</select></label>';
                        strHtmlProperties += '</div></div>';
                        break;
                    case "text":
                        strHtmlProperties += '<div class="width50 tab-property-text"><h5>'+objTabProperty.label+'</h5>';
                        strHtmlProperties += '<label for="'+objTabProperty.name+'" style="width:calc(100% - 25px)"><input type="text" value="' + objTabProperty.default + '" style="width:100%;" class="form-control form-control-sm" name="'+objTabProperty.name+'" id="'+objTabProperty.name+'" /></label>';
                        strHtmlProperties += '</div>';
                        break;
                }

                return strHtmlProperties;
            }
        }

        if (typeof updateTabInstanceHtmlDisplay !== "function" )
        {
            function updateTabInstanceHtmlDisplay(strAction, intCardPageId, intCardPageRelId, intCardPageTypeId, strFormAttributeToggle)
            {
                let strChangeTabInstanceHtmlUrl = "/cards/card-data/get-tab-content-for-display?action=" + strAction + "&card_tab_id=" + intCardPageId + "&card_tab_rel_id=" + intCardPageRelId;

                ajax.Send(strChangeTabInstanceHtmlUrl,
                    null,
                    function(objResult)
                    {
                        $("#" + strFormAttributeToggle).html(objResult.html).removeClass("ajax-loading-anim");
                        blnFunctionRestriction = false;
                    },
                    "POST",
                    function(objError) {
                        $("#" + strFormAttributeToggle).removeClass("ajax-loading-anim");
                        console.log(objError);
                        blnFunctionRestriction = false;
                    });
            }
        }

        if (typeof changeTabInstanceCustomAttributes !== "function" )
        {
            function changeTabInstanceCustomAttributes(strAction, intCardPageId, intCardPageRelId, intCardPageTypeId, strFormAttributeToggle, strCustomTabClass)
            {
                if (strCustomTabClass === "") { return; }

                let strChangeTabInstanceCustomAttributesUrl = "/cards/card-data/get-custom-tab-rel-attributes?action=" + strAction + "&tab_class=" + strCustomTabClass + "&card_tab_id=" + intCardPageId + "&card_tab_rel_id=" + intCardPageRelId;

                if (intCardPageTypeId != 2 || !strCustomTabClass || !intCardPageId || (!intCardPageRelId && strAction != "add")) {
                    $("#" + strFormAttributeToggle).removeClass("ajax-loading-anim");
                    blnFunctionRestriction = false;
                    return;
                }

                $("#" + strFormAttributeToggle).addClass("ajax-loading-anim").css("position","relative");

                ajax.Send(strChangeTabInstanceCustomAttributesUrl,
                    null,
                    function(objResult)
                    {
                        if (typeof objResult.tab === "undefined" || objResult.tab.length === 0)
                        {
                            $("#" + strFormAttributeToggle).removeClass("ajax-loading-anim");
                            $("." + strFormAttributeToggle + "_full").hide();
                            $("." + strFormAttributeToggle + "_empty").show();
                            return;
                        }

                        $("." + strFormAttributeToggle + "_full").show();
                        $("." + strFormAttributeToggle + "_empty").hide();
                        $("#" + strFormAttributeToggle).removeClass("ajax-loading-anim");

                        let strHtmlProperties = "<div style='padding:12px 10px;'>";

                        for(let currPropertyIndex in objResult.tab)
                        {
                            let objTabProperty = objResult.tab[currPropertyIndex];

                            strHtmlProperties += createTabInstancePropertyInputs(objTabProperty);
                        }

                        strHtmlProperties += "<div style='clear:both;'></div></div>";

                        $("." + strFormAttributeToggle + "_full").html(strHtmlProperties);

                        changeTabCustomSetup(intCardPageId, strFormAttributeToggle, strCustomTabClass);

                        blnFunctionRestriction = false;
                    },
                    "POST",
                    function(objError) {
                        $("#" + strFormAttributeToggle).removeClass("ajax-loading-anim");
                        console.log(objError);
                        blnFunctionRestriction = false;
                    });
            }
        }

        if (typeof changeTabCustomSetup !== "function" ) {
            function changeTabCustomSetup(intCardPageId, strFormAttributeToggle, strCustomTabClass) {
                ajax.Send("cards/card-data/get-tab-setup?tab_class=" + strCustomTabClass + "&card_tab_id=" + intCardPageId,
                    null,
                    function(objResult)
                    {
                        console.log(objResult);

                        if (typeof objResult.html === "undefined")
                        {
                            console.log("HTML undefuned")
                            return;
                        }

                        let strHtmlProperties = "<div class='custom_tab_setup_dialog' style='padding:12px 10px;'><h5> Tab Configuration</h5>";
                        strHtmlProperties += '<div style="margin-top:2px;background:#fff;border-radius:5px;padding:5px 10px">';
                        strHtmlProperties += objResult.html;
                        strHtmlProperties += "<div style='clear:both;'></div></div></div>";

                        $("." + strFormAttributeToggle + "_full").append(strHtmlProperties);
                    },
                    "POST",
                    function(objError) {

                    });
            }
        }
    </script>
    <?php
    }
    elseif (
        ($strViewTitle === "editCardPage" || $strViewTitle === "addCardPage" || $strViewTitle === "editCardPageAdmin" || $strViewTitle === "addCardPageAdmin")
        &&
        $objCardPage->card_tab_type_id != 2
    ) { ?>
    <form data-id="16346685656" id="<?php echo $strViewTitle; ?>Form" action="/cards/card-data/update-card-data?type=<?php echo $strUpdateDataMethod; ?>&id=<?php echo $intCardId; ?>&card_tab_id=<?php echo $intCardPageId; ?>" method="post">
        <?php echo $strCardPageIdField; ?>
        <?php echo $strNoCardIdField; ?>
        <div class="divTable">
            <div class="divRow">
                <div class="divCell">
                    <input disabled placeholder="Enter a tab title..." style="margin-bottom:10px;"  class="form-control" id="tab_title"  value="<?php echo str_replace('"','&#34;',$objCardPage->title ?? ""); ?>" />
                </div>
                <?php if ($strSource != "tabLibraryEditor") { ?>
                    <div class="divCell desktop-125px desktop-padding-left-15px" style="vertical-align: middle;white-space:nowrap;">
                        <span style="font-weight:bold; position: relative;top: 5px;">Visibility</span>
                        <label class="switch">
                            <input name="visibility" type="checkbox" <?php if (($objCardPage->visibility == true && $objCardPageRel->card_tab_rel_type == "default") || ($objCardPageRel->rel_visibility == true && $objCardPageRel->card_tab_rel_type == "mirror")) { echo "checked"; } ?>>
                            <span class="slider round"></span>
                        </label>
                    </div>
                <?php }?>
                <?php if ($strSource != "tabLibraryEditor" && $objCardPage->library_tab == true ) { ?>
                    <div class="divCell desktop-115px desktop-padding-left-15px" style="vertical-align: middle;white-space:nowrap;">
                        <span class="btn btn-secondary" style="cursor: default;padding: 3px 10px;margin-bottom: 7px;">Library Tab</span>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div style="padding:15px; border-radius:2px; background:#eaeaef; border:1px solid #c9cbd0; min-height:50px;"><?php

            if ($objCardPage->card_tab_type_id != 2 && $objCardPage->card_tab_type_id__value != 2 )
            {
                echo strip_tags(base64_decode($objCardPage->content ?? ""));
            }
            else
            {
                echo "This tab content is generated by our system dynamically.";
            }

            ?></div>
        <button style="margin-top:10px;" class="btn btn-primary w-100"><?php echo $strActionButtonText; ?></button>
    </form>
    <?php
    } elseif (
        ($objCardPage->card_tab_type_id == 2 || $objCardPage->card_tab_type_id__value == 2)
        &&
        $strSource == "tabLibraryEditor"
        &&
        ($strViewTitle === "editCardPage" || $strViewTitle === "addCardPage" || $strViewTitle === "editCardPageAdmin" || $strViewTitle === "addCardPageAdmin" )
    ) {

    ?>
    <form data-id="673576456534" id="<?php echo $strViewTitle; ?>Form" action="/cards/card-data/update-card-data?type=<?php echo $strUpdateDataMethod; ?>&id=<?php echo $intCardId; ?>&card_tab_id=<?php echo $intCardPageId; ?>" method="post">
        <?php echo $strCardPageIdField; ?>
        <?php echo $strNoCardIdField; ?>
        <div class="divTable">
            <div class="divRow">
                <div class="divCell">
                    <input disabled placeholder="Enter a tab title..." style="margin-bottom:10px;"  class="form-control" id="tab_title"  value="<?php echo str_replace('"','&#34;',$objCardPage->title ?? ""); ?>" />
                </div>
            </div>
            <div class="divRow">
                <select class="form-control">
                    <option>--Select Template File For Tab Rendering--</option>

                </select>
            </div>
            <div class="divRow">
                This is where
            </div>
        </div>
        <button style="margin-top:10px;" class="btn btn-primary w-100"><?php echo $strActionButtonText; ?></button>
    </form>
    <?php
    } else {

        ?>
    <form data-id="23478764566" id="<?php echo $strViewTitle; ?>Form" action="/cards/card-data/update-card-data?type=<?php echo $strUpdateDataMethod; ?>&id=<?php echo $intCardId; ?>&card_tab_id=<?php echo $intCardPageId; ?>" method="post">
        <?php echo $strCardPageIdField; ?>
        <?php echo $strNoCardIdField; ?>
        <div class="divTable">
            <div class="divRow">
                <div class="divCell">
                    <input disabled placeholder="Enter a tab title..." style="margin-bottom:10px;"  class="form-control" id="tab_title"  value="<?php echo str_replace('"','&#34;',$objCardPage->title ?? ""); ?>" />
                    <input type="hidden" name="tab_class" value="<?php echo str_replace('"','&#34;',$objCardPage->title ?? ""); ?>" />
                </div>
            </div>
        </div>
        <hr/>
        <div id="tabLibraryCustomAttributes" style="background:#ddd;padding: 0px 8px 0px;border-radius:5px;box-shadow:rgba(0,0,0,.2) 0 0 10px inset;margin-top:10px;">
                <div class="tabLibraryCustomAttributes_empty" style="padding:10px;">No Custom Attributes Found.</div>
                <div class="tabLibraryCustomAttributes_full" style="display:none;"></div>
        </div>
    </form>
    <script>
        if (typeof createTabPropertyInputs !== "function" ) {
            function createTabPropertyInputs(objTabProperty) {

                if (typeof objTabProperty === "undefined")
                {
                    return "";
                }

                let strHtmlProperties = "";

                switch(objTabProperty.type)
                {
                    case "radio":
                        strHtmlProperties += '<div class="width50 tab-property-radio"><h5>'+objTabProperty.label+'</h5>';
                        strHtmlProperties += '<div style="margin-top:5px;margin-bottom: 10px;"><label for="'+objTabProperty.name+'_'+objTabProperty.options[0]+'"><input type="radio" name="'+objTabProperty.name+'" id="'+objTabProperty.name+'_'+objTabProperty.options[0]+'" value="'+objTabProperty.options[0]+'" ' + ( objTabProperty.options[0] == objTabProperty.default ? 'checked' : '') + ' /> '+objTabProperty.options[0] + '</label>';
                        strHtmlProperties += '<label for="'+objTabProperty.name+'_'+objTabProperty.options[1]+'"><input type="radio" name="'+objTabProperty.name+'" id="'+objTabProperty.name+'_'+objTabProperty.options[1]+'" value="'+objTabProperty.options[1]+'" ' + ( objTabProperty.options[1] == objTabProperty.default ? 'checked' : '') + ' /> '+objTabProperty.options[1] + '</label>';
                        strHtmlProperties += '</div></div>';
                        break;
                    case "select":
                        break;
                    case "text":
                        strHtmlProperties += '<div class="width50 tab-property-text"><h5>'+objTabProperty.label+'</h5>';
                        strHtmlProperties += '<label for="'+objTabProperty.name+'" style="width:calc(100% - 25px)"><input type="text" value="' + objTabProperty.default + '" style="width:100%;" class="form-control form-control-sm" name="'+objTabProperty.name+'" id="'+objTabProperty.name+'" /></label>';
                        strHtmlProperties += '</div>';
                        break;
                }

                return strHtmlProperties;
            }
        }

        if (typeof changeTabCustomAttributes !== "function" ) {
            function changeTabCustomAttributes(gdInstanceId, strFormAttributeToggle) {
                let strCustomTabClass = $('#tab_class').val();
                console.log(strCustomTabClass);
                if (strCustomTabClass === "X") { return; }
                $("#" + strFormAttributeToggle).addClass("ajax-loading-anim").css("position","relative");
                ajax.Send("cards/card-data/get-module-widget-configuration?module_app_id=" + strCustomTabClass + "&instance_id=" + gdInstanceId,
                    null,
                    function(objResult)
                    {
                        if (typeof objResult.tab === "undefined" || objResult.tab.length === 0)
                        {
                            $("#" + strFormAttributeToggle).removeClass("ajax-loading-anim");
                            $("." + strFormAttributeToggle + "_full").hide();
                            $("." + strFormAttributeToggle + "_empty").show();
                            return;
                        }

                        $("." + strFormAttributeToggle + "_full").show();
                        $("." + strFormAttributeToggle + "_empty").hide();
                        $("#" + strFormAttributeToggle).removeClass("ajax-loading-anim");

                        let strHtmlProperties = "<div style='padding:12px 10px;'>";

                        for(let currPropertyIndex in objResult.tab)
                        {
                            let objTabProperty = objResult.tab[currPropertyIndex];
                            strHtmlProperties += createTabPropertyInputs(objTabProperty);
                        }

                        strHtmlProperties += "<div style='clear:both;'></div></div>";
                        $("." + strFormAttributeToggle + "_full").html(strHtmlProperties);
                    },
                    "POST",
                    function(objError) {
                        $("#" + strFormAttributeToggle).removeClass("ajax-loading-anim");
                    });
            }
        }
        <?php if ($strModalAction === "edit") { ?>
        <?php if ($strViewTitle === "editCardPageAdmin") { ?>
        setTimeout(function() {
            changeTabCustomAttributes(<?php echo $objCardPage->card_tab_id ?? "null"; ?>, 'tabLibraryCustomAttributes');
        }, 200);
        <?php }?>
        <?php } ?>
    </script>
    <?php
    }
    ?>
<?php
}

if ($strViewTitle === "editCardMainColor")
{
    $intCardId = $this->app->objHttpRequest->Data->PostData->card_id;

    $strCardMainImage = "/_ez/templates/" . ( $objCard->template_id ?? "1" ) . "/images/mainImage.jpg";
    $intRandomId = time();

    $objCardResult = (new Cards())->getById($intCardId);
    $objCard = $objCardResult->Data->First();
    $objImageResult = (new Images())->getWhere(["entity_id" => $intCardId, "image_class" => "main-image", "entity_name" => "card"]);

    if ($objImageResult->Result->Success === true && $objImageResult->Result->Count > 0)
    {
        $strCardMainImage = $objImageResult->Data->First()->url;
    }
?>
    <div class="divTable">
        <div class="divRow">
            <div class="divCell">
                <img id="main-image-color-selector" src="<?php echo $strCardMainImage; ?>" width="256" height="256" alt="" style="margin-right:15px;" />
            </div>
            <div class="divCell">
                <form id="updateCardParmaryColorForm" method="post">
                    <p id="colorpickerHolder_<?php echo $intRandomId; ?>"></p>
                    <button id="updateCardParmaryColorSubmit" class="btn btn-primary w-100">Update Color</button>
            </div>
        </div>
    </div>

    <script type="application/javascript">
        $('#colorpickerHolder_<?php echo $intRandomId; ?>').colpick({
            color:'<?php echo $objCard->card_data->style->card->color->main ?? "ff0000"; ?>',
            flat:true,
            layout:'hex',
            onSubmit: function(objColPick, strHex)
            {
                modal.EngageFloatShield();

                customerApp.UpdateCardData("style.card.color.main", strHex, function(result){
                    $('.card-main-color-block').css("backgroundColor","#" + strHex);
                    modal.CloseFloatShield(function() {
                        modal.CloseFloatShield();
                    });
                });
            }
        });
        $(document).on("click","#updateCardParmaryColorSubmit",function() {
            $(".colpick_submit").click();
        });

        $(document).on("click","#main-image-color-selector",function() {
            let img = document.getElementById('main-image-color-selector');
            let canvas = document.createElement('canvas');
            canvas.width = img.width;
            canvas.height = img.height;
            canvas.getContext('2d').drawImage(img, 0, 0, img.width, img.height);

            let pixelData = canvas.getContext('2d').getImageData(event.offsetX, event.offsetY, 1, 1).data;

            //console.log(JSON.stringify(pixelData));
        });

    </script>
    <style>
        .colpick_submit {
            display:none;
        }
        .colpick.colpick_hex .colpick_hex_field {
            width: 114px;
        }
    </style>
<?php }

if ($strViewTitle === "editCardPageColor")
{
    $intCardPageRelId = $this->app->objHttpRequest->Data->PostData->card_tab_rel_id;
    $strCardMainImage = "/_ez/templates/" . ( $objCard->template_id ?? "1" ) . "/images/mainImage.jpg";
    $intRandomId = time();

    $objCardPageRelResult = (new CardPageRels())->getById($intCardPageRelId);
    $objCardPageRel = $objCardPageRelResult->Data->First();

    $objCardResult = (new Cards())->getById($objCardPageRel->card_id);
    $objCard = $objCardResult->Data->First();

    $cardTabRelData = $objCardPageRel->card_tab_rel_data;

    $tabColor = $cardTabRelData->Properties->TabCustomColor ?? ($objCard->card_data->style->card->color->main ?? "ff0000");

    $objImageResult = (new Images())->getWhere(["entity_id" => $intCardId, "image_class" => "main-image", "entity_name" => "card"]);

    if ($objImageResult->Result->Success === true && $objImageResult->Result->Count > 0)
    {
        $strCardMainImage = $objImageResult->Data->First()->url;
    }
?>
    <div class="divTable">
        <div class="divRow">
            <div class="divCell">
                <p id="colorpickerHolder_<?php echo $intRandomId; ?>"></p>
                <button id="updateCardParmaryColorSubmit" class="btn btn-primary w-100">Update Tab Color</button>
                <button id="resetCardParmaryColorSubmit" class="btn btn-secondary w-100" style="margin-top:5px">Reset</button>
            </div>
        </div>
    </div>

    <script type="application/javascript">
        $('#colorpickerHolder_<?php echo $intRandomId; ?>').colpick({
            color:'<?php echo $tabColor; ?>',
            flat:true,
            layout:'hex',
            onSubmit: function(objColPick, strHex)
            {
                modal.EngageFloatShield();

                customerApp.UpdateCardPageRelData("TabCustomColor", <?php echo $intCardPageRelId; ?>, strHex, function(result){
                    console.log(result);
                    modal.CloseFloatShield(function() {
                        modal.CloseFloatShield();
                    });
                });
            }
        });

        $(document).on("click","#updateCardParmaryColorSubmit",function() {
            $(".colpick_submit").click();
        });

        $(document).on("click","#main-image-color-selector",function() {
            let img = document.getElementById('main-image-color-selector');
            let canvas = document.createElement('canvas');
            canvas.width = img.width;
            canvas.height = img.height;
            canvas.getContext('2d').drawImage(img, 0, 0, img.width, img.height);

            let pixelData = canvas.getContext('2d').getImageData(event.offsetX, event.offsetY, 1, 1).data;

            //console.log(JSON.stringify(pixelData));
        });

    </script>
    <style>
        .colpick_submit {
            display:none;
        }
        .colpick.colpick_hex .colpick_hex_field {
            width: 114px;
        }
    </style>
<?php }

if ($strViewTitle === "editCardUserAdmin" || $strViewTitle === "addCardUserAdmin")
{
    $intUserConnectionId = "";
    $strSelectedConnectionName = "";
    $objUser = null;
    $lstCardRelTypeResult = (new Cards())->GetCardRelTypes(["NOT" => ["1", "9", "8"]]);
    $lstCardRelType = $lstCardRelTypeResult->Data;
    $strButtonText = "Add Card User";
    $strUserIdField = PHP_EOL;
    $intOwnerRandId = time();
    $intCardId = $this->app->objHttpRequest->Data->PostData->card_id;

    if ($strViewTitle === "editCardUserAdmin")
    {
        if (empty($this->app->objHttpRequest->Data->PostData->card_rel_id))
        {
            die("Error: You must supply a card user id to this controller.");
        }

        $intCardRelId = $this->app->objHttpRequest->Data->PostData->card_rel_id;
        $intCardRelTypeId = $this->app->objHttpRequest->Data->PostData->card_rel_type_id;

        if ($intCardRelTypeId != 1)
        {
            $objCardRelResult = (new CardRels())->getById($intCardRelId);

            if ( $objCardRelResult->Result->Success === false)
            {
                die("Error: No card user found for id: $intCardRelId.");
            }

            $objCardRel = $objCardRelResult->Data->First();

            $objUserResult = (new Users())->getById($objCardRel->user_id);

            if ( $objUserResult->Result->Success === false)
            {
                die("Error: No card user found for id: $intCardRelId.");
            }

            $objCardUser = $objUserResult->Data->First();

            $strOwnerName = $objCardUser->first_name . " " . $objCardUser->last_name;
            $intOwnerId = $objCardUser->user_id;

            if(in_array($objCardRel->card_rel_type_id, [8,9]))
            {
                $lstCardRelTypeResult = (new Cards())->GetCardRelTypes();
                $lstCardRelType = $lstCardRelTypeResult->Data;
            }

            $strSelectedConnection = $lstCardRelType->FindEntityByValue("card_rel_type_id", $objCardRel->card_rel_type_id);
            $strSelectedConnectionid = $strSelectedConnection->card_rel_type_id;
        }
        else
        {
            $objCardResult = (new Cards())->getById($intCardId);

            if ( $objCardResult->Result->Success === false || $objCardResult->Result->Count === 0 )
            {
                die("Error: No card found for id: $intCardId.");
            }

            $objCardUserResult = (new Users())->getById($objCardResult->Data->First()->owner_id);

            if ( $objCardUserResult->Result->Success === false )
            {
                die("Error: No card user found for id: {$objCardResult->Data->First()->owner_id}.");
            }

            $objCardUser = $objCardUserResult->Data->First();

            $strOwnerName = $objCardUser->first_name . " " . $objCardUser->last_name;
            $intOwnerId   = $objCardUser->user_id;

            $strSelectedConnectionid = 1;

            $lstCardRelTypeResult = (new Cards())->GetCardRelTypes();
            $lstCardRelType = $lstCardRelTypeResult->Data;
        }

        $strButtonText = "Edit Card User";
    }
?>
    <form data-id="93023523416" id= "<?php echo $strViewTitle; ?>Form" action="/cards/card-data/update-card-data?type=add-user-role-to-card&id=<?php echo $intCardId; ?>" method="post">
        <?php echo $strUserIdField; ?>
        <input name="card_id" type="hidden" id="card_id" value="<?php echo $intCardId; ?>">
        <div style="background:#ddd;padding: 0px 8px 0px;border-radius:5px;box-shadow:rgba(0,0,0,.2) 0 0 10px inset; <?php if ($blnUserSpecificCardCreation === true) { echo "display:none;"; } ?>">
            <table class="table" style="margin-bottom: 5px; margin-top:10px;">
                <tr>
                    <td style="width:100px;vertical-align: middle;">Customer</td>
                    <td>
                        <?php if ( !in_array($strSelectedConnectionid,[1,8,9]))
                        {?>
                        <input autocomplete="off" id="co_<?php echo $intOwnerRandId; ?>" value="<?php echo $strOwnerName; ?>" placeholder="Start Typing..." class="form-control">
                        <input id="co_<?php echo $intOwnerRandId; ?>_id" name="user_id" value="<?php echo $intOwnerId; ?>" type="hidden">
                            </select>
                        <?php } else { ?>
                            <input class="form-control" disabled value="<?php echo $strOwnerName; ?>" />
                        <?php } ?>
                    </td>
                </tr>
            </table>
        </div>
        <table class="table no-top-border">
            <tr>
                <td style="width:100px;vertical-align: middle;">Role</td>
                <td>
                    <?php if ( !in_array($strSelectedConnectionid,[1,8,9]))
                        {?>
                    <select name="card_role" class="form-control">
                        <option value="">--Select User Association Type--</option>
                        <?php foreach($lstCardRelType as $currConnectionType) { ?>
                            <option value="<?php echo $currConnectionType->card_rel_type_id; ?>"<?php if ($strViewTitle === "editCardUserAdmin") { echo returnSelectedIfValuesMatch($currConnectionType->card_rel_type_id, $strSelectedConnectionid); } ?>><?php echo $currConnectionType->name; ?></option>
                        <?php } ?>
                    </select>
                    <?php } else { ?>
                        <input class="form-control" disabled value="<?php echo $lstCardRelType->FindEntityByValue("card_rel_type_id", $strSelectedConnectionid)->name; ?>" />
                    <?php } ?>
                </td>
            </tr>
        </table>
        <?php if ( !in_array($strSelectedConnectionid,[1,8,9]))
        {?>
        <button class="btn btn-primary w-100"><?php echo $strButtonText; ?></button>
        <?php } else { ?>
        <div class="btn btn-secondary w-100" style="cursor:default;">Read-Only Display</div>
        <?php } ?>
    </form>
    <script type="text/javascript">
        $( function() {
            app.Search("api/v1/users/get-users","#co_<?php echo $intOwnerRandId; ?>", "users", ["user_id","first_name","last_name"],["user_id","first_name.last_name"]);
        });
    </script>
<?php }

if ($strViewTitle === "editCardUser" || $strViewTitle === "addCardUser" )
{
    $intUserConnectionId = "";
    $strSelectedConnectionName = "";
    $objUser = null;
    $lstCardRelTypeResult = (new Cards())->GetCardRelTypes(["NOT" => ["1", "9", "8"]]);
    $lstCardRelType = $lstCardRelTypeResult->Data;
    $strButtonText = "Add Card User";
    $strUserIdField = PHP_EOL;

    if ($strViewTitle === "editConnection")
    {
        if (empty($this->app->objHttpRequest->Data->PostData->connection_id))
        {
            die("Error: You must supply a user connection id to this controller.");
        }

        $intUserConnectionId = $this->app->objHttpRequest->Data->PostData->connection_id;
        $objUserResult = (new Users())->GetConnectionById($intUserConnectionId);

        if ( $objUserResult->Result->Success === false)
        {
            die("Error: No connection was found for id: $intUserConnectionId.");
        }

        $objUser = $objUserResult->Data->First();

        $strSelectedConnection = $lstCardRelType->FindEntityByValue("connection_type_id", $objUser->connection_type_id);

        $strSelectedConnectionid = $strSelectedConnection->connection_type_id;

        $strButtonText = "Edit Card User";
    }
?>
    <form id= "<?php echo $strViewTitle; ?>Form" action="/customers/user-data/update-user-data?type=connection&id=<?php echo $intUserConnectionId; ?>" method="post">
        <?php echo $strUserIdField; ?>
        <table class="table no-top-border">
            <tr>
                <td style="width:100px;vertical-align: middle;">Value</td>
                <td><input class="form-control" type="text" placeholder="Enter Connection Value..." value="<?php echo !empty($objUser->connection_value) ? $objUser->connection_value : ""; ?>"/></td>
            </tr>
            <tr>
                <td style="width:100px;vertical-align: middle;">Type</td>
                <td>
                    <select class="form-control">
                        <option value="">--Select User Association Type--</option>
                        <?php foreach($lstCardRelType as $currConnectionType) { ?>
                            <option value="<?php echo $currConnectionType->connection_type_id; ?>"<?php if ($strViewTitle === "editConnection") { echo returnSelectedIfValuesMatch($currConnectionType->connection_type_id, $strSelectedConnectionid); } ?>><?php echo $currConnectionType->name; ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
        </table>
        <button class="btn btn-primary w-100"><?php echo $strButtonText; ?></button>
    </form>
<?php } ?>
