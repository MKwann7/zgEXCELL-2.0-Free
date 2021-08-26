<?php

namespace Entities\Tickets\Components\Vue\TicketsWidget;

use App\Website\Vue\Classes\Base\VueComponent;
use App\Website\Vue\Classes\VueProps;
use Entities\Cards\Components\Vue\CardWidget\ListCardWidget;
use Entities\Cards\Components\Vue\CardWidget\ManageCardWidget;
use Entities\Notes\Components\Vue\NotesTicketWidget\ListTicketNotesWidget;
use Entities\Users\Components\Vue\UserWidget\ManageCustomerProfileWidget;

class ManageTicketsAdminWidget extends VueComponent
{
    protected $id = "66655b89-4536-49f0-8e91-c6d77b30feff";
    protected $title = "Ticket Dashboard";
    protected $endpointUriAbstract = "ticket-dashboard/{id}";

    public function __construct(array $components = [])
    {
        parent::__construct();
    }

    protected function renderComponentDataAssignments() : string
    {
        return "
        dashboardTab: 'profile',
        entityNotFound: false,
        filterEntityId: null,
        ";
    }

    protected function renderComponentMethods() : string
    {
        global $app;
        return '              
                editTicketProfile: function(entity)
                {
                    modal.EngageFloatShield();
                    '. $this->activateDynamicComponentByIdInModal(ManageCustomerProfileWidget::getStaticId(),"", "edit", "this.entity", "this.mainEntityList", null, "this", true, "function(component) { 
                        modal.CloseFloatShield();
                    }").' 
                },
                setDashboardTab: function(tabName) {
                    this.dashboardTab = tabName;
                    sessionStorage.setItem(\'ticket.dashboard-tab\', tabName);
                },
                loadFromUriAbstract: function(id) 
                {
                    this.engageComponentLoadingSpinner();
                    let self = this;
                    this.component_title = this.component_title_original;
                    
                    this.loadEntityDataByUuid(id, function() {
                        self.disableComponentLoadingSpinner(); 
                    });
                },
                loadEntityDataByUuid: function(id, callback) 
                {
                    let self = this;
                    ajax.Send("api/v1/tickets/get-ticket-by-uuid?uuid=" + id, null, function(result)
                    {
                        ezLog(result, "loadEntityDataByUuid")
                        
                        if (result.success === false || typeof result.data === "undefined" || result.data.length === 0) 
                        { 
                            self.entityNotFound = true;
                            return;
                        }
                        
                        self.entity = result.data.ticket;
                        self.filterEntityId = self.entity.ticket_id;
                        self.component_title = self.component_title_original + ": " + self.entity.ticket_id;
                        
                        let vc = self.findVc(self);
                        vc.reloadComponents("'.$this->getInstanceId().'");

                        self.$forceUpdate();
                        
                        ezLog("HERE!!!")
                                                                   
                        if (typeof callback === "function") { callback(result.data); }
                    }, "GET");          
                },
        ';
    }

    protected function renderComponentHydrationScript() : string
    {
        return '
            this.dashboardTab = sessionStorage.getItem(\'ticket.dashboard-tab\');
            
            if (this.dashboardTab === null || (
                this.dashboardTab !== "profile" &&
                this.dashboardTab !== "build" &&
                this.dashboardTab !== "timeline"
                )
            ) { this.dashboardTab = "profile"; sessionStorage.setItem(\'ticket.dashboard-tab\', "profile"); }
            
            this.component_title = this.component_title_original;
            let self = this;
            
            if (this.entity && typeof this.entity.sys_row_id !== "undefined") 
            {
                this.loadEntityDataByUuid(this.entity.sys_row_id, function() {
                    self.disableComponentLoadingSpinner();
                    modal.CloseFloatShield();
                });
            }
            else
            {
                this.showNewSelection = true;
            }
        ';
    }

    protected function renderTemplate() : string
    {
        return '
            <div class="manage-ticket-main-wrapper formwrapper-manage-entity">
                <v-style type="text/css">
                    
                </v-style>
               
                <div class="entityDashboard">
                    <table class="table header-table" style="margin-bottom:0px;">
                        <tbody>
                        <tr>
                            <td class="mobile-to-table">
                                <h3 class="account-page-title">
                                <a v-show="hasParent" v-on:click="backToComponent()" id="back-to-entity-list" class="back-to-entity-list pointer"></a> 
                                {{ component_title }}
                                </h3>
                            </td>
                            <td class="mobile-to-table text-right page-count-display dashboard-tab-display" style="vertical-align: middle;">
                                <div data-block="profile" v-on:click="setDashboardTab(\'profile\')"  class="dashboard-tab fas fa-user-circle" v-bind:class="{active: dashboardTab === \'profile\'}"><span>Profile</span></div>
                                <div v-show="entity && entity.queue_type_id === 1" data-block="build" v-on:click="setDashboardTab(\'build\')"  class="dashboard-tab fas fa-hammer" v-bind:class="{active: dashboardTab === \'build\'}"><span>Card Build</span></div>
                                <div data-block="timeline" v-on:click="setDashboardTab(\'journey\')"  class="dashboard-tab fas fa-sticky-note" v-bind:class="{active: dashboardTab === \'journey\'}"><span>Journey</span></div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="entityTab" data-tab="profile" v-bind:class="{showTab: dashboardTab === \'profile\'}">
                        <div class="width100 entityDetails">
                            <div class="width50">
                                <div v-if="entity" class="card-tile-50">
                                    <h4>
                                        <span class="fas fa-user-circle fas-large desktop-25px"></span>
                                        <span class="fas-large">Profile</span>
                                        <span v-on:click="editTicketProfile(entity)" class="pointer editEntityButton entityButtonFixInTitle"></span>
                                    </h4>
                                    <div class="entityDetailsInner cardProfile">
                                        <table>
                                            <tbody>
                                            <tr>
                                                <td style="width:150px;">Owner: </td>
                                                <td><b>{{ entity.owner }}</b></td>
                                            </tr>
                                            <tr>
                                                <td style="width:150px;">Helprs: </td>
                                                <td>{{ entity.owner }}</td>
                                            </tr>
                                            <tr>
                                                <td style="width:150px;">Summary: </td>
                                                <td><b>{{ entity.summary }}</b></td>
                                            </tr>
                                            <tr>
                                                <td style="width:150px;">Type: </td>
                                                <td><i>{{ entity.type }}</i></td>
                                            </tr>
                                            <tr>
                                                <td style="width:150px;">Description: </td>
                                                <td>{{ entity.description }}</td>
                                            </tr>
                                            <tr>
                                                <td style="width:150px;">Days Open: </td>
                                                <td>{{ entity.duration }}</td>
                                            </tr>
                                            <tr>
                                                <td style="width:150px;">Expected Completion: </td>
                                                <td><strong>{{ entity.expected_completion }}</strong></td>
                                            </tr>
                                            <tr>
                                                <td>Status: </td>
                                                <td><strong>{{ entity.status }}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>'.'
                            <div class="width50">
                                <div v-if="entity" class="card-tile-50">
                                    <h4>
                                        <span class="fas fa-tasks fas-large desktop-25px"></span>
                                        <span class="fas-large">Checklist</span>
                                    </h4>
                                    <div>
                                        Here\'s where we are going to list the Journey Items for completion...
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="clear:both;"></div>
                        <div class="width100 entityDetails">
                            <div class="width100">
                                <div v-if="entity" class="card-tile-100">
                                    '.$this->registerAndRenderDynamicComponent(
                                        new ListTicketNotesWidget(),
                                        "view",
                                        [
                                            new VueProps("mainEntity", "object", "entity"),
                                            new VueProps("filterEntityId", "object", "entity.ticket_id"),
                                            new VueProps("filterByEntityValue", "boolean", true),
                                            new VueProps("filterByEntityRefresh", "boolean", true)
                                        ]
                                    ).'
                                </div>
                            </div>
                        </div>
                        <div style="clear:both;"></div>
                    </div>
                    
                    <div class="entityTab" data-tab="cards" v-bind:class="{showTab: dashboardTab === \'build\'}">
                        <div class="width100 entityDetails">
                            <div v-if="entity" class="card-tile-100">
                                    '.$this->registerAndRenderDynamicComponent(
                                    $this->registerDynamicComponentViaHub(
                                        ManageCardWidget::getStaticId(),
                                        "view",
                                        [
                                            new VueProps("filterEntityId", "object", "entity.user_id"),
                                            new VueProps("filterByEntityValue", "boolean", true),
                                            new VueProps("filterByEntityRefresh", "boolean", true)
                                        ]
                                    ),
                                    ["v-if" => "entity"]
                                ).'
                            </div>
                        </div>
                        <div style="clear:both;"></div>
                    </div>
                    
                    <div class="entityTab" data-tab="cards" v-bind:class="{showTab: dashboardTab === \'journey\'}">
                        <div class="width100 entityDetails">
                            <div v-if="entity" class="card-tile-100">
                                
                            </div>
                        </div>
                        <div style="clear:both;"></div>
                    </div>
                </div>
            </div>
        ';
    }

    protected function renderComponentComputedValues() : string
    {
        return '
            orderedCardContacts: function()
            {
                
            },
        ';
    }

}