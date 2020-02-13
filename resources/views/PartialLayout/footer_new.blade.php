<!-- Popper.JS -->
<script src="js/popper.min.js"></script>
<!-- Bootstrap JS -->
<script src="js/bootstrap.min.js"></script>
<!-- jQuery Custom Scroller CDN -->
<script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
<!-- Our js -->
<script src="js/jquery.formatCurrency-1.4.0.js"></script>
<script src="js/main.js"></script>
<script src="js/currencyFormatter.js"></script>
<script type="text/javascript" src="js/moment.min.js"></script>
<script type="text/javascript" src="js/daterangepicker.min.js"></script>

@if (session('success'))
    <script>
        alertify.set('notifier','position', 'top-center');
        alertify.success('<i class="fa mr-2">&#xf14a;</i>'+"{!! session('success') !!}");
    </script>
    {{Session::forget('success')}}
@endif

@if (session('fail'))
    <script>
        alertify.set('notifier','position', 'top-center');
        alertify.error('<i class="fas mr-2">&#xf06a;</i>'+"{!! session('fail') !!}"); 
    </script>
    {{Session::forget('fail')}}
@endif