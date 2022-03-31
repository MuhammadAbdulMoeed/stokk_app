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


                <li class="submenu">
                    <a

                        @if(Request()->route()->getName() == 'categoryListing' ||
                        Request()->route()->getName() == 'categoryCreate'  )
                        class="active"
                        @endif
                        href="javascript:void(0)">
                        <i class="fas fa-tachometer-alt"></i> <span>Category</span>
                        <span class="menu-arrow"></span></a>

                    <ul class="list-unstyled">
                        <li><a href="{{route('categoryListing')}}">Listing</a></li>
                        <li><a href="{{route('categoryCreate')}}">Create Category</a></li>
                    </ul>


                </li>


                <li class="submenu">
                    <a

                        @if(Request()->route()->getName() == 'filterListing' ||
                        Request()->route()->getName() == 'filterCreate'  )
                        class="active"
                        @endif
                        href="javascript:void(0)">
                        <i class="fas fa-tachometer-alt"></i> <span> Filters</span>
                        <span class="menu-arrow"></span></a>

                    <ul class="list-unstyled">
                        <li><a href="{{route('filterListing')}}">Listing</a></li>
                        <li><a href="{{route('filterCreate')}}">Create Filter</a></li>
                    </ul>


                </li>

                <li class="submenu">
                    <a

                        @if(Request()->route()->getName() == 'categoryFilterListing' ||
                        Request()->route()->getName() == 'categoryFilterCreate'  )
                        class="active"
                        @endif
                        href="javascript:void(0)">
                        <i class="fas fa-tachometer-alt"></i> <span> Category Filters</span>
                        <span class="menu-arrow"></span></a>

                    <ul class="list-unstyled">
                        <li><a href="{{route('categoryFilterListing')}}">Listing</a></li>
                        <li><a href="{{route('categoryFilterCreate')}}">Create</a></li>
                    </ul>


                </li>



            </ul>


            <div class="clearfix"></div>

        </div>

        <div class="clearfix"></div>

    </div>

</div>
<!-- End Sidebar -->
