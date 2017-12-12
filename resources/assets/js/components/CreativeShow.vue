<template>
    <div>
        <div class="row">
            <div class="col-md-8">
                <h1 class="title pull-left">Edit</h1>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-xs-2"></div>
            <div class="col-xs-2">
                Actions
            </div>
        </div>
        <div class="row">
            <div class="col-xs-2">
                <select class="form-control" id="label-approved" @change="editCreativeStatus()" v-model="creative.approved">
                    <option value="approved">Approved</option>
                    <option value="pending">Pending</option>
                    <option value="declined">Declined</option>
                </select>
            </div> 
            <div class="col-xs-2">
                <button class="btn btn-default">get</button>
                <button class="btn btn-default">else</button>
                <button class="btn btn-default">here</button>
            </div>              
            <div class="col-xs-3">
                <button class="btn btn-default">Preview</button>
                <a :href="creative.iurl"><button class="btn btn-default">Download</button></a>
            </div>               
        </div>
        <hr />     
        <div class="form-group">
            <div class="row">
                <div class="col-xs-8">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                <label for="label-city">Name</label>
                                <br/>
                                <input type="text" class="form-control" id="label-city" v-model="creative.name" />
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <label for="label-approved">Class</label>
                                <br/>
                                <select class="form-control" id="label-approved" v-model="creative.class">
                                    <option value="banner">Banner</option>
                                    <option value="video">Video</option>
                                    <option value="native">Native</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-12 col-md-3">
                                <label for="label-approved">Width</label>
                                <br/>
                                <input type="text" class="form-control" id="label-city" v-model="creative.w"/>
                            </div>
                            <div class="col-xs-12 col-md-3">
                                <label for="label-approved">Height</label>
                                <br/>
                                <input type="text" class="form-control" id="label-city" v-model="creative.h"/>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <div class="row">
                                    <label for="label-approved"></label><br />
                                    <input type="checkbox" v-model="creative.responsive" style="margin-left: 20px;" /> Responsive
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-12 col-md-12">
                                <label for="label-approved">Attributes</label>
                                <br/>
                                <select class="form-control" multiple id="label-approved" v-model="creative.attr.data">
                                    <option v-for="attribute in attributes" :value="attribute.value">{{attribute.description}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-4" style="margin-top: 20px;">
                    <div :style="'background-image: url('+creative.iurl+'); width: 100%; background-size: cover;'">
                        <img :src="creative.iurl" width="100%" style="visibility: hidden">
                    </div><br />
                    <div class="form-group">
                        <button class="btn btn-default" style="float: right;" @click="editCreative()">Edit</button>
                    </div>
                </div>
            </div>   
        </div>
        <hr/> 
        <div class="row">
            <div class="col-xs-8">
                <div class="form-group">
                    <div class="row">
                        <div class="col-xs-12">
                            <label for="label-city">CTR URL</label>
                            <br/>
                            <input type="text" class="form-control" id="label-city" v-model="creative.ctrurl" />
                        </div>
                        <div class="col-xs-12">
                            <label for="label-city">Tag #1</label>
                            <br/>
                            <input type="text" class="form-control" id="label-city" v-model="tags[0]" />
                        </div>
                        <div class="col-xs-12">
                            <label for="label-city">Tag #2</label>
                            <br/>
                            <input type="text" class="form-control" id="label-city" v-model="tags[1]" />
                        </div>
                        <div class="col-xs-12">
                            <label for="label-city">Tag #3</label>
                            <br/>
                            <input type="text" class="form-control" id="label-city" v-model="tags[2]" />
                        </div>
                        <div class="col-xs-12">
                            <label for="label-city">Tag #4</label>
                            <br/>
                            <input type="text" class="form-control" id="label-city" v-model="tags[3]" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr />
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
                <tr v-for="campaign in campaigns">
                    <td>{{ campaign.id }}</td>
                    <td>
                        <a :href="accountId + '/campaigns/' + campaign.id">
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
                        <a :href="'/accounts/'+ accountId +'/campaigns/'+campaign.id+'/creatives'"  class="btn btn-primary">
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
    </div>
</template>

<script>
    export default {
        mounted() {
            this.getIds();
        },

        data() {

            return {
                campaigns: [],
                selection: 'js',
                creativeId: 0,
                accountId: 0,
                creative: {
                    attr: {
                        data: []
                    }
                },
                loading: false,
                noresult: false,
                token: this.token,
                tags: ['','','',''],
                attributes: [],
                countries: []
            }
        },

        methods: {

            fetchCountries() {

                axios.get('/data/countries').then(response => {
                    this.countriesList = response;
                }, error => {
                    console.log(error);
                });
            },

            fetchAttributes() {
                axios.get('/data/attributes').then(response => {
                    this.attributes = response.data;
                }, error => {
                    alert(error);
                });
            },

            getFilledTags() {
                var tags = this.tags;
                return tags.filter(t => t !== '')
            },

            splitCtrurl() {
                var url = this.creative.ctrurl;
                var splitCtrurl = url.split("?");
                this.creative.ctrurl = splitCtrurl[0];
                for(var i = 1; i < splitCtrurl.length; i++) {
                    this.tags[i-1] = splitCtrurl[i]; 
                }
            },

            fetchCampaigns() {

                this.loading = true;
                var self = this;

                axios.get(this.$root.api + 'accounts/' +  this.accountId + '/campaigns', this.$root.config).then( response => {
                    var self = this;
                    var campaigns = response.data.data;
                    this.campaigns = campaigns.filter(c => 
                        c.creatives.data.map(cr => cr.id).indexOf(self.creativeId) !== -1
                    );
                    this.loading = false;
                }, error => {
                    console.log(error);
                });
            },

            getIds() {
                var idDraft = window.location.pathname;
                var res = idDraft.split("/");
                this.creativeId = res[4];
                this.accountId = res[2];
            },

            fetchCreative() {
                axios.get(this.$root.api + 'creatives/' + this.creativeId, this.$root.config).then(response => {
                    this.creative = response.data.data;
                    this.loading = false;
                }, error => {
                    alert(error);
                });
            },

            collectCreative() {
                return {
                    class: this.creative.class,
                    h: this.creative.h,
                    w: this.creative.w,
                    status: this.creative.approved,
                    name: this.creative.name,
                    responsive: this.creative.responsive,
                    ctrurl: this.creative.ctrurl + '?' + this.getFilledTags().join("?"),
                    thumb: this.creative.thumb,
                    folder_id: this.creative.folder.key
                }
            },

            editCreative() {
                axios.put(this.$root.api + 'creatives/' + this.creativeId, this.collectCreative(), this.$root.config).then(response => {
                    this.editAttributes();
                }, error => {
                    alert(error);
                });
            },

            editAttributes() {
                axios.put(this.$root.api + 'creatives/' + this.creativeId + '/attr', {attr: this.creative.attr.data}, this.$root.config).then(response => {
                    this.fetchCreative();
                    window.location.pathname = 'accounts/' + this.accountId;
                }, error => {
                    alert(error);
                });
            },

            editCreativeStatus() {
                axios.put(this.$root.api + 'creatives/' + this.creativeId, {status: this.creative.approved}, this.$root.config).then(response => {
                }, error => {
                    alert(error);
                });
            }
        },

        computed: {
        },

        watch: {
            token(value) {
                this.fetchCreative();
                this.fetchCampaigns();
                this.fetchAttributes();
                this.fetchCountries();
            },
            creative(value) {
                this.splitCtrurl();
            }
        }
    }

</script>
