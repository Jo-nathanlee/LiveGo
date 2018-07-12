<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- icon -->
    <link rel="Shortcut Icon" type="image/x-icon" href="img/livego.png" />
    <title>Live GO</title>

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4"
        crossorigin="anonymous">
    <!-- MY CSS -->
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <!--導覽列-->
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <!--標題列-->
    <link rel="stylesheet" href="{{ asset('css/notification.css') }}">
    <!--通知列-->
    <link rel="stylesheet" href="{{ asset('css/LiveGO.css') }}">
    <link rel="stylesheet" href="{{ asset('css/comment.css') }}">
    <!-- iconfont CSS -->
    <link rel="stylesheet" href="{{ asset('css/icofont.css') }}">
    <link href="{{ asset('css/alertify.css') }}" rel="stylesheet">
    <link href="{{ asset('css/default.css') }}" rel="stylesheet">
    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ"
        crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY"
        crossorigin="anonymous"></script>
    <!-- alterfy  -->
    <script src="{{ asset('js/alertify.js') }}"></script>
</head>


<body id="gray_bg">
    <div class="row">
        <div class="col-md-4 col-offset-4 text-center " id="log_in">
            <div class="login">
                <img src="img/livego.png" />
                <H4 class="text-dark">Live GO 來福狗</H4>
                <small class="d-block text-dark">直播電商智慧小幫手</small>


                <div class="col-md-8 col-offset-2">
                     <a class="btn btn-primary" href="/login/facebook">
                        Login
                    </a>
                    {{-- <button class="btn btn-lg btn-primary btn-block mt-4 mb-4" type="submit">Sign in</button> --}}
                </div>

                <small>* By logging in, you agree to our Terms of Use  & updates and acknowledge that you read our Privacy Policy.</small>
            </div>
        </div>
    </div>

    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ"
        crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm"
        crossorigin="anonymous"></script>
    <!-- My JS -->
    <script src="{{ asset('js/Live_go.js') }}"></script>

</body>

</html>
