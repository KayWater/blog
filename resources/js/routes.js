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
            component: Vue.component('App', require('./components/App.vue').default),
            children: [
                {
                    path: 'posts',
                    component: Vue.component('PostList', require('./components/posts/PostList.vue').default),
                },
            ],
        },
        {
            path: '/register',
            component: Vue.component('Register', require('./components/auth/Register.vue').default),
        },
        {
            path: '/login',
            component: Vue.component('Login', require('./components/auth/Login.vue').default),
        },
        {
            path: '/console',
            component: Vue.component('Console', require('./components/console/Console.vue').default),
            children: [
                {
                    // 编辑文章
                    path: 'post/write',
                    component: Vue.component('PostCreate', require('./components/console/posts/PostCreate.vue').default),
                },
                {
                    // 更新文章
                    path: 'post/:postID/edit',
                    component: Vue.component('PostUpdate', require('./components/console/posts/PostUpdate.vue').default),
                    props: true,
                },
                {
                    // 文章列表
                    path: 'posts',
                    component: Vue.component('PostList', require('./components/console/posts/PostList.vue').default),
                },
                {
                    // 草稿列表
                    path: 'drafts',
                    component: Vue.component('DraftList', require('./components/console/posts/DraftList.vue').default),
                },
                {
                    // 编辑草稿
                    path: 'draft/:draftID/edit',
                    component: Vue.component('DraftUpdate', require('./components/console/posts/DraftUpdate.vue').default),
                    props: true,
                },
            ]
        },
    ]
})