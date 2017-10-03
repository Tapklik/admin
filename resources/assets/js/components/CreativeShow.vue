<template>
    <div>
        <div class="row">
            <div class="col-md-8">
                <h1 class="title pull-left">Details</h1>
            </div>
        </div>
        <hr/>
        <div class="form-group">
            <div class="form-group">
                <div class="row">
                    <div class="col-xs-12 col-md-6">
                        <label for="label-city">Name</label>
                        <br/>
                        <input type="text" class="form-control" id="label-city" v-model="creative.name" />
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <label for="label-city">Click-Through URL</label>
                        <br/>
                        <input type="text" class="form-control" id="label-city" v-model="creative.ctrurl"/>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-xs-12 col-md-6">
                        <label for="label-approved">Class</label>
                        <br/>
                        <select class="form-control" id="label-approved" v-model="creative.class">
                            <option value="banner">Banner</option>
                            <option value="video">Video</option>
                            <option value="native">Native</option>
                        </select>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <label for="label-approved">Status</label>
                        <br/>
                        <select class="form-control" id="label-approved" v-model="creative.approved">
                            <option value="approved">Approved</option>
                            <option value="pending">Pending</option>
                            <option value="declined">Declined</option>
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
                        <label for="label-approved">Responsive</label>
                        <br/>
                        <select class="form-control" id="label-approved" v-model="creative.responsive">
                            <option :value="false">No</option>
                            <option :value="true">Yes</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <button @click="editCreative()">Edit</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            
        },

        data() {

            return {
                creativeId: this.getCreativeId(),
                accountId: this.getAccountId(),
                creative: {},
                loading: false,
                noresult: false,
                token: this.token
            }
        },

        methods: {
            getCreativeId() {
                var idDraft = window.location.pathname.replace('\/accounts\/', '');
                var id = idDraft.slice((idDraft.length - 36),idDraft.length)
                return id;
            },

            getAccountId() {
                var idDraft = window.location.pathname.replace('\/accounts\/', '');
                var id = idDraft.slice(0,(idDraft.length - 47))
                return id;
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
                    ctrurl: this.creative.ctrurl,
                    thumb: this.creative.thumb,
                    folder_id: this.creative.folder.key 
                }
            },

            editCreative() {
                axios.put(this.$root.api + 'creatives/' + this.creativeId, this.collectCreative(), this.$root.config).then(response => {
                    this.fetchCreative();
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
            }
        }
    }

</script>
