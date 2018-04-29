@extends('layouts.layout')
@section('content')
<div class="container h-100">
  <div class="row h-100 justify-content-center align-items-center">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="col-12 transparent-green p-5">
            <table class="table results table-hover">
                <thead>
                    <tr>
                    <th scope="col">+</th>
                    <th scope="col">Ética</th>
                    <th scope="col">Blanca Leticia Badillo Guzmán</th>
                    </tr>
                </thead>
            </table>
            <form method="POST" id="storeSubject" action="{{route('subjects.store')}}">
            @csrf       
            <div class="form-group">
            <h5>Preguntas
            <small><button type="button" style="color: white;" class="button" id="login">agregar pregunta</button></small>
            </h5>
            <small id="user_id_error" class="d-none form-text feedback bg-danger"></small>
            <br>
            </form>

            <table class="table align-middle results table-hover">
            <table class="table results table-hover">
                <thead>
                    <tr>
                    <th scope="col">+</th>
                    <th scope="col">Pregunta</th>
                    <th scope="col">Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <th scope="col" class="align-middle" >+</th>
                    <th scope="col" class="align-middle" >¿Qué buscaba el utilitarismo?</th>
                    <th scope="col">
                        <ul>
                            <li>Paz mundial</li>
                            <li>Igualdad de género</li>
                            <li>Beneficiar a la mayoría</li>
                            <li class="text-primary">
                                <u>Que cada quién reciba por lo que trabajó</u></li>
                        </ul>
                    </th>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
<script>
    $('#inicio').removeClass('active');
    $(function() {
        $('.materias').addClass('active');

    });
</script>
@endsection