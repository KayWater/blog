<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        
        <!-- Styles -->
		<link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/4.1.0/css/bootstrap.min.css">
		<link href="https://cdn.bootcss.com/bootstrap-switch/4.0.0-alpha.1/css/bootstrap-switch.min.css" rel="stylesheet">
    	<link rel="stylesheet" type="text/css" href="{{asset('css/editor.css')}}">
    	
    	<!-- Scripts -->
    	<!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
        <script src="https://cdn.staticfile.org/jquery/3.2.1/jquery.min.js"></script>
         
        <!-- popper.min.js 用于弹窗、提示、下拉菜单 -->
        <script src="https://cdn.staticfile.org/popper.js/1.12.5/umd/popper.min.js"></script>
         
        <!-- 最新的 Bootstrap4 核心 JavaScript 文件 -->
        <script src="https://cdn.staticfile.org/twitter-bootstrap/4.1.0/js/bootstrap.min.js"></script>
        <script src="https://cdn.bootcss.com/bootstrap-switch/4.0.0-alpha.1/js/bootstrap-switch.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.min.js"></script>
        
        <script type="text/javascript" src="{{asset('js/plugins/ckeditor.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/admin.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/editor.js')}}"></script>
        <link rel="stylesheet" type="text/css" href="{{asset('css/basic.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('css/editor.css')}}">

    </head>
    <body>
      <section class="content-container container-fluid">
        <section class="aside">
          <h5>我的草稿 <span class="editor-status" id="editor-status"></span></h5>
          <ul class="nav flex-column draft-nav">
          @if(isset($article))
            <li class="nav-item active">
              <a class="nav-link" href='{{url("/admin/article/edit/{$article->draft_id}")}}'>
                <p class="draft-title">{{$article->title}}</p>
                <p class="draft-time">更新于：{{$article->updated_at}}</p>
              </a>
            </li>
          @endif
          @foreach($drafts as $index => $currentDraft)
             <li class="nav-item {{isset($draft) && $currentDraft->id == $draft->id ? 'active' : ''}}">
               <a class="nav-link" href='{{url("/admin/draft/edit/{$currentDraft->id}")}}'>
                 <p class="draft-title">{{$currentDraft->title ? $currentDraft->title : "无标题草稿"}}</p>
                 <p class="draft-time">更新于：{{$currentDraft->updated_at}}</p>
               </a>
             </li>
          @endforeach
          </ul>
        </section>
        <section class="editor-container">
          <form class="editor-form" id="articleForm" >
            @if(isset($draft))
            <input class="" id="articleId" name="articleId" type="hidden" value="0">
            <input class="" id="draftId" name="draftId" type="hidden" value="{{$draft->id}}">
            <input class="title" id="title" name="title" type="text" 
              placeholder="在此输入标题" value="{{$draft->title}}">
            <textarea name="content" id="editor" >{{$draft->content}}</textarea>
            @elseif(isset($article))
            <input class="" id="articleId" name="articleId" type="hidden" value="{{$article->id}}">
            <input class="" id="draftId" name="draftId" type="hidden" value="{{$article->draft_id}}">
            <input class="title" id="title" name="title" type="text" 
              placeholder="在此输入标题" value="{{$article->title}}">
            <textarea name="content" id="editor" >{{$article->content}}</textarea>
            @else
            <input class="" id="articleId" name="articleId" type="hidden" value="0">
            <input class="" id="draftId" name="draftId" type="hidden" value='0'>
            <input class="title" id="title" name="title" type="text" placeholder="在此输入标题">
            <textarea name="content" id="editor" ></textarea>
            @endif
          </form>
        </section>
        <section class="aside">
          <div>
          	<span>标签</span>
            <a class="btn btn-link align-baseline" data-toggle="collapse" 
             aria-expanded="false" data-target=".tag-form-container">
              <span class="fa fa-plus text-success"></span>
            </a>
          </div>
          <div class="tips text-info">
            <p>*必须选择1~3个标签</p>
            <p>*没有所需标签时，自行创建</p>
            <p>*标签不自动保存，只在发表时生效</p>
          </div>
          <div class="tag-form-container collapse">
            <section class="card ">
                <h6 class="card-header">添加标签</h6>
                <div class="card-body">
                  <form class="" id="tagForm" >
                    <input id="tagid" name="tagid" type="hidden" value='0'>
                    <div class="form-group row">
    				  <label class="col-form-label col-form-label-sm col-md-3">名称</label>
    				  <div class="col-md-9">
    				    <input class="form-control form-control-sm " id="tagname" name="tagname" type="text" 
    				    placeholder="请输入2~12位字符">
    				  </div>
                    </div>
                    <div class=" row">
                      <button class="btn btn-default btn-block btn-sm" id="store">保存</button>
                    </div>
                  </form>
                </div>
            </section>
          </div>
          <div class="tag-group line-check-group">
            @foreach($tags as $index => $tag)
              @if(isset($article->tags) && $article->tags->contains("id",  $tag->id))
              <div class="check-item line-check active">
                <input name="tags" id="tag{{$tag->id}}" type="checkbox" value="{{$tag->id}}" checked>
                <label class="line-check-label" for="tag{{$tag->id}}">{{$tag->name}}</label>
              </div>
              @elseif(isset($draft->tags) && $draft->tags->contains("id",  $tag->id))
              <div class="check-item line-check active">
                <input name="tags" id="tag{{$tag->id}}" type="checkbox" value="{{$tag->id}}" checked>
                <label class="line-check-label" for="tag{{$tag->id}}">{{$tag->name}}</label>
              </div> 
              @else
              <div class="check-item line-check">
                <input name="tags" id="tag{{$tag->id}}" type="checkbox" value="{{$tag->id}}">
                <label class="line-check-label" for="tag{{$tag->id}}">{{$tag->name}}</label>
              </div>
              @endif
            @endforeach
          </div>
          <button class="btn btn-success" id="save"  type="button" >发表</button>
        </section>
      </section>
    </body>
</html>