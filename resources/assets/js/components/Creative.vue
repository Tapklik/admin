<template>
    <div>

        <!-- HEADER START -->
        <div class="row">
            <div class="col-md-8">
                <h1 class="title pull-left">Edit</h1>
            </div>
        </div>
        <!-- HEADER END -->

        <hr />

        <!-- ACTION BAR START -->
        <div class="row">
            <div class="col-xs-2"></div>
            <div class="col-xs-2">
                Actions
            </div>
        </div>
        <div class="row">
            <div class="col-xs-2">
                <select 
                class="form-control" 
                id="label-approved" 
                @change="editCreativeStatus()" 
                v-model="creative.approved"
                >
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
                <a :href="creative.iurl">
                    <button class="btn btn-default">Download</button>
                </a>
            </div>               
        </div>
        <!-- ACTION BAR END -->

        <hr />     
        
        <!-- CREATIVE START -->
        <div class="form-group">
            <div class="row">
                <div class="col-xs-8">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                <label for="label-city">Name</label>
                                <br/>
                                <input 
                                type="text" 
                                class="form-control" 
                                id="label-city" 
                                v-model="creative.name" 
                                />
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <label for="label-approved">Class</label>
                                <br/>
                                <select 
                                class="form-control" 
                                id="label-approved" 
                                v-model="creative.class"
                                >
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
                                <input 
                                type="text" 
                                class="form-control" 
                                id="label-city" 
                                v-model="creative.w"
                                />
                            </div>
                            <div class="col-xs-12 col-md-3">
                                <label for="label-approved">Height</label>
                                <br/>
                                <input 
                                type="text" 
                                class="form-control" 
                                id="label-city" 
                                v-model="creative.h"
                                />
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <div class="row">
                                    <label for="label-approved"></label><br />
                                    <input 
                                    type="checkbox" 
                                    v-model="creative.responsive" 
                                    style="margin-left: 20px;" 
                                    /> Responsive
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-12 col-md-12">
                                <label for="label-approved">Attributes</label>
                                <br/>
                                <select 
                                class="form-control" 
                                multiple 
                                id="label-approved" 
                                v-model="creative.attr.data"
                                >
                                    <option 
                                    v-for="attribute in attributes" 
                                    :value="attribute.value"
                                    >
                                        {{attribute.description}}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-4">
                    <div class="well" style="margin-top: 50px">
                        <img 
                        style="display: block; margin:auto" 
                        :src="creative.thumb" 
                        />
                    </div>
                </div>
            </div>   
        </div>
        <!-- CREATIVE END -->

        <hr />

        <!-- CTRURL START -->
        <div class="form-group">
            <div class="row">
                <div class="col-xs-8">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-12">
                                <label for="label-city">CTR URL</label>
                                <br/>
                                <input 
                                type="text" 
                                class="form-control" 
                                id="label-city" 
                                v-model="creative.ctrurl" 
                                />
                            </div>
                            <div class="col-xs-12">
                                <label for="label-city">Tag #1</label>
                                <br/>
                                <input 
                                type="text" 
                                class="form-control" 
                                id="label-city" 
                                v-model="tags[0]" 
                                />
                            </div>
                            <div class="col-xs-12">
                                <label for="label-city">Tag #2</label>
                                <br/>
                                <input 
                                type="text" 
                                class="form-control" 
                                id="label-city" 
                                v-model="tags[1]"
                                />
                            </div>
                            <div class="col-xs-12">
                                <label for="label-city">Tag #3</label>
                                <br/>
                                <input 
                                type="text" 
                                class="form-control" 
                                id="label-city" 
                                v-model="tags[2]"
                                />
                            </div>
                            <div class="col-xs-12">
                                <label for="label-city">Tag #4</label>
                                <br/>
                                <input 
                                type="text" 
                                class="form-control" 
                                id="label-city" 
                                v-model="tags[3]"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- CTRURL END -->

        <hr />

        <!-- CAMPAIGNS START -->
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

                <!-- TABLE LOADER START -->                   
                <tr v-if="campaigns_table_loading">
                    <td colspan="11" class="loader text-center">
                        <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
                    </td>
                </tr>
                <!-- TABLE LOADER END -->                          
                
                <!-- EMPTY TABLE MESSAGE START -->
                <tr v-else-if="campaigns_table_empty">
                    <td colspan="11">
                        Sorry but theres nothing here... yet :)
                    </td>
                </tr>
                <!-- EMPTY TABLE MESSAGE END -->

                <tr v-else v-for="campaign in campaigns">
                    <td>{{ campaign.name }}</td>
                    <td>{{campaign.ctrurl}}</td>
                    <td></td>
                    <td>
                        <button 
                        @click="openJSON('js', campaign.id)"
                        class="btn btn-primary"
                        >
                            JS
                        </button>
                        <button 
                        @click="openJSON('iframe', campaign.id)"
                        class="btn btn-primary"
                        >
                            iFrame
                        </button>
                        <button 
                        @click="openJSON(campaign)"
                        class="btn btn-primary"
                        >
                            View
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- CAMPAIGNS START -->

        <!-- INVOCATION CODE MODAL START -->
        <div class="modal fade" id="_modal-show-invocation" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button 
                        type="button" 
                        class="close" 
                        data-dismiss="modal" 
                        aria-label="Close"
                        >
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
                        <button 
                        type="button" 
                        class="btn btn-default" 
                        data-dismiss="modal"
                        >
                            Close
                        </button>
                        <button 
                        type="button" 
                        class="btn btn-primary" 
                        data-dismiss="modal" 
                        @click="createNewUser()"
                        >
                            Create
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- INVOCATION CODE MODAL START -->

    </div>
</template>

<script>
    export default {
        mounted() {
            this.getIds();
        },

        data() {
            return {
                //ESSENTIALS
                token: this.token,
                creative_id: '',
                account_id: '',

                //ACTIONS

                //CREATIVE
                attributes: [],
                creative: {
                    adm: '',
                    approved: '',
                    attr: {
                        data: []
                    },
                    class: '',
                    ctrurl: '',
                    expdir: 0,
                    folder: {
                        key: 0,
                        name: ''
                    },
                    h: 0,
                    html: '',
                    iurl: '',
                    id: '',
                    name: '',
                    pos: 0,
                    responsive: false,
                    thumb: '',
                    type: 0,
                    w: 0
                },

                //CTRURL
                tags: ['','','',''],

                //CAMPAIGNS
                campaigns: [],
                campaigns_table_loading: true,
                campaigns_table_empty: false,
                invocation_code: 'js',

                //INVOCATION CODE MODAL
                selected_invocation_code_text: ''
            }
        },

        methods: {

            //OVERALL
            getIds() {
                var pathname = window.location.pathname;
                var ids = pathname.split("/");
                this.creative_id = ids[4];
                this.account_id = ids[2];
            },

            //ACTIONS
            
            //CREATIVE            
            getAttributes() {
                axios.get(
                    '/data/attributes.json'
                ).then(response => {
                        this.attributes = response.data;
                    }, error => {

                    }
                );
            },


            getCreative() {
                axios.get(
                    this.$root.api + 'creatives/' + this.creative_id, 
                    this.$root.config
                ).then(response => {
                        this.creative = response.data.data;
                        this.loading = false;
                    }, error => {
                        alert(error);
                    }
                );
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
                axios.put(
                    this.$root.api + 'creatives/' + this.creative_id, 
                    this.collectCreative(), 
                    this.$root.config
                ).then(response => {
                        this.editAttributes();
                    }, error => {

                    }
                );
            },

            editAttributes() {
                axios.post(
                    this.$root.api + 'creatives/' + this.creative_id + '/attr', 
                    this.creative.attr.data, 
                    this.$root.config
                ).then(response => {
                        this.getCreative();
                        window.location.pathname = 'accounts/' + this.account_id;
                    }, error => {

                    }
                );
            },

            editCreativeStatus() {
                axios.put(
                    this.$root.api + 'creatives/' + this.creative_id, 
                    { status: this.creative.approved }, 
                    this.$root.config
                ).then(response => {
                
                    }, error => {

                    }
                );
            },

            
            //CTRURL
            splitCtrurl() {
                if(this.creative.ctrurl == null) return;
                
                var ctrurl = this.creative.ctrurl;
                var split_ctrurl = ctrurl.split("?"); //split the ctrurl and put in an array
                this.creative.ctrurl = split_ctrurl[0]; //assign the first value to ctrurl
                for(var i = 1; i < split_ctrurl.length; i++) {
                    this.tags[i-1] = split_ctrurl[i]; //others are assigned to tags
                }
            },

            getFilledTags() {
                var tags = this.tags;
                return tags.filter(tag => tag !== '')
            },
            
            //CAMPAIGNS
            getCampaigns() {
                axios.get(
                    this.$root.api + 'accounts/' +  this.account_id + '/campaigns', 
                    this.$root.config
                ).then(response => {
                        var self = this;
                        var campaigns = response.data.data;
                        this.campaigns = campaigns.filter(campaign => 
                            campaign.creatives.data.map(creative => 
                                creative.id).indexOf(self.creative_id) !== -1
                        );
                        this.campaigns_table_empty = this.campaigns == '' ? true : false; 
                        this.campaigns_table_loading = false;
                    }, error => {
                        this.campaigns_table_loading = false;
                    }
                );
            },

            //INVOCATION CODE MODAL
            openJSON(invocation_code, campaign_id) {
                this.getSelectedInvocationCodeText(invocation_code, campaign_id);
                $('#_modal-show-invocation').modal();
            },

            collectInvocationCode(invocation_code, campaign_id) {
                return {
                    attributes: this.creative.atr.data,
                    campaign_id: campaign_id,
                    creative_id: this.creative_id,
                    type: invocation_code
                }
            },

            getSelectedInvocationCodeText(invocation_code, campaign_id) {
                axios.get(
                    this.$root.api + 'core/invocation', 
                    this.collectInvocationCode(invocation_code, campaign_id), 
                    this.$root.config
                ).then(response => {
                        this.selected_invocation_code_text = response;
                    }, error=> {

                    }
                );
            }
        },

        computed: {
        },

        watch: {
            token(value) {
                this.getCreative();
                this.getCampaigns();
                this.getAttributes();
            },
            creative(value) {
                this.splitCtrurl();
            }
        }
    }

</script>
