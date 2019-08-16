
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';

Vue.use(VueRouter);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


import App from './components/App.vue';

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

const app = new Vue({
    el: '#app',
    router,
    // components: {
    //      App,
    // },
    render: h=>h(App),
    // created: function () {
    // 	console.log('test');
    // }
});
