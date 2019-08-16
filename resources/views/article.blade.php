@extends("layouts.main")

@push('scripts')
<!-- <script src="{{ asset('js/plugins/ckeditor.js') }}" defer></script> -->

<link href="{{ asset('css/comment.css') }}" rel="stylesheet">
<!-- <script src='{{ asset("js/commentbackup.js") }}' defer></script> -->

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
  	<div id="editor" class="ck-content">
  	{!! $article->content !!}
  	</div>
  </section>
  
  <section class="container mt-4 ">
<!--     	<div class="mt-2"> -->
<!--   		<form class="comment-form" id="commentForm" > -->
<!--   			<input id="postId" name="postId"  type="hidden" value="{{ $article->id }}"> -->
<!--   			<div class="form-group"> -->
<!--   				<label for="comment">评论</label> -->
<!-- 				<textarea name="comment" id="commentEditor"></textarea> -->
<!--   			</div> -->
<!--   			<div class="form-group text-right"> -->
<!--       			@if(Auth::check()) -->
<!--       			<button type="submit" id="commentSubmit" class="btn btn-primary "> -->
<!--       			<span class="fa fa-comment-o fa-flip-horizontal"></span>&nbsp;&nbsp;评论</button> -->
<!--       			@else -->
<!--       			<button type="button" class="btn btn-primary login-required"> -->
<!--       			<span class="fa fa-comment-o fa-flip-horizontal"></span>&nbsp;&nbsp;评论</button> -->
<!--       			@endif -->
<!--   			</div> -->
<!--   		</form> -->

  	</section>
    
@endsection