@extends('layouts.main')

@section('stylesheets')
@parent
{{ HTML::style('/web/css/lightbox.css'); }}
<style>
     body
       {
           background-color: #d24726;
       }
       
         @media (min-width: 300px) 
         {
         
            div#ri-grid ul li
            {  
                width: 100%!important;
                height: 33%;
                min-height: 300px;
            }
         }
            
         @media (min-width: 800px) 
         {
                div#ri-grid ul li
                {
                    width: 50%!important;
                    height: 33%;
                    min-height: 300px;

                }
           }
       
              
             
</style>

@stop


@section('content')
<div id="ri-grid" class="ri-grid ri-grid-size-2">
    <ul  >    
        @for($i = 1; $i < 20; $i += 1)
        @foreach($picList as $pic)
        <li>
                <a data-lightbox="show" title='{{ $pic['title'] }}'  href="{{ $pic['pic'] }}">
                    <img src="{{ $pic['pic'] }}" alt="Whatever works"/>
                </a>
        </li>
        @endforeach
        @endfor
        <!-- ... -->
    </ul>
</div>


@stop

@section('js')

@parent
            {{ HTML::script('/web/js/jquery.dataTables.js'); }}
            {{ HTML::script("/web/js/modernizr.custom.js"); }}
            {{ HTML::script('/web/js/jquery.gridrotator.js'); }}
            {{ HTML::script("/web/js/lightbox.js"); }}
            
            <script>
                	
			$(document).ready(function(){
			
				$( '#ri-grid' ).gridrotator( {
					maxStep         :8,
                                        preventClick    : false,
                                        interval        : 1000
				} );
			
			});
		
            
          
            </script>

@stop

