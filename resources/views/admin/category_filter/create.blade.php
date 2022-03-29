@extends('layout.dashboard-layout.app')

@section('title')
    Create Filter
@endsection


@section('body')

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12 bh-mb">
                    <div class="breadcrumb-holder">
                        <h1 class="main-title float-left">Create Filter</h1>
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item">Home</li>
                            <li class="breadcrumb-item active">Create Filter</li>
                        </ol>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>

            <form method="post" id="categoryForm">
                @csrf
                <div class="row">


                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Category</label>
                            <select name="category_id" class="form-control">
                                <option value="" selected disabled>Select</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <h5>Pre-Included Filters</h5>
                    </div>

                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                        <label class="sc-featur">Sub Category
                            <input type="checkbox" class="sale-checkbox" value="sub_category"
                                   name="includes[]">
                            <span class="checkmark"></span>
                        </label>
                    </div>

                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                        <label class="sc-featur">Brand
                            <input type="checkbox" class="sale-checkbox" value="brand"
                                   name="includes[]">
                            <span class="checkmark"></span>
                        </label>
                    </div>

                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                        <label class="sc-featur">Class
                            <input type="checkbox" class="sale-checkbox" value="class"
                                   name="includes[]">
                            <span class="checkmark"></span>
                        </label>
                    </div>

                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                        <label class="sc-featur">Rating
                            <input type="checkbox" class="sale-checkbox" value="rating"
                                   name="includes[]">
                            <span class="checkmark"></span>
                        </label>
                    </div>


                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

                        <div class="variationRecord">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h5 class="main-title">Custom Filter</h5>
                                </div>
                                <div class="col-sm-6 text-right">
                                    <button type="button" class="add_more btn btn-outline-primary">Add More</button>
                                </div>
                            </div>


                            <!-- new section -->

                            <div class="row variationSection">
                                <div class="col-4">

                                    <div class="product-card">


                                        <div class="db-product-detail">

                                            <div class="inside-dbp">
                                                <label for="exampleInputEmail">Name</label>
                                                <input type="text" name="value[filter_1][name]"
                                                       class="form-control" placeholder="Enter Filter Name"
                                                       maxlength="50">
                                            </div>

                                            <div class="inside-dbp">
                                                <label for="exampleInputEmail">Type</label>
                                                <select class="form-control filterType"
                                                        name="value[filter_1][filterType]">
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

                                            <div class="price_range_section" style="display: none">
                                                <div class="inside-dbp">
                                                    <label for="exampleInputEmail">Min Value</label>
                                                    <input type="text" name="value[filter_1][min]"
                                                           class="form-control" placeholder="Enter Min Value"
                                                           onkeypress="return isNumberKey(event)">
                                                </div>

                                                <div class="inside-dbp">
                                                    <label for="exampleInputEmail">Max Value</label>
                                                    <input type="text" name="value[filter_1][max]"
                                                           class="form-control" placeholder="Enter Max Value"
                                                           onkeypress="return isNumberKey(event)">
                                                </div>
                                            </div>

                                            <div class="select_option_section" style="display: none">

                                                <div class="inside-dbp">
                                                    <label for="exampleInputEmail">Option</label>
                                                    <input type="text" name="value[filter_1][options][]"
                                                           class="form-control" placeholder="Enter Option">

                                                    <button data-section="1" type="button"
                                                            class="add_more_option btn-sm btn-outline-primary"><i
                                                            class="fa fa-plus"></i></button>

                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- new section -->
                        </div>

                    </div>

                </div>


                <button class="btn btn-primary" type="button" id="createBtn">Create</button>


                <a href="{{route('filterListing')}}">
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
                    url: '{{route("filterSave")}}',
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (response, status) {

                        if (response.result == 'success') {
                            $.unblockUI();
                            successMsg(response.message);

                            setTimeout(function () {
                                    window.location.href = '{{route('filterListing')}}'
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


            $(document).on('change', '.filterType', function () {

                var data = $(this).val();


                if (data == 'price_range') {

                    $(this).parents('.db-product-detail').find('.price_range_section').css('display', 'block');
                    $(this).parents('.db-product-detail').find('.select_option_section').css('display', 'none');
                } else if (data == 'simple_select_option' || data == 'multi_select_option') {
                    $(this).parents('.db-product-detail').find('.price_range_section').css('display', 'none');
                    $(this).parents('.db-product-detail').find('.select_option_section').css('display', 'block');
                } else {
                    $(this).parents('.db-product-detail').find('.select_option_section').css('display', 'none');
                    $(this).parents('.db-product-detail').find('.price_range_section').css('display', 'none');

                }
            });


            $(document).on('click', '.add_more_option', function () {
                var section = $(this).data('section');
                var html = '<div class="inside-dbp">';
                html += '<label for="exampleInputEmail">Option</label>';
                html += '<input type="text" name="value[filter_' + section + '][options][]" class="form-control" placeholder="Enter Option">';
                html += '<button type="button" class="delete_select_option btn-sm btn-outline-primary"><i class="fa fa-trash"></i></button>';
                html += '</div>';

                $(this).parents('.select_option_section').append(html);
            });

            $(document).on('click', '.delete_select_option', function () {
                $(this).parent('.inside-dbp').remove();
            });

            var divIndex = 1;


            $('.add_more ').click(function(){
                divIndex = divIndex +1;

                var html = '<div class="col-4 variationsDivScript">';
                html += '<div class="product-card">';
                html += '<div class="delet_product remove w-100 text-right">';
                html += '<i class="far fa-trash-alt">';
                html += '</i>';
                html += '</div>';
                html += '<div class="db-product-detail">';
                html += '<div class="inside-dbp">';
                html += '<label for="exampleInputEmail">Name</label>';
                html += '<input type="text" name="value[filter_'+divIndex+'][name]" class="form-control" placeholder="Enter Filter Name" maxlength="50">';
                html += '</div>';
                html += '<div class="inside-dbp">';
                html += '<label for="exampleInputEmail">Type</label>';
                html += '<select class="form-control filterType" name="value[filter_'+divIndex+'][filterType]">';
                html += '<option value="" selected="" disabled="">Select</option>';
                html += '<option value="price_range">Price Range</option>';
                html += '<option value="input_field">Input Field</option>';
                html += '<option value="number_field">Number Field</option>';
                html += '<option value="simple_select_option">Simple Select Option</option>';
                html += '<option value="multi_select_option">Multi Select Option</option>';
                html += '<option value="date_picker">Date Picker</option>';
                html += '<option value="time_picker">Time Picker</option>';
                html += '<option value="date_range_picker">Date Range Picker</option>';
                html += '<option value="time_range_picker">Time Range Picker</option>';
                html += '</select>';
                html += '</div>';
                html += '<div class="price_range_section" style="display: none">';
                html += '<div class="inside-dbp">';
                html += '<label for="exampleInputEmail">Min Value</label>';
                html += '<input type="text" name="value[filter_'+divIndex+'][min]" class="form-control" placeholder="Enter Min Value" onkeypress="return isNumberKey(event)">';
                html += '</div>';
                html += '<div class="inside-dbp">';
                html += '<label for="exampleInputEmail">Max Value</label>';
                html += '<input type="text" name="value[filter_'+divIndex+'][max]" class="form-control" placeholder="Enter Max Value" onkeypress="return isNumberKey(event)">';
                html += '</div>';
                html += '</div>';
                html += '<div class="select_option_section" style="display: none;">';
                html += '<div class="inside-dbp">';
                html += '<label for="exampleInputEmail">Option</label>';
                html += '<input type="text" name="value[filter_'+divIndex+'][options][]" class="form-control" placeholder="Enter Option">';

                html += '<button data-section="'+divIndex+'" type="button" class="add_more_option btn-sm btn-outline-primary"><i class="fa fa-plus"></i></button>';

                html += '</div></div>';

                html += '</div>';
                html += '</div></div>';

                $('.variationSection').append(html);
            });


            $(document).on('click','.delet_product',function(){
                $(this).parents('.variationsDivScript').remove()
            });
        });


    </script>

@endsection
