<template>
    <div id="page">
        <navigation></navigation>
        
        <router-view></router-view>
    </div>
</template>

<script>
import Navigation from './global/Navigation.vue';
import LoginModal from './auth/LoginModal.vue';

export default {
    components: {
        Navigation,
        LoginModal,
    },

    data() {
        return {

        }
    },

    computed: {
        /**
         * isLogined 
         */
        isLogined() {
            return this.$store.getters['auth/isLogined'];
        },

        /**
         * Current user
         */
        me() {
            return this.$store.state.user.me;
        },
    },

    methods: {

    },

    created() {
        if (!this.isLogined) {
            return ;
        }

        this.$store.dispatch('user/loadMe');
    }
}
</script>