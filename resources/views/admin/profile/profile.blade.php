@extends('layout.dashboard-layout.app')

@section('title')
    Profile
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
                        <h1 class="main-title float-left">Profile</h1>
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item">Home</li>
                            <li class="breadcrumb-item active">Profile</li>
                        </ol>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>

            <div class="row">

                {{--                <div class="col-12">--}}
                {{--                    <div class="card-header">--}}
                {{--                        <h3> Admin Profile </h3>--}}
                {{--                    </div>--}}
                {{--                </div>--}}

                <div class="dis_flx_991">
                    <form action="#" method="post" enctype="multipart/form-data" id="adminProfile">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 col-xl-9">
                                <div class="card mb-3 card_nobrd">

                                    <div class="card-body cb_wdwidth">


                                        @csrf

                                        <div class="row">

                                            <div class="col-lg-12 col-xl-12">


                                                <div class="row">

                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label>Email</label>
                                                            <input class="form-control" name="email" type="email"
                                                                   readonly
                                                                   required="" value="{{Auth::user()->email}}"
                                                                   maxlength="50">
                                                        </div>
                                                    </div>


                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label>UserName</label>
                                                            <input class="form-control" name="username" type="text"
                                                                   maxlength="50"
                                                                   required="" value="{{Auth::user()->username}}">
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label>Password (leave empty not to change)</label>
                                                            <input class="form-control" name="password" type="password"
                                                                   maxlength="50">
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12 text-center mt-4">
                                                <button type="button" id="saveProfileBtn"
                                                        class="btn btn-primary btn-chng1">
                                                    Save Profile
                                                </button>
                                            </div>
                                        </div>

                                    </div>


                                </div>


                            </div>

                            <!-- end card-body -->
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-3">
                                <div class="profile_img">
                                    <div class="col-12">
                                        <div class="img-btn-div">
                                            <div class="img-div">
                            <span class="edit-circle">
                                <img id="image_upload_preview"
                                     src="{{Auth::user()->profile_image == null ?
                                            asset('admin/images/no_image.jpg'):
                                            asset(Auth::user()->profile_image) }}"

                                     class="img-fluid" alt="no img">
                            </span>
                                            </div>
                                            <div class="btn-div">
                                                <label class="edit-ubtn">
                                                    <input type="file" name="profile_image"
                                                           accept=".jpg,.png,.jpeg"
                                                           onchange="readURL(this);">
                                                    <span>Choose a File</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>

@endsection


@section('script')
    <script>

        $(document).ready(function () {
            $('#saveProfileBtn').click(function () {
                var data = new FormData($('#adminProfile')[0]);

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
                    url: '{{route("adminProfileSave")}}',
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,

                    success: function (response, status) {

                        if (response.result == 'success') {
                            $.unblockUI();
                            successMsg(response.message);

                            setTimeout(function () {
                                    window.location.href = '{{route('adminDashboard')}}';
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
        });

        var fileTypes = ['jpg', 'jpeg', 'png'];

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                var size = input.files[0].size;

                var extension = input.files[0].name.split('.').pop().toLowerCase(),  //file extension from input file
                    isSuccess = fileTypes.indexOf(extension) > -1;
                if (extension != 'jfif') {
                    if (isSuccess && size <= 1000000) {
                        reader.onload = function (e) {
                            $('#image_upload_preview')
                                .attr('src', e.target.result);
                        };

                        reader.readAsDataURL(input.files[0]);
                        $('#image_upload_preview').show();

                    } else {
                        errorMsg('You can only upload png,jpg or jpeg files and size of flag should not greater than 1MB');
                        $("#image").val('');
                        $('#image_upload_preview').hide();
                        $('#image_upload_preview').removeAttr('src');
                        return false;
                    }
                } else {
                    errorMsg('You can only upload png,jpg or jpeg files');
                    $("#image").val('');
                    $('#image_upload_preview').hide();
                    $('#image_upload_preview').removeAttr('src');
                    return false;
                }
            }
        }




    </script>
@endsection
