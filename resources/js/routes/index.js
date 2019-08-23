import Vue from 'vue'
import Router from 'vue-router'

import Posts from '../components/articles/Index'
import Post from '../components/articles/Post'
import Login from '../components/auth/Login'

Vue.use(Router)

export default new Router({
    routes: [
        { path: '/articles', component: Posts },
        { path: '/article/:id', name: 'post', component: Post, props: true },
        { path: '/login', name: 'login', component: Login},
    ]
})