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
        <hr />

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
                        Sorry but I can't find anything relating to <strong>{{ search | uppercase }}</strong>
                    </td>
                </tr>

                <tr v-for="account in filterByAccounts">
                    <td>{{ account.id }}.</td>
                    <td>{{ account.name }}</td>
                    <td>1000{{ account.id }}</td>
                    <td>rok@tapklik.com</td>
                    <td>
                        <button class="btn btn-primary">
                            View
                        </button>
                    </td>
                    <td>$1000.00</td>
                    <td>
                        <button class="btn btn-primary">
                            View
                        </button>
                    </td>
                    <td>
                        <button class="btn btn-primary">
                            View
                        </button>
                    </td>
                    <td>
                        <ul class="list-inline">
                            <li>
                                <i class="fa fa-play"></i>
                            </li>
                            <li>
                                <i class="fa fa-pause"></i>
                            </li>
                            <li>
                                <i class="fa fa-stop"></i>
                            </li>
                            <li>
                                <button class="btn btn-primary">Settings</button>
                            </li>
                        </ul>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="9">
                        <nav class="pull-right">
                            <ul class="pagination">
                                <li>
                                    <a href="#" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <li><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">4</a></li>
                                <li><a href="#">5</a></li>
                                <li>
                                    <a href="#" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </td>
                </tr>
            </tfoot>
        </table>
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
                search: '',
                loading: false,
                noresult: false
            }
        },

        methods: {

            fetchAccounts: function () {

                this.loading = true;

                this.$http.get(this.$root.api + 'campaigns').then( response => {
                    this.accounts = response.data;
                    this.loading = false;
                }, error => {
                    console.log(error);
                });
            }
        },

        computed: {
            filterByAccounts: function () {
                var self = this;

                if (typeof this.accounts.data == 'undefined') return;

                var results = this.accounts.data.filter( function(item) {

                    return item.name.toLowerCase().indexOf(self.search.toLowerCase()) > -1;
                });

                this.noresult = (!results.length) ? true : false;

                return results;
            },
        }
    }
</script>