<template>
    <el-container>
        <el-aside width='240px'>
            <side-bar></side-bar>
        </el-aside>
        <el-container>
            <el-main>
                <router-view></router-view>
            </el-main>
        </el-container>
    </el-container>
</template>

<script>
import SideBar from './SideBar.vue';

export default {
    components: {
        SideBar,
    },

    data() {
        return {

        }
    },

    computed: {
        /**
         * Is logined 
         */
        isLogined() {
            return this.$store.getters['auth/isLogined'];
        },

        /**
         * Current user
         */
        me() {
            return this.$store.state.user.me;
        }
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

<style scoped>

</style>