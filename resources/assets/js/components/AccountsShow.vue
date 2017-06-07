<template>
    <div>
        <div class="row">
            <div class="col-xs-12">
                <h1 class="title pull-left">Accounts {{ account.name }}</h1>

                <button class="btn btn-default pull-right" @click="openCreateAccount()">
                    <i class="fa fa-plus"></i> Create new user
                </button>
            </div>
        </div>
        <hr/>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>
                    Name
                </th>
                <th>
                    Email
                </th>
                <th>
                    Phone
                </th>
                <th>
                    Status
                </th>
            </tr>
            </thead>
            <tbody>
                <tr v-for="user in users">
                    <td>
                        {{ user.first_name }} {{ user.last_name }}
                    </td>
                    <td>
                        {{ user.email }}
                    </td>
                    <td>
                        {{ user.phone ? user.phone : 'N/A' }}
                    </td>
                    <td>
                        <i class="fa fa-check" v-show="user.status == 1"></i>
                        <i class="fa fa-ban" v-show="!user.status"></i>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="modal fade" id="_modal-create-new-user" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Create New User</h4>
                    </div>
                    <div class="modal-body">
                        <h5>DETAILS</h5>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-12 col-md-6">
                                    <label for="label-first-name">First Name</label>
                                    <br/>
                                    <input type="text" id="label-first-name" class="form-control" v-model="user.first_name"/>
                                </div>
                                <div class="col-xs-12 col-md-6">
                                    <label for="label-last-name">Last Name</label>
                                    <br/>
                                    <input type="text" id="label-last-name" class="form-control" v-model="user.last_name"/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-12 col-md-6">
                                        <label for="label-email">E-mail</label>
                                        <br/>
                                        <input type="text" class="form-control" id="label-email" v-model="user.email"/>
                                    </div>

                                    <div class="col-xs-12 col-md-6">
                                        <label for="label-phone-number">Phone number</label>
                                        <br/>
                                        <input type="text" class="form-control" id="label-phone-number" v-model="user.phone" />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <label for="label-password">Password</label>
                                        <br/>
                                        <input type="password" class="form-control" id="label-password" v-model="user.password"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="createNewUser()">Create</button>
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
                account: {},
                users: {},
                user: {
                    first_name: '',
                    last_name: '',
                    email: '',
                    phone: '',
                    password: ''
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

            fetchUsers: function () {
                this.loading = true;
                var self = this;
                var accountId = window.location.pathname.replace('\/accounts\/', '');

                this.$http.get(this.$root.api + 'accounts/' + accountId + '/users', {
                    headers: {
                        'Authorization': 'Bearer ' + self.token
                    }
                }).then( response => {
                    this.users = response.data.data;

                    this.loading = false;
                }, error => {
                    alert(error);
                });
            },

            fetchAccount: function () {

                this.loading = true;
                var self = this;
                var accountId = window.location.pathname.replace('\/accounts\/', '');

                this.$http.get(this.$root.api + 'accounts/' + accountId, {
                    headers: {
                        'Authorization': 'Bearer ' + self.token
                    }
                }).then( response => {
                    this.account = response.data.data;

                    this.loading = false;
                }, error => {
                    console.log(error);
                });
            },

            fetchCountries: function () {

                this.$http.get('/data/countries').then( response => {
                    this.countriesList = response;
                }, error => {
                    console.log(error);
                });
            },

            fetchTimezones: function () {

                this.$http.get('/data/timezones').then( response => {
                    this.timezonesList = response;
                }, error => {
                    console.log(error);
                });
            },

            fetchLanguages: function () {

                this.$http.get('/data/languages').then( response => {
                    this.languagesList = response;
                }, error => {
                    console.log(error);
                });
            },

            openUsers(id) {

                this.loading = true;

                this.$http.get(this.$root.api + 'accounts/' + id + '/users').then( response => {

                    this.loading = false;

                    this.users = response.data;

                    $('#_modal-users').modal();

                }, error => {
                    alert(error);
                });
            },

            openSettings(id) {

                this.loading = true;

                this.$http.get(this.$root.api + 'accounts/' + id).then(response => {

                    this.account = response.data;
                    this.loading = false;

                    $('#_modal-edit-account').modal();
                }, error => {
                    console.log(error);
                });
            },

            openCreateAccount() {

                $('#_modal-create-new-user').modal();
            },

            createNewUser: function () {
                this.loading = true;

                return this.$http.post(this.$root.api + 'accounts/' + this.account.id + '/users', this.user, {
                    headers: {
                        'Authorization': 'Bearer ' + this.token
                    }
                }).then(response => {

                    this.fetchUsers();
                    this.loading = false;
                    this.account = false;
                    this.closeModal();
                }, error => {

                    this.loading = false;
                    this.closeModal();
                });
            },

            closeModal() {
                $('#_modal-create-new-user').modal('close');
            },

            toggleStatus(id, status, index) {

                status = (1 == status) ? 0 : 1;
                this.accounts.data[index].status = status;

                this.$http.put(this.$root.api + 'accounts/' + id, {status: status}).then(response => {
                    this.fetchAccounts();
                }, error => {
                    swal('Error', error, 'error');
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
            token: function (value) {
                this.fetchAccount();
                this.fetchUsers();
            }
        }
    }

</script>
