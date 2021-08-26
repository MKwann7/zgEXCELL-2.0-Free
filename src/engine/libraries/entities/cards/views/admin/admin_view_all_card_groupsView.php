<?php
/**
 * Created by PhpStorm.
 * User: Micah.Zak
 * Date: 10/11/2018
 * Time: 9:43 AM
 */

$this->CurrentPage->BodyId            = "view-card-groups-admin-page";
$this->CurrentPage->BodyClasses       = ["admin-page", "view-card-groups-admin-page", "no-columns"];
$this->CurrentPage->Meta->Title       = "Card Groups | Admin | " . $this->app->objCustomPlatform->getPortalName();
$this->CurrentPage->Meta->Description = "Welcome to the NEW AMAZING WORLD of EZ Digital Cards, where you can create and manage your own cards!";
$this->CurrentPage->Meta->Keywords    = "";
$this->CurrentPage->SnipIt->Title     = "Card Groups";
$this->CurrentPage->SnipIt->Excerpt   = "Welcome to the NEW AMAZING WORLD of EZ Digital Cards, where you can create and manage your own cards!";
$this->CurrentPage->Columns           = 0;

?>
<div class="breadCrumbs">
    <div class="breadCrumbsInner">
        <a href="/account" class="breadCrumbHomeImageLink">
            <img src="/media/images/home-icon-01_white.png" class="breadCrumbHomeImage" width="15" height="15" />
        </a> &#187;
        <a href="/account" class="breadCrumbHomeImageLink">
            <span class="breadCrumbPage">Home</span>
        </a> &#187;
        <a href="/account/dashboard" class="breadCrumbHomeImageLink">
            <span class="breadCrumbPage">Admin</span>
        </a> &#187;
        <a href="/account/admin/cards" class="breadCrumbHomeImageLink">
            <span class="breadCrumbPage">Cards</span>
        </a> &#187;
        <span id="view-list">
            <span class="breadCrumbPage">Card Groups</span>
        </span>
        <span id="editing-entity">
            <a id="backToViewEntityList" href="/account/admin/cards/card-groups" class="breadCrumbHomeImageLink">
                <span class="breadCrumbPage">Card Groups</span>
            </a> &#187;
            <span class="breadCrumbPage">Card Group Dashboard</span>
        </span>
    </div>
</div>
<div class="BodyContentBox">
    <style type="text/css">
        .BodyContentBox .entityList.table-striped td:nth-child(4),
        .BodyContentBox .entityList.table-striped td:nth-child(6) {
            width:8%;
        }
        .BodyContentBox .entityList.table-striped td {
            width:10%;
        }
        .BodyContentBox .entityList.table-striped td:first-child {
            width:13%;
        }
        .BodyContentBox .entityList.table-striped td:nth-child(6),
        .BodyContentBox .entityList.table-striped td:nth-child(5) {
            width:15%;
        }
        .BodyContentBox .entityList.table-striped td:nth-child(2) {
            width:18%;
        }
        .breadCrumbs #editing-entity {
            display:none;
        }
        .breadCrumbs .breadCrumbsInner.edit-entity #editing-entity {
            display:inline;
        }
        .breadCrumbs .breadCrumbsInner.edit-entity #view-list {
            display:none;
        }
        .BodyContentBox .editEntityButton:not(:last-child) {
            margin-right:5px;
        }
        .BodyContentBox .account-page-title .back-to-entity-list {
            background: #cc0000 url(/website/images/mobile-back.png) center center / auto 75% no-repeat !important;
            text-indent: -99999px;
            padding: 5px 0px !important;
            width: 24px;
            height: 23px;
            display: inline-block;
            top: 2px;
            position: relative;
            border-radius: 5px;
        }

        .entityDashboard .width50:nth-of-type(odd) .card-tile-50 {
            width:calc( 100% - 7px );
            margin-right:7px;
            padding: 15px 25px;
            background: #fff;
        }

        .entityDashboard .width50:nth-of-type(even) .card-tile-50 {
            width:calc( 100% - 8px );
            margin-left:8px;
            padding: 15px 25px;
            background: #fff;
        }
        .entityDashboard .entityDetailsInner table tr td:nth-of-type(odd) {
            padding-right:15px;
        }
        .table.table-shadow {
            box-shadow: 0 0 5px rgba(0,0,0,.3);
        }
        .table.no-top-border td {
            border-top:0px;
        }

        [v-cloak] { display: none; }
    </style>
    <div id="app" class="formwrapper" >
        <div class="formwrapper-outer<?php if ( $strApproach === "view") { echo " edit-entity"; } ?>">
            <div class="formwrapper-control" v-cloak>
                <div class="fformwrapper-header">
                    <table class="table header-table" style="margin-bottom:0px;">
                        <tbody>
                        <tr>
                            <td>
                                <h3 class="account-page-title">Card Groups <span class="pointer addNewEntityButton entityButtonFixInTitle"  v-on:click="addCardGroup()" ></span></h3>
                                <div class="form-search-box" v-cloak>
                                    <input v-model="searchCardGroupQuery" class="form-control" type="text" placeholder="Search for..."/>
                                </div>
                            </td>
                            <td class="text-right page-count-display" style="vertical-align: middle;">
                                <span class="page-count-display-data">
                                    Current: <span>{{ pageIndex }}</span>
                                    Pages: <span>{{ totalPages }}</span>
                                </span>
                                <button v-on:click="prevPage()" class="btn prev-btn" :disabled="pageIndex == 1">Prev</button>
                                <button v-on:click="nextPage()" class="btn" :disabled="pageIndex == totalPages">Next</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="entityListOuter">
                    <table class="table table-striped entityList">
                        <thead>
                        <th v-for="cardColumn in cardGroupColumns">
                            <a v-on:click="orderByCard(cardColumn)" v-bind:class="{ active : orderKeyCardGroup == cardColumn, sortasc : sortByTypeCardGroup == true, sortdesc : sortByTypeCardGroup == false }">
                                {{ cardColumn | ucWords }}
                            </a>
                        </th>
                        <th class="text-right">
                            Actions
                        </th>
                        </thead>
                        <tbody>
                        <tr v-for="card in orderedCardGroups" v-on:dblclick="gotoCardGroup(card)">
                            <td>{{ card.card_rel_group_id }}</td>
                            <td>{{ card.name }}</td>
                            <td>{{ card.status }}</td>
                            <td>{{ card.user_id }}</td>
                            <td>{{ card.created_on }}</td>
                            <td>{{ card.last_updated }}</td>
                            <td class="text-right">
                                <span v-on:click="gotoCardGroup(card)" class="pointer editEntityButton"></span>
                                <span v-on:click="deleteCardGroup(card)" class="pointer deleteEntityButton"></span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="formwrapper-manage-entity">
                <div class="entityDashboard">
                    <h3 class="account-page-title"><a id="back-to-entity-list" class="back-to-entity-list pointer"></a> Card Group Dashboard</h3>
                    <input id="dashboard-entity-id" type="hidden" value="<?php echo !empty($objCardGroup->card_rel_group_id) ? $objCardGroup->card_rel_group_id : ""; ?>" />
                    <div class="width100 entityDetails">
                        <div class="width50">
                            <div class="card-tile-50">
                                <h4>Profile <span v-on:click="editProfile()" class="pointer editEntityButton entityButtonFixInTitle"></span></h4>
                                <div class="entityDetailsInner">
                                    <table>
                                        <tbody>
                                        <tr>
                                            <td>Group Name: </td>
                                            <td><strong id="entityCardGroupName"><?php echo !empty($objCardGroup->name) ? $objCardGroup->name : ""; ?></strong></td>
                                        </tr>
                                        <tr>
                                            <td>Description: </td>
                                            <td><strong id="entityCardDescription"><?php echo !empty($objCardGroup->description) ? $objCardGroup->description : ""; ?></strong></td>
                                        </tr>
                                        <tr>
                                            <td>Owner: </td>
                                            <td><strong id="entityUser"><?php echo !empty($objCardGroup->user_id) ? $objCardGroup->user_id : ""; ?></strong></td>
                                        </tr>
                                        <tr>
                                            <td>Status: </td>
                                            <td><strong id="entityStatus"><?php echo !empty($objCardGroup->status) ? $objCardGroup->status : ""; ?></strong></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="width50">
                            <div class="card-tile-50">
                                <h4>Card <span v-on:click="editCard()" class="pointer editEntityButton entityButtonFixInTitle"></span></h4>
                                <div class="entityDetailsInner">
                                    <table>
                                        <tbody>
                                        <tr>
                                            <td>Card Id: </td>
                                            <td><strong id="entityCardId"><a id="entityCardIdLink" data-ref="/account/admin/cards/view-card?id=$1" href="/account/admin/cards/view-card?id=<?php echo !empty($objCard->card_num) ? $objCard->card_num : ""; ?>"><?php echo !empty($objCard->card_num) ? $objCard->card_num : ""; ?></a></strong></td>
                                        </tr>
                                        <tr>
                                            <td>Card Name: </td>
                                            <td><strong id="entityCardName"><?php echo !empty($objCard->card_name) ? $objCard->card_name : ""; ?></strong></td>
                                        </tr>
                                        <tr>
                                            <td>Status: </td>
                                            <td><strong id="entityCardStatus"><?php echo !empty($objCard->status) ? $objCard->status : ""; ?></strong></td>
                                        </tr>
                                        <tr>
                                            <td>Package: </td>
                                            <td><strong id="entityCardPackageId"><?php echo !empty($objCard->product_id) ? $objCard->product_id : ""; ?></strong></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="clear:both;"></div>

                    <div class="width100 entityDetails">
                        <h4 class="account-page-subtitle">Card Group Users <span class="pointer addNewEntityButton entityButtonFixInTitle"  v-on:click="addCardGroupUser()" ></span></h4>
                        <div class="form-search-box" v-cloak>
                            <input v-model="searchCardGroupUsersQuery" class="form-control" type="text" placeholder="Search for..."/>
                        </div>
                        <table class="table table-striped" style="margin-top:10px;" v-cloak>
                            <thead>
                            <th v-for="cardGroupColumn in cardGroupUsersColumns">
                                <a v-on:click="orderByCardGroupUser(cardGroupColumn)" v-bind:class="{ active : orderKeyCardGroupUser == cardGroupColumn, sortasc : sortByTypeCardGroupUser == true, sortdesc : sortByTypeCardGroupUser == false }">
                                    {{ cardGroupColumn | ucWords }}
                                </a>
                            </th>
                            <th class="text-right">
                                Actions
                            </th>
                            </thead>
                            <tbody>
                            <tr v-for="cardGroup in orderedCardGroupUsers" v-on:dblclick="gotoCardGroupUser(cardGroup)">
                                <td>{{ cardGroup.user_id}}</td>
                                <td>{{ cardGroup.username }}</td>
                                <td>{{ cardGroup.first_name }}</td>
                                <td>{{ cardGroup.last_name }}</td>
                                <td>{{ cardGroup.created_on }}</td>
                                <td>{{ cardGroup.last_updated }}</td>
                                <td class="text-right">
                                    <span v-on:click="editCardGroupUser(cardGroup)" class="pointer editEntityButton"></span>
                                    <span v-on:click="deleteCardGroupUser(cardTab)" class="pointer deleteEntityButton"></span>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="application/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.17/vue.min.js"></script>
<script type="application/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.11/lodash.min.js"></script>
<script type="application/javascript">
    let customerApp = new Vue({

        el: '#app',

        computed:
            {
                totalPages: function()
                {
                    return this.pageTotal;
                },

                totalCards: function()
                {
                    return this.cardTotal;
                },

                totalCardGroupUsers: function()
                {
                    return this.cardGroupUserTotal;
                },

                orderedCardGroups: function()
                {
                    var self = this;

                    let objSortedCardGroups = this.sortedEntity(this.searchCardGroupQuery, this.cardGroups, this.orderKeyCardGroup, this.sortByTypeCardGroup, this.pageIndex,  this.pageDisplay, this.pageTotal, function(data) {
                        self.pageTotal = data.pageTotal;
                        self.pageIndex = data.pageIndex;
                    });

                    return objSortedCardGroups;
                },

                orderedCardGroupUsers: function()
                {
                    var self = this;

                    let objSortedCardGroupUsers = this.sortedEntity(this.searchCardGroupUsersQuery, this.cardGroupUsers, this.orderKeyCardGroupUser, this.sortByTypeCardGroupUser, this.cardGroupUsersIndex,  this.cardGroupUsersDisplay, this.cardGroupUsersTotal, function(data) {
                        self.cardTabTotal = data.pageTotal;
                        self.cardTabIndex = data.pageIndex;
                    });

                    return objSortedCardGroupUsers;
                },
            },

        filters: {
            ucWords: function(str)
            {
                return str.replace(/_/g," ").replace(/\w\S*/g, function (txt) {
                    return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
                });
            },

            orderBy: function(type)
            {

            }
        },

        methods: {

            orderByCardGroup: function(column)
            {

                this.sortByTypeCardGroup = ( this.orderKeyCardGroup == column ) ? ! this.sortByTypeCardGroup : this.sortByTypeCardGroup;

                this.orderKeyCardGroup = column;
            },

            orderByCardGroupUser: function(column)
            {

                this.sortByTypeCardGroupUser = ( this.orderKeyCardGroupUser == column ) ? ! this.sortByTypeCardGroupUser : this.sortByTypeCardGroupUser;

                this.orderKeyCardGroupUser = column;
            },

            sortedEntity: function (searchQuery, entity, orderkey, sortByType, pageIndex, pageDisplay, pageTotal, callback)
            {
                var returnData = {};

                returnData.pageIndex = pageIndex;

                let objOrderedEntity = _.orderBy(entity, orderkey, sortByType ? 'asc' : 'desc');

                let intStartIndex = ((returnData.pageIndex-1) * pageDisplay);
                let intIndexOffset = entity.length - intStartIndex;
                let intEndIndex = intStartIndex + (( pageDisplay <= intIndexOffset ) ? pageDisplay : intIndexOffset);

                if (!searchQuery) {
                    var intTotalPages = 1;

                    if (pageDisplay < objOrderedEntity.length) {
                        intTotalPages = objOrderedEntity.length / pageDisplay;
                    }

                    returnData.pageTotal = Math.ceil(intTotalPages);

                    if ( typeof callback === "function") {
                        callback(returnData);
                    }

                    return objOrderedEntity.slice(intStartIndex, intEndIndex);
                }

                let objFilteredEntity = objOrderedEntity.filter(function (currEntity)
                {
                    let searchRegex = new RegExp(searchQuery, 'i');
                    let intFoundMatch = false;
                    let arFoundMatch = false;
                    let arEntityKeys = Object.keys(currEntity);

                    for (let entityField in currEntity)
                    {
                        if ( typeof filterFields !== "undefined")
                        {
                            if(arFoundMatch[entityField] === true)
                            {
                                continue;
                            }

                            for (let indexFilters in filterFields)
                            {
                                if (arEntityKeys[entityField] == filterFields[indexFilters] )
                                {
                                    arFoundMatch[entityField] = true;
                                    continue;
                                }
                            }
                        }

                        if (searchRegex.test(currEntity[entityField])) {
                            //console.log(searchQuery);
                            intFoundMatch = true;
                        }
                    }

                    if (intFoundMatch == true) {

                        if ( typeof callback === "function") {
                            callback(returnData);
                        }

                        return currEntity;
                    }
                });

                let intOrderedIndexOffset = objOrderedEntity.length - intStartIndex;
                let intOrderedEndIndex = intStartIndex + (( pageDisplay <= intOrderedIndexOffset ) ? pageDisplay : intOrderedIndexOffset);

                if (objFilteredEntity.length < intStartIndex) {

                    intStartIndex = Math.floor(objFilteredEntity.length / pageDisplay) * pageDisplay;
                    returnData.pageIndex =  Math.ceil(objFilteredEntity.length / pageDisplay);
                    intOrderedIndexOffset = objFilteredEntity.length - intStartIndex;
                    intOrderedEndIndex = intStartIndex + intOrderedIndexOffset;
                }

                var intTotalFilteredPages = 1;

                if (pageDisplay < objFilteredEntity.length) {
                    intTotalFilteredPages = objFilteredEntity.length / pageDisplay;
                }

                returnData.pageTotal = Math.ceil(intTotalFilteredPages);

                if ( typeof callback === "function") {
                    callback(returnData);
                }

                return objFilteredEntity.slice(intStartIndex, intOrderedEndIndex);
            },

            addPerson: function()
            {
                var strUserName = this.personToAdd.username;
                var strFirstName = this.personToAdd.first_name;
                var strLastName = this.personToAdd.last_name;
                var strStatus = this.personToAdd.status;
                var strCreatedOn = this.personToAdd.created_on;

                if (!strFirstName || !strLastName) {
                    return;
                }

                var intId = this.people.length + 1;

                this.people.push({user_id: intId, username: strUserName,  first_name: strFirstName, last_name: strLastName, status: strStatus, created_on: strCreatedOn});

                this.personToAdd.username = "";
                this.personToAdd.first_name = "";
                this.personToAdd.last_name = "";
                this.personToAdd.status = "";
                this.personToAdd.created_on = "";
                this.personToAdd.user_id = "";
            },

            gotoCardGroup: function(card)
            {
                let stateObj = { foo: "bar" };

                $('#dashboard-entity-id').val(card.card_rel_group_id);
                $('#entityCardGroupName').html(card.name);
                $('#entityCardDescription').html(card.description);
                $('#entityUser').html(card.user_id);
                $('#entityStatus').html(card.status);

                //
                $(".formwrapper-outer").addClass("edit-entity");
                $(".breadCrumbsInner").addClass("edit-entity");

                let entityIdParameter = "card_group_id=" + card.card_rel_group_id;

                this.cardUsers = [];

                ajax.Send("cards/card-data/get-card-group-dashboard-info", entityIdParameter, function(objCardResult)
                {
                    if (objCardResult.success == false)
                    {
                        var data = {};
                        data.title = "Card View Error...";
                        data.html = objCardResult.message;
                        modal.AddFloatDialogMessage(data);
                        return false;
                    }

                    var strCardLink = $('#entityCardId a').data('ref');
                    $('#entityCardId a').html(objCardResult.data.card.card_id);
                    $('#entityCardName').html(objCardResult.data.card.card_name);
                    $('#entityCardStatus').html(objCardResult.data.card.status);
                    $('#entityCardPackageId').html(objCardResult.data.card.product_id);
                    $('#entityCardIdLink').attr("href", strCardLink.replace("$1", objCardResult.data.card.card_id));

                    for(var intCardPageGroupIndex in objCardResult.data.cardGroups)
                    {
                        customerApp.cardGroups.push(objCardResult.data.cardGroups[intCardPageGroupIndex]);
                    }

                    for(var intUserIndex in objCardResult.data.cardGroupUsers)
                    {
                        customerApp.cardGroupUsers.push(objCardResult.data.cardGroupUsers[intUserIndex]);
                    }

                    //GetCardsByGroupIdGetCardsByGroupIdvar objCard = objCardResult.data.card;

                    // success
                    history.pushState(stateObj, "View Card", "/account/admin/cards/card-groups/view-card-group?id=" + card.card_rel_group_id);

                },"POST");
            },

            deleteColumn: function(card)
            {
                    this.people = this.people.filter(function (curCard) {
                    return card.card_id != curCard.user_id;
                });
            },

            prevPage: function()
            {
                this.pageIndex--;

                this.cardGroups = this.cardGroups;
            },

            nextPage: function()
            {
                this.pageIndex++;

                this.cardGroups = this.cardGroups;
            },

            addCardGroup : function()
            {
                modal.EngageFloatShield();
                var data = {};
                data.title = "Add Card Group";
                //data.html = "We are logging you in.<br>Please wait a moment.";
                modal.EngagePopUpDialog(data, 750, 115, true);

                var strViewRequestParameter = "view=addCardGroup";

                modal.AssignViewToPopup("/cards/card-data/get-card-group-dashboard-views", strViewRequestParameter);
            },

            addCardGroupUser : function()
            {
                modal.EngageFloatShield();
                var data = {};
                data.title = "Add Card Group User";
                //data.html = "We are logging you in.<br>Please wait a moment.";
                modal.EngagePopUpDialog(data, 750, 115, true);

                var strViewRequestParameter = "view=addCardUser";

                modal.AssignViewToPopup("/cards/card-data/get-card-group-dashboard-views", strViewRequestParameter);
            },

            editCardGroupUser: function(user)
            {
                modal.EngageFloatShield();
                var data = {};
                data.title = "Edit Card Group User";
                //data.html = "We are logging you in.<br>Please wait a moment.";
                modal.EngagePopUpDialog(data, 750, 115, true);

                var strViewRequestParameter = "view=editCardUser&user_id=" + user.user_id;

                modal.AssignViewToPopup("/cards/card-data/get-card-group-dashboard-views", strViewRequestParameter);
            },

            gotoCardGroupUser: function(user)
            {
                window.location = "<?php echo getFullUrl() . "/"; ?>account/admin/customers/view-customer?id=" + user.user_id;
            },

            editCard: function(card)
            {
                modal.EngageFloatShield();
                var data = {};
                data.title = "Edit Card";
                //data.html = "We are logging you in.<br>Please wait a moment.";
                modal.EngagePopUpDialog(data, 750, 115, true);

                var strViewRequestParameter = "view=editCard&card_group_id=" + $('#dashboard-entity-id').val();

                modal.AssignViewToPopup("/cards/card-data/get-card-group-dashboard-views", strViewRequestParameter);
            },

            editProfile: function()
            {
                modal.EngageFloatShield();
                var data = {};
                data.title = "Edit Card Group Profile";
                //data.html = "We are logging you in.<br>Please wait a moment.";
                modal.EngagePopUpDialog(data, 750, 115, true);

                var intEntityId = $('#dashboard-entity-id').val();
                var strViewRequestParameter = "view=editProfile&card_id=" + intEntityId;

                modal.AssignViewToPopup("/cards/card-data/get-card-group-dashboard-views", strViewRequestParameter, null, function(objProfileUpdateResult){
                    console.log(JSON.stringify(objProfileUpdateResult));
                });
            },
        },

        data:
            {
                orderKeyCardGroup : 'card_id',
                orderKeyCardGroupUser: 'order_number',

                sortByTypeCardGroup: true,
                sortByTypeCardGroupUser: true,

                cardGroupColumns: ['card_rel_group_id', 'name', 'status', 'user_id', 'created_on', 'last_updated'],
                cardGroupUsersColumns: ['user_id', 'username', 'first_name','last_name', 'created_on', 'last_updated'],

                personToAdd: {user_id: "", first_name: "", last_name: "", username: "", display_name: "", status: ""},

                searchCardGroupQuery: '',
                searchCardGroupUsersQuery: '',

                pageDisplay: 15,
                cardGroupUsersDisplay: 5,

                pageTotal: 1,
                cardGroupUserTotal: 1,

                pageIndex: 1,
                cardGroupUsersIndex: 1,

                cardGroups: <?php echo $objActiveCards->Data->ConvertToJavaScriptArray([
                        "card_rel_group_id",
                        "name",
                        "description",
                        "status",
                        "user_id",
                        "card_rel_group_parent_id",
                        "created_on",
                        "last_updated",
                    ]) . PHP_EOL; ?>,

                cardGroupUsers: <?php if(!empty($colCardGroupUser)) { echo $colCardGroupUser->ConvertToJavaScriptArray([
                        "user_id",
                        "username",
                        "status",
                        "first_name",
                        "last_name",
                        "display_name",
                        "created_on",
                        "last_updated",
                    ]) . PHP_EOL; } else { echo "[]"; } ?>
            }
    });

    window.addEventListener('popstate', function(e) {
        // going back from edit?
        if (e.state == null)
        {
            $(".formwrapper-outer").removeClass("edit-entity");
            $(".breadCrumbsInner").removeClass("edit-entity");
        }
    });

    document.getElementById("backToViewEntityList").addEventListener("click", function(event){
        event.preventDefault()
        history.go(-1);
        $(".formwrapper-outer").removeClass("edit-entity");
        $(".breadCrumbsInner").removeClass("edit-entity");
    });

    document.getElementById("back-to-entity-list").addEventListener("click", function(event){
        event.preventDefault()
        history.go(-1);
        $(".formwrapper-outer").removeClass("edit-entity");
        $(".breadCrumbsInner").removeClass("edit-entity");
    });

</script>

