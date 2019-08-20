<template>
    <div id="app">
        <h1> Hello App! </h1>
        <p>
            <router-link to='/foo'>Go To Foo</router-link>
            <router-link to='/bar'>Go To Bar</router-link>
        </p>
        <router-view></router-view>
    </div>
</template>

<script>

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
    }
}
</script>