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
       div#container_total_div
       {
            background-color: white; 
            padding: 10px; 
            border-radius: 5px;    
       }
       
</style>

@stop


@section('content')


<h1 class='col-md-4 col-md-offset-4'>All Score Table</h1>

<div class="col-md-10  col-md-offset-1" id='container_total_div' >
<table id='highscoremainpage_table' class='table table-striped table-bordered table-responsive'  >
            <thead>
                <tr>
                    <th style='width: 25%;'>User</th>
                    <th style='width: 25%;'>Machine</th>
                    <th style='width: 25%;'>Score</th>
                    <th style='width: 25%;'>Date Created</th>
                </tr>
            </thead>
            <tbody>
                   @foreach($highscore as $tr)
                   <tr>
                       <td>{{ link_to_route('publicProfile', $tr['username'], array($tr['username'])) }}</td>
                       <td>{{ link_to_route('getMachine', $tr['machine_name'], array($tr['machine_id'])) }}</td>
                       <td>{{ $tr['score'] }}</td>
                       <td>{{ $tr['datecreated'] }}</td>
                   </tr>
                   @endforeach
            </tbody>
</table>
</div>
@stop

@section('js')

@parent
<script>
$('#highscoremainpage_table').dataTable({
        "sDom": "<'row'<'col-xs-6'T><'col-xs-6'f>r>t<'row'<'col-xs-6'i><'col-xs-6'p>>",
        "sPaginationType": "bootstrap",
		"oLanguage": {
			"sLengthMenu": "_MENU_ records per page"
                    },
		  
            });
</script>

@stop

