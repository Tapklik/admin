<template>
    <div>
        Support
    </div>
</template>

<script>
    export default {
        mounted() {
            this.getCountries();
            this.getTimezones();
            this.getLanguages();
        },

        data() {
            return {
                //ESSENTIALS
                token: '',     
                search_accounts: '',           

                //ACCOUNTS
                accounts: [],
                accounts_table_loading: true,
                accounts_table_empty: false,

                //CREATE NEW ACCOUNT
                new_account: {
                    name: '',
                    country: '',
                    city: '',
                    language: '',
                    timezone: '',
                    status: 1,
                    company: '',
                    billing_email: '',
                    billing_address: '',
                    billing_country: '',
                    billing_city: ''
                },
                countries: [],
                timezones: [],
                languages: [],
            }
        },

        methods: {

            //OVERALL
            buttonLoading(action, condition, id) {
                for(var button in this.$refs[id]) {
                    var targetted_button = this.$refs[id][button].id == action ? button : targetted_button;
                }
                condition ? this.$refs[id][targetted_button].children[0].className = 'fa fa-circle-o-notch fa-spin' : 
                            this.$refs[id][targetted_button].children[0].className = 'fa fa-check-circle-o';
            },

            //ACCOUNTS
            getAccounts(id) {
                axios.get(
                    this.$root.api + 'accounts',
                    this.$root.config
                ).then(response => {
                        this.accounts_table_empty = response.data.data == '' ? true : false;
                        this.accounts = response.data.data;
                        this.accounts_table_loading = false;
                        if(id) {
                            this.buttonLoading('delete', false, id);
                            this.buttonLoading('toggle', false, id);
                        }
                    }, error => {
                        this.accounts_table_loading = false;
                    }
                );
            },

            toggleAccountStatus(status ,id) {
                var status = status ? 0 : 1;
                this.buttonLoading('toggle', true, id);

                axios.put(
                    this.$root.api + 'accounts/' + id,
                    { status: status },
                    this.$root.config
                ).then(response => {
                        this.getAccounts(id);
                    }, error => {
                        this.getAccounts(id);
                    }
                );
            },

            deleteAccount(id) {
                this.buttonLoading('delete', true, id);

                axios.delete(
                    this.$root.api + 'accounts/' + id, 
                    this.$root.config
                ).then(response => {
                        this.getAccounts(id);
                    }, error => {
                        this.getAccounts(id);
                    }
                );
            },

            //CREATE NEW ACCOUNT
            openCreateNewAccount() {
                $('#_modal-create-new-account').modal();
            },

            getCountries() {
                axios.get(
                    '/data/countries.json'
                ).then(response => {
                        this.countries = response.data;
                    }, error => {

                    }
                );
            },

            getTimezones() {
                axios.get(
                    '/data/timezones.json'
                ).then(response => {
                        this.timezones = response;
                    }, error => {

                    }
                );
            },

            getLanguages() {
                axios.get(
                    '/data/languages.json'
                ).then(response => {
                        this.languages = response;
                    }, error => {

                    }
                );
            },

            clearNewAccount() {
                this.new_account.name = '',
                this.new_account.country = '',
                this.new_account.city = '',
                this.new_account.language = '',
                this.new_account.status = 1,
                this.new_account.company = '',
                this.new_account.billing_email = '',
                this.new_account.billing_address = '',
                this.new_account.billing_country = '',
                this.new_account.billing_city = '',
                this.new_account.timezone = ''
            },

            createNewAccount() {
                this.accounts_table_loading = true;

                axios.post(
                    this.$root.api + 'accounts', 
                    this.new_account, 
                    this.$root.config
                ).then(response => {
                        this.clearNewAccount();
                        this.getAccounts();
                    }, error => {
                        this.clearNewAccount();
                        this.getAccounts();
                    }
                );
            },

            updateFees(fees, id) {
                var payload = {
                    fee_fixed: fees.fixed,
                    fee_variable: fees.variable
                };
                axios.put(
                    this.$root.api + 'accounts/' + id + '/fees',
                    payload,
                    this.$root.config
                ).then(response => {
                        this.getAccounts();
                    }, error => {
                        this.getAccounts();
                    }
                );
            }
        },

        computed: {
            filtered_accounts() {
                var self = this;

                var results = this.accounts.filter(account => 
                    account.name.toLowerCase().indexOf(self.search_accounts) != -1
                );
                this.accounts_table_empty = results == '' ? true : false;
                return results;
            }
        },

        watch: {
            token(value) {
                this.getAccounts();
            }
        }
    }

</script>