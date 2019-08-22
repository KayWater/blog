
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
<<<<<<< HEAD
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';

Vue.use(VueRouter);
Vue.use(ElementUI);
=======

Vue.use(VueRouter);
>>>>>>> 133b84586c5a6380aacfec157b516ce82eeaa890

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


import App from './components/App.vue';

<<<<<<< HEAD
import router from './routes/index';
=======
const Foo = { template: '<div>foo</div>' }
const Bar = { template: '<div>bar</div>' }
const User = { 
    template: `
        <div class='user'>
            <h2> User {{ $route.params.id }} </h2>
            <router-view></router-view>
        </div>`,
    watch: {
        '$route' (to, from) {

        }
    }         
}

const routes = [
    { path: '/foo', component: Foo },
    { path: '/bar', component: Bar },
    { path: '/user/:id', component: User,
        children: [
            {
                path: '', 
                component: UserHome 
            },
            {
                path: 'profile',
                component: UserProfile
            },
            {
                path: 'posts',
                component: UserPosts
            }
        ]
    }
]

const router = new VueRouter({
    routes
});
>>>>>>> 133b84586c5a6380aacfec157b516ce82eeaa890

const app = new Vue({
    el: '#app',
    router,
<<<<<<< HEAD
    components: {
         App,
    },
    render: h=>h(App),
    created: function () {
    	
    }
=======
    // components: {
    //      App,
    // },
    render: h=>h(App),
    // created: function () {
    // 	console.log('test');
    // }
>>>>>>> 133b84586c5a6380aacfec157b516ce82eeaa890
});
