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
                <button type="button" class="btn btn-default">
                    <span class="glyphicon glyphicon-print"></span>
                </button>
                <button type="button" class="btn btn-default">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
                <button type="button" class="btn btn-default">
                    <span class="glyphicon glyphicon-tags"></span>
                </button>
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
                <div class="col-xs-4">
                    <div class="well" style="margin-top: 50px">
                        <img style="display: block; margin:auto" :src="creative.thumb" />
                    </div>
                </div>
            </div>   
        </div>
        <hr />
        <div class="form-group">
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
                    <th>Name</th>
                    <th>CTR URL</th>
                    <th>Empty</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="vcenter">
                <tr v-for="campaign in campaigns">
                    <td>
                        {{ campaign.name }}
                    </td>
                    <td>
                        {{campaign.ctrurl}}
                    </a>
                    </td>
                    <td>
                    </td>
                    <td>
                        <a @click="openJSON('js', campaign.id)"  class="btn btn-primary" target="_blank">
                            JS
                        </a>
                        <a @click="openJSON('iframe', campaign.id)"  class="btn btn-primary" target="_blank">
                            iFrame
                        </a>
                        <a @click="openJSON(campaign)"  class="btn btn-primary" target="_blank">
                            View
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="modal fade" id="_modal-show-invocation" tabindex="-1" role="dialog">
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
                            {{selected_invocation_code_text}}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal" @click="createNewUser()">Create</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
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
                invocation_code: 'js',
                selected_invocation_code_text: '',
                creative_id: 0,
                account_id: 0,
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

            openJSON(invocation_code, campaign_id) {
                this.getSelectedInvocationCodeText(invocation_code, campaign_id)
                $('#_modal-show-invocation').modal();
            },

            getSelectedInvocationCodeText(invocation_code, campaign_id) {
                axios.get(this.$root.api + 'core/invocation', {attributes: this.creative.attr.data, campaign_id: campaign_id, creative_id: this.creative_id, type: invocation_code}, this.$root.config).then(response => {
                    this.selected_invocation_code_text = response;
                }, error=> {
                    alert(error);
                });
            },

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
                if(this.creative.ctrurl == null) return;
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

                axios.get(this.$root.api + 'accounts/' +  this.account_id + '/campaigns', this.$root.config).then( response => {
                    var self = this;
                    var campaigns = response.data.data;
                    this.campaigns = campaigns.filter(c => 
                        c.creatives.data.map(cr => cr.id).indexOf(self.creative_id) !== -1
                    );
                    this.loading = false;
                }, error => {
                    console.log(error);
                });
            },

            getIds() {
                var idDraft = window.location.pathname;
                var res = idDraft.split("/");
                this.creative_id = res[4];
                this.account_id = res[2];
            },

            fetchCreative() {
                axios.get(this.$root.api + 'creatives/' + this.creative_id, this.$root.config).then(response => {
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
                axios.put(this.$root.api + 'creatives/' + this.creative_id, this.collectCreative(), this.$root.config).then(response => {
                    this.editAttributes();
                }, error => {
                    alert(error);
                });
            },

            editAttributes() {
                axios.post(this.$root.api + 'creatives/' + this.creative_id + '/attr', this.creative.attr.data, this.$root.config).then(response => {
                    this.fetchCreative();
                    window.location.pathname = 'accounts/' + this.account_id;
                }, error => {
                    alert(error);
                });
            },

            editCreativeStatus() {
                axios.put(this.$root.api + 'creatives/' + this.creative_id, {status: this.creative.approved}, this.$root.config).then(response => {
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
