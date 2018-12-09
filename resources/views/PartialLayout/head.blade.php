    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- icon -->
    <link rel="Shortcut Icon" type="image/x-icon" href="img/livego.png" />
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4"
        crossorigin="anonymous">
    <!-- MY CSS -->
    <link rel="stylesheet" href="css/sidebar.css">
    <!--導覽列-->
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/navbar_shop.css">
    <!--標題列-->
    <link rel="stylesheet" href="css/notification.css">
    <!--通知列-->
    <link rel="stylesheet" href="css/LiveGO.css">
    <link rel="stylesheet" href="css/comment.css">
    <!-- iconfont CSS -->
    <link rel="stylesheet" href="css/icofont.css">
    <link rel="stylesheet" href="css/product_mgnt.css">

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ"
        crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY"
        crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>


    <!-- altertify CSS & JS -->
    <link rel="stylesheet" href="css/alertify.min.css">
    <link href="css/alertify.css" rel="stylesheet">
    <link href="css/default.css" rel="stylesheet">
    <script src="js/alertify.js"></script>

    <script>
    function message_danger() {
        // error_code 接收錯誤代碼 error_msg 接收錯誤提示訊息
        var alert_div = document.createElement("div");
        alert_div.setAttribute('id', 'data_info');
        alert_div.setAttribute("class", "card-body align-middle h5 text-center bg-light");
        alert_div.innerHTML =
            "<strong><i class='icofont icofont-exclamation-circle h1'></i> </strong><div class='mt-4'>  {{ session('alert') }}</div>";
        var warp_div = document.createElement("div");

        warp_div.setAttribute("class", "card shadow show_msg_center  w-25 bg-light")
        warp_div.append(alert_div);
        $("html").append(warp_div);

        setTimeout(
            function () {
                $("#data_info").fadeToggle(1000);
            }, 2000);
        setTimeout(
            function () {
                $("#data_info").parent().remove();
            }, 3000);
    }
    </script>

     