@extends('layouts.layout')
@section('content')
<div class="container mt-2">
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="col-12 greenbox">
            <form id="searchForm">
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1"><i class="fas fa-search"></i></span>
                    <input type="text" class="searchInput form-control" placeholder="Buscar por materia o nombre de matestro" aria-describedby="basic-addon1">
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
                    <th scope="col">Materia</th>
                    <th scope="col">Rama</th>
                    </tr>
                </thead>
                <tbody id="subjectsTableBody">
                @if(count($subjects))
                    @foreach($subjects as $subject)
                    <tr>
                        <td>
                            <a style="color: white;" data-toggle="collapse" href="#c-{{$subject->id}}" role="button" aria-expanded="false" aria-controls="collapseExample">
                                +
                            </a>
                        </td>
                        <td>{{$subject->subject_name}}</td>
                        <td>{{$subject->subject_branch->branch_name}}</td>
                        
                        </tr>
                        <tr class="collapse detail" id="c-{{$subject->id}}">
                        <td></td>
                        <td>Preguntas: 
                            <p>{{count($subject->questions)}}</p>
                            <p><a href="{{route('subjects.show', ['id'=>$subject['id']])}}" class="button text-center p-2">Ver detalle</a></p>
                        </td>
                        <td> 
                            @if(count($subject->assignedUsers))
                                @if(count($subject->assignedUsers) == 1)
                                    Titular:
                                @else
                                    Titulares:
                                @endif
                                <br>
                                @foreach($subject->assignedUsers as $user)
                                {{$user->label}}
                                <br>
                                @endforeach
                            @else
                                <p>Aún no hay titulares asignados<p>
                            @endif
                        </td>
                    </tr>
                    @endforeach                
                @else
                <tr>
                <td colspan="3" class="text-center">Aún no hay materias registradas</td>
                </tr>
                @endif
                </tbody>
            </table>
                {{ $subjects->links() }}
        </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
<script>
    $('.pagination').addClass('justify-content-center');
    $('#inicio').removeClass('active');
    search_url = '/subjects';
    $(function() {
        $('.materias').addClass('active');
    });
    
</script>
@endsection