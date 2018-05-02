@php
$action = '' ;
$menu_enable = '';
$status = '';
if(Auth::user()->user_type == 1 || Auth::user()->id == $user->id){

    if($user->enabled == 1){
        $action = 'desactivará';
        $menu_enable = '<i class="fas fa-ban"></i> Desactivar';
        $status = "Activo";

    }else{
        $action = 'activará';
        $menu_enable = '<i class="fas fa-check"></i> Activar';
        $status = "Inactivo";
    }
}
@endphp
@extends('layouts.layout')
@section('content')
@include('partials.modal')
<div class="mb-6 container h-100 mbottom mt-2">
  <div class="row h-100">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="col-12 transparent-green p-5">
            <h1 style="margin: 0; display: inline-block;">
            @if(Auth::user()->user_type == 1 || Auth::user()->id == $user->id)
            <div style="float: left;" class="dropdown">
                <button type="button" class="btn btn-link text-light" data-toggle="dropdown">
                <h2><i class="fas fa-bars"></i></h2>
                </button>
                <div class="dropdown-menu">
                    <a id="editUserButton" class="dropdown-item" href="#"><i class="far fa-edit"></i> Editar</a>
                    @if(Auth::user()->user_type == 1 && Auth::user()->id != $user->id)
                    <a id="enableUser" class="dropdown-item" href="#">  {!! $menu_enable !!}</a>
                    @endif
                </div>
            </div>
            @endif
            {{$user->label}} 
        </h1>
        <h6>Status: {{ $status }} </h6>
        <hr>
        <table class="table results table-hover">
                <thead>
                    <tr>
                    <th scope="col">+</th>
                    <th scope="col">Materia</th>
                    <th scope="col">Rama</th>
                    </tr>
                </thead>
                <tbody id="subjectsTableBody">
                    @foreach($user->subjects as $subject)
                    <tr>
                        <td>
                            <a style="color: white;" data-toggle="collapse" href="#c-{{$subject->id}}" role="button" aria-expanded="false" aria-controls="collapseExample">
                                +
                            </a>
                        </td>
                        <td>{{$subject->assigned->subject_name}}</td>
                        <td> {{$subject->assigned->subject_branch->branch_name}}</td>   
                        </tr>
                        <tr class="collapse detail" id="c-{{$subject->id}}">
                        <td></td>
                        <td>Preguntas: 
                            <p>{{count($subject->questions)}}</p>
                            <p><a href="{{route('subjects.show', ['id'=>$subject->assigned->id])}}" class="button text-center p-2">Ver detalle</a></p>
                        </td>
                        <td> 
                            @if(count($subject->assigned->assignedUsers))
                                @if(count($subject->assigned->assignedUsers) == 1)
                                    Titular:
                                @else
                                    Titulares:
                                @endif
                                @foreach($subject->assigned->assignedUsers as $user)
                                <p>{{$user->label}}<p>
                                @endforeach
                            @else
                                <p>Aún no hay titulares asignados<p>
                            @endif
                        </td>
                    </tr>
                    @endforeach                
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
        var url_user  = "{{route('users.update', ['id'=>$user['id']])}}";
        var all_subjects = "/subjects?user={{$user->id}}";
        var url_deactivate = "{{route('users.destroy', ['id'=>$user['id']])}}";
        @if(Auth::id() == $user->id)
        $('#cuenta').addClass('active');
        $('.usuarios').removeClass('active');
        @else
            $('.usuarios').addClass('active');
        @endif
        @if(Auth::user()->user_type == 1 || Auth::id() == $user->id)
        $('#editUserButton').on('click', function(){
            $('.modal-header').addClass('bg-black');
            $('.close').addClass('text-light');
            $('.modal-title').text('{{$user->label}}');
            var content ='<form method="POST" id="editUser">@csrf\
            <div class="row"><input name="_method" type="hidden" value="PUT">\
            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12"><label class="form-check-label" for="level">Nombre</label>\
                    <input type="text" class="form-control" name="name" value="{{$user->name}}" placeholder="Nombre">\
                    <small id="name_error" class="d-none feedback form-text bg-danger"></small>\
                </div>\
                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">\
                    <label class="form-check-label" for="level">Apellido</label>\
                    <input type="text" class="form-control" value="{{$user->last_name}}" name="last_name" placeholder="Apellido">\
                    <small id="last_name_error" class="d-none form-text feedback bg-danger"></small>\
                </div>\
                </div>\
                <div class="row">\
                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">\
                <label class="form-check-label" for="level">Contraseña</label>\
                    <input type="password" class="form-control" name="password" placeholder="Contraseña">\
                    <small id="pasword_error" class="d-none feedback form-text bg-danger"></small>\
                </div>\
                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">\
                    <label class="form-check-label" for="level">Repetir contraseña</label>\
                    <input type="password" class="form-control" name="password_confirmation" placeholder="Repetir contraseña">\
                    <small id="password_confirmation_error" class="d-none form-text feedback bg-danger"></small>\
                </div>\
                </div>\
            <div class="row">\
            <div class="form-group col-lg-12">\
            <label class="form-check-label" for="level">Correo electrónico</label>\
                    <input type="email" class="form-control" value="{{$user->email}}" name="email" placeholder="E-mail">\
                    <small id="email_error" class="d-none form-text feedback bg-danger"></small></div></div>';
            @if(Auth::user()->user_type == 1)
            content += '<div class="form-group">\
                <h5>Asignar materia\
                </h5>\
                <small id="subject_id_error" class="d-none form-text feedback bg-danger"></small>\
                <select style="width:100%;" class="multiselect" multiple="multiple" id="subjectsSelect" name="subjects[]">\
                </select>\
            </div>';
            @endif
            content +='<br>\
            <button type="submit" style="color: white;" class="button purple btn-block " id="save">GUARDAR</button>\
            </form>';
            $('.modal-body').html(content);
            $('.modal-footer').html('').addClass('bg-black');
            @if(Auth::user()->user_type == 1)
            fillSelect($('#subjectsSelect'), all_subjects, 1);
            @endif
            $('#myModal').modal('show');
            saveForm($('#editUser'), url_user, 3);
            
        });
        
        $('#enableUser').on('click', function(){
            $('.modal-title').html('').removeClass('bg-black');
            $('.modal-header').removeClass('bg-black');
            $('.close').addClass('text-light');
            $('.modal-body').html('<form id="enableForm">@csrf\
                            <input name="_method" type="hidden" value="DELETE">\
                          <input type="hidden" name="user_id" value="{{$user->id}}">\
                          <p>Esta acción {{$action}} a {{$user->label}} como usuario del Arcade. Puede deshacer esta acción en cualquier momento.</p>\
                          <div class="text-center">\
                            <button type="submit" style="color: white;" class="button purple" id="saveQuestion">Continuar</button>\
                            </div>\
                        </form>');
            $('.modal-footer').html('').removeClass('bg-black');
            $('#myModal').modal('show');
            saveForm($('#enableForm'), url_deactivate, 3);
            
        });
        @endif
    });
</script>
@endsection