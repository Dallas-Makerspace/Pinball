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
        {{ HTML::style('/web/css/tables.css') }}
        {{ HTML::style('/web/bootstrap/css/bootstrap-datetimepicker.min.css') }}


        {{ HTML::style('/web/css/style.css') }}
        <link href='http://fonts.googleapis.com/css?family=La+Belle+Aurore' rel='stylesheet' type='text/css'>
        <style>
            div.progress
            {
                display: none;
            }
            div#usertable_message
            {
                display: none;
            }
            
            body
                {
                    background-image: url('/web/images/registerimage.jpg');
                    background-size: cover;
                    background-repeat: no-repeat;
                }

       div#tabCover
       {
           padding: 20px;
           background-color: white;
       }
       div.alert-danger, div.alert-success
       {
           display: none;
       }
       
        </style>
        @show
        
        
    </head>
    <body >
        
        <div  class='col-md-12' style='padding: 20px;' >
                    @if(Session::has('global'))
        
                    <div class='alert alert-dismissable alert-info col'>
                        {{ Session::get('global') }}
                    </div>

                    @endif
            
               
                <div class="list-group col-md-3 ">
                <a data-page='users' class="list-group-item active">Users<i class='glyphicon glyphicon-send pull-right col-sm-1'></i></a>
                <a data-page='pinball' class="list-group-item">Pinball Machines<i class='glyphicon glyphicon-send pull-right col-sm-1'></i></a>
                <a data-page='highscore' class="list-group-item">High Scores<i class='glyphicon glyphicon-send pull-right col-sm-1'></i></a>
               </div>
                    
                    <div id='tabCover' class='col-md-9 '>
                    
                    <div id='users' class='col-md-12 content' >
                        <ul class="nav nav-tabs content-nav" >
                             <li class="active" ><a data-toggle="tab" href="#user_list">User List</a></li>
                            <li  ><a data-toggle="tab" href="#add_user_main">Add User</a></li>

                        </ul>
                        <div  class='tab-content col-md-12'>
                            
                            <div id='add_user_main' class='tab-pane'>
                                <h1>Register User</h1>
                                   {{ Form::open(array('route' => 'adminpostuser', 'class' => 'form col-md-offset-1 col-md-11 ', 'id' => 'form_register_user')) }}
    
                                <div class="form-group  has-feedback" id='adduser_email'>
                                           {{ Form::label('email', 'Email Address: ', array('class' => 'control-label')) }}
                                           {{ Form::email('email', "", array('type' => 'email', 'placeholder' => 'email address', 'class' => 'form-control')) }}
                                            <span style='display: none;' class="glyphicon glyphicon-remove form-control-feedback"></span>
                                            <span style='display: none;' class='help-inline'></span>

                                </div>

                                <div class="form-group   has-feedback" id='adduser_username'>

                                           {{ Form::label('username', 'User Name: ',array('class' => 'control-label')) }}
                                           {{ Form::text('username', "", array( 'placeholder' => 'username', 'class' => 'form-control')) }}
                                            <span style='display: none;' class="glyphicon glyphicon-remove form-control-feedback"></span>
                                            <span style='display: none;' class='help-inline'></span>
   
                                 </div>
                                   
                                   <div class='alert alert-danger alert-dismissable' id='errorMessage_adduser'>
                                       <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                                       There was an error while trying to add the user.
                                   </div>
                                   
                                   <div id='successMessage_addUser' class='alert alert-success alert-dismissable'>
                                       <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                                       You have successfully added the user.
                                   </div>

                                
                                   
                                {{ Form::submit('submit', array('class' => 'btn btn-success btn-lg space')) }}

                                {{ Form::close() }}
                            </div>
                            
                            <div id='user_list' class='tab-pane active'>
                                <h1>User List</h1>
                                <div class='alert ' id='usertable_message'>
                                      <button type="button" class="close hideAlert"  >&times;</button>
                                      <span></span>
                                </div>
                                <table id='user_table'
                                       class='table table-striped table-bordered table-responsive'  >
                                    <thead>
                                        <tr>
                                            <th style='width: 35%;'>User</th>
                                            <th style='width: 35%;'>Email</th>
                                            <th style='width: 10%;'></th>
                                            <th style='width: 10%;'></th>
                                            <th style='width: 10%;'></th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($usertable as $tr)
                                        <tr>
                                            <td>{{ $tr['username'] }}</td>
                                            <td>{{ $tr['email'] }}</td>
                                            <td class='btncontainer'><button data-userid='{{ $tr['id'] }}' class='btn btn-success btn-sm user_resetpassword'>Reset Password</button></td>
                                            <td class='btncontainer'>
                                                <button data-userid='{{ $tr['id'] }}' class='btn
                                                     @if($tr['enabled'] == true)
                                                            btn-danger
                                                     @else
                                                           btn-success
                                                     @endif                                
                                                                                     
                                                                 btn-sm user_disable'>
                                                @if($tr['enabled'] == true)
                                                   Disable User 
                                                @else
                                                   Enable User
                                                @endif
                                                </button></td>

                                                    <td class='btncontainer'>
                                                        <button data-userid='{{ $tr['id'] }}' 
                                                               class='btn 
                                                @if($tr['isAdmin'] == true)
                                                     btn-danger
                                                @else
                                                     btn-success
                                                @endif
                                                     btn-sm user_admin'>
                                                     
                                                @if($tr['isAdmin'] == true)
                                                    Remove Admin 
                                                @else
                                                    Make Admin
                                                @endif
                                                
                                                </button></td>

                                        </tr>
                                        
                                        @endforeach
                                        
                                        
       
                                       
                                    </tbody>
                                </table>
                                
                            </div>
                            
                          

                        </div>

                    </div>
                    
                    <div id='pinball' class='col-md-12 content'>
                        <ul class="nav nav-tabs content-nav " >
                            <li class='active'  ><a data-toggle="tab" href="#list_pinball_main">Pinball Machine List</a></li>
                            <li  ><a data-toggle="tab" href="#add_pinball_main">Add Pinball Machine</a></li>
                        </ul>
                        
                        <div class='tab-content col-md-12'>
                            
                            <div id='add_pinball_main' class='tab-pane'>
                                <h1>Add Pinball Machines</h1>
                                     
                                     {{ Form::open(array('route' => 'postMachine', 'class' => 'form', 'id' => 'addMachine')) }}
    
                                <div class="form-group  has-feedback" id='machine_name'>
                                           {{ Form::label('name', 'Name: ', array('class' => 'control-label')) }}
                                           {{ Form::text('name', "", array( 'placeholder' => 'Name of Pinball Machine', 'class' => 'form-control')) }}
                                            <span style='display: none;' class="glyphicon glyphicon-remove form-control-feedback"></span>
                                            <span style='display: none;' class='help-inline'></span>                  
                                </div>

                                <div class="form-group   has-feedback" id='machine_description'>
                                           {{ Form::label('description', 'Description: ',array('class' => 'control-label')) }}
                                           {{ Form::textarea('description', "", array( 'placeholder' => 'Description of machine', 'class' => 'form-control', 'rows' => '5')) }}
                                           <span style='display: none;' class="glyphicon glyphicon-remove form-control-feedback"></span>
                                           <span style='display: none;' class='help-inline'></span>
                               </div>
                             <div class="form-group   has-feedback" id='machine_pics'>
                                           {{ Form::label('pictures', 'Pictures: ') }}
                               
                                            
                                        <div class="input-group">
                                                 <span class="input-group-btn">
                                                         <span class="btn btn-primary btn-file">
                                                                 Browse&hellip;  {{ Form::file('picture[]',  array(  'multiple' => '[]')) }}
                                                         </span>
                                                 </span>
                                                 <input type="text" class="form-control" readonly>
                                         </div>
                                        <span style='display: none;' class="glyphicon glyphicon-remove form-control-feedback"></span>
                                        <span style='display: none;' class='help-inline'></span>
                             </div>
                                     
                                     
                                           
                                           
                               {{ Form::submit('submit', array('class' => 'btn btn-success btn-lg')) }}



                                {{ Form::close() }}
                                
                                
                                <div class="alert" style="display: none;" id="addpinball_message">
                                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                              <span></span>
                                </div>
                                
                           
                                
                            </div>
                            
                            <div id='list_pinball_main' class='tab-pane active'>
                                <h1>Pinball Machine List</h1>
                                
                                <table id='pinball_table' class='table table-striped table-bordered table-responsive'>
                                    <thead>
                                        <tr>
                                            <th style='width: 25%;'>Name</th>
                                            <th style='width: 45%;'>Description</th>
                                            <th style='width: 10%;'></th>
                                            <th style='width: 10%;'></th>
                                            <th style='width: 10%;'></th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($machines as $tr)
                                        <tr >
                                            <td>{{ $tr['name'] }}</td>
                                            <td>{{ $tr['description'] }}</td>
                                            <td class='btncontainer'><button data-id="{{ $tr['id'] }}"  class='btn btn-info edit_machine_modal'>Edit </button></td>
                                            <td class='btncontainer'><a href="{{ route('getMachine', $tr['id']) }}"  class='btn btn-success'>View</a></td>
                                            @if($tr['isActive'] == true)
                                            <td class='btncontainer'><button data-id="{{ $tr['id'] }}" class='btn btn-danger pinball_retire'>Deactivate</button></td>
                                            @else
                                            <td class='btncontainer'><button data-id="{{ $tr['id'] }}" class='btn btn-success pinball_retire'>Activate</button></td>                                    
                                            @endif
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                          
                            <div class="modal fade" id="edit_pinball_machine" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                               

                                <div class="modal-dialog">
                                  <div class="modal-content">
                     {{ Form::open(array('route' => 'putMachine', 'class' => 'form', 'id' => 'edit_pinball_machine_form', 'style' => 'padding: 0;')) }}
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                      <h4 class="modal-title" id="myModalLabel">Edit Pinball Machine</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="alert alert-warning">
                                            If you upload pictures your previous pictures will be erased.
                                        </div>
    
                                <div class="form-group  has-feedback"  id='edit_machine_name'>
                                           {{ Form::label('name', 'Name: ', array('class' => 'control-label')) }}
                                           {{ Form::text('name', "", array( 'placeholder' => 'Name of Pinball Machine', 'class' => 'form-control'))}}
                                           <span style='display: none;' class="glyphicon glyphicon-remove form-control-feedback"></span>
                                        <span style='display: none;' class='help-inline'></span>       
                                </div>

                                <div class="form-group   has-feedback" id='edit_machine_description'>

                                           {{ Form::label('description', 'Description: ',array('class' => 'control-label')) }}
                                           {{ Form::textarea('description', "", array( 'placeholder' => 'Description of machine', 'class' => 'form-control', 'rows' => '5')) }}
                                           <span style='display: none;' class="glyphicon glyphicon-remove form-control-feedback"></span>
                                        <span style='display: none;' class='help-inline'></span>        
                               </div>
                            
                                <div class="form-group   has-feedback" id='edit_machine_pic'>

                                           {{ Form::label('pictures', 'Pictures: ') }}
                                          
                               <div class="input-group" >
					<span class="input-group-btn">
						<span class="btn btn-primary btn-file">
							Browse&hellip;  {{ Form::file('picture[]',  array(  'multiple' => '[]', 'class' => 'fileUploadSpecial')) }}
						</span>
					</span>
					<input type="text" class="form-control" readonly>
				</div>
                                           <span style='display: none;' class="glyphicon glyphicon-remove form-control-feedback"></span>
                                        <span style='display: none;' class='help-inline'></span>        

                                </div>   
                                {{ Form::hidden('machine_id', '', array('id' => 'machine_id')) }}         
                                     
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                      {{ Form::submit('Save Changes',array('class' => 'btn btn-primary', 'id' => 'edit_machine_submit')) }}
                                    </div>
                               {{ Form::close() }}
                                  </div>
                                </div>
                              </div>
                            
                        </div>
                        
                    </div>
                    
                    <div id='highscore' class='col-md-12 content'>
                        <ul class="nav nav-tabs content-nav " >
                            <li class='active'  ><a data-toggle="tab" href="#highscore_table_main">Score List</a></li>
                            <li  ><a data-toggle="tab" href="#add_highscore">Add Score</a></li>
                        </ul>
                        <div class='tab-content'>
                            <div id='highscore_table_main' class='tab-pane active'>
                               <h1>High Score List</h1>
                                <table id='highscore_table' class='table table-striped table-bordered table-responsive'>
                                    <thead>
                                        <tr>
                                            <th>User Name</th>
                                            <th>Score </th>
                                            <th>Date</th>
                                            <th>Pinball Machine</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($scores as $score)
                                        <tr>
                                            <td>{{ $score['username'] }}</td>
                                            <td>{{ $score['score'] }}</td>
                                            <td>{{ $score['datecreated'] }}</td>
                                            <td>{{ $score['machine_name'] }}</td>
                                            <td>
                                                <button data-id='{{ $score['id'] }}' class='btn btn-danger score_delete'>Delete</button>
                                            </td>

                                        </tr>
                                        
                                        @endforeach
                                    </tbody>
                                </table>
                                
                            </div>
                           
                            <div id='add_highscore' class="tab-pane">
                                     {{ Form::open(array('route' => 'postscore', 'class' => 'form', 'id' => 'add_score_form')) }}
    
                                <div class="form-group">
                                           {{ Form::label('username', 'User Name: ', array('class' => 'control-label')) }}
                                           {{ Form::select('username', $addSelection,"", array('class' => 'form-control','id' => 'select_user_highscore')) }}
                                        <span style='display: none;' class="glyphicon glyphicon-remove form-control-feedback"></span>
                                        <span style='display: none;' class='help-inline'></span>        
                                        

                                </div>
                                     
                                <div class="form-group" >
                                           {{ Form::label('machine', 'Pinball Machine: ', array('class' => 'control-label')) }}
                                           {{ Form::select('machine', $selectMachine,"", array('class' => 'form-control','id' => 'select_user_highscore')) }}
                                        <span style='display: none;' class="glyphicon glyphicon-remove form-control-feedback"></span>
                                        <span style='display: none;' class='help-inline'></span>        


                                </div>
                                     

                                <div class="form-group   has-feedback" id='addscore_score'>
                                           {{ Form::label('score', 'Score: ',array('class' => 'control-label')) }}
                                           {{ Form::text('score', "", array( 'placeholder' => 'Score', 'class' => 'form-control')) }}
                                                                          
                                        <span style='display: none;' class="glyphicon glyphicon-remove form-control-feedback"></span>
                                        <span style='display: none;' class='help-inline'></span>        

                                </div>
                                                                          

                                 <div class="form-group has-feedback" id='addscore_time'>
                                            {{ Form::label('time', 'Date & Time: ',array('class' => 'control-label')) }}
                                    <div class='input-group date' id='datetimepicker1'>
                                           {{ Form::text('time', "", array( 'readonly' => true, 'class' => 'form-control')) }}
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                           
                                        <span style='display: none;' class='help-inline'></span>        
                                </div>

                                
                               <div class="form-group has-feedback" id='addscore_picture'>

                                {{ Form::label('picture', 'Pictures: ',array('class' => 'control-label')) }}
                                           
                               <div class="input-group">
					<span class="input-group-btn">
						<span class="btn btn-primary btn-file">
							Browse&hellip;  {{ Form::file('picture',  array(  'class' => 'fileUploadSpecial')) }}
						</span>
					</span>
					<input type="text" class="form-control" readonly>
				</div>
                                        <span style='display: none;' class="glyphicon glyphicon-remove form-control-feedback"></span>
                                        <span style='display: none;' class='help-inline'></span>        
                              </div>
                                           
                               {{ Form::submit('submit', array('class' => 'btn btn-success btn-lg space')) }}

                                {{ Form::close() }}
                                
                                <div class="alert" style="display: none;" id="addscore_message">
                                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                              <span></span>
                                </div>
                                
                            </div>
                            
                        </div>
                    </div>
                    </div>
        </div>
                             
                            
        
        @section('js')
        
        <script type='text/javascript'>
        
        var resetPasswordUrl = "{{ route('postAdminResetPassword') }}";
        var enableUrl = "{{ route('postDisableUser') }}";
        var adminChangeUrl = "{{ route('postChangeAdminRole') }}"
        var pinballMachineUrl = "{{ route('getMachine', 'MACHINE_ID_REPLACE') }}";
        var getmachineURL = "{{ route('getMachineJSON', 'MACHINE_ID') }}";
        var pinballstatusURL = "{{ route('machineStatus', 'MACHINE_ID') }}";
        var deleteScore = "{{ route('deletescore', 'MACHINE_ID') }}";
        </script>
        
            {{ HTML::script('/web/js/jquery.js'); }}
            {{ HTML::script('/web/bootstrap/js/bootstrap.js'); }}
            {{ HTML::script('/web/js/jquery.dataTables.js'); }}
            {{ HTML::script('/web/js/dataTables.bootstrap.js'); }}
            {{ HTML::script("/web/js/jquery.form.js"); }}  
            {{ HTML::script("/web/bootstrap/js/moment.js"); }}
            {{ HTML::script("/web/bootstrap/js/bootstrap-datetimepicker.min.js"); }}
            {{ HTML::script('/web/js/admin.js'); }}



            <script type='text/javascript'>
            (function(){
                
                
                                   
                $(".content").hide();
                $("#users").show();
                
                $("a.list-group-item").on('click', function(){
                   $("a.list-group-item").removeClass('active');
                   $(this).addClass('active');
                   var id  = $(this).attr('data-page');
                   $(".content").hide();
                   $("#" + id).show();
                   
                });
                

                
                
                
                /** File Upload Btn **/
                $(document).on('change', '.btn-file :file', function() {
				var input = $(this);
				numFiles = input.get(0).files ? input.get(0).files.length : 1;
				label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
				input.trigger('fileselect', [numFiles, label]);
		});
                
                $("input.fileUploadSpecial").each(function()
                {
                   $(this).val(""); 
                });
                $(document).ready( function() {
			$('.btn-file :file').on('fileselect', function(event, numFiles, label) {
				  
				
                                var input = $(this).parents('.input-group').find(':text'),
				log = numFiles > 1 ? numFiles + ' files selected' : label;
				
				if( input.length )
                                {
					input.val(log);
				} 
                                
				
			});
		});		
                
            })(document);
            
            </script>
        @show
        
    </body>
</html>
