@extends("layouts.main")

@section("header")
@include("layouts.navbar")
@include("layouts.jumbotron")
@endsection

@section("content")
    <section class="container">
      @foreach($years as $year)
      	{{ $year }}
      @endforeach
      @foreach($articles as $key => $article)
      <div class="card article-card">
        <div class="card-body">
          <h4 class="card-title ">
            <a class="text-dark" href='{{url("/article/$article->id")}}'>{{$article->title}}</a>
          </h4>
          
          @foreach($article->tags as $key => $tag)
          <a class="btn btn-sm btn-outline-secondary card-link" href='{{url("/article/tag/$tag->id")}}'>
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
    </section> 
@endsection