@extends('layout.auth-layout.index')

@section('title')
    Reset Password
@endsection


@section('style')
    <link href="{{asset('admin/css/bootstrap-checkbox.css')}}" rel="stylesheet">

    <style>
        body{
            background-color: #fac660
        }
    </style>
@endsection

@section('body')

    <div class="row align-items-center justify-content-center m-2">
{{--        <img src="images/F&G.png" alt="">--}}
    </div>
    <div class="row h-100 justify-content-center align-items-center">
        <div class="card" style="width: 350px; padding-bottom: 10px;">
            <h4 class="card-header" style="background-color: #25b99e !important; color: white;">Reset Password</h4>

            <div class="card-body">

                <form data-toggle="validator" role="form" method="post" id="updatePassForm" action="#">
                    @csrf

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Email</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"
                                              style="background-color: #fac660!important; color:white"><i
                                                    class="far fa-envelope-open"></i></span>
                                    </div>
                                    <input type="email" class="form-control" name="email"
                                           data-error="Input valid email"  value="{{$data->email}}" readonly>
                                </div>

                            </div>

                            <div class="form-group">
                                <label>Password</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"
                                              style="background-color: #fac660!important; color:white"><i
                                                    class="fa fa-key"></i></span>
                                    </div>
                                    <input type="password" class="form-control" name="password"
                                           data-error="Input valid email" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Password Confirmation</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"
                                              style="background-color: #fac660!important; color:white"><i
                                                    class="fa fa-key"></i></span>
                                    </div>
                                    <input type="password" class="form-control" name="password_confirmation" id="confirm_password"
                                           data-error="Input valid email" required>
                                </div>


                                <div class="help-block with-errors text-danger"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" name="redirect" value="">
                            <a class="anchor-sh" style="text-decoration: none;" href="javascript:void(0)">
                                <input type="button" class="btn btn-primary btn-lg btn-block updatePassBtn" style="background-color: #002e5b!important; border-color:#002e5b; color:white"
                                        value="Password Reset" name="submit">
                            </a>
                        </div>
                    </div>
                </form>

                <div class="clear"></div>


            </div>

        </div>

    </div>



@endsection



@section('script')

    <script>

        $(document).ready(function(){

            $('.updatePassBtn').click(function () {

                var data = $('#updatePassForm').serialize();

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
                    url: '{{route("changePassword")}}',
                    data: data,

                    success: function (response, status) {

                        if (response.result == 'success') {
                            $.unblockUI();
                            successMsg(response.message);

                            setTimeout(function(){window.location.href = '{{route('loginPage')}}';},1000);

                        }
                        else if (response.result == 'error') {
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


            $("#confirm_password").keydown(function (e) {
                if (e.keyCode == 13) {
                    $('.updatePassBtn').click();
                }
            });
        });

    </script>

@endsection
