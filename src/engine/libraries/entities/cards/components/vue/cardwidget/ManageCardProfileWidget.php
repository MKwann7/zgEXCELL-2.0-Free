<?php

namespace Entities\Cards\Components\Vue\CardWidget;

use App\Core\App;
use App\Website\Vue\Classes\Base\VueComponent;
use Entities\Cards\Models\CardModel;

class ManageCardProfileWidget extends VueComponent
{
    protected string $id = "4c140efb-0aa5-4161-b9dc-9f0c4d4477dd";
    protected string $modalWidth = "750";
    protected string $updateButtonText = "Update";

    public function __construct (array $components = [])
    {
        $displayColumns = ["banner", "status"];

        if (userCan("manage-platforms"))
        {
            $displayColumns[] = "platform";
        }

        $displayColumns = array_merge($displayColumns, ["card_name", "card_num", "card_vanity_url", "card_owner_name", "card_contacts", "product", "created_on", "last_updated"]);

        $defaultEntity = (new CardModel())
            ->setDefaultSortColumn("card_num", "DESC")
            ->setDisplayColumns($displayColumns)
            ->setRenderColumns(["card_id", "owner_id", "card_owner_name", "card_name", "card_num", "card_vanity_url", "card_keyword", "product", "card_contacts", "status", "order_line_id", "platform", "company_id", "banner", "favicon", "created_on", "last_updated",]);

        parent::__construct($defaultEntity, $components);

        $this->modalTitleForAddEntity = "Add Card Profile";
        $this->modalTitleForEditEntity = "Edit Card Profile";
        $this->modalTitleForDeleteEntity = "Delete Card Profile";
        $this->modalTitleForRowEntity = "View Card Profile";
    }

    protected function renderComponentDataAssignments (): string
    {
        return '
            entityClone: false,
            dynamicOwnerSearch: false,
            dynamicCardUserSearch: false,
            customerList: [],
            templateList: [],
            ownerSearch: "",
            profileType: "site",
        ';
    }

    protected function renderComponentHydrationScript () : string
    {
        return parent::renderComponentHydrationScript() . '
            if (this.entity)
            {
                this.entityClone = _.clone(this.entity);
            }

            this.loadCustomers();
        ';
    }

    protected function renderComponentMountedScript(): string
    {
        return '
            dispatch.register("rehydrate_site_in_editor", this, "hydrateCard");
        ';
    }

    protected function renderComponentMethods (): string
    {
        /** @var App $app */
        global $app;

        return '
            hydrateCard: function(data)
            {
                if (data.card)
                {
                    this.entity = data.card;
                    this.entityClone = _.clone(data.card)
                    
                    if (this.templateList.length === 0)
                    {
                        let templateType = "site"
                        switch(this.entityClone.card_type_id) {
                            case 2: templateType = "persona"; break
                            case 3: templateType = "group"; break
                        }
                        this.profileType = templateType
                        this.hydrateSiteDataType("templates", this.templateList, "?type=" + templateType)
                    }
                }
            },
            updateSiteProfile: function()
            {
                let self = this;
                
                const elVanity = document.getElementById("vanity_1603190947");
                const elKeyword = document.getElementById("keyword_1603190947");
                
                if (elVanity.classList.contains("error-validation")) { return; }
                if (elKeyword.classList.contains("error-validation")) { return; }
                
                const url = "api/v1/cards/update-site-profile?card_id=" + this.entityClone.card_id;
                
                const entityNew = {
                    card_id: this.entityClone.card_id,
                    owner_id: this.entityClone.owner_id,
                    card_user_id: this.entityClone.card_user_id,
                    card_name: this.entityClone.card_name,
                    card_domain: this.entityClone.card_domain,
                    status: this.entityClone.status,
                    card_vanity_url: this.entityClone.card_vanity_url,
                    card_keyword: this.entityClone.card_keyword,
                    template_id: this.entityClone.template_id
                };
                
                modal.EngageFloatShield()
                 
                ajax.Post(url, entityNew, function(result) 
                {
                    if (result.success === false) 
                    {
                        return;
                    }
                    let templateChange = false;
                    if (self.entityClone.template_id != self.entity.template_id) {
                        templateChange = true;
                    }

                    self.entity.card_name = self.entityClone.card_name;
                    self.entity.owner_id = self.entityClone.owner_id;
					self.entity.card_owner_name = result.response.data.card.card_owner_name;
                    self.entity.card_keyword = self.entityClone.card_keyword;
                    self.entity.card_vanity_url = self.entityClone.card_vanity_url;
                    self.entity.card_domain = self.entityClone.card_domain;
                    self.entity.template_id = self.entityClone.template_id;
                    self.entity.template_name = self.getTemplateNameById(self.entityClone.template_id);
                    self.entity.status = self.entityClone.status;
                    
                    dispatch.broadcast("rehydrate_site_in_editor", {card: self.entity});
                    dispatch.broadcast("reload_site_profile_in_editor", {card: self.entity, templateChange: templateChange});

                    let vue = self.findApp(self);
                    vue.$forceUpdate();
                               
                    setTimeout(function() {
                        modal.CloseFloatShield()
                    },500);  
                });
            },
            getTemplateNameById: function(templateId)
            {
                for (currTemplate of this.templateList)
                {
                    if (currTemplate.card_template_id == templateId) { return currTemplate.name; }
                }
            },
            hydrateSiteDataType: function(type, list, query)
            {
                let self = this;
                if (!query) query = ""
                let templateQuery = "/api/v1/cards/get-site-" + type + query
                ajax.Get(templateQuery, null, function(result) 
                {
                    if (result.success === false)
                    {
                        return;
                    }

                    const templates = Object.entries(result.response.data.list);
                    
                    templates.forEach(function([id, currTemplate])
                    {
                        list.push(currTemplate);
                    });
                    
                    self.$forceUpdate();
                });
            },
            checkForDuplicateVanityUrl: function(entity)
            {
                const el = document.getElementById("vanity_1603190947");
                
                if (entity.card_vanity_url === "") 
                {    
                    el.classList.add("pass-validation");
                    el.classList.remove("error-validation");
                    return
                }
                
                const url = "/api/v1/cards/check-vanity-url?vanity_url=" + entity.card_vanity_url + "&card_id=" + entity.card_id;

                ajax.Get(url, null, function(result) 
                {
                    if (result.match === true) 
                    {
                        el.classList.remove("pass-validation");
                        el.classList.add("error-validation");
                        return;
                    }
                    
                    el.classList.add("pass-validation");
                    el.classList.remove("error-validation");
                });
            },
            checkForDuplicateDomainName: function(entity)
            {
                const el = document.getElementById("domain_1603190947");
                
                if (entity.card_domain === "") 
                {    
                    el.classList.add("pass-validation");
                    el.classList.remove("error-validation");
                    return
                }
                
                const url = "/api/v1/cards/check-domain?card_domain=" + entity.card_domain + "&card_id=" + entity.card_id;

                ajax.Get(url, null, function(result) 
                {
                    if (result.match === true) 
                    {
                        el.classList.remove("pass-validation");
                        el.classList.add("error-validation");
                        return;
                    }
                    
                    el.classList.add("pass-validation");
                    el.classList.remove("error-validation");
                });
            },
            checkForDuplicateKeyword: function(entity)
            {
                const el = document.getElementById("keyword_1603190947");
                
                if (entity.card_keyword === "") 
                {    
                    el.classList.add("pass-validation");
                    el.classList.remove("error-validation");
                    return
                }
                
                const url = "api/v1/cards/check-keyword?keyword=" + entity.card_keyword + "&card_id=" + entity.card_id;
                
                ajax.Get(url, null, function(result) 
                {
                    if (result.match === true) 
                    {
                        el.classList.remove("pass-validation");
                        el.classList.add("error-validation");
                        return;
                    }
                    
                    el.classList.add("pass-validation");
                    el.classList.remove("error-validation");
                });
            },
            engageDynamicOwnerSearch: function(user)
            {
                this.dynamicOwnerSearch = true;
            },
            hideDynamicOwnerSearch: function()
            {
                const self = this;
                setTimeout(function() {
                    self.dynamicOwnerSearch = false;
                }, 100);
            },
            keyMonitorCustomerList: function(event)
            {
                this.customerList = this.customerList;
                this.$forceUpdate();
            },
            parseUsersBySearch(usersList, text)
            {
                const self = this;
                let newUserList = [];
                
                if (typeof usersList.length !== "number" || usersList.length === 0)
                {
                    return newUserList;
                }
                
                let intTotalCount = 0;
                
                for (let currUser of usersList)
                {
                    if (intTotalCount > 25) { break; }
                    if (
                        currUser.first_name.toLowerCase().includes(text) || 
                        currUser.last_name.toLowerCase().includes(text) ||
                        (currUser.first_name.toLowerCase() + " " + currUser.last_name.toLowerCase()).includes(text) ||
                        currUser.user_id.toString().toLowerCase().includes(text)
                    )
                    {
                        newUserList.push(currUser);
                        intTotalCount++;
                    }
                }
                
                return newUserList;
            },
            assignCustomerToCardOwner: function(user)
            {
                this.ownerSearch = user.first_name + " " + user.last_name;
                this.entityClone.owner_id = user.user_id;
                this.dynamicOwnerSearch = false;
            },
            loadCustomers: function(callback)
            {
                const self = this;
                this.customerList = [];
                
                ajax.Get("/cart/get-all-users", null, function(result) 
                {
                    if (result.success === false)
                    {
                        return;
                    }

                    const users = Object.entries(result.response.data.list);

                    users.forEach(function([user_id, currUser]) {
                        if (currUser.user_id === self.entityClone.owner_id) { 
                            self.ownerSearch = currUser.first_name + " " + currUser.last_name; 
                        }
                        self.customerList.push(currUser);
                    });
                    
                    self.$forceUpdate();
                });
            },
        ';
    }

    protected function renderComponentComputedValues() : string
    {
        return '
            cartCustomerSearchList: function()
            {
                return this.parseUsersBySearch(this.customerList, this.ownerSearch.toLowerCase());
            },
        ';
    }

    protected function renderTemplate() : string
    {
        switch ($this->applicationType) {
            case "maxtech":
                $this->updateButtonText = "Update Site Profile";
                break;
            default:
                $this->updateButtonText = "Update Card Info";
        }

        return '
        <div class="editEntityProfile">
            <v-style type="text/css">
            
                .editEntityProfile .dynamic-search-list {
                    position: absolute;
                    width: calc(100% - 35px);
                    background: #fff;
                    margin-left: 5px;
                    z-index: 1000;
                    max-height:40vh;
                    overflow-y:auto;
                }
                .editEntityProfile .dynamic-search-list > table {
                    width: 100%;
                }
                .editEntityProfile .dynamic-search-list > table > thead {
                    box-shadow: rgba(0,0,0,0.2) 0px 2px 5px;
                    background-color: #007bff;
                    color: #fff !important;
                }
                .editEntityProfile .dynamic-search-list > table tr {
                    cursor:pointer;
                }
                .editEntityProfile .dynamic-search-list > table tr:hover {
                    background-color:#d5e9ff !important;
                }
            </v-style>
            <div v-if="entity">
                <table class="table no-top-border">
                    <tbody>
                        <tr>
                            <td style="width:125px;vertical-align: middle;">Card Name</td>
                            <td><input v-model="entityClone.card_name" class="form-control" type="text" placeholder="Enter Card Name..."></td>
                        </tr>
                    </tbody>
                </table>
                
                <div v-if="userAdminRole" class="augmented-form-items">
                    <table class="table" style="margin-bottom:2px;">
                        <tr>
                            <td style="width:117px;vertical-align: middle;">Owner</td>
                            <td style="position:relative;">
                                <div class="dynamic-search">
                                    <span class="inputpicker-arrow" style="top: 20px;right: 21px;">
                                        <b></b>
                                    </span>
                                    <input v-on:focus="engageDynamicOwnerSearch" v-on:blur="hideDynamicOwnerSearch" v-model="ownerSearch" v-on:keyup="keyMonitorCustomerList" autocomplete="off" value="" placeholder="Start Typing..." class="form-control ui-autocomplete-input">
                                    <div class="dynamic-search-list" style="position:absolute;" v-if="dynamicOwnerSearch === true && ownerSearch !== \'\'">
                                        <table>
                                            <thead>
                                                <th>User Id</th>
                                                <th>Name</th>
                                            </thead>
                                            <tbody>
                                                <tr v-for="currUser in cartCustomerSearchList">
                                                    <td @click="assignCustomerToCardOwner(currUser)">{{currUser.user_id}}</td>
                                                    <td @click="assignCustomerToCardOwner(currUser)">{{currUser.first_name}} {{currUser.last_name}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    <div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <table class="table no-top-border">
                    <tbody>
                        <tr v-if="userAdminRole">
                            <td style="width:125px;vertical-align: middle;">Domain Name</td>
                            <td><input v-on:blur="checkForDuplicateDomainName(entityClone)" v-model="entityClone.card_domain" id="domain_1603190947" class="form-control pass-validation" type="text" placeholder="Enter Domain Name..."></td>
                        </tr>
                        <tr v-if="userAdminRole && entityClone.card_domain !== \'\'">
                            <td style="width:125px;vertical-align: middle;">SSL Certificate?</td>
                            <td><label for="useSslForDomain">
                                <input v-model="entityClone.domain_ssl" id="useSslForDomain" type="radio" value="y"> Yes </label>&nbsp;&nbsp;
                                <label for="noSslForDomain">
                                <input v-model="entityClone.domain_ssl" id="noSslForDomain" type="radio" value="n"> No</label>
                            </td>
                        </tr>
                        <tr v-if="userAdminRole && entityClone.card_domain !== \'\' && entityClone.domain_ssl === \'y\'">
                            <td style="width:125px;vertical-align: middle;">SSL Cert<br>(not bundle)</td>
                            <td>
                                <textarea v-model="entityClone.domain_ssl_cert" type="text" class="form-control">
                                </textarea>
                            </td>
                        </tr>
                        <tr v-if="userAdminRole && entityClone.card_domain !== \'\' && entityClone.domain_ssl === \'y\'"">
                            <td style="width:125px;vertical-align: middle;">SSL Private Key</td>
                            <td>
                                <textarea v-model="entityClone.domain_ssl_key" type="text" class="form-control">
                                </textarea>
                            </td>
                        </tr>
                        <tr v-if="userAdminRole">
                            <td style="width:125px;vertical-align: middle;">Vanity URL</td>
                            <td><input v-on:blur="checkForDuplicateVanityUrl(entityClone)" v-model="entityClone.card_vanity_url" id="vanity_1603190947" class="form-control pass-validation" type="text" placeholder="Enter Vanity URL..."></td>
                        </tr>
                        <tr v-if="userAdminRole">
                            <td style="width:125px;vertical-align: middle;">Keyword</td>
                            <td><input v-on:blur="checkForDuplicateKeyword(entityClone)" v-model="entityClone.card_keyword" id="keyword_1603190947" class="form-control pass-validation" type="text" placeholder="Enter Keyword..."></td>
                        </tr>
                        <tr v-if="userAdminRole">
                            <td style="width:125px;vertical-align: middle;">Card Template</td>
                            <td>
                                <select v-model="entityClone.template_id" class="form-control">
                                    <option value="">--Select Template--</option>
                                    <option v-for="currTemplate in templateList" v-bind:value="currTemplate.card_template_id" selected="">{{ currTemplate.name }}</option>
                                </select>
                            </td>
                        </tr>
                        <tr v-if="userAdminRole">
                            <td style="width:125px;vertical-align: middle;">Status</td>
                            <td>
                                <select v-model="entityClone.status" class="form-control">
                                    <option value="Pending">Pending</option>
                                    <option value="Active">Active</option>
                                    <option value="Build">Build</option>
                                    <option value="Inactive">Inactive</option>
                                    <option value="Cancelled">Cancelled</option>
                                    <option value="Disabled">Disabled</option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <button v-on:click="updateSiteProfile" class="buttonID9234597e456 btn btn-primary w-100">' . $this->updateButtonText .'</button>
            </div>
        </div>';
    }
}