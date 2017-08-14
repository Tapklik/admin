<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <h1 class="title pull-left">Edit creative {{ creative.crid }}</h1>
            </div>
        </div>
        <hr/>

        <div class="form-group">
            <label>Adm</label>
            <textarea v-model="creative.adm" class="form-control" cols="5" rows="4"></textarea>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-md-4">
                    <label>Ctr Url</label>
                    <input type="text" v-model="creative.ctrurl" class="form-control" />
                </div>
                <div class="col-md-4">
                    <label>Iurl</label>
                    <input type="text" v-model="creative.iurl" class="form-control" />
                </div>
                <div class="col-md-4">
                    <label>Type</label>
                    <input type="text" v-model="creative.type" class="form-control" />
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-md-3">
                    <label>Btype</label>
                    <input type="text" v-model="tempBtype" :value="transformType" class="form-control" />
                </div>
                <div class="col-md-3">
                    <label>Attr</label>
                    <input type="text" v-model="tempAttr" :value="transformAttr" class="form-control" />
                </div>
                <div class="col-md-3">
                    <label>Pos</label>
                    <input type="text" v-model="creative.pos" class="form-control" />
                </div>
                <div class="col-md-3">
                    <label>Approved</label>
                    <select class="form-control" v-model="creative.approved">
                        <option>true</option>
                        <option>false</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-xs-12">
                    <button class="btn btn-primary pull-right" @click="updateCreative()">
                        Update
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {

            this.fetchCreative();
        },

        data: function () {

            return {
                creative: {
                    expdir: 0,
                    crid: '',
                    adm: '',
                    ctrurl: '',
                    iurl: '',
                    type: '',
                    btype: [],
                    attr: [],
                    pos: '',
                    approved: 1
                },
                tempAttr: '',
                tempBtype: ''
            }
        },

        methods: {

            fetchCreative() {
                this.loading = true;

                this.$http.get(this.$root.api + 'creatives/' + obj.id).then( response => {
                    this.creative = response.data.data;

                    this.loading = false;
                }, error => {
                    console.log(error);
                });
            },

            creativeUri(crid) {

                return '/creatives/' + crid;
            },

            updateCreative() {
                var payload = this.creative;
                payload['attr'] = this.tempAttr;
                payload['btype'] = this.tempBtype;
                 
                this.$http.put(this.$root.api + 'creatives/' + obj.id, payload).then(response => {
                   swal('Success', 'Done. Updated. B000M!', 'success');
                }, error => {
                    console.log(error);
                });
            }
        },

        computed: {
             transformAttr() {
                var items = '';

                for (var item in this.creative.attr) {

                        items += this.creative.attr[item] + ',';
                }

                if (this.creative.attr.length == 1) {
                    items = items.substring(0, items.length - 1);
                }

                this.tempAttr = items;

                return items;
            },

             transformType() {
                var items = '';

                for (var item in this.creative.btype) {

                        items += this.creative.btype[item] + ',';
                }

                if (this.creative.btype.length == 1) {
                    items = items.substring(0, items.length - 1);
                }

                this.tempBtype = items;

                return items;
            },
        }
    }
</script>
