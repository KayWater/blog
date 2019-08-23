<template>
    <div class='container'>
        <div class='row justify-content-center'>
            <div class='col-md-6'>
                <div class='card mt-5'>
                    <div class='card-header text-center'>登录</div>

                    <div class='card-body'>
                        <el-form ref='form' :model='form' >
                            <el-form-item label='邮箱'>
                                <el-input v-model='form.email'></el-input>
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
                                        <a class="pull-right" >
                                            忘记密码
                                        </a>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-5">
                <div class="card-header text-center">{{ __('登录') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="email" class="col-sm-4 col-form-label text-md-right">{{ __('邮箱') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" 
                            	class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" 
                            	name="email" value="{{ old('email') }}" required autofocus>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('密码') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" 
                                class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" 
                                name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row clearfix">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="remember" 
                                    id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        {{ __('记住我') }}
                                    </label>
                                </div>
                                <a class="pull-right" href="{{ route('password.request') }}">
                                    {{ __('忘记密码?') }}
                                </a>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4 text-center">
                                <button type="submit" class="btn btn-primary btn-block">
                                    {{ __('登录') }}
                                </button>  
                            </div>
                        </div>
                        <div class="form-group row mb-0 mt-4">
                        	<div class="col-md-6 offset-md-4">
                        	  <h6 class="text-center socialite-splitter">社交账号登录</h6>
                        	  <div class="socialite-container d-flex justify-content-around">
                            	  <a class="d-inline-block weibo-icon" href="{{ url('auth/provider/weibo') }}">
                            	    <span class="fa fa-weibo fa-2x"></span>
                            	  </a>
                        	  </div>
                        	</div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> -->
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
    }
}
</script>

<style scoped>
.socialite-container .weibo-icon {
	color: #ff0000;
}
</style>