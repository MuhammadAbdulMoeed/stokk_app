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

                        @if(Request()->route()->getName() == 'userListing' ||
                        Request()->route()->getName() == 'userCreate'  )
                        class="active"
                        @endif
                        href="javascript:void(0)">
                        <i class="fas fa-tachometer-alt"></i> <span>Users</span>
                        <span class="menu-arrow"></span></a>

                    <ul class="list-unstyled">
                        <li><a href="{{route('userListing')}}">Listing</a></li>
                        <li><a href="{{route('userCreate')}}">Create User</a></li>
                    </ul>


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

                <li class="submenu">
                    <a

                        @if(Request()->route()->getName() == 'brandListing' ||
                        Request()->route()->getName() == 'brandCreate'  )
                        class="active"
                        @endif
                        href="javascript:void(0)">
                        <i class="fas fa-tachometer-alt"></i> <span> Brands </span>
                        <span class="menu-arrow"></span></a>

                    <ul class="list-unstyled">
                        <li><a href="{{route('brandListing')}}">Listing</a></li>
                        <li><a href="{{route('brandCreate')}}">Create</a></li>
                    </ul>


                </li>

                <li class="submenu">
                    <a

                        @if(Request()->route()->getName() == 'classListing' ||
                        Request()->route()->getName() == 'classCreate'  )
                        class="active"
                        @endif
                        href="javascript:void(0)">
                        <i class="fas fa-tachometer-alt"></i> <span> Class </span>
                        <span class="menu-arrow"></span></a>

                    <ul class="list-unstyled">
                        <li><a href="{{route('classListing')}}">Listing</a></li>
                        <li><a href="{{route('classCreate')}}">Create</a></li>
                    </ul>


                </li>


                <li class="submenu">
                    <a

                        @if(Request()->route()->getName() == 'itemConditionListing' ||
                        Request()->route()->getName() == 'itemConditionCreate'  )
                        class="active"
                        @endif
                        href="javascript:void(0)">
                        <i class="fas fa-tachometer-alt"></i> <span> Item Condition </span>
                        <span class="menu-arrow"></span></a>

                    <ul class="list-unstyled">
                        <li><a href="{{route('itemConditionListing')}}">Listing</a></li>
                        <li><a href="{{route('itemConditionCreate')}}">Create</a></li>
                    </ul>


                </li>


            </ul>


            <div class="clearfix"></div>

        </div>

        <div class="clearfix"></div>

    </div>

</div>
<!-- End Sidebar -->
