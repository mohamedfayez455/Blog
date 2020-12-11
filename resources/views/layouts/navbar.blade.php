        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if( Sentinel::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
                                    {{ Sentinel::getUser()->username }} <span class="caret"></span>

                                    @if(Sentinel::getUser()->profile_picture)
                                        @php
                                            $profile_picture = Sentinel::getUser()->profile_picture ;
                                        @endphp
                                        <img src="{{ asset("profile_picture/$profile_picture") }}" style="max-height:30px; max-width: 30px; border-radius: 50% " alt="">
                                    @else
                                        <span><i class="fa fa-user-circle fa-lg" aria-hidden="true"></i></span>
                                    @endif

                                </a>

                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>

                                    @if(Sentinel::getUser()->hasAnyAccess(['*.create' , '*.approve']))
                                        <li><a href="{{route('posts.create')}}">Create Post</a></li>
                                        <li><a href="{{route('posts.unApproved')}}">UnApproved Post</a></li>
                                    @endif

{{--                                        <li><a href="{{route('profile' , Sentinel::getUser()->username)}}">Update Porfile</a></li>--}}
                                        <li><a href="/profile/{{Sentinel::getUser()->username}}">Update Porfile</a></li>

                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>