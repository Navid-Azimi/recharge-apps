<div id="navbar-full">
    <div id="navbar">
        <nav class="navbar navbar-ct-blue navbar-fixed-top" role="navigation">
            <div class="alert alert-success hidden">
                <div class="container">
                    <b>Lorem ipsum</b> dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
                </div>
            </div>
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#gsdk">KikWek</a>
                </div>
            
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                        <a href="#gsdk" class="dropdown-toggle" data-toggle="dropdown">Send top-up <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('public_package') }}">Send top-up <span class="label label-info">Afghanistan</span></a> </li>
                            <li><a href="{{ route('public_request') }}">Requested Number</a></li>
                            <li><a href="#gsdk">Request top-up</a></li>
                        </ul>
                        </li>
                        <li><a href="#gsdk">Gift Cards</a></li>
                        <li><a href="#gsdk">Company</a></li>
                        <li><a href="#gsdk">Help</a></li>
                        
                        
                        @if(Auth::user())
                        <li class="dropdown">
                            <a href="#gsdk" class="dropdown-toggle" data-toggle="dropdown">My Account <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                            <li><a href="#gsdk">{{ Auth::user()->name }}</a></li>
                            <form method="POST" id="logout-form" action="{{ route('logout') }}"> @csrf </form>
                            <li><a href="route('logout')" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('Log Out') }}
                                </a>
                            </li>
                            </ul>
                        </li>
                        @else
                        <li><a class="btn btn-round btn-default" href="{{ route('login') }}">Sign in</a></li>
                        @endif
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div>
        </nav>
    </div>
</div>
<!-- this is public pages start tags -->
