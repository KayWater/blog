<template>
    <el-row class="tac">
        <template v-if='me'>
        <el-col >
            <el-card>
                <div class="text-center">
                    <p>{{ me.name }}</p>
                    <div class='bottom clearfix'>
                        <router-link to='/' 
                        v-slot="{ href, route, navigate, isActive }">
                            <el-button type='text' :active='isActive' 
                            :href="href" @click='navigate'>首页</el-button>
                        </router-link>
                        <el-button type='text' @click="logout">注销</el-button>
                    </div>
                </div>
            </el-card>
            <el-menu
            :default-active="this.$route.path"
            class="el-menu-vertical-demo"
            @open="handleOpen"
            @close="handleClose"
            :default-openeds="defualtOpends"
            :router='true'>
                <el-submenu index="1">
                    <template slot="title">
                    <span>设置</span>
                    </template>
                    <el-menu-item index="/console/settings/security">密码</el-menu-item>
                </el-submenu>
                <el-submenu index='2'>
                    <template slot='title'>
                        <span>文章管理</span>
                    </template>
                    <el-menu-item index='/console/post/write'>写文章</el-menu-item>
                    <el-menu-item index='/console/posts'>我的文章</el-menu-item>
                    <el-menu-item index='/console/drafts'>我的草稿</el-menu-item>
                </el-submenu>
            </el-menu>
        </el-col>
        </template>
    </el-row>    
</template>

<script>
export default {
    data() {
        return {
            defualtOpends: ['1',],
        }
    },

    computed: {
        me() {
            return this.$store.state.user.me;
        },
    },

    methods: {
      handleOpen(key, keyPath) {
        console.log(key, keyPath);
      },
      handleClose(key, keyPath) {
        console.log(key, keyPath);
      },

      /**
         * Logout
         */
        logout() {
            // Dispatch the logout actions in auth module
            this.$store.dispatch('auth/logout')
            .then((response) => {
                // Redirect to home page after logout;
                this.$router.push({name: 'home'}).then((onComplete) => {
                    
                }).catch((error) => {
                    if (error.name === "NavigationDuplicated") {
                        return;
                    }
                });
            });
            
        },
    },

    created() {
        let vm = this;
    }
}
</script>

<style scoped>
.tac {
    position: fixed;
    width: 240px;
    height: 100%;
    overflow: hidden;
}
.tac .el-col {
    height: 100%;
}
.el-menu-vertical-demo {
    height: 100%;
    overflow-y: auto;
}
</style>

<style lang="scss" scoped>
.el-menu {
    height: calc(100% - 121px);
}
</style>
