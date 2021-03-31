require('./bootstrap');

window.Vue = require('vue');

import Vuetify from 'vuetify';
import 'vuetify/dist/vuetify.min.css'


Vue.use(Vuetify)

Vue.component('sample-component',require('./components/Sample.vue').default);
Vue.component('calender-component', require('./components/CalenderComponent.vue').default);
Vue.component('create-component', require('./components/CreateComponent.vue').default);

const app = new Vue({
    el: '#app',
    vuetify: new Vuetify({

    }),
    
});