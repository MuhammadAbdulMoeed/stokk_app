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

                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group">
                            <label>Category</label>
                            <select name="category_id" class="form-control">
                                <option value="" selected disabled>Select</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group">
                            <label>Filter</label>
                            <select multiple name="filters[]" class="form-control multiSelectOption">
                                @foreach($filters as $filter)
                                    <option value="{{$filter->id}}">{{$filter->filter_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>


                <button class="btn btn-primary" type="button" id="createBtn">Create</button>


                <a href="{{route('categoryFilterListing')}}">
                    <button class="btn btn-danger" type="button">Cancel</button>
                </a>
            </form>
        </div>

    </div>

@endsection


@section('script')


    <script>

        $(document).ready(function () {
            $('.multiSelectOption').select2();

            $('#createBtn').click(function () {

                // var data = $('#categoryForm').serialize();
                // var data = new FormData($('#categoryForm')[0]);

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
                    url: 'http://services.ticketmaster.com/api/ismds/event/0E005B9E487F4235/facets?show=count+row+listpricerange+places+maxQuantity+sections+shape&q=available&apikey=b462oi7fic6pehcdkzony5bxhe&apisecret=pquzpfrfz7zd2ylvtz3w5dtyse&resaleChannelId=internal.ecommerce.consumer.desktop.web.browser.ticketmaster.us',
                    // data: data,
                    // cache: false,
                    // contentType: false,
                    // processData: false,


                    beforeSend: function(xhr){
                        xhr.setRequestHeader("content-type","application/json;charset=utf-8")
                        xhr.setRequestHeader("Access-Control-Allow-Origin","*");
                        xhr.setRequestHeader("Access-Control-Allow-Credentials",true);
                        xhr.setRequestHeader("Access-Control-Allow-Headers","*");
                        xhr.setRequestHeader("Access-Control-Allow-Methods","GET, POST, DELETE, HEAD, OPTIONS, PATCH, PROPFIND, PROPPATCH, MKCOL, COPY, MOVE, LOCK, PUT");
                        // xhr.setRequestHeader("Access-Control-Allow-Origin","*");
                        // xhr.setRequestHeader("Access-Control-Expose-Headers","*");

                        // xhr.setRequestHeader("Access-Control-Allow-Headers","Origin, X-Requested-With,Content-Type,Accept");


                        xhr.setRequestHeader("TMPS-Correlation-Id", uuidv4());

                    },
                    // dataType: 'jsonp',

                    success: function (response, status) {
                        $.unblockUI();
                        console.log(response,status);

                        {{--if (response.result == 'success') {--}}
                        {{--    $.unblockUI();--}}
                        {{--    successMsg(response.message);--}}

                        {{--    setTimeout(function () {--}}
                        {{--            window.location.href = '{{route('categoryFilterListing')}}'--}}
                        {{--        }--}}
                        {{--        , 2000);--}}
                        {{--} else if (response.result == 'error') {--}}
                        {{--    $.unblockUI();--}}
                        {{--    errorMsg(response.message);--}}
                        {{--}--}}


                    },
                    error: function (data) {

                        $.unblockUI();
                        console.log(data);
                        // $.each(data.responseJSON.errors, function (key, value) {
                        //     $.unblockUI();
                        //     errorMsg(value);
                        // });
                    }


                });

            });



        });

        function uuidv4() {
            return ([1e7] + -1e3 + -4e3 + -8e3 + -1e11).replace(/[018]/g, c =>
                (c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16)
            );
        }
    </script>

@endsection
