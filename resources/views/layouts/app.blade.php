<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/10.4.1/styles/atom-one-dark-reasonable.min.css" integrity="sha512-DYEvxq+ESMe6pfhEV4PDJcYLuz3XZ3cp/RTUuAxblTKiIQ7O5Hf7cikoFPdfqrASCPLk5fYAhq8PwPoA7LBluw==" crossorigin="anonymous" />
    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                      @auth
                        <li class="nav-item">
                          <a href="{{ route('users.notifications') }}" class="nav-link">
                              <span class="badge badge-info">
                                  {{ auth()->user()->unreadNotifications->count() }}
                                  Unread notifications
                              </span>
                          </a>
                        </li>
                      @endauth
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

<div class="container bg-danger my-2">
    @if($errors->count()>0)
    <ul class="list-group-item">
        @foreach($errors->all() as $error)
          <li class="list-group-item text-danger">
              {{ $error }}
          </li>
        @endforeach
    </ul>
    @endif
</div>

        <div class="container mt-5">
            <div class="row">
            <div class="col-md-4">
                <a href="{{ route('discussions.create') }}" class="form-control btn btn-primary">Create a new discussion</a>
                <br>
                <br>
                <div class="card card-default">

                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <a href="/forum" style="text-decoration: none;">Home</a>
                            </li>
                         @if(Auth::check()) 
                            <li class="list-group-item">
                                <a href="/forum?filter=me" style="text-decoration: none;">My discussions</a>
                            </li>     
                         @endif
                            <li class="list-group-item">
                                <a href="/forum?filter=solved" style="text-decoration: none;">Solved discussions</a>
                            </li>    
                            <li class="list-group-item">
                                <a href="/forum?filter=unsolved" style="text-decoration: none;">Unsolved discussions</a>
                            </li>                                                   
                        </ul>
                    </div>
                    @if(Auth::check())
                    @if(Auth::user()->admin)
                       <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <a href="/channels" style="text-decoration: none;">Channels page</a>
                            </li>
                        </ul>
                       </div>    
                    @endif
                    @endif
                </div>
                <div class="card card-default mt-2">
                    <div class="card-header">
                      <strong>Channels :</strong>  
                    </div>

                    <div class="card-body">
                        <ul class="list-group">
                            @foreach($channels as $channel)
                                <li class="list-group-item">
                                    <a href="{{ route('channel', ['slug' => $channel->slug ]) }}" style="text-decoration: none;">{{ $channel->title }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                @yield('content')
            </div>
        </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="/js/app.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/10.4.1/highlight.min.js" integrity="sha512-DrpaExP2d7RJqNhXB41Q/zzzQrtb6J0zfnXD5XeVEWE8d9Hj54irCLj6dRS3eNepPja7DvKcV+9PnHC7A/g83A==" crossorigin="anonymous"></script>
<script>hljs.initHighlightingOnLoad();</script>
<script>
  @if(Session::has('success')) 
   toastr.success('{{ Session::get('success') }}');
  @endif 

</script>
</body>
</html>
