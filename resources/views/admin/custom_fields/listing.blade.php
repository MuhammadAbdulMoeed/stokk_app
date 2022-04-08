@extends('layout.dashboard-layout.app')

@section('title')
    Custom Fields  Listing
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
                        <h1 class="main-title float-left"> Custom Fields Listing</h1>

                        <div class="float-right">
                            <a href="{{route('customFieldsCreate')}}">
                                <button class="btn btn-primary">Create New Custom Fields</button>
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
                                        <th>Field Name</th>
                                        <th>Field Type</th>
                                        <th>Slug</th>
                                        <th>Required</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($data as $customFields)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$customFields->name}}</td>
                                            <td>{{ucwords(str_replace('_',' ',$customFields->field_type))}}</td>
                                            <td>{{$customFields->slug}}</td>

                                            <td>
                                                <button
                                                    class="btn-sm {{$customFields->is_required == 1 ? 'btn btn-outline-success':'btn btn-outline-danger'}}">
                                                    {{$customFields->is_required == 1 ? 'Yes':'No'}}
                                                </button>
                                            </td>

                                            <td>
                                                <button
                                                    class="btn-sm {{$customFields->is_active == 1 ? 'btn btn-outline-success':'btn btn-outline-danger'}}">
                                                    {{$customFields->is_active == 1 ? 'Active':'Inactive'}}
                                                </button>
                                            </td>

                                            <td>
                                                <a title="Edit" href="{{route('customFieldsEdit',['id'=>$customFields->id])}}"
                                                   class="btn btn-outline-primary btn-sm"><i
                                                        class="fas fa-pencil-alt"></i></a>

                                                <a title="Delete" data-id="{{$customFields->id}}"
                                                   href="javascript:void(0)"
                                                   class="btn btn-outline-danger btn-sm deleteRecord">
                                                    <i class="fas fa-trash-alt"></i></a>

                                                <a title="Change Status" href="javascript:void(0)"
                                                   data-id="{{$customFields->id}}"
                                                   class="btn btn-outline-primary btn-sm changeStatus"><i
                                                        class="fa fa-retweet"></i>
                                                </a>
                                            </td>

                                        </tr>
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

    @include('admin.custom_fields.modal.delete_modal')


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
                    url: '{{route("customFieldsDelete")}}',
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
                    url: '{{route("customFieldsChangeStatus")}}',
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
