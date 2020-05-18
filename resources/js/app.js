

require('./bootstrap');

window.Vue = require('vue');


Vue.component('navbar', require('./components/Navbar.vue').default);
Vue.component('profiles', require('./components/Profiles.vue').default);
//Vue.component('addprofiles', require('./components/AddProfile.vue').default);

/*const routes = [
    {
        name: 'Addpost',
        path: '/add-profile',
        component: Addprofile
    }
]
*/
const app = new Vue({
    el: '#app',
});
