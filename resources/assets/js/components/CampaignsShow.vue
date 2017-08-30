<template>
    <div>
        <div>
            <div class="row">
                <div class="col-xs-12">
                    <h1 class="title">{{ campaign.name }}</h1>
                    
                    <button class="btn btn-default pull-right">
                        <i class="fa fa-plus"></i> Edit this Campaign
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
                                <span class="muted">{{campaign.id}}</span>
                            </td>
                        </tr>
                        <br>
                        <tr>
                            <td class="col-sm-3">
                                <b>Status:</b> 
                            </td>
                            <td class="col-sm-9">
                                <button class="btn"
                                :class="{ 'btn-success': campaign.status=='active', 'btn-danger': campaign.status=='stopped', 'btn': campaign.status == 'archived'}"
                                :data-status="campaign.status"
                                @click="toggleStatus(campaign.id, campaign.status)">
                                <i class="fa fa-check-circle-o"></i>
                            </button>
                        </td>
                    </tr>
                    <br>
                    <tr>
                        <td class="col-sm-3">
                            <b>Bid:</b> 
                        </td>
                        <td class="col-sm-9">
                            <span>{{$root.fromMicroDollars(campaign.bid)}}</span>
                        </td>
                    </tr>
                    <br>
                    <tr>
                        <td class="col-sm-3">
                            <b>Budget: </b>
                        </td>
                        <td class="col-sm-9">
                            <span> {{$root.fromMicroDollars(campaign.budget.data.amount)}} / {{campaign.budget.data.type}} </span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <hr/>

        <div class="row">
            <div class="col-xs-12">
                <h2>Budget</h2>
            </div>
        </div>
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
                campaign: {
                    budget: {
                        data: {

                        }
                    }
                },
                loading: false,
                token: false,
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
                a: null,
                b: null
            }
        },

        methods: {


            fetchCampaign() {

                this.loading = true;
                var self = this;
                var campaignId = window.location.pathname.replace('\/campaigns\/', '');

                axios.get(self.$root.api + 'campaigns/' + campaignId, this.$root.config).then( response => {
                    self.campaign = response.data.data;

                    self.loading = false;
                }, error => {
                    console.log(error);
                });
            },

            consoleLog(message, mes) {
                console.log(message + mes);
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
                }, error => {
                    console.log(error);
                });
            },

            deleteUser(id) {

                var accountId = window.location.pathname.replace('\/campaigns\/', '');

                axios.delete(this.$root.api + 'accounts/' + accountId + '/users/' + id, this.$root.config).then(response => {
                    alert('succesful deletion');
                }, error => {
                    console.log(error);
                });
            },


            toggleStatus(id, status) {

               if (status == 'active') {
                status=='stopped'
                    axios.put(this.$root.api + 'campaigns/' + id, {status: 'stopped'}, this.$root.config).then(response => {
                    alert('success');
                    }, error => {
                        status=='active'
                    });
                }
                else if(status == 'stopped') {
                    axios.put(this.$root.api + 'campaigns/' + id, {status: 'archived'}, this.$root.config).then(response => {
                    alert('success')
                    }, error => {
                    console.log(error);
                    });
                }
                else {
                    axios.put(this.$root.api + 'campaigns/' + id, {status: 'active'}, this.$root.config).then(response => {
                    alert('success')
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

                var accountId = window.location.pathname.replace('\/campaigns\/', '');

                axios.get('http://api.tapklik.com/v1/campaigns/' + accountId + '/banker/main?query=balance', this.$root.config).then( response => {
                    self.a = response.data.data.balance
                }, error => {
                    console.log(error);
                });

                axios.get('http://api.tapklik.com/v1/campaigns/' + accountId + '/banker/flight?query=balance', this.$root.config).then( response => {
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

                var accountId = window.location.pathname.replace('\/campaigns\/', '');

                axios.get('http://api.tapklik.com/v1/campaigns/' + accountId + '/banker/flight?query=balance', this.$root.config).then( response => {
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

                var accountId = window.location.pathname.replace('\/campaigns\/', '');

                axios.get('http://api.tapklik.com/v1/campaigns/' + accountId + '/banker/spend?query=balance', this.$root.config).then( response => {
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

        watch: {
            token(value) {
                this.fetchCampaign();
            }
        }
    }
</script>


