<template>
    <div>

        <!-- HEADER START -->
        <div class="row">
            <div class="col-md-8">
                <h1 class="title pull-left">GRAPHS</h1>
            </div>
            <div class="col-md-4">
                <select class="btn btn-default" v-model="selected_time">
                    <option :value="-1">1 hour</option>
                    <option :value="-12">12 hours</option>
                    <option :value="-72">3 days</option>
                </select>
                <button 
                class="btn btn-default" 
                @click="openModal('#_modal-select-accounts')"> 
                    <i class="fa fa-filter"></i> ACCOUNTS!
                </button>
                <button 
                class="btn btn-default" 
                @click="openModal('#_modal-select-campaigns')"> 
                    <i class="fa fa-filter"></i> CAMPAIGNS!
                </button>
            </div>
        </div>
        <!-- HEADER END -->

        <hr />

        <!-- GRAPH START -->
        <iframe 
        :src="full_query"
        width="900" 
        height="400" 
        frameborder="0"
        ></iframe>
        <!-- GRAPH END -->

        <!-- MODALS START -->
        <!-- SELECT ACCOUNTS MODAL START -->
        <div class="modal fade" id="_modal-select-accounts" tabindex="-1" role="dialog">
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
                        <h4 class="modal-title">Select Accounts</h4>
                    </div>
                    <div class="modal-body">
                        <h5>Accounts</h5>
                        <div class="row">
                            <div v-for="account in accounts" :key="account.id" class="col-xs-4">
                                <input
                                type="checkbox" 
                                v-model="selected_accounts" 
                                :value="account.id"
                                />
                                <label> {{ account.id }} </label>
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
                    </div>
                </div>
            </div>
        </div>
        <!-- SELECT ACCOUNTS MODAL END -->

        <!-- SELECT CAMPAIGNS MODAL START -->
        <div class="modal fade" id="_modal-select-campaigns" tabindex="-1" role="dialog">
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
                        <h4 class="modal-title">Select Campaigns</h4>
                    </div>
                    <div class="modal-body">
                        <h5>Campaigns</h5>
                        <div class="row">
                            <div v-for="campaign in campaigns" :key="campaign.id" class="col-xs-4">
                                <input
                                type="checkbox" 
                                v-model="selected_campaigns" 
                                :value="campaign.id"
                                />
                                <label> {{ campaign.id }} </label>
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
                    </div>
                </div>
            </div>
        </div>
        <!-- SELECT CAMPAIGNS MODAL END -->
        <!-- MODALS END -->
        
    </div>
</template>
<script>
    export default {

        data() {
        	return {
                //ESSENTIALS
                token: '',
                iframe_url: 'https://www.hostedgraphite.com/93a2a8a9/2fb25eb8-3683-479b-a7d0-abaa7bb31938/grafana/dashboard-solo/db/campaigns',

                //QUERY PARAMETERS
                accounts: [],
                selected_accounts: [],
                campaigns: [],
                selected_campaigns: [],
                selected_time: -1,
        		date_from: this.getDate(-1),
        		date_to: this.getDate(0)
        	}
        },

        methods: {
            //OVERALL
            openModal(id) {
                $(id).modal();
            },

            getAccounts() {
                axios.get(
                    this.$root.api + 'accounts',
                    this.$root.config
                ).then(response => {
                        this.accounts = response.data.data;
                    }, error => {

                    }
                );
            },

            getCampaigns() {
                axios.get(
                    this.$root.api + 'campaigns', 
                    this.$root.config
                ).then(response => {
                        this.campaigns = response.data.data;
                    }, error => {

                    }
                );
            },

            getDate(hours) {
                if(!days) var days = 0;
                if(!hours) var hours = 0;
                var today = new Date;
                var selected_day = new Date;
                selected_day.setHours(today.getHours() + hours);
                var stringify_day = selected_day.toString();
                return stringify_day;
            },

            //QUERY PARAMETERS
            queryForDates() {
                this.date_from = this.date_from.replace("(CET)", "");
                this.date_to = this.date_to.replace("(CET)", "");
                return 'from=' + this.date_from + '&to=' + this.date_to;
            },

            queryForSelectedAccounts() {
                if(this.selected_accounts == '') return 'var-Account=All';
                var accounts = this.selected_accounts.map(account => 'var-Account=' + account);
                return accounts.join('&');
            },

            queryforSelectedCampaigns() {
                if(this.selected_campaigns == '') return 'var-Cmp=All';
                var campaigns = this.selected_campaigns.map(campaign => 'var-Cmp=' + campaign);
                return campaigns.join('&');
            }

        },

        computed: {
            full_query() {
                return this.iframe_url + '?' + this.queryForSelectedAccounts() + '&' + this.queryforSelectedCampaigns() + '&' + this.queryForDates() + '&panelId=55&fullscreen';
            }
        },
        watch: {
            token(value) {
                this.getAccounts();
                this.getCampaigns();
            },

            selected_time(value) {
                this.date_from = this.getDate(value);
            }
        }
    }
</script>