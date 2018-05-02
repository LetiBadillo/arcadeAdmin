@extends('layouts.layout')
@section('content')
@include('partials.modal')
<div class="mb-6 container h-100" style="margin-bottom: 100px !important;">
  <div class="row h-100 justify-content-center align-items-center">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3">
        <div class="col-12 transparent-green p-5">
        <form method="POST" id="storeSubject" action="{{route('subjects.store')}}">
            @csrf
            @include('partials.user.register')            
            <div class="form-group">
            <h5>Asignar materia
            </h5>
            <small id="user_id_error" class="d-none form-text feedback bg-danger"></small>
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
        var branches = "{{url('branches?ws=all')}}";

        fillSelect($('#subjectsSelect'), allSubjects, 1);
        saveForm($('#storeSubject'), "{{route('subjects.store')}}");
    });
</script>
@endsection