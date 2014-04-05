@extends('layouts.main')

@section('stylesheets')
@parent


<style>
     body
       {
           background-image: url('/web/images/mainbackground.jpg');
           background-size: cover;
           background-repeat: no-repeat;
       }
       div#mvp_table_container
       {
            background-color: white;
            padding: 10px;
            border-radius: 5px;    
       }
       
       
</style>

@stop


@section('content')


<h1 class='col-md-4 col-md-offset-4'>MVP Pinball Roster </h1>

<div id='mvp_table_container' class="col-md-10  col-md-offset-1">
<table id='roster_table' class='table table-striped table-bordered table-responsive'  >
            <thead>
                <tr>
                    <th style='width: 34%;'>User</th>
                    <th style='width: 33%;'>Average Score</th>
                    <th style='width: 33%;'>Highest Score</th>   
                </tr>
            </thead>
            <tbody>
                   @foreach($mvp_table as $tr)
                   
                   <tr>
                       <td>{{ link_to_route('publicProfile', $tr->username, array($tr->username)) }}</td>
                       <td>{{ number_format($tr->avg_score, 2) }}</td>
                       <td>{{ $tr->max_score }}</td>
                   </tr>
                   
                   @endforeach
            </tbody>
</table>
</div>


@stop

@section('js')

@parent
<script>
$('#roster_table').dataTable( {
        "sDom": "<'row'<'col-xs-6'T><'col-xs-6'f>r>t<'row'<'col-xs-6'i><'col-xs-6'p>>",
        "sPaginationType": "bootstrap",
		"oLanguage": {
			"sLengthMenu": "_MENU_ records per page"
                    },
		  
            });
</script>

@stop

