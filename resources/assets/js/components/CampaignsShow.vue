<template>
    <div>
        <div>
            <div class="row">
                <div class="col-xs-12">
                    <h1 class="title">{{ campaign.name }}</h1>
                    
                    <button class="btn btn-default pull-right">
                        <i class="fa fa-plus"></i> Edit this Campaign
                    </button>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-sm-5">
                    <table class="table">
                        <tr>
                            <td class="col-sm-3">
                                <b> Id: </b> 
                            </td>
                            <td class="col-sm-9">
                                <span class="muted">{{campaign.id}}</span>
                            </td>
                        </tr>
                        <br>
                        <tr>
                            <td class="col-sm-3">
                                <b>Status:</b> 
                            </td>
                            <td class="col-sm-9">
                                <button class="btn"
                                :class="{ 'btn-success': campaign.status=='active', 'btn-danger': campaign.status=='stopped', 'btn': campaign.status == 'archived'}"
                                :data-status="campaign.status"
                                @click="toggleStatus(campaign.id, campaign.approved, index)">
                        <i class="fa fa-check-circle-o"></i>
                    </button>
                            </td>
                        </tr>
                        <br>
                        <tr>
                            <td class="col-sm-3">
                                <b>Bid:</b> 
                            </td>
                            <td class="col-sm-9">
                                <span>{{$root.fromMicroDollars(campaign.bid)}}</span>
                            </td>
                        </tr>
                        <br>
                        <tr>
                            <td class="col-sm-3">
                                <b>Budget: </b>
                            </td>
                            <td class="col-sm-9">
                                <span> {{$root.fromMicroDollars(campaign.budget.data.amount)}} / {{campaign.budget.data.type}} </span>
                            </td>
                        </tr>
                    </table>
                </div>
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
                campaign: {
                    budget: {
                        data: {

                        }
                    }
                },
                loading: false,
                token: false
            }
        },

        methods: {


            fetchCampaign() {

                this.loading = true;
                var self = this;
                var campaignId = window.location.pathname.replace('\/campaigns\/', '');
                    
                axios.get(self.$root.api + 'campaigns/' + campaignId, this.$root.config).then( response => {
                    self.campaign = response.data.data;

                    self.loading = false;
                }, error => {
                    console.log(error);
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


