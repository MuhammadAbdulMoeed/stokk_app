@extends('layout.dashboard-layout.app')

@section('title')
    {{env('APP_NAME')}} - Admin Dashboard
@endsection


@section('body')

    <div class="content">

        <div class="container-fluid">

            <div class="row">
                <div class="col-xl-12 bh-mb">
                    <div class="breadcrumb-holder">
                        <h1 class="main-title float-left">Dashboard</h1>
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item">Home</li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row">
                <div class="col-xs-12 col-md-6 col-lg-6 col-xl-4">
                    <a href="#">
                        <div class="card-box noradius noborder bg-default">
                            <i class="fas fa-users float-right text-white"></i>
                            <h6 class="text-white text-uppercase m-b-20">Category</h6>
                            <h1 class="m-b-20 text-white counter">0</h1>
                            <span class="text-white"></span>
                        </div>
                    </a>
                </div>

                <div class="col-xs-12 col-md-6 col-lg-6 col-xl-4">
                    <a href="#">

                        <div class="card-box noradius noborder bg-default">
                            <i class="fas fa-users float-right text-white"></i>
                            <h6 class="text-white text-uppercase m-b-20"> Products</h6>
                            <h1 class="m-b-20 text-white counter">0</h1>
                            <span class="text-white"></span>
                        </div>
                    </a>
                </div>

                <div class="col-xs-12 col-md-6 col-lg-6 col-xl-4">
                    <a href="#">

                        <div class="card-box noradius noborder bg-default">
                            <i class="fas fa-users float-right text-white"></i>
                            <h6 class="text-white text-uppercase m-b-20">Brand</h6>
                            <h1 class="m-b-20 text-white counter">0</h1>
                            <span class="text-white"></span>
                        </div>
                    </a>
                </div>



            </div>
            <!-- end row -->
        </div>
        <!-- END container-fluid -->

    </div>

@endsection
