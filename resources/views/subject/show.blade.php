@php
$action = '' ;
$menu_enable = '';
$status = '';
if($subject->enabled == 1){
    $action = 'desactivará';
    $menu_enable = '<i class="fas fa-ban"></i> Desactivar';
    $status = "Activa";

}else{
    $action = 'activará';
    $menu_enable = '<i class="fas fa-check"></i> Activar';
    $status = "Inactiva";
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
                <div style="float: left;" class="dropdown">
                    <button type="button" class="btn btn-link text-light" data-toggle="dropdown">
                    <h2><i class="fas fa-bars"></i></h2>
                    </button>
                    <div class="dropdown-menu">
                        <a id="editSubjectButton" class="dropdown-item" href="#"><i class="far fa-edit"></i> Editar</a>
                        <a id="enableSubject" class="dropdown-item" href="#">  {!! $menu_enable !!}</a>
                    </div>
                </div>
                
                {{$subject->subject_name}} 
                <small class="lead">({{$subject->subject_branch->branch_name}} - 
                    @if($subject->level == 0)
                    Profesional
                    @else
                    Prepartoria
                    @endif) 
                </small>
            </h1>
            <h6>Status: {{ $status }} </h6>
        <hr>
        @if(count($subject->assignedUsers))
            @if(count($subject->assignedUsers) == 1)
                <h4>Titular:</h4>
            @else
                <h4>Titulares:</h4>
            @endif
            @foreach($subject->assignedUsers as $user)
                {{$user->label}}<br>
            @endforeach
        @else
            <p>Aún no hay titulares asignados<p>
        @endif
        <br>
        <h1 class="text-center">Preguntas</h1>
        <div class="text-center">
            <small><button type="button" style="color: white;" class="button" id="addQuestion">agregar pregunta</button></small>
        </div>
            <br>
            @if(count($subject->questions))
            <form id="searchForm">
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1"><i class="fas fa-search"></i></span>
                    <input type="text" name="search" class="searchQuestionsInput form-control" placeholder="Buscar por pregunta o nombre de matestro" aria-describedby="basic-addon1">
                </div>    
            </form>
            <br>
            <table class="table results table-dark">
                <tbody id="questionsTableBody">
                    @foreach($subject->questions as $question)
                <tr class="m-3">
                <th scope="col" class="text-uppercase align-middle text-center" > <i class="far fa-dot-circle"></i> 
                {{$question->question}}
                <br>    
                <small>{{$question->author->label}} </small>
                </th>
                <th scope="col">
                    @foreach($question->options as $option)
                        @if($option->is_answer)
                        <i class="yellow-txt fas fa-caret-right"></i>
                        <span class="yellow-txt">{{$option->option}}</span>
                        @else
                        <i class="fas fa-caret-right"></i>
                        <span>{{$option->option}}</span>
                        @endif
                        <br>
                    @endforeach
                    
                </th>
                <th>
                    <div style="float: right;" class="dropdown">
                        <button type="button" class="btn btn-link text-light" data-toggle="dropdown">
                        <h2><i class="fas fa-bars"></i></h2>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item editQuestion" data-id="{{$question->id}}" href="#"><i class="far fa-edit"></i> Editar</a>
                            @if($question->enabled == 1)
                            <a class="dropdown-item enableQuestion" data-action="deshabilitar" data-id="{{$question->id}}" href="#"><i class="fas fa-ban"></i>  Desactivar</a>
                            @else
                            <a class="dropdown-item enableQuestion" data-action="habilitar" data-id="{{$question->id}}" href="#"><i class="fas fa-check"></i>  Activar</a>
                            @endif
                        </div>
                    </div>
                </th>
                </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
<script>
    $('#inicio').removeClass('active');
    var search_url = "/questions"
    $(function() {
        var url_question = '{{url("/questions")}}';
        var url_subject  = "{{route('subjects.update', ['id'=>$subject['id']])}}";
        var url_deactivate = "{{route('subjects.destroy', ['id'=>$subject['id']])}}";
        var allUsers = "{{url('users?ws=all')}}"+"&subject_id={{$subject->id}}";
        var branches = "{{url('branches?ws=all')}}";
        $('.materias').addClass('active');
        $('#addQuestion').on('click', function(){
            $('.modal-header').addClass('bg-black');
            $('.close').addClass('text-light');
            $('.modal-title').text('Crear pregunta');
            $('.modal-body').html('<form id="saveQuestion">@csrf\
                          <input type="hidden" name="subject_id" value="{{$subject->id}}">\
                          <input type="hidden" name="author_id" value="{{Auth::id()}}">\
                            <div class="form-group col-lg-12">\
                                <label for="question">Pregunta </label>\
                                <input type="text" class="form-control" name="question" placeholder="¿?">\
                                <small id="question_error" class="d-none feedback form-text bg-danger"></small>\
                            </div>\
                            <div class="form-group col-lg-12">\
                                <label for="answer">Respuesta </label>\
                                <input type="text" class="form-control" name="answer" placeholder=". . . .">\
                                <small id="answer_error" class="d-none feedback form-text bg-danger"></small>\
                            </div>\
                            <div class="form-group col-lg-12">\
                                <label class="form-check-label" for="options">Otras opciones</label>\
                                <div class="input-group">\
                                    <span class="input-group-addon" id="basic-addon1"><i class="fas fa-check-square"></i></span>\
                                    <input type="text" aria-describedby="basic-addon1" class="form-control" name="options[]" placeholder="Opción 1">\
                                </div>\
                                <div class="input-group">\
                                    <span class="input-group-addon" id="basic-addon1"><i class="fas fa-check-square"></i></span>\
                                    <input type="text" aria-describedby="basic-addon1" class="form-control" name="options[]" placeholder="Opción 2">\
                                </div>\
                                <div class="input-group">\
                                    <span class="input-group-addon" id="basic-addon1"><i class="fas fa-check-square"></i></span>\
                                    <input type="text" aria-describedby="basic-addon1" class="form-control" name="options[]" placeholder="Opción 3">\
                                </div>\
                            </div>\
                            <div class="form-group col-lg-12">\
                                <label for="difficulty">Dificultad </label>\
                                <select class="form-control" name="difficulty">\
                                    <option value="">--Seleccionar--</option>\
                                    <option value="1">Fácil</option>\
                                    <option value="2">Intermedia</option>\
                                    <option value="3">Difícil</option>\
                                </select>\
                                <small id="difficulty_error" class="d-none feedback form-text bg-danger"></small>\
                            </div>\
                            <div class="text-center">\
                            <button type="submit" style="color: white;" class="button purple" id="saveQuestion">GUARDAR</button>\
                            </div>\
                        </form>');
            $('.modal-footer').html('').addClass('bg-black');
            $('#myModal').modal('show');
            saveForm($('#saveQuestion'), url_question, 3);
        });  
        
        $('#editSubjectButton').on('click', function(){
            $('.modal-header').addClass('bg-black');
            $('.close').addClass('text-light');
            $('.modal-title').text('{{$subject->subject_name}} ');
            var prof, prep = 0;
            if("{{$subject->level}}" == 0){
                prof = "checked";
            }
            if("{{$subject->level}}" == 1){
                prep = "checked";
            }
            $('.modal-body').html('<form id="editSubject">@csrf\
                            <input name="_method" type="hidden" value="PUT">\
                          <input type="hidden" name="subject_id" value="{{$subject->id}}">\
                          <div class="row">\
                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">\
                                    <label class="form-check-label" for="level">Materia</label>\
                                    <input value="{{$subject->subject_name}}" type="text" class="form-control" name="subject_name" placeholder="Materia">\
                                    <small id="subject_name_error" class="d-none feedback form-text bg-danger"></small>\
                                </div>\
                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">\
                                    <label class="form-check-label" for="level">Rama</label>\
                                    <select option="{{$subject->subject_branch_id}}" class="form-control" name="subject_branch_id" id="subject_branch">\
                                        <option value="">--Seleccionar--</option>\
                                    </select>\
                                    <small id="subject_branch_id_error" class="d-none form-text feedback bg-danger"></small>\
                                </div>\
                            </div>\
                            <div class="form-group">\
                                <h5>Asignar maestros</h5>\
                                <small id="user_id_info" class="form-text feedback">Este campo no es requerido</small>\
                                <small id="user_id_error" class="d-none form-text feedback bg-danger"></small>\
                                <select style="width:100%;" class="multiselect option" multiple="multiple" id="usersSelect" name="user_id[]">\
                                </select>\
                            </div>\
                            <label class="form-check-label" for="level">Nivel</label>\
                            <small id="level_error" class="d-none form-text feedback bg-danger"></small>\
                            <div class="form-check">\
                                <input type="radio" '+prof+' class="form-check-input" value="0"  name="level">\
                                <label class="form-check-label" name="level" for="level">Profesional</label>\
                            </div>\
                            <div class="form-check">\
                                <input type="radio" '+prep+' class="form-check-input" value="1" name="level">\
                                <label class="form-check-label" name="level"  for="level">Preparatoria</label>\
                            </div>\
                            <div class="text-center">\
                            <button type="submit" style="color: white;" class="button purple" id="saveQuestion">GUARDAR</button>\
                            </div>\
                        </form>');
            $('.modal-footer').html('').addClass('bg-black');
            fillSelect($('#usersSelect'), allUsers, 1);
            fillSelect($('#subject_branch'), branches, 0);
            $('#myModal').modal('show');
            saveForm($('#editSubject'), url_subject, 3);
            
        });
        
        $('#enableSubject').on('click', function(){
            $('.modal-title, .modal-header').html('').removeClass('bg-black');
            $('.close').addClass('text-light');
            $('.modal-body').html('<form id="enableForm">@csrf\
                            <input name="_method" type="hidden" value="DELETE">\
                          <input type="hidden" name="subject_id" value="{{$subject->id}}">\
                          <p>Esta acción {{$action}} {{$subject->subject_name}} como juego del Arcade. Puede deshacer esta acción en cualquier momento.</p>\
                          <div class="text-center">\
                            <button type="submit" style="color: white;" class="button purple" id="saveQuestion">Continuar</button>\
                            </div>\
                        </form>');
            $('.modal-footer').html('').removeClass('bg-black');
            $('#myModal').modal('show');
            saveForm($('#enableForm'), url_deactivate, 3);
            
        });

        $('.editQuestion').on('click', function(){
            var url_editQuestion = url_question+'/'+$(this).attr('data-id')+'?getInfo=1';
            $('.modal-header').removeClass('bg-black');
            $('.close').addClass('text-light');
            $('.modal-title').text('Editar pregunta');
            $('.modal-body').html('<form id="editQuestion">@csrf\
                          <input type="hidden" name="subject_id" value="{{$subject->id}}">\
                          <input type="hidden" name="author_id" value="{{Auth::id()}}">\
                          <input name="_method" type="hidden" value="PUT">\
                            <div class="form-group col-lg-12">\
                                <label for="question">Pregunta </label>\
                                <input type="text" class="form-control" name="question" placeholder="¿?">\
                                <small id="question_error" class="d-none feedback form-text bg-danger"></small>\
                            </div>\
                            <div class="form-group col-lg-12">\
                                <label for="answer">Respuesta </label>\
                                <input type="text" class="form-control" name="answer" placeholder=". . . .">\
                                <small id="answer_error" class="d-none feedback form-text bg-danger"></small>\
                            </div>\
                            <div class="form-group col-lg-12">\
                                <label class="form-check-label" for="options">Otras opciones</label>\
                                <div class="input-group">\
                                    <span class="input-group-addon" id="basic-addon1"><i class="fas fa-check-square"></i></span>\
                                    <input type="text" aria-describedby="basic-addon1" class="form-control" name="options[]" placeholder="Opción 1">\
                                </div>\
                                <div class="input-group">\
                                    <span class="input-group-addon" id="basic-addon1"><i class="fas fa-check-square"></i></span>\
                                    <input type="text" aria-describedby="basic-addon1" class="form-control" name="options[]" placeholder="Opción 2">\
                                </div>\
                                <div class="input-group">\
                                    <span class="input-group-addon" id="basic-addon1"><i class="fas fa-check-square"></i></span>\
                                    <input type="text" aria-describedby="basic-addon1" class="form-control" name="options[]" placeholder="Opción 3">\
                                </div>\
                            </div>\
                            <div class="form-group col-lg-12">\
                                <label for="difficulty">Dificultad </label>\
                                <select class="form-control" name="difficulty">\
                                    <option value="">--Seleccionar--</option>\
                                    <option value="1">Fácil</option>\
                                    <option value="2">Intermedia</option>\
                                    <option value="3">Difícil</option>\
                                </select>\
                                <small id="difficulty_error" class="d-none feedback form-text bg-danger"></small>\
                            </div>\
                            <div class="text-center">\
                            <button type="submit" style="color: white;" class="button purple" id="saveQuestion">GUARDAR</button>\
                            </div>\
                        </form>');
            $('.modal-footer').html('').addClass('bg-black');
            fillForm($("#editQuestion"), url_editQuestion);
            $('#myModal').modal('show');
            saveForm($('#editQuestion'), url_question+'/'+$(this).attr('data-id'), 3);
        });  

        $('.enableQuestion').on('click', function(){
            var url_deactivateQ = "{{url('questions')}}";
            console.log(url_deactivateQ+'/'+$(this).attr('data-id'));
            $('.modal-title, .modal-header').html('').removeClass('bg-black');
            $('.close').addClass('text-light');
            $('.modal-body').html('<form id="enableQuestionForm">@csrf\
                            <input name="_method" type="hidden" value="DELETE">\
                          <input type="hidden" name="subject_id" value="{{$subject->id}}">\
                          <p>Esta acción va a '+$(this).attr('data-action')+' esta pregunta en el  Arcade. Puede deshacer esta acción en cualquier momento.</p>\
                          <div class="text-center">\
                            <button type="submit" style="color: white;" class="button purple" id="saveQuestion">Continuar</button>\
                            </div>\
                        </form>');
            $('.modal-footer').html('').removeClass('bg-black');
            $('#myModal').modal('show');
            saveForm($('#enableQuestionForm'), url_deactivateQ+'/'+$(this).attr('data-id'), 3);
            
        });

        function fillForm(form, url){
            var that = $(form).find('input');
            $.get(url, function(data){
                $( "input[name='options[]']" ).each(function(keyy, option){
                        $(option).val(data.otheroptions[keyy]);
                        console.log(keyy);
                });
                $( "select[name='difficulty']" ).val(data.difficulty);
                $(that).each(function(k, v){
                    $.each(data, function(key, value) {
                        if($(v).attr("name") == key){
                            $(v).val(value);
                        }
                    });
                });
            });
        }
    });
</script>
@endsection