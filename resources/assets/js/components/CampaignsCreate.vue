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
                        <div class="col-md-4">
                            <label>Daily Budget</label>
                            <input class="form-control" v-model="campaign.bid" name="bid" />
                        </div>
                        <div class="col-md-4">
                            <label>Max Bid (CPM)</label>
                            <input class="form-control" v-model="campaign.bidmax" name="bidmax" />
                        </div>
                        <div class="col-md-4">

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
                                <select class="form-control" placeholder="Type a country..." id="_search-countries">
                                    <option v-for="country in countries" :value="country.code">
                                        {{ country.name }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-5">
                                <label>Geo City</label>
                                <select class="form-control" placeholder="Type a city..." id="_search-cities">
                                    <option></option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label>&nbsp; </label>
                                <button class="btn btn-primary" @click="addCountry()">
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
                                <input type="checkbox"/>
                                Male
                            </label>
                            <label class="pull-left">
                                <input type="checkbox"/>
                                Female
                            </label>
                        </div>

                        <div class="col-md-6">
                            <label>Ages</label>

                            <p class="clearfix"></p>

                            <ul class="list-inline">
                                <li>
                                    <label>
                                        <input type="checkbox"/>
                                        1-11
                                    </label>
                                </li>
                                <li>
                                    <label>
                                        <input type="checkbox"/>
                                        12-18
                                    </label>
                                </li>
                                <li>
                                    <label>
                                        <input type="checkbox"/>
                                        19-25
                                    </label>
                                </li>
                                <li>
                                    <label>
                                        <input type="checkbox"/>
                                        26-39
                                    </label>
                                </li>
                                <li>
                                    <label>
                                        <input type="checkbox"/>
                                        40-55
                                    </label>
                                </li>
                                <li>
                                    <label>
                                        <input type="checkbox"/>
                                        56-64
                                    </label>
                                </li>
                                <li>
                                    <label>
                                        <input type="checkbox"/>
                                        65-120
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
                categories: false,
                countries: false,
                accounts: false,
                tempGeoHolder: false,
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

                $('#_search-countries').on('select2:select', function (evt) {

                    $.ajax({
                        url: '/data/countries/' + $('#_search-countries').val(),
                        success: function (response) {
                            var html = '';
                            $.each(response[0].cities, function () {
                                var item = this;
                                html += '<option value="' + item.id + '">' + item.name + '</option>';
                            });

                            $('#_search-cities').html(html);
                            $('#_search-cities').select2({
                                placeholder: 'Type a city'
                            });
                        }
                    });
                });

                var self = this;

                $('#_search-cities').on('select2:select', function (evt) {

                    $.ajax({
                        url: '/data/countries/' + $('#_search-countries').val() + '/' + $('#_search-cities').val(),
                        success: function (response) {

                            self.tempGeoHolder = {"city": response.city, "country": response.country, "region": response.region, "region_name": response.region_name};
                        }
                    });
                });
            },

            createCampaign() {

                this.$http.post(this.$root.api + 'campaigns', this.campaign).then(success => {
                    swal('Great Successs', 'Campaign created successfully', 'success');
                }, error => {
                    swal('Great Successs', error.response, 'error');
                });
            },

            fetchCategories() {

                this.$http.get('/data/categories').then( response => {
                    this.categories = response.body;
                }, error => {
                    console.log(error);
                });
            },

            fetchCountries() {
                this.$http.get('/data/countries').then( response => {
                    this.countries = response.data;
                }, error => {
                    console.log(error);
                });
            },

            fetchAccounts() {
                this.$http.get(this.$root.api + 'accounts').then( response => {
                    this.accounts = response.data.data;
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