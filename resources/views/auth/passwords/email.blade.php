@extends('layouts.layout')
@section('content')
<div class="container h-100">
  <div class="row h-100 justify-content-center align-items-center">
    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
        <form class="col-12 transparent-green p-5" id="logMe" method="POST" action="{{ route('password.email') }}">
            <!--style="top: 8em;"-->
            @csrf
            <div class="form-group">
                <label for="email" class="col-form-label text-md-right">{{ __('E-Mail') }}</label>
                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                @if ($errors->has('email'))
                <small id="email_error" class="form-text feedback bg-danger">{{ $errors->first('email') }}</small>
                @endif
            </div>
           
            <button type="submit" style="color: white;" class="button purple btn-block" id="login">{{ __('Reestablecer contraseña') }}</button>
           
        </form> 
    </div>
  </div>
</div>

@endsection
