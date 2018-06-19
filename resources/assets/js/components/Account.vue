<template>
    <div>        
        <div class="row" style="padding-left: 16px; padding-right: 16px;">
            <div class="panel panel-default">
                <div class="panel-heading">Details</div>
                <div v-if="account.id.length == 0" class="panel-body" style="display: flex; justify-content: center;">
                    <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
                </div>
                <div v-else class="panel-body">
                    <div class="col-xs-6">
                        <label>Name: </label> {{account.name}} <br>
                        <label>ID: </label> {{account.id}} <br>
                        <label>Status: </label> 
                            <span class="label" :class="account.status ? 'label-success' : 'label-danger'">
                                {{ account.status ? 'Active' : 'Inactive' }}
                            </span>
                    </div>
                    <div class="col-xs-6">
                        <label>Localization: </label> 
                        {{ account.localization.country + ', ' + account.localization.city + ' | ' + account.localization.timezone }}<br>
                        <label>Language: </label> {{account.localization.language}}
                    </div>
                </div>
            </div>
        </div>

        <hr />

        <div class="row" style="padding-left: 16px; padding-right: 16px;">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row" style="display: flex; align-items: center">
                        <div class="col-xs-8">
                            Users
                        </div>
                        <div class="col-xs-4">
                            <button 
                            class="btn btn-default pull-right" 
                            @click="openCreateNewUser()"
                            >
                                <i class="fa fa-plus"></i> Create new user
                            </button>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Delete User</th>
                            </tr>
                        </thead>
                        <tbody>        

                            <!-- TABLE LOADER START -->                   
                            <tr v-if="users.loading">
                                <td colspan="11" class="loader text-center">
                                    <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
                                </td>
                            </tr>
                            <!-- TABLE LOADER END -->                          
                            
                            <!-- EMPTY TABLE MESSAGE START -->
                            <tr v-else-if="users.empty">
                                <td colspan="11">
                                    Sorry but theres nothing here... yet :)
                                </td>
                            </tr>
                            <!-- EMPTY TABLE MESSAGE END -->

                            <tr v-else v-for="user in lists.users">
                                <td>{{ user.first_name }} {{ user.last_name }}</td>
                                <td>{{ user.email }}</td>
                                <td>{{ user.phone ? user.phone : 'N/A' }}</td>
                                <td>
                                    <button 
                                    id="toggle"
                                    :ref="user.id"
                                    class="btn" 
                                    :class="user.status ? 'btn-success' : 'btn-danger'" 
                                    @click="toggleUserStatus(user.status, user.id, $event)" 
                                    >
                                        <i 
                                        :class="user_status_button_loading ? 
                                        'fa fa-circle-o-notch fa-spin' : 
                                        'fa fa-check-circle-o'"
                                        >
                                        </i>
                                    </button>
                                </td>
                                <td>
                                    <button 
                                    id="delete"
                                    :ref="user.id"
                                    class="btn btn-danger" 
                                    @click="deleteUser(user.id, $event)"
                                    >
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <hr />

        <div class="row" style="padding-left: 16px; padding-right: 16px;">
            <div class="panel panel-default">
                <div class="panel-heading">Campaigns</div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Adomain</th>
                                <th>CTR URL</th>
                                <th>Budget</th>
                                <th>Daily</th>
                                <th>Creatives</th>
                                <th>JSON</th>
                                <th>Status</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody class="vcenter">

                            <!-- TABLE LOADER START -->
                            <tr v-show="campaigns.loading">
                                <td colspan="11" class="loader text-center">
                                    <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
                                </td>
                            </tr>
                            <!-- TABLE LOADER END -->
                            
                            <!-- EMPTY TABLE MESSAGE START -->
                            <tr v-show="campaigns.empty">
                                <td colspan="11">
                                    Sorry but theres nothing here... yet :)
                                </td>
                            </tr>
                            <!-- EMPTY TABLE MESSAGE END -->

                            <tr v-for="campaign in lists.campaigns">
                                <td>{{ campaign.id }}</td>
                                <td>
                                    <a :href="account_id + '/campaigns/' + campaign.id">
                                        {{ campaign.name }}
                                    </a>
                                </td>
                                <td>{{ campaign.start_time }}</td>
                                <td>{{ campaign.end_time }}</td>
                                <td>
                                    <a :href="'http://' + campaign.adomain" target="_blank">
                                        {{ campaign.adomain }}
                                    </a>
                                </td>
                                <td>
                                    <a :href="campaign.ctrurl" target="_blank">
                                        {{ campaign.ctrurl }}
                                    </a>
                                </td>
                                <td>${{ $root.fromMicroDollars(campaign.budget.data.amount) }}</td>
                                <td>${{ $root.fromMicroDollars(campaign.bid) }}</td>
                                <td>
                                    <a 
                                    :href="'/accounts/' + account_id + '/campaigns/' + campaign.id + '/creatives'" 
                                    class="btn btn-primary"
                                    >
                                        View
                                    </a>
                                </td>
                                <td>
                                    <a 
                                    @click="openJson(campaign)" 
                                    class="btn btn-primary" 
                                    target="_blank"
                                    >
                                        View
                                    </a>
                                </td>
                                <td>
                                    <select  
                                    @change="toggleCampaignStatus(campaign)" 
                                    v-model="campaign.status">
                                        <option v-for="status in lists.status" :value="status">{{ status }}</option>
                                    </select>
                                </td>
                                <td>
                                    <button 
                                    id="delete"
                                    :ref="campaign.id"
                                    :disabled="campaign.status != 'draft'"  
                                    class="btn btn-danger" 
                                    @click="deleteCampaign(campaign.id, $event)"
                                    >
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <hr/>

        <div class="row" style="padding-left: 16px; padding-right: 16px;">
            <div class="panel panel-default">
                <div class="panel-heading">Creatives</div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Class</th>
                                <th>Dimensions</th>
                                <th>Image</th>
                                <th>Approve</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody class="vcenter">

                            <!-- TABLE LOADER START -->
                            <tr v-if="creatives.loading">
                                <td colspan="11" class="loader text-center">
                                    <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
                                </td>
                            </tr>
                            <!-- TABLE LOADER END -->

                            <!-- EMPTY TABLE MESSAGE START -->
                            <tr v-else-if="creatives.empty">
                                <td colspan="11">
                                    Sorry but theres nothing here... yet :)
                                </td>
                            </tr>
                            <!-- EMPTY TABLE MESSAGE END -->

                            <tr v-else v-for="creative in lists.creatives">
                                <td>{{ creative.id }}</td>
                                <td>
                                    <a :href=" account_id + '/creatives/' + creative.id">
                                        {{ creative.name }}
                                    </a>
                                </td>
                                <td>{{ creative.class }}</td>
                                <td>{{ creative.w }}x{{ creative.h}}</td>
                                <td> 
                                    <a :href="creative.iurl" target="_blank">
                                        <img width="70px" :src="creative.thumb">
                                    </a> 
                                </td>
                                <td>
                                    <button 
                                    :ref="creative.id"
                                    id="toggle"
                                    :class="creative.approved == 'approved' ? 'btn btn-success': 'btn btn-danger'" 
                                    @click="toggleCreativeStatus(creative, $event)"
                                    >
                                        <i class="fa fa-check-circle-o"></i>
                                    </button>
                                </td>
                                <td>
                                    <button
                                    :ref="creative.id"
                                    id="delete" 
                                    class="btn btn-danger" 
                                    @click="deleteCreative(creative.id, $event)">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>                        
                </div>
            </div>
        </div>

        <hr />

        <div class="row" style="padding-left: 16px; padding-right: 16px;">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row" style="display: flex; align-items: center;">
                        <div class="col-md-4">
                            Bills
                        </div>
                        <div class="col-md-4">
                            <button 
                            class="btn btn-default pull-right" 
                            @click="openCreateNewBill()"
                            >
                                <i class="fa fa-plus"></i> Create new bill
                            </button>
                        </div>
                        <div class="col-md-4">
                            <input 
                            type="search" 
                            class="form-control" 
                            placeholder="Search bill id..." 
                            v-model="bills.search"
                            />
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Credit/Debit</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Method</th>
                            </tr>
                        </thead>
                        <tbody class="vcenter">

                            <!-- TABLE LOADER START -->
                            <tr v-if="bills.loading">
                                <td colspan="11" class="loader text-center">
                                    <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
                                </td>
                            </tr>
                            <!-- TABLE LOADER END -->
                            
                            <!-- EMPTY TABLE MESSAGE START -->
                            <tr v-else-if="bills.empty">
                                <td colspan="11">
                                    <span v-if="bills.search.length > 0">
                                        Can't find anything related to <strong>{{ bills.search }}</strong>
                                    </span>
                                    <span v-else>No results</span>
                                </td>
                            </tr>
                            <!-- EMPTY TABLE MESSAGE END -->
                            
                            <tr v-else v-for="bill in filtered_bills">
                                <td> {{ bill.id }} </td>
                                <td> {{ bill.debit ? 'Debit' : 'Credit' }}</td>
                                <td> {{ bill.timestamp }} </td>
                                <td> {{ bill.debit ? $root.fromMicroDollars(bill.debit) : $root.fromMicroDollars(bill.credit) }} </td>
                                <td> {{ bill.description }} </td>
                            </tr>
                        </tbody>
                    </table>            
                </div>
            </div>
        </div>

        <br><br><br><br>

        <!-- MODALS START -->
        <!-- CAMPAIGN JSON MODAL START-->    
        <div class="modal fade" id="_modal-show-json" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">JSON</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            {{campaigns.opened_json}}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button 
                        type="button" 
                        class="btn btn-default" 
                        data-dismiss="modal"
                        >
                            Close
                        </button>
                        <button 
                        type="button" 
                        class="btn btn-primary" 
                        data-dismiss="modal" 
                        @click="createNewUser()"
                        >
                            Create
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- CAMPAIGN JSON MODAL END--> 

        <!-- CREATE NEW USER START-->   
        <div class="modal fade" id="_modal-create-new-user" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button 
                        type="button" 
                        class="close" 
                        data-dismiss="modal" 
                        aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Create New User</h4>
                    </div>
                    <div class="modal-body">
                        <h5>DETAILS</h5>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-12 col-md-6">
                                    <label for="label-first-name">First Name</label>
                                    <br/>
                                    <input 
                                    type="text" 
                                    id="label-first-name" 
                                    class="form-control" 
                                    v-model="users.new_user.first_name"
                                    />
                                </div>
                                <div class="col-xs-12 col-md-6">
                                    <label for="label-last-name">Last Name</label>
                                    <br/>
                                    <input 
                                    type="text" 
                                    id="label-last-name" 
                                    class="form-control" 
                                    v-model="users.new_user.last_name"
                                    />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-12 col-md-6">
                                        <label for="label-email">E-mail</label>
                                        <br/>
                                        <input 
                                        type="text" 
                                        class="form-control" 
                                        id="label-email" 
                                        v-model="users.new_user.email"
                                        />
                                    </div>
                                    <div class="col-xs-12 col-md-6">
                                        <label for="label-phone-number">Phone number</label>
                                        <br/>
                                        <input 
                                        type="text" 
                                        class="form-control" 
                                        id="label-phone-number" 
                                        v-model="users.new_user.phone" 
                                        />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <label for="label-password">Password</label>
                                        <br/>
                                        <input 
                                        type="password" 
                                        class="form-control" 
                                        id="label-password" 
                                        v-model="users.new_user.password"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button 
                            type="button" 
                            class="btn btn-default" 
                            data-dismiss="modal"
                            >
                                Close
                            </button>
                            <button 
                            type="button" 
                            class="btn btn-primary" 
                            data-dismiss="modal" 
                            @click="createNewUser()"
                            >
                                Create
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- CREATE NEW USER END-->

        <!-- CREATE NEW BILL START-->
        <div class="modal fade" id="_modal-create-new-bill" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button 
                        type="button" 
                        class="close" 
                        data-dismiss="modal" 
                        aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Create New Bill</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-12 col-md-6">
                                        <label for="label-city">Amount</label>
                                        <br/>
                                        <input 
                                        type="number" 
                                        class="form-control" 
                                        v-model="bills.new_bill.credit" 
                                        id="label-city" 
                                        />
                                    </div>
                                    <div class="col-xs-12 col-md-6">
                                        <label for="label-city">Tran Number</label>
                                        <br/>
                                        <input 
                                        type="text" 
                                        class="form-control" 
                                        id="label-city" 
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <label for="label-approved">Method of Payment</label>
                                        <br/>
                                        <select 
                                        class="form-control" 
                                        id="label-approved" 
                                        v-model="bills.new_bill.description"
                                        >
                                            <option value="cc payment">Credit Card</option>
                                            <option value="paypal payment">Paypal</option>
                                            <option value="bank transfer">Bank Transfer</option>
                                            <option value="cheque deposit">Cheque Deposit</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button 
                        type="button" 
                        class="btn btn-default" 
                        data-dismiss="modal"
                        >
                            Close
                        </button>
                        <button 
                        type="button" 
                        class="btn btn-primary" 
                        data-dismiss="modal" 
                        @click="createNewBill()"
                        >
                            Create
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- CREATE NEW BILL END-->
        <!-- MODALS END -->

    </div>
</template>

<script>
    export default {
        data() {
            return {
                //ESSENTIALS
                token: '',
                account_id: window.location.pathname.replace('\/accounts\/', ''),

                lists: {
                    users: [],
                    campaigns: [],
                    creatives: [],
                    status: ['active', 'paused', 'archived', 'draft', 'not started', 'expired'],
                    folders: [],
                    bills: []
                },

                bills: {
                    loading: true,
                    empty: false,
                    search: '',
                    new_bill: {
                        credit: 0,
                        description: 'cc payment'
                    }
                },

                creatives: {
                    loading: true,
                    empty: false
                },

                campaigns: {
                    loading: true,
                    empty: false,
                    opened_json: ''
                },

                users: {
                    loading: true,
                    empty: false,
                    new_user: {
                        first_name: '',
                        last_name: '',
                        email: '',
                        phone: '',
                        password: ''
                    }
                },


                //ACCOUNT DETAILS
                account: {
                    id: '',
                    name: '',
                    status: 0,
                    billing: {
                        address: '',
                        city: '',
                        company: '',
                        country: '',
                        email: ''
                    },
                    localization: {
                        city: '',
                        country: '',
                        language: '',
                        timezone: ''
                    }
                }
            }
        },

        methods: {
            getLists() {
                this.getUsers();
                this.getCampaigns();
                this.getFolders();
                this.getBills();
            },

            getAccount() {
                axios.get(
                    this.$root.api + '/accounts/' + this.account_id, 
                    this.$root.config
                ).then(response => {
                        this.account = response.data.data;
                    }, error => {

                    }
                );
            },

            getUsers() {
                axios.get(
                    this.$root.api + '/accounts/' + this.account_id + '/users', 
                    this.$root.config
                ).then(response => {
                        this.lists.users = response.data.data;
                        this.users.empty = this.lists.users.length > 0 ? false : true;
                        this.users.loading = false;
                    }, error => {
                        this.users.loading = false;
                    }
                );
            },

            getCampaigns() {
                axios.get(
                    this.$root.api + '/accounts/' +  this.account_id + '/campaigns', 
                    this.$root.config
                ).then(response => {
                        this.lists.campaigns = response.data.data;
                        this.campaigns.empty = this.lists.campaigns.length > 0 ? false : true;
                        this.campaigns.loading = false;
                    }, error => {
                        this.campaigns.loading = false;
                    }
                );
            },

            getFolders() {
                axios.get(
                    this.$root.api + '/creatives/' +  this.account_id + '/folders', 
                    this.$root.config
                ).then(response => {
                        this.lists.folders = response.data.data;
                        this.getCreatives();
                    }, error => {
                    
                    }
                );
            },

            getCreatives() {
                var folders = this.lists.folders;
                this.lists.creatives = [];
                for (var folder in folders) {
                    axios.get(
                        this.$root.api + '/creatives/' +  this.account_id + '/folders/' + folders[folder].id, 
                        this.$root.config
                    ).then(response => {
                            this.lists.creatives.push(response.data.data);
                            this.lists.creatives = [].concat.apply([], this.lists.creatives);
                            this.creatives.empty = this.lists.creatives.length > 0 ? false : true;
                        }, error => {

                        }
                    );
                }
                this.creatives.loading = false;
            },

            getBills() {
                axios.get(
                    this.$root.api + '/accounts/' + this.account_id + '/banker/main?type=billing', 
                    this.$root.config
                ).then(response => {
                        this.lists.bills = response.data.data;
                        this.bills.empty = this.lists.bills.length > 0 ? false : true;
                        this.bills.loading = false;
                    }, error => {
                        this.bills.loading = false;
                    }
                );
            },

            //NEW USER MODAL
            createNewUser() {
                this.users.loading = true;
                axios.post(
                    this.$root.api + '/accounts/' + this.account_id + '/users', 
                    this.users.new_user,
                    this.$root.config
                ).then(response => {
                        this.getUsers();
                    }, error => {
                        this.getUsers();
                    }
                );
            },

            deleteUser(id, event) {
                var image = this.$root.clickedButton();
                image.className = 'fa fa-circle-o-notch fa-spin';
                
                axios.delete(
                    this.$root.api + '/accounts/' +  this.account.id + '/users/' + id, 
                    this.$root.config
                ).then(response => {
                        this.getUsers();
                        image.className = "fa fa-trash";
                    }, error => {
                        this.getUsers();
                        image.className = "fa fa-trash";
                    }
                );
            },

            toggleUserStatus(status, id, event) {
                var status = status ? 0 : 1; 
                var image = this.$root.clickedButton(event);
                image.className = 'fa fa-circle-o-notch fa-spin';

                axios.put(
                    this.$root.api + '/accounts/' +  this.account.id + '/users/' + id, 
                    {status: status}, 
                    this.$root.config
                ).then(response => {
                        this.getUsers(id);
                        image.className = 'fa fa-check-circle-o';
                    }, error => {
                        this.getUsers(id);
                        image.className = 'fa fa-check-circle-o';
                    }
                );
            },

            deleteCampaign(id, event) {
                var image = this.$root.clickedButton(event);
                image.className = 'fa fa-circle-o-notch fa-spin';

                axios.delete(
                    this.$root.api + '/campaigns/' + id, 
                    this.$root.config
                ).then(response => {
                        this.getCampaigns(); 
                        image.className = "fa fa-trash";       
                    }, error => {
                        this.getCampaigns();
                        image.className = "fa fa-trash";
                    }
                );
            },

            toggleCampaignStatus(campaign) {
                axios.put(
                    this.$root.api + '/campaigns/' + campaign.id, 
                    {status: campaign.status}, 
                    this.$root.config
                ).then(response => {
                        this.getCampaigns();
                    }, error => {
                        this.getCampaigns();
                    }
                );
            },

            toggleCreativeStatus(creative, event) {
                var toggle_statuses = {
                    approved: 'declined',
                    declined: 'approved',
                    pending: 'approved'
                };

                var new_status = toggle_statuses[creative.approved];
                var image = this.$root.clickedButton(event);
                image.className = 'fa fa-circle-o-notch fa-spin';
                
                axios.put(
                    this.$root.api + '/creatives/' + creative.id, 
                    {status: new_status}, 
                    this.$root.config
                ).then(response => {;
                        this.getCreatives();
                        image.className = 'fa fa-check-circle-o';
                    }, error => {
                        this.getCreatives();
                        image.className = 'fa fa-check-circle-o';
                    }
                );
            },

            deleteCreative(id, event) {
                var image = this.$root.clickedButton(event);
                image.className = 'fa fa-circle-o-notch fa-spin';

                axios.delete(
                    this.$root.api + '/creatives/' + id, 
                    this.$root.config
                ).then(response => {
                        this.getCreatives();
                        image.className = "fa fa-trash";
                    }, error => {
                        this.getCreatives();
                        image.className = "fa fa-trash";
                    }
                );
            },


            collectNewBill() {
                return {
                    invoice_id: 'TZ0001ARG125878',
                    credit: this.$root.toMicroDollars(this.bills.new_bill.credit),
                    description: this.bills.new_bill.description,
                    type: 'billing'
                }
            },

            createNewBill() {
                this.bills.loading = true;

                axios.post(
                    this.$root.api + '/accounts/' + this.account_id + '/banker/main', 
                    this.collectNewBill(), 
                    this.$root.config
                ).then(response => {
                        this.getBills();
                    }, error => {
                        this.getBills();
                    }
                );
            },

            openCreateNewUser() {
                $('#_modal-create-new-user').modal();
            },

            openJson(campaign) {
                this.campaigns.opened_json = campaign;
                $('#_modal-show-json').modal();
            },

            openCreateNewBill() {
                $('#_modal-create-new-bill').modal();
            },

        },

        computed: {
            filtered_bills() {
                var self = this;

                var results = this.lists.bills.filter(bill => 
                    bill.id.toLowerCase().indexOf(self.bills.search) != -1
                );

                return results;
            }
        },

        watch: {
            token(value) {
                this.getAccount();
                this.getLists();
            },

            filtered_bills(value) {
                this.bills.empty = value.length > 0 ? false : true;
            }
        }
    }
</script>