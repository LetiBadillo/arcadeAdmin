<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Arcade</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/styles.css')}}">
    <link rel="stylesheet" href="{{asset('css/fontawesome-all.css')}}">
    <link rel="stylesheet" href="{{asset('css/multi-select.css')}}">
</head>
<body>
<nav class="navbar fixed-bottom navbar-expand-sm navbar-dark">
      <a class="navbar-brand font-xl" href="#">Arcade</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      @if(Auth::user())
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav ml-auto font-md">
          <li class="nav-item active" id="inicio">
            <a href="{{url('/')}}" class="nav-link">INICIO</a>
          </li>
          <li class="materias nav-item dropup">
            <a class="nav-link" href="#" id="dropdown10" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">MATERIAS </a>
            <div class="dropdown-menu" aria-labelledby="dropdown10">
              <a class="dropdown-item" href="{{url('subjects')}}">VER</a>
              <a class="dropdown-item" href="{{url('subjects/create')}}">CREAR</a>
            </div>
          </li>
          <li class="usuarios nav-item dropup">
            <a class="nav-link" href="#" id="dropdown10" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">USUARIOS </a>
            <div class="dropdown-menu" aria-labelledby="dropdown10">
            <a class="dropdown-item" href="{{url('users')}}">VER</a>
            <a class="dropdown-item" href="{{url('users/create')}}">CREAR</a>
            </div>
          </li>
          <li class="cuenta nav-item dropup">
            <a class="nav-link" href="#" id="dropdown10" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">CUENTA </a>
            <div class="dropdown-menu" aria-labelledby="dropdown10">
            <a class="dropdown-item" href="{{url('users')}}">CONTRASEÑA</a>
            <a class="dropdown-item" href="{{url('users/create')}}">CREAR</a>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">SALIR</a>            
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>                           
          </li>
          
        </ul>
      </div>
      @endif
    </nav>
    <div id="mainCarousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner" role="listbox">
            <div class="carousel-item active">
                <img class="d-block img-fluid" src="{{asset('images/bg2.jpg')}}" alt="First slide">
            </div>
            <div class="carousel-item">
                <img class="d-block img-fluid" src="{{asset('images/bg.jpg')}}" alt="Second slide">
            </div>
            <div class="carousel-item">
                <img class="d-block img-fluid" src="{{asset('images/bg3.jpg')}}" alt="Third slide">
            </div>
        </div>
    </div>
        @yield('content')
</body>
</html>
<script src="{{asset('js/app.js')}}"></script>
<script>
  var search_url = '';
</script>
<script src="{{asset('js/scripts.js')}}"></script>
<script src="{{asset('js/jquery.multi-select.js')}}"></script>
<script src="{{asset('js/jquery.quicksearch.js')}}"></script>
@yield('scripts')