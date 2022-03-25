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

                        @if(Request()->route()->getName() == 'showTitle')
                        class="active"
                        @endif
                        href="{{route('showTitle')}}">
                        <i class="fas fa-tachometer-alt"></i> <span> Title </span>
                        {{--<span class="menu-arrow"></span>--}}
                    </a>
                </li>


                <li class="submenu">
                    <a

                        @if(Request()->route()->getName() == 'showCookie')
                        class="active"
                        @endif
                        href="{{route('showCookie')}}">
                        <i class="fas fa-tachometer-alt"></i> <span> Cookies </span>
                        {{--<span class="menu-arrow"></span>--}}
                    </a>
                </li>


                <li class="submenu">
                    <a

                        @if(Request()->route()->getName() == 'showDisclaimer')
                        class="active"
                        @endif
                        href="{{route('showDisclaimer')}}">
                        <i class="fas fa-tachometer-alt"></i> <span> Disclaimer </span>
                        {{--<span class="menu-arrow"></span>--}}
                    </a>
                </li>


                <li class="submenu">
                    <a

                        @if(Request()->route()->getName() == 'showPolicy')
                        class="active"
                        @endif
                        href="{{route('showPolicy')}}">
                        <i class="fas fa-tachometer-alt"></i> <span> Privacy Policy </span>
                        {{--<span class="menu-arrow"></span>--}}
                    </a>
                </li>

                <li class="submenu">
                    <a

                        @if(Request()->route()->getName() == 'showTerms')
                        class="active"
                        @endif
                        href="{{route('showTerms')}}">
                        <i class="fas fa-tachometer-alt"></i> <span> Terms and Conditions </span>
                        {{--<span class="menu-arrow"></span>--}}
                    </a>
                </li>

                <li class="submenu">
                    <a

                        @if(Request()->route()->getName() == 'faqManagement')
                        class="active"
                        @endif
                        href="{{route('faqManagement')}}">
                        <i class="fas fa-tachometer-alt"></i> <span> FAQ </span>
                        {{--<span class="menu-arrow"></span>--}}
                    </a>
                </li>



                <li class="submenu">
                    <a

                        @if(Request()->route()->getName() == 'showImpressums')
                        class="active"
                        @endif
                        href="{{route('showImpressums')}}">
                        <i class="fas fa-tachometer-alt"></i> <span> Impressums </span>
                        {{--<span class="menu-arrow"></span>--}}
                    </a>
                </li>



                <li class="submenu">
                    <a

                        @if(Request()->route()->getName() == 'aboutUsManagement')
                        class="active"
                        @endif
                        href="{{route('aboutUsManagement')}}">
                        <i class="fas fa-tachometer-alt"></i> <span> About Us</span>
                        {{--<span class="menu-arrow"></span>--}}
                    </a>
                </li>


                <li class="submenu">
                    <a

                        @if(Request()->route()->getName() == 'contactUsManagement')
                        class="active"
                        @endif
                        href="{{route('contactUsManagement')}}">
                        <i class="fas fa-tachometer-alt"></i> <span> Contact Us</span>
                        {{--<span class="menu-arrow"></span>--}}
                    </a>
                </li>


                <li class="submenu">
                    <a

                        @if(Request()->route()->getName() == 'publicationManagement')
                        class="active"
                        @endif
                        href="{{route('publicationManagement')}}">
                        <i class="fas fa-tachometer-alt"></i> <span>Projects</span>
                        {{--<span class="menu-arrow"></span>--}}
                    </a>
                </li>


                <li class="submenu">
                    <a

                        @if(Request()->route()->getName() == 'publicationArticleListing')
                        class="active"
                        @endif
                        href="javascript:void(0)">
                        <i class="fas fa-tachometer-alt"></i> <span>Projects Article</span>
                        <span class="menu-arrow"></span></a>

                        <ul class="list-unstyled">
                            <li><a href="{{route('publicationArticleListing')}}">Listing</a></li>
                            <li><a href="{{route('publicationArticleCreate')}}">Create Projects Article</a></li>
                        </ul>


                </li>

                <li class="submenu">
                    <a

                        @if(Request()->route()->getName() == 'publicationArticleNewsListing')
                        class="active"
                        @endif
                        href="javascript:void(0)">
                        <i class="fas fa-tachometer-alt"></i> <span>Projects News Article</span>
                        <span class="menu-arrow"></span></a>

                    <ul class="list-unstyled">
                        <li><a href="{{route('publicationArticleNewsListing')}}">Listing</a></li>
                        <li><a href="{{route('publicationArticleNewsCreate')}}">Create Projects News Article</a></li>
                    </ul>


                </li>


                <li class="submenu">
                    <a

                        @if(Request()->route()->getName() == 'awardManagement')
                        class="active"
                        @endif
                        href="{{route('awardManagement')}}">
                        <i class="fas fa-tachometer-alt"></i> <span>Awards</span>
                        {{--<span class="menu-arrow"></span>--}}
                    </a>
                </li>


                <li class="submenu">
                    <a

                        @if(Request()->route()->getName() == 'awardArticleListing' ||
                        Request()->route()->getName () == 'awardArticleCreate')
                        class="active"
                        @endif
                        href="javascript:void(0)">
                        <i class="fas fa-tachometer-alt"></i> <span>Award Article</span>
                        <span class="menu-arrow"></span></a>

                    <ul class="list-unstyled">
                        <li><a href="{{route('awardArticleListing')}}">Listing</a></li>
                        <li><a href="{{route('awardArticleCreate')}}">Create Award Article</a></li>
                    </ul>


                </li>

                <li class="submenu">
                    <a

                        @if(Request()->route()->getName() == 'awardArticleNewsListing' ||
                        Request()->route()->getName() == 'awardArticleNewsCreate'  )
                        class="active"
                        @endif
                        href="javascript:void(0)">
                        <i class="fas fa-tachometer-alt"></i> <span>Award News Article</span>
                        <span class="menu-arrow"></span></a>

                    <ul class="list-unstyled">
                        <li><a href="{{route('awardArticleNewsListing')}}">Listing</a></li>
                        <li><a href="{{route('awardArticleNewsCreate')}}">Create Award News Article</a></li>
                    </ul>


                </li>

                <li class="submenu">
                    <a

                        @if(Request()->route()->getName() == 'newsListing' ||
                        Request()->route()->getName() == 'newsCreate'  )
                        class="active"
                        @endif
                        href="javascript:void(0)">
                        <i class="fas fa-tachometer-alt"></i> <span>Blogs</span>
                        <span class="menu-arrow"></span></a>

                    <ul class="list-unstyled">
                        <li><a href="{{route('newsListing')}}">Listing</a></li>
                        <li><a href="{{route('newsCreate')}}">Create Blogs</a></li>
                    </ul>


                </li>


                <li class="submenu">
                    <a

                        @if(Request()->route()->getName() == 'projectListing' ||
                        Request()->route()->getName() == 'projectCreate'  )
                        class="active"
                        @endif
                        href="javascript:void(0)">
                        <i class="fas fa-tachometer-alt"></i> <span>Expertise</span>
                        <span class="menu-arrow"></span></a>

                    <ul class="list-unstyled">
                        <li><a href="{{route('projectListing')}}">Listing</a></li>
                        <li><a href="{{route('projectCreate')}}">Create Expertise</a></li>
                    </ul>


                </li>



            </ul>


            <div class="clearfix"></div>

        </div>

        <div class="clearfix"></div>

    </div>

</div>
<!-- End Sidebar -->
