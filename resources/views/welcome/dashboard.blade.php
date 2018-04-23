@extends('layouts.layout')
@section('content')
<div class="container h-100">
    <div class="row align-items-center h-100">
        <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 mx-auto">
            <form class="col-12 contentOnTop">
                    <div class="form-group">
                        <input type="text" class="form-control" id="formGroupExampleInput" placeholder="E-mail">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="formGroupExampleInput2" placeholder="Contraseña">
                    </div>
                    <br>
                    <button type="button" style="color: white;" class="btn primary btn-block" id="login">START</button>
                </form> 
           <div style="height: 250px;"  class="jumbotron transparent-green"></div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@endsection