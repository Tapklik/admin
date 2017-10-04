<template>
    <div>
        <div class="row">
            <div class="col-md-8">
                <h1 class="title pull-left">Bid Details</h1>
            </div>
        </div>

        <hr/>

        <div class="row">
            <div class="col-md-2">
                ID: 
            </div>        
            <div class="col-md-4">
                {{bid.id}}
            </div>            
        </div>
        <div class="row">
            <div class="col-md-2">
                RSP_TIME: 
            </div>        
            <div class="col-md-4">
                {{bid.rsp_time}}
            </div>            
        </div>
        <div class="row">
            <div class="col-md-2">
                TIME
            </div>        
            <div class="col-md-4">
                {{bid.time}}
            </div>            
        </div>

        <hr/>

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
    </div>
</template>

<script>
    export default {
        mounted() {
        },

        data() {

            return {
                loading: false,
                noresult: false,
                token: this.token,
                bid: {},
                bidKeys: []
            }
        },

        methods: {
            fetchBid() {
                var self = this;
                var bidId = window.location.pathname.replace('\/reports\/', '');
                axios.get('http://45.76.95.115:2301/api/bids/' + bidId, this.$root.config).then( response => {
                    self.bid = response.data;
                }, error => {
                    console.log(error);
                });
            },
            fetchBidKeys() {
                var a = this.bid;
                var b = Object.keys(a);
                this.bidKeys = b;
            }
        },

        computed: {
    
        },

        watch: {
            token(value) {
                this.fetchBid();
            },
            bid(value) {
                this.fetchBidKeys();
            }
        }
    }

</script>
