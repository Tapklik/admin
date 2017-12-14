<template>
    <div>
        <div class="row">
            <div class="col-md-8">
                <h1 class="title pull-left">Accounthjks</h1>

                <button class="btn btn-default pull-right" @click="openCreateAccount()">
                    <i class="fa fa-plus"></i> Create new account
                </button>
            </div>
            <div class="col-md-4">
                <input type="search" class="form-control" placeholder="Search account name..." v-model="search"/>
            </div>
        </div>
        <hr/>
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
            <tr v-show="loading == true">
                <td colspan="10" class="loader text-center">
                    <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
                </td>
            </tr>
            <tr v-show="noresult">
                <td colspan="9">
                    Sorry but I can't find anything relating to <strong>{{ search }}</strong>
                </td>
            </tr>
            <tr v-for="account in accounts">
                <td>
                    <a :href="'/accounts/' + account.id">
                        {{ account.name }}
                    </a>
                </td>
                <td>
                    {{ account.id }}
                </td>
                <td>
                    <i class="fa fa-check" v-show="account.status == 1"></i>
                    <i class="fa fa-ban" v-show="!account.status"></i>
                </td>
                <td>
                    <button class="btn">
                        <i class="fa fa-cog"></i>
                    </button>
                </td>
                <td>
                    <button class="btn btn-danger" @click="deleteAccount(account.id)">
                        <i class="fa fa-check-circle-o"></i>
                    </button>                    
                </td>
            </tr>
            </tbody>
        </table>

        <div class="modal fade" id="_modal-create-new-account" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Create New Account</h4>
                    </div>
                    <div class="modal-body">
                        <h5>DETAILS</h5>
                        <div class="form-group">
                            <label for="label-name">Name</label>
                            <br/>
                            <input type="text" id="label-name" class="form-control" v-model="account.name"/>
                        </div>

                        <div class="form-group">
                            <h5>LOCALIZATION</h5>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-12 col-md-3">
                                        <label for="label-country">Country</label>
                                        <br/>
                                        <select class="form-control" id="label-country" v-model="account.country">
                                            <option v-for="country in countriesList.data" :value="country.country">
                                                {{ country.key }}
                                            </option>
                                        </select>
                                    </div>

                                    <div class="col-xs-12 col-md-3">
                                        <label for="label-city">City</label>
                                        <br/>
                                        <input type="text" class="form-control" id="label-city" v-model="account.city" />
                                    </div>

                                    <div class="col-xs-12 col-md-3">
                                        <label for="label-timezones">Time Zone</label>
                                        <br/>
                                        <select class="form-control" id="label-timezones" v-model="account.timezone">
                                            <option v-for="timezone in timezonesList.data" :value="timezone.text">
                                                {{ timezone.text }}
                                            </option>
                                        </select>
                                    </div>

                                    <div class="col-xs-12 col-md-3">
                                        <label for="label-languages">Language</label>
                                        <br/>
                                        <select class="form-control" id="label-languages" v-model="account.language">
                                            <option v-for="language in languagesList.data" :value="language.abbr">
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
                                        <input type="text" class="form-control" id="label-city" v-model="account.company" />
                                    </div>

                                    <div class="col-xs-12 col-md-3">
                                        <label for="label-city">Country</label>
                                        <br/>
                                        <input type="text" class="form-control" id="label-city" v-model="account.billing_country" />
                                    </div>
                                    <div class="col-xs-12 col-md-3">
                                        <label for="label-timezones">City</label>
                                        <br/>
                                        <input type="text" class="form-control" id="label-city" v-model="account.billing_city" />
                                    </div>
                                    <div class="col-xs-12 col-md-3">
                                        <label for="label-languages">Email</label>
                                        <br/>
                                        <input type="text" class="form-control" id="label-city" v-model="account.billing_email" />
                                    </div>
                                    <div class="col-xs-12">
                                        <label for="label-languages">Address</label>
                                        <br/>
                                        <textarea cols="40" rows="5" style="height: 100px" type="text" class="form-control" id="label-city" v-model="account.billing_address" /></textarea>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <label for="label-approved">Approved</label>
                                        <br/>
                                        <select class="form-control" id="label-approved" v-model="account.status">
                                            <option value="1">Approved</option>
                                            <option value="0">Not Approved</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" @click="cleanModalDetails()">Close</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal" @click="createNewAccount()">Create</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>
</template>

<script>
    export default {
        mounted() {

            this.fetchCountries();
            this.fetchTimezones();
            this.fetchLanguages();
        },

        data: function () {

            return {
                accounts: {},
                account: {
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
                countriesList: {},
                timezonesList: {},
                languagesList: {},
                loading: false,
                noresult: false,
                token: false
            }
        },

        methods: {
            cleanModalDetails() {
                this.account.name = '',
                this.account.country = '',
                this.account.city = '',
                this.account.language = '',
                this.account.status = 1,
                this.account.company = '',
                this.account.billing_email = '',
                this.account.billing_address = '',
                this.account.billing_country = '',
                this.account.billing_city = '',
                this.account.timezone = ''
            },
    
            fetchAccounts(token) {

                this.loading = true;
                var self = this;

                axios.get(this.$root.api + 'accounts',this.$root.config).then( response => {
                    this.accounts = response.data.data;

                    this.loading = false;
                }, error => {
                    console.log(error);
                });
            },

            fetchCountries() {

                axios.get('/data/countries.json').then(response => {
                    this.countriesList = response;
                }, error => {
                    console.log(error);
                });
            },

            fetchTimezones() {

                axios.get('/data/timezones.json').then( response => {
                    this.timezonesList = response;
                }, error => {
                    console.log(error);
                });
            },

            fetchLanguages() {

                axios.get('/data/languages.json').then( response => {
                    this.languagesList = response;
                }, error => {
                    console.log(error);
                });
            },

            deleteAccount(id) {

                axios.delete(this.$root.api + 'accounts/' + id, this.$root.config).then( response => {
                    this.fetchAccounts();
                }, error => {
                    alert(error);
                });
            },

            openUsers(id) {

                this.loading = true;

                axios.get(this.$root.api + 'accounts/' + id + '/users', this.$root.config).then( response => {

                    this.loading = false;

                    this.users = response.data;

                    $('#_modal-users').modal();

                }, error => {
                    alert(error);
                });
            },

            openSettings(id) {

                this.loading = true;

                axios.get(this.$root.api + 'accounts/' + id, this.$root.config).then(response => {

                    this.account = response.data;
                    this.loading = false;

                    $('#_modal-edit-account').modal();
                }, error => {
                    console.log(error);
                });
            },

            openCreateAccount() {

                $('#_modal-create-new-account').modal();
            },

            createNewAccount() {
                this.loading = true;

                return axios.post(this.$root.api + 'accounts', this.account, this.$root.config).then(response => {
                    this.cleanModalDetails();
                    this.fetchAccounts();
                    this.loading = false;
                    this.account = false;
                    this.closeModal();
                }, error => {

                    this.loading = false;
                    this.closeModal();
                });
            },

            closeModal() {
                $('#_modal-create-new-account').modal('close');
            },

            toggleStatus(id, status, index) {

                status = (1 == status) ? 0 : 1;
                this.accounts.data[index].status = status;

                axios.put(this.$root.api + 'accounts/' + id, {status: status}, this.$root.config).then(response => {
                    this.fetchAccounts();
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
            }
        },

        computed: {

            filterByUsers() {
                if (typeof this.users.data == 'undefined') return;

                var self = this;

                var results = this.users.data.filter( function(item) {

                    return item.first_name.toLowerCase().indexOf(self.searchUsers.toLowerCase()) > -1;
                });

                return results;
            }
        },

        watch: {
            token(value) {
                this.fetchAccounts();
            }
        }
    }

</script>
