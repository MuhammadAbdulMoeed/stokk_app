@extends('layout.dashboard-layout.app')

@section('title')
    Custom Field
@endsection


@section('body')

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12 bh-mb">
                    <div class="breadcrumb-holder">
                        <h1 class="main-title float-left">Create Custom Field</h1>
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item">Home</li>
                            <li class="breadcrumb-item active">Create Custom Field</li>
                        </ol>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>

            <form method="post" id="categoryForm">
                @csrf
                <div class="row">

                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group">
                            <label>Field Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Enter Field Name">
                        </div>
                    </div>

                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group">
                            <label>Slug</label>
                            <input type="text" class="form-control" name="slug" placeholder="Enter Slug If you don't know leave it empty">
                        </div>
                    </div>

                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group">
                            <label>Field Type</label>
                            <select class="form-control field_type"
                                    name="field_type">
                                <option value="" selected disabled>Select</option>
                                <option value="price_range">Price Range</option>
                                <option value="input_field">Input Field</option>
                                <option value="number_field">Number Field</option>
                                <option value="simple_select_option">Simple Select Option</option>
                                <option value="multi_select_option">Multi Select Option</option>
                                <option value="date_picker">Date Picker</option>
                                <option value="time_picker">Time Picker</option>
                                <option value="date_range_picker">Date Range Picker</option>
                                <option value="time_range_picker">Time Range Picker</option>
                            </select>
                        </div>
                    </div>



                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group">
                            <label>Is Required</label>
                            <select class="form-control" name="is_required">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                        </div>
                    </div>


                </div>

{{--                <div class="pre-included-filter-section" style="display: none">--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">--}}
{{--                            <h5>Pre-Included Filters</h5>--}}
{{--                        </div>--}}

{{--                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">--}}
{{--                            <label class="sc-featur">Sub Category--}}
{{--                                <input type="radio" class="sale-checkbox" value="sub_category"--}}
{{--                                       name="filter">--}}
{{--                                <span class="checkmark"></span>--}}
{{--                            </label>--}}
{{--                        </div>--}}

{{--                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">--}}
{{--                            <label class="sc-featur">Brand--}}
{{--                                <input type="radio" class="sale-checkbox" value="brand"--}}
{{--                                       name="filter">--}}
{{--                                <span class="checkmark"></span>--}}
{{--                            </label>--}}
{{--                        </div>--}}

{{--                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">--}}
{{--                            <label class="sc-featur">Class--}}
{{--                                <input type="radio" class="sale-checkbox" value="class"--}}
{{--                                       name="filter">--}}
{{--                                <span class="checkmark"></span>--}}
{{--                            </label>--}}
{{--                        </div>--}}

{{--                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">--}}
{{--                            <label class="sc-featur">Rating--}}
{{--                                <input type="radio" class="sale-checkbox" value="rating"--}}
{{--                                       name="filter">--}}
{{--                                <span class="checkmark"></span>--}}
{{--                            </label>--}}
{{--                        </div>--}}


{{--                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">--}}
{{--                            <div class="form-group">--}}
{{--                                <label>Filter Name</label>--}}
{{--                                <input type="text" name="filter_name" class="form-control">--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                    </div>--}}

{{--                </div>--}}

                <div class="select_option_section row" style="display: none">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

                        <div class="add_more_area">
                            <div class="row rcard">
                                <div class="col-11 col-md-11">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Option</label>
                                        <input type="text" class="form-control" name="value[]"
                                               placeholder="Enter Value" maxlength="100">
                                    </div>

                                </div>

                                <div class="col-1 col-md-1">
                                    <button type="button" class="add_more add_more_btn produts-am">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>

                            </div>


                        </div>

                    </div>

                </div>



                <button class="btn btn-primary" type="button" id="createBtn">Create</button>


                <a href="{{route('customFieldsListing')}}">
                    <button class="btn btn-danger" type="button">Cancel</button>
                </a>
            </form>
        </div>

    </div>

@endsection


@section('script')


    <script>

        $(document).ready(function () {

            $('#createBtn').click(function () {


                var data = new FormData($('#categoryForm')[0]);

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
                    url: '{{route("customFieldsSave")}}',
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (response, status) {

                        if (response.result == 'success') {
                            $.unblockUI();
                            successMsg(response.message);

                            setTimeout(function () {
                                    window.location.href = '{{route('customFieldsListing')}}'
                                }
                                , 2000);
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


            $(document).on('change', '.filter_type', function () {

                var data = $(this).val();


                if (data == 'pre_included_filter') {
                    $('.pre-included-filter-section').css('display', 'block');

                    $('.custom_filter_section').css('display', 'none');
                    $('.select_option_section').css('display','none');
                    $('.price_range_section').css('display', 'none');
                    $('.select_option_section').css('display', 'none');

                    // $("input[name=filter_name]").val();
                    // $("input[name=filter]").val();
                    // $("input[name=field_type]").val();
                    // $("input[name=min]").val();
                    // $("input[name=max]").val();
                    // $("input[name=value]").val();


                    var val = $('.filter_type').val();
                    $('#categoryForm')[0].reset();
                    $('.filter_type').val(val);

                } else if (data == 'custom_filter') {
                    $('.custom_filter_section').css('display', 'block');

                    $('.pre-included-filter-section').css('display', 'none');
                    $('.select_option_section').css('display','none');
                    $('.price_range_section').css('display', 'none');
                    $('.select_option_section').css('display', 'none');


                    // $("input[name=filter_name]").val();
                    // $("input[name=filter]").val();
                    // $("input[name=field_type]").val();
                    // $("input[name=min]").val();
                    // $("input[name=max]").val();
                    // $("input[name=value]").val();

                    var val = $('.filter_type').val();
                    $('#categoryForm')[0].reset();
                    $('.filter_type').val(val);

                }
            });

            $(document).on('change', '.field_type', function () {

                var data = $(this).val();


                if (data == 'price_range') {
                    $('.price_range_section').removeAttr('style');
                    $('.select_option_section').css('display', 'none');
                } else if (data == 'simple_select_option' || data == 'multi_select_option') {
                    $('.price_range_section').css('display', 'none');
                    $('.select_option_section').removeAttr('style');
                } else {
                    $('.price_range_section').css('display', 'none');
                    $('.select_option_section').css('display', 'none');
                }
            });


            // $(document).on('click', '.add_more_option', function () {
            //     var html = '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 parent_remove">';
            //     html += '<div class="form-group">';
            //     html += '<label for="exampleInputEmail">Option</label>';
            //     html += '<input type="text" name="option_value[]" class="form-control" placeholder="Enter Option">';
            //     html += '<button type="button" class="delete_select_option btn-sm btn-outline-primary"><i class="fa fa-trash"></i></button>';
            //     html += '</div>';
            //
            //     $(this).parents('.select_option_section').append(html);
            // });


            $(document).on('click', '.delete_select_option', function () {
                $(this).parent('.parent_remove').remove();
            });


            $('.add_more_btn').click(function () {
                var html = '<div class="row rcard">';
                html += '<div class="col-11 col-md-11">';
                html += '<div class="form-group">';
                html += '<label for="exampleInputEmail1">Option</label>';
                html += '<input type="text" class="form-control" name="value[]" placeholder="Enter Value" maxlength="100">';
                html += '</div>';
                html += '</div>';
                html += '<div class="col-1 col-md-1">'
                html += '<button type="button" class="add_more remove_options_btn produts-am"><i class="fas fa-times"></i></button>';
                html += '</div></div>';
                // number++;
                $('div.add_more_area').append(html);

            });

            $(document).on('click', '.remove_options_btn', function () {
                $(this).parents('div.rcard').remove();
                // number = number-1;
            });


        });


    </script>

@endsection
