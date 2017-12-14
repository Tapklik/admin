<template>
    <div>

        <!-- VISIBLE PART START-->
        <div>
            
            <!-- HEADER START -->
            <div class="row">
                <div class="col-xs-6">
                    <h1 class="title">{{ account.name }}</h1>
                </div>
                <div class="col-xs-6">
                    <button class="btn btn-default pull-right" @click="openCreateUser()">
                        <i class="fa fa-plus"></i> Create new user
                    </button>
                </div>
            </div>
            <!-- HEADER END -->
            
            <hr/>

            <!-- ACCOUNT DETAILS & USERS START -->
            <div class="row">

                <!-- ACCOUNT DETAILS (LEFT 5/12) START -->
                <div class="col-sm-5">
                    <div class="col-sm-3">
                        <b>ID: </b> 
                    </div>
                    <div class="col-sm-9">
                        <span class="muted">{{account.id}}</span>
                    </div>
                    <div class="col-sm-3">
                        <b>Status: </b> 
                    </div>
                    <div class="col-sm-9">
                        <span class="label" :class="account.status ? 'label-success' : 'label-danger'">
                            {{account.status ? 'Active' : 'Inactive'}}
                        </span>
                    </div>
                    <div class="col-sm-3">
                        <b>Localization: </b> 
                    </div>
                    <div class="col-sm-9">
                        <span>{{account.localization.country}} {{account.localization.city}}</span> <br>
                        <span>{{account.localization.timezone}}</span>
                    </div>
                    <div class="col-sm-3">
                        <b>Language: </b> 
                    </div>
                    <div class="col-sm-9">
                        <span>{{account.localization.language}}</span>  
                    </div>
                </div>
                <!-- ACCOUNT DETAILS (LEFT 5/12) END -->

                <!-- USERS (RIGHT 7/12) START -->
                <div class="col-sm-7">
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

                            <tr v-for="user in users">
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
                                        class="fa" 
                                        :class="user_status_button_loading ? 'fa-circle-o-notch fa-spin' : 'fa-check-circle-o'"
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
                </div>
                <!-- USERS (RIGHT 7/12) END -->

            </div>
            <!-- ACCOUNT DETAILS & USERS END -->

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
                                {{campaign.ctrurl}}
                            </a>
                        </td>
                        <td>${{ $root.fromMicroDollars(campaign.budget.data.amount) }}</td>
                        <td>${{ $root.fromMicroDollars(campaign.bid) }}</td>
                        <td>
                            <a :href="'/accounts/'+ account_id +'/campaigns/'+campaign.id+'/creatives'"  class="btn btn-primary">
                                View
                            </a>
                        </td>
                        <td>
                            <a @click="openJSON(campaign)"  class="btn btn-primary" target="_blank">
                                View
                            </a>
                        </td>
                        <td>
                            <select  @change="toggleStatus(campaign.id, campaign.status)" v-model="campaign.status">
                                <option v-for="s in statuses" :value="s">{{s}}</option>
                            </select>
                        </td>
                        <td>
                            <button v-if="campaign.status == 'draft'" class="btn btn-danger" @click="deleteCampaign(campaign.id)">
                                <i class="fa fa-check-circle-o"></i>
                            </button>
                            <button v-else :disabled="true" class="btn btn-danger" @click="archiveCampaign(campaign.id)">
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
                <div class="col-xs-12">
                    <h2>Creatives</h2>
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

                    <tr v-else v-for="c in creatives">
                        <td>{{ c.id }}</td>
                        <td>
                            <a :href=" account_id + '/creatives/' + c.id">
                                {{ c.name }}
                            </a>
                        </td>
                        <td>{{ c.class }}</td>
                        <td>{{ c.w }}x{{ c.h}}</td>
                        <td> <a :href="c.iurl" target="_blank"><img width="70px" :src="c.thumb"></a> </td>
                        <td>
                            <button :class="{'btn btn-success': c.approved == 'approved', 'btn btn-danger': c.approved != 'approved'}" @click="toggleApproval(c.id, c.approved)">
                                <i class="fa fa-check-circle-o"></i>
                            </button>
                        </td>
                        <td>
                            <button class="btn btn-danger" @click="deleteCreative(c.id)">
                                <i class="fa fa-check-circle-o"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>  
            <!-- CREATIVES END -->          

            <hr/>

            <!-- BUDGET START -->
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <h2>Budget</h2>
                    <span>Balance: ${{$root.twoDecimalPlaces($root.fromMicroDollars(balance + flight))}} ({{$root.twoDecimalPlaces($root.fromMicroDollars(flight))}}) </span>
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
            <!-- BUDGET END -->

        </div>
        <!-- VISIBLE PART END -->

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
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal" @click="createNewUser()">Create</button>
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
                                    <input type="text" id="label-first-name" class="form-control" v-model="new_user.first_name"/>
                                </div>
                                <div class="col-xs-12 col-md-6">
                                    <label for="label-last-name">Last Name</label>
                                    <br/>
                                    <input type="text" id="label-last-name" class="form-control" v-model="new_user.last_name"/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-12 col-md-6">
                                        <label for="label-email">E-mail</label>
                                        <br/>
                                        <input type="text" class="form-control" id="label-email" v-model="new_user.email"/>
                                    </div>

                                    <div class="col-xs-12 col-md-6">
                                        <label for="label-phone-number">Phone number</label>
                                        <br/>
                                        <input type="text" class="form-control" id="label-phone-number" v-model="new_user.phone" />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <label for="label-password">Password</label>
                                        <br/>
                                        <input type="password" class="form-control" id="label-password" v-model="new_user.password"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" data-dismiss="modal" @click="createNewUser()">Create</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- CREATE NEW USER END-->

    </div>
</template>

<script>
    export default {
        mounted() {
            this.createChart();
        },

        data() {

            return {
                user_status_button_loading: false,
                users_table_empty: false,
                campaigns_table_empty: false,
                creatives_table_empty: false,
                statuses: ['active', 'paused', 'archived', 'declined', 'deleted', 'draft'],
                balance: 0,
                flight: 0,
                opened_json: {},
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
                users: {},
                new_user: {
                    first_name: '',
                    last_name: '',
                    email: '',
                    phone: '',
                    password: ''
                },
                token: false,
                campaigns: [],
                folders:[],
                banker: {
                    main: 0,
                    flight: 0,
                    spend: 0
                },
                users_table_loading: true,
                creatives: {},
                account_id: window.location.pathname.replace('\/accounts\/', ''),
                creatives_table_loading: true,
                campaigns_table_loading: true
            }
        },

        methods: {

            buttonLoading(action, condition, id) {
                for(var button in this.$refs[id]) {
                    var targetted_button = this.$refs[id][button].id == action ? button : targetted_button;
                }
                condition ? this.$refs[id][targetted_button].children[0].className = 'fa fa-circle-o-notch fa-spin' : 
                            this.$refs[id][targetted_button].children[0].className = 'fa fa-check-circle-o';
            },

            deleteCreative(id) {
                this.creatives_table_loading = true;
                axios.delete(this.$root.api + 'creatives/' + id, this.$root.config).then( response => {
                    this.getCreatives();
                }, error => {
                    alert(error);
                });
            },

            fetchUsers() {
                var self = this;

                axios.get(this.$root.api + 'accounts/' + this.account.id + '/users', this.$root.config).then( response => {
                    this.users = response.data.data;

                    this.users_table_loading = false;
                }, error => {
                    alert(error);
                    this.users_table_loading = false;
                });
            },

            fetchBalance() {
                var self = this;

                axios.get(this.$root.api + 'accounts/' +  this.account.id + '/banker/main?query=balance', this.$root.config).then( response => {
                    this.balance = response.data.data.balance;
                }, error => {
                    alert(error);
                });
            },

            fetchFlight() {
                var self = this;

                axios.get(this.$root.api + 'accounts/' +  this.account.id + '/banker/flight?query=balance', this.$root.config).then( response => {
                    self.flight = response.data.data.balance;
                }, error => {
                    alert(error);
                });
            },

            getFolders() {
                this.loading = true;
                var self = this;
                var folders = [];
                axios.get(this.$root.api + 'creatives/' +  this.account.id + '/folders', this.$root.config).then(response => {
                    this.folders = response.data.data;
                    folders = response.data.data;
                    
                    this.loading = false;
                }, error => {
                    alert(error);
                });
                var creatives = [];
                for (var f in folders) {
                    axios.get(this.$root.api + 'creatives/' +  this.account.id + '/folders/' + folders[f].id, this.$root.config).then(response => {
                    var a = response.data;
                    creatives.push(a);
                    
                    this.loading = false;
                }, error => {
                    alert(error);
                });
                }
                this.creatives = creatives;
            },

            getCreatives() {
                var self = this;
                var folders = this.folders;
                var creatives = [];
                
                for (var f in folders) {
                    axios.get(this.$root.api + 'creatives/' +  this.account.id + '/folders/' + folders[f].id, this.$root.config).then(response => {
                        var a = response.data.data;
                        for (var i in a) {
                            creatives.push(a[i]);
                        }
                }, error => {
                    alert(error);
                });
                }
                this.creatives_table_loading = false;
                this.creatives = creatives;
            },

            toggleApproval(id, status) {
                var toggleBag = {
                    approved: 'declined',
                    declined: 'approved',
                    pending: 'approved'
                };
                this.creatives_table_loading = true;
                axios.put(this.$root.api + 'creatives/' + id, {status: toggleBag[status]}, this.$root.config).then(response => {
                    this.getCreatives();
                }, error => {
                    console.log(error);
                });
            },

            fetchAccount() {
                var self = this;

                axios.get(this.$root.api + 'accounts/' + this.account_id, this.$root.config).then( response => {
                    this.account = response.data.data;
                    this.loading = false;
                }, error => {
                    console.log(error);
                });
            },

            fetchCampaigns() {
                this.campaigns_table_loading = true;
                var self = this;
                axios.get(this.$root.api + 'accounts/' +  this.account.id + '/campaigns', this.$root.config).then( response => {
                    this.campaigns = response.data.data;
                    this.campaigns_table_loading = false;
                }, error => {
                    this.campaigns_table_loading = false;
                });
            },

            deleteCampaign(id) {

                axios.delete(this.$root.api + 'campaigns/' + id, this.$root.config).then( response => {
                    alert('succesful deletion');
                    location.reload();
                }, error => {
                    console.log(error);
                });
            },

            deleteUser(id) {
                this.buttonLoading('delete',true, id);

                axios.delete(
                    this.$root.api + 'accounts/' +  this.account.id + '/users/' + id, 
                    this.$root.config
                ).then(response => {
                        this.fetchUsers();
                        this.buttonLoading('delete', false, id);
                    }, error => {
                        this.fetchUsers();
                        this.buttonLoading('delete', false, id);
                    }
                );
            },

            toggleUserStatus(status, id) {
                this.buttonLoading('toggle', true, id);
                var status = status ? 0 : 1; 

                axios.put(
                    this.$root.api + 'accounts/' +  this.account.id + '/users/' + id, 
                    { status: status }, 
                    this.$root.config
                ).then(response => {
                        this.buttonLoading('toggle', false, id);
                        this.fetchUsers();
                    }, error => {
                        this.buttonLoading('toggle', false, id);
                        this.fetchUsers();
                    }
                );
            },

            toggleStatus(id, status) {
                this.campaigns = [];
                
                    axios.put(this.$root.api + 'campaigns/' + id, {status: status}, this.$root.config).then(response => {
                        this.fetchCampaigns();
                    }, error => {
                    console.log(error);
                    });
            },

            openUsers(id) {
                axios.get(this.$root.api + 'accounts/' + id + '/users', this.$root.config).then( response => {
                    this.users = response.data;

                    $('#_modal-users').modal();

                }, error => {
                    alert(error);
                });
            },

            openSettings(id) {
                axios.get(this.$root.api + 'accounts/' + id, this.$root.config).then(response => {

                    this.account = response.data;
                    this.loading = false;

                    $('#_modal-edit-account').modal();
                }, error => {
                    console.log(error);
                });
            },

            openCreateUser() {
                $('#_modal-create-new-user').modal();
            },

            openJSON(json) {
                this.opened_json = json;
                $('#_modal-show-json').modal();
            },

            createNewUser() {
                this.users = [];
                this.users_table_loading = true;

                return axios.post(this.$root.api + 'accounts/' + this.account.id + '/users', this.new_user, this.$root.config).then(response => {

                    this.fetchUsers();
                    this.closeModal();
                }, error => {
                    this.fetchUsers();
                    this.closeModal();
                });
            },

            closeModal() {
                $('#_modal-create-new-user').modal('close');
            },

            createChart() {
                var self = this; 
                var chart = [];
                for( var c = 0; c <= 2; c++) {
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

             getBalanceData(){
                var self = this;

                axios.get(this.$root.api + 'accounts/' +  this.account.id + '/banker/main?query=balance', this.$root.config).then( response => {
                    self.banker.main = response.data.data.balance
                }, error => {
                    console.log(error);
                });

                axios.get(this.$root.api + 'accounts/' +  this.account.id + '/banker/flight?query=balance', this.$root.config).then( response => {
                    self.banker.flight = response.data.data.balance
                }, error => {
                    console.log(error);
                });

                 axios.get(this.$root.api + 'accounts/' +  this.account.id + '/banker/spend?query=balance', this.$root.config).then( response => {
                    self.banker.spend = response.data.data.balance
                }, error => {
                    console.log(error);
                });
    
                var balance = ((self.banker.main + self.banker.flight)/1000000).toFixed(2)
                return {
                    "balance": balance,
                    "flight": self.banker.flight,
                    "spend": self.banker.spend
                }
            },

            emptyData() {
                var emptyData = []
                var time = new Date();
                var data = 0;
                for (var i = 40; i >= 0; i--) {
                    var d = {
                        "date" : time - (i * 5000),
                        "balance": data
                    }
                    emptyData.push(d)
                }
                return emptyData
            },

            generateUri(type, id) {

                var endpoint = '';

                switch(type) {

                    case 'campaigns':
                    endpoint += 'campaigns';
                    break;

                    case 'creatives':
                    endpoint += 'creatives/' + id;
                    break;
                }

                return endpoint;
            }
        },

        computed: {

            filterByUsers() {
                if (typeof this.users.data == 'undefined') return;

                var self = this;

                var results = this.users.data.filter( function(item) {

                    return item.first_name.toLowerCase().indexOf(self.searchUsers.toLowerCase()) > -1;
                });

                return results;
            }
        },

        watch: {
            token(value) {
                this.fetchAccount();
            },

            folders(value) {
                this.getCreatives();
            },
            account(value) {
                this.fetchUsers();
                this.fetchCampaigns();
                this.getFolders();
                this.fetchBalance();
                this.fetchFlight();
            }
        }
    }
</script>