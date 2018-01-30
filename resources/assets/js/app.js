/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */

/*Vue.component('tk-datepicker', require('vue-datepicker'));*/
Vue.component('account', require('./components/Account.vue'));
Vue.component('accounting', require('./components/Accounting.vue'));
Vue.component('accounts', require('./components/Accounts.vue'));
Vue.component('bid', require('./components/Bid.vue'));
Vue.component('billing', require('./components/Billing.vue'));
Vue.component('campaign', require('./components/Campaign.vue'));
Vue.component('campaign-creatives', require('./components/CampaignCreatives.vue'));
Vue.component('creative', require('./components/Creative.vue'));
Vue.component('dashboard', require('./components/Dashboard.vue'));
Vue.component('reporting', require('./components/Reporting.vue'));
Vue.component('support', require('./components/Support.vue'));
Vue.component('support-graphs', require('./components/SupportGraphs.vue'));

/*LOGIN COMPONENT*/
Vue.component('auth', require('./components/Auth.vue'));

const app = new Vue({
    el: '#app',
    data: {
        version: 'v0.1.5-ALPHA',
        erlang_api: 'http://104.225.218.109:2301/api/v1/',
        api : 'http://104.225.218.101:10006/v1/',
        path: '//api.tapklik.com/',
        token: false,
        config: {},
        account: {
            id: null,
            creativeId: null,
            campaignId: null
        }
    },

    mounted () {
        this.getApiToken();
    },

    methods: {

        getApiToken() {
            axios.get('/core/token').then(response => {
                this.token = response.data.token;
        }, error => {
                swal('Error', error, 'error');
            });
        },

        toMicroDollars(value){
            return value * 1000000
        },

        fromMicroDollars(value) {
            return value / 1000000
        },

        twoDecimalPlaces(value) {
            if(value) return value.toFixed(2); 
            else return null;
        }
    },
    
    watch: {
        token(value) {
            if(value == false) return;
            this.$children[0].token = value;
            this.config = {headers: {'Authorization': "Bearer " + this.token}};
        }
    },
});
