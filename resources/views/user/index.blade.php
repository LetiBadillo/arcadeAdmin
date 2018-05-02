@extends('layouts.layout')
@section('content')
<div class="container mt-2">
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="col-12 greenbox">
            <form id="searchForm">
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1"><i class="fas fa-search"></i></span>
                    <input type="text" class="searchUserInput form-control" placeholder="Buscar por materia o nombre de matestro" aria-describedby="basic-addon1">
                </div>               
            </form>
        </div>
    </div>
  </div>
</div>

<div class="mb-6 container h-100 mbottom mt-2">
  <div class="row h-100">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="col-12 transparent-green p-5">
            <table class="table results table-hover">
                <thead>
                    <tr>
                    <th scope="col">+</th>
                    <th scope="col">Usuario</th>
                    <th scope="col">Materias asignadas</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($users))
                        @foreach($users as $user)
                        <tr>
                        <td>
                            <a style="color: white;" data-toggle="collapse" href="#c-{{$user->id}}" role="button" aria-expanded="false" aria-controls="collapseExample">
                                +
                            </a>
                        </td>
                        <td>{{$user->label}}</td>
                        <td>{{count($user->subjects)}}</td>
                        
                        </tr>
                        <tr class="collapse detail" id="c-{{$user->id}}">
                            <td></td>
                        <td class="text-center">Materias: 
                            <br>
                            @foreach($user->subjects as $subject)
                                {{$subject->assigned->subject_name}}
                                <br>
                            @endforeach
                        </td>
                        <td class="align-middle text-center">
                            <p><a href="{{route('users.show', ['id'=>$user['id']])}}" class="button text-center p-2">Ver detalle</a></p>
                        </td>
                        </tr>
                        @endforeach
                    @endif
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