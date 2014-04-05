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
       
       
       @media (min-width: 720px) {

            div.pinball_holder:nth-of-type(odd)
            {
                border: solid black 2px;
                display: inline-block; 
                width: 35%; 
                margin-right: 5%;
                margin-left: 5%; 
                min-width: 250px;
                background-color: white; 
                margin-bottom: 50px;
            }
            div.pinball_holder:nth-of-type(even)
            {
                border: solid black 2px;
                display: inline-block; 
                width: 35%; 
                margin-right: 5%;
                margin-left: 10%; 
                min-width: 250px;
                background-color: white; 
                margin-bottom: 50px;
            }
       }
       
              @media (min-width: 300px) 
              {
                  div.pinball_holder
                  {
                    border: solid black 2px;
                    display: inline-block; 
                    width: 80%; 
                    margin-right: 8%;
                    margin-left: 8%; 
                    min-width: 250px;
                    background-color: white; 
                    margin-bottom: 50px;
                  }
              }
              div.pinball_holder img
              {
                  width: 80%; 
                  height: 70%;  
                  margin-left: 10%; 
                  margin-top: 5%;
              }
</style>

@stop


@section('content')


        @foreach($machines as $machine)
        <div  class='pinball_holder'>
            <img src="{{ asset($machine['pic']) }}"    class="img-circle">

            <h1>{{ link_to_route('getMachine', $machine['name'], array($machine['id'])) }}</h1>
         </div>
        @endforeach


@stop

@section('js')

@parent
           

@stop
