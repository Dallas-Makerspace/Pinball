
    


      <div class="navbar navbar-default" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="{{ route('home') }}">Pinball</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav" >
            <li class='sp @if(in_array('home', $active)) active @endif; '>{{ link_to_route('home', "Home", array(),  array()) }}</li>
            <li class='sp @if(in_array( 'pictures', $active)) active @endif;'>{{ link_to_route('pictures', "Photos", array(),  array()) }}</li>
            <li class='sp @if(in_array( 'roster', $active)) active @endif;'>{{ link_to_route('roster', "Roster", array(),  array()) }}</li>
            <li class='sp @if(in_array( 'pinballs',$active)) active @endif;'>{{ link_to_route('getMachines', "Pinball", array(),  array()) }}</li>
            @if(Auth::check())
                <li class='sp @if(in_array( 'record', $active)) active @endif;'>{{ link_to_route('record', "Record Score", array(),  array()) }}</li>
                <li class='sp @if(in_array( 'logout', $active)) active @endif;'>{{ link_to_route('logout', "Logout", array(),  array()) }}</li>
 
           @else
                <li class='sp @if(in_array( 'getSignIn', $active)) active @endif;'>{{ link_to_route('getSignIn', "Sign in", array(),  array()) }}</li>
            @endif
         </ul>
          
        </div><!--/.nav-collapse -->
      </div>
    </div>