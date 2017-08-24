<template>
    <div>
        <div class="row">
            <div class="col-md-8">
                <h1 class="title pull-left">Campaigns</h1>

                <a href="/campaigns/create" class="btn btn-default pull-right">
                    <i class="fa fa-plus"></i> Create new campaign
                </a>
            </div>
            <div class="col-md-4">
                <input type="search" class="form-control" placeholder="Search campaign name..." v-model="search"/>
            </div>
        </div>
        <hr/>
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
                <th>Approved</th>
            </tr>
            </thead>
            <tbody class="vcenter">
            <tr v-show="loading == true">
                <td colspan="11" class="loader text-center">
                    <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
                </td>
            </tr>
            <tr v-show="noresult">
                <td colspan="11">
                    Sorry but theres nothing here... yet :)
                </td>
            </tr>

            <tr v-for="(campaign, index) in filterByCampaigns">
                <td>{{ campaign.id }}</td>
                <td>
                    <a :href="'campaigns/' + campaign.id">
                        {{ campaign.name }}
                    </a>
                </td>
                <td>{{ campaign.start_time }}</td>
                <td>{{ campaign.end_time }}</td>
                <td>
                    <a :href="adomain" v-for="adomain in campaign.adomain" target="_blank">
                        {{ adomain }}
                    </a>
                </td>
                <td>
                    <a :href="campaign.ctrurl" target="_blank">
                        link
                    </a>
                </td>
                <td>${{ $root.fromMicroDollars(campaign.budget.data.amount) }}</td>
                <td>${{ $root.fromMicroDollars(campaign.bid) }}</td>
                <td>
                    <a :href="generateUri('creatives', campaign.id)"  class="btn btn-primary">
                        View
                    </a>
                </td>
                <td>
                    <a :href="generateUri('api', campaign.id)"  class="btn btn-primary" target="_blank">
                        View
                    </a>
                </td>
                <td>
                    <button class="btn"
                            :class="{ 'btn-success': campaign.approved, 'btn-danger': !campaign.approved }"
                            :data-status="campaign.status"
                            @click="toggleStatus(campaign.id, campaign.approved, index)">
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
        },

        data() {

            return {
                campaigns: {},
                campaign: {},
                search: '',
                urls: {
                    campaigns: '/campaigns/'
                },
                loading: false,
                noresult: false,
                token: this.token
            }
        },

        methods: {

            fetchCampaigns() {
                
                this.loading = true;
            
                axios.get(this.$root.api + 'campaigns', this.$root.config).then(response => {
                    this.campaigns = response.data;
                    this.loading = false;
                }, error => {
                    console.log("heeey")
                    swal('Error', error, 'error');
                })
            },


            toggleStatus(id, status, index) {

                status = (1 == status) ? 0 : 1;
                this.campaigns.data[index].status = status;

                axios.put(this.$root.api + 'campaigns/' + id + '/approve', {approved: status}, this.$root.config).then(response => {
                    this.fetchCampaigns();
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

                    case 'api':
                        endpoint += '//api.tapklik.com/v1/campaigns/' + id;
                    break;

                    case 'creatives':
                        endpoint += '/campaigns/' + id + '/creatives';
                    break;
                }

                return endpoint;
            }
        },

        computed: {

            filterByCampaigns: function () {

                if (typeof this.campaigns.data == 'undefined') return;

                var self = this;

                var results = this.campaigns.data.filter( function(item) {

                    return item.name.toLowerCase().indexOf(self.search.toLowerCase()) > -1;
                });

                this.noresult = (!results.length) ? true : false;

                return results;
            }
        },

        watch: {
            token(value) {
                this.fetchCampaigns()
            }
        }
    }

</script>
