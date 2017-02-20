<template>
    <div>
        <div class="row">
            <div class="col-md-8">
                <h1 class="title pull-left">Creatives for Campaign</h1>
            </div>
            <div class="col-md-4">
            </div>
        </div>
        <hr/>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Thumb.</th>
                <th>Ctrurl</th>
                <th>Iurl</th>
                <th>Type</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody class="vcenter">
            <tr v-show="loading == true">
                <td colspan="5" class="loader text-center">
                    <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
                </td>
            </tr>
            <tr v-show="noresult">
                <td colspan="5">
                    Sorry but I can't find anything relating to <strong>{{ search }}</strong>
                </td>
            </tr>

            <tr v-for="(creative, index) in creatives.data">
                <td>
                    <a :href="creativeUri(creative.crid)">
                        {{ creative.crid }}
                    </a>
                </td>
                <td>
                    <img :src="getImage(creative.iurl)" style="max-height: 20px;" />
                </td>
                <td>
                    <a :href="creative.ctrurl" class="btn btn-primary" target="_blank">
                        View
                    </a>
                </td>
                <td>
                    <a :href="creative.iurl" class="btn btn-primary" target="_blank">
                        View
                    </a>
                </td>
                <td>{{ creative.type }}</td>
                <td>
                    <button class="btn"
                            :class="{ 'btn-success': creative.approved, 'btn-danger': !creative.approved }"
                            :data-status="creative.approved"
                            @click="toggleStatus(creative.crid, creative.approved, index)">
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

            this.fetchCampaignCreatives();
        },

        data: function () {

            return {
                creatives: {
                    data: {

                    }
                },
                search: '',
                urls: {
                    accounts: '/accounts/'
                },
                loading: false,
                noresult: false
            }
        },

        methods: {

            fetchCampaignCreatives: function () {
                this.loading = true;

                this.$http.get(this.$root.api + 'campaigns/' + obj.id + '/creatives').then( response => {
                    this.creatives = response.data;
                    this.loading = false;
                }, error => {
                    console.log(error);
                });
            },

            toggleStatus: function(id, status, index) {
                this.loading = true;

                var state = (status) ? 0 : 1;

                var self = this;
                this.$http.put(this.$root.api + 'creatives/' + id + '/status', {status: state}).then( response => {

                   self.fetchCampaignCreatives();
                    this.loading = false;
                }, error => {
                    console.log(error);
                });
            },

            generateUri(type, id) {

                var endpoint = '';

                switch(type) {

                    case 'campaigns':
                        endpoint += 'campaigns';
                    break;

                    case 'creatives':
                        endpoint += 'creatives';
                    break;
                }

                return '/accounts/' + id + '/' + endpoint;
            },

            creativeUri(crid) {

                return '/creatives/' + crid;
            },

            getImage(file) {
                return this.$root.path + file;
            }
        },

    }
</script>
