@extends('layouts.master_shop')

@section('title','來去逛逛')

@section('head_extension')
<link rel="stylesheet" href="css/joyce.css">
@stop
<style>
    .chosenli{
        background-color: #000000!important;
        color : #FFFFFF!important;
        box-shadow: 0 0 0 0.2rem rgba(248, 249, 250, 0.5)!important;
    }
    .chosen{
        color : #FFFFFF!important;
        background-color: #000000!important;
    }
</style>
@section('wrapper')
<div class="wrapper">
@stop
@section('navbar')
    <div id="content">
        <div class="col-sm-12 intro">
@stop
    @section('content')
            <div id="shop_intro" class="flex row">
                <div class="introLeft flex col-lg-9 col-md-12">
                    <img src="https://graph.facebook.com/{{ $page_id }}/picture?type=large" alt="photo" class="shopIMG">
                    <div class="introTitle">
                        <h3>{{ $page_name }}</h3>
                        <div class="flex subTitle mt10">
                        @if($if_streaming)
                            <h6><span class="badge liveIcon">LIVE</span>正在直播中</h6>
                        @endif
                            <div class="iconBox">
                                <img src="img/facebook_icon.png" alt="photo" class="com_icon">
                                <img src="img/instagram_icon.png" alt="photo" class="com_icon">
                                <img src="img/line_icon.png" alt="photo" class="com_icon">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="introRight col-lg-3 col-md-12">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="在商場內搜尋">
                    </div>
                    <h5>共 <span>{{ $product_count }}</span> 件商品</h5>
                </div>
            </div>
        </div>

            <div class="col-sm-12" id="itemBlock">
                <div class="container-fulid">
                    <div class="row">
                        @foreach( $products as $product )
                            <div class="col-xl-3 col-lg-4 col-md-6 goodsBlock box{{ $loop->iteration }}" data-num="{{ $loop->iteration }}" goodskey="{{ $product->goods_key }}" >
                                <div class="goods">
                                    <div class="imgBlock">
                                        <img src="{{ $product->pic_url }}" alt="photo" class="goods_img">
                                        @if( strtotime( $product->updated_at ) > strtotime( date('Y-m-d').'-1 week' ) )
                                        <div class="flags">
                                            <p>NEW 新上架</p>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="goodsTitle">
                                        <h4>{{ $product->goods_name }}</h4>                              
                                    </div>
                                    <div class="flex goodsDetail">
                                        <span>剩餘 <span class="lastgoods">{{ $product->total_num-$product->pre_sale }}</span> 件</span>
                                        <span class="currencyField price">{{ $product->goods_price }}</span>
                                    </div>
                                </div>                           
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- Modal -->
        <div class="modal" id="ModalCentered" tabindex="-1" role="dialog" aria-labelledby="ModalCenteredLabel" aria-hidden="true">
            <div class=" modal-dialog-centered" style="width:90%!important;margin-left:5%" role="document">
            <div class="">
                <div id="ModalCenteredbody">
                    
                </div>
                {{-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div> --}}
            </div>
            </div>
        </div>
        </div>
        <!-- 相片輪播 -->
        <div class="popover">
            <div id="slide-window">
                <ul id="slides" class="flex">
                    <li class="slide"><img src="img/cat.jpg" alt=""></li>
                    <li class="slide"><img src="img/catt.jpg" alt=""></li>
                    <li class="slide"><img src="img/cat.jpg" alt=""></li>
                    <li class="slide"><img src="img/pigcat.jpg" alt=""></li>
                    <li class="slide"><img src="img/aaa.jpg" alt=""></li>
                </ul>
                <span id="left"><i class="fas fa-chevron-left"></i></span>
                <span id="right"><i class="fas fa-chevron-right"></i></span>
                <span id="close"><i class="fas fa-times"></i></span>
            </div>
        </div>
        <div class="popover-mask"></div>
</div>
    @stop 
@section('footer')    
<script>
        
        $(function(){
            $('[data-toggle="tooltip"]').tooltip();

            

            $('#slide-window #close').click(function(){
                $('.popover-mask').css('display', 'none');
                $('#slide-window').css('display', 'none');
            });

        });

        function pictureShow(){
            $('.picsBox .picsmask').click(function(){
                $('.popover-mask').css('display', 'block');
                $('#slide-window').css('display', 'block');
            });
        }
        //相片輪播
        $.global = new Object();

        $.global.item = 1;
        $.global.total = 0;

        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var CSRF_TOKEN= $('meta[name="csrf-token"]').attr('content');
            
            var WindowHeight = $(window).height();
            var WindowWidth = $(window).width();
            var SlideCount = $('#slides li').length;
            var SlidesWidth;
            if(WindowHeight > WindowWidth){
                SlidesWidth = WindowWidth * 0.7;
            }

            if(WindowWidth > WindowHeight){
                SlidesWidth = WindowHeight * 0.7;
            }
            
            $.global.item = 0;
            $.global.total = SlideCount; 
            
            $('.slide img').css('width', SlidesWidth+'px');
            $('.slide img').css('height', SlidesWidth+'px');
            $('#slides').css('width', SlidesWidth+'px');
            $('#slides').css('height', SlidesWidth+'px');

                
            $('#left').click(function() { Slide('back'); }); 
            $('#right').click(function() { Slide('forward'); });

            //產品detail
            $('.goodsBlock').click(function(){
                $(".goodsIntro").remove();

                var goods_key = $(this).attr('goodskey');
                var today = new Date();
                var sevendaysBefore = new Date(today.getTime() - 24*60*60*1000*7);
                var content = '';
                $.ajax({
                    url: '/shop_product',
                    type: 'POST',
                    data: {page_id:{{ $page_id }},goods_key:goods_key,_token:CSRF_TOKEN},
                    dataType: 'JSON',
                    success: function (data) {

                        if(data[0].description == null){
                            data[0].description = "";
                        }

                        content = '<div class="row goodsIntro">\
                                    <div class="closeBtn"><a data-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></a></div>\
                                    <div class="picsBox col-lg-4 col-md-12 col-12">\
                                        <img src="'+data[0].pic_url+'" alt="photo" class="pics">\
                                    </div>\
                                    <div class="info col-lg-8 col-md-12">\
                                        <div>\
                                            <div class="flex goodsheader">';
                        if( (Date.parse(data[0].updated_at)).valueOf() > (Date.parse(sevendaysBefore)).valueOf() )
                        {
                            content += '<div class="flags greenFlag">\
                                        <p>NEW 新上架</p>\
                                    </div>';
                        }
                        content += '<span class="ml15">剩餘 <span id="lastgoods">'+data[0].goods_num+'</span> 件</span>';
                        
                        content += ' </div>\
                                <div class="goodscontent">\
                                    <h2>'+data[0].goods_name+'</h2>\
                                    <p class="mt10">'+data[0].description+'</p>\
                                </div>\
                            </div>\
                            <div class="goodsfooter flex row">\
                                <div class="flex selectBlock">\
                                    <ul class="flex select-btn">';
                                    for(var i=0; i< data.length; i++){
                                        var num = data[i].goods_num - data[i].pre_sale;
                                        content += '<li onclick="select_size(this)"><a name="category_btn" data_id="'+data[i].product_id+'" href="javascript:void(0)" num="'+num+'" >'+data[i].category+'</a></li>';
                                    }
                        content +=' </ul>\
                                    <div class="form-group flex-center-start">\
                                        <span>選購</span>\
                                        <input type="number" min="0" class="form-control inputNoBorder" id="howmany"  value="1">\
                                        <span>件</span>\
                                    </div>\
                                </div>\
                                <div class="flex-center-start">\
                                    <span class="price " id="goods_detail_price">$'+data[0].goods_price+'</span>\
                                    <input type="hidden" id="detail_price" value="'+data[0].goods_price+'">\
                                    <button type="button" class="btn btn-dark addToCart"><i class="fas fa-shopping-cart mr5"></i>加入購物車</button>\
                                </div>\
                            </div>\
                        </div>\
                    </div>';
                        
                    $("#ModalCenteredbody").append(content);
                    $("#ModalCentered").modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });


                // var goods = $(this);
                // var num = goods.attr('data-num');
                // console.log('num');
                // console.log(num);
                // var WindowWidth = $(window).width();
                // var inrow;
                // if(WindowWidth > 1200){
                //     inrow = 4;
                // } else if ( WindowWidth < 1200 && WindowWidth > 992){
                //     inrow = 3;
                // } else if ( WindowWidth < 992 && WindowWidth > 768){
                //     inrow = 2;
                // } else if ( WindowWidth < 768){
                //     inrow = 1;
                // }
                // console.log(inrow);
                // var i;
                // if(num % inrow === 0){
                //     i = num;
                // } else {
                //     i = (Math.floor(num / inrow) + 1) * inrow;
                // }
                
                // console.log(i)
                // var printDiv = $('.box'+i)
                // var introL = $('.goodsIntro').length;
                // if(introL === 0){
                //     $(html).insertAfter(printDiv);
                // }
               
                // pictureShow();
            });

            //加入購物車
            $(document).on('click','.addToCart',function(){
                var buyNum = $('#howmany').val();
                var product_id = $('.chosen').attr("data_id");
                var detail_price = $('#detail_price').val();
                if(product_id == null){
                    alertify.set('notifier','position', 'top-center');
                    alertify.error('<i class="fas mr-2">&#xf06a;</i>'+"請選擇商品類別");
                }else{
                    $.ajax({
                        type: "POST",
                        url: "/shop_add_cart",
                        dataType: "json",
                        data: {
                                "page_id": {{ $page_id }},
                                "goods_num": buyNum,
                                "bid_price": detail_price,
                                "product_id": product_id,
                                "ps_id":{{ $ps_id }}
                                },
                        cache: false,
                        success: function(data){
                            if(data == '1')
                            {
                                alertify.set('notifier','position', 'top-center');
                                alertify.success('<i class="fa mr-2">&#xf14a;</i>'+"新增成功");
                                setTimeout(function(){
                                    location.reload(); 
                                }, 1000); 
                            }
                            else
                            {
                                alertify.set('notifier','position', 'top-center');
                                alertify.error('<i class="fa mr-2">&#xf14a;</i>'+"很抱歉！商品庫存不足");
                                setTimeout(function(){
                                    location.reload(); 
                                }, 1000); 
                            }
                        },
                        error: function(xhr){
                            //alert(xhr.responseText);
                        }
                    });
                }
            });
        });

        

        function Slide(direction){
            if (direction == 'back') { 
                var $target = $.global.item - 1; 
            }
            if (direction == 'forward') { 
                var $target = $.global.item + 1; 
            }  
            // console.log($target);
            if ($target == -1) { 
                DoIt($.global.total-1); 
            } else if ($target == $.global.total) {
                DoIt(0); 
            } else { 
                DoIt($target); 
            }
        }

        function DoIt(target){
            var WindowHeight = $(window).height();
            var WindowWidth = $(window).width();
            var SlideCount = $('#slides li').length;
            var $margin;
            if(WindowHeight > WindowWidth){
                $margin = WindowWidth * 0.7* target;
            }

            if(WindowWidth > WindowHeight){
                $margin = WindowHeight * 0.7* target;
            }
            var $actualtarget = target + 1;
            
            
            $('#slides li').css('transform','translateX(-'+$margin+'px)');	
            
            $.global.item = target; 
        }

        function select_size(element){
            $('a[name ="category_btn"]').removeClass('chosen');
            $('a[name ="category_btn"]').parent().removeClass('chosenli');
            $(element).addClass('chosenli');
            $(element).children().addClass('chosen');    
            $('#lastgoods').html($(element).children().attr('num'));
            $('#howmany').attr('max',$(element).children().attr('num'));
        }

        function closeIntro(){
            $('.goodsIntro').remove();
        }
    </script>

@stop

