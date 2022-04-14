@extends('layout.dashboard-layout.app')

@section('title')
    Category Field Order
@endsection

@section('style')

    {{--    <link rel="stylesheet" href="https://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css"/>--}}

    <meta name="_token" content="{{ csrf_token() }}"/>

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
                        <h1 class="main-title float-left"> "{{$data[0]->category->name}}" Field Order</h1>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

                    <div class="card mb-3">


                        <div class="card-body">

                            <ul id="sortable" class="ui-sortable list-group">

                                @foreach($data as $field)
                                    <li id="{{$field->id}}" class="list-group-item text-left ui-sortable-handle">
                                        {{$field->field->name}}
                                    </li>
                                @endforeach

                            </ul>

                        </div>


                    </div>


                </div>

            </div>
        </div>
    </div>



@endsection


@section('script')


    {{--    <script type="text/javascript" src="https://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>--}}


    <script>


        $(document).on('ready', function () {
            var start_position = '';
            var changed = '';
            $('#sortable').sortable({
                update: function (event, ui) {
                    var productOrder = $(this).sortable('toArray');


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

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({

                        type: 'POST',
                        url: '{{route("categoryCustomFieldsUpdatePosition")}}',
                        data: {data: productOrder, _token: '{{csrf_token()}}'},

                        success: function (response, status) {

                            if (response.result == 'success') {
                                $.unblockUI();
                                successMsg(response.message);

                                {{--setTimeout(function () {--}}
                                {{--    --}}{{--window.location.href = '{{route('teamListing')}}';--}}
                                {{--}, 1000);--}}

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

                }
            });


        });


    </script>

@endsection
