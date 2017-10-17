<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <h2 class="title pull-left">Edit Campaign {{campaignId}}</h2>

                <button class="btn btn-primary pull-right" @click="updateCampaign()">
                    Edit
                </button>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-md-12">
                <h4 class="title pull-left">Details</h4>
            </div>
        </div>
        <hr/>
        <div class="form-group">
            <div class="form-group">
                <div class="row">
                    <div class="col-xs-12 col-md-6">
                        <label for="label-city">Name</label>
                        <br/>
                        <input type="text" class="form-control" id="label-city" v-model="campaign.name" />
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <label for="label-city">Click-Through URL</label>
                        <br/>
                        <input type="text" class="form-control" id="label-city" v-model="campaign.ctrurl"/>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-xs-12 col-md-6">
                        <label for="label-city">Advertiser Domain</label>
                        <br/>
                        <input type="text" class="form-control" id="label-city" v-model="campaign.adomain" />
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <label for="label-city">Budget Type</label>
                        <br/>
                        <input type="text" class="form-control" id="label-city" v-model="campaign.budget.data.type"/>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-xs-12 col-md-6">
                        <label for="label-city">Date From</label>
                        <br/>
                        <input type="text" class="form-control" id="label-city" v-model="campaign.start_time" />
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <label for="label-city">Date To</label>
                        <br/>
                        <input type="text" class="form-control" id="label-city" v-model="campaign.end_time"/>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-xs-12 col-md-6">
                        <label for="label-city">Budget</label>
                        <br/>
                        <input type="text" class="form-control" id="label-city" v-model="campaign.budget.data.amount" />
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <label for="label-city">Bid</label>
                        <br/>
                        <input type="text" class="form-control" id="label-city" v-model="campaign.bid"/>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-xs-12 col-md-6">
                        <label for="label-city">Pacing</label>
                        <br/>
                        <input type="text" class="form-control" id="label-city" v-model="campaign.budget.data.pacing" />
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <h4 class="title pull-left">Categories</h4>
            </div>
        </div>
        <hr/>
        <div class="form-group">
            <div class="form-group">
                <div class="row">
                    <div class="col-xs-12 col-md-12">
                        <label for="label-city">Selected Categories</label>
                        <br/>
                        <div v-for="c in categoriesList" class="col-xs-12 col-md-3">
                            <input type="checkbox" :value="c.code" v-model="campaign.cat.data">
                            {{c.type}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <h4 class="title pull-left">Creatives</h4>
            </div>
        </div>
        <hr/>
        <div class="form-group">
            <div class="form-group">
                <div class="row">
                    <div class="col-xs-12 col-md-12">
                        <label for="label-city">Selected Creatives</label>
                        <br/>
                        <div v-for="c in creatives" class="col-xs-12 col-md-4">
                            <input type="checkbox" :value="c" v-model="campaign.creatives.data">
                            {{c.id}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-md-12">
                <h4 class="title pull-left">Targetting</h4>
            </div>
        </div>
        <hr>
        <div class="form-group">
            <div class="form-group">
                <div class="row">
                    <div class="col-xs-12 col-md-12">
                        <label for="label-city">Devices</label>
                        <br/>
                        <div v-for="t in types" class="col-xs-12 col-md-4">
                            <input type="checkbox" :value="t.device_id" v-model="campaign.device.data.type">
                            {{t.type}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-xs-12 col-md-12">
                        <label for="label-city">Browsers</label>
                        <br/>
                        <div v-for="u in ua" class="col-xs-12 col-md-2">
                            <input type="checkbox" :value="u.device_id" v-model="campaign.device.data.ua">
                            {{u.type}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-xs-12 col-md-12">
                        <label for="label-city">Operating Systems</label>
                        <br/>
                        <div v-for="o in os" class="col-xs-12 col-md-2">
                            <input type="checkbox" :value="o.device_id" v-model="campaign.device.data.os">
                            {{o.type}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-xs-12 col-md-3">
                        <label for="label-city">Age Group</label>
                        <br/>
                        <input type="text" class="form-control" id="label-city" v-model="campaign.user.data.age.min" />
                    </div>
                    <div class="col-xs-12 col-md-3">
                        <label for="label-city"></label>
                        <br/>
                        <input type="text" class="form-control" id="label-city" v-model="campaign.user.data.age.max"/>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <label for="label-city">Gender</label>
                        <br/>
                        <div v-for="g in gender" class="col-xs-12 col-md-2">
                            <input type="checkbox" :value="g" v-model="campaign.user.data.gender">
                            {{g}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-xs-12 col-md-12">
                        <label for="label-city">Geo</label>
                        <br/>
                        <input type="text" @keyup="reloadGeo()" v-model="searchCountry">
                        <div v-for="g in geo" class="col-xs-12 col-md-2">
                            <input type="checkbox" :value="g" v-model="campaign.geo.data">
                            {{g}}
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
            this.fetchCategories();
            this.fetchTechnologies();
        },

        data() {

            return {
                campaignId: this.getCampaignId(),
                accountId: this.getAccountId(),
                creatives: [],
                folders: [],
                campaign: {
                    name: '',
                    adomain: '',
                    ctrurl: '',
                    bid: 0,
                    exchange: 1,
                    test: 1,
                    weight: 1,
                    status: '',
                    total: 1,
                    start_time: null,
                    end_time: null,
                    geo: {
                        data: []
                    },
                    cat: {
                        data: []
                    },
                    creatives: {
                        data: []
                    },

                    budget: {
                        data: {
                            amount: 0,
                            pacing: '',
                            type: '',
                        }
                    },
                    device: {
                        data: {
                            type: [],
                            make: [],
                            model: [],
                            os: [],
                            ua: [],
                        }
                    },
                    user: {
                        data: {
                            gender: [],
                            age: {
                                min: null,
                                max: null
                            }
                        }
                    }
                },
                loading: false,
                noresult: false,
                token: this.token,
                categoriesList: [],
                technologiesList: [],
                types: [],
                ua: [],
                os: [],
                gender: ['M','F'],
                searchCountry: '',
                geo: []

            }
        },

        methods: {

            updateCampaign () {
                this.ajax = true;

                this.updateCampaignDetails();
                this.updateCampaignCategories();
                this.updateCampaignUser();
                this.updateCampaignGeography();
                this.updateCampaignDevice();
                this.updateCampaignBudget();
                this.updateCampaignCreatives();
            },

            updateCampaignDetails(){
                

                var payload = this.collectCampaign();

                axios.put(this.$root.api + 'campaigns/' + this.campaign.id, payload, this.$root.config).then(response => {
                    
                    this.something = this.something + 1;

                }, error => {
                    this.alert = true;
                    this.error = true;
                    this.success = false;
                    this.alertMessage = 'Something went wrong';
                });
            },

            updateCampaignCategories(){

                var payload = this.collectCategories();

                axios.post(this.$root.api + 'campaigns/' + this.campaign.id + '/cat', payload, this.$root.config).then(response => {
                    
                    this.something = this.something + 1;
                }, error => {
                    this.alert = true;
                    this.error = true;
                    this.success = false;
                    this.alertMessage = 'Something went wrong';
                });
            },

            updateCampaignUser(){
                var payload = this.collectUser();

                axios.post(this.$root.api + 'campaigns/' + this.campaign.id + '/users', payload, this.$root.config).then(response => {
                    
                    this.something = this.something + 1;
                }, error => {
                    this.alert = true;
                    this.error = true;
                    this.success = false;
                    this.alertMessage = 'Something went wrong';
                });
            },

            updateCampaignGeography(){

                var payload = this.collectGeography();

                axios.post(this.$root.api + 'campaigns/' + this.campaign.id + '/geo', {geo: payload}, this.$root.config).then(response => {
                    
                    this.something = this.something + 1;
                }, error => {
                    this.alert = true;
                    this.error = true;
                    this.success = false;
                    this.alertMessage = 'Something went wrong';
                });
            },

            updateCampaignDevice(){

                var payload = this.collectDevices();

                axios.post(this.$root.api + 'campaigns/' + this.campaign.id + '/device/type', {types: payload.types}, this.$root.config).then(response => {
                    
                    this.something = this.something + 1;
                }, error => {
                    this.alert = true;
                    this.error = true;
                    this.success = false;
                    this.alertMessage = 'Something went wrong';
                });
                axios.post(this.$root.api + 'campaigns/' + this.campaign.id + '/device/model', {models: payload.models}, this.$root.config).then(response => {
                    
                    this.something = this.something + 1;
                }, error => {
                    this.alert = true;
                    this.error = true;
                    this.success = false;
                    this.alertMessage = 'Something went wrong';
                });
                axios.post(this.$root.api + 'campaigns/' + this.campaign.id + '/device/os', {os: payload.os}, this.$root.config).then(response => {
                    
                    this.something = this.something + 1;
                }, error => {
                    this.alert = true;
                    this.error = true;
                    this.success = false;
                    this.alertMessage = 'Something went wrong';
                });
            },

            updateCampaignBudget()
            {
                var payload = this.collectBudget();

                axios.post(this.$root.api + 'campaigns/' + this.campaign.id + '/budget', payload, this.$root.config).then(response => {
                    
                    this.something = this.something + 1;
                }, error => {
                    this.alert = true;
                    this.error = true;
                    this.success = false;
                    this.alertMessage = 'Something went wrong';
                });
            },

            updateCampaignCreatives() {

                var payload = this.collectCreatives();

                axios.post(this.$root.api + 'campaigns/' + this.campaign.id + '/creatives', {creatives: payload}, this.$root.config).then(response => {
                    
                    this.something = this.something + 1;
                }, error => {
                    this.alert = true;
                    this.error = true;
                    this.success = false;
                    this.alertMessage = 'Something went wrong';
                });
            },

            collectCampaign() {
                if (this.campaign.status == 'draft') {   
                    return {
                        name: this.campaign.name,
                        description: '',
                        start: this.campaign.start_time,
                        end: this.campaign.end_time,
                        bid: this.campaign.bid,
                        ctrurl: this.campaign.ctrurl,
                        adomain: this.campaign.adomain,
                        test: this.campaign.test,
                        status: 'active',
                        weight: this.campaign.weight,
                        node: this.campaign.node
                    };
                }
                else {

                return {
                    name: this.campaign.name,
                    description: '',
                    start: this.campaign.start_time,
                    end: this.campaign.end_time,
                    bid: this.campaign.bid,
                    ctrurl: this.campaign.ctrurl,
                    adomain: this.campaign.adomain,
                    test: this.campaign.test,
                    status: this.campaign.status,
                    weight: this.campaign.weight,
                    node: this.campaign.node
                };
                }
            },

            collectCategories() {
                return this.campaign.cat.data;
            },

            collectUser() {
                return this.campaign.user.data;
            },

            collectGeography() {
                return this.campaign.geo.data.map(function (geo) {
                    return geo.id;
                });
            },

            collectDevices() {
                return {
                    types: this.campaign.device.data.type,
                    models: this.campaign.device.data.ua,
                    os: this.campaign.device.data.os,
                };
            },

            collectBudget() {

                return this.campaign.budget.data;
            },

            collectCreatives() {

                var ids = [];

                for(var i in this.campaign.creatives.data)
                {
                    ids.push(this.campaign.creatives.data[i].id);
                }

                return ids;
            },

            reloadGeo() {
                var locations = this.campaign.geo.data;
                if(this.searchCountry.length >= 3){
                    axios.get(this.$root.api + 'core/search/geo?key=' + this.searchCountry, this.$root.config).then(response => {
                            this.geo = response.data.data;
                            for(var l in locations) {
                                this.geo.push(locations[l]);
                            }
                        }, error => {
                            this.alert = true;
                            this.error = true;
                            this.success = false;
                            this.alertMessage = 'Something went wrong';
                        }
                    )
                }
                
                else {
                  this.geo = locations;
                }
            },

            getCampaignId() {
                var idDraft = window.location.pathname.replace('\/accounts\/', '');
                var id = idDraft.slice((idDraft.length - 36),idDraft.length)
                return id;
            },

            getAccountId() {
                var idDraft = window.location.pathname.replace('\/accounts\/', '');
                var id = idDraft.slice(0,(idDraft.length - 47))
                return id;
            },

            fetchCampaign() {
                axios.get(this.$root.api + 'campaigns/' + this.campaignId, this.$root.config).then(response => {
                    this.campaign = response.data.data;
                    this.geo = this.campaign.geo.data;
                    
                    this.loading = false;
                }, error => {
                    alert(error);
                });
            },

            fetchCategories() {

                axios.get('/data/categories.json').then(response => {
                    this.categoriesList = response.data;
                }, error => {
                    console.log(error);
                });
            },

            fetchTechnologies() {

                axios.get('/data/technologies.json').then(response => {
                    this.technologiesList = response.data;
                }, error => {
                    console.log(error);
                });
            },

            getFolders() {
                this.loading = true;
                var self = this;
                var accountId = this.accountId;
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
                var accountId = this.accountId;
                var folders = this.folders;
                var creatives = [];
                
                for (var f in folders) {
                    axios.get(this.$root.api + 'creatives/' + accountId + '/folders/' + folders[f].id, this.$root.config).then(response => {
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



        },

        watch: {
            token(value) {
                this.fetchCampaign();
                this.getFolders();
            },
            
            folders(value) {
                this.getCreatives();
            },

            technologiesList(value) {
                this.types = value.devices; 
                this.ua = value.browsers;
                this.os = value.operatingsystems;
            },

        }
    }
</script>


