@extends('layouts.admin')

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
            <th scope="col">用户名</th>
            <th scope="col">邮箱</th>
            <th scope="col">管理员</th>
            <th scope="col">创建于</th>
            <th scope="col">更新于</th>
            <th scope="col">操作</th>
          </tr>
        </thead>
        <tbody>
          @foreach( $users as $key => $user )
          <tr>
            <th scope="row">{{$key+1}}</th>
            <td class="tag-name">{{$user->name}}</td>
            <td>{{$user->email}}</td>
            <td>{{$user->is_admin}}</td>
            <td>{{$user->created_at}}</td>
            <td>{{$user->updated_at}}</td>
            <td>
              <a class="btn btn-sm btn-link" href='{{url("/admin/user/edit/$user->id")}}'>
                <span class="fa fa-pencil-square-o text-dark"></span>
              </a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <nav class="page-nav right-pagination " role="Pagination" >
      {{$users->links()}}
      </nav>
    </section>

</section>
@endsection