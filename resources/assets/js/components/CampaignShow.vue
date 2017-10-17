<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <h2 class="title pull-left">Edit Campaign {{campaignId}}</h2>

                <button class="btn btn-primary pull-right" @click="editCampaign()">
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
                            <input type="checkbox" :value="c" v-model="campaign.cat.data">
                            {{c}}
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
                            <input type="checkbox" :value="c" v-model="campaign.cat.data">
                            {{c}}
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
                categoriesList: []
            }
        },

        methods: {

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



        },

        watch: {
            token(value) {
                this.fetchCampaign();
                this.getFolders();
            },
            folders(value) {
                this.getCreatives();
            }
        }
    }
</script>


