@extends('layout.dashboard-layout.app')

@section('title')
    Create Product
@endsection

@section('style')
    <style>
        .custom-dbhome .form-group {
            width: 25%
        }
    </style>
@endsection




@section('body')

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12 bh-mb">
                    <div class="breadcrumb-holder">
                        <h1 class="main-title float-left">Create Product</h1>
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item">Home</li>
                            <li class="breadcrumb-item active">Create Product</li>
                        </ol>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>

            <form method="post" id="categoryForm">
                @csrf
                <div class="row mainRow">

                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter Name">
                        </div>

                    </div>

                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Category</label>
                            <select class="form-control category" name="category_id">
                                <option value="" selected disabled>Select</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">SubCategory</label>
                            <select class="form-control subCategory" name="sub_category_id">
                                <option value="" selected disabled>Select</option>

                            </select>
                        </div>

                    </div>


                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Currency</label>
                            <input type="text" name="currency" class="form-control" placeholder="Enter Currency">

                        </div>

                    </div>

                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Location</label>
                            <input type="text" name="location" class="form-control" placeholder="Enter Location">
                        </div>

                    </div>

                </div>

                <h5>Product Gallery</h5>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="custom-dbhome">
                            <div class="form-group ">
                                <div class="db-bannerIMG">
                                    <img class="image_1" src="{{asset('admin/images/no_image.jpg')}}">
                                </div>
                                <label for="exampleInputEmail1">Image </label>
                                <input type="file" class="images_select" name="image[]"
                                       accept="image/png,image/jpg,image/jpeg"
                                       onchange="readURL(this,'image_1');">
                            </div>

                            <div class="form-group ">
                                <div class="db-bannerIMG">
                                    <img class="image_2" src="{{asset('admin/images/no_image.jpg')}}">
                                </div>
                                <label for="exampleInputEmail1">Image </label>
                                <input type="file" class="images_select" name="image[]"
                                       accept="image/png,image/jpg,image/jpeg"
                                       onchange="readURL(this,'image_2');">
                            </div>

                            <div class="form-group ">
                                <div class="db-bannerIMG">
                                    <img class="image_3" src="{{asset('admin/images/no_image.jpg')}}">
                                </div>
                                <label for="exampleInputEmail1">Image </label>
                                <input type="file" class="images_select" name="image[]"
                                       accept="image/png,image/jpg,image/jpeg"
                                       onchange="readURL(this,'image_3');">
                            </div>

                            <div class="form-group ">
                                <div class="db-bannerIMG">
                                    <img class="image_4" src="{{asset('admin/images/no_image.jpg')}}">
                                </div>
                                <label for="exampleInputEmail1">Image </label>
                                <input type="file" class="images_select" name="image[]"
                                       accept="image/png,image/jpg,image/jpeg"
                                       onchange="readURL(this,'image_4');">
                            </div>

                            <div class="form-group ">
                                <div class="db-bannerIMG">
                                    <img class="image_5" src="{{asset('admin/images/no_image.jpg')}}">
                                </div>
                                <label for="exampleInputEmail1">Image </label>
                                <input type="file" class="images_select" name="image[]"
                                       accept="image/png,image/jpg,image/jpeg"
                                       onchange="readURL(this,'image_5');">
                            </div>

                            <div class="form-group ">
                                <div class="db-bannerIMG">
                                    <img class="image_6" src="{{asset('admin/images/no_image.jpg')}}">
                                </div>
                                <label for="exampleInputEmail1">Image </label>
                                <input type="file" class="images_select" name="image[]"
                                       accept="image/png,image/jpg,image/jpeg"
                                       onchange="readURL(this,'image_6');">
                            </div>

                        </div>
                    </div>
                </div>


                <button class="btn btn-primary" type="button" id="createBtn">Create</button>


                <a href="{{route('productListing')}}">
                    <button class="btn btn-danger" type="button">Cancel</button>
                </a>
            </form>
        </div>

    </div>

@endsection


@section('script')


    <script>

        $(document).ready(function () {
            // $('.multiSelectOption').select2();

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
                    url: '{{route("productSave")}}',
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (response, status) {

                        if (response.result == 'success') {
                            $.unblockUI();
                            successMsg(response.message);

                            setTimeout(function () {
                                    window.location.href = '{{route('productListing')}}'
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

            $('.category').change(function () {
                var data = $(this).val();

                $('.custom_field_section').remove();
                $('.subCategory').val();

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
                    url: '{{route("getSubCategory")}}',
                    data: {'category_id': data},

                    success: function (response, status) {

                        if (response.result == 'success') {
                            $.unblockUI();

                            var html = '<option value="" selected disabled>Select</option>';
                            $.each(response.data, function (index, value) {

                                html += '<option value="' + value.id + '">' + value.name + '</option>'

                            });

                            $('.subCategory').html(html);


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

            $(document).on('change', '.productType', function () {

                var data = $(this).val();

                if (data == 'for_rent') {
                    $('.rentPrice').removeAttr('style');
                    $('.forSale').css('display', 'none');
                } else {
                    $('.rentPrice').css('display', 'none');
                    $('.forSale').removeAttr('style');
                }
            });

            $('.subCategory').change(function () {
                var data = $(this).val();

                var text = $('.category option:selected').text();

                var category = $('.category').val();

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
                    url: '{{route("getCategoryField")}}',
                    data: {'sub_category_id': data, 'category_id': category},

                    success: function (response, status) {

                        if (response.result == 'success') {
                            $.unblockUI();
                            var insideHtml = '';
                            var html ='<div class="custom_field_section row">';

                            $.each(response.data, function (index, value) {
                                if(value.field['type']  == 'number_field')
                                {
                                    html += '<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">';
                                    html += '<div class="form-group">';
                                    html += '<label for="exampleInputEmail1">'+value.field['name']+'</label>';
                                    html += '<input type="text" class="form-control" onkeypress="return isNumberKey(event)" name="custom_fields['+value.field['id']+']">';
                                    html += '</div>';
                                    html += '</div>';
                                }
                                else if(value.field['type']  == 'input_field')
                                {
                                    html += '<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">';
                                    html += '<div class="form-group">';
                                    html += '<label for="exampleInputEmail1">'+value.field['name']+'</label>';
                                    html += '<input type="text" class="form-control" onkeypress="return isCharacterKey(event)" name="custom_fields['+value.field['id']+']">';
                                    html += '</div>';
                                    html += '</div>';
                                }
                                else if(value.field['type']  == 'simple_select_option')
                                {
                                    html += '<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">';
                                    html += '<div class="form-group">';
                                    html += '<label for="exampleInputEmail1">'+value.field['name']+'</label>';
                                    html += '<select name="custom_fields['+value.field['id']+']" class="form-control show_related_fields">';
                                    html += '<option value="" selected disabled>Select</option>';
                                    $.each(value.field_record,function(index1,value1){
                                        if(value1.related_fields.length == 0)
                                        {
                                            html += '<option value="'+value1.id+'">'+value1.name+'</option>';
                                        }
                                        else{
                                            html += '<option value="'+value1.id+'">'+value1.name+'</option>';
                                            insideHtml += '<div class="'+value1.id+'-'+value1.name.replace(/\s/g, "")+' row '+value.field['name']+'" style="display:none;">';
                                        }

                                        $.each(value1.related_fields,function(index2,value2){
                                            if(value2['field_type']  == 'number_field')
                                            {
                                                insideHtml += '<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">';
                                                insideHtml += '<div class="form-group">';
                                                insideHtml += '<label for="exampleInputEmail1">'+value2['name']+'</label>';
                                                insideHtml += '<input type="text" class="form-control" onkeypress="return isNumberKey(event)" name="custom_fields['+value2['id']+']">';
                                                insideHtml += '</div>';
                                                insideHtml += '</div>';

                                            }
                                            else if(value2['field_type']  == 'input_field')
                                            {
                                                insideHtml += '<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">';
                                                insideHtml += '<div class="form-group">';
                                                insideHtml += '<label for="exampleInputEmail1">'+value2['name']+'</label>';
                                                insideHtml += '<input type="text" class="form-control" onkeypress="return isCharacterKey(event)" name="custom_fields['+value2['id']+']">';
                                                insideHtml += '</div>';
                                                insideHtml += '</div>';

                                            }
                                            else if(value2['field_type']  == 'simple_select_option')
                                            {
                                                insideHtml += '<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">';
                                                insideHtml += '<div class="form-group">';
                                                insideHtml += '<label for="exampleInputEmail1">' + value2['name'] + '</label>';
                                                insideHtml += '<select name="custom_fields[' + value2['id'] + ']" class="form-control">';
                                                $.each(value.field_record, function (index3, value3) {
                                                    insideHtml += '<option value="' + value3.id + '">' + value3.name + '</option>';
                                                });
                                                insideHtml += '</select>';
                                                insideHtml += '</div>';
                                                insideHtml += '</div>';
                                            }
                                            else if(value2['field_type']  == 'multi_select_option')
                                            {
                                                insideHtml += '<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">';
                                                insideHtml += '<div class="form-group">';
                                                insideHtml += '<label for="exampleInputEmail1">'+value2['name']+'</label>';
                                                insideHtml += '<select multiple name="custom_fields['+value2['slug']+']" class="form-control multiSelectOption">';
                                                $.each(value.field_record,function(index4,value4){
                                                    insideHtml += '<option value="'+value4.id+'">'+value4.name+'</option>';
                                                });
                                                insideHtml += '</select>';
                                                insideHtml += '</div>';
                                                insideHtml += '</div>';
                                            }

                                        });
                                        insideHtml += '</div>';

                                    });
                                    html += '</select>';
                                    html += '</div>';
                                    html += '</div>';

                                }
                                else if(value.field['type']  == 'multi_select_option')
                                {
                                    html += '<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">';
                                    html += '<div class="form-group">';
                                    html += '<label for="exampleInputEmail1">'+value.field['name']+'</label>';
                                    html += '<select multiple name="custom_fields['+value.field['id']+'][]" class="form-control multiSelectOption">';
                                    $.each(value.field_record,function(index1,value1){
                                        html += '<option value="'+value1.id+'">'+value1.name+'</option>';

                                    });
                                    html += '</select>';

                                    html += '</div>';
                                    html += '</div>';
                                }
                            });

                            $('.mainRow').after(html);
                            $('.multiSelectOption').select2();

                            $('.custom_field_section').after(insideHtml);





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

            $(document).on('change','.show_related_fields',function(){
                var data  = $(this).val();
                var text = $(this).find('option:selected').text().replaceAll(/\s/g,'');
                // $( ".show_related_fields option:selected" ).text().replaceAll(/\s/g,'');
                var className = $( ".show_related_fields option:selected" ).attr('class');

                var parentText = $(this).parent('div.form-group').find('label').text();

                $('.'+parentText).hide();

                $('.'+data+'-'+text).removeAttr('style');

            });


        });

        var fileTypes = ['jpg', 'jpeg', 'png'];

        function readURL(input, className) {


            if (input.files && input.files[0]) {
                var reader = new FileReader();

                var size = input.files[0].size;

                var extension = input.files[0].name.split('.').pop().toLowerCase(),  //file extension from input file
                    isSuccess = fileTypes.indexOf(extension) > -1;
                if (extension != 'jfif') {
                    // if (isSuccess && size <= 1000000) {
                    reader.onload = function (e) {
                        $('.' + className).attr('src', e.target.result);
                    };

                    reader.readAsDataURL(input.files[0]);
                    // $('#image_upload_preview').show();

                    // } else {
                    //     errorMsg('You can only upload png,jpg or jpeg files and size of flag should not greater than 1MB');
                    //     // $("#image").val('');
                    //     $('.' + className).parents('div.form-group').find('input').val('');
                    //     // $('#image_upload_preview').hide();
                    //     $('.' + className).removeAttr('src');
                    //     return false;
                    // }
                } else {
                    errorMsg('You can only upload png,jpg or jpeg files');
                    // $("#image").val('');
                    // $('#image_upload_preview').hide();
                    // $('#image_upload_preview').removeAttr('src');

                    // $("#image").val('');
                    $('.' + className).parents('div.form-group').find('input').val('');
                    // $('#image_upload_preview').hide();
                    $('.' + className).removeAttr('src');
                    return false;
                }
            }
        }

    </script>

@endsection
