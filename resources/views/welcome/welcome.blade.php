@extends('layouts.layout')
@section('content')
<div class="container h-100">
  <div class="row h-100 justify-content-center align-items-center">
    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
        <form class="col-12 transparent-green" method="POST" action="{{ route('login') }}">
            <!--style="top: 8em;"-->
            @csrf
            <div class="form-group">
                <input type="text" name="email" class="form-control" placeholder="E-mail">
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Contraseña">
            </div>
            <br>
            <button type="submit" style="color: white;" class="button primary btn-block" id="login">START</button>
            <br>
            <a class="button btn-block text-center" href="{{ route('password.request') }}">
                           ¿Olvidaste tu contraseña?
            </a>
        </form> 
    </div>
  </div>
</div>
@endsection
@section('scripts')
@endsection