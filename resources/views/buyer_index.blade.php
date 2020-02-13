@extends('layouts.master_mall_cart')

@section('title','購物車')
@section('heads')

@stop

@section('wrapper')
<div class="wrapper">
@stop
                @section('navbar')
                <div id="content" style="background-color: #F5F5F5	">
            <div class="container">
                <div class="card rounded-0">
                    <div class="card-body p-0">
                    @stop
                        @section('content')
                        <div class="row justify-content-center">
                            <div class="col-md-10 col-sm-12" style="max-width: 100%;min-height: 100vh">
                            <?php $item=1;$Order_total_cost=0; ?>
                                <form id="form_next" action="{{ route('checkout_form') }}" method="POST">
                                {{ csrf_field() }}
                                    <div class="media mt-3 pb-3 border-bottom font-weight-bolder">
                                        <div class="d-flex align-self-center mr-3 invisible">
                                            <div class="custom-control custom-checkbox ">
                                                <input type="checkbox" class="custom-control-input" id="" name="" value="">
                                                <label class="custom-control-label" for=""></label>
                                            </div>
                                        </div>
                                        <img class="d-flex mr-3 align-self-center invisible " style="width: 5rem">
                                        <div class="media-body d-flex align-self-center mr-3 ">
                                            商品
                                        </div>
                                        <div class="media-body d-flex align-self-center mr-3">
                                            單價
                                        </div>
                                        <div class="media-body d-flex align-self-center mr-3">
                                            數量
                                        </div>
                                        <div class="media-body d-flex align-self-center mr-3">
                                            總計
                                        </div>
                                        <div class="media-body d-flex align-self-center mr-3 ">
                                            操作
                                        </div>
                                    </div>
                                    @foreach($shopping_cart_streamming as $cart)
                                    <?php
                                        $item++;
                                        $buyer_fbname = $cart ->name;
                                        $streaming_product_total_price = $cart->single_price*$cart->goods_num;
                                        $Order_total_cost += $streaming_product_total_price;
                                    ?>
                                        <div class="media mt-3 pb-3 border-bottom text-center">
                                            <div class="d-flex align-self-center mr-3">
                                                <div class="custom-control custom-checkbox ml-4">
                                                    <input type="checkbox" class="custom-control-input" id="{{$item}}" name="goods_streaming[]" value="{{$page_name}},{{$cart->fb_id}},{{$fbname}},{{$cart->goods_name}},{{$cart->single_price}},{{$cart->goods_num}},{{$cart->single_price*$cart->goods_num}},{{$cart->page_id}},{{$cart->id}},{{$cart->pic_url}},{{$cart->category}},{{$cart->product_id}}">
                                                    <label class="custom-control-label" for="{{$item}}"></label>
                                                </div>
                                            </div>
                                            <img class="d-flex mr-3 align-self-center " style="height: 5rem;width: 5rem" onerror="this.src='img/Products.png';" src="{{$cart->pic_url}}">
                                            <div class="media-body d-flex align-self-center mr-3 text-truncate">
                                                {{$cart->goods_name}}
                                                @if( $cart->category!="empty"  )
                                                    ，{{$cart->category}}
                                                @endif
                                            </div>
                                            <div class="media-body d-flex align-self-center mr-3 currencyField">
                                                {{$cart->single_price}}
                                            </div>
                                            <div class="media-body d-flex align-self-center mr-3">
                                                {{$cart->goods_num}}
                                            </div>
                                            <div class="media-body d-flex align-self-center mr-3 currencyField">
                                                <?php echo $streaming_product_total_price;?>
                                            </div>
                                            <div class="media-body d-flex align-self-center mr-3" >
                                                <button type="button" class="btn btn-sm btn-danger" disabled>刪除</button>
                                            </div>
                                        </div>
                                        @endforeach
                                        @foreach($shpping_cart_mall as $cart)
                                        <?php
                                            $item++;
                                            $buyer_fbname = $cart ->name;
                                            $Order_total_cost += $cart->total_price;
                                        ?>
                                        <div class="media mt-3 pb-3 border-bottom text-center">
                                            <div class="d-flex align-self-center mr-3">
                                                <div class="custom-control custom-checkbox ml-4">
                                                    <input type="checkbox" class="custom-control-input" id="{{$item}}" name="goods_shop[]" value="{{$page_name}},{{$cart->fb_id}},{{$fbname}},{{$cart->goods_name}},{{$cart->total_price/$cart->goods_num}},{{$cart->goods_num}},{{$cart->total_price}},{{$cart->page_id}},{{$cart->id}},{{$cart->pic_url}},{{$cart->category}},{{$cart->product_id}}">
                                                    <label class="custom-control-label" for="{{$item}}"></label>
                                                </div>
                                            </div>
                                            <img class="d-flex mr-3 align-self-center " style="height: 5rem;width: 5rem" onerror="this.src='img/Products.png';" src="{{$cart->pic_url}}">
                                            <div class="media-body d-flex align-self-center mr-3 text-truncate">
                                                {{$cart->goods_name}}
                                                @if( $cart->category!="empty"  )
                                                ，{{$cart->category}}
                                                @endif
                                            </div>
                                            <div class="media-body d-flex align-self-center mr-3 currencyField">
                                                {{$cart->total_price/$cart->goods_num}}
                                            </div>
                                            <div class="media-body d-flex align-self-center mr-3">
                                                {{$cart->goods_num}}
                                            </div>
                                            <div class="media-body d-flex align-self-center mr-3 currencyField">
                                                {{$cart->total_price}}
                                            </div>
                                            <div class="media-body d-flex align-self-center mr-3">
                                                <button type="button" class="btn btn-sm btn-danger delete_btn" shopOrder_id="{{$cart->id}}">刪除</button>
                                            </div>
                                        </div>
                                        @endforeach
                                        @if(count($shpping_cart_mall)!=0 or count($shopping_cart_streamming)!=0)
                                        <input type="hidden" name="buyer_fbname" value="{{ $buyer_fbname  }}">
                                        <input type="hidden" name="page_id" value="{{ $page_id }}">
                                        <ul class="list-group mt-4">
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <input type="hidden" name="free_shipping" value="{{ $shipping_fee }}">
                                                <span>購買總金額： <span class="currencyField" id="cart_total"><?php echo $Order_total_cost;?></span></span><br>
                                                <span id="cart_text">免運費金額尚未達到，金額還差 <span class="currencyField" id="cart_free"><?php echo (int)$free_shipping-(int)$Order_total_cost;?></span> 元。</span>
                                                <span class="d-none" id="cart_text_Reach">已達到免運費金額。</span>
                                                <span class="d-none" id="cart_text_None">無免運費優惠。</span>
                                                <input id="ShopNextStep" type="button" value="下一步" class="btn btn-secondary">
                                            </li>
                                        </ul>
                                        @endif
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <!-- Cotent end-->
</div>
@stop

@section('footer')

    <script>
        var free = {{ $free_shipping }};

        $( ".custom-control-input" ).ready(function() {

            if(free == 0){
                $("#cart_text_None").removeClass();
                $("#cart_text").addClass("d-none");
            }
        });

        $(".custom-control-input").change(function() {
            var total = 0;

            $('input[type=checkbox]:checked').each(function () {
                total = total + parseInt($(this).val().split(",")[6])
            });
            $("#cart_total").html(formatCurrency(total));
            var Distance = free - total;
            if(free == 0){
                $("#cart_text_None").removeClass();
                $("#cart_text").addClass("d-none");
            }else{

                if(free>=total){
                    $("#cart_text").removeClass();
                    $("#cart_text_Reach").addClass("d-none");

                    $("#cart_free").html(formatCurrency(Distance));
                }else{
                    $("#cart_text_Reach").removeClass();
                    $("#cart_text").addClass("d-none");
                    $("#cart_free").html(formatCurrency(Distance));
                }
            }

        });

        function formatCurrency(total) {
            var neg = false;
            if(total < 0) {
                neg = true;
                total = Math.abs(total);
            }
            return (neg ? "-$" : '$') + parseFloat(total, 10).toFixed(0).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString();
        }

        $("#ShopNextStep").on('click',function(){
            var total = 0;

            $('input[type=checkbox]:checked').each(function () {
                total = total + parseInt($(this).val().split(",")[6])
            });

            if(total<free)
            {
                alertify.confirm('系統訊息', '免運費金額尚未達到，金額還差'+(free-total)+'元，確定進行結帳嗎？', function(){ document.getElementById('form_next').submit(); }
                , function(){ });

            }else{
                document.getElementById('form_next').submit();
            }

        });


        $(document).on('click', '.delete_btn', function () {
            var event = $(this);
            //var csrfToken = $('meta[name="csrf-token"]').attr('content');
            //console.log(csrfToken);
            $.ajax({
                /* the route pointing to the post function */
                url: '/buyer_index_delete',
                type: 'POST',
                /* send the csrf-token and the input to the controller */
                data: { shopOrder_id: $(this).attr('shopOrder_id'),_token: '{{csrf_token()}}'},
                dataType: 'JSON',
                /* remind that 'data' is the response of the AjaxController */
                success: function (data) {
                    event.parent().parent().remove();
                    alertify.set('notifier','position', 'top-center');
                    alertify.success('<i class="fa mr-2">&#xf14a;</i>'+"商品已成功刪除！");
                    location.reload();
                },
                error: function(xhr, status, error) {
                    //console.log(xhr.responseText);
                    //console.log(status);
                    //console.log(error);
                    alertify.set('notifier','position', 'top-center');
                    alertify.error('<i class="fas mr-2">&#xf06a;</i>'+"商品刪除失敗！");
                }
            });
        });
    </script>
@stop


