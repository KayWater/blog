/*
 |-------------------------------------------------------------------------------
 | routes.js
 |-------------------------------------------------------------------------------
 | Contains all of the routes for the application
 */

import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter)

export default new VueRouter({
    routes: [
        {
            path: '/',
            name: 'app',
            components: Vue.component('App', require('./components/App.vue')),
            children: [
                {
                    path: 'posts',
                    name: 'posts',
                    components: Vue.component('PostList', require('./components/posts/PostList.vue')),
                },
            ],
        },
        {
            path: '/register',
            name: 'register',
            components: Vue.component('Register', require('./components/auth/Register.vue')),
        },
        {
            path: '/login',
            name: 'login',
            components: Vue.component('Login', require('./components/auth/Login.vue')),
        }
    ]
})