<template>
    <div>
            
        <!-- HEADER START -->
        <div class="row">
            <div class="col-xs-6">
                <h1 class="title">{{ account.name }}</h1>
            </div>
            <div class="col-xs-6">
                <button 
                class="btn btn-default pull-right" 
                @click="clearNewUser(), openModal('#_modal-create-new-user')"
                >
                    <i class="fa fa-plus"></i> Create new user
                </button>
            </div>
        </div>
        <!-- HEADER END -->
        
        <hr/>

        <!-- ACCOUNT DETAILS START -->
        <div class="row">
            <div class="col-sm-6">
                <div class="col-sm-3">
                    <b>ID: </b> 
                </div>
                <div class="col-sm-9">
                    <span class="muted">{{ account.id }}</span>
                </div>
                <div class="col-sm-3">
                    <b>Status: </b> 
                </div>
                <div class="col-sm-9">
                    <span 
                    class="label" 
                    :class="account.status ? 'label-success' : 'label-danger'"
                    >
                        {{ account.status ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="col-sm-3">
                    <b>Localization: </b> 
                </div>
                <div class="col-sm-9">
                    <span>{{ account.localization.country }} {{ account.localization.city }}</span> <br>
                    <span>{{ account.localization.timezone }}</span>
                </div>
                <div class="col-sm-3">
                    <b>Language: </b> 
                </div>
                <div class="col-sm-9">
                    <span>{{ account.localization.language }}</span>  
                </div>
            </div>
        </div>
        <!-- ACCOUNT DETAILS END -->

        <hr />

        <!-- USERS START -->
        <div class="row">
            <div class="col-xs-12">
                <h2>Users</h2>
            </div>
        </div>
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
                <tr v-if="users_table_loading">
                    <td colspan="11" class="loader text-center">
                        <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
                    </td>
                </tr>
                <!-- TABLE LOADER END -->                          
                
                <!-- EMPTY TABLE MESSAGE START -->
                <tr v-else-if="users_table_empty">
                    <td colspan="11">
                        Sorry but theres nothing here... yet :)
                    </td>
                </tr>
                <!-- EMPTY TABLE MESSAGE END -->

                <tr v-else v-for="user in users">
                    <td>{{ user.first_name }} {{ user.last_name }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ user.phone ? user.phone : 'N/A' }}</td>
                    <td>
                        <button 
                        id="toggle"
                        :ref="user.id"
                        class="btn" 
                        :class="user.status ? 'btn-success' : 'btn-danger'" 
                        @click="toggleUserStatus(user.status, user.id)" 
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
                        @click="deleteUser(user.id)"
                        >
                            <i class="fa fa-check-circle-o"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- USERS END -->

        <hr/>

        <!-- CAMPAIGNS START -->
        <div class="row">
            <div class="col-xs-12">
                <h2>Campaigns</h2>
            </div>
        </div>
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
                <tr v-show="campaigns_table_loading">
                    <td colspan="11" class="loader text-center">
                        <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
                    </td>
                </tr>
                <!-- TABLE LOADER END -->
                
                <!-- EMPTY TABLE MESSAGE START -->
                <tr v-show="campaigns_table_empty">
                    <td colspan="11">
                        Sorry but theres nothing here... yet :)
                    </td>
                </tr>
                <!-- EMPTY TABLE MESSAGE END -->

                <tr v-for="campaign in campaigns">
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
                        @click="openModal('#_modal-show-json', campaign)" 
                        class="btn btn-primary" 
                        target="_blank"
                        >
                            View
                        </a>
                    </td>
                    <td>
                        <select  
                        @change="toggleCampaignStatus(campaign.id, campaign.status)" 
                        v-model="campaign.status">
                            <option v-for="status in statuses" :value="status">{{ status }}</option>
                        </select>
                    </td>
                    <td>
                        <button 
                        id="delete"
                        :ref="campaign.id"
                        :disabled="campaign.status != 'draft'"  
                        class="btn btn-danger" 
                        @click="deleteCampaign(campaign.id)"
                        >
                            <i class="fa fa-check-circle-o"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- CAMPAIGNS END -->

        <hr/>

        <!-- CREATIVES START -->
        <div class="row">
            <div class="col-xs-6">
                <h2>Creatives</h2>
            </div>
            <div class="col-xs-6">
                <button class="btn btn-default pull-right" @click="openModal('#_modal-add-creative')">
                    <i class="fa fa-plus"></i>
                    Add Creative
                </button>
            </div>
        </div>
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
                <tr v-if="creatives_table_loading">
                    <td colspan="11" class="loader text-center">
                        <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
                    </td>
                </tr>
                <!-- TABLE LOADER END -->

                <!-- EMPTY TABLE MESSAGE START -->
                <tr v-else-if="creatives_table_empty">
                    <td colspan="11">
                        Sorry but theres nothing here... yet :)
                    </td>
                </tr>
                <!-- EMPTY TABLE MESSAGE END -->

                <tr v-else v-for="creative in creatives">
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
                        @click="toggleCreativeStatus(creative.id, creative.approved)"
                        >
                            <i class="fa fa-check-circle-o"></i>
                        </button>
                    </td>
                    <td>
                        <button
                        :ref="creative.id"
                        id="delete" 
                        class="btn btn-danger" 
                        @click="deleteCreative(creative.id)">
                            <i class="fa fa-check-circle-o"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>  
        <!-- CREATIVES END -->          

        <hr/>

        <!-- BILLING START -->
        <div class="row">
            <div class="col-xs-12 col-md-6">
                <h2>Budget</h2>
                <span>
                    Balance: $
                    {{$root.twoDecimalPlaces($root.fromMicroDollars(banker.main + banker.flight))}} 
                    ({{$root.twoDecimalPlaces($root.fromMicroDollars(banker.flight))}}) 
                </span>
            </div>
            <div class="col-xs-12 col-md-6">
                <a class="btn btn-default pull-right" :href="account_id + '/billing'">Billing</a>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-4">
                <div class="col-md-12 panel panel-default">
                    <h4>Balance </h4>
                    <div id="chartdiv_0" style="height: 300px;"></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="col-md-12 panel panel-default">
                    <h4> In-Flight </h4>
                    <div id="chartdiv_1" style="height: 300px;"></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="col-md-12 panel panel-default">
                    <h4>Total Spend</h4>
                    <div id="chartdiv_2" style="height: 300px;"></div>
                </div>
            </div>
        </div>
        <!-- BILLING END -->

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
                            {{opened_json}}
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
                                    v-model="new_user.first_name"
                                    />
                                </div>
                                <div class="col-xs-12 col-md-6">
                                    <label for="label-last-name">Last Name</label>
                                    <br/>
                                    <input 
                                    type="text" 
                                    id="label-last-name" 
                                    class="form-control" 
                                    v-model="new_user.last_name"
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
                                        v-model="new_user.email"
                                        />
                                    </div>
                                    <div class="col-xs-12 col-md-6">
                                        <label for="label-phone-number">Phone number</label>
                                        <br/>
                                        <input 
                                        type="text" 
                                        class="form-control" 
                                        id="label-phone-number" 
                                        v-model="new_user.phone" 
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
                                        v-model="new_user.password"
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

        <!-- ADD CREATIVE START-->   
        <div class="modal fade" id="_modal-add-creative" tabindex="-1" role="dialog">
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
                        <div class="row">
                            <div 
                            id="uploader" 
                            class="col-xs-12"
                            style="padding-top: 15px; padding-bottom: 15px; text-align: center; background: repeating-linear-gradient(45deg, transparent, transparent 10px, #ccc 10px, #ccc 20px), linear-gradient( to bottom, #eee, #999); cursor: pointer;"
                            @mouseenter="dropzoneMaker()"
                            >
                                <span id="uploader-title" >Upload Creative Here</span>
                            </div>
                        </div>
                        <hr>
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
                            @click="uploadCreative(), add_creative_button_loading = true"
                            >
                                Create
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ADD CREATIVE END-->
        <!-- MODALS END -->

    </div>
</template>

<script>
    export default {
        mounted() {
            this.createChart();
        },

        data() {
            return {
                //ESSENTIALS
                token: '',
                account_id: window.location.pathname.replace('\/accounts\/', ''),
                dropzone: false,

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
                },

                //USERS 
                users: [],
                users_table_loading: true,
                users_table_empty: false,

                //CAMPAIGNS
                campaigns: [],
                opened_json: {},
                campaigns_table_loading: true,
                campaigns_table_empty: false,
                statuses: ['active', 'paused', 'archived', 'draft', 'not started', 'expired'],

                //CREATIVES
                creatives: [],
                folders:[],
                creatives_table_loading: true,
                creatives_table_empty: false,
                add_creative_button_loading: false,

                //BILLING
                banker: {
                    main: 0,
                    flight: 0,
                    spend: 0
                },

                //CREATE NEW USER MODAL
                new_user: {
                    first_name: '',
                    last_name: '',
                    email: '',
                    phone: '',
                    password: ''
                },
                new_creative: {},
                thumbnail: ''
            }
        },

        methods: {
            dropzoneMaker() {
                if (this.dropzone !== false) return;
                this.dropzone = new Dropzone("#uploader", {
                    url: this.$root.uri + '/creatives',
                    paramName: 'file',
                    maxFilesize: 2,
                    acceptedFiles: 'image/*, application/zip',
                    headers: {"Authorization": 'Bearer ' + this.token},
                    autoProcessQueue: false,
                    thumbnailWidth: 120,
                    thumbnailHeight: 120,
                    clickable: ['#uploader', '#uploader-title']
                });

                this.dropzone.on("addedfile", function(file, thumb) {
                    var is_zip = file.type.indexOf('zip') != -1 ? true : false;
                    var sizeInterval = setInterval(function () {
                        console.log(typeof file.width);
                        if(typeof file.width != 'undefined' || is_zip) {
                            this.new_creative = {
                                w: is_zip ? 0 : file.width,
                                h: is_zip ? 0 : file.height,
                                name: file.name.slice(0,file.name.lastIndexOf('.')),
                                class: is_zip ? 'html5' : 'banner',
                                url: '',
                                responsive: 0
                            };
                            clearInterval(sizeInterval);
                        }
                    }.bind(this), 1000);
                }.bind(this));

                this.dropzone.on("thumbnail", function(file, thumb) {
                    this.thumbnail = thumb;
                }.bind(this));
            },

            uploadCreative() {
                this.dropzone.options.params = {
                    //SEND THE PARAMETERS HERE
                };
                this.dropzone.processQueue();

                this.dropzone.on("complete", function (file) {
                    if (file.status == 'success') {
                        this.add_creative_button_loading = false;
                    }
                }.bind(this));
            },

            //OVERALL        
            buttonLoading(action, condition, id) {
                for(var button in this.$refs[id]) {
                    var targetted_button = this.$refs[id][button].id == action ? button : targetted_button;
                }
                condition ? this.$refs[id][targetted_button].children[0].className = 'fa fa-circle-o-notch fa-spin' : 
                            this.$refs[id][targetted_button].children[0].className = 'fa fa-check-circle-o';
            },

            openModal(identifier, json) {
                this.opened_json = json ? json : '';
                $(identifier).modal();
            },

            //NEW USER MODAL
            createNewUser() {
                this.users_table_loading = true;
                axios.post(
                    this.$root.api + 'accounts/' + this.account.id + '/users', 
                    this.new_user,
                    this.$root.config
                ).then(response => {
                        this.clearNewUser();
                        this.getUsers();
                        this.users_table_loading = false;
                    }, error => {
                        this.clearNewUser();
                        this.getUsers();
                        this.users_table_loading = false;
                    }
                );
            },

            clearNewUser() {
                this.new_user.first_name = '';
                this.new_user.last_name = '';
                this.new_user.email = '';
                this.new_user.phone = '';
                this.new_user.password = '';
            },

            //ACCOUNT DETAILS
            getAccount() {
                var self = this;

                axios.get(
                    this.$root.api + 'accounts/' + this.account_id, 
                    this.$root.config
                ).then(response => {
                        this.account = response.data.data;
                    }, error => {

                    }
                );
            },

            //USERS
            getUsers(id) {
                axios.get(
                    this.$root.api + 'accounts/' + this.account.id + '/users', 
                    this.$root.config
                ).then(response => {
                        this.users_table_empty = response.data.data == '' ? true : false; 
                        this.users = response.data.data;
                        this.users_table_loading = false;
                        if(id) {
                            this.buttonLoading('delete' ,false, id);
                            this.buttonLoading('toggle', false, id);
                        }
                    }, error => {
                        this.users_table_loading = false;
                    }
                );
            },

            deleteUser(id) {
                this.buttonLoading('delete', true, id);

                axios.delete(
                    this.$root.api + 'accounts/' +  this.account.id + '/users/' + id, 
                    this.$root.config
                ).then(response => {
                        this.getUsers(id);
                    }, error => {
                        this.getUsers(id);
                    }
                );
            },

            toggleUserStatus(status, id) {
                this.buttonLoading('toggle', true, id);
                var status = status ? 0 : 1; 

                axios.put(
                    this.$root.api + 'accounts/' +  this.account.id + '/users/' + id, 
                    {status: status}, 
                    this.$root.config
                ).then(response => {
                        this.getUsers(id);
                    }, error => {
                        this.getUsers(id);
                    }
                );
            },

            //CAMPAIGNS
            getCampaigns(id) {
                axios.get(
                    this.$root.api + 'accounts/' +  this.account.id + '/campaigns', 
                    this.$root.config
                ).then(response => {
                        this.campaigns_table_empty = response.data.data == '' ? true : false;
                        this.campaigns = response.data.data;
                        this.campaigns_table_loading = false;
                        if(id) this.buttonLoading('delete', false, id);
                    }, error => {
                        this.campaigns_table_loading = false;
                    }
                );
            },

            deleteCampaign(id) {
                this.buttonLoading('delete', true, id);

                axios.delete(
                    this.$root.api + 'campaigns/' + id, 
                    this.$root.config
                ).then(response => {
                        this.getCampaigns(id);        
                    }, error => {
                        this.getCampaigns(id);
                    }
                );
            },

            toggleCampaignStatus(id, status) {
                axios.put(
                    this.$root.api + 'campaigns/' + id, 
                    {status: status}, 
                    this.$root.config
                ).then(response => {
                        this.getCampaigns();
                    }, error => {
                        this.getCampaigns();
                    }
                );
            },

            //CREATIVES
            getFolders() {
                axios.get(
                    this.$root.api + 'creatives/' +  this.account.id + '/folders', 
                    this.$root.config
                ).then(response => {
                        this.folders = response.data.data;
                    }, error => {
                    
                    }
                );
            },

            getCreatives(id) {
                var folders = this.folders;
                if (folders == '') this.creatives_table_empty = true;
                for (var folder in folders) {
                    axios.get(
                        this.$root.api + 'creatives/' +  this.account.id + '/folders/' + folders[folder].id, 
                        this.$root.config
                    ).then(response => {
                            this.creatives.push(response.data.data);
                            this.creatives = [].concat.apply([], this.creatives);
                            this.creatives_table_empty = this.creatives == [] ? true : false;
                            if(id) {
                                this.buttonLoading('delete', false, id);
                                this.buttonLoading('toggle', false, id);
                            }
                        }, error => {

                        }
                    );
                }
                this.creatives_table_loading = false;
            },

            toggleCreativeStatus(id, status) {
                var toggle_statuses = {
                    approved: 'declined',
                    declined: 'approved',
                    pending: 'approved'
                };
                this.buttonLoading('toggle', true, id);

                axios.put(
                    this.$root.api + 'creatives/' + id, 
                    {status: toggle_statuses[status]}, 
                    this.$root.config
                ).then(response => {
                        this.getCreatives(id);
                    }, error => {
                        this.getCreatives(id);
                    }
                );
            },

            deleteCreative(id) {
                this.buttonLoading('delete', true, id);

                axios.delete(
                    this.$root.api + 'creatives/' + id, 
                    this.$root.config
                ).then(response => {
                        this.getCreatives(id);
                    }, error => {
                        this.getCreatives(id);
                    }
                );
            },

            //BILLING
            getMain() {
                axios.get(
                    this.$root.api + 'accounts/' +  this.account_id + '/banker/main?query=balance', 
                    this.$root.config
                ).then(response => {
                        this.banker.main = response.data.data.balance;
                    }, error => {
                    
                    }
                );
            },

            getFlight() {
                axios.get(
                    this.$root.api + 'accounts/' +  this.account_id + '/banker/flight?query=balance', 
                    this.$root.config
                ).then(response => {
                        this.banker.flight = response.data.data.balance;
                    }, error => {

                    }
                );
            },

            getSpend() {
                axios.get(
                    this.$root.api + 'accounts/' +  this.account_id + '/banker/spend?query=balance', 
                    this.$root.config
                ).then(response => {
                        this.banker.spend = response.data.data.balance
                    }, error => {

                    }
                );
            },

             getBalanceData(){
                this.getMain();
                this.getFlight();
                this.getSpend();

                var balance = this.$root.fromMicroDollars(this.banker.main + this.banker.flight).toFixed(2);

                return {
                    "balance": balance,
                    "flight": this.banker.flight,
                    "spend": this.banker.spend
                }
            },

            //CHARTS
            createChart() {
                var self = this; 
                var chart = [];
                for(var c = 0; c <= 2; c++) {
                    chart[c] = AmCharts.makeChart( 'chartdiv_' + c, {
                      "type": "serial",
                      "theme": "light",
                      "zoomOutButton": {
                        "backgroundColor": '#000000',
                        "backgroundAlpha": 0.15
                        },
                        "dataProvider": self.emptyData(),
                        "categoryField": "date",
                        "categoryAxis": {
                            "parseDates": true,
                            "minPeriod": "ss",
                            "dashLength": 1,
                            "gridAlpha": 0.15,
                            "axisColor": "#DADADA"
                        },
                        "graphs": [ {
                            "id": "balance",
                            "valueField": "balance",
                            "lineThickness": 2,
                            "lineColor": "#337ab7",
                            "bullet": "round",
                            "bulletAlpha": 0,
                            "hideBulletsCount": 50
                        }],
                        "balloon": {
                            "borderColor": "#337ab7",
                            "borderAlpha": 0,
                            "borderThickness": 0,
                            "shadowAlpha": 0,
                            "color": "#ffffff",
                            "drop": false,
                            "cornerRadius": 5,
                            "fillColor": "#337ab7",
                            "fillAlpha": 1,
                        }
                    } )
                }

                setInterval( function() {
                    chart[0].dataProvider.shift();
                    chart[1].dataProvider.shift();
                    chart[2].dataProvider.shift();
                    var time = new Date();
                    var data = self.getBalanceData();
                    chart[0].dataProvider.push({
                        "date": time,
                        "balance": data.balance
                    });
                    chart[1].dataProvider.push({
                        "date": time,
                        "balance": data.flight
                    });
                    chart[2].dataProvider.push({
                        "date": time,
                        "balance": data.spend
                    });
                    chart[0].validateData();
                    chart[1].validateData();
                    chart[2].validateData();
                }, 5000 );
            },

            emptyData() {
                var empty_data = []
                var time = new Date();
                var data = 0;
                for (var i = 40; i >= 0; i--) {
                    var d = {
                        "date" : time - (i * 5000),
                        "balance": data
                    };
                    empty_data.push(d);
                }
                return empty_data;
            },
        },

        watch: {
            token(value) {
                this.getAccount();
            },

            folders(value) {
                this.getCreatives();
            },

            account(value) {
                this.getFolders();
                this.getUsers();
                this.getCampaigns();
                this.getBalanceData();
            }
        }
    }
</script>