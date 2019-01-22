@extends('layouts.admin')

@push("scripts")
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.min.js"></script>
  <script src="{{asset('js/admin.js')}}"></script>
   
@endpush

@section('aside')
  @include('layouts.aside')
@endsection

@section('content')
  <section class="content-container container-fluid">
  	<section class="table-responsive">
      <table class="table table-striped ">
        <thead class="thead-light">
          <tr>
            <th scope="col">#</th>
            <th scope="col">名称</th>
            <th scope="col">标签</th>
            <th scope="col">浏览量</th>
			<th scope="col">发表于</th>
            <th scope="col">更新于</th>
            <th scope="col">操作</th>
          </tr>
        </thead>
        <tbody>
          @foreach( $articles as $key => $article )
          <tr>
            <th scope="row">{{ $key+1 }}</th>
            <td class="tag-name">{{ $article->title }}</td>
            <td>
              @foreach( $article->tags as $key => $tag )
                <a class="" href="">{{ $tag->name }}</a>
              @endforeach
            </td>
            <td>{{ $article->views }}
            <td>{{ $article->published_at }}</td>
            <td>{{ $article->updated_at }}</td>
            <td>
              <a class="btn btn-sm btn-link" href='{{url("/admin/article/edit/$article->id")}}'>
                <span class="fa fa-pencil-square-o text-dark"></span>
              </a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <nav class="page-nav right-pagination " role="Pagination" >
      {{ $articles->links() }}
      </nav>
    </section>
   
  </section>

@endsection