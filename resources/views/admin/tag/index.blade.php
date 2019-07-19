@extends('layouts.admin')

@push("scripts")
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.min.js" defer></script>
  <script src="{{asset('js/admin.js')}}" defer></script>
   
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
            <th scope="col">状态</th>
            <th scope="col">热度</th>
            <th scope="col">操作</th>
          </tr>
        </thead>
        <tbody>
          @foreach( $tags as $key => $tag )
          <tr>
            <th scope="row">{{ $key+1 }}</th>
            <td class="tag-name">{{ $tag->name }}</td>
            <td>
              <div class="switch" >
                <input class="bootstrap-switch tag-status-switch" data-on-color="success" 
                data-off-color="info" data-tag-id="{{$tag->id}}" name="tagStatus" 
                type="checkbox" data-size="mini" {{ $tag->status ? "checked" : "" }} />
              </div>
            </td>
            <td>{{ $tag->articles_count }}</td>
            <td>
              <button class="btn btn-sm btn-link tag-edit-btn" data-tag-id="{{$tag->id}}" 
              data-control='tagForm' type="button" >
                <span class="fa fa-pencil-square-o text-dark"></span>
              </button>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <nav class="page-nav right-pagination " role="Pagination" >
      {{ $tags->links() }}
      </nav>
    </section>
    <section>
      	<div class="col-md-3">
          <section class="card ">
            <h5 class="card-header">添加|修改标签</h5>
            <div class="card-body">
              <form class="" id="tagForm" >
                <input id="tagid" name="tagid" type="hidden" value='0'>
                <div class="form-group row">
				  <label class="col-form-label col-md-3">名称</label>
				  <div class="col-md-9">
				    <input class="form-control" id="tagname" name="tagname" type="text" 
				    placeholder="请输入2~18位字符">
				  </div>
                </div>
                <div class="form-group row">
                  <label class="col-form-label col-md-3">状态</label>
                  <div class="col-md-9">
                	<div class="switch" >
                	  <input class="form-check-input bootstrap-switch" 
                	  data-on-color="success" data-off-color="info" type="checkbox" 
                	  id="tagStatus" name="tagInitialStatus" checked />
                	</div>
                  </div>
                </div>
                <div class="form-group row">
                  <button class="btn btn-default btn-block" id="save">保存</button>
                </div>
              </form>
            </div>
          </section>
        </div>
    </section>
  </section>

@endsection