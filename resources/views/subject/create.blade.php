@extends('layouts.layout')
@section('content')
<div class="container h-100">
  <div class="row h-100 justify-content-center align-items-center">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="col-12 transparent-green p-5">
        <form action="{{route('subjects.create')}}">
            <div class="form-group">
                <input type="text" class="form-control" name="branch_name" placeholder="Materia">
                <small id="branch_name_error" class="d-none form-text bg-danger"></small>
            </div>
            <div class="form-group">
                <select class="form-control" name="subject_branch" id="subject_brach">
                    <option value="">Rama</option>
                </select>
                <small id="subject_branch_error" class="d-none form-text bg-danger"></small>
            </div>
            <label class="form-check-label" for="level">Nivel</label>
            <small id="subject_branch_error" class="d-none form-text bg-danger"></small>
            <div class="form-check">
                <input type="radio" class="form-check-input" name="level">
                <label class="form-check-label" for="exampleCheck1">Profesional</label>
            </div>
            <div class="form-check">
                <input type="radio" class="form-check-input" name="level">
                <label class="form-check-label" for="exampleCheck1">Preparatoria</label>
            </div>
            <br>
            <hr>
            <select class="multiselect" multiple="multiple" id="usersSelect" name="my-select[]">
                <option value='elem_1'>elem 1</option>
                <option value='elem_2'>elem 2</option>
                <option value='elem_3'>elem 3</option>
                <option value='elem_4'>elem 4</option>
                <option value='elem_100'>elem 100</option>
            </select
            <button type="submit" style="color: white;" class="button tertiary btn-block" id="login">GUARDAR</button>
            <br>
            </form>
        </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
@endsection