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
            name: 'home',
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
        },
        {
            path: '/console',
            components: Vue.component('Console', require('./components/console/Console.vue')),
            children: [
                {
                    // 编辑文章
                    path: 'post/write',
                    components: Vue.component('PostCreate', require('./components/console/posts/PostCreate.vue')),
                },
                {
                    // 更新文章
                    path: 'post/:postID/edit',
                    components: Vue.component('PostUpdate', require('./components/console/posts/PostUpdate.vue')),
                    props: true,
                },
                {
                    // 文章列表
                    path: 'posts',
                    components: Vue.component('PostList', require('./components/console/posts/PostList.vue')),
                },
            ]
        },
    ]
})