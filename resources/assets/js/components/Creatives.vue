<template>
    <div>
        <div class="row">
            <div class="col-md-8">
                <h1 class="title pull-left">Creatives for Campaign {{ campaign.data.name }}</h1>

                <button class="btn btn-default pull-right" @click="openCreateAccount()">
                    <i class="fa fa-plus"></i> Create new creative
                </button>
            </div>
            <div class="col-md-4">
                <input type="search" class="form-control" placeholder="Search creative by name..." v-model="search"/>
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
                <td colspan="10" class="loader text-center">
                    <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
                </td>
            </tr>
            <tr v-show="noresult">
                <td colspan="9">
                    Sorry but I can't find anything relating to <strong>{{ search }}</strong>
                </td>
            </tr>

            <tr v-for="(creative, index) in filterByCreatives">
                <td>{{ creative.id }}.</td>
                <td>{{ creative.name }}</td>
                <td>1000{{ creative.id }}</td>
                <td>rok@tapklik.com</td>
                <td>
                    <button class="btn btn-primary" @click="openUsers(creative.id)">
                        View
                    </button>
                </td>
                <td>${{ creative.budget.data.value }}</td>
                <td>
                    <a :href="generateUri('campaigns', creative.id)" class="btn btn-primary">
                        View
                    </a>
                </td>
                <td>
                    <a :href="generateUri('creatives', creative.id)" class="btn btn-primary">
                        View
                    </a>
                </td>
                <td>
                    <button class="btn"
                            :class="{ 'btn-success': creative.status, 'btn-danger': !creative.status }"
                            :data-status="creative.status"
                            @click="toggleStatus(creative.id, creative.status, index)">
                        <i class="fa fa-check-circle-o"></i>
                    </button>
                </td>
                <td>
                    <button class="btn btn-default" @click="openSettings(creative.id)">
                        <i class="fa fa-cog"></i>
                    </button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        mounted() {

            this.fetchCampaign();
        },

        data: function () {

            return {
                creatives: {},
                campaign: {
                    data: {
                        name: ''
                    }
                },
                users: {},
                search: '',
                searchUsers: '',
                urls: {
                    accounts: '/accounts/'
                },
                countriesList: {},
                timezonesList: {},
                languagesList: {},
                loading: false,
                noresult: false
            }
        },

        methods: {

            fetchCampaign: function () {
                this.loading = true;

                this.$http.get(this.$root.api + 'campaigns/' + obj.id).then( response => {
                    this.campaign = response.data;
                    this.creatives = this.campaign.creatives;
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

                $('#_modal-create-new-account').modal();
            },

            createNewAccount: function () {
                this.loading = true;

                return this.$http.post(this.$root.api + 'accounts', this.account).then(response => {

                    this.fetchAccounts();
                    this.loading = false;

                    this.closeModal();
                }, error => {

                    console.log(error);
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

                this.$http.put(this.$root.api + 'accounts/' + id, {status: status}).then(response => {
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

            filterByCreatives: function () {

                if (typeof this.creatives == 'undefined') return;
                var self = this;

                var results = this.creatives.filter( function(item) {

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

                return results;
            }
        }
    }


</script>