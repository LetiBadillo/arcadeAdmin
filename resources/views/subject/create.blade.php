@extends('layouts.layout')
@section('content')
@include('partials.modal')
<div class="mb-6 container h-100" style="margin-bottom: 100px !important;">
  <div class="row h-100 justify-content-center align-items-center">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3">
        <div class="col-12 transparent-green p-5">
        <form method="POST" id="storeSubject" action="{{route('subjects.store')}}">
            @csrf
            <div class="row">
                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label class="form-check-label" for="level">Materia</label>
                    <input type="text" class="form-control" name="subject_name" placeholder="Materia">
                    <small id="subject_name_error" class="d-none feedback form-text bg-danger"></small>
                </div>
            
                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label class="form-check-label" for="level">Rama</label>
                    <select class="form-control" name="subject_branch_id" id="subject_brach">
                        <option value="">--Seleccionar--</option>
                    </select>
                    <small id="subject_branch_id_error" class="d-none form-text feedback bg-danger"></small>
                </div>
            </div>            
            <div class="form-group">
            <h5>Asignar maestros
            </h5>
            <small id="user_id_info" class="form-text feedback">Este campo no es requerido</small>
            <small id="user_id_error" class="d-none form-text feedback bg-danger"></small>
            <select style="width:100%;" class="multiselect" multiple="multiple" id="usersSelect" name="user_id[]">
            </select>
            </div>

            <label class="form-check-label" for="level">Nivel</label>
            <small id="level_error" class="d-none form-text feedback bg-danger"></small>
            <div class="form-check">
                <input type="radio" class="form-check-input" value="0"  name="level">
                <label class="form-check-label" name="level" for="level">Profesional</label>
            </div>
            <div class="form-check">
                <input type="radio" class="form-check-input" value="1" name="level">
                <label class="form-check-label" name="level"  for="level">Preparatoria</label>
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
        $('.materias').addClass('active');
        var allUsers = "{{url('users?ws=all')}}";
        var branches = "{{url('branches?ws=all')}}";
        
        fillSelect($('#usersSelect'), allUsers, 1);
        fillSelect($('#subject_brach'), branches, 0);
        saveForm($('#storeSubject'), "{{route('subjects.store')}}", 2);
    });
</script>
@endsection