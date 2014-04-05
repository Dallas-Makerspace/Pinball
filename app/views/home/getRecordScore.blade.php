@extends('layouts.main')

@section('stylesheets')

@parent
        {{ HTML::style('/web/bootstrap/css/bootstrap-datetimepicker.min.css') }}

<style>
       body
       {
           background-image: url('/web/images/mainbackground.jpg');
           background-size: cover;
           background-repeat: no-repeat;
       }
       video, #webcam_image
       {
           width: 100%;
           height: 100%;
       }
       button#takePictureBTN
       {
           width: 100%;
           margin: 20px auto;
           display: block;
           
               
       }
       
       
</style>

@stop


@section('content')
<h1 class="col-md-offset-4 col-md-4">Add High Score</h1>

@if(Session::has("score_errors") == true)
<div class="alert alert-danger alert-dismissable col-md-offset-4 col-md-4 clear">
         <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
   {{ Session::get("score_errors") }}
</div>
                @if($errors->has('base64_img')) 
                    <div class="alert alert-danger alert-dismissable col-md-offset-4 col-md-4 clear">
                             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                       {{ $errors->first('base64_img') }}
                    </div>
                @endif
@endif;
<div class='row'>
    <div class="col-md-8 col-md-offset-2">
         {{ Form::open(array('route' => 'addHighScore', 'class' => 'form  col-md-12', 'files' => true)) }}
    
         <div class="form-group" >
               {{ Form::label('machine', 'Pinball Machine: ', array('class' => 'control-label')) }}
               {{ Form::select('machine', $machines,"", array('class' => 'form-control','id' => 'select_user_highscore')) }}
         </div>
         
         <div id="addscore" class="form-group @if($errors->has('score')) has-error @endif  has-feedback">
                                            
             
             {{ Form::label('score', 'Pinball Score: ', array('class' => 'control-label')) }}
               {{ Form::text('score',"", array('class' => 'form-control','id' => 'highscore')) }}
   
             @if($errors->has('score')) 
             <span  class="glyphicon glyphicon-remove form-control-feedback"></span>
             <span  class='help-inline'>{{ $errors->first('score') }}</span>  
              @endif 
         </div>
         
         
         
         
         <div class="form-group @if($errors->has('time')) has-error @endif has-feedback" id='addscore_time'>
                                            {{ Form::label('time', 'Date & Time: ',array('class' => 'control-label')) }}
                                    <div class='input-group date' id='datetimepicker1'>
                                           {{ Form::text('time', date('n/j/Y g:i A', strtotime("-5 hour")), array( 'readonly' => true, 'class' => 'form-control')) }}
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
             @if($errors->has('time')) 
                    <span  class="glyphicon glyphicon-remove form-control-feedback"></span>
                    <span  class='help-inline'>{{ $errors->first('time') }}</span>  
             @endif                 
       </div>
         
         
            <div class="form-group" >
                  {{ Form::label('picType', 'Picture Type: ', array('class' => 'control-label')) }}
                  {{ Form::select('picType', array('livecam' => "Use Webcam", 'Upload' => 'Upload Picture'),"livecam", array('class' => 'form-control','id' => 'picture_select')) }}
            </div>

          <div class="form-group @if($errors->has('picture')) has-error @endif has-feedback"  id='addscore_picture'>

                    {{ Form::label('picture', 'Pictures: ',array('class' => 'control-label')) }}

                    <div class="input-group">
                            <span class="input-group-btn">
                                    <span class="btn btn-primary btn-file">
                                            Browse&hellip;  {{ Form::file('picture',  array(  'class' => 'fileUploadSpecial')) }}
                                    </span>
                            </span>
                            <input type="text" class="form-control" readonly>
                    </div>
            @if($errors->has('picture')) 
                    <span  class="glyphicon glyphicon-remove form-control-feedback"></span>
                    <span  class='help-inline'>{{ $errors->first('picture') }}</span>  
             @endif        
          </div>         

               
         <div class="col-md-12" id="addscore_livecam">
             <button class=" btn btn-primary" id="takePictureBTN" type="button" >Take Your Picture</button>
             {{ Form::hidden("base64_img","", array('id' => 'base64_img') ); }}
             <div id="highscore_pre" class="col-md-offset-1 col-md-10">
                    
             </div>   
                             <hr />
             <div class="col-md-offset-1 col-md-10">
             <img id="webcam_image" alt="high score pic" src="{{ asset('/web/images/person.png') }}" />
             </div>
         </div>
             
         
         
    {{ Form::submit('submit', array('class' => 'btn btn-success btn-lg space')) }}
    

    {{ Form::close() }}
    
    </div>
</div>

@stop

@section('js')

@parent
            {{ HTML::script("/web/bootstrap/js/moment.js"); }}
                        {{ HTML::script("/web/js/say-cheese.js"); }}

            {{ HTML::script("/web/bootstrap/js/bootstrap-datetimepicker.min.js"); }}

<script>
    
    (function(){
                /** File Upload Btn **/
                $(document).on('change', '.btn-file :file', function() {
				var input = $(this);
				numFiles = input.get(0).files ? input.get(0).files.length : 1;
				label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
				input.trigger('fileselect', [numFiles, label]);
		});
                 $(document).on("change", "#picture_select", function(){
                    
                        changeLiveCamUpload();
                     
                });
                $("input.fileUploadSpecial").each(function()
                {
                   $(this).val(""); 
                });
                   function changeLiveCamUpload()
                    {
                         var selected = $("#picture_select option:selected").val();
                         if(selected === "livecam")
                         {
                             $("#addscore_livecam").show();
                             $("#addscore_picture").hide();
                         }
                         else
                         {
                             $("#addscore_livecam").css('display', 'none');
                             $("#addscore_picture").show();
                         }
                    }
                $(document).ready( function() {
                    
                    
                        changeLiveCamUpload();
                    
			$('.btn-file :file').on('fileselect', function(event, numFiles, label) {
				  
				
                                var input = $(this).parents('.input-group').find(':text'),
				log = numFiles > 1 ? numFiles + ' files selected' : label;
				
				if( input.length )
                                {
					input.val(log);
				} 
                                
				
			});
                        
                        $('#datetimepicker1').datetimepicker();
                        function takepicture()
                        {

                            sayCheese.takeSnapshot();
                        }

                        var sayCheese = new SayCheese('#highscore_pre', { snapshots: true });

                        sayCheese.on('start', function() {
                        });

                        sayCheese.on('error', function(error) {
                         // handle errors, such as when a user denies the request to use the webcam,
                         // or when the getUserMedia API isn't supported
                        });

                        sayCheese.on('snapshot', function(snapshot) {
                            ;
                             $("#webcam_image").attr("src", snapshot.toDataURL('image/png'));
                           $("#base64_img").val(snapshot.toDataURL('image/png'));
                           


                        });

                        $("#takePictureBTN").on("click", function(){
                             sayCheese.takeSnapshot();
                        });
                        sayCheese.start();
            
    
            });	
                

            
            
        
                
            })(document);
            
            

</script>

@stop