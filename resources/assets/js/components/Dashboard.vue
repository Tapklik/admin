<template>
	<div>

        <!-- HEADER START -->
        <div class="row">
            <div class="col-xs-12">
                <h1 class="title">Dashboard</h1>
            </div>
        </div>
        <!-- HEADER END -->

        <hr />

        <!-- ACCOUNTS START -->
        <div class="row">
            <div class="col-xs-12">
                <h2>Accounts</h2>
            </div>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Acc. Name</th>
                    <th>Acc. Id</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="vcenter">
                
                <!-- TABLE LOADER START -->
                <tr v-if="accounts_table_loading">
                    <td colspan="11" class="loader text-center">
                        <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
                    </td>
                </tr>
                <!-- TABLE LOADER END -->
                
                <!-- EMPTY TABLE MESSAGE START -->
                <tr v-else-if="accounts_table_empty">
                    <td colspan="11">
                        Sorry but I can't find anything relating to <strong>{{ search_accounts }}</strong>
                    </td>
                </tr>
                <!-- EMPTY TABLE MESSAGE END -->
                
                <tr v-else v-for="account in accounts">
                    <td>
                        <a :href="'/accounts/' + account.id">
                            {{ account.name }}
                        </a>
                    </td>
                    <td>{{ account.id }}</td>
                    <td>
                        <button 
                        id="toggle"
                        :ref="account.id"
                        class="btn" 
                        :class="account.status ? 'btn-success' : 'btn-danger'" 
                        @click="toggleAccountStatus(account.status, account.id)" 
                        >
                            <i class="fa fa-check-circle-o"></i>
                        </button>
                    </td>
                    <td>
                        <button class="btn">
                            <i class="fa fa-cog"></i>
                        </button>
                        <button 
                        id="delete" 
                        :ref="account.id" 
                        class="btn btn-danger" 
                        @click="deleteAccount(account.id)"
                        >
                            <i class="fa fa-trash"></i>
                        </button>                    
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- ACCOUNTS END -->

        <hr />

		<!-- CAMPAIGNS START -->
        <div class="row">
            <div class="col-xs-12">
                <h2>Campaigns</h2>
            </div>
        </div>
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
                    <th>Status</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody class="vcenter">

                <!-- TABLE LOADER START -->
                <tr v-show="campaigns_table_loading">
                    <td colspan="11" class="loader text-center">
                        <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
                    </td>
                </tr>
                <!-- TABLE LOADER END -->
                
                <!-- EMPTY TABLE MESSAGE START -->
                <tr v-show="campaigns_table_empty">
                    <td colspan="11">
                        Sorry but theres nothing here... yet :)
                    </td>
                </tr>
                <!-- EMPTY TABLE MESSAGE END -->

                <tr v-for="campaign in campaigns">
                    <td>{{ campaign.id }}</td>
                    <td>
                        <a :href="'/accounts/' + campaign.account.data.id + '/campaigns/' + campaign.id">
                            {{ campaign.name }}
                        </a>
                    </td>
                    <td>{{ campaign.start_time }}</td>
                    <td>{{ campaign.end_time }}</td>
                    <td>
                        <a :href="'http://' + campaign.adomain" target="_blank">
                            {{ campaign.adomain }}
                        </a>
                    </td>
                    <td>
                        <a :href="campaign.ctrurl" target="_blank">
                            {{ campaign.ctrurl }}
                        </a>
                    </td>
                    <td>${{ $root.fromMicroDollars(campaign.budget.data.amount) }}</td>
                    <td>${{ $root.fromMicroDollars(campaign.bid) }}</td>
                    <td>
                        <a 
                        :href="'/accounts/' + account_id + '/campaigns/' + campaign.id + '/creatives'" 
                        class="btn btn-primary"
                        >
                            View
                        </a>
                    </td>
                    <td>
                        <a 
                        @click="openModal('#_modal-show-json', campaign)" 
                        class="btn btn-primary" 
                        target="_blank"
                        >
                            View
                        </a>
                    </td>
                    <td>
                        <select  
                        @change="toggleCampaignStatus(campaign.id, campaign.status)" 
                        v-model="campaign.status">
                            <option v-for="status in statuses" :value="status">{{ status }}</option>
                        </select>
                    </td>
                    <td>
                        <button 
                        id="delete"
                        :ref="campaign.id"
                        :disabled="campaign.status != 'draft'"  
                        class="btn btn-danger" 
                        @click="deleteCampaign(campaign.id)"
                        >
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- CAMPAIGNS END -->

        <!-- MODALS START -->
        <!-- CAMPAIGN JSON MODAL START-->
        <div class="modal fade" id="_modal-show-json" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">JSON</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            {{opened_json}}
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
                        <button 
                        type="button" 
                        class="btn btn-primary" 
                        data-dismiss="modal" 
                        @click="createNewUser()"
                        >
                            Create
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- CAMPAIGN JSON MODAL END--> 
        <!-- MODALS END -->

	</div>
</template>

<script>
	export default {
        data() {
            return {
                //ESSENTIALS
                token: '',

                //CAMPAIGNS
                campaigns: [],
                opened_json: {},
                campaigns_table_loading: true,
                campaigns_table_empty: false,
                statuses: ['active', 'paused', 'archived', 'draft', 'not started', 'expired'],

                //ACCOUNTS
                accounts: [],
                accounts_table_loading: true,
                accounts_table_empty: false,
            }
        },

        methods: {

            //OVERALL        
            buttonLoading(action, condition, id) {
                for(var button in this.$refs[id]) {
                    var targetted_button = this.$refs[id][button].id == action ? button : targetted_button;
                }
                condition ? this.$refs[id][targetted_button].children[0].className = 'fa fa-circle-o-notch fa-spin' : 
                            this.$refs[id][targetted_button].children[0].className = 'fa fa-check-circle-o';
            },

            openModal(identifier, json) {
                this.opened_json = json ? json : '';
                $(identifier).modal();
            },

            filterDataSize(number_of_items, dataset) {
            	var excess = dataset.length - number_of_items; //look for number of items that are more than required
            	if(excess > 0) dataset.splice(number_of_items, excess); //delete those items
            	return dataset;
            },

            //ACCOUNTS
            getAccounts(id) {
                axios.get(
                    this.$root.api + '/accounts',
                    this.$root.config
                ).then(response => {
                        this.accounts_table_empty = response.data.data == '' ? true : false;
                        this.accounts = this.filterDataSize(10, response.data.data);
                        this.accounts_table_loading = false;
                        if(id) this.buttonLoading("delete", false, id);
                    }, error => {
                        this.accounts_table_loading = false;
                    }
                );
            },

            toggleAccountStatus(status ,id) {
                var status = status ? 0 : 1;
                this.buttonLoading('toggle', true, id);

                axios.put(
                    this.$root.api + '/accounts/' + id,
                    { status: status },
                    this.$root.config
                ).then(reponse => {
                        this.getAccounts(id);
                    }, error => {
                        this.getAccounts(id);
                    }
                );
            },

            deleteAccount(id) {
                this.buttonLoading('delete', true, id);

                axios.delete(
                    this.$root.api + '/accounts/' + id, 
                    this.$root.config
                ).then(response => {
                        this.getAccounts(id);
                    }, error => {
                        this.getAccounts(id);
                    }
                );
            },

            //CAMPAIGNS
            getCampaigns(id) {
                axios.get(
                    this.$root.api + '/campaigns?include=account', 
                    this.$root.config
                ).then(response => {
                        this.campaigns_table_empty = response.data.data == '' ? true : false;
                        this.campaigns = this.filterDataSize(10, response.data.data);
                        this.campaigns_table_loading = false;
                        if(id) this.buttonLoading('delete', false, id);
                    }, error => {
                        this.campaigns_table_loading = false;
                    }
                );
            },

            deleteCampaign(id) {
                this.buttonLoading('delete', true, id);

                axios.delete(
                    this.$root.api + '/campaigns/' + id, 
                    this.$root.config
                ).then(response => {
                        this.getCampaigns(id);        
                    }, error => {
                        this.getCampaigns(id);
                    }
                );
            },

            toggleCampaignStatus(id, status) {
                axios.put(
                    this.$root.api + '/campaigns/' + id, 
                    {status: status}, 
                    this.$root.config
                ).then(response => {
                        this.getCampaigns();
                    }, error => {
                        this.getCampaigns();
                    }
                );
            }
        },

        watch: {
            token(value) {
        		this.getCampaigns();
        		this.getAccounts();
            }
        }
    }
</script>