<!-- Left Sidebar -->
<div class="left main-sidebar">

    <div class="sidebar-inner leftscroll">

        <div id="sidebar-menu">

            <ul>

                <li class="submenu">
                    <a

                        @if(Request()->route()->getName() == 'adminDashboard')
                        class="active"
                        @endif
                        href="{{route('adminDashboard')}}">
                        <i class="fas fa-tachometer-alt"></i> <span> Dashboard</span>
                        {{--<span class="menu-arrow"></span>--}}
                    </a>
                </li>









{{--         --}}
                <li class="submenu">
                    <a

{{--                        @if(Request()->route()->getName() == 'projectListing' ||--}}
{{--                        Request()->route()->getName() == 'projectCreate'  )--}}
{{--                        class="active"--}}
{{--                        @endif--}}
                        href="javascript:void(0)">
                        <i class="fas fa-tachometer-alt"></i> <span>Expertise</span>
                        <span class="menu-arrow"></span></a>

                    <ul class="list-unstyled">
                        <li><a href="#">Listing</a></li>
                        <li><a href="#">Create Expertise</a></li>
                    </ul>


{{--                </li>--}}



            </ul>


            <div class="clearfix"></div>

        </div>

        <div class="clearfix"></div>

    </div>

</div>
<!-- End Sidebar -->
