<template>
    <div>

        <!-- HEADER START -->
        <div class="row">
            <div class="col-md-8">
                <h1 class="title pull-left">Accounts</h1>
                <button class="btn btn-default pull-right" @click="openCreateNewAccount()">
                    <i class="fa fa-plus"></i> Create new account
                </button>
            </div>
            <div class="col-md-4">
                <input 
                type="search" 
                class="form-control" 
                placeholder="Search account name..." 
                v-model="search_accounts"
                />
            </div>
        </div>
        <!-- HEADER END -->

        <hr/>

        <!-- ACCOUNTS START -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Acc. Name</th>
                    <th>Acc. Id</th>
                    <th>Status</th>
                    <th>Settings</th>
                    <th>Delete Account</th>
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
                
                <tr v-for="account in filtered_accounts">
                    <td>
                        <a :href="'/accounts/' + account.id">
                            {{ account.name }}
                        </a>
                    </td>
                    <td>{{ account.id }}</td>
                    <td>
                        <i :class="account.status ? 'fa fa-check' : 'fa fa-ban'"></i>
                    </td>
                    <td>
                        <button class="btn">
                            <i class="fa fa-cog"></i>
                        </button>
                    </td>
                    <td>
                        <button 
                        id="delete" 
                        :ref="account.id" 
                        class="btn btn-danger" 
                        @click="deleteAccount(account.id)"
                        >
                            <i class="fa fa-check-circle-o"></i>
                        </button>                    
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- ACCOUNTS END -->

        <!-- MODALS START -->
        <!-- CREATE NEW ACCOUNT START -->
        <div class="modal fade" id="_modal-create-new-account" tabindex="-1" role="dialog">
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
                        <h4 class="modal-title">Create New Account</h4>
                    </div>
                    <div class="modal-body">
                        <h5>DETAILS</h5>
                        <div class="form-group">
                            <label for="label-name">Name</label>
                            <br/>
                            <input 
                            type="text" 
                            id="label-name" 
                            class="form-control" 
                            v-model="new_account.name"
                            />
                        </div>
                        <div class="form-group">
                            <h5>LOCALIZATION</h5>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-12 col-md-3">
                                        <label for="label-country">Country</label>
                                        <br/>
                                        <select 
                                        class="form-control" 
                                        id="label-country" 
                                        v-model="new_account.country"
                                        >
                                            <option 
                                            v-for="country in countries.data" 
                                            :value="country.country"
                                            >
                                                {{ country.key }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-xs-12 col-md-3">
                                        <label for="label-city">City</label>
                                        <br/>
                                        <input 
                                        type="text" 
                                        class="form-control" 
                                        id="label-city" 
                                        v-model="new_account.city" 
                                        />
                                    </div>
                                    <div class="col-xs-12 col-md-3">
                                        <label for="label-timezones">Time Zone</label>
                                        <br/>
                                        <select 
                                        class="form-control" 
                                        id="label-timezones" 
                                        v-model="new_account.timezone"
                                        >
                                            <option 
                                            v-for="timezone in timezones.data" 
                                            :value="timezone.text">
                                                {{ timezone.text }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-xs-12 col-md-3">
                                        <label for="label-languages">Language</label>
                                        <br/>
                                        <select 
                                        class="form-control" 
                                        id="label-languages" 
                                        v-model="new_account.language"
                                        >
                                            <option 
                                            v-for="language in languages.data" 
                                            :value="language.abbr"
                                            >
                                                {{ language.name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <h5>BILLING DETAILS</h5>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-12 col-md-3">
                                        <label for="label-city">Company</label>
                                        <br/>
                                        <input 
                                        type="text" 
                                        class="form-control" 
                                        id="label-city" 
                                        v-model="new_account.company" 
                                        />
                                    </div>

                                    <div class="col-xs-12 col-md-3">
                                        <label for="label-city">Country</label>
                                        <br/>
                                        <input 
                                        type="text" 
                                        class="form-control" 
                                        id="label-city" 
                                        v-model="new_account.billing_country" 
                                        />
                                    </div>
                                    <div class="col-xs-12 col-md-3">
                                        <label for="label-timezones">City</label>
                                        <br/>
                                        <input 
                                        type="text" 
                                        class="form-control" 
                                        id="label-city" 
                                        v-model="new_account.billing_city" 
                                        />
                                    </div>
                                    <div class="col-xs-12 col-md-3">
                                        <label for="label-languages">Email</label>
                                        <br/>
                                        <input 
                                        type="text" 
                                        class="form-control" 
                                        id="label-city" 
                                        v-model="new_account.billing_email" 
                                        />
                                    </div>
                                    <div class="col-xs-12">
                                        <label for="label-languages">Address</label>
                                        <br/>
                                        <textarea 
                                        cols="40" 
                                        rows="5" 
                                        style="height: 100px" 
                                        type="text" 
                                        class="form-control" 
                                        id="label-city" 
                                        v-model="new_account.billing_address"
                                        >
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <label for="label-approved">Approved</label>
                                        <br/>
                                        <select 
                                        class="form-control" 
                                        id="label-approved" 
                                        v-model="new_account.status">
                                            <option value="1">Approved</option>
                                            <option value="0">Not Approved</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button 
                        type="button" 
                        class="btn btn-default" 
                        data-dismiss="modal" 
                        @click="cleanModalDetails()"
                        >
                            Close
                        </button>
                        <button 
                        type="button" 
                        class="btn btn-primary" 
                        data-dismiss="modal" 
                        @click="createNewAccount()"
                        >
                            Create
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- CREATE NEW ACCOUNT END -->
        <!-- MODALS END -->
    </div>
</template>

<script>
    export default {
        mounted() {
            this.getCountries();
            this.getTimezones();
            this.getLanguages();
        },

        data() {
            return {
                //ESSENTIALS
                token: '',     
                search_accounts: '',           

                //ACCOUNTS
                accounts: [],
                accounts_table_loading: true,
                accounts_table_empty: false,

                //CREATE NEW ACCOUNT
                new_account: {
                    name: '',
                    country: '',
                    city: '',
                    language: '',
                    timezone: '',
                    status: 1,
                    company: '',
                    billing_email: '',
                    billing_address: '',
                    billing_country: '',
                    billing_city: ''
                },
                countries: [],
                timezones: [],
                languages: [],
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

            //ACCOUNTS
            getAccounts() {
                axios.get(
                    this.$root.api + 'accounts',
                    this.$root.config
                ).then(response => {
                        this.accounts_table_empty = response.data.data == '' ? true : false;
                        this.accounts = response.data.data;
                        this.accounts_table_loading = false;
                    }, error => {
                        this.accounts_table_loading = false;
                    }
                );
            },

            deleteAccount(id) {
                this.buttonLoading('delete', true, id);

                axios.delete(
                    this.$root.api + 'accounts/' + id, 
                    this.$root.config
                ).then(response => {
                        this.buttonLoading('delete', false, id);
                        this.getAccounts();
                    }, error => {
                        this.buttonLoading('delete', false, id);
                        this.getAccounts();
                    }
                );
            },

            //CREATE NEW ACCOUNT
            openCreateNewAccount() {
                $('#_modal-create-new-account').modal();
            },

            getCountries() {
                axios.get(
                    '/data/countries.json'
                ).then(response => {
                        this.countries = response;
                    }, error => {

                    }
                );
            },

            getTimezones() {
                axios.get(
                    '/data/timezones.json'
                ).then(response => {
                        this.timezones = response;
                    }, error => {

                    }
                );
            },

            getLanguages() {
                axios.get(
                    '/data/languages.json'
                ).then(response => {
                        this.languages = response;
                    }, error => {

                    }
                );
            },

            cleanModalDetails() {
                this.new_account.name = '',
                this.new_account.country = '',
                this.new_account.city = '',
                this.new_account.language = '',
                this.new_account.status = 1,
                this.new_account.company = '',
                this.new_account.billing_email = '',
                this.new_account.billing_address = '',
                this.new_account.billing_country = '',
                this.new_account.billing_city = '',
                this.new_account.timezone = ''
            },

            createNewAccount() {
                axios.post(
                    this.$root.api + 'accounts', 
                    this.new_account, 
                    this.$root.config
                ).then(response => {
                        this.cleanModalDetails();
                        this.getAccounts();
                    }, error => {
                        this.cleanModalDetails();
                        this.getAccounts();
                    }
                );
            }
        },

        computed: {
            filtered_accounts() {
                var self = this;

                var results = this.accounts.filter(account => 
                    account.name.indexOf(self.search_accounts) != -1
                );
                this.accounts_table_empty = results == '' ? true : false;
                return results;
            }
        },

        watch: {
            token(value) {
                this.getAccounts();
            }
        }
    }

</script>
