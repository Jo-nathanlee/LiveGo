@extends('layouts.master_home')

@section('title','Live GO')

@section('content')      
    <!-- 開場動畫 -->
    <div id="LoadingDIv" class="d-none d-sm-none d-md-block">
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
            <img src="img_home/logo.png">
        </div>

        <hr class="lineAnimation">
    </div>
    <div id="Loading_sm" class="d-block d-sm-block d-md-none d-lg-none d-xl-none">
        <div id="dog_animation">
            <img src="img_home/dog.gif">
            <font> LiveGO</font>
        </div>
        <hr class="lineAnimation">
    </div>
    <div class="curtain-panel">
        <div class="top-curtain curtain" data-title="Click to reveal a special reward..."></div>
        <div class="bottom-curtain curtain" data-title="Click to reveal a special reward..."></div>
    </div>
    <!-- 開場動畫結束 -->
    <div id="main">
        <!-- navbar -->
        <nav class="navbar navbar-expand-md navbar-fixed-top navbar-dark bg-dark ">
            <div class="container">
                <div class="navbar-collapse collapse nav-content order-2">
                    <ul class="nav navbar-nav">
                        <li class="nav-item mr-3">
                            <i class="icofont-facebook-messenger"></i>
                        </li>
                        <li class="nav-item mr-3">
                            <i class="icofont-instagram"></i>
                        </li>
                        <li class="nav-item">
                            <i class="icofont-line-messenger"></i>
                        </li>
                    </ul>
                </div>
                <ul class="nav navbar-nav text-nowrap flex-row mx-md-auto order-1 order-md-2">
                    <li class="nav-item ">
                        <a class="nav-link" href="#">LiveGO</a>
                    </li>
                </ul>
                <div class="ml-auto navbar-collapse collapse nav-content order-3 order-md-3">
                    <ul class="ml-auto nav navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="#">直播電商智慧小幫手</a>
                        </li>
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
                    <a>LiveGO
                        <span class="ml-4 d-block">
                            <small>來福狗</small>
                        </span>
                    </a>
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
        <!-- feature page -->
        <div id="HelpUs_page">
            <div class="title">
                <h2>LiveGO 能幫助我什麼?</h2>
                <h3>我們能當您專屬直播店商智慧小幫手</h3>
            </div>
            <div class="container">
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
            </div>

        </div>
        <!-- feature page end -->
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
                            <button type="button" class="btn btn-outline-secondary buttom_position w-50 col-sm-12 sm-mt-2">加入我們!! </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- GrowingUp_page end-->
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
                                    <h3>填寫表單</h3>
                                </div>
                                <div class="d-block">
                                    <P>填寫您的資料，以便LiveGO能聯繫您。</P>
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
@stop
@section('footer')  
        <!-- footer_page  -->
        <div id="footer_page">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-white display-6 text-center mb-2 mt-4">
                        <div class="d-inline">
                            <i class="icofont-facebook-messenger"></i>
                        </div>
                        <div class="d-inline ml-2">
                            <i class="icofont-instagram"></i>
                        </div>
                        <div class="d-inline ml-2">
                            <i class="icofont-line-messenger"></i>
                        </div>
                    </div>
                    <div class="col-md-12 text-center text-white">

                        <small>phone : 0966590309</small>
                        <br>
                        <small>地址 : 桃園縣中壢區新中北路230號</small>
                        <br>
                        <small>E-mail : p0981735388@gamil.com</small>
                        <br>
                        <small>© 2018 by galeedondon. Proudly created with LiveGO.</small>
                    </div>
                </div>
            </div>
        </div>
        <!-- footer_page end -->
    </div>
    <script defer src="js_home/main.js"></script>
    <script src="js_home/video.js"></script>
    <script src="js_home/background_circle.js"></script>
@stop
