@extends("layouts.main")

@section("header")
@include("layouts.navbar")
@endsection

@section("content")
	@include("layouts.jumbotron")
	
    <section class="container">
    	<div class="row">
          	<div class="col-md-8">
              	@foreach($articles as $key => $article)
              	<div class="card article-card">
                	<div class="card-body">
                  		<h4 class="card-title ">
                    		<a class="text-dark" href='{{url("/article/$article->id")}}'>
                    		{{$article->title}}</a>
                  		</h4>
                  
                  		@foreach($article->tags as $key => $tag)
                  		<a class="btn btn-sm btn-outline-secondary card-link" 
                  		href='{{url("/article/tag/$tag->id")}}'>
                    		<span class="fa fa-tag"></span>&nbsp;&nbsp;{{$tag->name}}
                  		</a>
                  		@endforeach
                  		<p class="card-text text-secondary clearfix">
                    		<span class="fa fa-clock-o">&nbsp;&nbsp;{{$article->published_at}}</span>
                    		&nbsp;&nbsp;
                    		<span class="fa fa-eye">&nbsp;&nbsp;{{$article->views}}</span>
                    		<a class=" pull-right" href='{{url("/article/$article->id")}}'>Read More</a>
                  		</p>
                	</div>
              	</div>
              	@endforeach
              	<nav class="page-nav center-pagination" aria-label="Page pagination">
              		{{ $articles->links() }}
              	</nav>
         	</div>
          	<div class="col-md-4">
          	  	<div class="card mt-4" >
          			<div class="card-header">Tags</div>
              		<div class="card-body">
                	@foreach($tags as $tag)
                		<a class="btn btn-sm btn-outline-secondary my-1" 
                		href='{{ url("/article/tag/$tag->id") }}'>{{ $tag->name }}</a>
                	@endforeach
              		</div>
            	</div>
            	<div class="card  mt-4">
                	<div class="card-header">Archive</div>
                	<div class="card-body">
                    	@foreach($years as $year)
                    	<p class="card-text text-primary clearfix">
                        	<a href='{{ url("/archive/$year->year") }}'>{{ $year->year }}</a>
     				    	<span class="pull-right">{{ $year->total }}篇</span>
                    	</p>
                    	@endforeach
                	</div>
            	</div>
          	</div>
         </div>
    </section>
@endsection

@section("footer")

@endsection