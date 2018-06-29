<template>
    <div>

        <div class="row" style="padding-left: 16px; padding-right: 16px;">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-5" style="display: flex; align-items: center;">
                            <div class="col-xs-8">
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
                        </div>
                        <div class="col-xs-7">
                            <div class="pull-right">
                                <a :href="goToCreativesShow()" class="btn btn-default">TASK</a>
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
                    </div>
                </div>
            </div>
        </div>

        <hr />

        <div class="row" style="padding-left: 16px; padding-right: 16px;">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row" style="display: flex; align-items: center;">
                        <div class="col-xs-8">
                          Details  
                        </div>
                        <div class="col-xs-4">
                            <button class="btn btn-default pull-right" @click="openEditCreative()">
                                Edit Creative
                            </button>
                        </div>
                    </div>
                </div>
                <div v-if="creative.id.length == 0" class="panel-body" style="display: flex; justify-content: center;">
                    <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
                </div>
                <div v-else class="panel-body" style="display: flex; align-items: center;">
                    <div class="col-xs-6">
                        <label>ID: </label> {{creative.id}} <br>
                        <label>Name: </label> {{creative.name}} <br>
                        <label>Class: </label> {{creative.class}} <br>
                        <label>Size: </label> {{creative.w + 'x' + creative.h}} <br>
                        <label>Responsive: </label> 
                        <span class="label" :class="creative.responsive ? 'label-success' : 'label-danger'">
                            {{ creative.responsive ? 'Yes' : 'No' }}
                        </span> <br>
                        <hr>
                        <label>Click-through URL: </label> {{creative.ctrurl != null ? creative.ctrurl : 'None'}} <br>
                        <label>HTML: </label> {{creative.html != null ? creative.html : 'None'}} <br>
                        <label>Path: </label> {{creative.path != null ? creative.path : 'None'}} <br>
                        <hr>
                        <label>Attributes: </label> {{creative.attr.data.length > 0 ? creative.attr.data.join() : 'None'}} 
                        <br>
                        <hr>
                        <label>Additional/Debug Params: </label> <br> {{creative.params != null ? creative.params : 'None'}}
                    </div>
                    <div class="col-xs-6">
                        <img
                        style="display: block; margin:auto; max-width: 100%; height: auto;"
                        :src="creative.thumb"
                        />
                    </div>
                </div>
            </div>
        </div>

        <hr />

        <div class="row" style="padding-left: 16px; padding-right: 16px;">
            <div class="panel panel-default">
                <div class="panel-heading">Campaigns</div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>CTR URL</th>
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
                                <td><a :href="campaign.ctrurl">{{campaign.ctrurl}}</a></td>
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
                </div>
            </div>
        </div>
        
        <hr />

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

        <!-- EDIT CREATIVE MODAL START -->
        <div class="modal fade" id="_modal-edit-creative" tabindex="-1" role="dialog">
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
                        <h4 class="modal-title">Edit Creative</h4>
                    </div>
                    <div class="modal-body">
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
                                        <label for="label-approved">Click-through URL</label>
                                        <br/>
                                        <textarea
                                            rows="2"
                                            class="form-control"
                                            id="label-city"
                                            v-model="creative.ctrurl"
                                        /></textarea>
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
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-12 col-md-12">
                                        <label for="label-approved">Additional/Debug Params</label>
                                        <br/>
                                        <textarea
                                            rows="3"
                                            class="form-control"
                                            id="label-city"
                                            v-model="creative.params"
                                        /></textarea>
                                    </div>
                                </div>
                            </div>
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
                        <button type="button" class="btn btn-primary" data-dismiss="modal" @click="editCreative()">Edit</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- EDIT CREATIVE MODAL END -->

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


                <!-- ADD CREATIVE START-->
        <div class="modal fade" id="_modal-show-creative" tabindex="-1" role="dialog">
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
                        <h4 class="modal-title">Show Creative</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8">
                                <input
                                type="text"
                                class="form-control"
                                placeholder="ctrurl"
                                v-model="show_creative_ctrurl"><br>
                                <input
                                type="text"
                                class="form-control"
                                placeholder="tags"
                                v-model="show_creative_ctrurl">
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-default" @click="showCreativeRefresh()">Refresh Creative</button>
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
                            >
                                Create
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <br><br><br><br>
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
                    params: '',
                    expdir: 0,
                    folder: {
                        key: 0,
                        name: ''
                    },
                    h: 0,
                    html: '',
                    path: '',
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
                add_creative_button_loading: false,

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

            goToCreativesShow() {
                return window.location.pathname + '/show';
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

            showCreative() {
                return {"http_code":200,"response":"\n\t\t\t\t\t\t  \t\t<script type='text\/javascript' src='https:\/\/cdn.tapklik.com\/js\/tapklik.basic.js'><\/script>\n\t\t\t\t\t\t  \t\t<iframe id='tapklik-ad' src='about:blank;' frameborder='0' scrolling='no'><\/iframe>\n\t\t\t\t\t\t  \t\t<script type='text\/javascript'>\n\t\t\t\t\t\t  \t\t\tvar banner_url = 'http:\/\/s3.eu-central-1.amazonaws.com\/tapklik-creatives-alpha\/creatives\/h\/d90da31d8c8815b9893fcccb51ee2d1ed255d339.zip\/holiday_300x250_cc_tk.html';\n\t\t\t\t\t\t  \t\t\tvar width = 300;\n\t\t\t\t\t\t  \t\t\tvar height = 250;\n\t\t\t\t\t\t  \t\t\tvar ct = 'http:\/\/wins.alpha.tapklik.com:2250\/link\/h\/8035cc7e-790f-11e8-8832-5a00017e23f6\/47d612468f?b=15302-c715-412a-a6f7-6b7c36f6ff12&x=3&adr=b1&ts=1530275100';\n\t\t\t\t\t\t  \t\t\tvar gc = '';\n\t\t\t\t\t\t  \t\t\tvar c = '47d612468f';\n\t\t\t\t\t\t  \t\t\tvar cr = '8035cc7e-790f-11e8-8832-5a00017e23f6';\n\t\t\t\t\t\t  \t\t\tvar b = '15302-c715-412a-a6f7-6b7c36f6ff12';\n\t\t\t\t\t\t  \t\t\tvar ts = '1530275100';\n\t\t\t\t\t\t  \t\t\tvar loader_obj = {};\n\t\t\t\t\t\t\t\t\t\t  loader_obj['width'] = width;\n\t\t\t\t\t\t\t\t\t\t  loader_obj['height'] = height;\n\t\t\t\t\t\t\t\t\t\t  loader_obj['1pclick_url'] = gc || '';\n\t\t\t\t\t\t\t\t\t\t  loader_obj['click_urls'] = {};\n\t\t\t\t\t\t\t\t\t\t  loader_obj['click_urls']['clickTag'] = ct;\n\t\t\t\t\t\t\t\t\t\t  loader_obj['1poobclick_url'] = 'http:\/\/80.240.20.129:2301\/d\/b\/g\/echo1p?b=' + b + '&ct=' + encodeURIComponent(ct) + '&gc=' + encodeURIComponent(gc);\n      \t\t\t\t\t\t\t\tTK.html5.basicLoader('tapklik-ad', banner_url, loader_obj);\n\t\t\t\t\t\t  \t\t<\/script>\n\t\t\t\t\t\t  \t\t<img  width='1' height='1' style='border:0; visibility: hidden;' src='http:\/\/wins.alpha.tapklik.com:2250\/butler\/h\/8035cc7e-790f-11e8-8832-5a00017e23f6\/47d612468f?b=15302-c715-412a-a6f7-6b7c36f6ff12&x=3&adr=b1&ts=1530275100'>\n\t\t\t\t\t\t  "};
                
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
                    ctrurl: this.creative.ctrurl,
                    params: this.creative.params,
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
            
            openEditCreative() {
                $('#_modal-edit-creative').modal();
            },

            openShowCreative() {
                $('#_modal-show-creative').modal();
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
