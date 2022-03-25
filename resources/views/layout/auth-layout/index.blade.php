<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title')</title>

    @include('layout.auth-layout.css')

    <!-- BEGIN CSS for this page -->
    @yield('style')
    <!-- END CSS for this page -->

</head>

<body>

<div class="container h-100">
    <!-- Start content -->
        @yield('body')
    <!-- END content -->

    <!-- END content-page -->

</div>
<!-- END main -->

@include('layout.auth-layout.js')
<!-- END Java Script for this page -->
@yield('script')

</body>
</html>
