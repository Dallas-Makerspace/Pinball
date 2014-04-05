@extends('layouts.main')

@section('stylesheets')
@parent
<style>
     body
       {
           background-image: url('/web/images/signin.jpg');
           background-size: cover;
           background-repeat: no-repeat;
       }
</style>

@stop

@section('content')

<h1 class='col-md-offset-4 col-md-4'>Sign In</h1>


    {{ Form::open(array('route' => 'postSignIn', 'class' => 'form col-md-offset-4 col-md-4 ')) }}

        <div class="form-group  @if($errors->has('username')) has-error @endif has-feedback">
                   {{ Form::label('username', 'User Name: ', array('class' => 'control-label')) }}
                   {{ Form::text('username', "", array( 'placeholder' => 'Email Address or Username', 'class' => 'form-control')) }}
                   @if($errors->has('username'))
                   <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                   <span class='help-inline'>{{ $errors->first('username') }}</span>
                   @endif        
        </div>
    
         <div class="form-group  @if($errors->has('password')) has-error @endif has-feedback">
            {{ Form::label('password', 'Password: ',array('class' => 'control-label')) }}
            {{ Form::password('password',  array('placeholder' => 'password', 'class' => 'form-control')) }}
            @if($errors->has('password'))
                   <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                   <span class='help-inline'>{{ $errors->first('password') }}</span>
            @endif        
         </div>
    
    {{ Form::submit('submit', array('class' => 'btn btn-success btn-lg space')) }}
<br />
<hr />
        {{ link_to_route('getCreateUser', 'Register') }}  |  {{ link_to_route('forgetpassword', 'Forget Password') }}

    {{ Form::close() }}
    
    
    @if(Session::has('signinerror'))
    
    <div class='alert alert-danger alert-dismissable col-md-4 col-md-offset-4 space'>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        Your username and password do not match.
    </div>
    @endif

@stop