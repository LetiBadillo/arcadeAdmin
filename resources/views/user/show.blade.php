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
<div class="container h-100">
  <div class="row h-100 justify-content-center align-items-center">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="col-12 transparent-green p-5">
            <h1 style="margin: 0; display: inline-block;">
            @if(Auth::user()->user_type == 1 || Auth::user()->id == $user->id)
            <div style="float: left;" class="dropdown">
                <button type="button" class="btn btn-link text-light" data-toggle="dropdown">
                <h2><i class="fas fa-bars"></i></h2>
                </button>
                <div class="dropdown-menu">
                    <a id="editSubject" class="dropdown-item" href="#"><i class="far fa-edit"></i> Editar</a>
                    <a id="enableSubject" class="dropdown-item" href="#">  {!! $menu_enable !!}</a>
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
        $('.usuarios').addClass('active');

    });
</script>
@endsection