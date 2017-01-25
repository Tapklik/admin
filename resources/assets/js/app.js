
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

Vue.component('accounts', require('./components/Accounts.vue'));
Vue.component('campaigns', require('./components/Campaigns.vue'));
Vue.component('campaigns-all', require('./components/CampaignsAll.vue'));
Vue.component('campaigns-show', require('./components/CampaignsShow.vue'));
Vue.component('creatives', require('./components/Creatives.vue'));

const app = new Vue({
    el: '#app',
    data: {
        'api': 'http://local.api.tapklik.com/v1/'
    }
});
