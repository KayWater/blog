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
                    <li class="nav-item">
                        <el-button type="text" @click='login()'>登录</el-button>
                        <router-link class='nav-link' to='/login'>登录</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class='nav-link' to='/register'>注册</router-link>
                    </li>
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
        user() {
            return this.$store.state.user;
        },

        userLoadStatus() {
            return this.$store.state.userLoadStatus;
        },

        dialogLoginVisible() {
            return this.$store.state.dialogLoginVisible;
        }
    },

    methods: {
        login() {
            this.$store.commit('setDialogLoginVisible', true);
        }
    },

    watch: {
        dialogLoginVisible: function(value) {
            console.log(value);
        }
    }
}
</script>

<style scoped>

</style>