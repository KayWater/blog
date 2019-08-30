<template>
    <div id="page">
        <navigation></navigation>
        
        <router-view></router-view>
        <login-modal></login-modal>

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
      
    },
    methods: {

    },

    created() {
        this.$store.dispatch('loadUser');
    }
}
</script>