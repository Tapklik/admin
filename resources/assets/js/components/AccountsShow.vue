<template>
    <div>
        <div>
            <div class="row">
                <div class="col-xs-12">
                    <h1 class="title">{{ account.name }}</h1>

                    <button class="btn btn-default pull-right" @click="openCreateAccount()">
                        <i class="fa fa-plus"></i> Create new user
                    </button>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-sm-5">
                    <table class="table">
                        <tr>
                            <td class="col-sm-3">
                                <b> Id: </b> 
                            </td>
                            <td class="col-sm-9">
                                <span class="muted">{{account.id}}</span>
                            </td>
                        </tr>
                        <br>
                        <tr>
                            <td class="col-sm-3">
                                <b>Status:</b> 
                            </td>
                            <td class="col-sm-9">
                                <span v-if="account.status === 1" class="label label-success">Active</span>
                                <span v-else class="label label-success">Active</span>
                            </td>
                        </tr>
                        <br>
                        <tr>
                            <td class="col-sm-3">
                                <b>Location:</b> 
                            </td>
                            <td class="col-sm-9">
                                <span>{{account.localization.country}} {{account.localization.city}}</span> <br>
                                <span>({{account.localization.timezone}})</span>
                            </td>
                        </tr>
                        <br>
                        <tr>
                            <td class="col-sm-3">
                                <b>Language</b>
                            </td>
                            <td class="col-sm-9">
                                <span>{{account.localization.language}}</span>
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="col-sm-7">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>
                                    Name
                                </th>
                                <th>
                                    Email
                                </th>
                                <th>
                                    Phone
                                </th>
                                <th>
                                    Status
                                </th>
                                <th>
                                    Delete User
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="user in users">
                                <td>
                                    {{ user.first_name }} {{ user.last_name }}
                                </td>
                                <td>
                                    {{ user.email }}
                                </td>
                                <td>
                                    {{ user.phone ? user.phone : 'N/A' }}
                                </td>
                                <td>
                                    <i class="fa fa-check" v-show="user.status == 1"></i>
                                    <i class="fa fa-ban" v-show="!user.status"></i>
                                </td>
                                <td>
                                    <button class="btn btn-danger" @click="deleteUser(user.id)">
                                        <i class="fa fa-check-circle-o"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <hr/>

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
                        <tr v-show="loading == true">
                            <td colspan="11" class="loader text-center">
                                <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
                            </td>
                        </tr>
                        <tr v-show="noresult">
                            <td colspan="11">
                                Sorry but theres nothing here... yet :)
                            </td>
                        </tr>
                        <tr v-for="campaign in campaigns">
                            <td>{{ campaign.id }}</td>
                            <td>
                                <a :href="'campaigns/' + campaign.id">
                                    {{ campaign.name }}
                                </a>
                            </td>
                            <td>{{ campaign.start_time }}</td>
                            <td>{{ campaign.end_time }}</td>
                            <td>
                                <a :href="adomain" v-for="adomain in campaign.adomain" target="_blank">
                                    {{ adomain }}
                                </a>
                            </td>
                            <td>
                                <a :href="campaign.ctrurl" target="_blank">
                                    link
                                </a>
                            </td>
                            <td>${{ $root.fromMicroDollars(campaign.budget.data.amount) }}</td>
                            <td>${{ $root.fromMicroDollars(campaign.bid) }}</td>
                            <td>
                                <a :href="generateUri('creatives', campaign.id)"  class="btn btn-primary">
                                    View
                                </a>
                            </td>
                            <td>
                                <a :href="generateUri('api', campaign.id)"  class="btn btn-primary" target="_blank">
                                    View
                                </a>
                            </td>
                            <td>
                                <button class="btn"
                                        :class="{ 'btn-success': campaign.status=='active', 'btn-danger': campaign.status=='stopped', 'btn': campaign.status=='archived' }"
                                        @click="toggleStatus(campaign.id , campaign.status)">
                                    <i class="fa fa-check-circle-o"></i>
                                </button>
                            </td>
                            <td>
                                <button class="btn btn-danger" @click="deleteCampaign(campaign.id)">
                                    <i class="fa fa-check-circle-o"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>

            <hr/>

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
            <tr v-show="loading == true">
                <td colspan="11" class="loader text-center">
                    <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
                </td>
            </tr>
            <tr v-show="noresult">
                <td colspan="11">
                    Sorry but theres nothing here... yet :)
                </td>
            </tr>

            <tr v-for="c in creatives">
                <td>{{ c.id }}</td>
                <td>
                    <a :href=" accountId + '/creatives/' + c.id">
                        {{ c.name }}
                    </a>
                </td>
                <td>{{ c.class }}</td>
                <td>{{ c.w }}x{{ c.h}}</td>
                <td> <img width="70px" :src="c.thumb"> </td>
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

            <hr/>

            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <h2>Budget</h2>
                    <span>Balance: ${{$root.twoDecimalPlaces($root.fromMicroDollars(balance.balance))}} </span>
                </div>
                <div class="col-xs-12 col-md-6">
                    <a class="btn btn-default pull-right" :href="accountId + '/billing'">Billing</a>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-4">
                    <div class="col-md-12 panel panel-default">
                        <h4>Balance </h4>
                        <div id="chartdiv" style="height: 300px;"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="col-md-12 panel panel-default">
                        <h4> In-Flight </h4>
                        <div id="chartdiv2" style="height: 300px;"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="col-md-12 panel panel-default">
                        <h4>Total Spend</h4>
                        <div id="chartdiv3" style="height: 300px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="_modal-create-new-user" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Create New User</h4>
                        </div>
                        <div class="modal-body">
                            <h5>DETAILS</h5>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-12 col-md-6">
                                        <label for="label-first-name">First Name</label>
                                        <br/>
                                        <input type="text" id="label-first-name" class="form-control" v-model="user.first_name"/>
                                    </div>
                                    <div class="col-xs-12 col-md-6">
                                        <label for="label-last-name">Last Name</label>
                                        <br/>
                                        <input type="text" id="label-last-name" class="form-control" v-model="user.last_name"/>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-xs-12 col-md-6">
                                            <label for="label-email">E-mail</label>
                                            <br/>
                                            <input type="text" class="form-control" id="label-email" v-model="user.email"/>
                                        </div>

                                        <div class="col-xs-12 col-md-6">
                                            <label for="label-phone-number">Phone number</label>
                                            <br/>
                                            <input type="text" class="form-control" id="label-phone-number" v-model="user.phone" />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <label for="label-password">Password</label>
                                            <br/>
                                            <input type="password" class="form-control" id="label-password" v-model="user.password"/>
                                        </div>
                                    </div>                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" @click="createNewUser()">Create</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            this.generateCharts();
            this.fetchCountries();
            this.fetchTimezones();
            this.fetchLanguages();
        },

        data() {

            return {
                balance: null,
                account: {
                    localization: {
                        
                    }
                },
                users: {},
                user: {
                    first_name: '',
                    last_name: '',
                    email: '',
                    phone: '',
                    password: ''
                },
                countriesList: {},
                timezonesList: {},
                languagesList: {},
                loading: false,
                noresult: false,
                token: false,
                balanceList: [],
                flightList:[],
                spendList:[],
                campaigns: [],
                folders:[],
                a: null,
                b: null,
                creatives: {},
                accountId: window.location.pathname.replace('\/accounts\/', '')
            }
        },

        methods: {

            consoleLog(message, mes) {
                console.log(message + mes);
            },

            fetchUsers() {
                this.loading = true;
                var self = this;
                var accountId = window.location.pathname.replace('\/accounts\/', '');

                axios.get(this.$root.api + 'accounts/' + accountId + '/users', this.$root.config).then( response => {
                    this.users = response.data.data;

                    this.loading = false;
                }, error => {
                    alert(error);
                });
            },

            fetchBalance() {
                this.loading = true;
                var self = this;
                var accountId = window.location.pathname.replace('\/accounts\/', '');

                axios.get(this.$root.api + 'accounts/' + accountId + '/banker/main?query=balance', this.$root.config).then( response => {
                    this.balance = response.data.data;

                    this.loading = false;
                }, error => {
                    alert(error);
                });
            },

            getFolders() {
                this.loading = true;
                var self = this;
                var accountId = window.location.pathname.replace('\/accounts\/', '');
                var folders = [];
                axios.get(this.$root.api + 'creatives/' + accountId + '/folders', this.$root.config).then(response => {
                    this.folders = response.data.data;
                    folders = response.data.data;
                    
                    this.loading = false;
                }, error => {
                    alert(error);
                });
                var creatives = [];
                for (var f in folders) {
                    axios.get(this.$root.api + 'creatives/' + accountId + '/folders/' + folders[f].id, this.$root.config).then(response => {
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
                this.loading = true;
                var self = this;
                var accountId = window.location.pathname.replace('\/accounts\/', '');
                var folders = this.folders;
                var creatives = [];
                
                for (var f in folders) {
                    axios.get(this.$root.api + 'creatives/' + accountId + '/folders/' + folders[f].id, this.$root.config).then(response => {
                        console.log(response.data.data);
                        var a = response.data.data;
                        for (var i in a) {
                            creatives.push(a[i]);
                        }
                        this.loading = false;
                }, error => {
                    alert(error);
                });
                }
                this.creatives = creatives;
            },

            toggleApproval(id, status) {
                var toggleBag = {
                    approved: 'declined',
                    declined: 'approved',
                    pending: 'approved'
                };

                axios.put(this.$root.api + 'creatives/' + id, {status: toggleBag[status]}, this.$root.config).then(response => {
                    this.getCreatives();
                }, error => {
                    console.log(error);
                });
            },

            fetchAccount() {

                this.loading = true;
                var self = this;
                var accountId = window.location.pathname.replace('\/accounts\/', '');

                axios.get(this.$root.api + 'accounts/' + accountId, this.$root.config).then( response => {
                    this.account = response.data.data;

                    this.loading = false;
                }, error => {
                    console.log(error);
                });
            },

            fetchCampaigns() {

                this.loading = true;
                var self = this;
                var accountId = window.location.pathname.replace('\/accounts\/', '');

                axios.get(this.$root.api + 'accounts/' + accountId + '/campaigns', this.$root.config).then( response => {
                    this.campaigns = response.data.data;

                    this.loading = false;
                }, error => {
                    console.log(error);
                });
            },

            fetchCountries() {

                axios.get('/data/countries').then( response => {
                    this.countriesList = response;
                }, error => {
                    console.log(error);
                });
            },

            fetchTimezones() {

                axios.get('/data/timezones').then( response => {
                    this.timezonesList = response;
                }, error => {
                    console.log(error);
                });
            },

            fetchLanguages() {

                axios.get('/data/languages').then( response => {
                    this.languagesList = response;
                }, error => {
                    console.log(error);
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

                var accountId = window.location.pathname.replace('\/accounts\/', '');

                axios.delete(this.$root.api + 'accounts/' + accountId + '/users/' + id, this.$root.config).then(response => {
                    alert('succesful deletion');
                    location.reload();
                }, error => {
                    console.log(error);
                });
            },


            toggleStatus(id, status) {

               if (status == 'active') {
                
                    axios.put(this.$root.api + 'campaigns/' + id, {status: 'stopped'}, this.$root.config).then(response => {
                    alert('success');
                    }, error => {
                    console.log(error);
                    });
                }
                else if(status == 'stopped') {
                    axios.put(this.$root.api + 'campaigns/' + id, {status: 'archived'}, this.$root.config).then(response => {
                    alert('success');
                    location.reload();
                    }, error => {
                    console.log(error);
                    });
                }
                else {
                    axios.put(this.$root.api + 'campaigns/' + id, {status: 'active'}, this.$root.config).then(response => {
                    alert('success');
                    location.reload();
                    }, error => {
                    console.log(error);
                    });
                }
            },

            openUsers(id) {

                this.loading = true;

                axios.get(this.$root.api + 'accounts/' + id + '/users', this.$root.config).then( response => {

                    this.loading = false;

                    this.users = response.data;

                    $('#_modal-users').modal();

                }, error => {
                    alert(error);
                });
            },

            openSettings(id) {

                this.loading = true;

                axios.get(this.$root.api + 'accounts/' + id, this.$root.config).then(response => {

                    this.account = response.data;
                    this.loading = false;

                    $('#_modal-edit-account').modal();
                }, error => {
                    console.log(error);
                });
            },

            openCreateAccount() {
                $('#_modal-create-new-user').modal();
            },

            createNewUser: function () {
                this.loading = true;

                return axios.post(this.$root.api + 'accounts/' + this.account.id + '/users', this.user, this.$root.config).then(response => {

                    this.fetchUsers();
                    this.loading = false;
                    this.account = false;
                    this.closeModal();
                }, error => {

                    this.loading = false;
                    this.closeModal();
                });
            },

            closeModal() {
                $('#_modal-create-new-user').modal('close');
            },

            createChart(target, dataset) {

                var chart = AmCharts.makeChart( target, {
                  "type": "serial",
                  "theme": "light",
                  "zoomOutButton": {
                    "backgroundColor": '#000000',
                    "backgroundAlpha": 0.15
                },
                "dataProvider": dataset,
                "categoryField": "date",
                "categoryAxis": {
                    "parseDates": true,
                    "minPeriod": "ss",
                    "dashLength": 1,
                    "gridAlpha": 0.15,
                    "axisColor": "#DADADA"
                },
                "graphs": [ {
                    "id": "g1",
                    "valueField": "balance",
                    "bullet": "round",
                    "bulletBorderColor": "#FFFFFF",
                    "bulletBorderThickness": 2,
                    "lineThickness": 2,
                    "lineColor": "#b5030d",
                    "negativeLineColor": "#0352b5",
                    "hideBulletsCount": 50
                } ]
            } )

            },

            generateCharts() {
                var self = this

                setInterval(function(){
                    self.getBalanceData();
                    self.getFlightData();
                    self.getSpendData();
                    self.createChart('chartdiv', self.balanceList)
                    self.createChart('chartdiv2', self.flightList)
                    self.createChart('chartdiv3', self.spendList)
                }, 10000); 
            },

            getBalanceData(){

                var self = this;
                var time = new Date()
                var main = 'main'

                var accountId = window.location.pathname.replace('\/accounts\/', '');

                axios.get('http://api.tapklik.com/v1/accounts/' + accountId + '/banker/main?query=balance', this.$root.config).then( response => {
                    self.a = response.data.data.balance
                }, error => {
                    console.log(error);
                });

                axios.get('http://api.tapklik.com/v1/accounts/' + accountId + '/banker/flight?query=balance', this.$root.config).then( response => {
                    self.b = response.data.data.balance
                }, error => {
                    console.log(error);
                });
                console.log(self.a)
                console.log(self.b)
                var c = ((self.a + self.b)/1000000).toFixed(2)


                if (self.balanceList.length >= 30) {
                    self.balanceList.splice(0,1)
                }
                self.balanceList.push({
                    "date": time,
                    "balance": c
                }) 


            },

            getFlightData() {
                var self = this;
                var time = new Date()
                var flight = 'flight'

                var accountId = window.location.pathname.replace('\/accounts\/', '');

                axios.get('http://api.tapklik.com/v1/accounts/' + accountId + '/banker/flight?query=balance', this.$root.config).then( response => {
                    if (self.flightList.length >= 30) {
                        self.flightList.splice(0,1)
                    }
                    self.flightList.push({
                        "date": time,
                        "balance": (response.data.data.balance/1000000).toFixed(2)
                    })
                }, error => {
                    console.log(error);
                });
            },

            getSpendData() {
                var self = this;
                var time = new Date()
                var spend = 'spend'

                var accountId = window.location.pathname.replace('\/accounts\/', '');

                axios.get('http://api.tapklik.com/v1/accounts/' + accountId + '/banker/spend?query=balance', this.$root.config).then( response => {
                    if (self.spendList.length >= 30) {
                        self.spendList.splice(0,1)
                    }
                    self.spendList.push({
                        "date": time,
                        "balance": (response.data.data.balance/1000000).toFixed(2)
                    })
                }, error => {
                    console.log(error);
                });
            },

            generateUri(type, id) {

                var endpoint = '';

                switch(type) {

                    case 'campaigns':
                    endpoint += 'campaigns';
                    break;

                    case 'creatives':
                    endpoint += 'creatives';
                    break;
                }

                return '/accounts/' + id + '/' + endpoint;
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
                this.fetchUsers();
                this.fetchCampaigns();
                this.getFolders();
                this.fetchBalance();
            
            },

            folders(value) {
                this.getCreatives();
            }
        }
    }
</script>
