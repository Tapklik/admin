<template>
    <div>

        <!-- HEADER START -->
        <div class="row">
            <div class="col-xs-12">
                <h2>Creatives</h2>
            </div>
        </div>
        <!-- HEADER END -->

        <hr />

        <!-- CAMPAIGN CREATIVES START -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Class</th>
                    <th>Dimensions</th>
                    <th>Image</th>
                    <th>Approve</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody class="vcenter">

                <!-- TABLE LOADER START -->
                <tr v-if="creatives_table_loading">
                    <td colspan="11" class="loader text-center">
                        <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
                    </td>
                </tr>
                <!-- TABLE LOADER END -->

                <!-- EMPTY TABLE MESSAGE START -->
                <tr v-else-if="creatives_table_empty">
                    <td colspan="11">
                        Sorry but theres nothing here... yet :)
                    </td>
                </tr>
                <!-- EMPTY TABLE MESSAGE END -->

                <tr v-else v-for="creative in campaign_creatives">
                    <td>{{ creative.id }}</td>
                    <td>
                        <a style="cursor: pointer" @click="sendToCreative(creative.id)">
                            {{ creative.name }}
                        </a>
                    </td>
                    <td>{{ creative.class }}</td>
                    <td>{{ creative.w }}x{{ creative.h}}</td>
                    <td>  
                        <a :href="creative.iurl" target="_blank">
                            <img width="70px" :src="creative.thumb">
                        </a> 
                    </td>
                    <td>
                        <button 
                        :ref="creative.id"
                        id="toggle"
                        :class="creative.approved == 'approved' ? 'btn btn-success' : 'btn btn-danger'" 
                        @click="toggleCreativeStatus(creative.id, creative.approved)"
                        >
                            <i class="fa fa-check-circle-o"></i>
                        </button>
                    </td>
                    <td>
                        <button
                        :ref="creative.id"
                        id="delete" 
                        class="btn btn-danger" 
                        @click="deleteCreative(creative.id)"
                        >
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- CAMPAIGN CREATIVES END -->

    </div>
</template>

<script>
    export default {
        mounted() {
            this.getIds();
        },

        data() {
            return {
                //ESSENTIALS
                campaign_id: '',
                account_id: '',
                token: this.token,

                //CREATIVES
                creatives_table_loading: true,
                creatives_table_empty: false,
                campaign_creatives: [],
            }
        },

        methods: {
            //OVERALL
            getIds() {
                var idDraft = window.location.pathname;
                var res = idDraft.split("/");

                this.campaign_id = res[4];
                this.account_id = res[2];
            },

            buttonLoading(action, condition, id) {
                for(var button in this.$refs[id]) {
                    var targetted_button = this.$refs[id][button].id == action ? button : targetted_button;
                }
                condition ? this.$refs[id][targetted_button].children[0].className = 'fa fa-circle-o-notch fa-spin' : 
                            this.$refs[id][targetted_button].children[0].className = 'fa fa-check-circle-o';
            },

            sendToCreative(id) {
                window.location.pathname = "/accounts/" + this.account_id +"/creatives/" + id;
            },

            //CAMPAIGN CREATIVES 
            getCampaignCreatives() {
                axios.get(
                    this.$root.api + 'campaigns/' + this.campaign_id, 
                    this.$root.config
                ).then(response => {
                        this.campaign_creatives = response.data.data.creatives.data;
                        this.creatives_table_loading = false;
                    }, error => {
                        this.creatives_table_loading = false;
                    }
                );
            },

            toggleCreativeStatus(id, status) {
                var toggleBag = {
                    approved: 'declined',
                    declined: 'approved',
                    pending: 'approved'
                };
                this.buttonLoading('toggle', true, id);

                axios.put(
                    this.$root.api + 'creatives/' + id, 
                    { status: toggleBag[status] }, 
                    this.$root.config
                ).then(response => {
                        this.buttonLoading('toggle', false, id);
                        this.getCampaignCreatives();
                    }, error => {
                        this.buttonLoading('toggle', false, id);
                        this.getCampaignCreatives();
                    }
                );
            },

            deleteCreative(id) {
                this.buttonLoading('delete', true, id);

                axios.delete(
                    this.$root.api + 'creatives/' + id, 
                    this.$root.config
                ).then(response => {
                        this.buttonLoading('delete', false, id);
                        this.fetchCampaign();
                    }, error => {
                        this.buttonLoading('delete', false, id);
                        this.fetchCampaign();
                    }
                );
            }
        },

        watch: {
            token(value) {
                this.getCampaignCreatives();
            }
        }
    }
</script>


