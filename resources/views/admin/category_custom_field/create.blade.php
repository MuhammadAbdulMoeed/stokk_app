@extends('layout.dashboard-layout.app')

@section('title')
    Create Category Field
@endsection


@section('body')

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12 bh-mb">
                    <div class="breadcrumb-holder">
                        <h1 class="main-title float-left">Create Category Field</h1>
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item">Home</li>
                            <li class="breadcrumb-item active">Create Category Field</li>
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
                            <select multiple name="fields[]" class="form-control multiSelectOption">
                                @foreach($fields as $field)
                                    <option value="{{$field->id}}">{{$field->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>


                <button class="btn btn-primary" type="button" id="createBtn">Create</button>


                <a href="{{route('categoryCustomFieldsListing')}}">
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

                var data = $('#categoryForm').serialize();
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

                    type: 'POST',
                    url: '{{route('categoryCustomFieldsSave')}}',
                    data: data,
                    // cache: false,
                    // contentType: false,
                    // processData: false,




                    success: function (response, status) {
                        $.unblockUI();

                        if (response.result == 'success') {
                            successMsg(response.message);

                            setTimeout(function () {
                                    window.location.href = '{{route('categoryCustomFieldsListing')}}'
                                }
                                , 2000);
                        } else if (response.result == 'error') {
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

        function uuidv4() {
            return ([1e7] + -1e3 + -4e3 + -8e3 + -1e11).replace(/[018]/g, c =>
                (c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16)
            );
        }
    </script>

@endsection
