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
            <div class="col-xs-2 col-xs-offset-2">
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
            <div class="col-xs-8">
                <button @click="openCreativePreview()" class="btn btn-default">Preview</button>
                <a :href="creative.iurl" v-show="!creative_is_html5" class="btn btn-default">Download Image</a>
                <a :href="creative.asset" v-show="creative_is_html5">
                    <button class="btn btn-default">Download HTML5</button>
                </a>
                <button v-show="creative_is_html5" class="btn btn-default" @click="openUpload('#_modal-add-creative')">
                    Upload
                </button>
                <button @click="verifyCreative()" class="btn btn-default">
                    Verify
                </button>
                <button @click="checkCreativeStatus()" class="btn btn-default">
                    Check Status
                </button>
            </div>
        </div>
        <!-- ACTION BAR END -->

        <hr />

        <!-- ADEX TABLE START -->
        <div class="well col-xs-3" v-for="(ad, index) in adex">
            <div class="row">
                <h4 class="col-xs-9">{{index}}</h4>
                <span class="label label-success col-xs-3">
                    Approved
                </span>
            </div><br>
            <div class="row">
                <div class="col-xs-4">
                    <button>
                        Hello
                    </button>
                    <br />
                    <br />
                    <button>
                        There
                    </button>
                </div>
                <p class="col-xs-8">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc porta aliquet sagittis.
                </p>
            </div>
        </div>
        <!-- ADEX TABLE END -->

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
                                    <option value="html5">HTML5</option>
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
                    <button @click="editCreative()" class="btn btn-default">Edit Creative</button>
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
                        @click="openInvocationCodeModal(campaign)"
                        class="btn btn-primary"
                        >
                            Preview
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- CAMPAIGNS END -->

        <!-- INVOCATION CODE MODAL START -->
        <div class="modal fade" id="_modal-show-invocation" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content" :style="'width: ' + (creative.w + 32) + 'px; margin: auto'">
                    <div class="modal-header">
                        <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Invocation Code Preview</h4>
                    </div>
                    <div class="modal-body">
                        <div
                        class="form-group"
                        v-html="invocation_code_preview"
                        ></div>
                    </div>
                    <div class="modal-footer">
                        <button
                        type="button"
                        class="btn btn-default"
                        data-dismiss="modal"
                        >
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- INVOCATION CODE MODAL END -->

        <!-- PREVIEW MODAL START -->
        <div class="modal fade" id="_modal-show-preview" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content" :style="'width: ' + (creative.w + 32) + 'px; margin: auto; max-width: 100%;'">
                    <div class="modal-header">
                        <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Preview</h4>
                    </div>
                    <div class="modal-body">
                        <div
                        class="form-group"
                        v-html="preview"
                        ></div>
                    </div>
                    <div class="modal-footer">
                        <button
                        type="button"
                        class="btn btn-default"
                        data-dismiss="modal"
                        >
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- PREVIEW MODAL END -->

                <!-- ADD CREATIVE START-->
        <div class="modal fade" id="_modal-add-creative" tabindex="-1" role="dialog">
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
                        <h4 class="modal-title">Create New User</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div
                            id="uploader"
                            class="col-xs-12"
                            style="padding-top: 15px; padding-bottom: 15px; text-align: center; background: repeating-linear-gradient(45deg, transparent, transparent 10px, #ccc 10px, #ccc 20px), linear-gradient( to bottom, #eee, #999); cursor: pointer;"
                            @mouseenter="dropzoneMaker()"
                            >
                                <span id="uploader-title" >Upload Creative Here</span>
                            </div>
                        </div>
                        <hr>
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
                            :loading="add_creative_button_loading"
                            @click="uploadCreative(), add_creative_button_loading = true"
                            >
                                Create
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ADD CREATIVE END-->


    </div>
</template>

<script>
    export default {
        mounted() {
            this.getIds();
            this.getAdex();
        },

        data() {
            return {
                //ESSENTIALS
                token: this.token,
                creative_id: '',
                account_id: '',
                account_name: '',
                adex: {},
                dropzone: false,
                thumbnail: '',
                preview: '',
                preview_validation: '',

                //CREATIVE
                new_creative: {},
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

                //INVOCATION CODE MODAL
                invocation_code_preview: '',
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

            getAccountName() {
                axios.get(
                    this.$root.api + '/accounts/' + this.account_id,
                    this.$root.config
                ).then( response => {
                    this.account_name = response.data.data.name;
                }, error => {
                    this.account_name = '';
                });
            },

            dropzoneMaker() {
                if (this.dropzone !== false) return;
                this.dropzone = new Dropzone("#uploader", {
                    url: this.$root.api + '/creatives',
                    paramName: 'file',
                    maxFilesize: 2,
                    acceptedFiles: 'image/*, application/zip, text/html, .html',
                    headers: {"Authorization": 'Bearer ' + this.token},
                    autoProcessQueue: false,
                    thumbnailWidth: 120,
                    thumbnailHeight: 120,
                    clickable: ['#uploader', '#uploader-title']
                });
                this.dropzone.on("addedfile", function(file, thumb) {
                    var is_zip = file.type.indexOf('zip') != -1 ? true : false;
                    var sizeInterval = setInterval(function () {
                        this.new_creative = {
                            path: this.creative.html.substr(this.creative.html.indexOf('creatives')),
                            name: file.name,
                            nosave: 1
                        };
                        clearInterval(sizeInterval);
                    }.bind(this), 1000);
                }.bind(this));

                this.dropzone.on("thumbnail", function(file, thumb) {
                    this.thumbnail = thumb;
                }.bind(this));
            },

            uploadCreative() {
                this.dropzone.options.params = {
                    path: this.new_creative.path,
                    name: this.new_creative.name,
                    nosave: this.new_creative.nosave
                };
                this.dropzone.processQueue();

                this.dropzone.on("complete", function (file) {
                    if (file.status == 'success') {
                        this.add_creative_button_loading = false;
                    }
                }.bind(this));
            },

            //ADEX
            getAdex() {
                axios.get(
                    '/data/adex.json'
                ).then(response => {
                        this.adex = response.data;
                    }, error => {

                    }
                );
            },

            //CREATIVE
            checkCreativeStatus() {
                axios.get(
                    this.$root.api + '/creatives/' + this.creative_id + '/status',
                    this.$root.config
                ).then(response => {
                        console.log(response);
                        var status = response.data.status;
                        alert('This creative is: ' + status);
                    }, error => {
                        alert('Could not retrieve creative status.');
                    }
                );
            },

            verifyCreative() {
                var payload = this.verifyCreativePayload();
                axios.post(
                    this.$root.api + '/creatives/' + this.creative_id + '/verification',
                    payload,
                    this.$root.config
                ).then(response => {

                }, error => {

                });
            },

            verifyCreativePayload() {
                var ctrurls = [];
                var verification_url = this.creative.ctrurl == null ? this.creative.adm_url : this.creative.ctrurl;
                if (verification_url != null) ctrurls.push(verification_url);
                else verification_url = '';
                var snippet = this.preview_validation;
                return {
                    advertiserName: this.account_name,
                    html: {
                        height: this.creative.h,
                        snippet: snippet,
                        width: this.creative.w
                    },
                    creativeId: this.creative.id,
                    clickThroughUrls: verification_url
                };
            },

            openUpload(target) {
                $(target).modal();
            },

            openCreativePreview() {
                $("#_modal-show-preview").modal();
            },

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
                    this.$root.api + '/creatives/' + this.creative_id,
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
                    this.$root.api + '/creatives/' + this.creative_id,
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
                    this.$root.api + '/creatives/' + this.creative_id + '/attr',
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
                    this.$root.api + '/creatives/' + this.creative_id,
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
                return tags.filter(tag => tag !== '');
            },

            //CAMPAIGNS
            getCampaigns() {
                axios.get(
                    this.$root.api + '/accounts/' +  this.account_id + '/campaigns',
                    this.$root.config
                ).then(response => {
                        var self = this;
                        var campaigns = response.data.data;
                        this.campaigns = campaigns.filter(campaign =>
                            campaign.creatives.data.map(creative =>
                                creative.id).indexOf(self.creative_id) != -1
                        );
                        this.campaigns_table_empty = this.campaigns == '' ? true : false;
                        this.campaigns_table_loading = false;
                    }, error => {
                        this.campaigns_table_loading = false;
                    }
                );
            },

            //INVOCATION CODE MODAL
            openInvocationCodeModal(campaign) {
                this.getInvocationCode(campaign);
                $('#_modal-show-invocation').modal();
            },

            getInvocationCode(campaign) {
                var index = campaign.creatives.data.map(creative => creative.id).indexOf(this.creative_id);
                var creative = campaign.creatives.data[index];
                var html5 = creative.class != 'html5' ? false : true;
                if(html5) {
                    var adm_url_replacement = 'ct=' + encodeURIComponent(creative.adm_url) + '?preview=1';
                    var result = creative.adm_iframe.replace('{{ADM_URL}}', adm_url_replacement);
                    this.invocation_code_preview = result;
                } else {
                    var result = creative.adm.replace('{{ADM_URL}}', creative.adm_url + '?preview=1');
                    this.invocation_code_preview = result;
                }
            },

            getPreview() {
                var creative = this.creative;
                var html5 = creative.class != 'html5' ? false : true;
                var validate = '';
                var result = '';
                var validation = '';
                var adm_url_replacement;
                var url = creative.ctrurl == null ? creative.adm_url : creative.ctrurl;
                if(html5) {
                    validate = creative.adm_iframe;
                    adm_url_replacement = 'preview=1&ct=' + encodeURIComponent(url);
                    result = validate.replace('{{ADM_URL}}', adm_url_replacement);
                    this.preview = result;
                    validation = result.replace('&preview=1&ct=', '&ct=%%CLICK_URL_ESC%%');
                    this.preview_validation = validation;
                } else {
                    validate = creative.adm;
                    result = validate.replace('{{ADM_URL}}', url + '?preview=1');
                    this.preview = result;
                    validation = result.replace(url + '?preview=1', '%%CLICK_URL_UNESC%%' + url);
                    this.preview_validation = validation;
                }
            }
        },

        computed: {
            creative_is_html5() {
                return this.creative.asset == '' ? false : true;
            }
        },

        watch: {
            token(value) {
                this.getCreative();
                this.getCampaigns();
                this.getAttributes();
                this.getAccountName();
            },
            creative(value) {
                this.splitCtrurl();
                this.getPreview();
                this.getPreview(true);
            }
        }
    }
</script>
