<template>
    <div>

        <!-- HEADER START -->
        <div class="row">
            <div class="col-md-8">
                <h1 class="title pull-left">Bills</h1>
                <button 
                class="btn btn-default pull-right" 
                @click="openCreateNewBill()"
                >
                    <i class="fa fa-plus"></i> Create new bill
                </button>
            </div>
            <div class="col-md-4">
                <input 
                type="search" 
                class="form-control" 
                placeholder="Search bill id..." 
                v-model="search_bills"
                />
            </div>
        </div>
        <!-- HEADER END -->

        <hr/>

        <!-- BILLS START -->
        <table class="table table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Credit/Debit</th>
                <th>Date</th>
                <th>Amount</th>
                <th>Method</th>
            </tr>
            </thead>
            <tbody class="vcenter">

            <!-- TABLE LOADER START -->
            <tr v-if="bills_table_loading">
                <td colspan="11" class="loader text-center">
                    <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
                </td>
            </tr>
            <!-- TABLE LOADER END -->
            
            <!-- EMPTY TABLE MESSAGE START -->
            <tr v-else-if="bills_table_empty">
                <td colspan="11">
                    Sorry but I can't find anything relating to <strong>{{ search_bills }}</strong>
                </td>
            </tr>
            <!-- EMPTY TABLE MESSAGE END -->
            
            <tr v-else v-for="bill in filtered_bills">
                <td> {{ bill.id }} </td>
                <td> {{ bill.debit ? 'Debit' : 'Credit' }}</td>
                <td> {{ bill.timestamp }} </td>
                <td> {{ bill.debit ? $root.fromMicroDollars(bill.debit) : $root.fromMicroDollars(bill.credit) }} </td>
                <td> {{ bill.description }} </td>
            </tr>
            </tbody>
        </table>
        <!-- BILLS END -->

        <!-- MODALS START -->
        <!-- CREATE NEW BILL START -->
        <div class="modal fade" id="_modal-create-new-bill" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button 
                        type="button" 
                        class="close" 
                        data-dismiss="modal" 
                        aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Create New Bill</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-12 col-md-6">
                                        <label for="label-city">Amount</label>
                                        <br/>
                                        <input 
                                        type="number" 
                                        class="form-control" 
                                        v-model="new_bill.amount" 
                                        id="label-city" 
                                        />
                                    </div>
                                    <div class="col-xs-12 col-md-6">
                                        <label for="label-city">Tran Number</label>
                                        <br/>
                                        <input 
                                        type="text" 
                                        class="form-control" 
                                        id="label-city" 
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <label for="label-approved">Method of Payment</label>
                                        <br/>
                                        <select 
                                        class="form-control" 
                                        id="label-approved" 
                                        v-model="new_bill.description"
                                        >
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
                        <button 
                        type="button" 
                        class="btn btn-default" 
                        data-dismiss="modal"
                        @click="clearNewBill()"
                        >
                            Close
                        </button>
                        <button 
                        type="button" 
                        class="btn btn-primary" 
                        data-dismiss="modal" 
                        @click="createNewBill()"
                        >
                            Create
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- CREATE NEW BILL END -->
        <!-- MODALS START -->

    </div>
</template>

<script>
    export default {

        data() {
            return {
                //ESSENTIALS
                token: this.token,
                search_bills: '',
                account_id: this.getAccountId(),

                //BILLS
                bills: [],
                bills_table_loading: true,
                bills_table_empty: false,
                
                //CREATE NEW BILL
                new_bill: {
                    invoice_id: 'TZ0001ARG125878',
                    amount: 0,
                    description: 'cc payment',
                    type: 'billing'
                }
            }
        },

        methods: {

            //OVERALL
            getAccountId() {
                var pathname = window.location.pathname;
                var result = pathname.split("/");
                return result[2];
            },

            //BILLS
            getBills() {            
                axios.get(
                    this.$root.api + 'accounts/' + this.account_id + '/banker/main?type=billing', 
                    this.$root.config
                ).then(response => {
                        this.bills_table_empty = response.data.data == '' ? true : false;
                        this.bills = response.data.data;
                        this.bills_table_loading = false;
                    }, error => {
                        this.bills_table_loading = false;
                    }
                );
            },

            //CREATE NEW BILL
            openCreateNewBill() {
                $('#_modal-create-new-bill').modal();
            },

            clearNewBill() {
                this.new_bill.invoice_id = 'TZ0001ARG125878';
                this.new_bill.amount = 0;
                this.new_bill.description = 'cc payment';
                this.new_bill.type = 'billing';
            },

            createNewBill() {
                this.bills_table_loading = true;

                axios.post(
                    this.$root.api + 'accounts/' + this.account_id + '/banker/main', 
                    this.new_bill, 
                    this.$root.config
                ).then(response => {
                        this.clearNewBill();
                        this.getBills();
                    }, error => {
                        this.clearNewBill();
                        this.getBills();
                    }
                );
            }
        },

        computed: {

            filtered_bills() {
                var self = this;

                var results = this.bills.filter(bill => 
                    bill.id.toLowerCase().indexOf(self.search_bills) != -1
                );
                this.bills_table_empty = results == '' ? true : false;
                return results;
            }
        },

        watch: {
            token(value) {
                this.getBills()
            }
        }
    }

</script>
