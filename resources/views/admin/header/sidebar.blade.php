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
                        <i class="fa fa-users"></i> <span>Users</span>
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
                        <i class="fas fa-signal"></i> <span>Category</span>
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
                        <i class="fa fa-filter"></i> <span> Filters</span>
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
                        <i class="fa fa-filter"></i> <span> Category Filters</span>
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
                        <i class="fas fa-check-square"></i> <span> Brands </span>
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
                        <i class="fas fa-chalkboard"></i> <span> Class </span>
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
                        <i class="fab fa-leanpub"></i> <span> Item Condition </span>
                        <span class="menu-arrow"></span></a>

                    <ul class="list-unstyled">
                        <li><a href="{{route('itemConditionListing')}}">Listing</a></li>
                        <li><a href="{{route('itemConditionCreate')}}">Create</a></li>
                    </ul>


                </li>


                <li class="submenu">
                    <a

                        @if(Request()->route()->getName() == 'sizeListing' ||
                        Request()->route()->getName() == 'sizeCreate'  )
                        class="active"
                        @endif
                        href="javascript:void(0)">
                        <i class="fas fa-sort-amount-up"></i> <span> Size </span>
                        <span class="menu-arrow"></span></a>

                    <ul class="list-unstyled">
                        <li><a href="{{route('sizeListing')}}">Listing</a></li>
                        <li><a href="{{route('sizeCreate')}}">Create</a></li>
                    </ul>


                </li>

                <li class="submenu">
                    <a

                        @if(Request()->route()->getName() == 'additionalOptionListing' ||
                        Request()->route()->getName() == 'additionalOptionCreate'  )
                        class="active"
                        @endif
                        href="javascript:void(0)">
                        <i class="fa fa-plus-square"></i> <span> Additional Option </span>
                        <span class="menu-arrow"></span></a>

                    <ul class="list-unstyled">
                        <li><a href="{{route('additionalOptionListing')}}">Listing</a></li>
                        <li><a href="{{route('additionalOptionCreate')}}">Create</a></li>
                    </ul>


                </li>

                <li class="submenu">
                    <a

                        @if(Request()->route()->getName() == 'clothTypeListing' ||
                        Request()->route()->getName() == 'clothTypeCreate'  )
                        class="active"
                        @endif
                        href="javascript:void(0)">
                        <i class="fa fa-plus-square"></i> <span> Clothing Type </span>
                        <span class="menu-arrow"></span></a>

                    <ul class="list-unstyled">
                        <li><a href="{{route('clothTypeListing')}}">Listing</a></li>
                        <li><a href="{{route('clothTypeCreate')}}">Create</a></li>
                    </ul>


                </li>



                <li class="submenu">
                    <a

                        @if(Request()->route()->getName() == 'productListing' ||
                        Request()->route()->getName() == 'productCreate'  )
                        class="active"
                        @endif
                        href="javascript:void(0)">
                        <i class="fab fa-product-hunt"></i> <span> Product </span>
                        <span class="menu-arrow"></span></a>

                    <ul class="list-unstyled">
                        <li><a href="{{route('productListing')}}">Listing</a></li>
                        <li><a href="{{route('productCreate')}}">Create</a></li>
                    </ul>


                </li>



            </ul>


            <div class="clearfix"></div>

        </div>

        <div class="clearfix"></div>

    </div>

</div>
<!-- End Sidebar -->
