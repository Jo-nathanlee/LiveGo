@extends('layouts.master_shop')

@section('title','購物車')

@section('head_extension')

<style>
	ul.multiselect-container {
		width: 100% !important;
		}

	.dropdown-menu {width:100% !important;}

    .cart_S1{
	height: auto;
	background-color: #eeeeee;
	padding: 1.5rem;
	border-radius: 15px;
	}
	.cart_S1_top{
		width: 100%;
		height: 60px;
		background-color: #FFFFFF;
		border-radius: 15px;
		text-align: justify;
		text-align-last: justify;  	
		line-height: 60px;
		padding: 0px 20px 0px 20px;
		color: #726e6f;
	}
	.cart_S1_top div{
		width: auto;
		height: 100%;
		/*background-color: red;*/
		display: inline-block;
		font-size: 1.2rem;
	}
	.cart_S1_top_ck_all{
		margin-left:35px;
		color:#cacaca;
	}
	.cart_S1_box{
		background-color: #FFFFFF;
		margin-top:25px;
		border-radius: 15px;
	}

	.S1_bor_dv{
		width:auto;
		height: 5rem;
		/*background-color: blue;*/
		display: inline-block;
		vertical-align: top;
		text-align-last:auto;
		letter-spacing: 2px;
		font-weight: 400;
		font-size: 1.2rem;
		word-break: break-all;
		/*width: calc(100%/6);*/
		text-align: center;
		/*border-style: solid;*/
	}
	.S1_bor_dv_W{
		width:auto;
		height: 5rem;
		/*background-color: blue;*/
		display: inline-block;
		vertical-align: top;
		text-align-last:auto;
		letter-spacing: 2px;
		font-weight: 400;
		font-size: 1.3rem;
		word-break: break-all;
		word-break: break-all;
		height: auto;
		text-align: left;
	}
	.cart_ck_label{
		position: absolute;
	}
	.cart_ck_box{
		width: 17px !important;
		height: 17px !important;
		margin-top: 2rem;
		position: relative;
		border-style: solid;
		border-width: 1px;
		cursor: pointer;
	}
	.cart_ck_box img{
		width: 130%;
		height: 150%;
		margin-top: -7px;
		margin-left: 3px;
		display: none;
	}
	.cart_goods_img{
		height:5rem;
		width:5rem;
		background: url('../img/goods.jpg') no-repeat center;
		background-size: 100% auto;
		background-position: center center;
		display: inline-block;
		margin-left: 0px !important;
		margin-right: 10px;
	}
	.cart_goods_sm_W{
		font-size: .75rem;
		letter-spacing:.5px;
		margin-top: .7rem;
	}
	.cart_goods_name{
		font-size: 1.5rem;
	}
	.cart_goods_name svg{
		color: #1464ff;
		font-size: 1.3rem;
	}
	.LIVE_i{
		font-size: .5rem;
		border-style: solid;
		border-radius: 3px;
		width: auto;
		display: inline-block;
		letter-spacing:0px;
		margin-right: 5px;
		vertical-align: inherit;
		padding: 0px 2px 0px 2px;
		border-width: 1.5px;
		font-weight: bold;
	}
	.cart_goods_key{
		display: inline-block;
		color: #616161;
	}
	.cart_goods_key div{
		background-color: #626262;
		color: #FFFFFF;
		display: inline-block;
		padding: 0px 5px 0px 5px;
		border-radius: 10px;
	}
	.cart_goods_Q{
		font-weight: bold;
		line-height: 6rem;
		/*width:calc(100%/7);*/
		/*margin-right: 70px;*/
	}
	.cart_goods_Q span{
		font-weight: 400;
	}
	.cart_goods_M{
		font-weight:bolder;
		line-height: 6rem;
		letter-spacing:1px;
		/*width:calc(100%/5);*/
	}
	.cart_goods_K{
		/*width:calc(100%/4.8);*/
		text-align: left;
	}
	.cart_goods_N{
		/*width:9%;*/
	}
	.cart_gooda_k_box{
		display: inline-block;
		border-style: solid;
		border-width: 1px;
		padding: 2px 5px;
		font-size: 12px;
		cursor: pointer;
		position: relative;
		padding-right: 0;
		border-radius: 7px;
		margin-top: 2rem;

	}
	.cart_cg_num{
		display: inline-block;
		font-size: 1rem;
		float: right;
		color: #737373;
		margin-top:2rem;

	}
	.cart_cg_num .form-control{
		width:70px;
		height: 30px;
		border-width: 1.5px;
		border-color: #aeaeae;
		color: #737373;
		background-color: #FFFFFF;
		border-radius: 8px;
		float: right;
	}
	.cart_goods_fx{
		/*width: calc(100%/2.8);*/
		text-align: inherit;
	}
	.cart_goods_sm_W svg{
		font-size: 1rem;
		margin-right: 5px;
	}
	.cart_gooda_k_box .op_goods_i{
		height: auto;
		margin-top: -3px;
		margin-bottom: -5px;
		padding: 3px 5px;
	}
	.S1_bor .re_goods{
		font-size: large;
		right: 10px;
		top: 5px;
	}
	.cart_gooda_total{
		text-align: right;
		font-size: 1.3rem;
		border-style: none;
		padding: 1rem;
	}
	.cart_gooda_total span{
		font-size: 1.7rem;
	}
	.tooltip-inner{
	max-width: 300px !important;
	font-size: .8rem;
	text-align: left !important;
	font-family: 微軟正黑體;
	letter-spacing: 2px;
	}

	.cart_S2_box{
		background-color: #FFFFFF;
		border-radius: 15px;
		height: auto;
		width: 100%;
		margin-top: 2rem;
	}
	.cart_S2_bor{
		border-bottom-style: solid;
		padding: 1rem 1.5rem 1rem 1.5rem;
		border-color: #e3e3e3;
		border-width: 1.5px;
	}
	.cart_S2_bor label{
		margin-bottom: 0;
	}
	.cart_how_ck_box{
		background-color: #FFFFFF;
		border-style: dashed;
		border-color: #737373;
		color:  #737373;
		border-width: 1.3px;
		border-radius: 5px;
		padding: 2px 20px 2px 20px;
		cursor: pointer;
		display: inline-block;
		margin-left: 10px;
	}
	.cart_how_ck_box_K{
		background-color: #393939;
		border-color: #FFFFFF;
		color:  #FFFFFF;
	}
	.cart_ck_how_label{
		position: relative;
		margin-bottom: 0;
	}
	.cart_time{
		display: inline-block;
		float: right;
		margin-top: 5px;
	}
	.cart_time span{
		font-weight: 400;
	}
	.cart_wh_img{
		height:auto;
		width:1.1rem;
		background-repeat:no-repeat !important;
		background-size:100% !important;
		background-position: center center;
		display: inline-block;
		margin-left: 20px;
		vertical-align: middle;
	}
	.cart_S2_bor div input[type="radio"]+ div::before{
		content: "\a0"; 
		display: inline-block;
		vertical-align: middle;
		font-size: 18px;
		width: .7em;
		height: .7em;
		margin-right: .4em;
		border-radius: 50%;
		border: 1px solid #737373;
		text-indent: .15em;
		margin-top: -.3rem;
		margin-left: -17px;
	}
	.cart_S2_bor div input[type="radio"]:checked + div::before {
		background-color: #606060;
		background-clip: content-box;
		padding: .1em;
	}

	.cart_S2_bor div label{
		margin-right: 15px;
	}
	.cart_S2_bor_L{
		width: 50%;
		color: #606060;
		padding: 1rem 1.5rem 1rem 1.5rem;
		display: inline-block;
		font-size: 1rem;
		border-right-style: solid;
		border-width: 1px;
		border-color: #e3e3e3;
	}
	.cart_S2_wh_box{
		font-size: .8rem;
		display: inline-block;
		white-space:nowrap;
	}
	.cart_S2_data_box input[type="text"]{
		border-radius: 5px;
		border-style: solid;
		padding: 5px 10px 5px 10px;
		border-color: #a6a6a6;
		border-width: 1px;
		height: 80%;
		margin-left: 5px;
		width: 30%;
		font-size: .8rem;
	}
	.cart_S2_data_box input[type="text"]:nth-child(1){
		width: 60%;
	}
	.cart_S2_data_box{
		margin-top: 5px;
		letter-spacing: 1px;
		line-height: 30px;
	}
	.cart_S2_data_box u{
		display: inline-block;
	}
	.cart_S2_bor_R{
		width: 50%;
		color: #606060;
		padding: 1rem 1.5rem 1rem 1.5rem;
		display: inline-block;
		font-size: 1rem;
		vertical-align: top;
	}
	.cart_S2_bor_R div{
		vertical-align: top;
		display: inline-block;
	}
	.cart_S2_bor_R textarea{
		vertical-align: top;
		display: inline-block;
		margin-left: 10px;
		border-radius: 8px;
		width:75%;
		height:92px;
		resize:none;
		font-size: .8rem;
		padding: .3rem;
		border-style: solid;
	}
	.cart_pay_ck_box{
		background-color: #FFFFFF;
		border-style: dashed;
		border-color: #737373;
		color:  #737373;
		border-width: 1.3px;
		border-radius: 5px;
		padding: 2px 20px 2px 20px;
		cursor: pointer;
		display: inline-block;
		margin-left: 10px;
	}
	.cart_pay_ck_box_K{
		background-color: #393939;
		border-color: #FFFFFF;
		color:  #FFFFFF;
	}
	.cart_S3_box_total_w{
		font-size: 1.2rem;
		color: #726e6d;
		letter-spacing: 1px;
		display: inline-block;
		margin-top:10px;
	}
	.cart_S3_box_total_w span{
		font-size: 1.5rem;
		color: #393939;
	}
	.cart_S3_box_total{
		display: inline-block;
		color: #3a3839;
		background-color: #fff100;
		padding: 0px 10px 0px 10px;
		border-radius: 8px;
	}
	.cart_S3_box{
		margin-top: 100px;
		text-align: right;
		height: 60px;
	}
	.cart_S3_box_btn{
		height: 100%;
		vertical-align: top;
		border-radius: 0;
		width: 130px;
		background-color: #393939;
		border-top-right-radius: 15px;
		border-bottom-right-radius: 15px;
		color: #FFFFFF;
		font-size: 1.4rem;
		font-family: 微軟正黑體;
		line-height: 45px;
		margin-left: 20px;
	}
	.cart_S3_box label{
		display: initial;
		margin-bottom: 0;
	}
	.cart_S3_box_btn svg{
		margin-right: 10px;
	}
	.cart_table .collapsing{
		transition:none;
	}
	.cart_nav td:first-child{
	border-top-left-radius: 10px;
	border-bottom-left-radius: 10px;
	text-align: left !important;
	}

	.cart_nav td:last-child{
	border-top-right-radius: 10px;
	border-bottom-right-radius: 10px;
	/* text-align: right !important; */
	white-space:nowrap;
	}
	.cart_table td{
		position: relative;
		padding: 10px 0px;
	}
	.cart_table td:nth-child(1){
		padding-left: 1rem;
		width: auto;
		min-width:  450px;
	}
	.cart_table td:nth-child(2){
		text-align: center;
		min-width: 80px;
	}
	.cart_table td:nth-child(3){
		min-width: 130px;
	}
	.cart_table td:nth-child(4){
		width: auto;
		min-width: 70px;
	}
	.cart_table td:nth-child(5){
		text-align:right;
		min-width: 75px;
		padding-right: 1rem;
	}
	.cart_nav td{
		height: 55px;
		text-align: center !important;
		font-size: 1.1rem;
	}
	td .re_goods{
		right: 10px;
		top: 0px;
	}
	.cart_S2_data_box .address{
		display: inline-block;
	}
	.cart_S2_data_box .name{
		display: inline-block;
	}
	.cart_S2_wh_box .shop{
		display: inline-block;
	}
	.cart_S2_bor .tt{
		font-size: 1.2rem;
		margin-right: 10px;
	}
	.nav_t_good{
		margin-left: 130px;
	}
	.cart_table tr{
		border-bottom-style: solid;
		border-color: #dadada;
		border-width: 1.5px;
	}
	.cart_table tr:nth-child(1){
		border-style: none;
	}
	/*第一欄第三列：左上*/
	.cart_table tr:nth-child(3) td:first-child{
	border-top-left-radius: 10px;
	}
	/*第一欄最後列：左下*/
	.cart_table tr:last-child td:first-child{
	border-bottom-left-radius: 10px;
	}
	/*最後欄第三列：右上*/
	.cart_table tr:nth-child(3) td:last-child{
	border-top-right-radius: 10px;
	}
	/*最後欄第一列：右下*/
	.cart_table tr:last-child td:last-child{
	border-bottom-right-radius: 10px;
	}
	@media (max-width: 1460px){
		.cart_S2_data_box .address,.cart_S2_data_box .name{
			width: 100%;
		}
	}
	@media (max-width: 1340px){
		.product_S span{
			display: none;
		}
		.cart_table td:nth-child(3){
			text-align: center;
		}
		.cart_gooda_k_box{
			border-style: none;
		}
		.cart_gooda_k_box .op_goods_i {
			background-color: #FFFFFF;
			color: #000000;
			font-size: 1.5rem;
		}
		.cart_gooda_k_box .op_goods_i{
			margin-top: -1rem;
			margin-left: -5px;
		}
	}
	@media (max-width: 1220px){
		.cart_nav td{
			font-size: 1rem;
		}
		.S1_bor_dv {
			font-size: 1rem;
		}
		.cart_goods_name {
			font-size: 1.3rem;
		}
		.cart_table td:nth-child(1){
			min-width: 370px;
		}
		/* .cart_table td:nth-child(3) {
			min-width: 110px;
		} */
		.cart_S1,.navbar{
			min-width: 770px;
		}
		.cart_S2_data_box .cg{
			margin-left: 80px;
		}
		
	}
	@media (max-width: 1100px){
		.cart_goods_img {
			height: 4rem;
			width: 4rem;
		}
		.S1_bor_dv{
			height: 4rem;
		}
		.cart_goods_name{
			font-size: 1rem;
		}
		.cart_goods_sm_W{
			font-size: .5rem;
		}
		.cart_goods_name svg{
			font-size: 1rem;
		}
		.cart_nav td{
			font-size: .9rem;
		}
		.S1_bor_dv {
			font-size: .9rem;
		}
		.cart_cg_num .form-control{
			width: 60px;
			font-size: .8rem;
		}
		.cart_table td:nth-child(1){
			min-width: 320px;
		}
		/* .cart_table td:nth-child(3) {
			min-width: 100px;
		} */
		.cart_S1, .navbar {
			min-width: 700px; 
		}
		.cart_time {
			font-size: .9rem;
		}
		.cart_S2_bor .tt{
			font-size: 1rem;
		}
		.cart_how_ck_box{
			font-size: .8rem;
			padding: 2px 15px;
		}
		.cart_S2_wh_box .shop{
			display: block;
			margin-top: 10px;
		}
		.cart_S2_wh_box{
			text-align: justify;
			text-align-last: justify;
		}
		.cart_S2_bor_R textarea{
			width: 70%;
		}
		.cart_pay_ck_box{
			font-size: .8rem;
			padding: 2px 15px;
		}
		.cart_gooda_total{
			font-size: 1rem;
		}
		.cart_gooda_total span {
			font-size: 1.2rem;
		}
		.cart_S3_box_total_w{
			font-size: 1rem;
			margin-top: 5px;
		}
		.cart_S3_box_btn{
			font-size: 1.3rem;
			line-height: 40px;
		}
		.cart_S3_box{
			height: 50px;
		}
	}
	@media (max-width: 600px){
		.cart_table td:nth-child(2) {
			display: none;
		}
		#content{
			padding: 20px 0px;
		}
		.cart_goods_img {
			height: 3rem;
			width: 3rem;
		}
		.cart_ck_box {
			margin-top: 1rem;
		}
		.S1_bor_dv {
			height: 3rem;
		}
		.cart_S1{
			padding:1rem; 
		}
		.cart_table td:nth-child(1) {
			padding-left: .5rem;
			min-width: 165px;
		}
		.cart_goods_img{
			margin-left: 28px;
			margin-right:5px;
		}
		.cart_goods_M {
			line-height: 4.5rem;
		}
		.cart_gooda_k_box .op_goods_i{
			height: 0px;
		}
		.cart_gooda_k_box {
			margin-top: 1.5rem;
		}
		.cart_cg_num{
			margin-top: 1.2rem;
		}
		.cart_goods_name,.cart_goods_name svg {
			font-size: .5rem;
		}
		.cart_goods_key{
			display: none;
		}
		.nav_t_good{
			margin-left: 20px;
		}
		.cart_S1, .navbar {
			min-width:360px;
		}
		.S1_bor_dv {
			font-size: .7rem;
		}
		.cart_table td:nth-child(3) {
			min-width: 70px;
		}
		.product_S b {
			font-size: 10px;
		}
		.cart_gooda_k_box .op_goods_i{
			font-size: 1rem;
			margin-left: -10px;
		}
		.cart_table td:nth-child(4) {
			min-width: 40px;
		}
		.form-control{
			padding: .2rem;
		}
		.cart_cg_num .form-control {
			width: 40px;
			font-size: .7rem;
		}
		.cart_table td:nth-child(5) {
			text-align: left;
			padding-right: 5px;
			min-width: 0px;
		}
		.cart_goods_name,.cart_goods_sm_W{
			overflow: hidden;
			text-overflow: ellipsis;
			white-space: nowrap;
			width: 80px;
		}
		.S1_bor_dv{
			overflow: hidden;
			text-overflow: ellipsis;
			white-space: nowrap;
		}
		.cart_nav td {
			font-size: .7rem;
			height: 40px;
		}
		.cart_nav td:last-child{
			text-align: left !important;
			padding-right: 5px;
		}
		.td .re_goods{
			margin-top: -10px;
		}
		.cart_time{
			float: none;
			font-size: .7rem;
			margin-top: 10px;
		}
		.cart_S2_bor {
			padding: .7rem 1.5rem;
		}
		.cart_S2_bor_L{
			width: 100%;
			border-style: none;
		}
		.cart_S2_bor_R{
			width: 100%;
			display: block;
		}
		.cart_S3_box_total_w ,.cart_gooda_total{
			font-size: .8rem;
		}
		.cart_S3_box_total_w span {
			font-size: 1.2rem;
		}
		.cart_gooda_total{
			padding: .5rem 1rem;
		}
		.cart_S3_box{
			margin-top: 2rem;
			height: 40px;
		}
		.cart_S3_box_btn{
			font-size: 1rem;
			width: 90px;
			line-height: 25px;
		}
	}	    
</style>
<link rel="stylesheet" href="css/bootstrap-select.min.css">
<script src="js/bootstrap-select.min.js"></script>
@stop

@section('wrapper')
<div class="wrapper">
@stop
@section('navbar')
    <div id="content" class="active">
@stop

        @section('content')

            <div class="col-sm-12 cart_S1">
                <table class="cart_table" border="0" style="width: 100%;">
                    <tr class="cart_nav">
                        <td>
                            <div>
                                <label for="cart_ck0" class=" cart_ck_label">
                                    <input type="checkbox" name="cart_ck0" id="cart_ck0" value="" style="display:none;"
                                        onclick="cart_ck(this,0)">
                                    <div class="cart_ck_box cart_ck_box0 " style="margin-top: .3rem;"><img
                                            src="img/tick.png" alt="tick"></div>
                                </label>
                                <span class="cart_S1_top_ck_all">全選</span> <span class="nav_t_good">商品</span>
                            </div>
						</td>
						
                        <td class="d-none">
                            <div>庫存量</div>
                        </td>
                        <td>
                            <div>單價</div>
						</td>
                        <td>
                            <div>規格</div>
                        </td>
                        <td class="text-center">
                            <div>購買數量</div>
                        </td>
                    </tr>

                    <tr style="height: 1rem;">
                    </tr>
                    @foreach ($orders as $order)
                        
                            <tr>
                                <!-- 一個商品 開始 -->
                                <td>
                                    <span class="or_ck_label" style="top:1.5rem">
                                        <input id="order_ck{{$order['product_id']}}" name="sel_cart" total="{{ $order['goods_num']*$order['bid_price'] }}" goods_num='{{$order['goods_num']}}'  type="checkbox" onclick="order_ck2(this,{{ $order['goods_num']*$order['bid_price'] }} )" productid="{{ $order['product_id'] }}"  class="chkbox" />
                                        <label for="order_ck{{$order['product_id']}}" ></label>
                                    </span>
                                    <div class="S1_bor_dv cart_goods_fx">
                                        <div class="cart_goods_img" style="background-image:url('{{$order['pic_url']}}') !important;"></div>
                                        
                                        <div class="S1_bor_dv_W">
                                            @if($order['live_video_id'] != null)
                                                <div class="cart_goods_sm_W">
                                                    <div class="LIVE_i">LIVE</div><span style="margin-right: 30px;">直播購買</span>
                                                    <div class="cart_goods_key">關鍵字: <div>{{$order['goods_key']}}</div></div>
                                                </div>
                                            @else
                                                <div class="cart_goods_sm_W">
                                                    <i class="fas fa-cart-arrow-down"></i><span style="margin-right: 30px;">商場加購</span>
                                                </div>
                                            @endif
                                            <div class="cart_goods_name">
                                                    {{$order['goods_name']}}
                                                <i class="fas fa-info-circle"></i>
                                            </div>
                                        </div>
                                    </div>
								</td>
								<td class="d-none">
									<div class="S1_bor_dv cart_goods_Q">78<span>件</span></div>
								</td>
		
                                <td class="text-center">
                                    <div class="S1_bor_dv cart_goods_M currencyField">{{$order['bid_price']}}</div>
                                </td>
                                <td class="text-center">
                                    <div class="S1_bor_dv cart_goods_K">
                                        <div class="cart_gooda_k_box">
                                            <span class="product_S">
                                                    <b>({{$order['category']}})&nbsp;</b>
                                            </span>
                                            <!--  <div class="op_goods_i"><i class="fas fa-sort-down"></i></div> -->
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    @if($order['live_video_id'] != null)
                                        <div class="S1_bor_dv cart_goods_N">
                                            <div class="cart_cg_num" data-toggle="tooltip" data-html="true" title="<b>無法修改</b>&nbsp;:&nbsp;任何在<b>直播中</b>所購買的商品<br>恕<b>不可修改</b>訂單，敬請見諒。">
                                                <input class="form-control input_num" name="input_num[]" type="number" value="{{$order['goods_num']}}" disabled>
                                            </div>
                                        </div>
                                    @else
                                        <div class="S1_bor_dv cart_goods_N">
                                            <div class="cart_cg_num "><input class="form-control input_num" name="input_num[]" type="number" value="{{$order['goods_num']}}" min="0" max="{{$order['store_num'] - $order['pre_sale']}}"></div>
                                        </div>
                                    @endif
                                </td>
        
                            </tr><!-- 一個商品 結尾 -->
                        
                    @endforeach
                    @foreach ($prize as $item)
                    	<tr>
                            <!-- 一個商品 開始 -->
                            <td>
                                <span class="or_ck_label" style="top:1.5rem">
                                    <input id="order_ck{{$item->page_id}}{{$item->id}}" name="sel_or" prizeid="{{ $item->id }}"  type="checkbox" onclick="order_ck2(this,'prize')"  class="chkbox" />
                                    <label for="order_ck{{$item->page_id}}{{$item->id}}"></label>
                                </span>
                                <div class="S1_bor_dv cart_goods_fx">
                                    <div class="cart_goods_img" style="background-image:url('{{$item->image_url}}') !important; background-size:  100% 100%; background-repeat: no-repeat;"> </div>
                                    <div class="S1_bor_dv_W">
                                        <div class="cart_goods_sm_W">
                                            <i class="fa fa-gift"></i><span style="margin-right: 30px;">直播抽獎</span>
                                            {{-- <div class="cart_goods_key">關鍵字: <div>A01S</div>
                                            </div> --}}
                                        </div>
                                        <div class="cart_goods_name">
                                            {{$item->product_name}}
                                            <i class="fas fa-info-circle"></i>
                                        </div>
                                    </div>
                                </div>
							</td>
							<td class="d-none">
								<div class="S1_bor_dv cart_goods_Q">78<span>件</span></div>
							</td>
	
                            <td class="text-center">
                                <div class="S1_bor_dv cart_goods_M currencyField">0</div>
                            </td>
                            <td class="text-center">
                                <div class="S1_bor_dv cart_goods_K">
                                    {{-- <div class="cart_gooda_k_box">
                                        <span class="product_S">
                                            <b>(S)</b><span>&nbsp;&nbsp;(M)&nbsp;&nbsp;(L)&nbsp;&nbsp;(XL)</span>
                                        </span>
                                        <!--  <div class="op_goods_i"><i class="fas fa-sort-down"></i></div> -->
                                    </div> --}}
    
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="S1_bor_dv cart_goods_N">
                                    <div class="cart_cg_num w-100" data-toggle="tooltip" data-html="true" title="<b>無法修改</b>&nbsp;:&nbsp;任何在<b>直播中</b>所購買的商品<br>怨<b>不可修改</b>訂單，敬請見諒。">
                                        <input class="form-control" type="number" value="1" disabled>
                                    </div>
                                </div>
                            </td>
                        </tr><!-- 一個商品 結尾 -->
                    @endforeach




                </table>

                <div class="cart_S2_box">
                    <!-- 第二區塊開始 -->
                    <div class="cart_S2_bor">
						<span class="tt">取貨方式</span>
						@if($page_detall->home_delivery == 1)
							<label for="cart_how_ck1" class=" cart_ck_how_label">
								<input type="radio" name="sel_how_cart" id="cart_how_ck1" price="{{$shipping['13']['fee']}}" value="宅配" style="display: none;"
									onclick="cart_how_ck(this,1)">
								<div class="cart_how_ck_box cart_how_ck_box1 " >宅配</div>
							</label>
						@endif
						@if( $page_detall->family_mart ==1 OR $page_detall->seven_eleven ==1 OR $page_detall->family_mart ==1 OR $page_detall->hi_life ==1)
							<label for="cart_how_ck2" class="cart_ck_how_label">
								<input type="radio" name="sel_how_cart" id="cart_how_ck2" value="超商取貨" checked="true"
									style="display: none;" onclick="cart_how_ck(this,2)">
								<div class="cart_how_ck_box cart_how_ck_box2 cart_how_ck_box_K">超商取貨</div>
							</label>
						@endif
                        <div class="cart_time">
                            <span>預計到貨時間</span>&nbsp;&nbsp;{{ date('Y-m-d') }}&nbsp;-&nbsp;{{ date('Y-m-d ' , strtotime('+4 day')) }}
                        </div>
                    </div>
                    <div class="cart_S2_bor" style="padding: 0;font-size: 0px;">
                        <div class="cart_S2_bor_L">
                            <div class="cart_S2_wh_box">
								@if($page_detall->family_mart ==1)
									<label for="cart_wh_ck1" class="cart_ck_how_label">
										<input type="radio" name="sel_wh_cart" id="cart_wh_ck1" price="{{$shipping['15']['fee']}}" value="15" shop="全家"
											style="display: none;">
										<div class="cart_wh_img" style="background:url('img/family2.png')"></div>
										<span>全家</span>
									</label>
								@endif
								@if($page_detall->seven_eleven ==1)
									<label for="cart_wh_ck2" class="cart_ck_how_label">
										<input type="radio" name="sel_wh_cart" id="cart_wh_ck2" price="{{$shipping['14']['fee']}}" value="14" shop="7-11"
											style="display: none;">
										<div class="cart_wh_img" style="background:url('img/711.png')"></div>
										<span>7-11</span>
									</label>
								@endif
                                <div class="shop">
									@if($page_detall->ok_mart ==1)
										<label for="cart_wh_ck3" class="cart_ck_how_label">
											<input type="radio" name="sel_wh_cart" id="cart_wh_ck3" price="{{$shipping['16']['fee']}}" value="16" shop="OK"
												style="display: none;">
											<div class="cart_wh_img" style="background:url('img/OK.png')"></div>
											<span>OK</span>
										</label>
									@endif
									@if($page_detall->hi_life ==1)
										<label for="cart_wh_ck4" class="cart_ck_how_label">
											<input type="radio" name="sel_wh_cart" id="cart_wh_ck4" price="{{$shipping['17']['fee']}}" value="17" shop="萊爾富"
												style="display: none;">
											<div class="cart_wh_img" style="background:url('img/hilife.png')"></div>
											<span>萊爾富</span>
										</label>
									@endif
                                </div>
                            </div>
                            <div class="cart_S2_data_box">
                                寄送地址 <input type="text" id="input_address" name="address"> <span class="cg" style="font-size: .7rem;cursor: pointer;" onclick="showmodal()"><u>選擇分店</u></span><br>
                                <div class="address">連絡電話 <input type="text" id="input_tel" name="tel"></div>
                                <div class="name">收件人名 <input type="text" id="input_name" name="name"></div>
                                

                            </div>
                        </div>
                        <div class="cart_S2_bor_R">
                            <div>買家備註</div>
                            <textarea id="input_note"></textarea>
                        </div>
                    </div>
                    <div class="cart_S2_bor">
                        <span class="tt">付款方式</span>
                        <label for="cart_pay_ck2" class="cart_ck_pay_label">
                            <input type="radio" name="sel_pay_cart" id="cart_pay_ck2" value="75" checked style="display: none;" onclick="cart_pay_ck(this,2)">
                            <div class="cart_pay_ck_box cart_pay_ck_box2 cart_pay_ck_box_K">銀行轉帳</div>
                        </label>
                    </div>
					<div class="cart_S2_bor">
						<div class="address">銀行後五碼 <input type="text" id="input_bankcode" name="bankcode"></div>     
                    </div>
                    <div class="S1_bor cart_gooda_total">
                        <!-- 總計開始 -->
                        運費&nbsp;:&nbsp;NT$&nbsp;<span id="freight">0</span>
                    </div><!-- 總計結尾 -->
                </div><!-- 第二區塊結尾 -->
                <div class="cart_S2_box cart_S3_box">
                    <div class="cart_S3_box_total_w">總計&nbsp;<span id='checkout_num'>0</span>&nbsp;件商品&nbsp;:&nbsp;
                        <div class="cart_S3_box_total">NT<span id='checked_price' class="currencyField">0</span></div>
                    </div>
					<input type="hidden" id="free_ship" value="{{$free_shipping}}">
                    <label for="cart_S3_box_btnn" >
                        <button type="button" class="btn cart_S3_box_btn" id="cart_S3_box_btnn" style="display: none;"></button>
                        
                        <div class="btn cart_S3_box_btn" onclick="checkout()">
                            <i class='fas fa-paw'></i>送出
                        </div>
                    </label>
                </div>

            </div>
            <div class="modal" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="searchModalLabel">選擇縣市</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                            {{-- 縣市 --}}
                            <select class="selectpicker mr-2" data-live-search="true" id="County" title="請選擇縣市">
                                    <option data-tokens="基隆市">基隆市</option>
                                    <option data-tokens="台北市">台北市</option>
                                    <option data-tokens="新北市">新北市</option>
                                    <option data-tokens="桃園市">桃園市</option>
                                    <option data-tokens="新竹市">新竹市</option>
                                    <option data-tokens="新竹縣">新竹縣</option>
                                    <option data-tokens="苗栗縣">苗栗縣</option>
                                    <option data-tokens="台中市">台中市</option>
                                    <option data-tokens="新北市">新北市</option>
                                    <option data-tokens="南投縣">南投縣</option>
                                    <option data-tokens="雲林縣">雲林縣</option>
                                    <option data-tokens="嘉義市">嘉義市</option>
                                    <option data-tokens="新北市">新北市</option>
                                    <option data-tokens="台南市">台南市</option>
                                    <option data-tokens="高雄市">高雄市</option>
                                    <option data-tokens="屏東縣">屏東縣</option>
                                    <option data-tokens="台東縣">台東縣</option>
                                    <option data-tokens="花蓮縣">花蓮縣</option>
                                    <option data-tokens="宜蘭縣">宜蘭縣</option>
                                    <option data-tokens="澎湖縣">澎湖縣</option>
                                    <option data-tokens="金門縣">金門縣</option>
                                    <option data-tokens="連江縣">連江縣</option>
                            </select>
    
                            <select class="selectpicker mr-2" data-live-search="true" onchange="Area(this)" id="Area" title="請選擇區域" disabled>
                            </select>
                            <select class="selectpicker" data-live-search="true"  id="address" title="請選擇地址" disabled>
                            </select>
                            <br>
                            <small class="pt-2 text-muted float-right">*如果找不到相對應地址請告知客服</small>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                        <button type="button" class="btn btn-primary" onclick="paste(this)">確認</button>
                    </div>
                    </div>
                </div>
            </div>
            @stop 
    @section('footer')    
    
    
    <script>
        var CSRF_TOKEN= $('meta[name="csrf-token"]').attr('content');
        alertify.set('notifier','position', 'top-center');
		
				
		function cart_ck(checkbox,x){ //勾選商品

			if(checkbox.checked == true){
				$('.cart_ck_box'+x+' img').css({'display':'block'}); 	
			}
			else{
				$('.cart_ck_box'+x+' img').css({'display':'none'}); 
				
			}

			if($("#cart_ck0").prop("checked")){//如果全選按鈕有被選擇的話（被選擇是true）
				$('.cart_S1_top_ck_all').css({'color':'#726e6f'}); 
				$("input[name='sel_cart']").prop("checked",true);//把所有的核取方框的property都變成勾選
				var check=$("input[name='sel_cart']:checked").length;
				for(i=0;i<=check;i++){
					$('.cart_ck_box'+i+' img').css({'display':'block'}); 	
				}
			}else{
				$('.cart_S1_top_ck_all').css({'color':'#cacaca'}); 
				$("input[name='sel_cart']").prop("checked",false);//把所有的核取方框的property都取消勾選
				var check=$("input[name='sel_cart']").length;
				for(i=0;i<=check;i++){
					$('.cart_ck_box'+i+' img').css({'display':'none'}); 	
				}
			}

			var allVals =0;

			$('input[name="sel_cart"]:checked').each(function() {
				total = parseInt($(this).attr('total'));
				goods_num = parseInt($(this).attr('goods_num'));
				single_price = total/goods_num;
				input_num = parseInt($(this).closest('tr').find('[class*="input_num"]').first().val());
				allVals += single_price*input_num;
			});

			$("#checked_price").html("$"+allVals);

			var check=$("input[name='sel_or']:checked").length+$("input[name='sel_cart']:checked").length;      
            if(check == 0)
                $("#checkout_price").html( "$0");
            $("#checkout_num").html(check);

		}

        function order_ck2(checkbox,price){ //勾選訂單
            var current_price = parseInt($("#checked_price").text().replace("$", ""));
			goods_num = parseInt($(checkbox).attr('goods_num'));
			single_price = price/goods_num;
			input_num = $(checkbox).closest('tr').find('[class*="input_num"]').first().val();
			price = single_price*input_num;
            
            if(price == 'prize')
                price = 0;
			
            if(checkbox.checked == true){
                $("#checked_price").html( "$"+(price+current_price).toString() );	
                $("#checkout_price").html( "$"+(price+current_price+60).toString() );
            }
            else{
                $("#checked_price").html( "$"+(current_price-price).toString() );
                $("#checkout_price").html( "$"+(current_price-price).toString() );
            }
            var check=$("input[name='sel_or']:checked").length+$("input[name='sel_cart']:checked").length;      
            if(check == 0)
                $("#checkout_price").html( "$0");
            $("#checkout_num").html(check);
        }
        
    
        $(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
        
		$(".input_num").bind('keyup mouseup', function () {
			var total_price = 0;
			$('input[name="sel_cart"]:checked').each(function() {
				total = parseInt($(this).attr('total'));
				goods_num = parseInt($(this).attr('goods_num'));
				single_price = total/goods_num;
				input_num = parseInt($(this).closest('tr').find('[class*="input_num"]').first().val());
				total_price += single_price*input_num;
			});

			$("#checked_price").html("$"+total_price);
		});

		
        $( "#County" ).change(function() {
            $.LoadingOverlay("show");
            var value = $(this).val();
            $.ajax({
                url: '/getMart_area',
                type: 'GET',
                data: { _token:CSRF_TOKEN ,contry:value ,sel_wh_cart:$("input[name=sel_wh_cart]:checked").attr('shop')},
                dataType: 'JSON',
                success: function (data) {
                    $("#Area").children().remove();
                    $("#address").children().remove();
                    $.each(data, function( index, value ) {
                        $("#Area").append('<option data-tokens="'+value['area']+'">'+value['area']+'</option>');
                    });
                    $("#Area").removeAttr('disabled');
                    $("#Area").selectpicker('refresh')
                    
                    $.LoadingOverlay("hide");
                   
                },
                error: function(XMLHttpRequest, status, error) {
                    // console.log(error);
                    // console.log(XMLHttpRequest.status);
                    // console.log(XMLHttpRequest.responseText);
                }
            });
        });
    
    
        function Area(element){
            var value =  $(element).val();
            $.LoadingOverlay("show");
            $.ajax({
                url: '/getMart_address',
                type: 'GET',
                data: { _token:CSRF_TOKEN ,contry:$("#County").val() ,sel_wh_cart:$("input[name=sel_wh_cart]:checked").attr('shop') , area:value},
                dataType: 'JSON',
                success: function (data) {
                    $("#address").children().remove();
                    $.each(data, function( index, value ) {
                        $("#address").append('<option data-tokens="'+value['store_id']+'">門市：'+value['store_name']+'；地址：'+value['store_address']+'</option>');
                    });
                    $("#address").removeAttr('disabled');
                    $("#address").selectpicker('refresh')
                    
                    $.LoadingOverlay("hide");
                   
                },
                error: function(XMLHttpRequest, status, error) {
                    // console.log(error);
                    // console.log(XMLHttpRequest.status);
                    // console.log(XMLHttpRequest.responseText);
                }
            });
            
        }
    
        function paste(element){
            $("#searchModal").modal('hide');
            $("input[name='address']").val($("#address").val());
        }
		//運送方式
		
		$( "input[name='sel_wh_cart']" ).change(function() {
			//var current_price = parseInt($("#checked_price").text().replace("$", ""));
			$("input[name='sel_how_cart']").prop('checked',false);
			$("#freight").html($(this).attr('price'));
			//$("#checked_price").html( "$"+(parseInt($("#freight").html()) + current_price).toString() );
		});
		$( "input[name='sel_how_cart']" ).change(function() {
			//var current_price = parseInt($("#checked_price").text().replace("$", ""));
			$("input[name='sel_wh_cart']").prop('checked',false);
			$("#freight").html($(this).attr('price'));
			//$("#checked_price").html( "$"+(parseInt($("#freight").html()) + current_price).toString() );
		});
	    $(document).ready(function () {
			$("input[name='sel_or']:checked").prop("checked", false);
			$("input[name='sel_cart']:checked").prop("checked", false);
		});

		function showmodal(){
			if($("input[name='sel_wh_cart']:checked").length == 0){
				alertify.error('請選擇超商！');
			}else{
				$("#County").val('default');
				$("#County").selectpicker("refresh");
				$("#address").children().remove();
				$("#Area").children().remove();
				$("#address").attr('disabled', 'disabled');
				$("#Area").attr('disabled', 'disabled');
				$("#address").selectpicker('refresh');
				$("#Area").selectpicker('refresh');
				$('#address').selectpicker('render');
				$('#Area').selectpicker('render');
				$("#searchModal").modal('show');
			}
		}

		function checkout(){
			selectedOrderProduct = new Array();
			selectedPrize = new Array();
			goodsnum = new Array();
			$("input:checkbox[name=sel_cart]:checked").each(function(){
				selectedOrderProduct.push( $(this).attr('productid')+'&'+$(this).attr('goods_num') );
				input_num = parseInt($(this).closest('tr').find('[class*="input_num"]').first().val());
				goodsnum.push(input_num);
			});
			console.log(goodsnum);

			$("input:checkbox[name=sel_or]:checked").each(function(){
				selectedPrize.push( $(this).attr('prizeid') );
			});


		
			var address = $("#input_address").val();
			var phone = $("#input_tel").val();
			var bankcode = $("#input_bankcode").val();
			var receiver_name = $("#input_name").val();
			var note = $("textarea#input_note").val();
			var goods_total = parseInt($("#checked_price").text().replace("$", ""));
			var delivery_type = $("input[name='sel_how_cart']:checked").val();
			if(delivery_type == 'store')
				delivery_type = $("input[name='sel_wh_cart']:checked").val();

			var payment_type = $("input[name='sel_pay_cart']:checked").val();
			
			var freight_type = $("input[name='sel_how_cart']:checked").val();

			console.log(bankcode);
						
			if( freight_type !="宅配"){
				freight_type = $("input[name='sel_wh_cart']:checked").val();
			}else{
				freight_type =13;
			}

			if(selectedOrderProduct.length == 0){
				alertify.error('請選擇付款商品！');
			}else if($("input[name=address]").val()=="" || $("input[name=tel]").val()=="" || $("input[name=name]").val()=="" ){
				alertify.error('請確認填寫送貨資訊！');
			}else if($("input[name=sel_how_cart]:checked").val()=='超商取貨' && $("input[name=sel_wh_cart]:checked").val() ==undefined){
				alertify.error('請選擇超商！');
			}else{
				var current_price = parseInt($("#checked_price").text().replace("$", ""));
				var free_ship = parseInt($("#free_ship").val());
				if(current_price < free_ship){
					//未滿額
					alertify.confirm('確認是否送出訂單？送出後訂單無法更改', '還差$'+( free_ship - current_price ).toString()+'免運費',
					function(){  
						//確定


						$.ajax({
							url: '/checkout',
							type: 'POST',
							data: {
								selectedOrderProduct:selectedOrderProduct,
								selectedPrize:selectedPrize ,
								goodsnum:goodsnum ,
								page_id:'{{$page_id}}',
								ps_id:'{{$ps_id}}',
								address:address,
								bankcode:bankcode,
								phone:phone,
								note:note,
								freight_type:freight_type,
								receiver_name:receiver_name,
								goods_total:goods_total,
								delivery_type:delivery_type,
								payment_type:payment_type,
								_token:CSRF_TOKEN},
								dataType: 'JSON',
							success: function (data) {
								//replace避免使用者重複checkout
								location.replace('{{ route('remittance', ["page_id"=>$page_id]) }}');
							},
							error: function(XMLHttpRequest, status, error) {
								console.log(error);
								console.log(XMLHttpRequest.status);
								console.log(XMLHttpRequest.responseText);
							}
						});
					}
					, function(){});
				}else{
					//滿額
					alertify.confirm('訂單確認', '確認是否送出訂單？送出後訂單無法更改',
					function(){  
						//確定
						$.ajax({
							url: '/checkout',
							type: 'POST',
							data: {
								selectedOrderProduct:selectedOrderProduct,
								selectedPrize:selectedPrize ,
								goodsnum:goodsnum ,
								page_id:'{{$page_id}}',
								ps_id:'{{$ps_id}}',
								address:address,
								bankcode:bankcode,
								phone:phone,
								note:note,
								freight_type:freight_type,
								receiver_name:receiver_name,
								goods_total:goods_total,
								delivery_type:delivery_type,
								payment_type:payment_type,
								_token:CSRF_TOKEN},
								dataType: 'JSON',
							success: function (data) {
								//replace避免使用者重複checkout
								location.replace('{{ route('remittance', ["page_id"=>$page_id]) }}');
							},
							error: function(XMLHttpRequest, status, error) {
								console.log(error);
								console.log(XMLHttpRequest.status);
								console.log(XMLHttpRequest.responseText);
							}
						});
					}
					, function(){});
				}
				
			}
		}
    </script>
    @stop
    
    
