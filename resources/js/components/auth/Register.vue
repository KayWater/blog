<template>
    <div class='container'>
        <div class='row justify-content-center'>
            <div class='col-md-6'>
                <div class='card mt-5'>
                    <div class='card-header text-center'>账号注册</div>
                    <div class='card-body'>
                        <el-form ref='form' :model='form' :rules='rules'>
                            <el-form-item prop="username" :error='errorMessages.username'>
                                <el-input placeholder="请输入2~18位字符" v-model='form.username'>
                                    <template slot="prepend">用户名</template>
                                </el-input>
                            </el-form-item>
                            <el-form-item prop='email' :error='errorMessages.email'>
                                <el-input placeholder="请输入邮箱地址" v-model='form.email'>
                                    <template slot="prepend">邮箱</template>
                                </el-input>
                            </el-form-item>
                            <el-form-item prop='password' :error="errorMessages.password">
                                <el-input placeholder="请输入密码" type='password' 
                                v-model='form.password' autocomplete='off'>
                                    <template slot="prepend">密码</template>
                                </el-input>
                            </el-form-item>
                            <el-form-item prop='confirmPassword' :error="errorMessages.confirmPassword">
                                <el-input placeholder="请再次输入密码" type='password' 
                                v-model="form.confirmPassword" autocomplete='off'>
                                    <template slot="prepend">确认密码</template>
                                </el-input>
                            </el-form-item>
                            <el-form-item>
                                <el-button class="btn-block" @click="register()">注册</el-button>
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
        /**
         * Validate password
         */
        var validatePassword = (rule, value, callback) => {
            if (value === '') {
                callback(new Error('请输入密码'));
            } else {
                if (this.form.confirmPassword !== '') {
                    this.$refs.form.validateField('confirmPassword');
                }
                callback();
            }
        };
        /**
         * Validate confirmPassword 
         */
        var validateConfirmPassword = (rule, value, callback) => {
            if (value === '') {
                callback(new Error('密码不能为空'));
            } else if (value !== this.form.password) {
                callback(new Error('两次输入密码不一致！'));
            } else {
                callback();
            }
        };
        return {
            form: {
                username: 'echo',
                email: '793500318@qq.com',
                password: '123456',
                confirmPassword: '123456',
            },
            rules: {
                username: [
                    { required: true, message: '请输入用户名', trigger: 'blur' },
                    { min: 2, max: 18, message: '请输入2~18位字符', trigger: 'blur' },
                ],
                email: [
                    { required: true, message: '请输入邮箱地址', trigger: 'blur' },
                    { type: 'email', message: '请输入合法的邮箱地址', trigger: 'blur' }
                ],
                password: [
                    { required: true, message: '请输入密码', trigger: 'blur' },
                    { min: 6, message: '请输入至少6位字符', trigger: 'blur' },
                    { validator: validatePassword, trigger: 'blur'},
                ],
                confirmPassword: [
                    { required: true, message: '请再次输入密码', trigger: 'blur' },
                    { validator: validateConfirmPassword, trigger: 'blur' },
                ]
            },
            errorMessages: {
                username: '',
                email: '',
                password: '',
                confirmPassword: '',
            }
        }
    },
    methods: {
        /**
         * Handle register action
         */
        register() {
            let vm = this;
            vm.clearErrorMessages();

            vm.$refs.form.validate((valid) => {
                if(valid) {
                    vm.$store.dispatch('auth/register', this.form)
                        .then(function(response){
                            vm.$message({
                                message: '账号注册成功',
                                type: 'success',
                                center: 'true',
                            })
                        }).catch(function(response){
                            for(let [key, value] of Object.entries(response)) {
                                vm.errorMessages[key] = value[0];
                            }
                        });
                } else {
                    console.log('error');
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

</style>