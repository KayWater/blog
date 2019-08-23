<template>
    <div class='container'>
        <nav class='navbar navbar-expand-lg navbar-light bg-light'>
            <a class='navbar-brand' href='/'>PIBlog</a>
            <button class='navbar-toggler' type='button' data-toggle='collapse'
            data-target='navbarSupportedContent' aria-controls='navbarSupportedContent'
            aria-expanded='false' aria-label='Toggle navigation'>
                <span class='navbar-toggler-icon'></span>
            </button>

            <div class='collapse navbar-collapse' id='navbarSupportedContent'>
                <ul class='navbar-nav mr-auto'>
                    <li class='nav-item'>
                        <router-link class='nav-link' to='/articles'>文章</router-link>
                        
                    </li>
                </ul>
                <form class='form-inline my-2 my-lg-0' id='searchForm'>
                    <input class='form-control mr-sm-2' type='search' id='search'
                    name='search' placeholder='search' aria-label='Search'>
                    <button class='btn btn-outline-secondary my-2 my-sm-0' id='save'
                    type='submit'>Search</button>
                </form>

                <ul class='navbar-nav ml-auto'>
                    <li class="nav-item">
                        <router-link class='nav-link' to='/login'>登录</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class='nav-link' to='/register'>注册</router-link>
                    </li>
                </ul>
            </div>
        </nav> 
    </div>
    <!-- <div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <ul class="navbar-nav ml-auto">
         	@if( Auth::check() || Auth::guard('socialite')->check() )
            <li class="nav-item dropdown">
              <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" 
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                @if(Auth::check()) 
                  {{ Auth::user()->name }}
                @elseif(Auth::guard('socialite')->check())
                  {{  Auth::guard('socialite')->user()->nickname }}
                @endif
                <span class="caret"></span>
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
          	@else
            <li class="nav-item">
              <a class="nav-link" href="{{ route('login') }}">{{ __('登录') }}</a>
            </li>
            <li class="nav-item">
            @if (Route::has('register'))
              <a class="nav-link" href="{{ route('register') }}">{{ __('注册') }}</a>
            @endif
            </li>
          @endif
        </ul>
      </div>
    </nav>
</div> -->

</template>

<script>
export default {
    
}
</script>

<style scoped>

</style>