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
                        <input class="form-control" :value="campaign.name"/>
                    </div>
                    <div class="col-md-3">

                        <div class="col-md-6">
                            <label>From</label>
                            <input class="form-control" :value="campaign.start_time"/>
                        </div>
                        <div class="col-md-6">
                            <label>To</label>
                            <input class="form-control" :value="campaign.end_time"/>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>Advertiser Domain</label>
                        <input class="form-control" :value="campaign.adomain"/>
                    </div>
                    <div class="col-md-3">
                        <label>CTR Url</label>
                        <input class="form-control" :value="campaign.ctrurl"/>
                    </div>
                </div>
            </div>
        </div>

        <br/>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <div class="col-md-4">
                        <label>Daily Budget</label>
                        <input class="form-control" :value="campaign.budget.data.total"/>
                    </div>
                    <div class="col-md-4">
                        <label>Max Bid (CPM)</label>
                        <input class="form-control" :value="campaign.bidmax"/>
                    </div>
                    <div class="col-md-4">
                        <label>Daily Budget Pacing</label>
                        <button class="btn btn-tapklik btn-block disabled" disabled>Set</button>
                    </div>
                </div>
            </div>
        </div>

        <br/>
        <div class="row">
            <div class="col-md-12">
                <legend>2. Categories</legend>
                <div class="form-group">
                    <div class="col-xs-12 col-md-2" v-for="category in categories.body">
                        <label>
                            <input type="checkbox" />
                            {{ category }}
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <br/>
        <div class="row">
            <div class="col-md-12">
                <legend>3. Targeting</legend>
                <div class="form-group">
                    <div class="col-md-6">
                        <label>Geolocation</label>

                        <input class="form-control" />
                    </div>
                    <div class="col-md-6">

                        <div class="col-md-6">
                            <label>Audience</label>

                            <p class="clearfix"></p>

                            <label class="pull-left">
                                <input type="checkbox" />
                                Male
                            </label>
                            <label class="pull-left">
                                <input type="checkbox" />
                                Female
                            </label>
                        </div>

                        <div class="col-md-6">
                            <label>Ages</label>

                            <p class="clearfix"></p>

                            <ul class="list-inline">
                                <li>
                                    <label>
                                        <input type="checkbox" />
                                        1-11
                                    </label>
                                </li>
                                <li>
                                    <label>
                                        <input type="checkbox" />
                                        12-18
                                    </label>
                                </li>
                                <li>
                                    <label>
                                        <input type="checkbox" />
                                        19-25
                                    </label>
                                </li>
                                <li>
                                    <label>
                                        <input type="checkbox" />
                                        26-39
                                    </label>
                                </li>
                                <li>
                                    <label>
                                        <input type="checkbox" />
                                        40-55
                                    </label>
                                </li>
                                <li>
                                    <label>
                                        <input type="checkbox" />
                                        56-64
                                    </label>
                                </li>
                                <li>
                                    <label>
                                        <input type="checkbox" />
                                        65-120
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <br/>
        <div class="row">
            <div class="col-md-12">
                <legend>4. Admin</legend>
                <div class="form-group">
                    <div class="col-md-2">
                        <label>Test</label> <br />
                        <select class="form-control">
                            <option value="true">TRUE</option>
                            <option value="false" selected>FALSE</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label>Status</label> <br />
                        <select class="form-control">
                            <option value="stopped">Running</option>
                            <option value="stopped" selected>Stopped</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label>Weight</label> <br />
                        <input class="form-control" :value="campaign.weight" />
                    </div>
                    <div class="col-md-2">
                        <label>Exchange</label> <br />
                        <input class="form-control" :value="campaign.exchange" />
                    </div>
                    <div class="col-md-2">
                        <label>Node</label> <br />
                        <input class="form-control" :value="campaign.node" />
                    </div>
                    <div class="col-md-2">
                        <label>Pacing</label>  <br />
                        <select class="form-control">
                            <option value="true">Enabled</option>
                            <option value="false" selected>Disabled</option>
                        </select>
                    </div>
                </div>

                <p class="clearfix"></p>
                <div class="form-group">
                    <div class="col-xs-12">
                        <label>Hours Of Week</label>
                        <p class="clearfix"></p>

                        <div class="col-md-4">
                            <label>Mon</label>
                            <ul class="list-unstyled">
                                <li v-for="i in days">
                                    <label>
                                        <input type="checkbox" />
                                        {{ i }}
                                    </label>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <label>Tue</label>
                            <ul class="list-unstyled">
                                <li v-for="i in days">
                                    <label>
                                        <input type="checkbox" />
                                        {{ i }}
                                    </label>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <label>Wed</label>
                            <ul class="list-unstyled">
                                <li v-for="i in days">
                                    <label>
                                        <input type="checkbox" />
                                        {{ i }}
                                    </label>
                                </li>
                            </ul>
                        </div>

                        <hr />

                        <div class="col-md-4">
                            <label>Thu</label>
                            <ul class="list-unstyled">
                                <li v-for="i in days">
                                    <label>
                                        <input type="checkbox" />
                                        {{ i }}
                                    </label>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <label>Fri</label>
                            <ul class="list-unstyled">
                                <li v-for="i in days">
                                    <label>
                                        <input type="checkbox" />
                                        {{ i }}
                                    </label>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <label>Sat</label>
                            <ul class="list-unstyled">
                                <li v-for="i in days">
                                    <label>
                                        <input type="checkbox" />
                                        {{ i }}
                                    </label>
                                </li>
                            </ul>
                        </div>

                        <hr />

                        <div class="col-md-4">
                            <label>Sun</label>
                            <ul class="list-unstyled">
                                <li v-for="i in days">
                                    <label>
                                        <input type="checkbox" />
                                        {{ i }}
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <br/>
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
            this.fetchCategories();
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
                categories: false,
                loading: false,
                noresult: false,
                days: [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24]
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

            fetchCategories: function () {

                this.$http.get('/data/categories').then( response => {
                    this.categories = response;
                }, error => {
                    console.log(error);
                });
            }
        }
    }



</script>