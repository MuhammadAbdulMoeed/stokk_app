
<script src="{{asset('admin/js/modernizr.min.js')}}"></script>
<script src="{{asset('admin/js/jquery.min.js')}}"></script>

<script src="{{asset('admin/js/popper.min.js')}}"></script>
<script src="{{asset('admin/js/bootstrap.min.js')}}"></script>

<script src="{{asset('admin/js/detect.js')}}"></script>
<script src="{{asset('admin/js/fastclick.js')}}"></script>
<script src="{{asset('admin/js/jquery.blockUI.js')}}"></script>
<script src="{{asset('admin/js/jquery.nicescroll.js')}}"></script>

<!-- App js -->
<script src="{{asset('admin/js/script.js')}}"></script>

<script src="{{asset('custom/js/toastr.min.js')}}"></script>



<script>
    // $(document).ready(function() {
    //     $(".rate_select2").select2();
    // });


    function successMsg(_msg){
        window.toastr.success(_msg);
    }

    function errorMsg(_msg){
        window.toastr.error(_msg);
    }

    function warningMsg(_msg){
        window.toastr.warning(_msg);
    }


    @if(Session::has('success'))
        successMsg('{{Session::get("success")}}');
    @endif

    @if(Session::has('error'))
        errorMsg("{{Session::get('error')}}");
    @endif

</script>

