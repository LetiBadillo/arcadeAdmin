@extends('layouts.layout')
@section('content')
@include('partials.modal')
<div class="mb-6 container h-100 mbottom mt-2">
  <div class="row h-100">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="col-12 transparent-green p-5">
            
        <h1>{{$subject->subject_name}} 
            <small class="lead">({{$subject->subject_branch->branch_name}})</small></h1>

        <hr>
        @if(count($subject->assignedUsers))
            @if(count($subject->assignedUsers) == 1)
                Titular:
                <br>
            @else
                Titulares:
                <br>
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
            <table class="table results table-dark">
                <tbody>
                <tr class="m-3">
                <th scope="col" class="text-uppercase align-middle text-center" > <i class="far fa-dot-circle"></i> ¿Qué buscaba el utilitarismo?
                <br>    
                <small>Por Blanca Leticia Badillo Guzmán</small>
                </th>
                <th scope="col">
                        <i class="fas fa-caret-right"></i>
                        Paz mundial
                        <br>
                        <i class="fas fa-caret-right"></i> Igualdad de género
                        <br>
                        <i class="fas fa-caret-right"></i> Beneficiar a la mayoría
                        <br>
                        <i class="fas fa-caret-right"></i> Que cada quién reciba por lo que trabajó
                        <br>
                    
                </th>
                </tr>
                    <tr class="m-3">
                    <th scope="col" class="text-uppercase align-middle text-center" > <i class="far fa-dot-circle"></i> ¿Qué buscaba el utilitarismo?
                    <br>    
                    <small>Por Blanca Leticia Badillo Guzmán</small>
                    </th>
                    <th scope="col">
                            <i class="fas fa-caret-right"></i>
                            Paz mundial
                            <br>
                            <i class="fas fa-caret-right"></i> Igualdad de género
                            <br>
                            <i class="fas fa-caret-right"></i> Beneficiar a la mayoría
                            <br>
                            <i class="fas fa-caret-right"></i> Que cada quién reciba por lo que trabajó
                            <br>
                        
                    </th>
                    </tr>
                    <tr class="m-3">
                    <th scope="col" class="text-uppercase align-middle text-center" > <i class="far fa-dot-circle"></i> ¿Qué buscaba el utilitarismo?
                    <br>    
                    <small>Por Blanca Leticia Badillo Guzmán</small>
                    </th>
                    <th scope="col">
                            <i class="fas fa-caret-right"></i>
                            Paz mundial
                            <br>
                            <i class="fas fa-caret-right"></i> Igualdad de género
                            <br>
                            <i class="fas fa-caret-right"></i> Beneficiar a la mayoría
                            <br>
                            <i class="fas fa-caret-right"></i> Que cada quién reciba por lo que trabajó
                            <br>
                        
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
        $('#addQuestion').on('click', function(){
            $('.modal-header').addClass('bg-black');
            $('.close').addClass('text-light');
            $('.modal-title').text('Crear pregunta');
            $('.modal-body').html('<form id="saveQuestion">\
                            <div class="form-group col-lg-12">\
                                <label for="question">Pregunta </label>\
                                <input type="text" class="form-control" name="question" placeholder="¿?">\
                                <small id="question_error" class="d-none feedback form-text bg-danger"></small>\
                            </div>\
                            <div class="form-group col-lg-12">\
                                <label for="answer">Respuesta </label>\
                                <input type="text" class="form-control" name="answer" placeholder=". . . .">\
                                <small id="option_error" class="d-none feedback form-text bg-danger"></small>\
                            </div>\
                            <div class="form-group col-lg-12">\
                                <label class="form-check-label" for="options">Otras opciones</label>\
                                <div class="form-check">\
                                    <input type="radio" class="form-check-input" value="0">\
                                    <input type="text" class="form-control" name="option[]" placeholder="Opción 1">\
                                </div>\
                                <div class="form-check">\
                                    <input type="radio" class="form-check-input">\
                                    <input type="text" class="form-control" name="option[]" placeholder="Opción 2">\
                                </div>\
                                <div class="form-check">\
                                    <input type="radio" class="form-check-input">\
                                    <input type="text" class="form-control" name="option[]" placeholder="Opción 3">\
                                </div>\
                            </div>\
                            <div class="text-center">\
                            <button type="submit" style="color: white;" class="button purple" id="saveQuestion">GUARDAR</button>\
                            </div>\
                        </form>');
            $('.modal-footer').addClass('bg-black');
            $('#myModal').modal('show');
        });    
    });
</script>
@endsection