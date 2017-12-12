
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
Vue.component('accounts', require('./components/Accounts.vue'));
Vue.component('accounts-show', require('./components/AccountsShow.vue'));
Vue.component('campaigns', require('./components/Campaigns.vue'));
Vue.component('campaign-create', require('./components/CampaignsCreate.vue'));
Vue.component('campaigns-all', require('./components/CampaignsAll.vue'));
Vue.component('campaign-show', require('./components/CampaignShow.vue'));
Vue.component('campaign-creatives-show', require('./components/CampaignCreativesShow.vue'));
Vue.component('creative', require('./components/CreativeShow.vue'));
Vue.component('creatives', require('./components/Creatives.vue'));
Vue.component('dashboard', require('./components/Dashboard.vue'));
Vue.component('creatives-all', require('./components/CreativesAll.vue'));
Vue.component('creative-show', require('./components/CreativesShow.vue'));
Vue.component('reports', require('./components/Reports.vue'));
Vue.component('users', require('./components/Users.vue'));
Vue.component('accounting', require('./components/Accounting.vue'));
Vue.component('billing', require('./components/BillingShow.vue'));
Vue.component('bid-show', require('./components/BidShow.vue'));

/*LOGIN COMPONENT*/
Vue.component('auth', require('./components/Auth.vue'));

const app = new Vue({
    el: '#app',
    data: {
        erlang_api: 'http://104.225.218.109:2301',
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