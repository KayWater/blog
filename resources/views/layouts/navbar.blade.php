<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="{{url('article')}}">文章</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{url('archive')}}">归档</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{url('tags')}}">标签</a>
        </li>
      </ul>
      <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-secondary my-2 my-sm-0" type="submit">Search</button>
      </form>
      <!-- Authentication Links -->
      <ul class="navbar-nav ml-auto">
      @guest
        <li class="nav-item">
          <a class="nav-link" href="{{ route('login') }}">{{ __('登录') }}</a>
        </li>
        <li class="nav-item">
        @if (Route::has('register'))
          <a class="nav-link" href="{{ route('register') }}">{{ __('注册') }}</a>
        @endif
        </li>
      @else
        <li class="nav-item dropdown">
          <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" 
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            {{ Auth::user()->name }} <span class="caret"></span>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="{{ route('logout') }}"
              onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                  {{ __('Logout') }}
            </a>
    
            <form id="logout-form" action="{{ route('logout') }}" method="POST" 
              style="display: none;">
              @csrf
            </form>
          </div>
        </li>
      @endguest
    </ul>
  </div>
</nav>
  