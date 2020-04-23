<template>
    <div class='container'>
        <div class='row justify-content-center'>
            <div class='col-md-6'>
                <div class='card mt-5'>
                    <div class='card-header text-center'>登录</div>

                    <div class='card-body'>
                        <el-form ref='form' :model='form' :rules='rules'>
                            <el-form-item prop="email" :error="errorMessages.email">
                                <el-input v-model='form.email'>
                                    <template slot='prepend'>邮箱</template>
                                </el-input>
                            </el-form-item>
                            <el-form-item prop='password' :error="errorMessages.password">
                                <el-input type='password' v-model='form.password' 
                                autocomplete='off'>
                                    <template slot='prepend'>密码</template>
                                </el-input>
                            </el-form-item>
                            <el-form-item>
                                <el-row type='flex' justify='space-between'>
                                    <el-col :span=8>
                                        <el-checkbox-group v-model='form.remember'>
                                            <el-checkbox label="记住我"></el-checkbox>
                                        </el-checkbox-group>
                                    </el-col>
                                    <el-col :span=8>
                                        <a class="pull-right" >
                                            忘记密码
                                        </a>
                                    </el-col>
                                </el-row>
                            </el-form-item>
                            <el-form-item>
                                <el-button class="btn-block" @click='login()'>登录</el-button>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            form: {
                email: '793500318@qq.com',
                password: '111111',
                remember: false,
            },
            rules: {
                email: [
                    { required: true, message: '请输入邮箱地址', trigger: 'blur' },
                    { type: 'email', message: '请输入合法的邮箱地址', trigger: 'blur' }
                ],
                password: [
                    { required: true, message: '请输入密码', trigger: 'blur' },
                    { min: 6, message: '请输入至少6位字符', trigger: 'blur' },
                ],
            },
            errorMessages: {
                email: '',
                password: '',
            },
        }
    },

    methods: {
        /**
         * Handle login action
         */
        login() {
            let vm = this;
            vm.clearErrorMessages();

            vm.$refs.form.validate((valid) => {
                if(valid) {
                    vm.$store.dispatch('auth/login', this.form)
                        .then(function(response){
                            vm.$router.go(-1);
                        }).catch(function(response){
                            for(let [key, value] of Object.entries(response)) {
                                vm.errorMessages[key] = value[0];
                            }
                        });
                } else {
                    vm.$message({
                        message: '登录失败',
                        type: 'error',
                    });
                    return;
                }
            })
        },

        /**
         * Clear error messages
         */
        clearErrorMessages() {
            for(let [key, value] of Object.entries(this.errorMessages)) {
                this.errorMessages[key] = '';
            }
        }
    }
}
</script>

<style scoped>
.socialite-container .weibo-icon {
	color: #ff0000;
}
</style>