
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

<<<<<<< HEAD
// import VueRouter from 'vue-router';
// import ElementUI from 'element-ui';
// import 'element-ui/lib/theme-chalk/index.css';


// Vue.use(VueRouter);
// Vue.use(ElementUI);
=======
import VueRouter from 'vue-router';
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';

Vue.use(VueRouter);
Vue.use(ElementUI);
>>>>>>> c22dcc9574e65921368db93827849f82cef848db

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


import App from './components/App.vue';

<<<<<<< HEAD
import router from './routes.js';
import store from './store.js';

// const app = new Vue({
//     el: '#app',
//     router,
//     // components: {
//     //      App,
//     // },
//     render: h=>h(App),
//     // created: function () {
//     // 	console.log('test');
//     // }
// });

new Vue({
    router,
    store,
}).$mount('#app');
=======
import router from './routes/index';

const app = new Vue({
    el: '#app',
    router,
    components: {
         App,
    },
    render: h=>h(App),
    created: function () {
    	
    }
});
>>>>>>> c22dcc9574e65921368db93827849f82cef848db
