<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>LiveGO 來福狗 臉書直播電商智慧小幫手</title>

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-grid.min.css">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="css/masterpage.css">
    <link rel="stylesheet" href="css/LiveGO.css">
    <!-- Font Awesome JS -->
    <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.5.0/css/all.css' integrity='sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU'
        crossorigin='anonymous'>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ"
        crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY"
        crossorigin="anonymous"></script>
    <!-- EMOJI CSS -->
    <link rel="stylesheet" href="css/emojionearea.css">
    <!-- DataTable CSS -->
    <link rel="stylesheet" href="css/datatables.min.css">
    <!-- alterty JS -->
    <link rel="stylesheet" href="css/alertify.min.css">
</head>

<body style="background-color: #003163;  font-family: Microsoft JhengHei; overflow: hidden;">
    <div class="wrapper">
        <!-- Page Content  -->
        <div id="content">
            <div class="container">
                <div class="row text-center mt-4 pt-4 text-white font-weight-bolder">
                    <div class="col-md-12">
                        <h1>404</h1>
                    </div>
                    <div class="col-md-12">
                        <h3>找不到此網頁</h3>
                        <div id="div1">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ"
        crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="js/bootstrap.min.js"></script>
    <!-- EMOJI JS -->
    <script src="js/emojionearea.js"></script>
    <!-- DataTable JS -->
    <script src="js/dataTables.min.js"></script>
    <!-- alterty JS -->
    <script src="js/alertify.js"></script>
    <!-- Chart js -->
    <script src="js/Chart.bundle.js"></script>
    <script src="js/utils.js"></script>
    <!--My js-->
    <script src="js/main.js"></script>
    <style>
        .doggogo {
            position: absolute;
            z-index: 2000;
            width: 100px;
            height: 100px;
        }
    </style>
    <script>
        var h = $(window).height();
        var w = $(window).width();



        function dog() {
            setInterval(function () {
                var xh = Math.floor((Math.random() * h));
                var xw = Math.floor((Math.random() * w));
                $(".wrapper").append("<div class='doggogo' style='left:" + (xw ) + "px; top:" + (xh ) + "px; '><img src='img/42b02ed58144f790a6c77a6bd36c7619.gif'></div>")
            }, 100)
        }

        var t = 11;
        function showTime() {
            t -= 1;
            document.getElementById('div1').innerHTML = "─=≡Σ((( つ•̀ω•́)つ "+t;
            
            if(t==0){

                $("#div1").addClass("d-none");
            }
            //每秒執行一次,showTime()
            setTimeout("showTime()", 1000);
        }

        //執行showTime()
        showTime();


        setTimeout("dog()", 10500);
    </script>
</body>

</html>