<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>{{ $title }}</title>
        @section('stylesheets')
        {{ HTML::style('/web/bootstrap/css/bootstrap.css'); }}
        {{ HTML::style('/web/bootstrap/css/bootstrap-theme.css'); }}
        {{ HTML::style('/web/css/DT_bootstrap.css') }}

        {{ HTML::style('/web/css/style.css') }}
<link href='http://fonts.googleapis.com/css?family=La+Belle+Aurore' rel='stylesheet' type='text/css'>
    
    <style>
        body{ padding: 20px; }
        div.navbar{font-family: 'La Belle Aurore', arial;  font-size: 1.5em;  }
        li.sp a{ color: #285e8e!important; }
        li.sp a:hover{ color: brown!important;}
        .navbar-default .navbar-brand{color: brown; font-weight: bold;}
        .navbar-brand { font-size: 1.2em; position: relative; top: 4px;}
        
    </style>
        @show
        
        
    </head>
    <body >
        
        @include('layouts.nav')
        
        @if(Session::has('global'))
        
        <div class='alert alert-dismissable alert-info col'>
            {{ Session::get('global') }}
        </div>
        
        @endif
        
        @yield('content')
        
        @section('js')
        
            {{ HTML::script('/web/js/jquery.js'); }}
            {{ HTML::script("/web/bootstrap/js/bootstrap.js") }}
            {{ HTML::script('/web/js/jquery.dataTables.js'); }}
            {{ HTML::script('/web/js/dataTables.bootstrap.js'); }}
            
            <script>
                   $(document).on("focus","textarea, input",function(){
                      $(this).parents("div.has-error").find('span.help-inline').hide();
                      $(this).parents("div.has-error").find('span.glyphicon-remove').hide();
                      $(this).parents("div.has-error").removeClass('has-error');

                   });
            </script>

        @show
        
    </body>
</html>
