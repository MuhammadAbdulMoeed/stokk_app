@extends('layout.dashboard-layout.app')

@section('title')
    Edit Custom Field
@endsection


@section('body')

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12 bh-mb">
                    <div class="breadcrumb-holder">
                        <h1 class="main-title float-left">Edit Custom Field</h1>
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item">Home</li>
                            <li class="breadcrumb-item active">Edit Custom Field</li>
                        </ol>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>

            <form method="post" id="updateCategory">
                @csrf
                <input type="hidden" name="id" value="{{$data->id}}">

                <div class="row">


                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="form-group">
                            <label>Type</label>
                            <select name="type" class="form-control type">
                                <option value="" selected disabled>Select</option>
                                <option
                                    value="pre_included_field" {{$data->type == 'pre_included_field' ? 'selected':''}}>
                                    Pre-Included
                                </option>
                                <option value="custom_field" {{$data->type == 'custom_field' ? 'selected':''}}>Custom
                                </option>
                            </select>
                        </div>
                    </div>


                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group">
                            <label>Field Name</label>
                            <input type="text" class="form-control" name="name"
                                   placeholder="Enter Field Name" value="{{$data->name}}">
                        </div>
                    </div>

                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group">
                            <label>Slug</label>
                            <input type="text" class="form-control" name="slug" value="{{$data->slug}}"
                                   placeholder="Enter Slug If you don't know leave it empty">
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group">
                            <label>Field Type</label>
                            <select class="form-control field_type"
                                    name="field_type">
                                {{--                                <option value="price_range" {{$data->field_type == "price_range" ? 'selected':''}}>Price--}}
                                {{--                                    Range--}}
                                {{--                                </option>--}}
                                <option value="input_field" {{$data->field_type == "input_field" ? 'selected':''}}>
                                    Input Field
                                </option>
                                <option value="number_field" {{$data->field_type == "number_field" ? 'selected':''}}>
                                    Number Field
                                </option>
                                <option
                                    value="simple_select_option" {{$data->field_type == "simple_select_option" ? 'selected':''}}>
                                    Simple Select Option
                                </option>
                                <option
                                    value="multi_select_option" {{$data->field_type == "multi_select_option" ? 'selected':''}}>
                                    Multi Select Option
                                </option>
                                {{--                                <option value="date_picker" {{$data->field_type == "date_picker" ? 'selected':''}}>Date--}}
                                {{--                                    Picker--}}
                                {{--                                </option>--}}
                                {{--                                <option value="time_picker" {{$data->field_type == "time_picker" ? 'selected':''}}>Time--}}
                                {{--                                    Picker--}}
                                {{--                                </option>--}}
                                {{--                                <option--}}
                                {{--                                    value="date_range_picker" {{$data->field_type == "date_range_picker" ? 'selected':''}}>--}}
                                {{--                                    Date Range Picker--}}
                                {{--                                </option>--}}
                                {{--                                <option--}}
                                {{--                                    value="time_range_picker" {{$data->field_type == "time_range_picker" ? 'selected':''}}>--}}
                                {{--                                    Time Range Picker--}}
                                {{--                                </option>--}}
                            </select>
                        </div>
                    </div>


                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group">
                            <label>Is Required</label>
                            <select class="form-control" name="is_required">
                                <option value="0" {{$data->is_required == "0" ? 'selected':''}}>No</option>
                                <option value="1" {{$data->is_required == "1" ? 'selected':''}}>Yes</option>
                            </select>
                        </div>
                    </div>


                </div>


                <div class="select_option_section row"

                     @if($data->type == 'custom_field' && (($data->field_type == 'simple_select_option') || ($data->field_type == 'multi_select_option')))
                     style=""
                     @else
                     style="display: none"
                    @endif
                >
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

                        <div class="add_more_area">
                            @if($data->type == 'custom_field' && isset($data->customFieldOption) && sizeof($data->customFieldOption) > 0)
                                @foreach($data->customFieldOption as $key => $option)
                                    <div class="row rcard">
                                        <div class="col-11 col-md-11">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Option</label>
                                                <input type="text" class="form-control" name="value[]"
                                                       placeholder="Enter Value" maxlength="100"
                                                       value="{{$option->name}}">
                                            </div>

                                        </div>
                                        @if($loop->first)
                                            <div class="col-1 col-md-1">
                                                <button type="button" class="add_more add_more_btn produts-am">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        @else
                                            <div class="col-1 col-md-1">
                                                <button type="button" class="add_more remove_options_btn produts-am">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        @endif

                                    </div>
                                @endforeach
                            @else
                                <div class="row rcard">
                                    <div class="col-11 col-md-11">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Option</label>
                                            <input type="text" class="form-control option" name="value[]"
                                                   placeholder="Enter Value" maxlength="100">
                                        </div>

                                    </div>
                                    <div class="col-1 col-md-1">
                                        <button type="button" class="add_more add_more_btn produts-am">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            @endif


                        </div>

                    </div>

                </div>

                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group">
                            <label>Parent</label>
                            <select class="form-control parentID" name="parent_id">
                                <option value="" selected disabled>Select</option>
                                @foreach($fields as $field)
                                    <option
                                        value="{{$field->id}}" {{$field->id == $data->parent_id ? 'selected':''}}>{{$field->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group">
                            <label>Parent Option ID</label>
                            <select class="form-control custom_field_option" name="option_id">
                                @foreach($selected as $fieldOption)
                                    <option
                                        value="{{$fieldOption->id}}" {{$fieldOption->id == $data->option_id ? 'selected':''}}>{{$fieldOption->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group">
                            <label>Filter</label>
                            <select class="form-control filter_flag" name="filter">
                                <option value="0" {{$data->filter == 0 ? 'selected':''}}>No</option>
                                <option value="1" {{$data->filter == 1 ? 'selected':''}}>Yes</option>

                            </select>
                        </div>
                    </div>


                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 filter_field_div"  style="display: {{$data->filter == 1 ? '':'none'}}">
                        <div class="form-group">
                            <label>Filter Field Type</label>
                            <select class="form-control filter_field_type" name="filter_field_type">
                                <option value="" selected disabled>Select</option>
                                <option
                                    value="range_slider" {{$data->filter_field_type == 'range_slider' ? 'selected':''}}>
                                    Range Slider
                                </option>
                                <option
                                    value="input_field" {{$data->filter_field_type == 'input_field' ? 'selected':''}}>
                                    Input Field
                                </option>
                                <option
                                    value="number_field" {{$data->filter_field_type == 'number_field' ? 'selected':''}}>
                                    Number Field
                                </option>
                                <option
                                    value="simple_select_option" {{$data->filter_field_type == 'simple_select_option' ? 'selected':''}}>
                                    Simple Select Option
                                </option>
                                <option
                                    value="multi_select_option" {{$data->filter_field_type == 'multi_select_option' ? 'selected':''}}>
                                    Multi Select Option
                                </option>
                                <option
                                    value="date_picker" {{$data->filter_field_type == 'date_picker' ? 'selected':''}}>
                                    Date Picker
                                </option>
                                <option
                                    value="time_picker" {{$data->filter_field_type == 'time_picker' ? 'selected':''}}>
                                    Time Picker
                                </option>
                                <option
                                    value="date_range_picker" {{$data->filter_field_type == 'date_range_picker' ? 'selected':''}}>
                                    Date Range Picker
                                </option>
                                <option
                                    value="time_range_picker" {{$data->filter_field_type == 'time_range_picker' ? 'selected':''}}>
                                    Time Range Picker
                                </option>
                            </select>
                        </div>
                    </div>

                </div>

                <div class="filter_value_section row" style="display: {{$data->filter_field_type == 'range_slider' ? '':'none'}}">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group">
                            <label>Min Value</label>
                            <input type="text" class="form-control" name="min"
                                   placeholder="Enter Min Value" value="{{$data->min}}">
                        </div>
                    </div>

                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group">
                            <label>Max</label>
                            <input type="text" class="form-control" name="max" value="{{$data->max}}"
                                   placeholder="Enter Max Value">
                        </div>
                    </div>
                </div>

                @if($data->type == 'pre_included_field')
                    @include('admin.custom_fields.section.pre_included_filter_section')
                @endif

                <button class="btn btn-primary" type="button" id="createBtn">Update</button>


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


                var data = new FormData($('#updateCategory')[0]);

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
                    url: '{{route("customFieldsUpdate")}}',
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


            $(document).on('change', '.field_type', function () {

                var data = $(this).val();

                var type = $('.type').val();


                if (data == 'price_range') {
                    $('.price_range_section').removeAttr('style');
                    $('.select_option_section').css('display', 'none');
                } else if (data == 'simple_select_option' || data == 'multi_select_option') {
                    $('.price_range_section').css('display', 'none');
                    $('.select_option_section').removeAttr('style');

                    if (type == 'custom_field') {
                        $('.select_option_section').removeAttr('style');
                    } else if (type == 'pre_included_field') {
                        $('.select_option_section').css('display', 'none');
                    }

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


            $(document).on('change', '.parentID', function () {
                var data = $(this).val();

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
                    url: '{{route("getFieldOption")}}',
                    data: {'field_id': data},

                    success: function (response, status) {

                        if (response.result == 'success') {
                            $.unblockUI();

                            var html = '<option value="" selected disabled>Select</option>';
                            $.each(response.data, function (index, value) {

                                html += '<option value="' + value.id + '">' + value.name + '</option>'

                            });

                            $('.custom_field_option').html(html);


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


            $('.type').change(function () {
                var data = $(this).val();

                var type = $('.field_type').val();


                if (data == 'pre_included_field') {
                    $('.parent_section_row').after(`@include('admin.custom_fields.section.pre_included_filter_section')`);
                    if (type) {
                        $('.select_option_section').css('display', 'none');
                    }

                } else {
                    $('.pre-included-filter-section').remove();
                    if (type == 'simple_select_option' || type == 'multi_select_option') {
                        $('.select_option_section').removeAttr('style');
                    }

                }
            });

            $('.filter_flag').change(function () {

                var data = $(this).val();

                if (data == 1) {
                    $('.filter_field_div').show();
                } else {
                    $('.filter_field_div').hide();
                    $('.filter_value_section').hide();
                }


            });

            $('.filter_field_type').change(function () {

                var data = $('.filter_field_type').val();
                if (data == 'range_slider') {
                    $('.filter_value_section').show();
                }
                else{
                    $('.filter_value_section').hide();
                }
            });


        });


    </script>

@endsection
