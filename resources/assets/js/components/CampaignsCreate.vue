<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <h1 class="title pull-left">New Campaign</h1>

                <button class="btn btn-primary pull-right" @click="createCampaign()">
                    CREATE
                </button>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-md-12">
                <legend class="clearfix" @click="currentOpenSection = 1">
                    1. Information

                    <button class="btn btn-primary pull-right">
                        Update Information
                    </button>
                </legend>
            </div>
        </div>

        <br>


        <form id="section-info">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group" v-show="currentOpenSection == 1">
                        <div class="col-md-3">
                            <label>Name</label>
                            <input class="form-control" v-model="campaign.name"/>
                        </div>
                        <div class="col-md-3">

                            <div class="col-md-6">
                                <label>From</label>
                                <tk-datepicker :date="campaign.start_time"></tk-datepicker>
                            </div>
                            <div class="col-md-6">
                                <label>To</label>
                                <tk-datepicker :date="campaign.end_time"></tk-datepicker>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label>Advertiser Domain</label>
                            <input class="form-control" v-model="campaign.adomain" />
                        </div>
                        <div class="col-md-3">
                            <label>CTR Url</label>
                            <input class="form-control" v-model="campaign.ctrurl" />
                        </div>
                    </div>
                </div>
            </div>

            <br/>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group" v-show="currentOpenSection == 1">
                        <div class="col-md-3">
                            <label>Daily Budget</label>
                            <input class="form-control" v-model="campaign.budget.data.total" :name="total" />
                        </div>
                        <div class="col-md-3">
                            <label>Bid</label>
                            <input class="form-control" v-model="campaign.bid" name="bid" />
                        </div>
                        <div class="col-md-3">
                            <label>Max Bid (CPM)</label>
                            <input class="form-control" v-model="campaign.bidmax" name="bidmax" />
                        </div>
                        <div class="col-md-3">

                            <div class="col-md-6">
                                <label>Daily Budget Pacing</label>
                                <button class="btn btn-tapklik btn-block disabled" disabled>Set</button>
                            </div>
                            <div class="col-md-6">
                                <label>JSON Output</label>
                                <button class="btn btn-tapklik btn-block" @click="openJson(campaign)" onclick="return false;">View</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <br/>
        <div class="row">
            <div class="col-md-12">
                <legend class="clearfix" @click="currentOpenSection = 2">
                    2. Categories

                    <button class="btn btn-primary pull-right">
                        Update Categories
                    </button>
                </legend>

                <div class="form-group" v-show="currentOpenSection == 2">
                    <div class="col-xs-12 col-md-2" v-for="category in categories">
                        <label>
                            <input type="checkbox" :value="category" v-model="campaign.cat.data"/>
                            {{ category }}
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <br/>
        <div class="row">
            <div class="col-md-12">
                <legend @click="currentOpenSection = 3">
                    3. Targeting

                    <button class="btn btn-primary pull-right">
                        Update Targeting
                    </button>
                </legend>
                <div class="form-group" v-show="currentOpenSection == 3">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-5">
                                <label>Geo Country</label> <br />
                                <form>
                                    <div class="typeahead__container">
                                        <div class="typeahead__field">
                                            <span class="typeahead__query">
                                                <input class="js-typeahead-input"
                                                       name="q"
                                                       type="search"
                                                       id="_search-countries"
                                                       placeholder="Type a country..."
                                                       autofocus
                                                       autocomplete="off" v-model="tempCountry">
                                            </span>
                                        </div>
                                    </div>
                                </form>

                            </div>
                            <div class="col-md-5">
                                <label>Geo City</label>
                                <input type="test" class="form-control" placeholder="Type a city..." id="_search-cities" v-model="tempGeoHolder.city">
                            </div>
                            <div class="col-md-2">
                                <label>&nbsp; </label>
                                <button class="btn btn-primary" @click="addGeoItem()">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>

                            <div class="row clearfix">
                                <div class="col-xs-12 col-md-4 text-center">
                                    <span id="_geo_data"/>
                                </div>
                            </div>
                        </div>

                        <ul class="list-unstyled">
                            <li v-for="(geo, index) in campaign.geo.data" class="col-md-3">
                                <a @click="removeCountry(index)" class="label label-default">
                                    <i class="fa fa-minus"></i>
                                    {{ geo.country }} - {{ geo.city }}
                                </a>
                            </li>
                        </ul>
                        </div>

                    <div class="col-md-6">

                        <div class="col-md-6">
                            <label>Audience</label>

                            <p class="clearfix"></p>

                            <label class="pull-left">
                                <input type="checkbox" :value="'m'" v-model="chosenGender" />
                                Male
                            </label>
                            <label class="pull-left">
                                <input type="checkbox" :value="'f'" v-model="chosenGender" />
                                Female
                            </label>
                        </div>

                        <div class="col-md-6">
                            <label>Ages</label>

                            <p class="clearfix"></p>

                            <ul class="list-inline">
                                <li v-for="group in demographyGroups">
                                    <label>
                                        <input type="checkbox" :value="group" v-model="chosenDemography"/>
                                        {{ group }}
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <br/>
        <div class="row">
            <div class="col-md-12">
                <legend class="clearfix" @click="currentOpenSection = 4">
                    4. Admin

                    <button class="btn btn-primary pull-right">
                        Update Admin
                    </button>
                </legend>
                <div class="form-group" v-show="currentOpenSection == 4">
                    <div class="col-md-2">
                        <label>Test</label> <br/>
                        <select class="form-control">
                            <option value="true">TRUE</option>
                            <option value="false" selected>FALSE</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label>Status</label> <br/>
                        <select class="form-control" v-model="campaign.status">
                            <option :value="'running'">Running</option>
                            <option :value="'stopped'" :selected="'selected'">Stopped</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Weight</label> <br/>
                                <input class="form-control" v-model="campaign.weight"/>
                            </div>
                            <div class="col-md-6">
                                <label>Exchange</label> <br/>
                                <input class="form-control" v-model="campaign.exchange"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label>Account</label> <br/>
                        <select class="form-control" v-model="campaign.account_id">
                            <option v-for="account in accounts" :value="account.id" >{{ account.name }}</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label>Node</label> <br/>
                        <input class="form-control" v-model="campaign.node"/>
                    </div>
                    <div class="col-md-2">
                        <label>Pacing</label> <br/>
                        <select class="form-control">
                            <option value="true">Enabled</option>
                            <option value="false" selected>Disabled</option>
                        </select>
                    </div>
                </div>

                <p class="clearfix"></p>

                <div class="form-group" v-show="currentOpenSection == 4">
                    <div class="col-xs-12">
                        <label>Hours Of Week</label>
                        <p class="clearfix"></p>

                        <div class="col-md-4">
                            <label>Mon</label>
                            <ul class="list-unstyled">
                                <li v-for="(i, key) in mon">
                                    <label>
                                        <input type="checkbox" :value="key" :checked="campaign.hourofweek.data[i]" v-model="campaign.hourofweek.data" />
                                        {{ i }}
                                    </label>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <label>Tue</label>
                            <ul class="list-unstyled">
                                <li v-for="(i, key) in tue">
                                    <label>
                                        <input type="checkbox" :value="key" :checked="campaign.hourofweek.data[i]" v-model="campaign.hourofweek.data" />
                                        {{ i }}
                                    </label>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <label>Wed</label>
                            <ul class="list-unstyled">
                                <li v-for="(i, key) in wed">
                                    <label>
                                        <input type="checkbox" :value="key" :checked="campaign.hourofweek.data[i]" v-model="campaign.hourofweek.data" />
                                        {{ i }}
                                    </label>
                                </li>
                            </ul>
                        </div>

                        <hr/>

                        <div class="col-md-4">
                            <label>Thu</label>
                            <ul class="list-unstyled">
                                <li v-for="(i, key) in thu">
                                    <label>
                                        <input type="checkbox" :value="key" :checked="campaign.hourofweek.data[i]" v-model="campaign.hourofweek.data" />
                                        {{ i }}
                                    </label>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <label>Fri</label>
                            <ul class="list-unstyled">
                                <li v-for="(i, key) in fri">
                                    <label>
                                        <input type="checkbox" :value="key" :checked="campaign.hourofweek.data[i]" v-model="campaign.hourofweek.data" />
                                        {{ i }}
                                    </label>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <label>Sat</label>
                            <ul class="list-unstyled">
                                <li v-for="(i, key) in sat">
                                    <label>
                                        <input type="checkbox" :value="key" :checked="campaign.hourofweek.data[i]" v-model="campaign.hourofweek.data" />
                                        {{ i }}
                                    </label>
                                </li>
                            </ul>
                        </div>

                        <hr/>

                        <div class="col-md-4">
                            <label>Sun</label>
                            <ul class="list-unstyled">
                                <li v-for="(i, key) in sun">
                                    <label>
                                        <input type="checkbox" :value="key" :checked="campaign.hourofweek.data[i]" v-model="campaign.hourofweek.data" />
                                        {{ i }}
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            this.init();
            this.fetchCategories();
            this.fetchCountries();
            this.fetchAccounts();
        },

        data() {

            return {
                currentOpenSection: 1,
                campaign: {
                    name: '',
                    adomain: '',
                    ctrurl: '',
                    bid: 0,
                    bidmax: 0,
                    weight: 1,
                    exchange: 1,
                    node: '',
                    account_id: 1,
                    status: '',
                    start_time: {
                        time: ''
                    },
                    end_time: {
                        time: ''
                    },
                    cat: {
                        data: []
                    },
                    geo: {
                        data: []
                    },
                    hourofweek: {
                        data: [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41, 42,43,44,45,46,
47,48, 49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72, 73,74,75,76,77,78,79,80,81,82,83,84, 85,86,87,88,89,
90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,
125,126,127,128,129,130,131,132,133,134,135,136,137,138,139,140,141,142,143,144,145,146,147,148,149,150,160,161,162,163, 164,165,166,
167,168,169,170,171,172,173,174,175,176]
                    },
                    budget: {
                        data: {
                            total: 0,
                            daily: {
                                total: 0,
                                spend: 0
                            }
                        }
                    },
                },
                categories: false,
                countries: false,
                accounts: false,
                tempExchange: '',
                tempGeoHolder: {
                    country: '',
                    city: ''
                },
                tempDeviceHolder: {
                    'type_id': '',
                    'make': '',
                    'model': '',
                    'os': '',
                    'ua': '',
                },
                demographyGroupsData: [
                    {key: 2, group: '1-11', gender: 'm'},
                    {key: 3, group: '12-18', gender: 'm'},
                    {key: 4, group: '19-25', gender: 'm'},
                    {key: 5, group: '26-39', gender: 'm'},
                    {key: 6, group: '40-55', gender: 'm'},
                    {key: 7, group: '56-64', gender: 'm'},
                    {key: 8, group: '65-120', gender: 'm'},
                    {key: 10, group: '1-11', gender: 'f'},
                    {key: 11, group: '12-18', gender: 'f'},
                    {key: 12, group: '19-25', gender: 'f'},
                    {key: 13, group: '26-39', gender: 'f'},
                    {key: 14, group: '40-55', gender: 'f'},
                    {key: 15, group: '56-64', gender: 'f'},
                    {key: 16, group: '65-120', gender: 'f'},
                ],
                demographyGroups: ['1-11','12-18','19-25','26-39','40-55','56-64','65-120'],
                chosenDemography: [],
                chosenGender: [],
                mon: {1:1,2:2,3:3,4:4, 5:5, 6:6, 7:7, 8:8, 9:9, 10:10, 11:11, 12:12, 13:13, 14:14, 15:15, 16:16, 17:17, 18:18, 19:19, 20:20, 21:21, 22:22, 23:23, 24:24},
                tue: {25:1,26:2,27:3,28:4,29:5,30:6,31:7,32:8,33:9,34:10,35:11,36:12,37:13,38:14,39:15,40:16,41:17,42:18,43:19,44:20,45:21,46:22,47:23,48:24},
                wed: {49:1,50:2,51:3,52:4,53:5,54:6,55:7,56:8,57:9,58:10,59:11,60:12,61:13,62:14,63:15,64:16,65:17,66:18,67:19,68:20,69:21,70:22,71:23,72:24},
                thu: {73:1,74:2,75:3,76:4,77:5,78:6,79:7,80:8,81:9,82:10,83:11,84:12,85:13,86:14,87:15,88:16,89:17,90:18,91:19,92:20,93:21,94:22,95:23,96:24},
                fri: {97:1,98:2,99:3,100:4,101:5,102:6,103:7,104:8,105:9,106:10,107:11,108:12,109:13,110:14,111:15,112:16,113:17,114:18,115:19,116:20,117:21,118:22,119:23,120:24},
                sat: {121:1,122:2,123:3,124:4,125:5,126:6,127:7,128:8,129:9,130:10,131:11,132:12,133:13,134:14,135:15,136:16,137:17,138:18,139:19,140:20,141:21,142:22,143:23,144:24},
                sun: {145:1,146:2,147:3,148:4,149:5,150:6,151:7,152:8,153:9,154:10,155:11,156:12,157:13,158:14,159:15,160:16,161:17,162:18,163:19,164:20,165:21,166:22,167:23,168:24},
            }
        },

        methods: {
            init() {
                var self = this;
                $(function () {
                    $.typeahead({
                        input: '#_search-countries',
                        order: "desc",
                        source: {
                            data: [
                                "Afghanistan", "Albania", "Algeria", "Andorra", "Angola", "Antigua and Barbuda",
                                "Argentina", "Armenia", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh",
                                "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia",
                                "Bosnia and Herzegovina", "Botswana", "Brazil", "Brunei", "Bulgaria", "Burkina Faso", "Burma",
                                "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Central African Republic", "Chad",
                                "Chile", "China", "Colombia", "Comoros", "Congo, Democratic Republic", "Congo, Republic of the",
                                "Costa Rica", "Cote d'Ivoire", "Croatia", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti",
                                "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador",
                                "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Fiji", "Finland", "France", "Gabon",
                                "Gambia", "Georgia", "Germany", "Ghana", "Greece", "Greenland", "Grenada", "Guatemala", "Guinea",
                                "Guinea-Bissau", "Guyana", "Haiti", "Honduras", "Hong Kong", "Hungary", "Iceland", "India",
                                "Indonesia", "Iran", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan",
                                "Kazakhstan", "Kenya", "Kiribati", "Korea, North", "Korea, South", "Kuwait", "Kyrgyzstan", "Laos",
                                "Latvia", "Lebanon", "Lesotho", "Liberia", "Libya", "Liechtenstein", "Lithuania", "Luxembourg",
                                "Macedonia", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands",
                                "Mauritania", "Mauritius", "Mexico", "Micronesia", "Moldova", "Mongolia", "Morocco", "Monaco",
                                "Mozambique", "Namibia", "Nauru", "Nepal", "Netherlands", "New Zealand", "Nicaragua", "Niger",
                                "Nigeria", "Norway", "Oman", "Pakistan", "Panama", "Papua New Guinea", "Paraguay", "Peru",
                                "Philippines", "Poland", "Portugal", "Qatar", "Romania", "Russia", "Rwanda", "Samoa", "San Marino",
                                "Sao Tome", "Saudi Arabia", "Senegal", "Serbia and Montenegro", "Seychelles", "Sierra Leone",
                                "Singapore", "Slovakia", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "Spain",
                                "Sri Lanka", "Sudan", "Suriname", "Swaziland", "Sweden", "Switzerland", "Syria", "Taiwan",
                                "Tajikistan", "Tanzania", "Thailand", "Togo", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey",
                                "Turkmenistan", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States",
                                "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Yemen", "Zambia", "Zimbabwe"
                            ]
                        },
                        callback: {
                            onInit: function (node) {
                            },
                            onClick(node, el, data) {
                                self.tempGeoHolder.country = data.display.toLowerCase();
                            }
                        }
                    });
                });
            },

            createCampaign() {

                axios.post(this.$root.api + 'campaigns', this.campaign, this.$root.config).then(response => {
                    swal('Great Successs', 'Campaign created successfully', 'success');
                    console.log(response);
                }, error => {
                    console.log(error);
                });
            },

            fetchCategories() {

                axios.get('/data/categories').then( response => {
                    this.categories = response.body;
                }, error => {
                    console.log(error);
                });
            },

            fetchCountries() {
                axios.get('/data/countries').then( response => {
                    this.countries = response.data;
                }, error => {
                    console.log(error);
                });
            },

            fetchAccounts() {
                axios.get(this.$root.api + 'accounts', this.$root.config).then( response => {
                    this.accounts = response.data.data;
                }, error => {
                    console.log(error);
                });
            },

            addGeoItem() {
                var chosenCountry = $('#_search-countries').val();
                var self = this;

                axios.get('/search/geography/country?q=' + chosenCountry).then(response => {
                     var data = {
                        country: response.data.data.iso3,
                        city: $('#_search-cities').val(),
                    };

                    self.campaign.geo.data.push(data);
                }, error => {
                    console.log(error);
                });
            },

            openJson: function () {

                $('#_modal_json .modal-body .jsonify').html(JSON.stringify(this.campaign));
                $('.jsonify').jsonFormatter();
                $('#_modal_json').modal();
                return false;
            },

            addCountry() {
                this.campaign.geo.data.push(this.tempGeoHolder);
                this.tempGeoHolder = {};
            },

            removeCountry: function (index) {

                this.campaign.geo.data.splice(index, 1);
            }
        }
    }

</script>
