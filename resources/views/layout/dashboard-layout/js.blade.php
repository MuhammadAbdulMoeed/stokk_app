<script src="{{asset('admin/js/modernizr.min.js')}}"></script>

<script src="{{asset('admin/js/popper.min.js')}}"></script>
<script src="{{asset('admin/js/bootstrap.min.js')}}"></script>

<script src="{{asset('admin/js/detect.js')}}"></script>
<script src="{{asset('admin/js/fastclick.js')}}"></script>
<script src="{{asset('admin/js/jquery.blockUI.js')}}"></script>
<script src="{{asset('admin/js/jquery.nicescroll.js')}}"></script>
<!-- range -->

<!-- App js -->
<script src="{{asset('admin/js/script.js')}}"></script>

<script src="{{asset('custom/js/toastr.min.js')}}"></script>

<script src="{{asset('custom/js/keypress_functions.js')}}"></script>

<script src="{{asset('custom/js/select2(4.0.3).full.js')}}"></script>
<script src="{{asset('custom/js/slick.min.js')}}"></script>

<script>


    $(document).ready(function () {
        getTitle();
    });

    function getTitle() {
        $.ajax({
            type: 'GET',
            url: '{{route("getTitle")}}',

            success: function (response, status) {

                if (response.result == 'success') {

                    $('.site_name').text(response.data.name);
                } else if (response.result == 'error') {
                }
            }
        });
    }

    function successMsg(_msg) {
        window.toastr.success(_msg);
    }

    function errorMsg(_msg) {
        window.toastr.error(_msg);
    }

    function warningMsg(_msg) {
        window.toastr.warning(_msg);
    }


    @if(Session::has('success'))
    successMsg('{{Session::get("success")}}');
    @endif

    @if(Session::has('error'))
    errorMsg("{{Session::get('error')}}");
    @endif


</script>


