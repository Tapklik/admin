<template>
    <div>
        <div class="row">
            <div class="col-md-8">
                <h1 class="title pull-left">Bills</h1>

                <button class="btn btn-default pull-right" @click="openCreateBill()">
                    <i class="fa fa-plus"></i> Create new bill
                </button>
            </div>
            <div class="col-md-4">
                <input type="search" class="form-control" placeholder="Search bill id..." v-model="search"/>
            </div>
        </div>
        <hr/>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Credit or Debit</th>
                <th>Date of Payment</th>
                <th>Amount</th>
                <th>Method of Payment</th>
            </tr>
            </thead>
            <tbody class="vcenter">
            <tr v-show="loading == true">
                <td colspan="11" class="loader text-center">
                    <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
                </td>
            </tr>
            <tr v-show="noresult">
                <td colspan="11">
                    Sorry but theres nothing here... yet :)
                </td>
            </tr>

            <tr v-for="bill in bills">
                <td> {{ bill.id }} </td>
                <td v-if="bill.debit == 0">Credit</td>
                <td v-else>Debit</td>
                <td> {{ bill.timestamp }} </td>
                <td v-if="bill.debit == 0"> {{ $root.fromMicroDollars(bill.credit) }} </td>
                <td v-else> {{ $root.fromMicroDollars(bill.debit) }} </td>
                <td> {{bill.description}} </td>
            </tr>
            </tbody>
        </table>
        <div class="modal fade" id="_modal-create-new-bill" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Create New Bill</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-12 col-md-6">
                                        <label for="label-city">Amount</label>
                                        <br/>
                                        <input type="text" class="form-control" v-model="bill.amount" id="label-city" />
                                    </div>
                                    <div class="col-xs-12 col-md-6">
                                        <label for="label-city">Tran Number</label>
                                        <br/>
                                        <input type="text" class="form-control" id="label-city" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <label for="label-approved">Method of Payment</label>
                                        <br/>
                                        <select class="form-control" id="label-approved" v-model="bill.description">
                                            <option value="cc payment">Credit Card</option>
                                            <option value="paypal payment">Paypal</option>
                                            <option value="bank transfer">Bank Transfer</option>
                                            <option value="cheque deposit">Cheque Deposit</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="createNewBill()">Create</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
        },

        data() {

            return {
                bills: [],
                loading: false,
                noresult: false,
                token: this.token,
                bill: {
                    amount: 0,
                    description: 'cc payment',
                    type: 'billing'
                }
            }
        },

        methods: {

            openCreateBill() {
                $('#_modal-create-new-bill').modal();
            },

            fetchBills() {
                
                this.loading = true;
                var self = this;
                var accountIdDraft = window.location.pathname.replace('\/accounts\/', '');
                var accountId = accountIdDraft.slice(0,(accountIdDraft.length - 8));
            
                axios.get(self.$root.api + 'accounts/' + accountId + '/banker/main?type=billing', self.$root.config).then(response => {
                    self.bills = response.data.data;
                    self.loading = false;
                }, error => {
                    console.log("heeey")
                    swal('Error', error, 'error');
                })
            },
            collectBill() {
                return {
                    credit: this.$root.toMicroDollars(this.bill.amount),
                    description: this.bill.description,
                    type: "billing"                    
                }
            },
            createNewBill() {
                this.loading = true;
                var accountIdDraft = window.location.pathname.replace('\/accounts\/', '');
                var accountId = accountIdDraft.slice(0,(accountIdDraft.length - 8));

                return axios.post(this.$root.api + 'accounts/' + accountId + '/banker/main', this.collectBill(), this.$root.config).then(response => {

                    this.fetchBills();
                    this.loading = false;
                    this.closeModal();
                }, error => {
                    this.loading = false;
                    this.closeModal();
                });
            },


            closeModal() {
                $('#_modal-create-new-bill').modal('close');
            },

            toggleStatus(id, status, index) {

                status = (1 == status) ? 0 : 1;
                this.campaigns.data[index].status = status;

                axios.put(this.$root.api + 'campaigns/' + id + '/approve', {approved: status}, this.$root.config).then(response => {
                    this.fetchCampaigns();
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

                    case 'api':
                        endpoint += '//api.tapklik.com/v1/campaigns/' + id;
                    break;

                    case 'creatives':
                        endpoint += '/campaigns/' + id + '/creatives';
                    break;
                }

                return endpoint;
            }
        },

        computed: {

            filterByBills: function () {

                if (typeof this.bills.data == 'undefined') return;

                var self = this;

                var results = this.bills.data.filter( function(item) {

                    return item.id.toLowerCase().indexOf(self.search.toLowerCase()) > -1;
                });

                this.noresult = (!results.length) ? true : false;

                return results;
            }
        },

        watch: {
            token(value) {
                this.fetchBills()
            }
        }
    }

</script>
