<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>{{$title}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="assets/style.css"/>
    <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script src="{{ asset('assets/bootstrap/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/script.js') }}"></script>

    <!-- Owl stylesheet -->
    <link rel="stylesheet" href="assets/owl-carousel/owl.carousel.css">
    <link rel="stylesheet" href="assets/owl-carousel/owl.theme.css">
    <script src="{{ asset('assets/owl-carousel/owl.carousel.js') }}"></script>
    <!-- Owl stylesheet -->


<!-- slitslider -->
    <link rel="stylesheet" type="text/css" href="assets/slitslider/css/style.css" />
    <link rel="stylesheet" type="text/css" href="assets/slitslider/css/custom.css" />
    <script type="text/javascript" src="{{ asset('assets/slitslider/js/modernizr.custom.79639.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/slitslider/js/jquery.ba-cond.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/slitslider/js/jquery.slitslider.js') }}"></script>
<!-- slitslider -->



   <style>
        .notification {
          position: relative;
        }

        .notification-count {
            position: absolute;
            top: -8px;
            right: -12px;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 16px;
            height: 16px;
            background-color: red;
            color: white;
            font-size: 10px;
            border-radius: 50%;
        }


    </style>

</head>

<body>
<!-- Header Starts -->
<div class="navbar-wrapper">

        <div class="navbar-inverse" role="navigation">
          <div class="container">
            <div class="navbar-header">


              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>

            </div>


            <!-- Nav Starts -->
              <div class="navbar-collapse  collapse">
                  <ul class="nav navbar-nav navbar-right">
                      <li class="{{ Request::is('/') ? 'active' : '' }}"><a href="{{route('index')}}">Home</a></li>
                      <li class="{{ Request::is('about') ? 'active' : '' }}"><a href="{{route('about')}}">About</a></li>
                      <li class="{{ Request::is('agents') ? 'active' : '' }}"><a href="{{route('agents')}}">Agents</a></li>
                      <li class="{{ Request::is('contact') ? 'active' : '' }}"><a href="{{route('contact')}}">Contact</a></li>
                  </ul>
              </div>
            <!-- #Nav Ends -->

          </div>
        </div>

    </div>
<!-- #Header Starts -->
    <div class="container">
    <!-- Header Starts -->
        <div class="header">

            <a href="{{route('index')}}"><img style="width: 171px" src="{{ asset('images/logo.jpeg') }}" alt="Realestate"></a>

            @auth()
                <div class="dropdown pull-right ">
                    <div  class="dropdown-toggle"  id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" >
                        <h4 style="color: #72B70F; font-weight: bolder;">
                {{--              to get the first name only                  --}}
                            {{ explode(' ', Auth::user()->name)[0] }}
                            <span class="caret"></span>
                        </h4>
                    </div>
                    <ul class="dropdown-menu m-0" aria-labelledby="dropdownMenu1">
                        <li><a href="{{route('profile.edit')}}"> {{ __('Profile') }}</a></li>
                        <li><a href="{{route('units')}}">Units</a></li>
                        <li><a href="{{route('salerent')}}">Upload Unit</a></li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <li><a style="color: black; margin-left: 19px;" href="{{route('logout')}}" onclick="event.preventDefault();this.closest('form').submit();"> {{ __('Log Out') }}</a></li>
                        </form>

                    </ul>
                </div>

            <!--notifications-->
            <div class="dropdown pull-right" style="margin-right: 25px;">
                    <div  class="dropdown-toggle"  id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" >
                        <h4 style="color: #72B70F; font-weight: bolder;">

                        <div class="notification">
                             <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="black" class="bi bi-bell-fill" viewBox="0 0 16 16">
                                 <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zm.995-14.901a1 1 0 1 0-1.99 0A5.002 5.002 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901z"/>
                            </svg>
                            @php if(count(Auth::user()->unreadNotifications) != 0 ){@endphp
                              <span class="notification-count">{{count(Auth::user()->unreadNotifications)}}</span>
                            @php } @endphp
                        </div>

                        </h4>
                    </div>
                    <ul class="dropdown-menu m-0" aria-labelledby="dropdownMenu1" >
                        <center><a>Mark As Read </a></center>
                        @foreach(Auth::user()->unreadNotifications as $notification)
                           <li><a href="{{route('notification', $notification->data['unit_id'])}}" style="text-transform: lowercase;">{{GetUser($notification->data['reported_user'])->name}} Reported on your post .</a></li>
                        @endforeach
                    </ul>
            </div>
            <!--notifications -->

            @endauth
            @guest()
                <div class=" pull-right">
                        <a  href="{{ route('login') }}" class="btn btn-info" >Login</a>
                        <a  href="{{ route('register') }}" class="btn btn-info" >Register</a>
                </div>
            @endguest

        </div>
    <!-- #Header Starts -->
    </div>
