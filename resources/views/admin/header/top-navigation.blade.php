 <!-- top bar navigation -->
<div class="headerbar">

    <!-- LOGO -->
    <div class="headerbar-left align-items-center justify-content-between">
{{--                <a href="{{route('adminDashboard')}}" class="logo">--}}
{{--                    <span><img alt="Logo" src="{{asset('admin/images/Assetlogo.png')}}"/></span>--}}
{{--                    <img alt="Logo" src="{{asset('admin/images/favicon.png')}}"/>--}}
{{--                </a>--}}


        <h1 class="logo"><a href="{{route('adminDashboard')}}" class="site_name"></a></h1>

    </div>

    <nav class="navbar-custom">
        <ul class="list-inline float-right mb-0">


            <li class="list-inline-item dropdown notif">
                <a class="nav-link dropdown-toggle nav-user" data-toggle="dropdown" href="#" role="button"
                   aria-haspopup="false" aria-expanded="false">

{{--                    @if(Auth::user()->profile_image)--}}
{{--                        <img src="{{asset(Auth::user()->profile_image)}}"--}}
{{--                             alt="Profile image" class="avatar-rounded">--}}
{{--                    @else--}}
                        <img src="{{asset('custom/images/user (5).png')}}"
                             alt="Profile image" class="avatar-rounded">
{{--                    @endif--}}


                </a>
                <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                    <!-- item-->
                    <div class="dropdown-item noti-title">
                        <h5 class="text-overflow">
                            <small>
                                {{--Hello, {{Auth::user()->name}}--}}
                                @if(Auth::user()->username)
                                    Hello, {{Auth::user()->username}}
                                @else
                                    Hello
                                @endif
                            </small>
                        </h5>
                    </div>

                    <!-- item-->
{{--                    <a href="{{route('adminProfile')}}" class="dropdown-item notify-item">--}}
{{--                        <i class="fa fa-user"></i> <span>Profile</span>--}}
{{--                    </a>--}}

                    <!-- item-->
                    <a href="{{route('logoutUser')}}" class="dropdown-item notify-item">
                        <i class="fa fa-power-off"></i> <span>Logout</span>
                    </a>
                </div>
            </li>

        </ul>

        <ul class="list-inline menu-left mb-0">
            <li class="float-left">
                <button class="button-menu-mobile open-left">
                    <i class="fa fa-fw fa-bars"></i>
                </button>
            </li>
        </ul>

    </nav>

</div>
<!-- End Navigation -->
