@extends("layouts.main")

@section("header")
@include("layouts.navbar")
@include("layouts.jumbotron")
@endsection

@section("content")
  <section class="container mt-3">
    @foreach($tags as $tag)
      <a class="btn btn-outline-secondary" role="button" 
        href='{{url("article/tag/$tag->id")}}'>{{$tag->name}}</a>
    @endforeach
  </section> 
@endsection

@section("footer")

@endsection