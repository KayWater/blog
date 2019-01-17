@extends("layouts.main")

@push('scripts')
<script type="text/javascript" src="{{ asset('js/plugins/ckeditor.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/front-editor.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/plugins/comment.js') }}"></script>
@endpush

@section("header")
@include("layouts.navbar")
@endsection

@section("content")
  <section class="container mt-4">
  	<h3 class="text-center">{{$article->title}}</h3>
  	<div class="text-center">
  	@foreach($article->tags as $key => $tag)
  	  <a class="btn btn-link btn-sm" href='{{url("article/tag/$tag->id")}}'>
  	    <span class="fa fa-tag"></span>&nbsp;&nbsp;{{$tag->name}}
  	  </a>
  	@endforeach
  	</div>
  	<p class="text-center">{{$article->published_at}}</p>
  	<div id="editor">
  	{!! $article->content !!}
  	</div>
  </section>
  
  <section class="container mt-5">
  	 <div class="comment-container" id="commentContainer" data-id="{{ $article->id }}">
  	 
<!--   	<div class="comment-container" id="commentContainer" data-id="{{ $article->id }}"> -->
<!--   	  <div class=""> -->
<!--   	  	<textarea class="w-100 bg-light" id="comment" name="comment" row=3  -->
<!--   	  	max-length=140 placeholder="写下你的评论……"></textarea> -->
<!--   	  	<div class="comment-btn-group clearfix"> -->
<!--   	    	<button class="btn-send">发表</button> -->
<!--   	    </div> -->
<!--   	  </div> -->
<!--   	  <div class="comment-list"> -->
<!--   	  	<div class=""> -->
<!--   	  	</div> -->
<!--   	  	<div class="comment-item"> -->
<!--   	  	  <div class="comment-user">test 2018-4-4 -->
<!--   	  	  </div> -->
<!--   	  	  <p class="comment-content"> -->
<!--   	  	      特斯特斯特生态 -->
<!--   	  	  </p> -->
<!--   	  	  <div class="comment-toolbar"> -->
<!--   	  	    <a>赞</a> -->
<!--   	  	    <button class="btn btn-default" >回复</button> -->
<!--   	  	  </div> -->
<!--   	  	</div> -->
<!--   	  </div> -->
<!--   	</div> -->
  </section>
  
  <section class="container">
        <div id="cyReward" role="cylabs" data-use="reward"></div>
        <script type="text/javascript" charset="utf-8" src="https://changyan.itc.cn/js/lib/jquery.js"></script>
        <script type="text/javascript" charset="utf-8" src="https://changyan.sohu.com/js/changyan.labs.https.js?appid=cysTHKVjG"></script>
        <div id="SOHUCS" sid="{{ $article->id }}" ></div>
        <script type="text/javascript">
        (function(){ 
        var appid = 'cysTHKVjG';
        var conf = 'prod_abbaa8ccd9827912bcf9a9c0bbd7c384'; 
        var width = window.innerWidth || document.documentElement.clientWidth; 
        if (width < 960) { 
        window.document.write('<script id="changyan_mobile_js" charset="utf-8" type="text/javascript" src="https://changyan.sohu.com/upload/mobile/wap-js/changyan_mobile.js?client_id=' + appid + '&conf=' + conf + '"><\/script>'); } else { var loadJs=function(d,a){var c=document.getElementsByTagName("head")[0]||document.head||document.documentElement;var b=document.createElement("script");b.setAttribute("type","text/javascript");b.setAttribute("charset","UTF-8");b.setAttribute("src",d);if(typeof a==="function"){if(window.attachEvent){b.onreadystatechange=function(){var e=b.readyState;if(e==="loaded"||e==="complete"){b.onreadystatechange=null;a()}}}else{b.onload=a}}c.appendChild(b)};loadJs("https://changyan.sohu.com/upload/changyan.js",function(){window.changyan.api.config({appid:appid,conf:conf})}); } })(); 
        </script> 
  </section>
@endsection