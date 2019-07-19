<!doctype html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
     <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Blog</title>

    <!-- Fonts -->
     <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />

	 <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

	<!-- Scripts -->
	<!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
<!--     <script src="https://cdn.staticfile.org/jquery/3.2.1/jquery.min.js"></script> -->
     
    <!-- popper.min.js 用于弹窗、提示、下拉菜单 -->
<!--     <script src="https://cdn.staticfile.org/popper.js/1.12.5/umd/popper.min.js"></script> -->
     
    <!-- 最新的 Bootstrap4 核心 JavaScript 文件 -->
<!--     <script src="https://cdn.staticfile.org/twitter-bootstrap/4.1.0/js/bootstrap.min.js"></script> -->
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/4.0.0-alpha.1/js/bootstrap-switch.min.js" defer></script>
    
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.min.js" defer></script>
    
    <script src="{{ asset('js/basic.js') }}" defer></script>
    @stack("scripts")
    
        <!-- Styles -->
<!--     <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/4.1.0/css/bootstrap.min.css"> -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/4.0.0-alpha.1/css/bootstrap-switch.min.css" />
        <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
  	<link rel="stylesheet" href="{{asset('css/basic.css')}}">
	<link rel="stylesheet" href="{{asset('css/main.css')}}">

  </head>
  <body>
      <div id="app">
        @section("header")
        
        @show
        
        @section("content")
        
        @show
        
        @section("footer")
        
        @show
      </div>
  </body>
</html>