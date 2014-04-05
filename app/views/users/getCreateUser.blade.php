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

<h1 class='col-md-offset-4 col-md-4'>Register User</h1>

    {{ Form::open(array('route' => 'registeruser', 'class' => 'form col-md-offset-4 col-md-4 ')) }}
    
        <div class="form-group  @if($errors->has('email')) has-error @endif has-feedback">
                   {{ Form::label('email', 'Email Address: ', array('class' => 'control-label')) }}
                   {{ Form::email('email', "", array('type' => 'email', 'placeholder' => 'email address', 'class' => 'form-control')) }}
                   @if($errors->has('email'))
                   <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                   <span class='help-inline'>{{ $errors->first('email') }}</span>
                   @endif        
        </div>

         <div class="form-group  @if($errors->has('username')) has-error @endif has-feedback">

                    {{ Form::label('username', 'UserName: ',array('class' => 'control-label')) }}
                    {{ Form::text('username', "", array( 'placeholder' => 'username', 'class' => 'form-control')) }}
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
    
         <div class="form-group  @if($errors->has('confirm_password')) has-error @endif has-feedback">
                {{ Form::label('confirm_passowrd', 'Confirm Password: ',array('class' => 'control-label')) }}
                {{ Form::password('confirm_password', array('placeholder' => 'Confirm Password', 'class' => 'form-control')) }}
            @if($errors->has('confirm_password'))
                   <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                   <span class='help-inline'>{{ $errors->first('confirm_password') }}</span>
            @endif    
         </div>
    {{ Form::submit('submit', array('class' => 'btn btn-success btn-lg space')) }}
    <br />
<hr />
        {{ link_to_route('getSignIn', 'Sign In') }}  |  {{ link_to_route('forgetpassword', 'Forget Password') }}

    {{ Form::close() }}
    
   

@stop
