<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <h1 class="title pull-left">Campaign {{ campaign.name }}</h1>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-md-12">
                <legend>1. Information</legend>

                <div class="form-group">
                    <div class="col-md-3">
                        <label>Name</label>
                        <input class="form-control" :value="campaign.name" />
                    </div>
                    <div class="col-md-3">

                        <div class="col-md-6">
                            <label>From</label>
                            <input class="form-control" :value="campaign.start_time" />
                        </div>
                        <div class="col-md-6">
                            <label>To</label>
                            <input class="form-control" :value="campaign.end_time" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>Advertiser Domain</label>
                        <input class="form-control" :value="campaign.adomain" />
                    </div>
                    <div class="col-md-3">
                        <label>CTR Url</label>
                        <input class="form-control" :value="campaign.ctrurl" />
                    </div>
                </div>
            </div>
        </div>

        <br />
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <div class="col-md-4">
                        <label>Daily Budget</label>
                        <input class="form-control" :value="campaign.budget.data.total" />
                    </div>
                    <div class="col-md-4">
                        <label>Max Bid (CPM)</label>
                        <input class="form-control" :value="campaign.bidmax" />
                    </div>
                    <div class="col-md-4">
                        <label>Daily Budget Pacing</label>
                        <button class="btn btn-tapklik btn-block disabled" disabled>Set</button>
                    </div>
                </div>
            </div>
        </div>

        <br />
        <div class="row">
            <div class="col-md-12">
                <legend>2. Categories</legend>
                <div class="form-group">
                    <div class="col-xs-12">

                    </div>
                </div>
            </div>
        </div>

        <br />
        <div class="row">
            <div class="col-md-12">
                <legend>3. Targeting</legend>
                <div class="form-group">
                    <div class="col-xs-12">

                    </div>
                </div>
            </div>
        </div>

        <br />
        <div class="row">
            <div class="col-md-12">
                <legend>4. Admin</legend>
                <div class="form-group">
                    <div class="col-xs-12">

                    </div>
                </div>
            </div>
        </div>

        <br />
        <div class="row clearfix">
            <div class="col-md-12">
                <button class="btn btn-primary pull-right">Update</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {

            this.fetchCampaign();
        },

        data: function () {

            return {
                campaign: {
                    budget: {
                        data: {
                            total: 0,
                            daily: {
                                total: 0,
                                spend: 0
                            }
                        }
                    }
                },
                loading: false,
                noresult: false,
            }
        },

        methods: {

            fetchCampaign: function () {

                this.loading = true;

                this.$http.get(this.$root.api + 'campaigns/' + obj.id).then( response => {
                    this.campaign = response.data.data;
                    this.loading = false;
                }, error => {
                    console.log(error);
                });
            },
        }
    }

</script>