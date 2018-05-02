@extends('layouts.layout')
@section('content')
@include('partials.modal')
<div class="mb-6 container h-100" style="margin-bottom: 100px !important;">
  <div class="row h-100 justify-content-center align-items-center">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3">
        <div class="col-12 transparent-green p-5">
        <form method="POST" id="storeUser" action="{{route('subjects.store')}}">
            @csrf
            <div class="row">
                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label class="form-check-label" for="level">Nombre</label>
                    <input type="text" class="form-control" name="name" placeholder="Nombre">
                    <small id="name_error" class="d-none feedback form-text bg-danger"></small>
                </div>
                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label class="form-check-label" for="level">Apellido</label>
                    <input type="text" class="form-control" name="last_name" placeholder="Apellido">
                    <small id="last_name_error" class="d-none form-text feedback bg-danger"></small>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label class="form-check-label" for="level">Contraseña</label>
                    <input type="password" class="form-control" name="password" placeholder="Contraseña">
                    <small id="pasword_error" class="d-none feedback form-text bg-danger"></small>
                </div>
                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label class="form-check-label" for="level">Repetir contraseña</label>
                    <input type="password" class="form-control" name="password_confirmation" placeholder="Repetir contraseña">
                    <small id="password_confirmation_error" class="d-none form-text feedback bg-danger"></small>
                </div>
            </div>      
            <div class="row">
            <div class="form-group col-lg-12">
                    <label class="form-check-label" for="level">Correo electrónico</label>
                    <input type="email" class="form-control" name="email" placeholder="E-mail">
                    <small id="email_error" class="d-none form-text feedback bg-danger"></small>
            </div>  
            </div>   
            <div class="form-group">
                <h5>Asignar materia
                </h5>
                <small id="subject_id_error" class="d-none form-text feedback bg-danger"></small>
                <select style="width:100%;" class="multiselect" multiple="multiple" id="subjectsSelect" name="subjects[]">
                </select>
            </div>
            <br>
            <button type="submit" style="color: white;" class="button purple btn-block " id="save">GUARDAR</button>
            </form>
        </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
<script>
    $('#inicio').removeClass('active');
    $(function() {
        $('.usuarios').addClass('active');
        var allSubjects = "{{url('subjects?ws=all')}}";

        fillSelect($('#subjectsSelect'), allSubjects, 1);
        saveForm($('#storeUser'), "{{route('users.store')}}", 2);
    });
</script>
@endsection