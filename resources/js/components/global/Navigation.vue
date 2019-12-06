<template>
    <div class='container'>
        <nav class='navbar navbar-expand-lg navbar-light bg-light'>
            <a class='navbar-brand' href='/'>PIBlog</a>
            <button class='navbar-toggler' type='button' data-toggle='collapse'
            data-target='navbarSupportedContent' aria-controls='navbarSupportedContent'
            aria-expanded='false' aria-label='Toggle navigation'>
                <span class='navbar-toggler-icon'></span>
            </button>

            <div class='collapse navbar-collapse' id='navbarSupportedContent'>
                <ul class='navbar-nav mr-auto'>
                    <li class='nav-item'>
                        <router-link class='nav-link' to='/posts'>文章</router-link>
                        
                    </li>
                </ul>
                <form class='form-inline my-2 my-lg-0' id='searchForm'>
                    <input class='form-control mr-sm-2' type='search' id='search'
                    name='search' placeholder='search' aria-label='Search'>
                    <button class='btn btn-outline-secondary my-2 my-sm-0' id='save'
                    type='submit'>Search</button>
                </form>

                <ul class='navbar-nav ml-auto'>
                    <template v-if="isLogined && me">
                        <li class="nav-item">
                            <el-dropdown>
                                <span class='el-dropdown-link'>
                                    {{ me.name }}<i class='el-icon-arrow-down el-icon--right'></i>
                                </span>
                                <el-dropdown-menu slot='dropdown'>
                                    <el-dropdown-item>
                                        <router-link class='nav-link' to='/console'>管理后台</router-link>
                                    </el-dropdown-item>
                                    <el-dropdown-item>
                                        <el-button type='text' @click='logout'>注销</el-button>
                                    </el-dropdown-item>
                                </el-dropdown-menu>
                            </el-dropdown>
                        </li>
                    </template>
                    <template v-else>
                        <li class="nav-item">
                            <!-- <el-button type="text" @click='login()'>登录</el-button> -->
                            <router-link class='nav-link' to='/login'>登录</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class='nav-link' to='/register'>注册</router-link>
                        </li>
                    </template>
                </ul>
            </div>
        </nav> 
    </div>
</template>

<script>
export default {
    data() {
        return {
            
        }
    },

    computed: {
        /**
         * Current user
         */
        me() {
            return this.$store.state.user.me;
        },

         /**
         * Whether is logined
         */
        isLogined() {
            return this.$store.getters['auth/isLogined'];
        },
    },

     methods: {
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
}
</script>

<style scoped>
.el-dropdown-link {
    cursor: pointer;
    color: #409EFF;
}
.el-icon-arrow-down {
    font-size: 12px;
}

.navbar-light .navbar-nav .router-link-active {
    color: #999999;
    font-weight: bold;
    font-size: 1rem;
}
</style>