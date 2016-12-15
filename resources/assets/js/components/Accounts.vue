<template>
    <div>
        <div class="row">
            <div class="col-md-8">
                <h1 class="title">Accounts</h1>
            </div>
            <div class="col-md-4">
                <input type="search" class="form-control" placeholder="Search account name..." v-model="search"/>
            </div>
        </div>
        <hr/>

        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Acc. Name</th>
                <th>Acc. Id</th>
                <th>Acc. Manager</th>
                <th>Users</th>
                <th>Budget</th>
                <th>Campaigns</th>
                <th>Creatives</th>
                <th>Status</th>
                <th>Settings</th>
            </tr>
            </thead>
            <tbody class="vcenter">
            <tr v-show="loading == true">
                <td colspan="9" class="loader text-center">
                    <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
                </td>
            </tr>
            <tr v-show="noresult">
                <td colspan="9">
                    Sorry but I can't find anything relating to <strong>{{ search }}</strong>
                </td>
            </tr>

            <tr v-for="account in filterByAccounts">
                <td>{{ account.id }}.</td>
                <td>{{ account.name }}</td>
                <td>1000{{ account.id }}</td>
                <td>rok@tapklik.com</td>
                <td>
                    <button class="btn btn-primary" @click="openUsers(account.id)">
                        View
                    </button>
                </td>
                <td>${{ account.budget.data.value }}</td>
                <td>
                    <a :href="account.id" class="btn btn-primary">
                        View
                    </a>
                </td>
                <td>
                    <button class="btn btn-primary">
                        View
                    </button>
                </td>
                <td>
                    <button class="btn btn-success">
                        <i class="fa fa-check-circle-o"></i>
                    </button>
                </td>
                <td>
                    <button class="btn btn-default">
                        <i class="fa fa-cog"></i>
                    </button>
                </td>
            </tr>
            </tbody>
        </table>

        <div class="modal fade" id="_modal-users" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Modal title</h4>
                    </div>
                    <div class="modal-body">
                        <input type="search" placeholder="Search user by name" class="form-control" v-model="searchUsers" />
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Username</th>
                                <th>&nbsp;</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="user in filterByUsers">
                                <td>{{ user.id }}</td>
                                <td>{{ user.first_name }} {{ user.last_name }}</td>
                                <td class="text-right">
                                    <a href="#" class="btn btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>
</template>

<script>
    export default {
        mounted() {

            this.fetchAccounts();
        },

        data: function () {

            return {
                accounts: {},
                users: {},
                search: '',
                searchUsers: '',
                loading: false,
                noresult: false
            }
        },

        methods: {

            fetchAccounts: function () {

                this.loading = true;

                this.$http.get(this.$root.api + 'accounts').then( response => {
                    this.accounts = response.data;
                    this.loading = false;
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
            }
        },

        computed: {

            filterByAccounts: function () {

                if (typeof this.accounts.data == 'undefined') return;

                var self = this;

                var results = this.accounts.data.filter( function(item) {

                    return item.name.toLowerCase().indexOf(self.search.toLowerCase()) > -1;
                });

                this.noresult = (!results.length) ? true : false;

                return results;
            },

            filterByUsers() {
                if (typeof this.users.data == 'undefined') return;

                var self = this;

                var results = this.users.data.filter( function(item) {

                    return item.first_name.toLowerCase().indexOf(self.searchUsers.toLowerCase()) > -1;
                });

                //this.noresult = (!results.length) ? true : false;

                return results;
            }
        }
    }



</script>