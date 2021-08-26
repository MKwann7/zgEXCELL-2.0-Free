<?php
/**
 * Created by PhpStorm.
 * User: Micah.Zak
 * Date: 10/11/2018
 * Time: 9:43 AM
 */

$this->CurrentPage->BodyId            = "view-all-images-page";
$this->CurrentPage->BodyClasses       = ["admin-page", "view-my-cards-page", "two-columns", "left-side-column"];
$this->CurrentPage->Meta->Title       = "Image Library | " . $this->app->objCustomPlatform->getPortalDomain();
$this->CurrentPage->Meta->Title       = "Image Library | " . $this->app->objCustomPlatform->getPortalDomain();
$this->CurrentPage->Meta->Description = "Welcome to the NEW AMAZING WORLD of EZ Digital Cards, where you can create and manage your own cards!";
$this->CurrentPage->Meta->Keywords    = "";
$this->CurrentPage->SnipIt->Title     = "Image Library";
$this->CurrentPage->SnipIt->Excerpt   = "Welcome to the NEW AMAZING WORLD of EZ Digital Cards, where you can create and manage your own cards!";
$this->CurrentPage->Columns           = 0;

?>
<div class="breadCrumbs">
    <div class="breadCrumbsInner<?php if ( $strApproach === "view") { echo " edit-entity"; } ?>">
        <input id="entity-page-entrance" data-source="<?php if ( $strApproach === "view") { echo 'edit-entity'; } else { echo 'list-entities'; } ?>" type="hidden"/>
        <a href="/account" class="breadCrumbHomeImageLink">
            <img src="/media/images/home-icon-01_white.png" class="breadCrumbHomeImage" width="15" height="15" />
        </a> &#187;
        <a href="/account" class="breadCrumbHomeImageLink">
            <span class="breadCrumbPage">Home</span>
        </a> &#187;
        <span id="view-list">
            <span class="breadCrumbPage">Cards</span>
        </span>
        <span id="editing-entity">
            <a id="backToViewEntityList" href="/account/cards/" class="breadCrumbHomeImageLink">
                <span class="breadCrumbPage">Image Library</span>
            </a> &#187;
            <span class="breadCrumbPage">Image Dashboard</span>
        </span>
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
                                <h3 class="account-page-title">Image Library <span style="display:none;" class="pointer addNewEntityButton entityButtonFixInTitle"  v-on:click="addImage()" ></span></h3>
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
                        <th class="image_thumb">Thumb</th>
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
                        <tr v-for="image in orderedImages" v-on:dblclick="editImage(image)">
                            <td class="image_thumb"><img class="main-list-image" v-bind:src="image.thumb" width="50" height="50" /></td>
                            <td>{{ image.title }}</td>
                            <td>{{ image.image_class }}</td>
                            <td>{{ image.width }}</td>
                            <td>{{ image.height }}</td>
                            <td>{{ image.type }}</td>
                            <td>{{ image.last_updated }}</td>
                            <td class="text-right">
                                <span v-on:click="editImage(image)" class="pointer editEntityButton"></span>
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
    let imageApp = new Vue({

        el: '#app',

        computed:
            {
                totalPages: function()
                {
                    return this.pageTotal;
                },

                orderedImages: function()
                {
                    var self = this;

                    let objSortedPeople = this.sortedEntity(this.searchQuery, this.images, this.orderKey, this.sortByType, this.pageIndex,  this.pageDisplay, this.pageTotal, function(data) {
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

            editImage: function(image)
            {
                modal.EngageFloatShield();
                var data = {};
                data.title = "Edit Image";
                //data.html = "We are logging you in.<br>Please wait a moment.";
                modal.EngagePopUpDialog(data, 850, 225, true);

                let strViewRequestParameter = "view=editImage&image_id=" + image.image_id;

                modal.AssignViewToPopup("/media/media-data/get-image-library-editor", strViewRequestParameter, null, function(objResult) {
                    image.title = objResult.data.title;
                    image.last_updated = objResult.data.last_updated;
                    modal.CloseFloatShield();
                });
            },

            deleteColumn: function(person)
            {
                this.people = this.people.filter(function (curPerson) {
                    return person.user_id != curPerson.user_id;
                });
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

            editProfilePhoto: function()
            {
                modal.EngageFloatShield();
                let data = {};
                data.title = "Edit Profile Photo";
                //data.html = "We are logging you in.<br>Please wait a moment.";
                modal.EngagePopUpDialog(data, 500, 115, true);

                let strViewRequestParameter = "view=editProfilePhoto&user_id=" + $('#dashboard-entity-id').val();

                modal.AssignViewToPopup("/customers/user-data/get-customer-dashboard-views", strViewRequestParameter);
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

            BatchLoadCards: function()
            {
                this.batchOffset++;

                setTimeout(function()
                {
                    let strBatchUrl = "media/media-data/get-user-image-batches?offset=" + imageApp.batchOffset;

                    ajax.Send(strBatchUrl, null, function(objCardResult)
                    {
                        if (!objCardResult.data)
                        {
                            return;
                        }

                        for(let currCardIndex in objCardResult.data.images)
                        {
                            imageApp.people.images(objCardResult.data.images[currCardIndex]);
                        }

                        imageApp.pageTotal = imageApp.images / imageApp.pageDisplay;

                        if (objCardResult.end == "false")
                        {
                            imageApp.BatchLoadCards();
                        }
                    });
                },50);
            },
        },

        data:
            {
                batchOffset: 0,
                orderKey: 'created_on',

                sortByType: false,

                columns: ['title', 'image_class', 'width', 'height', 'type', 'last_updated'],

                searchQuery: '',

                pageDisplay: 15,

                pageTotal: 1,

                pageIndex: 1,


                images: <?php if(!empty($lstImagesFromUser)) { echo $lstImagesFromUser->ConvertToJavaScriptArray([
                        "image_id",
                        "url",
                        "thumb",
                        "title",
                        "user_id",
                        "image_class",
                        "width",
                        "height",
                        "type",
                        "created_on",
                        "last_updated",
                    ]) . PHP_EOL; } else { echo "[]"; } ?>
            },
        mounted() {
            //this.BatchLoadCards();
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

    document.getElementById("backToViewEntityList").addEventListener("click", function(event){
        event.preventDefault();
        dash.goBackToEntityList("/account/image-library");
    });

    document.getElementById("back-to-entity-list").addEventListener("click", function(event){
        event.preventDefault();
        dash.goBackToEntityList("/account/image-library");
    });

    document.getElementById("back-to-entity-list-404").addEventListener("click", function(event){
        event.preventDefault();
        dash.goBackToEntityList("/account/image-library");
    });

</script>