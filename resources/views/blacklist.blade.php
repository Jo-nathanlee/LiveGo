@extends('layouts.master')

@section('title','Live GO 棄標黑名單')
@section('heads')
    <!-- datatable + bootstrap 4  -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
   
@stop

@section('wrapper')
<div class="wrapper">
    <div id="sidebar_page"></div>
@stop
@section('navbar')
    <!-- Page Content  -->
    <div id="content">
        <div id="navbar_page"></div>
        <!--Nav bar end-->
@stop
@section('content')
        <div id="blacklist" class="container-fluid main">
            <div class="row">
                <div class="col-md-12">  
                    <h2 class="col-md-12">黑名單列表<hr></h2>
                    <!-- 狀態列 -->
                    <!-- <div id="order_st_nav" class="container-fluid st_nav">
                        <div class="row">
                            <div class="col-md-12">
                                <nav class="nav nav-tabs">
                                    <a class="nav-link" href="#!">全部</a>
                                    <a class="nav-link" href="#!">未付款</a>
                                    <a class="nav-link" href="#!">等待出貨</a>
                                    <a class="nav-link" href="#!">運送中</a>
                                    <a class="nav-link" href="#!">已完成</a>
                                    <a class="nav-link" href="#!">已取消</a>
                                    <a class="nav-link" href="#!">退換貨</a>
                                    <div id="order_st_nav_bar_hover"></div>
                                    跑條動畫 想寫再寫
                                </nav>
                            </div>
                        </div>
                    </div> -->
                    
                    <!-- 手機板狀態列 -->
                    <!-- <div id="order_st_nav_md" class="container-fluid st_nav_md">
                        <div class="row">
                            <div class="col-md-12">
                                <a id="order_st_nav_md_picker" class="btn-block btn st_nav_md_picker" data-toggle="collapse" data-target="#order_st_nav_md_list" aria-expanded="false" aria-controls="order_st_nav_md_list">訂單狀態</a>
                                <div id="order_st_nav_md_list" class="collapse multi-collapse st_nav_md_list">
                                    <nav class="nav flex-column">
                                        <a class="btn btn-block btn-light" href="#!">全部</a>
                                        <a class="btn btn-block btn-light" href="#!">未付款</a>
                                        <a class="btn btn-block btn-light" href="#!">等待出貨</a>
                                        <a class="btn btn-block btn-light" href="#!">運送中</a>
                                        <a class="btn btn-block btn-light" href="#!">已完成</a>
                                        <a class="btn btn-block btn-light" href="#!">已取消</a>
                                        <a class="btn btn-block btn-light" href="#!">退換貨</a>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <!-- 手機板狀態列end -->
                    <!-- 狀態列end -->
                    <!-- 搜尋 先隱藏-->
                    <div class="container-fluid main" style="display: none;">
                            <div class="row">
                                <div id="blacklist_search" class="col-10 col-md-10 -secondary form-group search">
                                    <div class="input-group mb-2 mr-sm-2">
                                        <input class="form-control" type="text" placeholder="黑名單搜尋 ex:黃文怡">
                                        <div class="input-group-append">
                                            <div class="input-group-text btn">
                                                <i class="icofont icofont-search"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- 進階搜尋 -->
                                <div class="col-2 col-md-2 ">
                                    <button id="blacklist_search_adv_btn" type="button"  class="btn btn-block btn-outline-secondary search_adv_btn" data-toggle="collapse" data-target="#blacklist_search_adv" aria-expanded="false" aria-controls="blacklist_search_adv"><i class="icofont icofont-align-right"></i></button>
                                </div>
                                <!-- 選項 -->
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class=" col-md-12">
                                            <div id="blacklist_search_adv" class="collapse multi-collapse">
                                                <div id="blacklist_search_adv_list" class="search_adv_list">
                                                    <!-- 進階搜尋 -->
                                                    <div class="alert alert-secondary" role="alert">
                                                        <div class="form-inline">
                                                            <label for="列入日期" class="col-sm-1 col-form-label"><strong>最後列入日期</strong></label>
                                                                <div class="form-group">
                                                                    <div class="input-group date" id="datetimepicker_form" data-target-input="nearest">
                                                                        <input type="text" class="form-control form-control-sm datetimepicker-input" data-target="#datetimepicker_form" value=""
                                                                        />
                                                                        <div class="input-group-append" data-target="#datetimepicker_form" data-toggle="datetimepicker">
                                                                            <div class="input-group-text">
                                                                                <i class="fa fa-calendar"></i>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="input-group date" id="datetimepicker_to" data-target-input="nearest">
                                                                        <input type="text" class="form-control form-control-sm datetimepicker-input" data-target="#datetimepicker_to" value="" />
                                                                        <div class="input-group-append" data-target="#datetimepicker_to" data-toggle="datetimepicker">
                                                                            <div class="input-group-text">
                                                                                <i class="fa fa-calendar"></i>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <br><br>
                                                        </div>
                                                        <div class="form-inline">
                                                            <label for="會員編號" class="col-sm-1 col-form-label"><strong>會員編號</strong></label>
                                                            <input class="form-control form-control-sm" type="text" name="" id="">
                                                            <br><br>
                                                        </div>
                                                        <div class="form-inline">
                                                            <label for="事由" class="col-1 col-form-label"><strong>事由</strong></label>
                                                            <!-- <input class="form-control form-control-sm" type="text" name="" id=""> -->
                                                            <select class="custom-select form-control-sm">
                                                                <option selected>洗頻</option>
                                                                <option value="1">惡意棄單</option>
                                                                <option value="2">性騷擾</option>
                                                                <option value="2">黃文怡</option>
                                                            </select>
                                                            <br><br>
                                                        </div>
                                                        
                                                        <div class="form-inline">
                                                            <label for="?" class="col-1 col-form-label"><strong>?</strong></label>
                                                            <input class="form-control form-control-sm" type="text" name="" id="">
                                                            <br><br>
                                                        </div>
                                                        <!-- <div class="container-fluid">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <button class="btn btn-block btn-light">送出</button>
                                                                </div>
                                                            </div>
                                                        </div> -->
                                                        
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <!-- 選項end -->
                                <!-- 進階搜尋end -->
                            </div>
                    </div>
                    <!-- 搜尋end -->
                    <!-- 訂單列表 -->
                    <div id="blacklist_list" class="container-fluid">
                        <div class="row">
                            <div  class="col-md-12">
                                <table id="table_source" class="table" >
                                    <thead>
                                        <tr>
                                            <th>黑名單大頭貼</th>
                                            <th>會員編號</th>
                                            <th>姓名</th>
                                            <th>首次列入時間</th>
                                            <th>最後列入時間</th>
                                            <th>事由</th>
                                            <th>列入次數</th>
                                            <th>狀態</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr id="blacklist_item">
                                            <td scope="row">
                                                <img id="blacklist_img" src="img/livego.png" class="img-fluid img" alt="Responsive image">
                                            </td>
                                            <td>10344250</td>
                                            <td>黃文怡</td>
                                            <td>2017-10-27-22:00:27</td>
                                            <td>2018-08-07-19:50:51</td>
                                            <td>噁男</td>
                                            <td>12次</td>
                                            <td>列入</td>
                                            <td><button class="btn btn-light">解除</button></td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                                <!-- 頁碼 -->
                                <span id="list_table_page" class="list_table_page"></span>
                                <!-- 頁碼end -->
                            </div>   
                        </div>
                    </div>
                    <!-- 訂單列表end -->
                </div>
            </div>        
        </div>
        <!-- main end -->
    </div>
    <!-- Cotent end-->
</div>
@stop

@section('footer')
    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <!-- My JS -->
    <script src="js/Live_go.js" ></script>
    <!-- 我新增的JS -->
    <script src="js/list_mgnt.js"></script>
    <!-- <script src="js/jquery-tablepage-1.0.js"></script> -->
    <!-- <script src="js/moment.js"></script> -->
    <!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js"></script> -->
    <!-- DataTable + Bootstrap 4  cdn引用-->
    <script defer src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script defer src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
@stop            