
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
Vue.component('campaigns-show', require('./components/CampaignsShow.vue'));
Vue.component('creatives', require('./components/Creatives.vue'));
Vue.component('dashboard', require('./components/Dashboard.vue'));
Vue.component('creatives-all', require('./components/CreativesAll.vue'));
Vue.component('creative-show', require('./components/CreativesShow.vue'));
Vue.component('reports', require('./components/Reports.vue'));
Vue.component('users', require('./components/Users.vue'));

const app = new Vue({
    el: '#app',
    data: {
        'api': 'http://api.tapklik.com/v1/',
        'path': '//api.tapklik.com/',
        'token': ''
    },

    mounted () {
        this.getApiToken();
    },

    methods: {

        getApiToken () {

            this.$http.post(this.api + 'auth', {
                'email': 'root',
                'password': 'root'
            }).then(response => {
                this.token = atob(response.data.token);
            }, error => {
                alert('Error');
            });

        }
    },

    watch: {
        token(value) {
            this.$children[0].token = value;
        }
    }
});