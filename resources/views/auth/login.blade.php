@extends('layouts.main')

@section('header')
@include('layouts.navbar')
@endsection

@section('content')
<div class="container">
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
                            	  <a class="d-inline-block" href="{{ url('auth/provider/weibo') }}">
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
</div>
@endsection
