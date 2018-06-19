<template>
    <div>
        <div class="row" style="padding-left: 16px; padding-right: 16px;">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row" style="display: flex; align-items: center;">
                        <div class="col-xs-4">
                            Details
                        </div>
                        <div class="col-xs-8">
                            <button 
                            class="btn btn-primary pull-right" 
                            @click="updateCampaign()"
                            >
                                Edit
                            </button>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-12 col-md-6">
                                    <label for="label-city">Name</label>
                                    <br/>
                                    <input 
                                    type="text" 
                                    class="form-control" 
                                    id="label-city" 
                                    v-model="campaign.name" 
                                    />
                                </div>
                                <div class="col-xs-12 col-md-6">
                                    <label for="label-city">Click-Through URL</label>
                                    <br/>
                                    <input 
                                    type="text" 
                                    class="form-control" 
                                    id="label-city" 
                                    v-model="campaign.ctrurl"
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-12 col-md-6">
                                    <label for="label-city">Advertiser Domain</label>
                                    <br/>
                                    <input 
                                    type="text" 
                                    class="form-control" 
                                    id="label-city" 
                                    v-model="campaign.adomain" 
                                    />
                                </div>
                                <div class="col-xs-12 col-md-6">
                                    <label for="label-city">Budget Type</label>
                                    <br/>
                                    <select 
                                    class="form-control" 
                                    v-model="campaign.budget.data.type"
                                    >
                                        <option value="daily">Daily</option>
                                        <option value="campaign">Campaign</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-12 col-md-6">
                                    <label for="label-city">Date From</label>
                                    <br/>
                                    <input 
                                    type="text" 
                                    class="form-control" 
                                    id="label-city" 
                                    v-model="campaign.start_time" 
                                    />
                                </div>
                                <div class="col-xs-12 col-md-6">
                                    <label for="label-city">Date To</label>
                                    <br/>
                                    <input 
                                    type="text" 
                                    class="form-control" 
                                    id="label-city" 
                                    v-model="campaign.end_time"
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-12 col-md-6">
                                    <label for="label-city">Budget</label>
                                    <br/>
                                    <input 
                                    type="text" 
                                    class="form-control" 
                                    id="label-city" 
                                    v-model="campaign_budget" 
                                    />
                                </div>
                                <div class="col-xs-12 col-md-6">
                                    <label for="label-city">Bid</label>
                                    <br/>
                                    <input 
                                    type="text" 
                                    class="form-control" 
                                    id="label-city" 
                                    v-model="campaign_bid"
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-12 col-md-6">
                                    <label for="label-city">Pacing</label>
                                    <br/>
                                    <input 
                                    type="text" 
                                    class="form-control" 
                                    id="label-city" 
                                    v-model="campaign.budget.data.pacing" 
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr />

        <div class="row" style="padding-left: 16px; padding-right: 16px;">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row" style="display: flex; align-items: center;">
                        <div class="col-xs-4">
                            Categories
                        </div>
                        <div class="col-xs-8">
                            <button 
                            class="btn btn-primary pull-right" 
                            @click="updateCampaign()"
                            >
                                Edit
                            </button>
                        </div>
                    </div>                    
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-12 col-md-12">
                                    <label for="label-city">Selected Categories</label>
                                    <br/>
                                    <div v-for="category in lists.categories">
                                        <div class="col-xs-12 col-md-3">
                                            <input 
                                            type="checkbox" 
                                            :value="category.code" 
                                            v-model="campaign.cat.data"
                                            >
                                            <a 
                                            class="btn btn-link" 
                                            data-toggle="collapse" 
                                            :href="'#' + category.code" 
                                            role="button" 
                                            aria-expanded="false"
                                            :aria-controls="category.code"
                                            >
                                                {{ category.type }}
                                            </a>
                                        </div>
                                    </div>
                                    <div v-for="category in lists.categories">
                                        <div class="collapse" :id="category.code">
                                            <div class="well col-xs-12">
                                                <div v-for="subcategory in category.sub" class="col-xs-3">
                                                    <input type="checkbox" :value="subcategory.code" v-model="campaign.cat.data">
                                                    {{subcategory.type}} ({{subcategory.code}})
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr />

        <div class="row" style="padding-left: 16px; padding-right: 16px;">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row" style="display: flex; align-items: center;">
                        <div class="col-xs-4">
                            Creatives
                        </div>
                        <div class="col-xs-8">
                            <button 
                            class="btn btn-primary pull-right" 
                            @click="updateCampaign()"
                            >
                                Edit
                            </button>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-12 col-md-12">
                                    <label for="label-city">Selected Creatives</label>
                                    <br/>
                                    <div v-for="creative in lists.creatives" class="col-xs-12 col-md-4">
                                        <input 
                                        type="checkbox" 
                                        :value="creative" 
                                        v-model="campaign.creatives.data"
                                        >
                                        <span>
                                            <b> {{creative.name}} </b>({{creative.id}})
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr />

        <div class="row" style="padding-left: 16px; padding-right: 16px;">
            <div class="panel panel-default">
                <div class="panel-heading">                    
                    <div class="row" style="display: flex; align-items: center;">
                        <div class="col-xs-4">
                            Targetting
                        </div>
                        <div class="col-xs-8">
                            <button 
                            class="btn btn-primary pull-right" 
                            @click="updateCampaign()"
                            >
                                Edit
                            </button>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-12 col-md-4">
                                    <label for="label-city">Devices</label>
                                    <br/>
                                    <div v-for="type in lists.types">
                                        <input 
                                        type="checkbox" 
                                        :value="type.device_id" 
                                        v-model="campaign.device.data.type"
                                        >
                                        {{type.type}}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-4">
                                    <label for="label-city">Browsers</label>
                                    <br/>
                                    <div v-for="u in lists.ua">
                                        <input 
                                        type="checkbox" 
                                        :value="u.device_id" 
                                        v-model="campaign.device.data.ua"
                                        >
                                        {{u.type}}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-4">
                                    <label for="label-city">Operating Systems</label>
                                    <br/>
                                    <div v-for="o in lists.os">
                                        <input 
                                        type="checkbox" 
                                        :value="o.device_id" 
                                        v-model="campaign.device.data.os"
                                        >
                                        {{o.type}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr />
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="title pull-left">User</h4>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-12 col-md-3">
                                    <label for="label-city">Age Group - From:</label>
                                    <br/>
                                    <select 
                                    class="form-control" 
                                    v-model="campaign.user.data.age.min"
                                    >
                                        <option v-for="age in lists.ages" :value="age">{{age}}</option>
                                    </select>
                                </div>
                                <div class="col-xs-12 col-md-3">
                                    <label for="label-city">To: </label>
                                    <br/>
                                    <select 
                                    class="form-control" 
                                    v-model="campaign.user.data.age.max"
                                    >
                                        <option v-for="age in lists.ages" :value="age">{{age}}</option>
                                    </select>
                                </div>
                                <div class="col-xs-12 col-md-3">
                                    <label for="label-city">Gender</label>
                                    <br/>
                                        <input type="checkbox" value="M" v-model="campaign.user.data.gender"> M
                                        <input type="checkbox" value="F" v-model="campaign.user.data.gender"> F 
                                </div>
                            </div>
                        </div>
                        <hr />
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="title pull-left">Geo</h4>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-3">
                                    <input 
                                    type="text"
                                    @keyup.enter="reloadGeo()"
                                    class="form-control"
                                    v-model="search_geo"
                                    >
                                </div>
                                <button class="btn btn-primary" @click="reloadGeo()">Search Geo</button> 
                            </div>
                            <br />
                            <div v-for="g in lists.geo" class="col-xs-12">
                                <input 
                                type="checkbox" 
                                :value="g" 
                                v-model="campaign.geo.data"
                                />
                                {{g}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br> <br><br><br>
    </div>
</template>

<script>
    export default {
        data() {

            return {
                //ESSENTIALS
                token: this.token,
                campaign_id: '',
                account_id: '',
                
                lists: {
                    categories: [],
                    types: [],
                    ua: [],
                    os: [],
                    folders: [],
                    creatives: [],
                    gender: ['M', 'F'],
                    geo: [],
                    ages: [1, 12, 18, 26, 40, 55, 65, 120]

                },
                campaign_button_loading: false,
                updates_counter: 0,

                //CAMPAIGN
                search_geo: '',
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
                }
            }
        },

        methods: {
            //CAMPAIGN LISTS
            getLists() {
                this.getIds();
                this.getCategories();
                this.getTechnologies();
                this.getFolders();
            },

            getIds() {
                var idDraft = window.location.pathname;
                var res = idDraft.split("/");

                this.campaign_id = res[4];
                this.account_id = res[2];
            },

            getCategories() {
                axios.get(
                    '/data/categories.json'
                ).then(response => {
                        this.lists.categories = response.data;
                    }, error => {

                    }
                );
            },

            getTechnologies() {
                axios.get(
                    '/data/technologies.json'
                ).then(response => {
                        this.lists.types = response.data.devices; 
                        this.lists.ua = response.data.browsers;
                        this.lists.os = response.data.operatingsystems;
                    }, error => {

                    }
                );
            },

            getFolders() {
                axios.get(
                    this.$root.api + '/creatives/' + this.account_id + '/folders', 
                    this.$root.config
                ).then(response => {
                        this.lists.folders = response.data.data;
                        this.getCreatives();
                    }, error => {
                        alert(error);
                    }
                );
            },

            getCreatives() {
                var folders = this.lists.folders;

                for (var folder in folders) {
                    axios.get(
                        this.$root.api + '/creatives/' + this.account_id + '/folders/' + folders[folder].id, 
                        this.$root.config
                    ).then(response => {
                            this.lists.creatives.push(response.data.data);
                            this.lists.creatives = [].concat.apply([], this.lists.creatives);
                        }, error => {

                        }
                    );
                }
            },

            getGeo() {
                axios.get(
                    this.$root.api + '/core/search/geo?key=' + this.search_geo, 
                    this.$root.config
                ).then(response => {
                        this.lists.geo = response.data.data;
                    }, error => {
                        this.$root.showAlertPopUp('error', 'Something went wrong');
                    }
                );
            },

            reloadGeo() {
                if(!this.search_geo || this.search_geo.length < 3) this.geo = this.campaign.geo.data;
                else this.getGeo();
            },

            //CAMPAIGN
            getCampaign() {
                axios.get(
                    this.$root.api + '/campaigns/' + this.campaign_id, 
                    this.$root.config
                ).then(response => {
                        this.campaign = response.data.data;
                        this.lists.geo = this.campaign.geo.data;
                    }, error => {

                    }
                );
            },

            collectCampaign() {
                var status = this.campaign.status == 'draft' ? 'active' : this.campaign.status;
                
                return {
                    name: this.campaign.name,
                    description: '',
                    start: this.campaign.start_time,
                    end: this.campaign.end_time,
                    bid: this.campaign.bid,
                    ctrurl: this.campaign.ctrurl,
                    adomain: this.campaign.adomain,
                    test: this.campaign.test,
                    status: status,
                    weight: this.campaign.weight,
                    node: this.campaign.node
                };
            },

            collectCategories() {
                return this.campaign.cat.data;
            },

            collectUser() {
                return this.campaign.user.data;
            },

            collectGeography() {
                return this.campaign.geo.data.map(geo => geo.id);
            },

            collectDevices(key) {
                return {
                    types: this.campaign.device.data.type,
                    models: this.campaign.device.data.ua,
                    operating_systems: this.campaign.device.data.os,
                };
            },

            collectBudget() {
                return this.campaign.budget.data;
            },

            collectCreatives() {
                var ids = this.campaign.creatives.data.map(creative => creative.id);
                return ids;
            },

            updateCampaignPartly(method,extension, payload) {
                if(method=='put')
                    axios.put(
                        this.$root.api + '/campaigns/' + this.campaign.id + extension, 
                        payload, 
                        this.$root.config
                    ).then(response => {
                            this.updates_counter = this.updates_counter + 1;
                        }, error => {

                        }
                    );
                else if(method == 'post') {
                    axios.post(
                        this.$root.api + '/campaigns/' + this.campaign.id + extension, 
                        payload, 
                        this.$root.config
                    ).then(response => {
                            this.updates_counter = this.updates_counter + 1;
                        }, error => {
                    
                        }
                    );
                }
            },

            updateCampaign () {
                this.campaign_button_loading = true;
                this.updateCampaignPartly('put', '', this.collectCampaign());
                this.updateCampaignPartly('post', '/cat', this.collectCategories());
                this.updateCampaignPartly('post', '/users', this.collectUser());
                this.updateCampaignPartly('post', '/geo', {geo: this.collectGeography()});
                this.updateCampaignPartly('post', '/device/type', {types: this.collectDevices().types});
                this.updateCampaignPartly('post', '/device/model', {models: this.collectDevices().models});
                this.updateCampaignPartly('post', '/device/os', {os: this.collectDevices().operating_systems});
                this.updateCampaignPartly('post', '/budget', this.collectBudget());
                this.updateCampaignPartly('post', '/creatives', {creatives: this.collectCreatives()});
            }
        },

        computed: {
            campaign_budget: {
                get() {
                    return this.campaign.budget.data.amount / 1000000;
                },

                set(value) {
                    this.campaign.budget.data.amount = value * 1000000;
                }
            },
            campaign_bid: {
                get() {
                    return this.campaign.bid / 1000000;
                },

                set(value) {
                    this.campaign.bid = value * 1000000;
                }
            }
        },

        watch: {

            updates_counter(value) {
                if(value == 9) window.location.pathname = 'accounts/' + this.account_id;
            },

            token(value) {
                this.getLists();
                this.getCampaign();
            }
        }
    }
</script>


