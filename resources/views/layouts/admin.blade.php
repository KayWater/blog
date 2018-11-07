<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
        
        <!-- Styles -->
		<link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/4.1.0/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/4.0.0-alpha.1/css/bootstrap-switch.min.css" />
    	<link rel="stylesheet" type="text/css" href="{{asset('css/basic.css')}}">
    	<link rel="stylesheet" type="text/css" href="{{asset('css/admin.css')}}">
    	
    	<!-- Scripts -->
    	<!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
        <script src="https://cdn.staticfile.org/jquery/3.2.1/jquery.min.js"></script>
         
        <!-- popper.min.js 用于弹窗、提示、下拉菜单 -->
        <script src="https://cdn.staticfile.org/popper.js/1.12.5/umd/popper.min.js"></script>
         
        <!-- 最新的 Bootstrap4 核心 JavaScript 文件 -->
        <script src="https://cdn.staticfile.org/twitter-bootstrap/4.1.0/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/4.0.0-alpha.1/js/bootstrap-switch.min.js"></script>
        @stack('scripts')
    </head>
    <body>
    	<nav class="navbar navbar-expand-lg navbar-light bg-light">
    		<a class="navbar-brand" href="#">玩玩而已</a>
    		<button class="navbar-toggler" type="button" data-toggle="collapse" 
    		  data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" 
    		  aria-expanded="false" aria-label="Toggle navigation">
                 <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
              <ul class="navbar-nav ">
                <li class="nav-item dropdown">
    				<a class="nav-link nav-item dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown" 
    				 aria-haspopup="true" aria-expanded="false" role="button">
    					<span id="admin">{{ Auth::user()->name }}</span>
    				</a>
    				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
    
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
    			</li>
              </ul>
            </div>
    	</nav>
    	<section class="main">
    	@section('aside')
        @show()
        
        @section('content')
        test
        @show()
        </section>
    </body>
</html>
