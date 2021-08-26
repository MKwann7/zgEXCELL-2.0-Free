<?php
/**
 * Created by PhpStorm.
 * User: Micah.Zak
 * Date: 10/11/2018
 * Time: 9:43 AM
 */

$this->CurrentPage->BodyId            = "widget-library-page";
$this->CurrentPage->BodyClasses       = ["admin-page", "widget-library-page", "two-columns", "left-side-column"];
$this->CurrentPage->Meta->Title       = "Tab Library | " . $this->app->objCustomPlatform->getPortalDomain();
$this->CurrentPage->Meta->Description = "Welcome to the NEW AMAZING WORLD of EZ Digital Cards, where you can create and manage your own cards!";
$this->CurrentPage->Meta->Keywords    = "";
$this->CurrentPage->SnipIt->Title     = "Tab Library";
$this->CurrentPage->SnipIt->Excerpt   = "Welcome to the NEW AMAZING WORLD of EZ Digital Cards, where you can create and manage your own cards!";
$this->CurrentPage->Columns           = 2;

$this->LoadVenderForPageScripts($this->CurrentPage->BodyId, "froala");
$this->LoadVendorForPageStyles($this->CurrentPage->BodyId, "froala");
$this->LoadVenderForPageScripts($this->CurrentPage->BodyId, ["jquery"=>"input-picker/v1.0"]);
$this->LoadVendorForPageStyles($this->CurrentPage->BodyId, ["jquery"=>"input-picker/v1.0"]);

?>
<div class="breadCrumbs">
    <div class="breadCrumbsInner">
        <a href="/account" class="breadCrumbHomeImageLink">
            <img src="/media/images/home-icon-01_white.png" class="breadCrumbHomeImage" width="15" height="15" />
        </a> &#187;
        <a href="/account" class="breadCrumbHomeImageLink">
            <span class="breadCrumbPage">Home</span>
        </a> &#187;
        <a href="/account/cards" class="breadCrumbHomeImageLink">
            <span class="breadCrumbPage">Cards</span>
        </a> &#187;
        <span class="breadCrumbPage">Widget Library</span>
    </div>
</div>
<?php $this->RenderPortalComponent("content-left-menu"); ?>
<div class="BodyContentBox">
    <style type="text/css">
        .BodyContentBox .entityList.table-striped td {
            width:10%;
        }
        .BodyContentBox .entityList.table-striped td:first-child {
            width:5%;
        }
        .BodyContentBox .entityList.table-striped td:nth-child(5) {
            width:5%;
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
        .BodyContentBox .account-page-title #back-to-entity-list,
        .BodyContentBox .account-page-title #back-to-entity-list-404 {
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
        @media (max-width:750px) {
            .main-list-image {
                width: 25px;
                height: 25px;
            }
        }
        .cards_banner {
            width:40px;
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
                                <h3 class="account-page-title">Widget Library <span class="pointer addNewEntityButton entityButtonFixInTitle"  v-on:click="addTab()" ></span></h3>
                                <div class="form-search-box" v-cloak>
                                    <input v-model="searchQuery" class="form-control" type="text" placeholder="Search for..."/>
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
                        <th v-for="column in columns">
                            <a v-on:click="orderByColumn(column)" v-bind:class="{ active : orderKey == column, sortasc : sortByType == true, sortdesc : sortByType == false }">
                                {{ column | ucWords }}
                            </a>
                        </th>
                        <th class="text-right">
                            Actions
                        </th>
                        </thead>
                        <tbody>
                        <tr v-for="tab in orderedTabs" v-on:dblclick="editTab(tab)">
                            <td>{{ tab.title }}</td>
                            <td>{{ tab.content }}</td>
                            <td>{{ tab.type }}</td>
                            <td>{{ tab.installed_count }}</td>
                            <td>{{ tab.created_on }}</td>
                            <td>{{ tab.last_updated }}</td>
                            <td class="text-right">
                                <span v-on:click="editTab(tab)" class="pointer editEntityButton"></span>
                                <span v-on:click="deleteTab(connection)"  v-if="(tab.installed_count == 0)" class="pointer deleteEntityButton"></span>
                                <span v-if="(tab.installed_count == 1)" style="opacity:.3;" class="pointer deleteEntityButton"></span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="application/javascript">
    let tabApp = new Vue({

        el: '#app',

        computed:
            {
                totalPages: function()
                {
                    return this.pageTotal;
                },

                orderedTabs: function()
                {
                    var self = this;

                    let objSortedPeople = this.sortedEntity(this.searchQuery, this.tabs, this.orderKey, this.sortByType, this.pageIndex,  this.pageDisplay, this.pageTotal, function(data) {
                        self.pageTotal = data.pageTotal;
                        self.pageIndex = data.pageIndex;
                    });

                    return objSortedPeople;
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
            orderByColumn: function(column)
            {

                this.sortByType = ( this.orderKey == column ) ? ! this.sortByType : this.sortByType;

                this.orderKey = column;
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

            addTab: function(image)
            {
                modal.EngageFloatShield();
                let data = {};
                data.title = "Add New Page to Library";
                //data.html = "We are logging you in.<br>Please wait a moment.";
                modal.EngagePopUpDialog(data, 1000, 115, true);
                let intCardId = $('#dashboard-entity-id').val();
                let intOwnerCardId = $('#entity-owner-id').val();
                let strViewRequestParameter = "view=addLibraryTabAdmin&id=" + intCardId + "&owner_id=" + intOwnerCardId;
                let strContentPrefix = '<div class="tabSelectionOuter divTable"><div class="tabSelectionRow divRow"><div class="divCell tabSelectionLabel tabSelectionHtmlTab" style="width:calc(100% - 8px);" onclick="tabApp.LoadTabHtmlSelection();"><h2>Create a New HTML Library Page</h2><div class="tabSelectionActionButton"><i class="fas fa-file-code"></i></div></div><div class="divCell tabSelectionLabel tabSelectionSpecialTabs" style="width:calc(100% - 6px);" onclick="tabApp.LoadTabSpecialtySelection();"><h2>Install a Module Widget</h2><div class="tabSelectionActionButton"><i class="fas fa-clone"></i></div></div></div></div>';

                modal.AssignViewToPopup("/cards/card-data/get-card-dashboard-views", strViewRequestParameter, function()
                    {
                        modal.EngageFloatShield();
                    },
                    function (objResult)
                    {
                        tabApp.tabs.push(objResult.tab);

                        modal.CloseFloatShield(function() {
                            modal.CloseFloatShield();
                        },500);
                    },
                    function (objValidate)
                    {
                        if ($("#addCardPageAdminForm #tab_title").val() == "")
                        {
                            $("#addCardPageAdminForm #tab_title").addClass("error-validation").blur(function() {
                                $(this).removeClass("error-validation");
                            });

                            return false;
                        }

                        return true;
                    },
                    strContentPrefix);
            },

            editTab: function(tab)
            {
                modal.EngageFloatShield();
                var data = {};
                data.title = "Edit Library Tab";
                //data.html = "We are logging you in.<br>Please wait a moment.";
                modal.EngagePopUpDialog(data, 1000, 225, true);

                let strViewRequestParameter = "view=editCardPageFromLibrary&source=tabLibrary&card_tab_id=" + tab.card_tab_id;

                modal.AssignViewToPopup("/cards/card-data/get-card-dashboard-views", strViewRequestParameter, function()
                {
                    modal.EngageFloatShield();
                }, function(objResult) {

                    console.log(objResult);

                    if (objResult.tab.library_tab == false)
                    {
                        tabApp.tabs = tabApp.tabs.filter(function (currTab) {
                            return tab.card_tab_id != currTab.card_tab_id;
                        });
                    }
                    else
                    {
                        tab.title = objResult.tab.title;
                        tab.content = objResult.tab.content;
                        tab.last_updated = objResult.tab.last_updated;
                    }

                    modal.CloseFloatShield(function() {
                        modal.CloseFloatShield();
                    },500);
                });
            },

            BackToCreateNew: function()
            {
                $(".zgpopup-dialog-body-inner-append-fullwidth form").hide();
                $(".tabSelectionOuter").show();
                let objModalTitle = $(".zgpopup-dialog-box-inner").last().find(".pop-up-dialog-main-title-text");
                let strOriginalText = objModalTitle.attr("data-original-text");
                objModalTitle.text(strOriginalText).attr("data-original-text","");
                let objPopUpBox = $(".universal-float-shield").last().children(".zgpopup-dialog-box");
                app.AlignPopUp(objPopUpBox);
            },

            LoadTabHtmlSelection: function()
            {
                $(".tabSelectionOuter").hide();
                setTimeout(function() {
                        tabApp.DelayedTabHtmlSectionLoad();
                    }
                    ,100);
            },

            DelayedTabHtmlSectionLoad: function()
            {
                if ($("#addLibraryTabAdminForm").length > 0)
                {
                    $("#addLibraryTabAdminForm").show();
                    let strOriginalText = $(".zgpopup-dialog-box-inner").last().find(".pop-up-dialog-main-title-text").text();
                    $(".zgpopup-dialog-box-inner").last().find(".pop-up-dialog-main-title-text").attr("data-original-text", strOriginalText).html('<a id="back-to-entity-list" onclick="tabApp.BackToCreateNew();" class="back-to-entity-list pointer"></a> Add New HTML Library Tab');
                    setTimeout(function() {
                            let objPopUpBox = $(".universal-float-shield").last().children(".zgpopup-dialog-box");
                            app.AlignPopUp(objPopUpBox);
                        }
                        ,100);
                }
                else
                {
                    setTimeout(function() {
                            tabApp.DelayedTabHtmlSectionLoad();
                        }
                        ,100);
                }
            },

            LoadTabSpecialtySelection: function()
            {
                $(".tabSelectionOuter").hide();
                setTimeout(function() {
                        tabApp.DelayedTabSpecialtySectionLoad();
                    }
                    ,100);
            },

            DelayedTabSpecialtySectionLoad: function()
            {
                if ($("#addLibraryTabAdminForm").length > 0)
                {
                    $("#addLibraryTabAdminForm").show();
                    let strOriginalText = $(".zgpopup-dialog-box-inner").last().find(".pop-up-dialog-main-title-text").text();
                    $(".zgpopup-dialog-box-inner").last().find(".pop-up-dialog-main-title-text").attr("data-original-text", strOriginalText).html('<a id="back-to-entity-list" onclick="tabApp.BackToCreateNew();" class="back-to-entity-list pointer"></a> Add New Module Widget');
                    setTimeout(function() {
                            let objPopUpBox = $(".universal-float-shield").last().children(".zgpopup-dialog-box");
                            app.AlignPopUp(objPopUpBox);
                        }
                        ,100);
                }
                else
                {
                    setTimeout(function() {
                            tabApp.DelayedTabSpecialtySectionLoad();
                        }
                        ,100);
                }
            },

            prevPage: function()
            {
                this.pageIndex--;

                this.people = this.people;
            },

            nextPage: function()
            {
                this.pageIndex++;

                this.people = this.people;
            },

            gotoCard: function(card)
            {
                window.location = "<?php echo getFullUrl() . "/"; ?>account/admin/cards/view-card?id=" + card.card_num
            },

            editProfile: function()
            {
                modal.EngageFloatShield();
                var data = {};
                data.title = "Edit Customer Profile";
                //data.html = "We are logging you in.<br>Please wait a moment.";
                modal.EngagePopUpDialog(data, 750, 115, true);

                var intEntityId = $('#dashboard-entity-id').val();
                var strViewRequestParameter = "view=editProfile&user_id=" + intEntityId;

                modal.AssignViewToPopup("/customers/user-data/get-customer-dashboard-views", strViewRequestParameter, function()
                    {
                        modal.EngageFloatShield();
                    },
                    function (objResult)
                    {
                        $('#entityFullName').html(objResult.customer.first_name + " " + objResult.customer.last_name);
                        $('#entityUserName').html(objResult.customer.username);
                        $('#entityStatus').html(objResult.customer.status);

                        modal.CloseFloatShield(function() {
                            modal.CloseFloatShield();
                        },500);
                    },
                    function (objValidate)
                    {
                        let intErrors = 0;

                        if ($("#editProfileForm .error-text").length > 0)
                        {
                            return false;
                        }

                        $("#editProfileForm .error-validation[name!=username]").removeClass("error-validation");

                        for(let intFieldIndex in objValidate)
                        {
                            if (objValidate[intFieldIndex].value == "" && objValidate[intFieldIndex].name != "username" && objValidate[intFieldIndex].name != "password")
                            {
                                intErrors++;
                                $("#editProfileForm inpfut[name=" + objValidate[intFieldIndex].name + "], #editProfileForm select[name=" + objValidate[intFieldIndex].name + "]").addClass("error-validation");
                            }
                        }

                        if (intErrors > 0)
                        {
                            return false;
                        }

                        return true;
                    });
            },

            BatchLoadTabs: function()
            {
                this.batchOffset++;

                setTimeout(function()
                {
                    let strBatchUrl = "cards/card-data/get-card-library-tab-batches?offset=" + tabApp.batchOffset;

                    ajax.Send(strBatchUrl, null, function(objCardResult)
                    {
                        for(let currCardIndex in objCardResult.data.tabs)
                        {
                            tabApp.tabs.push(objCardResult.data.tabs[currCardIndex]);
                        }

                        tabApp.pageTotal = tabApp.tabs / tabApp.pageDisplay;

                        if (objCardResult.end == "false")
                        {
                            tabApp.BatchLoadTabs();
                        }
                    });
                },50);
            },
        },

        data:
            {
                batchOffset: 0,
                orderKey: 'last_updated',

                sortByType: false,

                columns: ['title', 'content', 'type', 'card_count', 'created_on', 'last_updated'],

                searchQuery: '',

                pageDisplay: 15,

                pageTotal: 1,

                pageIndex: 1,

                tabs: <?php if(!empty($lstLibraryTabs)) { echo $lstLibraryTabs->ConvertToJavaScriptArray([
                        "card_tab_id",
                        "title",
                        "user_id",
                        "content",
                        "installed_count",
                        "width",
                        "height",
                        "type",
                        "created_on",
                        "last_updated",
                    ]) . PHP_EOL; } else { echo "[]"; } ?>
            },
        mounted() {
            this.BatchLoadTabs();
        }
    });

    dash.processTabDisplay(sessionStorage.getItem('dashboard-tab'));

    window.addEventListener('popstate', function(e) {
        // going back from edit?
        if (e.state == null)
        {
            $(".formwrapper-outer").removeClass("edit-entity");
            $(".breadCrumbsInner").removeClass("edit-entity");
        }
    });

    // document.getElementById("backToViewEntityList").addEventListener("click", function(event){
    //     event.preventDefault()
    //     dash.goBackToEntityList("/account/image-library");
    // });

    // document.getElementById("back-to-entity-list").addEventListener("click", function(event){
    //     event.preventDefault()
    //     dash.goBackToEntityList("/account/image-library");
    // });

    // document.getElementById("back-to-entity-list-404").addEventListener("click", function(event){
    //     event.preventDefault()
    //     dash.goBackToEntityList("/account/image-library");
    // });

</script>

