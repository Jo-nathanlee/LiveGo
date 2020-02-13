<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="LiveGO 來福狗 - 臉書直播電商智慧小幫手" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="css_home/icofont.min.css">
    <link rel="stylesheet" href="css_home/main.css">
    <link rel="stylesheet" href="css_home/bootstrap.min.css">
    <link rel="icon" href="https://livego.com.tw/img/livego.png" type="image/x-icon" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script defer src="js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.20.4/TweenMax.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
        crossorigin="anonymous"></script>
    <!-- Google Font -->
    <title>LiveGO 來福狗</title>

</head>

<body>
    <!-- Load Facebook SDK for JavaScript -->
    <div id="fb-root"></div>
    <script>
    window.fbAsyncInit = function() {
        FB.init({
        xfbml            : true,
        version          : 'v4.0'
        });
    };

    (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = 'https://connect.facebook.net/zh_TW/sdk/xfbml.customerchat.js';
    fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

    <!-- Your customer chat code -->
    <div class="fb-customerchat"
    attribution=setup_tool
    page_id="1775801842732634"
    theme_color="#4f4f4f"
    logged_in_greeting="您好！歡迎光臨！有什麼可以幫助您的嗎？"
    logged_out_greeting="您好！歡迎光臨！有什麼可以幫助您的嗎？">
    </div>
    <!-- 開場動畫 -->
    <div id="LoadingDIv">
        <div id="fisrtAnimation">
            <span class="dot_1"></span>
            <span class="dot_2"></span>
            <span class="dot_3"></span>
            <span class="dot_4"></span>
        </div>
        <div id="secondAnimation">
            <span class="triangle_1"></span>
            <span class="triangle_2"></span>
            <span class="triangle_3"></span>
            <span class="triangle_4"></span>
            <span class="triangle_5"></span>
            <span class="triangle_6"></span>
            <span class="triangle_7"></span>
            <span class="triangle_8"></span>
        </div>
        <div id="thirdAnimation">
            <img src="https://livego.com.tw/img/livego.png">
        </div>

        <hr class="lineAnimation">
    </div>
    <!-- <div id="Loading_sm" class="d-block d-sm-block d-md-none d-lg-none d-xl-none">
        <div id="dog_animation">
            <img src="img/dog.gif">
            <font> LiveGO</font>
        </div>
        <hr class="lineAnimation">
    </div> -->
    <div class="curtain-panel">
        <div class="top-curtain curtain" data-title="Click to reveal a special reward..."></div>
        <div class="bottom-curtain curtain" data-title="Click to reveal a special reward..."></div>
    </div>
    <!-- 開場動畫結束 -->
    <div id="main">
        <!-- navbar -->
        <nav class="navbar navbar-expand-md navbar-fixed-top">
            <div class="container">
                <div class="navbar-collapse collapse nav-content order-2">
                    <ul class="nav navbar-nav h5">
                        LiveGO來福狗
                    </ul>
                </div>
                <ul class="nav navbar-nav text-nowrap flex-row mx-md-auto order-1 order-md-2">
                    <li class="nav-item mr-3" onclick="location.href='https://www.facebook.com/messages/t/LiveGO.com.tw'" >
                        <i class="icofont-facebook-messenger"></i>
                    </li>
                    <li class="nav-item mr-3">
                        <i class="icofont-facebook" onclick="location.href='https://www.facebook.com/LiveGO.com.tw/'" ></i>
                    </li>
                    <li class="nav-item">
                        <i class="icofont-line-messenger"  onclick="location.href='http://qr-official.line.me/L/uZiG5m3fCk.png'"></i>
                    </li>
                </ul>
                <div class="ml-auto navbar-collapse collapse nav-content order-3 order-md-3">
                    <ul class="ml-auto nav navbar-nav h5">
                        <button type="button" onclick="location.href='https://livego.com.tw/set_page'" class="btn btn-info">賣家系統登入</button>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- navbar end -->
        <div id="myModal" class="modal">
            <!-- Modal content -->
            <span class="close text-right"></span>
            <video controls width="400" id="LiveGO_Video" class="modal-content">
                <source src="img_home/LiveGO.mp4" type="video/mp4">
            </video>
        </div>
        <!-- home page -->
        <div id="LiveGO_page">
            <div class="container">
                <div class="strLiveGO">
                    <a>LiveGO</a>
                    <img class="d-none d-sm-none d-md-inline" src="https://livego.com.tw/img_home/livegosmall.png">
                </div>
                <div class="subject d-none d-sm-none d-md-table-cell">
                    <h1 class="caret">臉書直播電商智慧小幫手</h1>
                </div>
                <div class="subject d-md-none d-sm-table-cell">
                    <h4 class="caret">臉書直播電商智慧小幫手</h1>
                </div>
                <!-- 觀看影片手機不顯示 -->
                <div class="d-none d-sm-none d-md-block">
                    <div class="mydiv">
                        <div class="play-button">
                            <svg class="play-circles" viewBox="0 0 152 152">
                                <circle class="play-circle-01" fill="none" stroke="#fff" stroke-width="3" stroke-dasharray="343 343" cx="76" cy="76" r="72.7"
                                />
                                <circle class="play-circle-02" fill="none" stroke="#fff" stroke-width="3" stroke-dasharray="309 309" cx="76" cy="76" r="65.5"
                                />
                            </svg>
                        </div>
                        <div class="play-triangle "></div>
                    </div>
                    <div class="WatchVideo">
                        <h1 id="strWatchVideo">
                            Watch Video !
                        </h1>
                    </div>
                </div>

                <div class="d-block d-sm-block d-md-none d-lg-none d-xl-none">
                    <div class="xs_watch_video">
                        <i class="fa fa-play-circle mr-3"></i>WatchVideo!
                    </div>
                </div>
            </div>
        </div>
        <!-- home page end -->
        <!-- add us page -->
        <div id="AddUs">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="h6 d-none d-sm-none d-md-table-cell" style="white-space:nowrap">自動、方便、快速、簡單，原來一個人也可以輕鬆經營直播拍賣！
                            <button type="button" onclick="location.href='https://www.facebook.com/LiveGO.com.tw/'"  class="ml-4 btn btn-lg btn-outline-light">
                                <i class="icofont-hand-drag1 h6"></i> 現在立即免費使用！</button>
                        </div>
                        <div class="d-md-none d-sm-table-cell small">自動、方便、快速、簡單，原來一個人也可以輕鬆經營直播拍賣！
                            <button type="button" onclick="location.href='https://www.facebook.com/LiveGO.com.tw/'" class="ml-2 btn btn-sm btn-outline-light small">
                                立即免費使用！</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- add us page end -->
        <!-- Problems page -->
        <section id="team" class="pb-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 d-none d-sm-none d-md-table-cell" style="padding-bottom: 5rem;">
                        <h2 class="text-center font-weight-bolder">您是否在直播拍賣有遇到這些問題呢？</h2>
                        <h3 class="text-center font-weight-bolder text-muted">是否常常會讓你頭疼？</h3>
                    </div>
                    <div class="col-md-12 d-md-none d-sm-table-cell" style="padding-bottom: 5rem;">
                        <h4 class="text-center font-weight-bolder">您是否在直播拍賣有遇到這些問題呢？</h2>
                            <h5 class="text-center font-weight-bolder text-muted">是否常常會讓你頭疼？</h3>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <div class="image-flip" ontouchstart="this.classList.toggle('hover');">
                            <div class="mainflip">
                                <div class="frontside">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <p>
                                                <div class="d-inline">
                                                    <div class="problem_circle">
                                                        <i class="icofont-sound-wave" style="font-size:3rem;"></i>
                                                    </div>
                                                </div>
                                            </p>
                                            <h4 class="card-title">直播購物流程繁雜</h4>
                                            <p class="card-text">繁瑣的直播購物流程在顧客量一多時就會手忙腳亂，導致無法有效率的跟買家溝通。</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="backside">
                                    <div class="card">
                                        <div class="card-body text-center mt-4">
                                            <h4 class="card-title">流程精簡化</h4>
                                            <p class="card-text"><i class="icofont-checked"></i> 簡化直播購物流程，減少人力需求。</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <div class="image-flip" ontouchstart="this.classList.toggle('hover');">
                            <div class="mainflip">
                                <div class="frontside">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <p>
                                                <div class="d-inline">
                                                    <div class="problem_circle">
                                                        <i class="icofont-search-document" style="font-size:3rem;"></i>
                                                    </div>
                                                </div>
                                            </p>
                                            <h4 class="card-title">無明確訂單資訊</h4>
                                            <p class="card-text">標時訂單資訊不明確，無法清楚記錄訂單，常常導致跟顧客有消費糾紛。</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="backside">
                                    <div class="card">
                                        <div class="card-body text-center mt-4">
                                            <h4 class="card-title">訂單自動化</h4>
                                            <p class="card-text"><i class="icofont-checked"></i> 系統自動產生得標訂單，提升訂單處理效率。</p>
                                            <p class="card-text"><i class="icofont-checked"></i> 系統自動發送得標訊息，節省與顧客溝通時間。</p>
                                            <p class="card-text"><i class="icofont-checked"></i> 系統自動記錄購物粉絲，分辨忠實顧客。</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <div class="image-flip" ontouchstart="this.classList.toggle('hover');">
                            <div class="mainflip">
                                <div class="frontside">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <p>
                                                <div class="d-inline">
                                                    <div class="problem_circle" >
                                                        <i class="icofont-papers" style="font-size:3rem;"></i>
                                                    </div>
                                                </div>
                                            </p>
                                            <h4 class="card-title">訂單填寫錯誤</h4>
                                            <p class="card-text">訂單量龐大時，容易發生小幫手訂單寫錯等狀況。</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="backside">
                                    <div class="card">
                                        <div class="card-body text-center mt-4">
                                            <h4 class="card-title">訂單自動化</h4>
                                            <p class="card-text"><i class="icofont-checked"></i> 系統自動產生得標訂單，提升訂單處理效率。</p>
                                            <p class="card-text"><i class="icofont-checked"></i> 系統自動發送得標訊息，節省與顧客溝通時間。</p>
                                            <p class="card-text"><i class="icofont-checked"></i> 系統自動記錄購物粉絲，分辨忠實顧客。</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <div class="image-flip" ontouchstart="this.classList.toggle('hover');">
                            <div class="mainflip">
                                <div class="frontside">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <p>
                                                <div class="d-inline">
                                                    <div class="problem_circle">
                                                        <i class="icofont-burglar" style="font-size:3rem;"></i>
                                                    </div>
                                                </div>
                                            </p>
                                            <h4 class="card-title">買家惡意棄標</h4>
                                            <p class="card-text">無法有效避免買家多次惡意棄標。</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="backside">
                                    <div class="card">
                                        <div class="card-body text-center mt-4">
                                            <h4 class="card-title">規則公平化</h4>
                                            <p class="card-text"><i class="icofont-checked"></i> 得標機制電子化，降低消費糾紛。</p>
                                            <p class="card-text"><i class="icofont-checked"></i> 紀錄棄標名單，避免惡意買家。</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- <div id="Problems">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 d-none d-sm-none d-md-table-cell" style="padding-top: 5rem;">
                        <h2 class="text-center font-weight-bolder">您是否在直播拍賣有遇到這些問題呢？</h2>
                        <h3 class="text-center font-weight-bolder text-muted">是否常常會讓你頭疼？</h3>
                    </div>
                    <div class="col-md-12 d-md-none d-sm-table-cell" style="padding-top: 5rem;">
                        <h4 class="text-center font-weight-bolder">您是否在直播拍賣有遇到這些問題呢？</h2>
                            <h5 class="text-center font-weight-bolder text-muted">是否常常會讓你頭疼？</h3>
                    </div>

                    <div class="col-md-6 d-none d-sm-none d-md-table-cell text-center">
                        <img src="img_home/cellphone.png" style="width: 100%;">
                    </div>
                    <div class="col-md-6 d-none d-sm-none d-md-table-cell pt-4 mt-4">
                        <div class="alert alert-mediumseagreen shadow mt-4" role="alert">
                            <h4 class="alert-heading">
                                <i class="icofont-chart-flow"></i>直播流程過於複雜</h4>
                            直播購物流程過於繁雜，導致效率不佳。
                        </div>
                        <div class="alert alert-mediumseagreen shadow" role="alert">
                            <h4 class="alert-heading">
                                <i class="icofont-search-document"></i>無明確訂單資訊</h4>
                            訂單資訊模糊不明確，容易與顧客有消費糾紛。
                        </div>
                        <div class="alert alert-mediumseagreen shadow" role="alert">
                            <h4 class="alert-heading">
                                <i class="icofont-paper"></i>訂單填寫錯誤</h4>
                            小幫手填寫大量訂單，導致訂單填寫錯誤等。
                        </div>
                        <div class="alert alert-mediumseagreen shadow" role="alert">
                            <h4 class="alert-heading">
                                <i class="icofont-investigator"></i>買家惡意棄標</h4>
                            無法預防惡意買家多次棄標。
                        </div>
                    </div>
                    <div class="col-sm-12 d-md-none d-sm-table-cell">
                        <div class="alert alert-mediumseagreen shadow mt-4 small" role="alert">
                            <h6 class="alert-heading">
                                <i class="icofont-chart-flow"></i>直播流程過於複雜</h6>
                            直播購物流程過於繁雜，導致效率不佳。
                        </div>
                        <div class="alert alert-mediumseagreen shadow small" role="alert">
                            <h6 class="alert-heading">
                                <i class="icofont-search-document"></i>無明確訂單資訊</h6>
                            訂單資訊模糊不明確，容易與顧客有消費糾紛。
                        </div>
                        <div class="alert alert-mediumseagreen shadow small" role="alert">
                            <h6 class="alert-heading">
                                <i class="icofont-paper"></i>訂單填寫錯誤</h6>
                            小幫手填寫大量訂單，導致訂單填寫錯誤等。
                        </div>
                        <div class="alert alert-mediumseagreen shadow small" role="alert">
                            <h6 class="alert-heading">
                                <i class="icofont-investigator"></i>買家惡意棄標</h6>
                            無法預防惡意買家多次棄標。
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <!-- Problems page end -->
        <!-- feature page -->
        <div id="HelpUs_page">
            <div class="title d-none d-sm-none d-md-block">
                <h2>LiveGO 能幫助我什麼?</h2>
                <h3>我們能當您最有效率的小幫手，解決直播中所有繁雜的事！</h3>
            </div>
            <div class="title d-md-none d-sm-block">
                <h4>LiveGO 能幫助我什麼?</h2>
                    <h5>我們能當您最有效率的小幫手，解決直播中所有繁雜的事！</h3>
            </div>
            <div id="container">
                <div class="row">
                    <div class="col-md-8 offset-md-2 col-sm-12">
                        <div id="monitor" class="d-none d-sm-none d-md-block">
                            <div id="monitorscreen">
                                <video controls width="400" id="LiveGO_Video" class="modal-content">
                                    <source src="img_home/LiveGO.mp4" type="video/mp4">
                                </video>
                            </div>
                        </div>
                        <div class="title d-md-none d-sm-block">
                            <iframe width="100%" height="571" src="https://www.youtube.com/embed/lhqC9g6raeY" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="container">
                <div class="row pb-5 fisrt_row">
                    <div class="col-md-4  text-center ">
                        <div class="w-50 offset-3">
                            <div class="d-block mb-4">
                                <i class="icofont-chart-histogram-alt"></i>
                            </div>
                            <div class="d-block">
                                <h3>得標訂單效率化</h3>
                                <small>即時產生且不遺漏任何一筆訂單，解決你訂單過多時不能及時處理訂單的情況。</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4  text-center">
                        <div class="w-50 offset-3">
                            <div class="d-block mb-4">
                                <i class="icofont-stack-overflow"></i>
                            </div>
                            <div class="d-block">
                                <h3>購物流程精簡化</h3>
                                <small>將以往繁雜的購物流程優化、提升效率，進而增加買家購物的意願。</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4  text-center">
                        <div class="w-50 offset-3">
                            <div class="d-block mb-4">
                                <i class="icofont-safety"></i>
                            </div>
                            <div class="d-block">
                                <h3>錯誤風險最小化</h3>
                                <small> 透過LiveGO控管購物的流程，降低人工作業下發生的錯誤風險。</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container pb-5">
                <div class="row pb-5 pt-5 second_row">
                    <div class="col-md-4  text-center  ">
                        <div class="w-50 offset-3">
                            <div class="d-block mb-4">
                                <i class="icofont-ui-settings"></i>
                            </div>
                            <div class="d-block">
                                <h3>標訊息自動化</h3>
                                <small>當買家得標時，LiveGO會自動發送得標資訊給買家，節省小幫手私訊買家的時間。</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4  text-center  ">
                        <div class="w-50 offset-3">
                            <div class="d-block mb-4">
                                <i class="icofont-binary"></i>
                            </div>
                            <div class="d-block">
                                <h3>訂單紀錄電子化</h3>
                                <small>記錄每筆銷售訂單、買家得標時的留言，進而減少買賣雙方交易糾紛。</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4  text-center">
                        <div class="w-50 offset-3">
                            <div class="d-block mb-4">
                                <i class="icofont-list"></i>
                            </div>
                            <div class="d-block">
                                <h3>棄標名單列表化</h3>
                                <small>紀錄買家棄標次數，當買家下次購物時，賣家可以參考是否要再次讓此買家進行購物。</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->

        </div>
        <!-- feature page end -->
        <!-- Service page -->
        <div id="Service">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 d-none d-sm-none d-md-table-cell" style="padding-top: 5rem;margin-bottom: 5rem;">
                        <h2 class="text-center font-weight-bolder">LiveGO 提供最優質的賣家&買家模組</h2>
                        <h3 class="text-center font-weight-bolder text-light">自動！方便！輕鬆！</h3>
                    </div>
                    <div class="col-md-6 d-none d-sm-none d-md-table-cell">
                        <img src="img_home/business-2879470_960_720.jpg" class="w-100">
                    </div>
                    <div class="col-md-6">
                        <!-- <h4 class="font-weight-bolder title-text">賣家模組提供賣家全自動化的服務！</h4> -->
                        <div style="height: 5rem;" class=" d-md-none d-sm-table-cell"></div>
                        <p class="note">
                            <span class="title-text">
                                <i class="icofont-check-circled"></i>直播訂單管理模組</span>
                            <br>
                            <span> 自動產生直播訂單、直播訂單紀錄、自動私訊得標者</span>
                        </p>
                        <p class="note">
                            <span class="title-text">
                                <i class="icofont-check-circled"></i>直播顧客管理模組</span>
                            <br>
                            <span>記錄會員資料、記錄會員棄標次數、記錄會員購買次數</span>
                        </p>
                        <p class="note">
                            <span class="title-text">
                                <i class="icofont-check-circled"></i>財務管理模組</span>
                            <br>
                            <span>自動結算營業額、分析日月成長額</span>
                        </p>
                    </div>
                    <div class="col-md-6 ">
                        <div class="d-none d-sm-none d-md-table-cell" style="height: 5rem;"></div>
                        <!-- <h4 class="font-weight-bolder title-text">買家模組提供買家最方便、品質的服務！</h4> -->
                        <p class="note">
                            <span class="title-text">
                                <i class="icofont-check-circled"></i>直播購物管理模組</span>
                            <br>
                            <span> 訂單狀態查詢、合併多筆直播訂單、多元支付</span>
                        </p>
                        <p class="note">
                            <span class="title-text">
                                <i class="icofont-check-circled"></i>商城購物模組</span>
                            <br>
                            <span>來福逛逛、購物車</span>
                        </p>
                        <p class="note">
                            <span class="title-text">
                                <i class="icofont-check-circled"></i>直播庫管理模組</span>
                            <br>
                            <span>直播節目表清單、直播頻道&商家訂閱、我的最愛</span>
                        </p>
                    </div>
                    <div class="col-md-6 d-none d-sm-none d-md-table-cell" style="margin-top: 5rem;">
                        <img src="img_home/service-coverph.png" class="w-100">
                    </div>
                </div>
            </div>
        </div>
        <!-- Service page end -->
        <!-- GrowingUp_page -->
        <div id="GrowingUp_page">
            <h2 class="text-center">直播產值近35億元</h2>
            <h3 class="text-center mb-4">LiveGO幫您掌握商機</h3>
            <div class="container ">
                <div class="card shadow-lg">
                    <div class="row card-body p-5">
                        <div class="col-md-2 col-sm-4  col-4 text-right">
                            <div class="progress-label">Facebook</div>
                            <div class="progress-label">Youtube</div>
                            <div class="progress-label">17 直播</div>
                            <div class="progress-label">Instagram</div>
                            <div class="progress-label">Live.me</div>
                        </div>
                        <div class="col-md-4 col-sm-8 col-8">
                            <div class="progress mb-3">
                                <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" style="width: 71%" aria-valuenow="71"
                                    aria-valuemin="0" aria-valuemax="100">71%</div>
                            </div>
                            <div class="progress mb-3">
                                <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" style="width: 16%" aria-valuenow="16"
                                    aria-valuemin="0" aria-valuemax="100">16%</div>
                            </div>
                            <div class="progress mb-3">
                                <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" style="width: 6%" aria-valuenow="6"
                                    aria-valuemin="0" aria-valuemax="100">
                                    <small>6%</small>
                                </div>
                            </div>
                            <div class="progress mb-3">
                                <div class="progress-bar bg-success text-light progress-bar-striped progress-bar-animated" role="progressbar" style="width: 4%"
                                    aria-valuenow="4" aria-valuemin="0" aria-valuemax="100">
                                    <small>4%</small>
                                </div>
                            </div>
                            <div class="progress mb-3">
                                <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" style="width: 3%" aria-valuenow="3"
                                    aria-valuemin="0" aria-valuemax="100">
                                    <small>3%</small>
                                </div>
                            </div>
                            <footer class="blockquote-footer text-right">
                                <small>資策會產業情報研究所針對觀看直播之調查</small>
                            </footer>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="content">
                                現今七成多的使用者以「FaceBook」為主要平台，而你還不跟上時代潮流一起前往網路直播嗎？快來加入LiveGO！絕對可以讓您在網路直播中獲得更多利潤同時在背後挺你，幫您解決傳統直播上遇到的問題！
                            </div>
                            <button type="button" onclick="location.href='https://www.facebook.com/LiveGO.com.tw/'" class="btn btn-outline-secondary buttom_position w-50 col-sm-12 sm-mt-2">加入我們!! </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- GrowingUp_page end-->
        <!-- news page -->
        <div class="container">
            <h2 class="text-center">LiveGO來福狗相關報導</h2>
            <h3 class="text-center mb-4">聽聽別人怎麼說??</h3>
            <div class="container cta-100 ">
                <div class="container">
                    <div class="row blog">
                        <div class="col-md-12">
                            <div id="blogCarousel" class="carousel slide container-blog" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    <li data-target="#blogCarousel" data-slide-to="0" class="active"></li>
                                    <li data-target="#blogCarousel" data-slide-to="1"></li>
                                </ol>
                                <!-- Carousel items -->
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="item-box-blog">
                                                    <div class="item-box-blog-image">
                                                        <!--Date-->
                                                        <div class="item-box-blog-date bg-blue-ui white">
                                                            <span class="mon">2018/11/27</span>
                                                        </div>
                                                        <!--Image-->
                                                        <figure>
                                                            <img alt="中原大學-LiveGO來福狗" src="https://upload.wikimedia.org/wikipedia/zh/thumb/8/83/CYCU.svg/1200px-CYCU.svg.png"> </figure>
                                                    </div>
                                                    <div class="item-box-blog-body">
                                                        <!--Heading-->
                                                        <div class="item-box-blog-heading">
                                                            <a href="http://www1.cycu.edu.tw/news/detail?type=%E5%B8%AB%E7%94%9F%E7%9A%84%E5%85%89&id=1986" tabindex="0">
                                                                <h5>中原大學 - 學生結合專業，打造直播界蝦皮</h5>
                                                            </a>
                                                        </div>
                                                        <!--Text-->
                                                        <div class="item-box-blog-text">
                                                            <p>直播熱潮正夯，中原大學資訊管理學系的學生將專業知識與創意點子結合，不但寫出網站系統將直播購物下單規則變簡單，更開發出網紅與企業的媒合平台，豐富的創意與執行力獲得今年度「大專校院資訊應用服務創新競賽」多項大獎。中原學生透過競賽賺取專業能力經驗值，更透過實作與企業充分對話，發揮學用合一、產學合作的精神。
                                                                由經濟部工業局、教育部資訊及科技教育司和中華民國資訊管理協會共同主辦的「大專校院資訊應用服務創新競賽」，11月3日大會於台大體育館舉行決賽，從868隊大專院校及高中職隊伍中遴選380組隊伍入圍，決賽總人數達2280人，場面極為盛大。中原大學資管系共有4組隊伍脫穎而出，奪下一金三銅的佳績，為校爭光！
                                                                今年的競賽主題相當多元，涵蓋物聯網、資訊安全、雲端科技、智慧零售等。學生團隊在競賽過程中除了運用資管所學與團隊合作，也要設計一套符合企業主的APP軟件程式，企業亦可從中找到科技菁英，形成優良的產學合作橋樑。摘下「產學合作組」金牌的「來福狗-LIVE
                                                                GO」團隊就表示，由於近年直播購物熱潮，組員們因此鎖定直播銷售市場帶來的龐大產值，開發一套完整的網頁系統用以輔助直播賣家，除了能清楚計算下訂資訊，降低出錯率，同時也能幫助賣家解決惡意棄標及衍生的消費紛爭。團隊成員陳節軒說：「我們的目標就是要打造『直播界的蝦皮』！」
                                                                通稿照片-獲得「商業資訊創新應用組」銅牌的「愛粉絲」團隊以媒合平台為主題.jpg 而獲得「商業資訊創新應用組」銅牌的「愛粉絲」團隊則是以媒合平台為主題，團隊成員朱映潔表示，網路上有各種不同類型的網紅，像是美食推薦、科普或教英文，若能開發一個網站協助業界公司分析合適的商品代言人、媒合兩者需求，相信一定可以有無限商機。
                                                                同樣拿下第三名寶座的URBAN DIARY 及憶想星空團隊表現也相當亮眼。URBAN DIARY團隊表示當時設計初衷是「希望平凡的生活能透過APP有不一樣的回饋」。於是他們不但將待辦事項智能化，間接紀錄每天的生活；APP軟件程式還能間接幫助你規劃未來，朝設定的目標邁進。憶想星空團隊成員李憶濃也進一步說明，針對鍾愛「Instagram」的用戶，將APP結合社群平台，並開發獨立相簿的功能，讓分享過的回憶能被好好珍藏。
                                                                通稿照片-憶想星空團隊針對Instagram用戶開發獨立相簿的功能.jpg 通稿照片-獲得第三名UrbanDiary團隊設計初衷是「希望平凡的生活能透過APP有不一樣的回饋」.jpg
                                                                中原大學致力於「學用合一」之發展，不但成立三創學程與創新創業中心輔助學生的好點子，今年更在校內舉辦了第一屆的創業競賽，提供專業舞台，讓學生的想法實體化，為企業培育優秀人才！
                                                            </p>
                                                        </div>
                                                        <div class="mt">
                                                            <a href="http://www1.cycu.edu.tw/news/detail?type=%E5%B8%AB%E7%94%9F%E7%9A%84%E5%85%89&id=1986" tabindex="0" class="btn bg-blue-ui white read">read more</a>
                                                        </div>
                                                        <!--Read More Button-->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="item-box-blog">
                                                    <div class="item-box-blog-image">
                                                        <!--Date-->
                                                        <div class="item-box-blog-date bg-blue-ui white">
                                                            <span class="mon">2018/11/27</span>
                                                        </div>
                                                        <!--Image-->
                                                        <figure>
                                                            <img alt="中華日報-LiveGO來福狗" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRJOjMyKbg0fQdaXAN5QUAMqE-FELw5Esx3PlC03favLMPPPGG8"> </figure>
                                                    </div>
                                                    <div class="item-box-blog-body">
                                                        <!--Heading-->
                                                        <div class="item-box-blog-heading">
                                                            <a href="https://www.google.com/url?sa=t&rct=j&q=&esrc=s&source=web&cd=7&cad=rja&uact=8&ved=2ahUKEwiXpoLU7-PhAhWFXrwKHdfgCo8QFjAGegQIAxAB&url=http%3A%2F%2Fwww.cdns.com.tw%2Fnews.php%3Fn_id%3D0%26nc_id%3D267044&usg=AOvVaw29w1US-K2EmD9atkiHJ7HJ"
                                                                tabindex="0">
                                                                <h5>中華日報 - 中原元智資工與資管系參賽獲獎</h5>
                                                            </a>
                                                        </div>
                                                        <!--Text-->
                                                        <div class="item-box-blog-text">
                                                            <p>
                                                                元智大學和中原大學二十七日都發佈新聞稿指該校的資工與資管系，近期參加國內各項競賽都有不錯成績，中原資工是參加資訊應用服務創新獲一金三銅的佳績，元智資工則是參加電腦輔助軟體競賽獲得第二名，老師們說，參賽可提升學生的專業能力和降低產學落差。 　元智資工是由學生鄭立程等同學組隊參加國際積體電路電腦輔助設計軟體製作競賽，他們在A組中獲得第二名，這項比賽是電子設計自動化領域中很重要比賽，他們也在美國加州聖地牙哥舉辦的國際電腦輔助設計研討會獲頒獎牌及獎金三萬元。
                                                                　中原大學資管同學則是參加大專校院資訊應用服務創新競賽，獲得一金三銅的佳績，今年在八百六十八隊大專院校及高中職隊伍中遴選，其中三百八十組隊伍入圍，今年的競賽主題相當多元，涵蓋物聯網、資訊安全、雲端科技、智慧零售等。
                                                                　獲得「產學合作組」金牌的「來福狗-LIVE GO」團隊說，他們是看到近年直播購物熱潮，所以，開發一套完整的網頁系統用以輔助直播賣家，除了能清楚計算下訂資訊，降低出錯率，同時也能幫助賣家解決惡意棄標及衍生的消費紛爭。
                                                                元智資工系陳勇志教授說，這次競賽與傳統程式設計競賽不同，除了賽程需花七個月時程外，問題的複雜度也提高，除了要有專業知識與程式實作能力外，也考驗學生的細心與恆心，對提升學生的專業能力與降低產學落差有相當助益。
                                                            </p>
                                                        </div>
                                                        <div class="mt">
                                                            <a href="https://www.google.com/url?sa=t&rct=j&q=&esrc=s&source=web&cd=7&cad=rja&uact=8&ved=2ahUKEwiXpoLU7-PhAhWFXrwKHdfgCo8QFjAGegQIAxAB&url=http%3A%2F%2Fwww.cdns.com.tw%2Fnews.php%3Fn_id%3D0%26nc_id%3D267044&usg=AOvVaw29w1US-K2EmD9atkiHJ7HJ"
                                                                tabindex="0" class="btn bg-blue-ui white read">read more</a>
                                                        </div>
                                                        <!--Read More Button-->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="item-box-blog">
                                                    <div class="item-box-blog-image">
                                                        <!--Date-->
                                                        <div class="item-box-blog-date bg-blue-ui white">
                                                            <span class="mon">2018/11/27</span>
                                                        </div>
                                                        <!--Image-->
                                                        <figure>
                                                            <img alt="FM96.7 環宇電台-LiveGO來福狗" src="data:image/jpeg;base64,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"> </figure>
                                                    </div>
                                                    <div class="item-box-blog-body">
                                                        <!--Heading-->
                                                        <div class="item-box-blog-heading">
                                                            <a href="http://www.uni967.com/newweb/index.php?menu=4&page=4_1&category=%E5%9C%B0%E6%96%B9&ID=6561" tabindex="0">
                                                                <h5>FM96.7 環宇電台 - 目標成為直播界的蝦皮 中原學生創意備受肯定</h5>
                                                            </a>
                                                        </div>
                                                        <!--Text-->
                                                        <div class="item-box-blog-text">
                                                            <p>
                                                                現在網路直撥越來越夯，有學生將專業知識與創意點子結合，不只寫出網站系統將直播購物下單規則變得簡單，更開發出網紅與企業的媒合平台，中原大學學生組成「來福狗-LIVE GO」團隊，豐富的創意與執行力獲得今年度「大專校院資訊應用服務創新競賽」多項大獎，團隊成員陳節軒也說：「我們的目標就是要打造『直播界的蝦皮』！」
                                                                由經濟部工業局、教育部資訊及科技教育司和中華民國資訊管理協會共同主辦的「大專校院資訊應用服務創新競賽」，11月3號在台大體育館舉行決賽，從868隊大專院校及高中職隊伍中遴選380組隊伍入圍，決賽總人數達2280人，中原大學資管系共有4組隊伍脫穎而出，奪下一金三銅的佳績，摘下「產學合作組」金牌的「來福狗-LIVE
                                                                GO」團隊說，由於近年直播購物熱潮，組員們就鎖定直播銷售市場帶來的龐大產值，開發一套完整的網頁系統用以輔助直播賣家，除了能清楚計算下訂資訊，降低出錯率，同時也能幫助賣家解決惡意棄標及衍生的消費紛爭，指導老師金志聿說這個比賽是資訊管理的專題競賽，所以才跟同學討論要如何運用資訊科技加上創意，來解決『臉書直播』所遇到的問題，例如不知道誰得標或者數量太多、人事複雜等，所以就想說能不能利用『資訊』的方式，讓電商更便利、更公平去處理訂單，學生就利用這個點子，做出『來福狗-LIVE
                                                                GO』的平台。 另外，獲得「商業資訊創新應用組」銅牌的「愛粉絲」團隊則是以媒合平台為主題，成員朱映潔表示，網路上有各種不同類型的網紅，像是美食推薦、科普或教英文，若能開發一個網站協助業界公司分析合適的商品代言人、媒合兩者需求，相信一定可以有無限商機。
                                                                校方強調，中原大學致力於「學用合一」之發展，不但成立三創學程與創新創業中心輔助學生的好點子，今年更在校內舉辦了第一屆的創業競賽，提供專業舞台，讓學生的想法實體化，為企業培育優秀人才！
                                                            </p>
                                                        </div>
                                                        <div class="mt">
                                                            <a href="http://www.uni967.com/newweb/index.php?menu=4&page=4_1&category=%E5%9C%B0%E6%96%B9&ID=6561" tabindex="0" class="btn bg-blue-ui white read">read more</a>
                                                        </div>
                                                        <!--Read More Button-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--.row-->
                                    </div>
                                    <!--.item-->
                                    <div class="carousel-item ">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="item-box-blog">
                                                    <div class="item-box-blog-image">
                                                        <!--Date-->
                                                        <div class="item-box-blog-date bg-blue-ui white">
                                                            <span class="mon">2018/11/27</span>
                                                        </div>
                                                        <!--Image-->
                                                        <figure>
                                                            <img alt="痞客邦-LiveGO來福狗" src="data:image/png;base64,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"> </figure>
                                                    </div>
                                                    <div class="item-box-blog-body">
                                                        <!--Heading-->
                                                        <div class="item-box-blog-heading">
                                                            <a href="http://jamesjoeim.pixnet.net/blog/post/264447172-%E4%B8%AD%E5%8E%9F%E5%A4%A7%E5%AD%B8%E5%AD%B8%E7%94%9F%E7%B5%90%E5%90%88%E5%B0%88%E6%A5%AD-%E6%89%93%E9%80%A0%E7%9B%B4%E6%92%AD%E7%95%8C%E8%9D%A6%E7%9A%AE"
                                                                tabindex="0">
                                                                <h5>痞客邦 - 中原大學學生結合專業 打造直播界蝦皮 </h5>
                                                            </a>
                                                        </div>
                                                        <!--Text-->
                                                        <div class="item-box-blog-text">
                                                            <p>
                                                                摘下「產學合作組」金牌的「來福狗-LIVE GO」團隊就表示，由於近年直播購物熱潮，組員們因此鎖定直播銷售市場帶來的龐大產值，開發一套完整的網頁系統用以輔助直播賣家，除了能清楚計算下訂資訊，降低出錯率，同時也能幫助賣家解決惡意棄標及衍生的消費紛爭。團隊成員陳節軒說：「我們的目標就是要打造『直播界的蝦皮』！」
                                                            </p>
                                                        </div>
                                                        <div class="mt">
                                                            <a href="http://jamesjoeim.pixnet.net/blog/post/264447172-%E4%B8%AD%E5%8E%9F%E5%A4%A7%E5%AD%B8%E5%AD%B8%E7%94%9F%E7%B5%90%E5%90%88%E5%B0%88%E6%A5%AD-%E6%89%93%E9%80%A0%E7%9B%B4%E6%92%AD%E7%95%8C%E8%9D%A6%E7%9A%AE"
                                                                tabindex="0" class="btn bg-blue-ui white read">read more</a>
                                                        </div>
                                                        <!--Read More Button-->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="item-box-blog">
                                                    <div class="item-box-blog-image">
                                                        <!--Date-->
                                                        <div class="item-box-blog-date bg-blue-ui white">
                                                            <span class="mon">2018/11/27</span>
                                                        </div>
                                                        <!--Image-->
                                                        <figure>
                                                            <img alt="大紀元-LiveGO來福狗" src="data:image/png;base64,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"> </figure>
                                                    </div>
                                                    <div class="item-box-blog-body">
                                                        <!--Heading-->
                                                        <div class="item-box-blog-heading">
                                                            <a href="http://cn.epochtimes.com/b5/18/11/28/n10878172.htm" tabindex="0">
                                                                <h5>大紀元 -開發網紅與企業媒合平台 中原學生想法實體化</h5>
                                                            </a>
                                                        </div>
                                                        <!--Text-->
                                                        <div class="item-box-blog-text">
                                                            <p>
                                                                濟部工業局、教育部資訊及科技教育司和中華民國資訊管理協會共同主辦的「大專校院資訊應用服務創新競賽」，於台大體育館舉行決賽，從868隊大專院校及高中職隊伍中遴選380組隊伍入圍，決賽總人數達2280人，中原大學資管系共有4組隊伍脫穎而出，奪下一金三銅的佳績，為校爭光！
                                                                直播熱潮正夯，中原大學資訊管理學系的學生將專業知識與創意點子結合，不但寫出網站系統將直播購物下單規則變簡單，更開發出網紅與企業的媒合平台，豐富的創意與執行力獲得今年度「大專校院資訊應用服務創新競賽」多項大獎。中原學生透過競賽賺取專業能力經驗值，更透過實作與企業充分對話，發揮學用合一、產學合作的精神。
                                                                賽主題相當多元，涵蓋物聯網、資訊安全、雲端科技、智慧零售等。學生團隊在競賽過程中除了運用資管所學與團隊合作，也要設計一套符合企業主的APP軟件程式，企業亦可從中找到科技菁英，形成優良的產學合作橋樑。
                                                                摘下「產學合作組」金牌的「來福狗-LIVE GO」團隊就表示，近年直播購物熱潮，組員們因此鎖定直播銷售市場帶來的龐大產值，開發一套完整的網頁系統用以輔助直播賣家，除了能清楚計算下訂資訊，降低出錯率，同時也能幫助賣家解決惡意棄標及衍生的消費紛爭。團隊成員陳節軒說：「我們的目標就是要打造『直播界的蝦皮』！」
                                                            </p>
                                                        </div>
                                                        <div class="mt">
                                                            <a href="http://cn.epochtimes.com/b5/18/11/28/n10878172.htm" tabindex="0" class="btn bg-blue-ui white read">read more</a>
                                                        </div>
                                                        <!--Read More Button-->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="item-box-blog">
                                                    <div class="item-box-blog-image">
                                                        <!--Date-->
                                                        <div class="item-box-blog-date bg-blue-ui white">
                                                            <span class="mon">2018/11/27</span>
                                                        </div>
                                                        <!--Image-->
                                                        <figure>
                                                            <img alt="LINE TODAY-LiveGO來福狗" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAeFBMVEUgICD///8AAACpqakcHBwxMTEMDAy8vLwaGhru7u7JyckTExMICAiLi4ubm5twcHDj4+NFRUWSkpIkJCSjo6P5+fmwsLDOzs5+fn63t7fv7+/W1tY8PDzBwcFeXl5VVVV4eHiHh4dnZ2dPT0/e3t45OTlaWlotLS2NMFVvAAAFGklEQVR4nO2Zi1KrMBCG6YJIDaK2lN60F7T1/d/wJLtJuLRWFGrnzPzfOE4KSeCDkGSTIAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD8ryRKqeimN0CGpHYkNQdikyKfCpTPJimLaper4Cojom35VB58Rls6bUnHcrRxIV9n2k9wU4RhWGxqipk+EGZa7NOcCh+Noio523sSqH1YY1Epqrx+IixKXWV6V8xGhucdsZJayNl8d6g/1XjCR7M0ULvCFTYPiOvMp30M40e+g0nsj0QrviUKojs+NSJ9MM04+aQCmo9q3JMvR7NRA10lPVU/15G5aXrzB+bvp2U/o2QjJ/mcKvnHQ5VxGMNxy3AfNwwf6hrLS4b0WP89Nm+R7mtHMlc4erVHSl3/s3+sARWc3qigBx0M1/Q7Q3pvHnijlqFXVDv/VHSD5RQ3f1rJo+kj2MVwdBd9aXihlWbNnJpt0jIcHeXtUFg9hOjTP47kRSrq19N0MdQnTwz3E6as9TSTLMtyPvmhk/kmldLz/SKbucdhDfOl7YDkAdHaXmnlX/MsiJz4Z7+xpovhB50aUszUv5A4TWlqX0Cq0zubjhW9stDYG77aIyN5QtXr1z/V0V+KP8l+/Uw3w9FLcmp4tjZb5KHW/W75g+JCs8gZ6gqfqpzSMOfOWMSWZBtpv36mo2Ge/t7whQcJaXnTyBvaXoTrifcmtZAr6YITabBSwXO/r7Cj4ZiuYCgjge59bPLFKPM4KB/wRt5lz36mo+HohQY3VAt/YfowJ1lozG2apwWFdKpR3zltN8NweMNEOpRCXycwHc2HnHrVQornNeOFr+oPDMenhhHze0M7j9FZE54ZvFFur+D6Gv5X9uxnuhhyj7BtG46Z2WvTsWGY1wxlOtownPIQoUciuYVMRpeQi07co131foUdDO/N7+WkZWi5YJiUYa45mBw6pDDpaTVa6GPOkJYmsYu57JqHj6mrv3c/08XwzbyL1ReztguGNl6UMEiiwuC8ITfHu4i4JbOSD0EO/WPn7w0feOCd/9hQPRWGO3mHJhmeNZSOZuRM3znKlm5ogH6mk6GNZ5qGHb7Dek9z4TuUnlNfT2qWmJr4JgboZ7oZZmcMh+pL5yTh0hslch2Jx2y+AV5hJ8PDOcOztf1kPJRgviCpsNhujqy6voWhD26uMqexDdJzC8N4cQVDGSN05KCagvUCf2YY0DUMJSYku9pUwWt7f27ohqdfGB5r8aGqRguSdjF3UUsFL4wMb/hoovI0jc8bKrcqeDHGbxkqH+PHJLFsPcZ/l1e4U1Z+bXDrmNcwfMjyXP9NkrOGQbpqG56u07QNA/uBzR/3eXudJrQLUs8UxWM5ZeCZ7OwzuoahxYRn5wxtuHpxre3EsMNaW6kiGYpyXtCXpnJMbmCYbL8wXF4wtOssntP10tB/ABw0SRjFs+0/N3Qr0T8yDGjRqDttr3mbSMmuGHKP64IZurZha99i3nHf4tQwoNpIcLJvsT7yo5PZxJTnf/JNzsjnG8JQ9p4cmbmL1t7T3jSg6PDt3hNTK8K37PaePs7sPXEm2bHKJMayW1BTl68YYOLt9g8tPCq29g/lKtH3+4dBq4gtti3LzYX9w+pqgd1GTKt8Qwhen5vvAQMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAC+4B95+lZnOd+GEQAAAABJRU5ErkJggg=="> </figure>
                                                    </div>
                                                    <div class="item-box-blog-body">
                                                        <!--Heading-->
                                                        <div class="item-box-blog-heading">
                                                            <a href="https://today.line.me/tw/pc/article/%E9%80%8F%E9%81%8E%E5%AF%A6%E4%BD%9C%E8%88%87%E4%BC%81%E6%A5%AD%E5%90%88%E4%BD%9C%E3%80%80%E4%B8%AD%E5%8E%9F%E5%A4%A7%E5%AD%B8%E5%AD%B8%E7%94%9F%E6%89%93%E9%80%A0%E7%9B%B4%E6%92%AD%E7%95%8C%E8%9D%A6%E7%9A%AE-ng3oyy"
                                                                tabindex="0">
                                                                <h5>LINE TODAY - 透過實作與企業合作　中原大學學生打造直播界蝦皮</h5>
                                                            </a>
                                                        </div>
                                                        <!--Text-->
                                                        <div class="item-box-blog-text">
                                                            <p>直播熱潮正夯，中原大學資訊管理學系的學生將專業知識與創意點子結合，不僅寫出網站系統將直播購物下單規則變簡單，更開發出網紅與企業的媒合平台，豐富的創意與執行力獲得今年度「大專校院資訊應用服務創新競賽」多項大獎。中原學生透過競賽賺取專業能力經驗值，更透過實作與企業充分對話，發揮學用合一、產學合作的精神。
                                                                由經濟部工業局、教育部資訊及科技教育司和中華民國資訊管理協會共同主辦的「大專校院資訊應用服務創新競賽」，11月3日大會於台大體育館舉行決賽，從868隊大專院校及高中職隊伍中遴選380組隊伍入圍，決賽總人數達2280人，場面極為盛大。中原大學資管系共有4組隊伍脫穎而出，奪下一金三銅的佳績，為校爭光！
                                                                今年的競賽主題相當多元，涵蓋物聯網、資訊安全、雲端科技、智慧零售等。學生團隊在競賽過程中除了運用資管所學與團隊合作，也要設計一套符合企業主的APP軟件程式，企業亦可從中找到科技菁英，形成優良的產學合作橋樑。摘下「產學合作組」金牌的「來福狗-LIVE
                                                                GO」團隊就表示，由於近年直播購物熱潮，組員們因此鎖定直播銷售市場帶來的龐大產值，開發一套完整的網頁系統用以輔助直播賣家，除了能清楚計算下訂資訊，降低出錯率，同時也
                                                                能幫助賣家解決惡意棄標及衍生的消費紛爭。團隊成員陳節軒說：「我們的目標就是要打造『直播界的蝦皮』！」</p>
                                                        </div>
                                                        <div class="mt">
                                                            <a href="https://today.line.me/tw/pc/article/%E9%80%8F%E9%81%8E%E5%AF%A6%E4%BD%9C%E8%88%87%E4%BC%81%E6%A5%AD%E5%90%88%E4%BD%9C%E3%80%80%E4%B8%AD%E5%8E%9F%E5%A4%A7%E5%AD%B8%E5%AD%B8%E7%94%9F%E6%89%93%E9%80%A0%E7%9B%B4%E6%92%AD%E7%95%8C%E8%9D%A6%E7%9A%AE-ng3oyy"
                                                                tabindex="0" class="btn bg-blue-ui white read">read more</a>
                                                        </div>
                                                        <!--Read More Button-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--.row-->
                                    </div>
                                    <!--.item-->
                                </div>
                                <!--.carousel-inner-->
                            </div>
                            <!--.Carousel-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- news page end -->
        <section class="pricing py-5">
            <div class="container">
                <div class="row">
                    <!-- Free Tier -->
                    <div class="col-lg-4">
                        <div class="card mb-5 mb-lg-0">
                            <div class="card-body">
                                <h3 class="text-center font-weight-bolder">初階會員</h3>
                                <h5 class="card-title text-muted text-uppercase text-center" style="text-decoration:line-through;">原價 $2000/月</h5>
                                <h6 class="card-price text-center">$0
                                    <span class="period">/月</span>
                                </h6>
                                <h6 class="pt-2 font-weight-bolder text-muted  text-center">給初次使用拍賣系統的您</h6>
                                <hr>
                                <ul class="fa-ul">
                                    <li>
                                        <span class="fa-li">
                                            <i class="icofont-disc"></i>
                                        </span>系統使用權</li>
                                    <li>
                                        <span class="fa-li">
                                            <i class="icofont-disc"></i>
                                        </span>使用手冊&教學服務</li>
                                    <li>
                                        <span class="fa-li">
                                            <i class="icofont-disc"></i>
                                        </span>會員管理</li>
                                    <li>
                                        <span class="fa-li">
                                            <i class="icofont-disc"></i>
                                        </span>封鎖惡意買家功能</li>
                                    <li>
                                        <span class="fa-li">
                                            <i class="icofont-disc"></i>
                                        </span>訂單管理功能</li>
                                    <li>
                                        <span class="fa-li">
                                            <i class="icofont-disc"></i>
                                        </span>日、月營收報表管理</li>
                                    <li>
                                        <span class="fa-li">
                                            <i class="icofont-disc"></i>
                                        </span>來福逛逛商城上架功能</li>
                                    <li class="text-muted">
                                        <span class="fa-li">
                                            <i class="icofont-disc"></i>
                                        </span>專人
                                        <strong>分析廣告、拍賣成效</strong>
                                    </li>
                                </ul>
                                <a href="https://www.facebook.com/LiveGO.com.tw/" class="btn btn-block btn-success text-uppercase">立即加入</a>
                            </div>
                        </div>
                    </div>
                    <!-- Plus Tier -->
                    <div class="col-lg-4" style="cursor: not-allowed; ">
                        <div class="card mb-5 mb-lg-0">
                            <div class="card-body">
                                <h3 class="text-center font-weight-bolder">高階會員</h3>
                                <h5 class="card-title text-muted text-uppercase text-center" style="text-decoration:line-through;">原價 $5000/月</h5>

                                <h6 class="card-price text-center">$3000
                                    <span class="period">/月</span>
                                </h6>
                                <h6 class="pt-2 font-weight-bolder text-muted  text-center">給想了解每次拍賣、廣告成效的您</h6>

                                <hr>
                                <ul class="fa-ul">
                                    <li>
                                        <span class="fa-li">
                                            <i class="icofont-disc"></i>
                                        </span>
                                        系統使用權
                                    </li>
                                    <li>
                                        <span class="fa-li">
                                            <i class="icofont-disc"></i>
                                        </span>使用手冊&教學服務</li>
                                    <li>
                                        <span class="fa-li">
                                            <i class="icofont-disc"></i>
                                        </span>會員管理</li>
                                    <li>
                                        <span class="fa-li">
                                            <i class="icofont-disc"></i>
                                        </span>封鎖惡意買家功能</li>
                                    <li>
                                        <span class="fa-li">
                                            <i class="icofont-disc"></i>
                                        </span>訂單管理功能</li>
                                    <li>
                                        <span class="fa-li">
                                            <i class="icofont-disc"></i>
                                        </span>日、月營收報表管理</li>
                                    <li>
                                        <span class="fa-li">
                                            <i class="icofont-disc"></i>
                                        </span>來福逛逛商城上架功能</li>
                                    <li>
                                        <span class="fa-li">
                                            <i class="icofont-disc"></i>
                                        </span>專人
                                        <strong>分析廣告、拍賣成效</strong>
                                    </li>
                                </ul>
                                <a href="#" class="btn btn-block btn-secondary text-uppercase disabled">尚未開放敬請期待</a>
                            </div>
                        </div>
                    </div>
                    <!-- Pro Tier -->
                    <div class="col-lg-4" style="cursor: not-allowed; ">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="text-center font-weight-bolder">特約會員</h3>
                                <h5 class="card-title text-muted text-uppercase text-center" style="text-decoration:line-through;">原價 $10000/月</h5>
                                <h6 class="card-price text-center">$9000
                                    <span class="period">/月</span>
                                </h6>
                                <h6 class="pt-2 font-weight-bolder text-muted  text-center">請與客服聯絡</h6>
                                <hr>
                                <ul class="fa-ul">
                                    <li>
                                        <span class="fa-li">
                                            <i class="icofont-disc"></i>
                                        </span>
                                        <strong>擁有高階會員權限</strong>
                                    </li>
                                    <li>
                                        <span class="fa-li">
                                            <i class="icofont-disc"></i>
                                        </span>
                                        使用手冊&教學服務
                                    </li>
                                    <li>
                                        <span class="fa-li">
                                            <i class="icofont-disc"></i>
                                        </span>
                                        專人服務
                                    </li>
                                    <li>
                                        <span class="fa-li">
                                            <i class="icofont-disc"></i>
                                        </span>
                                        系統進階功能
                                    </li>
                                    <li class="">
                                        <span class="fa-li">
                                            <i class="icofont-disc"></i>
                                        </span>
                                        搶先體驗最新功能
                                    </li>
                                    <li class="invisible">
                                        <span class="fa-li">
                                            <i class="icofont-disc"></i>
                                        </span>
                                    </li>
                                    <li class="invisible">
                                        <span class="fa-li">
                                            <i class="icofont-disc"></i>
                                        </span>
                                    </li>
                                    <li class="invisible">
                                        <span class="fa-li ">
                                            <i class="icofont-disc"></i>
                                        </span>
                                    </li>
                                </ul>
                                <a href="#" class="btn btn-block btn-secondary text-uppercase disabled">尚未開放敬請期待</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Step_page -->
        <div id="Step_page">
            <div class="container">
                <h2 class="text-center">申請流程步驟</h2>
                <h3 class="text-center mb-5">簡單四步驟</h3>
                <div class="row">
                    <div class="col-md-3">
                        <div class="card shadow step">
                            <div class="card-body">
                                <div class="d-block">
                                    <H2>
                                        <small>STEP 1</small>
                                    </H2>
                                    <i class="icofont-tasks foont-size-5rem"></i>
                                </div>
                                <div class="d-block pb-2">
                                    <h3>聯絡臉書粉絲團</h3>
                                </div>
                                <div class="d-block">
                                    <P>與粉絲專業聯絡。</P>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card shadow step">
                            <div class="card-body">
                                <div class="d-block">
                                    <H2>
                                        <small>STEP 2</small>
                                    </H2>
                                    <i class="icofont-bulb-alt foont-size-5rem"></i>
                                </div>
                                <div class="d-block pb-2">
                                    <h3>等待回復</h3>
                                </div>
                                <div class="d-block">
                                    <P>耐心等待LiveGO與您主動聯繫。</P>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card shadow step">
                            <div class="card-body">
                                <div class="d-block">
                                    <H2>
                                        <small>STEP 3</small>
                                    </H2>
                                    <i class="icofont-ui-copy foont-size-5rem"></i>
                                </div>
                                <div class="d-block pb-2">
                                    <h3>選擇方案</h3>
                                </div>
                                <div class="d-block">
                                    <P>選擇對您最適合的方案後即可送出！</P>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card shadow step">
                            <div class="card-body">
                                <div class="d-block pb-2">
                                    <H2>
                                        <small>STEP 4</small>
                                    </H2>
                                    <i class="icofont-verification-check foont-size-5rem"></i>
                                </div>
                                <div class="d-block">
                                    <h3>開通完成</h3>
                                </div>
                                <div class="d-block">
                                    <P>付款後即可開始使用LiveGO!</P>
                                </div>
                            </div>
                        </div>
                        <div class="foot_print mt-4">
                            <i class="icofont-hen-tracks rotate-60 first_foot invisible"></i>
                            <i class="icofont-hen-tracks rotate-120  second_foot invisible"></i>
                            <i class="icofont-hen-tracks rotate-60 third_foot invisible"></i>
                            <i class="icofont-hen-tracks rotate-120 fourth_foot invisible"></i>
                            <i class="icofont-hen-tracks rotate-60 fifth_foot invisible"></i>
                            <i class="icofont-hen-tracks rotate-120 sixth_foot invisible"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Step_page end -->
        <!-- footer_page  -->
        <div id="footer_page">
            <div class="container">
                <div class="row">

                    <div class="col-md-12 text-center text-white">

                        <small>phone : 0966590309</small>
                        <br>
                        <small>地址 : 桃園縣中壢區新中北路230號</small>
                        <br>
                        <small>E-mail : jerrychen.livego@gamil.com</small>
                        <br>
                        <small>© 2018 by galeedondon. Proudly created with LiveGO.</small>
                    </div>
                </div>
            </div>
        </div>
        <!-- footer_page end -->
    </div>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });

        $( ".xs_watch_video" ).click(function() {
            $('html, body').animate({
                scrollTop: $("#monitorscreen").offset().top
            }, 500);
        });
        $( ".mydiv" ).click(function() {
            $('html, body').animate({
                scrollTop: $("#monitorscreen").offset().top
            }, 500);
        });
    </script>

    <script defer src="js_home/main.js"></script>
    <script src="js_home/video.js"></script>
    <script src="js_home/background_circle.js"></script>

</body>

</html>