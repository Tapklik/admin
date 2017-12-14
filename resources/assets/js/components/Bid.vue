<template>
    <div>

        <!-- HEADER START -->
        <div class="row">
            <div class="col-md-8">
                <h1 class="title pull-left">Bid Details</h1>
            </div>
        </div>
        <!-- HEADER END -->

        <hr/>

        <!-- BID DETAILS START -->
        <div class="row">
            <div class="col-md-2"> ID: </div>        
            <div class="col-md-4"> {{ bid.id }} </div>            
        </div>
        <div class="row">
            <div class="col-md-2"> RSP_TIME: </div>        
            <div class="col-md-4"> {{ bid.rsp_time }} </div>            
        </div>
        <div class="row">
            <div class="col-md-2"> TIME </div>        
            <div class="col-md-4"> {{ bid.time }} </div>            
        </div>
        <!-- BID DETAILS END -->

        <hr/>

        <!-- BID ADDITIONAL DETAILS START -->
        <div class="row">
            <div class="col-md-8">
                <h1 class="title pull-left">Other Details</h1>
            </div>
        </div>

        <hr/>

        <table class="table table-striped">
            <tbody class="vcenter">
                <tr v-for="(item, index) in bid">
                    <th> {{ index }} </th>
                    <td>{{ item }} </td>
                </tr>
            </tbody>
        </table>
        <!-- BID ADDITIONAL DETAILS END -->

    </div>
</template>

<script>
    export default {
        mounted() {
        },

        data() {
            return {
                //ESSENTIALS
                token: this.token,
                bid_id: window.location.pathname.replace('\/reports\/', ''),

                //BID
                bid: {},
                bid_keys: []
            }
        },

        methods: {

            //BID
            getBid() {
                axios.get(
                    this.$root.erlang_api + 'bids/' + this.bid_id, 
                    this.$root.config
                ).then(response => {
                        this.bid = response.data;
                    }, error => {
                        console.log(error);
                    }
                );
            },
            getBidKeys() {
                var bid = this.bid;
                var keys = Object.keys(bid);
                this.bid_keys = keys;
            }
        },

        watch: {
            token(value) {
                this.getBid();
            },

            bid(value) {
                this.getBidKeys();
            }
        }
    }

</script>
