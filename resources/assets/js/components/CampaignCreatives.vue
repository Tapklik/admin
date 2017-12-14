<template>
    <div>
        <div class="row">
            <div class="col-xs-12">
                <h2>Creatives</h2>
            </div>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Class</th>
                    <th>Dimensions</th>
                    <th>Image</th>
                    <th>Approve</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody class="vcenter">
                <tr v-if="creativesLoader == true">
                    <td colspan="11" class="loader text-center">
                        <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
                    </td>
                </tr>
                <tr v-else-if="noresult">
                    <td colspan="11">
                        Sorry but theres nothing here... yet :)
                    </td>
                </tr>
                <tr v-else v-for="c in campaign.creatives.data">
                    <td>{{ c.id }}</td>
                    <td>
                        <a :href=" accountId + '/creatives/' + c.id">
                            {{ c.name }}
                        </a>
                    </td>
                    <td>{{ c.class }}</td>
                    <td>{{ c.w }}x{{ c.h}}</td>
                    <td>  <a :href="c.iurl" target="_blank"><img width="70px" :src="c.thumb"></a> </td>
                    <td>
                        <button :class="{'btn btn-success': c.approved == 'approved', 'btn btn-danger': c.approved != 'approved'}" @click="toggleApproval(c.id, c.approved)">
                            <i class="fa fa-check-circle-o"></i>
                        </button>
                    </td>
                    <td>
                        <button class="btn btn-danger" @click="deleteCreative(c.id)">
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
                noresult: false,
                creativesLoader: true,
                campaignId: 0,
                accountId: 0,
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
                token: this.token,
            }
        },

        methods: {

            toggleApproval(id, status) {
                var toggleBag = {
                    approved: 'declined',
                    declined: 'approved',
                    pending: 'approved'
                };
                this.creativesLoader = true;
                axios.put(this.$root.api + 'creatives/' + id, {status: toggleBag[status]}, this.$root.config).then(response => {
                    this.fetchCampaign();
                }, error => {
                    console.log(error);
                });
            },

            deleteCreative(id) {
                this.creativesLoader = true;
                axios.delete(this.$root.api + 'creatives/' + id, this.$root.config).then( response => {
                    this.fetchCampaign();
                }, error => {
                    alert(error);
                });
            },

            getIds() {
                var idDraft = window.location.pathname;
                var res = idDraft.split("/");

                this.campaignId = res[4];
                this.accountId = res[2];
            },

            fetchCampaign() {
                axios.get(this.$root.api + 'campaigns/' + this.campaignId, this.$root.config).then(response => {
                    this.campaign = response.data.data;
                    this.geo = this.campaign.geo.data;
                    this.creativesLoader = false;
                    
                    this.loading = false;
                }, error => {
                    this.creativesLoader = false;
                    alert(error);
                });
            },
        },

        watch: {
            token(value) {
                this.fetchCampaign();
            }
        }
    }
</script>


