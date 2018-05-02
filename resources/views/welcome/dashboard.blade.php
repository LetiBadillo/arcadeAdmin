@extends('layouts.layout')
@section('content')
<div class="mb-6 container h-100 mbottom mt-2">
  <div class="row h-100">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="col-12 transparent-green p-5">
        <table class="table results table-hover">
                <thead>
                    <tr>
                    <th scope="col">
                      <H1 class="text-center">TOP SCORES</H1>
                    </th>
                    </tr>
                </thead>
                <tbody id="subjectsTableBody">
                @if(Auth::user()->user_type == 1)
                @foreach(App\Models\Subject::all() as $subject)
                <tr class="text-center text-uppercase">
                  <td>{{$subject->subject_name}}
                      <br>
                      @if(count($subject->topScores))
                      @foreach($subject->topScores as $score)
                          {{$score->username}} - {{$score->score}}
                          <br>
                      @endforeach 
                       @else
                      Aún no hay puntuaciones guardadas
                      @endif 
                  </td>
                        
                </tr>
                  @endforeach
                @else
                  @foreach(Auth::user()->subjects as $subject)
                  <tr class="text-center text-uppercase">
                  <td>{{$subject->assigned->subject_name}}
                        <br>
                      @if(count($subject->assigned->topScores))
                      @foreach($subject->assigned->topScores as $score)
                      {{$score->username}} - {{$score->score}}
                      <br>
                      @endforeach  
                      @else
                      Aún no hay puntuaciones guardadas
                      @endif
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
@endsection