@extends('layouts.layout')
@section('content')
<div class="container h-100">
  <div class="row h-100 justify-content-center align-items-center">
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
                <tbody>
                <tr>
                <td>
                    <a style="color: white;" data-toggle="collapse" href="#c-id" role="button" aria-expanded="false" aria-controls="collapseExample">
                        +
                    </a>
                </td>
                <td>Ética</td>
                <td>Filosofía</td>
                
                </tr>
                <tr class="collapse detail" id="c-id">
                <td></td>
                <td>Preguntas: 
                    <p>30</p>
                    <p><a href="#" class="button text-center p-2">Ver detalle</a></p>
                </td>
                <td>Titulares: 
                    <p>Roberto A. Guevara Leóns<p>
                    <p>Blanca Leticia Badillo Guzmán</p>
                </td>
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

    });
</script>
@endsection