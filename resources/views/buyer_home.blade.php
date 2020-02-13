<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Bootstrap CSS CDN -->
        <link rel="icon" href="https://livego.com.tw/img/livego.png" type="image/x-icon" />
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
        <!-- edit img css -->
        <link rel="stylesheet" href="css/cropper.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <!-- Popper.JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ"
            crossorigin="anonymous"></script>

        <!-- loding -->
        <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.6/dist/loadingoverlay.min.js"></script>
    </head>
    <body>
        <div class="wrapper">
            <div id="content" style="background-color: #F5F5F5	">
                <div class="container">
                    <div class="card rounded-0">
                        <div class="card-body p-0"> 
                            <nav class="navbar navbar-expand-lg navbar-light shadow_bottom" style="background-color:rgba(179, 196, 189, 0.1);">
                                <div class="container-fluid">
                                    <div class="dropdown d-lg-none m-4">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="DropdownNavbar" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            <i class="fas fa-align-justify"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="DropdownNavbar">
                                            <!-- <a class="dropdown-item" id="TermsOfService">服務條款</a> -->
                                            <a class="dropdown-item" href="{{ route('buyer_order') }}">歷史訂單</a>
                                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">登出</a>
                                        </div>
                                    </div>
                                    <div class="collapse navbar-collapse">
                                        <ul class="nav navbar-nav m-auto">
                                            <li class="nav-item active border-right">
                                                <a class="nav-link" href="{{ route('buyer_home') }}">
                                                    <img src="https://livego.com.tw/img/livego.png">
                                                </a>
                                            </li>
                                            <li class="nav-item active border-right">
                                                <a class="nav-link h4" href="{{ route('buyer_home') }}">
                                                    來福逛逛
                                                </a>
                                            </li>
                                            <li class="nav-item active">
                                                <a class="nav-link">
                                                    追蹤我們
                                                    <div class="ml-1 mr-1 d-inline-block" onclick="window.location='https://www.facebook.com/ebx7086y/?ref=bookmarks';">
                                                        <i class='fab fa-facebook-square'></i>
                                                    </div>
                                                    <div class="d-inline-block" onclick="window.location='https://line.me/R/ti/p/%40ebx7086y';">
                                                        <i class='fab fa-line'></i>
                                                    </div>
                                                </a>
                                            </li>
                                        </ul>
                                        <ul class="nav navbar-nav ml-auto ">
                                            <li class="nav-item active m-auto" style="padding-right:5rem">
                                                <a class="nav-link" href="#">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <button class="btn btn-secondary" type="button">
                                                                <i class='fas fa-search'></i>
                                                            </button>
                                                        </div>
                                                        <style id="search_style_home"></style>
                                                        <input type="text" class="form-control" id="InputSearch_home" placeholder="在來福逛逛搜尋.." aria-label="Search">
                                                    </div>
                                                </a>
                                            </li>
                                        </ul>
                                        <ul class="nav navbar-nav ml-auto small">
                                            <li class="nav-item active m-auto">
                                                <a class="nav-link" href="#">
                                                    <i class='fas fa-bell mr-1'></i>通知總覽
                                                </a>
                                            </li>
                                            <li class="nav-item active m-auto">
                                                <a class="nav-link" href="#" id="TermsOfService">
                                                    <i class='fas fa-hand-holding-heart mr-1'></i>服務條款
                                                </a>
                                            </li>
                                            <li class="nav-item active">
                                                <div class="dropdown">
                                                    <a class="nav-link dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <img src="https://graph.facebook.com/{{Auth::user()->fb_id}}/picture" / class="rounded-circle">
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                                        {{ __('登出') }}</a>
                                                    </div>
                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                        @csrf
                                                    </form>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </nav>
                            <div class="row justify-content-center mb-4">
                                <div class="col-md-10">
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#!">全部</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row text-center" style="min-height: 100vh ">
                                <div class="col-md-12">
                                    <?php
                                        $count=0;
                                    ?>
                                    @foreach($query as $shop)
                                    <?php $count++ ?>
                                    <div class="hvrbox" data-index="{{ $shop->page_name }}" onclick="location.href='/shopping_mall?page_id={{ $shop->page_id }}'">
                                        <img src="https://graph.facebook.com/{{ $shop->page_id }}/picture?type=large" alt="Mountains" class="hvrbox-layer_bottom">
                                        <div class="hvrbox-layer_top">
                                            <div class="hvrbox-text">{{ $shop->page_name }}</div>
                                        </div>
                                    </div>
                                    @endforeach
                                    <?php
                                      $divnum=$count%4;
                                      $divnum=4-$divnum;
                                      for($i=0;$i<$divnum;$i++){
                                          echo '<div class="hvrbox invisible"  data-index="" >'.
                                          '<img src="" alt="Mountains" class="hvrbox-layer_bottom">'.
                                          '<div class="hvrbox-layer_top">'.
                                              '<div class="hvrbox-text"></div>'.
                                          '</div>'.
                                      '</div>';
                                      }
                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <!-- Cotent end-->
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
    <script src="js/datatables.min.js"></script>
    <!-- alterty JS -->
    <script src="js/alertify.js"></script>
    <!-- Chart js 分別在報表頁面新增-->
    <!-- <script src="js/Chart.bundle.min.js"></script>
    <script src="js/utils.js"></script> -->
    <!-- edit img JS -->
    <script src="js/cropper.js"></script>
    <script src="js/file.js"></script>
    <!--My js-->
    <script src="js/main.js"></script>
    <!--alert message-->
    <script src="js/message.js"></script>
    <script src="js/pagination.js"></script>
    <script>

    var searchStyle2 = document.getElementById('search_style_home');
    var searchInput2 = document.getElementById('InputSearch_home');
    if (searchInput2 != null) {
        searchInput2.addEventListener('input', function () {
            if (!this.value) {
                searchStyle2.innerHTML = "";
                return;
            }
            // look ma, no indexOf!  
            searchStyle2.innerHTML = ".hvrbox:not([data-index*=\"" + this.value + "\"]) { display: none; }";
            // beware of css injections!
        });
    }
    </script>

@if (session('success'))
    <script>
        alertify.set('notifier','position', 'top-center');
        alertify.success('<i class="fa mr-2">&#xf14a;</i>'+"{{ session('success') }}");
    </script>
@endif

@if (session('fail'))
    <script>
        alertify.set('notifier','position', 'top-center');
        alertify.error('<i class="fas mr-2">&#xf06a;</i>'+"{{ session('fail') }}"); 
    </script>
@endif
    </body>
</html>