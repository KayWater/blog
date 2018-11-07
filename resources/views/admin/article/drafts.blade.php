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
            <th scope="col">创建于</th>
            <th scope="col">更新于</th>
            <th scope="col">操作</th>
          </tr>
        </thead>
        <tbody>
          @foreach( $drafts as $key => $draft )
          <tr>
            <th scope="row">{{ $key+1 }}</th>
            <td class="tag-name">{{ $draft->title }}</td>
            <td>{{ $draft->created_at }}</td>
            <td>{{ $draft->updated_at }}</td>
            <td>
              <a class="btn btn-sm btn-link" href='{{ url("/admin/article/edit/$draft->id") }}'>
                <span class="fa fa-pencil-square-o text-dark"></span>
              </a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <nav class="page-nav right-pagination " role="Pagination" >
      {{ $drafts->links() }}
      </nav>
    </section>
   
  </section>

@endsection