<template>
    <div>

        <div class="row" style="padding-left: 16px; padding-right: 16px;">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row" style="display: flex; align-items: center;">
                        <div class="col-md-4">
                            Accounts
                        </div>

                        <div class="col-md-8">
                            <button 
                            class="btn btn-default pull-right" 
                            @click="openCreateNewAccount()"
                            >
                                <i class="fa fa-plus"></i> Create new account
                            </button>
                        </div>
                        <div class="col-md-4">
                            <input 
                            type="search" 
                            class="form-control" 
                            placeholder="Search account name..." 
                            v-model="accounts.search"
                            />
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Acc. Name</th>
                                <th>Acc. Id</th>
                                <th>F</th>
                                <th>V</th>
                                <th>Status</th>
                                <th>Actions</th>

                            </tr>
                        </thead>
                        <tbody class="vcenter">
                            
                            <!-- TABLE LOADER START -->
                            <tr v-if="accounts.loading">
                                <td colspan="11" class="loader text-center">
                                    <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
                                </td>
                            </tr>
                            <!-- TABLE LOADER END -->
                            
                            <!-- EMPTY TABLE MESSAGE START -->
                            <tr v-else-if="accounts.empty">
                                <td colspan="11">
                                    <span v-if="accounts.search.length === 0">There are no accounts</span>
                                    <span v-else>Can't find anything related to <strong>{{ accounts.search }}</strong></span>
                                </td>
                            </tr>
                            <!-- EMPTY TABLE MESSAGE END -->
                            
                            <tr v-else v-for="account in filtered_accounts">
                                <td>
                                    <a :href="'/accounts/' + account.id">
                                        {{ account.name }}
                                    </a>
                                </td>
                                <td>{{ account.id }}</td>
                                <td> 
                                    <input 
                                    type="text" 
                                    v-model="account.fees.fixed" 
                                    @blur="updateFees(account.fees, account.id)" 
                                    /> 
                                </td>
                                <td> 
                                    <input 
                                    type="text" 
                                    v-model="account.fees.variable" 
                                    @blur="updateFees(account.fees, account.id)"
                                    /> 
                                </td>
                                <td>
                                    <button 
                                    class="btn" 
                                    :class="account.status ? 'btn-success' : 'btn-danger'" 
                                    @click="toggleAccountStatus(account.status, account.id, $event)" 
                                    >
                                        <i class="fa fa-check-circle-o"></i>
                                    </button>
                                </td>
                                <td>
                                    <button class="btn">
                                        <i class="fa fa-cog"></i>
                                    </button>
                                    <button 
                                    class="btn btn-danger" 
                                    @click="deleteAccount(account.id, $event)"
                                    >
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

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
                                            v-for="country in list.countries" 
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
                                            v-for="timezone in list.timezones" 
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
                                            v-for="language in list.languages" 
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
                                        <label for="label-country">Country</label>
                                        <br/>
                                        <select 
                                        class="form-control" 
                                        id="label-country" 
                                        v-model="new_account.billing_country"
                                        >
                                            <option 
                                            v-for="country in list.countries" 
                                            :value="country.country"
                                            >
                                                {{ country.key }}
                                            </option>
                                        </select>
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
        data() {
            return {
                //ESSENTIALS
                token: '',     
                
                //ACCOUNTS
                accounts: {
                    search: '',
                    empty: false,
                    loading: true
                },

                list: {
                    countries: [],
                    timezones: [],
                    languages: [],
                    accounts: []
                },

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
            }
        },

        methods: {
            getLists() {
                this.getAccounts();
                this.getCountries();
                this.getTimezones();
                this.getLanguages();
            },

            getAccounts() {
                axios.get(
                    this.$root.api + '/accounts',
                    this.$root.config
                ).then(response => {
                        this.list.accounts = response.data.data;
                        this.accounts.empty = this.list.accounts.length > 0 ? false : true;
                        this.accounts.loading = false;
                    }, error => {
                        this.accounts.loading = false;
                    }
                );
            },

            getCountries() {
                axios.get(
                    '/data/countries.json'
                ).then(response => {
                        this.list.countries = response.data;
                    }, error => {

                    }
                );
            },

            getTimezones() {
                axios.get(
                    '/data/timezones.json'
                ).then(response => {
                        this.list.timezones = response.data;
                    }, error => {

                    }
                );
            },

            getLanguages() {
                axios.get(
                    '/data/languages.json'
                ).then(response => {
                        this.list.languages = response.data;
                    }, error => {

                    }
                );
            },

            createNewAccount() {
                this.accounts.loading = true;
                axios.post(
                    this.$root.api + '/accounts', 
                    this.new_account, 
                    this.$root.config
                ).then(response => {
                        this.getAccounts();
                    }, error => {
                        this.getAccounts();
                    }
                );
            },

            deleteAccount(id, event) {
                var image = this.$root.clickedButton(event);
                image.className = 'fa fa-circle-o-notch fa-spin';

                axios.delete(
                    this.$root.api + '/accounts/' + id, 
                    this.$root.config
                ).then(response => {
                        this.getAccounts();
                        image.className = "fa fa-trash";
                    }, error => {
                        this.getAccounts();
                        image.className = "fa fa-trash";
                    }
                );
            },

            toggleAccountStatus(status ,id, event) {
                var payload = {
                    status: status ? 0 : 1
                };
                var image = this.$root.clickedButton(event);
                image.className = 'fa fa-circle-o-notch fa-spin';

                axios.put(
                    this.$root.api + '/accounts/' + id,
                    payload,
                    this.$root.config
                ).then(response => {
                        this.getAccounts();
                        image.className = "fa fa-check-circle-o";
                    }, error => {
                        this.getAccounts();
                        image.className ="fa fa-check-circle-o";
                    }
                );
            },

            updateFees(fees, id) {
                var payload = {
                    fee_fixed: fees.fixed,
                    fee_variable: fees.variable
                };
                axios.put(
                    this.$root.api + '/accounts/' + id + '/fees',
                    payload,
                    this.$root.config
                ).then(response => {
                        this.getAccounts();
                    }, error => {
                        this.getAccounts();
                    }
                );
            },

            openCreateNewAccount() {
                $('#_modal-create-new-account').modal();
            }
        },

        computed: {
            filtered_accounts() {
                var self = this;

                var results = this.list.accounts.filter(account => 
                    account.name.toLowerCase().indexOf(self.accounts.search) != -1
                );

                return results;
            }
        },

        watch: {
            token(value) {
                this.getLists();
            },

            filtered_accounts(value) {
                this.accounts.empty = value.length > 0 ? false : true;
            }
        }
    }
</script>