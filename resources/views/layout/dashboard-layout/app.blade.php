<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex"/>
    <title>@yield('title')</title>

@include('layout.dashboard-layout.css')

<!-- BEGIN CSS for this page -->
@yield('style')
<!-- END CSS for this page -->
    <!-- Favicons -->
    {{--  <link href="{{asset('front-side/images/Asset 2@4x-8.png')}}" rel="icon">--}}
    {{--    <link href="{{asset('front-side/images/apple-touch-icon.png')}}" rel="apple-touch-icon">--}}


</head>

<body class="adminbody">

<div id="main">


@include('admin.header.top-navigation')
@include('admin.header.sidebar')


<!-- End Navigation -->


    <!-- Left Sidebar -->
@include('admin.header.sidebar')

<!-- End Sidebar -->


    <div class="content-page">

        <!-- Start content -->
    @yield('body')
    <!-- END content -->

    </div>
    <!-- END content-page -->


    @include('admin.footer.footer')

</div>
<!-- END main -->
{{--@include('layout.script.activity_watcher')--}}
@include('layout.dashboard-layout.js')
<!-- END Java Script for this page -->
@yield('script')
</body>
</html>
