<template>
    <div id="app-layout">
        <navigiation></navigiation>
        <router-view></router-view>
    </div>
</template>

<script>
    import Navigiation from '../components/global/Navigation.vue';

    export default {
        components: {
            Navigiation
        },
        created() {
            this.$store.dispatch('loadCafes');
            this.$store.dispatch('loadUser');
            this.$store.dispatch('loadBrewMethods');
        }
    }
</script>

<style>

</style>