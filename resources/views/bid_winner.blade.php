@extends('layouts.master')

@section('title','得標者清單')

@section('heads')
@stop

@section('wrapper')
<div class="wrapper">
@stop
@section('navbar')
    <!-- Page Content  -->
    <div id="content">
        @stop
        @section('content')
        <div class="container-fluid all_content overflow-auto" id="Menber_List">
            <div class="row">
                <div class="col-md-12 mb-4 ">
                    <form class="form-inline justify-content-center" method="get" action="/bid_winner">
                    {{ csrf_field() }} 
                        <h6 class="mr-4 font-weight-bolder">請輸入搜尋條件</h6>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend m-auto">
                                起始日期:
                            </div>
                            <input type="date" class="form-control ml-2" placeholder="Username" name="start_date">
                        </div>
                        <div class="input-group mb-2 mr-sm-2 ">
                            <div class="input-group-prepend m-auto">
                                至 &nbsp;&nbsp;&nbsp;&nbsp;結束日期:
                            </div>
                            <input type="date" class="form-control ml-2" placeholder="Username" name="end_date">
                        </div>
                        <button type="submit" class="btn btn-secondary ml-4 mb-2">確認</button>
                    </form>
                    <form action="/bid_winner_PDF" method="POST">
                    {{ csrf_field() }}    
                        <input type="hidden" name="start_date_PDF" value="{{ $start_date_PDF }}">
                        <input type="hidden" name="end_date_PDF" value="{{ $end_date_PDF }}">
                        <button type="submit" class="btn btn-secondary ml-4 mb-2" id="print">列印</button>
                        <input class="btn btn-info ml-4 mb-2" type="button" onclick="Create_Bid_Winner()" value="新增">
                    </form>


                    <div style="display:none;">
                        <div id="inputNewBidWinner">
                            <span>選擇會員</span>
                            <select id="select_member" class="custom-select"> 
                                <option value="">請選擇會員</option>
                                @foreach($member as $member)
                                    <option value="{{ $member->fb_id }}">{{ $member->fb_name }}</option>
                                @endforeach 
                            </select>

                            <span>選擇商品</span>
                            <select id="select_product" class="custom-select">
                                <option value="">請選擇商品</option>
                                @foreach($streaming_product as $product)
                                    <option value="{{ $product->product_id }}">{{ $product->goods_name }}
                                    @if($product->category !="empty"  )
                                        (&nbsp;{{ $product->category }}&nbsp;)
                                    
                                    @endif
                                    </option>
                                @endforeach
                            </select>

                            <span>數量</span><br>
                            <input id="num" class="form-control"  type="number" value="1" /><br>

                            <input type="hidden" id="fb_id" value="">
                            <input type="hidden" id="fb_name" value="">
                            <input type="hidden" id="goods_name" value="">
                            <input type="hidden" id="goods_price" value="">
                            <input type="hidden" id="product_id" value="">
                            <input type="hidden" id="category" value="">
                        </div>
                    </div>

                </div>
                <div class="col-md-12">
                    <table id="table_source" class="table table-borderles">
                        <thead>
                            <tr>
                                <th></th>
                                <th>得標者姓名</th>
                                <th>商品名稱</th>
                                <th>得標金額</th>
                                <th>得標數量</th>
                                <th>得標總價</th>
                                <th>留言內容</th>
                                <th>得標時間</th>
                                <th>修改</th>
                                <th>刪除</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($winner as $winner)
                                <tr>
                                    <td><img src="https://graph.facebook.com/{{  $winner->fb_id }}/picture?type=normal&access_token={{ $page_token }}" class="rounded-circle user_pic" ></td>
                                    <td>{{$winner->fb_name}}</td>
                                    <td>
                                        {{$winner->goods_name}}
                                        @if($winner->category != "empty")
                                            ，{{$winner->category}}
                                        @endif
                                    </td>
                                    <td class="currencyField">{{$winner->single_price}}</td>
                                    <td>{{$winner->order_num}}</td>
                                    <td class="currencyField">{{(int)$winner->order_num*(int)$winner->single_price}}</td>
                                    <td>{{$winner->comment}}</td>
                                    <td>{{$winner->created_time}}</td>
                                    <td><input class="btn btn-info ml-2" type="button" pid="{{ $winner->product_id }}" no="{{$winner->id }}" onclick="Edit_Bid_Winner($(this))" value="修改"></td>
                                    <td><input class="btn btn-danger ml-2" type="button" no="{{$winner->id }}" pid="{{ $winner->product_id }}" onclick="Delete_Bid_Winner($(this))" value="刪除"></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>     
                </div>
            </div>
        </div>    
    <!-- Cotent end-->
    </div>
</div>

<script>
    function Create_Bid_Winner() {
        var inputNewBidWinner = $('#inputNewBidWinner').html();
        alertify.confirm('手動新增得標者', inputNewBidWinner,
            function () {
                //使用者輸入的資料
                var fb_id = $('#fb_id').val();
                var fb_name = $('#fb_name').val();
                var goods_name = $('#goods_name').val();
                var goods_price = $('#goods_price').val();
                var goods_num = $('#num').val();
                var product_id = $('#product_id').val();
                var category = $('#category').val();

             
                
                $( document ).ready(function() {
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        /* the route pointing to the post function */
                        url: '/create_bid_winner',
                        type: 'POST',
                        /* send the csrf-token and the input to the controller */
                        data: { category:category,fb_id: fb_id, goods_name: goods_name, goods_price: goods_price, goods_num: goods_num, product_id: product_id, _token: csrfToken},
                        dataType: 'JSON',
                        /* remind that 'data' is the response of the AjaxController */
                        success: function (data) { 
                            alertify.set('notifier','position', 'top-center');
                            alertify.success('<i class="fa mr-2">&#xf14a;</i>'+"新增成功");
                            if(category=="empty"){
                                var category_note="";
                            }else{
                                var category_note="，"+category;
                            }
                            $('#table_source').DataTable()
                            .row.add(['<img src="https://graph.facebook.com/'+fb_id+'/picture?type=normal&access_token={{ $page_token }}" class="rounded-circle user_pic">', fb_name  ,goods_name+category_note, '<span class="currencyField">'+formatCurrency_format(goods_price)+'</span>'
                            ,goods_num,'<span class="currencyField">'+formatCurrency_format(goods_num*goods_price)+'</span>','由賣家新增',data[0],
                             '<input class="btn btn-info ml-2" type="button" pid="'+product_id+'" no="'+data[1]+'" onclick="Edit_Bid_Winner($(this))" value="修改">','<input class="btn btn-danger ml-2" type="button" pid="'+product_id+'" no="'+data[1]+'" onclick="Delete_Bid_Winner($(this))" value="刪除">'])
                            .draw()
                            .node();
                        },
                        error: function(xhr, status, error) {
                            alertify.set('notifier','position', 'top-center');
                            alertify.error('<i class="fas mr-2">&#xf06a;</i>'+"新增失敗");
                        }
                    });
                });
            }
            , function () { });
    }

    function Edit_Bid_Winner(object) {
        var no = object.attr('no');  //流水號
        var pid = object.attr('pid');  //圖片網址
        var row = object.parent().parent();
        var goodsname = $('#table_source').DataTable().row( row ).data()[2];
        var goodscount = $('#table_source').DataTable().row( row ).data()[4];
        goodsname = goodsname.replace(/\s+/g,"");
        alertify.confirm('<div class="form-group"><label>商品名稱</label><input type="text" class="form-control" disabled value="'+goodsname+'"></div><div class="form-group"><label>商品數量</label><input type="number" id="editGoodsCount" class="form-control" value="'+goodscount+'"></div>', 
        function(){   
            $( document ).ready(function() {
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');

                    $.ajax({
                        /* the route pointing to the post function */
                        url: '/edit_bid_winner',
                        type: 'POST',
                        /* send the csrf-token and the input to the controller */
                        data: { original_num :goodscount ,id: no, product_id: pid, goods_num: $("#editGoodsCount").val() ,_token: csrfToken},
                        dataType: 'JSON',
                        /* remind that 'data' is the response of the AjaxController */
                        success: function (data) {
                            //console.log(data);
                            alertify.set('notifier','position', 'top-center');
                            alertify.success('<i class="fa mr-2">&#xf14a;</i>'+"修改成功");
                            $('#table_source').DataTable().row( row ).data()[4] = $("#editGoodsCount").val();
                            row.children().eq(4).text($("#editGoodsCount").val());
                            row.children().eq(5).text( formatCurrency_format($("#editGoodsCount").val()*data['goods_price']) );
                        },
                        error: function(xhr, status, error) {
                            // console.log(error);
                            alertify.set('notifier','position', 'top-center');
                            alertify.error('<i class="fas mr-2">&#xf06a;</i>'+"修改失敗，庫存不足");
                        }
                    });
                });
        }, 
        function(){ });

    }

    $( document ).ready(function() {
        //帶入member資料
        $(document).on('change','#select_member',function(){
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                    /* the route pointing to the post function */
                    url: '/get_member_data',
                    type: 'POST',
                    /* send the csrf-token and the input to the controller */
                    data: { fb_id: $(this).find(":selected").val(), _token: csrfToken},
                    dataType: 'JSON',
                    /* remind that 'data' is the response of the AjaxController */
                    success: function (data) {
                        $('#fb_id').val(data['fb_id']);
                        $('#fb_name').val(data['fb_name']);
                    },
                    error: function(xhr, status, error) {
                        
                    }
                    
            });
        });

        //帶入goods資料
        $(document).on('change','#select_product',function(){
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                    /* the route pointing to the post function */
                    url: '/get_goods_data',
                    type: 'POST',
                    /* send the csrf-token and the input to the controller */
                    data: { pid: $(this).find(":selected").val(), _token: csrfToken},
                    dataType: 'JSON',
                    /* remind that 'data' is the response of the AjaxController */
                    success: function (data) {
                        $('#goods_name').val(data['goods_name']);
                        $('#goods_price').val(data['goods_price']);
                        $('#product_id').val(data['product_id']);
                        $('#category').val(data['category']);
                    },
                    error: function(xhr, status, error) {
                        
                    }
                    
            });
        });

        $(document).on('change','#num',function(){
            $('#num').val($(this).val());

        });
    });

    //刪除得標者(/bid_winner頁面)
    function Delete_Bid_Winner(object) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var no = object.attr('no');  //流水號
        var row = object.parent().parent();
        var uid_str = no.toString();
        var product_id = object.attr('pid');  //圖片網址
        alertify.confirm('系統訊息', '是否確定刪除該得標者?'
        , function () { 
            $.ajax({
                /* the route pointing to the post function */
                url: '/delete_bid_winner',
                type: 'POST',
                /* send the csrf-token and the input to the controller */
                data: { product_id:product_id, id: uid_str,_token: csrfToken},
                dataType: 'JSON',
                /* remind that 'data' is the response of the AjaxController */
                success: function (data) {
                    alertify.set('notifier','position', 'top-center');
                    alertify.success('<i class="fa mr-2">&#xf14a;</i>'+"刪除得標者成功");
                    $('#table_source').DataTable().row(row)
                    .remove()
                    .draw();
                },
                error: function(xhr, status, error) {
                    alertify.set('notifier','position', 'top-center');
                    alertify.error('<i class="fas mr-2">&#xf06a;</i>'+"刪除得標者失敗"); 
                }
            });
        }
        , function () {  });
    }

    $( document ).ready(function() {
        const driver = new Driver(
        //     {
        // onHighlightStarted: (Element) => {
        //     if(localStorage['visited']!="yes" || ){
        //         $('#table_source').DataTable()
        //                     .row.add(['<img src="https://graph.facebook.com/321923508505733/picture" class="rounded-circle user_pic" >',"來福測試人頭","來福的口水",'$9999','1','我要+1','','','2019-07-16 23:00:53','<input class="btn btn-info ml-2" type="button"  value="修改">','<input class="btn btn-danger ml-2" type="button" value="刪除">'])
        //                     .draw()
        //                     .node();  
        //        window.localStorage.removeItem('visited');
        //     }
            
        // },
        // onDeselected: (Element) =>{
        //     var dtcount = $('#table_source').DataTable().row().count();

        //     if(dtcount==1){
        //         localStorage['visited'] = "yes";
        //     }else{
        //         var nodes = [];
        //         $('#table_source').DataTable().rows().every( function(rowIdx, tableLoop, rowLoop) {
        //             if ( this.data()[1] == '來福測試人頭') nodes.push(this.node())
        //         })
            
        //         $('#table_source').DataTable().row(nodes[0]).remove().draw()
        //     }

            
        // }    
        // }
        );

        driver.defineSteps([
                {
                    element: '.form-inline.justify-content-center',
                    popover: {
                        title: '選取得標時間',
                        description: '預設值為當日得標者清單',
                        position: 'bottom'
                    }
                },
                {
                    element: '#print',
                    popover: {
                        title: '點選列印',
                        description: '列印<strong>全部</strong>訂單',
                        position: 'bottom'
                    }
                },
                {
                    element:'form>.btn.btn-info.ml-4.mb-2',
                    popover: {
                        title: '點選新增',
                        description: '新增得標者，可用來補單',
                        position: 'bottom'
                    }
                },
                {
                    element: '.dataTables_length',
                    popover: {
                        title: '選取資料筆數',
                        description: '調整顯示得標者筆數',
                        position: 'bottom'
                    }
                },
                {
                    element: '#table_source_filter',
                    popover: {
                        title: '快速尋找得標者',
                        description: '只需輸入關鍵字即可！',
                        position: 'left-bottom'
                    }
                },
                {
                    element: '#table_source_wrapper',
                    popover: {
                        title: '查看得標者資訊',
                        description: '可以查看得標者訊息',
                        position: 'bottom'
                    }
                },
                {
                    element: '.btn.btn-info.ml-2',
                    popover: {
                        title: '點選修改',
                        description: '可以修改得標商品數量',
                        position: 'left-bottom'
                    }
                },
                {
                    element: '.btn.btn-danger.ml-2',
                    popover: {
                        title: '點選刪除',
                        description: '可以刪除得標者',
                        position: 'left-bottom'
                    }
                },
            ]);

        document.querySelector('#help_me').addEventListener('click', function (e) {
            e.preventDefault();
        e.stopPropagation();
        driver.start();
        });
    });
    </script>

@stop

@section('footer')

@stop            
