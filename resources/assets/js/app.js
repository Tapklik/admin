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


// ** PRODUCTION
var envUri = 'https://api.tapklik.com/v1'; 
var reportUri = 'https://reports.tapklik.com/api/query';
var erlangUri = 'https://boss.services.tapklik.com/api/v1';


// ** LOCAL
if(window.location.hostname.search('local') > -1 || window.location.hostname.search('127')  > -1) {
    envUri = '//local.api.tapklik.com/v1';
    reportUri: '//104.225.218.101:10002/api/query';
    erlangUri = '//104.225.218.109:2301/api/v1';
}

// ** DEVELOPMENT
if(window.location.hostname.search('alpha') > -1) {
    envUri = '//104.225.218.101:10006/v1';
    reportUri: '//104.225.218.101:10002/api/query';
    erlangUri = '//104.225.218.109:2301/api/v1';

}
if(window.location.hostname.search('local.onead.tapklik.com') > -1) envUri = '//104.225.218.101:10006/v1';



const app = new Vue({
    el: '#app',
    data: {
        version: 'v0.3.2',
        erlang_api: erlangUri,
        api : envUri,
        path: envUri,

        token: false,
        config: {},
        user: {}
    },

    mounted () {
        this.getApiToken();
    },

    methods: {
        createNotification(notification_message, users) {
            var today = new Date();
            var created_at = today.getTime() / 1000;
            var payload = {
                service: ['onead'],
                message: notification_message,
                users: users,
                created_at: created_at.toString()
            }
            axios.post(
                this.api + '/core/notifications',
                {config: payload},
                this.$root.config
            ).then(response => {
                
            }, error => {

            });
        },

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
