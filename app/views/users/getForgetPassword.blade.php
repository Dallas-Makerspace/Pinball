@extends('layouts.main')

@section('stylesheets')

    @parent
    <style>
       body
       {
           background-image: url('/web/images/registerimage.jpg');
           background-size: cover;
           background-repeat: no-repeat;
       }
  
    </style>
@stop


@section('content')

<h1 class='col-md-offset-4 col-md-4'>Forget Password</h1>

    {{ Form::open(array('route' => 'forgetpasspost', 'class' => 'form col-md-offset-4 col-md-4 ')) }}
    
        <div class="form-group  @if($errors->has('email')) has-error @endif has-feedback">
                   {{ Form::label('email', 'Email Address: ', array('class' => 'control-label')) }}
                   {{ Form::email('email', "", array('type' => 'email', 'placeholder' => 'email address', 'class' => 'form-control')) }}
                   @if($errors->has('email'))
                   <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                   <span class='help-inline'>{{ $errors->first('email') }}</span>
                   @endif        
        </div>


    {{ Form::submit('submit', array('class' => 'btn btn-success btn-lg space')) }}
    <br />
<hr />
        {{ link_to_route('getSignIn', 'Sign In') }}  |  {{ link_to_route('forgetpassword', 'Forget Password') }}

    {{ Form::close() }}
    
   

@stop

