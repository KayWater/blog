<template>
    <el-dialog title='Login' :visible.sync="dialogLoginVisible">
        <el-form ref='form' :model='form'>
            <el-form-item label='邮箱'>
                <el-input v-model='form.name'></el-input>
            </el-form-item>
            <el-form-item label='密码'>
                <el-input type='password' v-model='form.password' 
                autocomplete='off'></el-input>
            </el-form-item>
            <el-form-item label='密码'>
                <el-input type='password' v-model='form.password' 
                autocomplete='off'></el-input>
            </el-form-item>
            <el-form-item>
                <el-row type='flex' justify='space-between'>
                    <el-col :span=8>
                        <el-checkbox-group v-model='form.remember'>
                            <el-checkbox label="记住我"></el-checkbox>
                        </el-checkbox-group>
                    </el-col>
                    <el-col :span=8>
                        <a class="pull-right"> 忘记密码</a>
                    </el-col>
                </el-row>
            </el-form-item>
            <el-form-item>
                <el-button class="btn-block">登录</el-button>
            </el-form-item>
            <el-form-item>
                <el-divider>社交账号登录</el-divider>
                <div class="socialite-container d-flex justify-content-around">
                    <a class="d-inline-block weibo-icon" :href="'/auth/provider/weibo'">
                        <span class="fa fa-weibo fa-2x"></span>
                    </a>
                </div>
            </el-form-item>
        </el-form>
    </el-dialog>
</template>

<script>
    export default {
        data() {
            return {
                form: {
                    email: '',
                    password: '',
                    remember: false,
                }
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
            
        },

        watch: {

        }
    }
</script>

<style>

</style>