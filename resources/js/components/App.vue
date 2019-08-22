<template>
    <div id="app">
<<<<<<< HEAD
        <navbar></navbar>
        
=======
        <h1> Hello App! </h1>
        <p>
            <router-link to='/foo'>Go To Foo</router-link>
            <router-link to='/bar'>Go To Bar</router-link>
        </p>
>>>>>>> 133b84586c5a6380aacfec157b516ce82eeaa890
        <router-view></router-view>
    </div>
</template>

<script>
<<<<<<< HEAD
import Navbar from './Navbar.vue';

export default {
    components: {
        navbar: Navbar,
    },
    computed: {
      
    },
    methods: {

=======

export default {
    components: {

    },
    computed: {
        username() {
            return this.$route.params.username
        }
    },
    methods: {
        goBack() {
            window.history.length > 1 ? this.$router.go(-1) : this.$router.push('/')
        }
>>>>>>> 133b84586c5a6380aacfec157b516ce82eeaa890
    }
}
</script>