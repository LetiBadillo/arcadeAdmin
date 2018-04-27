@extends('layouts.layout')
@section('content')
<div class="container h-100">
  <div class="row h-100 justify-content-center align-items-center">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="col-12 transparent-green p-5">
        <form method="POST" action="{{route('subjects.store')}}">
            @csrf
            <div class="form-group">
                <label class="form-check-label" for="level">Materia</label>
                <input type="text" class="form-control" name="subject_name" placeholder="Materia">
                <small id="subject_name_error" class="d-none form-text bg-danger"></small>
            </div>
            <div class="form-group">
                <label class="form-check-label" for="level">Rama</label>
                <select class="form-control" name="subject_branch_id" id="subject_brach">
                    <option value="">--Seleccionar--</option>
                </select>
                <small id="subject_branch_id_error" class="d-none form-text bg-danger"></small>
            </div>
            <label class="form-check-label" for="level">Nivel</label>
            <small id="subject_branch_error" class="d-none form-text bg-danger"></small>
            <div class="form-check">
                <input type="radio" class="form-check-input" value="0"  name="level">
                <label class="form-check-label" name="level" for="level">Profesional</label>
            </div>
            <div class="form-check">
                <input type="radio" class="form-check-input" value="1" name="level">
                <label class="form-check-label" name="level"  for="level">Preparatoria</label>
            </div>
            <br>
            <hr>
            <h5>Asignar maestros <span class="fa fa-plus-circle" ></span></h5>
            <small id="subject_branch_error" class="d-none form-text bg-danger"></small>
            <select style="width:100%;" class="multiselect" multiple="multiple" id="usersSelect" name="users[]">
            </select>
            <br>
            <button type="submit" style="color: white;" class="button purple btn-block" id="login">GUARDAR</button>
            <br>
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
    });
</script>
@endsection