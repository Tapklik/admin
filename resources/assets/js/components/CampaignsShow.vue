<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <h1 class="title pull-left">Campaign {{ campaign.name }}</h1>

                <button class="btn btn-primary pull-right" @click="updateCampaign(campaign.id)">
                    UPDATE
                </button>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-md-12">
                <legend class="clearfix" @click="changeSetion(1)">
                    1. Information

                    <button class="btn btn-primary pull-right">
                        Information Section
                    </button>
                </legend>
            </div>
        </div>

        <br>

        <form id="section-info">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group" v-show="openSection == 1">
                        <div class="col-md-3">
                            <label>Name</label>
                            <input class="form-control" v-model="campaignPayload.name" :value="campaign.name"/>
                        </div>
                        <div class="col-md-3">

                            <div class="col-md-6">
                                <label>From</label>
                                <tk-datepicker :date="campaignPayload.start_time"></tk-datepicker>
                            </div>
                            <div class="col-md-6">
                                <label>To</label>
                                <tk-datepicker :date="campaignPayload.end_time"></tk-datepicker>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label>Advertiser Domain</label>
                            <input class="form-control" :value="transformAdomain" v-model="tempAdomain" />
                        </div>
                        <div class="col-md-3">
                            <label>CTR Url</label>
                            <input class="form-control" v-model="campaignPayload.ctrurl" :value="campaign.ctrurl"/>
                        </div>
                    </div>
                </div>
            </div>

            <br/>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group" v-show="openSection == 1">
                        <div class="col-md-3">
                            <label>Daily Budget</label>
                            <input class="form-control" v-model="campaignPayload.budget.data.total" :name="total" />
                        </div>
                        <div class="col-md-3">
                            <label>Bid</label>
                            <input class="form-control" v-model="campaignPayload.bid" :name="bid" />
                        </div>
                        <div class="col-md-3">
                            <label>Max Bid (CPM)</label>
                            <input class="form-control" v-model="campaignPayload.bidmax" name="bidmax" />
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
                <legend class="clearfix" @click="changeSetion(2)">
                    2. Categories

                    <button class="btn btn-primary pull-right">
                        Categories Sections
                    </button>
                </legend>

                <div class="form-group" v-show="openSection == 2">
                    <div class="col-xs-12 col-md-2" v-for="category in categories">
                        <label>
                            <input type="checkbox" :value="category" v-model="campaignPayload.cat.data"/>
                            {{ category }}
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <br/>
        <div class="row">
            <div class="col-md-12">
                <legend @click="changeSetion(3)">
                    3. Targeting

                    <button class="btn btn-primary pull-right">
                        Targeting Section
                    </button>
                </legend>
                <div class="form-group" v-show="openSection == 3">
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
                                                       autocomplete="off">
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

                    <div class="row">
                        <p>&nbsp;</p>
                    </div>

                    <div class="form-group">
                        <div class="col-md-3">
                            <label>Make</label>
                            <input type="text" placeholder="Make" class="form-control" />
                        </div>
                        <div class="col-md-2">
                            <label>Model</label>
                            <input type="text" placeholder="Model" class="form-control" />
                        </div>
                        <div class="col-md-2">
                            <label>Operating System</label>
                            <input type="text" placeholder="Os" class="form-control" />
                        </div>
                        <div class="col-md-3">
                            <label>User Agent</label>
                            <input type="text" placeholder="UA" class="form-control" />
                        </div>

                        <div class="col-md-2">
                            <label>&nbsp;</label>
                            <a class="btn btn-primary">
                                <i class="fa fa-plus"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <br/>
        <div class="row">
            <div class="col-md-12">
                <legend class="clearfix" @click="changeSetion(4)">
                    4. Admin

                    <button class="btn btn-primary pull-right">
                        Admin Section
                    </button>
                </legend>
                <div class="form-group" v-show="openSection == 4">
                    <div class="col-md-2">
                        <label>Test</label> <br/>
                        <select class="form-control" v-model="campaignPayload.test">
                            <option>true</option>
                            <option>false</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label>Status</label> <br/>
                        <select class="form-control" v-model="campaignPayload.status">
                            <option>running</option>
                            <option>stopped</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label>Weight</label> <br/>
                        <input class="form-control" v-model="campaignPayload.weight"/>
                    </div>
                    <div class="col-md-2">
                        <label>Exchange</label> <br/>
                        <input class="form-control" :value="transformExchange" v-model="tempExchange" />
                    </div>
                    <div class="col-md-2">
                        <label>Node</label> <br/>
                        <input class="form-control" v-model="campaignPayload.node"/>
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

                <div class="form-group" v-show="openSection == 4">
                    <div class="col-xs-12">
                        <label>Hours Of Week</label>
                        <p class="clearfix"></p>

                        <div class="col-md-4">
                            <label>Mon</label>
                            <ul class="list-unstyled">
                                <li v-for="(i, key) in mon">
                                    <label>
                                        <input type="checkbox" :value="key" :checked="campaignPayload.hourofweek.data[i]" v-model="campaignPayload.hourofweek.data" />
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
                                        <input type="checkbox" :value="key" :checked="campaignPayload.hourofweek.data[i]" v-model="campaignPayload.hourofweek.data" />
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
                                        <input type="checkbox" :value="key" :checked="campaignPayload.hourofweek.data[i]" v-model="campaignPayload.hourofweek.data" />
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
                                        <input type="checkbox" :value="key" :checked="campaignPayload.hourofweek.data[i]" v-model="campaignPayload.hourofweek.data" />
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
                                        <input type="checkbox" :value="key" :checked="campaignPayload.hourofweek.data[i]" v-model="campaignPayload.hourofweek.data" />
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
                                        <input type="checkbox" :value="key" :checked="campaignPayload.hourofweek.data[i]" v-model="campaignPayload.hourofweek.data" />
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
                                        <input type="checkbox" :value="key" :checked="campaignPayload.hourofweek.data[i]" v-model="campaignPayload.hourofweek.data" />
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
            this.fetchCampaign();
            this.fetchCategories();
            this.fetchCountries();
        },

        data() {

            return {
                campaign: {
                    name: '',
                    adomain: '',
                    ctrurl: '',
                    bid: 0,
                    bidmax: 0,
                    weight: 0,
                    exchange: '',
                    node: '',
                    start_time: '',
                    end_time: '',
                    cat: {
                        data: []
                    },
                    geo: {
                        data: [{}]
                    },
                    hourofweek: {
                        data: []
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
                campaignPayload: {
                    name: '',
                    adomain: '',
                    ctrurl: '',
                    bid: 0,
                    bidmax: 0,
                    weight: 0,
                    exchange: '',
                    node: '',
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
                        data: [{}]
                    },
                    hourofweek: {
                        data: []
                    },
                    budget: {
                        data: {
                            total: 0,
                            daily: {
                                total: 0,
                                spend: 0
                            }
                        }
                    }
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
                categories: false,
                countries: false,
                cities: [],
                fullCityData: {},
                loading: false,
                noresult: false,
                showgeo: false,
                openSection: 1,
                tempAdomain: '',
                tempExchange: '',
                tempGeoHolder: {
                    country: '',
                    city: ''
                },
                mon: {1:1,2:2,3:3,4: 4,5: 5,6: 6,7: 7,8: 8,9: 9,10:10,11:11,12:12,13:13,14:14,15:15,16:16,17:17,18:18,19:19,20:20,21:21,22:22,23:23,24:24},
                tue: {25:1,26:2,27:3,28:4,29:5,30:6,31:7,32:8,33:9,34:10,35:11,36:12,37:13,38:14,39:15,40:16,41:17,42:18,43:19,44:20,45:21,46:22,47:23,48:24},
                wed: {49:1,50:2,51:3,52:4,53:5,54:6,55:7,56:8,57:9,58:10,59:11,60:12,61:13,62:14,63:15,64:16,65:17,66:18,67:19,68:20,69:21,70:22,71:23,72:24},
                thu: {73:1,74:2,75:3,76:4,77:5,78:6,79:7,80:8,81:9,82:10,83:11,84:12,84:13,85:14,86:15,87:16,88:17,89:18,90:19,91:20,92:21,93:22,94:23,95:24},
                fri: {96:1,97:2,98:3,99:4,100:5,101:6,102:7,103:8,104:9,105:10,106:11,107:12,108:13,109:14,110:15,111:16,112:17,113:18,114:19,115:20,116:21,117:22,118:23,119:24},
                sat: {120:1,121:2,122:3,123:4,124:5,125:6,126:7,127:8,128:9,129:10,130:11,131:12,132:13,133:14,134:15,135:16,136:17,137:18,138:19,139:20,140:21,141:22,142:23,143:24},
                sun: {144:1,145:2,146:3,147:4,148:5,149:6,150:7,160:8,161:9,162:10,163:11,164:12,165:13,166:14,167:15,168:16,169:17,170:18,171:19,172:20,173:21,174:22,175:23,176:24},
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

            updateCampaign: function (id) {

                var self = this;

                this.campaignPayload['account_id'] = 1;
                this.campaignPayload['demography'] = {gender: self.chosenGender, group: self.chosenDemography};

                // Implode back the data
                this.campaignPayload['adomain'] = this.tempAdomain.split(',');
                this.campaignPayload['exchange'] = this.tempExchange.split(',');

                this.$http.put(this.$root.api + 'campaigns/' + obj.id, this.campaignPayload).then( response => {
                    self.campaign.data = response.data;
                    console.log(self.campaign.data);

                    swal('Success', 'Made it... all good... phewww', 'success');
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

            changeSetion: function (section) {
                this.openSection = section;
            },

            addGeoItem() {
                var self = this;

                this.$http.put(this.$root.api + 'campaigns/' + obj.id + '/geography', {country: self.tempGeoHolder.country, city: self.tempGeoHolder.city}).then(response => {
                console.log(response);

                    var data = {
                        country: response.data.country,
                        region: response.data.region,
                        region_name: response.data.region_name,
                        city: response.data.city,
                    };

                    self.campaignPayload.geo.data.push(data);
                    self.tempGeoHolder = {country: '',city: ''};
                    $('#_search-countries').val('');
                }, error => {
                    swal('Ooops', error.message, 'error');
                });
            },

            fetchCampaign() {

                this.loading = true;

                this.$http.get(this.$root.api + 'campaigns/' + obj.id).then( response => {
                    var campaignData = response.data.data;

                    this.campaign = response.data.data;

                    campaignData['start_time'] = {time:  this.campaign.start_time};
                    campaignData['end_time'] = {time:  this.campaign.end_time};
                    this.campaignPayload = campaignData;

                    this.loading = false;
                }, error => {
                    console.log(error);
                });
            },

            fetchCategories: function () {

                this.$http.get('/data/categories').then( response => {
                    this.categories = response.data;
                }, error => {
                    console.log(error);
                });
            },

            fetchCountries: function () {
                this.$http.get('/data/countries').then( response => {
                    this.countries = response.data;
                }, error => {
                    console.log(error);
                });
            },

            removeCountry: function (index) {

                this.campaign.geo.data.splice(index, 1);
            }
        },

        computed: {


            transformAdomain() {
                var items = '';

                for (var item in this.campaign.adomain) {

                        items += this.campaign.adomain[item] + ',';
                }

                if (this.campaign.adomain.length == 1) {
                    items = items.substring(0, items.length - 1);
                }

                this.tempAdomain = items;

                return items;
            },

            transformExchange() {
                var items = '';

                for (var item in this.campaign.exchange) {

                        items += this.campaign.exchange[item] + ',';
                }

                if (this.campaign.exchange.length == 1) {
                    items = items.substring(0, items.length - 1);
                }

                this.tempExchange = items;
                return items;
            }
        }
    }
</script>
