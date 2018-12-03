
<aside class="aside-md" id="aside-bar">
  <ul class="nav flex-column aside-nav">
    <li class="nav-item ff-dropdown" data-module="user">
	  <a class="ff-dropdown-toggle nav-link" data-toggle="collapse" role="button" 
	  href="#multiCollapseExample1" aria-expanded="true" aria-controls="multiCollapseExample1" id="submenu2">
		<span class="icon"><span class="fa fa-book"></span></span>
		<span>用户管理</span>
		<span class="pull-right">
		  <span class="fa fa-angle-down toggle-fa"></span>
		  <span class="fa fa-angle-up toggle-fa d-none "></span>
		</span>
	  </a>
	  <ul class="nav nav-fill sub-nav ff-dropdown-menu collapse" id="multiCollapseExample1" data-labelledby="submenu2">
		<li class="nav-item" data-page="local">
		  <a class="nav-link" href='{{url("/admin/user/local")}}'>
			<span class="icon"><span class="fa fa-angle-right"></span></span>
			<span>本地用户</span>	
		  </a>
		</li>
		<li class="nav-item" data-page="socialite">
	      <a class="nav-link" href='{{url("/admin/user/socialite")}}'>
			<span class="icon"><span class="fa fa-angle-right"></span></span>
			<span>社交用户</span>
		  </a>
		</li>
	  </ul>
	</li>
	<li class="nav-item ff-dropdown" data-module="article">
	  <a class="ff-dropdown-toggle nav-link" data-toggle="ff-dropdown" id="submenu2">
		<span class="icon"><span class="fa fa-book"></span></span>
		<span>文章管理</span>
		<span class="pull-right">
		  <span class="fa fa-angle-down toggle-fa"></span>
		  <span class="fa fa-angle-up toggle-fa d-none "></span>
		</span>
	  </a>
	  <ul class="nav nav-fill sub-nav ff-dropdown-menu" data-labelledby="submenu2">
		<li class="nav-item" data-page="write">
		  <a class="nav-link" href='{{url("/admin/article/edit")}}'>
			<span class="icon"><span class="fa fa-angle-right"></span></span>
			<span>文章编辑</span>	
		  </a>
		</li>
		<li class="nav-item" data-page="lists">
	      <a class="nav-link" href='{{url("/admin/article")}}'>
			<span class="icon"><span class="fa fa-angle-right"></span></span>
			<span>文章列表</span>
		  </a>
		</li>
		<li class="nav-item" data-page="drafts">
		  <a class="nav-link" href='{{url("/admin/draft")}}'>
		    <span class="icon"><span class="fa fa-angle-right"></span></span>
		    <span>草稿列表</span>
		  </a>
		</li>
	  </ul>
	</li>
	<li class="nav-item" >
	  <a class="nav-link" href="/admin/tags" data-page="tag">
	    <span class="icon"><span class="fa fa-tags"></span></span>
	    <span>标签管理</span>
	    <span class="pull-right">
		  <span class="fa fa-angle-right"></span>
		</span>
	  </a>
	</li>
  </ul>
</aside>
