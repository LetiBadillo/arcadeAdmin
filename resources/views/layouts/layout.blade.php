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
</head>
<body>
<nav class="navbar fixed-bottom navbar-expand-sm navbar-dark">
      <a class="navbar-brand font-xl" href="#">Arcade</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav ml-auto font-md">
          <li class="nav-item active">
            <a class="nav-link" id="startLogin">START</a>
          </li>
          <!--<li class="nav-item">
            <a class="nav-link" href="#">Link</a>
          </li>-->
          <!--<li class="nav-item dropup">
            <a class="nav-link dropdown-toggle" href="#" id="dropdown10" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropup</a>
            <div class="dropdown-menu" aria-labelledby="dropdown10">
              <a class="dropdown-item" href="#">START</a>
              <a class="dropdown-item" href="#">Another action</a>
              <a class="dropdown-item" href="#">Salir</a>
            </div>
          </li>-->
        </ul>
      </div>
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
@yield('scripts')