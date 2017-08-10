<template>
    <div>
        <div class="row">
            <div class="col-md-8">
                <h1 class="title pull-left">The Account Name</h1>
                <p>the account id</p>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-md-6">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Account overview</th>
                        </tr>
                    </thead>
                    <tbody class="vcenter">
                        <tr v-show="loading == true">
                            <td colspan="10" class="loader text-center">
                                <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Country
                            </td>
                            <td>
                                account.id
                            </td>
                        </tr>
                        <tr>
                            <td>
                                City
                            </td>
                            <td>
                                {{ account.id }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Timezone
                            </td>
                            <td>
                                {{ account.id }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Language                    
                            </td>
                            <td>
                                {{ account.id }}
                            </td>
                        </tr>
                    </tbody>
                </table>  
            </div>
            <div class="col-md-6">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Acc. Name</th>
                            <th>Acc. Id</th>
                            <th>Status</th>
                            <th>Settings</th>
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
                        </tr>
                    </tbody>
                </table>  
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
        },

        data: function () {

            return {
                information: {},
                account: {},
                countriesList: {},
                timezonesList: {},
                languagesList: {},
                loading: false,
                noresult: false,
                token: false
            }
        },

        methods: {

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

                $('#_modal-create-new-account').modal();
            },

            createNewAccount: function () {
                this.loading = true;

                return this.$http.post(this.$root.api + 'accounts', this.account, {
                    headers: {
                        'Authorization': 'Bearer ' + this.token
                    }
                }).then(response => {

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

        }
    }

</script>
