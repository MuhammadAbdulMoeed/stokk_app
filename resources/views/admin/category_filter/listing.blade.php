@extends('layout.dashboard-layout.app')

@section('title')
    Category Filters Listing
@endsection

@section('style')
    <style>

        .blockUI {
            z-index: 1060 !important;
        }

    </style>
@endsection

@section('body')

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12 bh-mb">
                    <div class="breadcrumb-holder">
                        <h1 class="main-title float-left">Category Filters Listing</h1>

                        <div class="float-right">
                            <a href="{{route('categoryFilterCreate')}}">
                                <button class="btn btn-primary">Create New Category Filters</button>
                            </a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

                    <div class="card mb-3">


                        <div class="card-body">

                            <div class="table-responsive">

                                <table class="table table-bordered" id="data_table">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Category Name</th>
                                        <th>Filter Name</th>
                                        {{--                                        <th>Status</th>--}}
                                        <th>Action</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($data as $category)
                                        @if(sizeof($category->categoryFilters) >0)
                                            @php $i = 0  @endphp
                                            <tr>
                                                <td>{{++$i}}</td>
                                                <td>{{$category->name}}</td>
                                                <td>
                                                    @foreach($category->categoryFiltersOrder as $category_filter)
                                                        @if($loop->last)
                                                            {{$category_filter->name}}
                                                        @else
                                                            {{$category_filter->name}},
                                                        @endif
                                                    @endforeach
                                                </td>
                                                {{--                                                <td>--}}
                                                {{--                                                    <button class="btn-sm {{$category->is_active == 1 ? 'btn btn-outline-success':'btn btn-outline-danger'}}">--}}
                                                {{--                                                        {{$category->is_active == 1 ? 'Active':'Inactive'}}--}}
                                                {{--                                                    </button>--}}
                                                {{--                                                </td>--}}
                                                <td>
                                                    <a title="Edit"
                                                       href="{{route('categoryFilterEdit',['id'=>$category->id])}}"
                                                       class="btn btn-outline-primary btn-sm"><i
                                                            class="fas fa-pencil-alt"></i></a>

                                                    <a title="Delete" data-id="{{$category->id}}"
                                                       href="javascript:void(0)"
                                                       class="btn btn-outline-danger btn-sm deleteRecord">
                                                        <i class="fas fa-trash-alt"></i></a>

                                                    <a title="Change Order"
                                                       href="{{route('categoryFilterChangePosition',['id'=>$category->id])}}"
                                                       data-id="{{$category->id}}"
                                                       class="btn btn-outline-primary btn-sm ">
                                                        <i class="fa fa-sort" aria-hidden="true"></i>
                                                    </a>

                                                </td>

                                            </tr>
                                        @endif
                                    @endforeach

                                    </tbody>

                                </table>


                            </div>

                        </div>


                    </div>


                </div>

            </div>
        </div>
    </div>

    @include('admin.category_filter.modal.delete_modal')


@endsection


@section('script')

    <script src="{{asset('admin/js/dataTable.js')}}"></script>

    <script>


        $(document).on('ready', function () {

            $('#data_table').DataTable();

            $(document).on('click', '.deleteRecord', function () {

                var data = $(this).data('id');

                var html = $('#deleteRecordId').val(data);

                $('#delete_form').append(html);

                $('#delete_modal').modal('show');

            });


            $('#deleteRecordBtn').click(function () {

                var data = $('#delete_form').serialize();

                $.blockUI({
                    css: {
                        border: 'none',
                        padding: '15px',
                        backgroundColor: '#000',
                        '-webkit-border-radius': '10px',
                        '-moz-border-radius': '10px',
                        opacity: .5,
                        color: '#fff'
                    }
                });
                $.ajax({

                    type: 'POST',
                    url: '{{route("categoryFilterDelete")}}',
                    data: data,

                    success: function (response, status) {

                        if (response.result == 'success') {
                            $.unblockUI();
                            successMsg(response.message);

                            setTimeout(function () {
                                window.location.reload();
                            }, 1000);

                        } else if (response.result == 'error') {
                            $.unblockUI();
                            errorMsg(response.message);
                        }
                    },
                    error: function (data) {
                        $.each(data.responseJSON.errors, function (key, value) {
                            $.unblockUI();
                            errorMsg(value);
                        });
                    }


                });
            });


            $('.changeStatus').click(function () {

                var data = $(this).data('id');

                $.blockUI({
                    css: {
                        border: 'none',
                        padding: '15px',
                        backgroundColor: '#000',
                        '-webkit-border-radius': '10px',
                        '-moz-border-radius': '10px',
                        opacity: .5,
                        color: '#fff'
                    }
                });
                $.ajax({

                    type: 'GET',
                    url: '{{route("filterChangeStatus")}}',
                    data: {'id': data},

                    success: function (response, status) {

                        if (response.result == 'success') {
                            $.unblockUI();
                            successMsg(response.message);

                            setTimeout(function () {
                                window.location.reload();
                            }, 1000);

                        } else if (response.result == 'error') {
                            $.unblockUI();
                            errorMsg(response.message);
                        }
                    },
                    error: function (data) {
                        $.each(data.responseJSON.errors, function (key, value) {
                            $.unblockUI();
                            errorMsg(value);
                        });
                    }


                });
            });


        });


    </script>

@endsection
