<template>
    <div>
        <div class="row">
            <div class="col-md-8">
                <h1 class="title pull-left">Creatives for Campaign</h1>

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

            <tr v-for="(creative, index) in creatives">
                <td>{{ creative.crid }}</td>
                <td>{{ creative.name }}</td>
                <td>1000{{ creative.id }}</td>
                <td>rok@tapklik.com</td>
                <td>
                    <button class="btn btn-primary" @click="openUsers(creative.id)">
                        View
                    </button>
                </td>
                <td>$ </td>
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

            this.fetchCampaignCreatives();
        },

        data: function () {

            return {
                creatives: {
                    data: {
                        budget: {
                            data: {}
                        }
                    }
                },
                search: '',
                urls: {
                    accounts: '/accounts/'
                },
                loading: false,
                noresult: false
            }
        },

        methods: {

            fetchCampaignCreatives: function () {
                this.loading = true;

                this.$http.get(this.$root.api + 'campaigns/' + obj.id + '/creatives').then( response => {
                    this.creatives = response.data;
                    this.loading = false;
                    console.log(this.creatives);
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
            },
        },
    }
</script>
