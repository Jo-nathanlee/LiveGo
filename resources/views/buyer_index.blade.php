
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- icon -->
    <link rel="Shortcut Icon" type="image/x-icon" href="img/livego.png" />
    <title>Live GO</title>

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4"
        crossorigin="anonymous">
    <!-- MY CSS -->
    <link rel="stylesheet" href="css/sidebar.css">
    <!--導覽列-->
    <link rel="stylesheet" href="css/navbar.css">
    <!--標題列-->
    <link rel="stylesheet" href="css/notification.css">
    <!--通知列-->
    <link rel="stylesheet" href="css/LiveGO.css">
    <link rel="stylesheet" href="css/comment.css">
    <!-- iconfont CSS -->
    <link rel="stylesheet" href="css/icofont.css">
    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ"
        crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY"
        crossorigin="anonymous"></script>
    <!-- alterfy  -->
    <script src="js/alertify.js"></script>
    <link href="css/alertify.css" rel="stylesheet">
    <link href="css/default.css" rel="stylesheet">
    <!-- datatable + bootstrap 4  -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
</head>
<script>
    $(function () {
        $("#navbar_page").load("來福商城navbar.html");
        $("#sidebar_page").load("來福商城sidebar.html");
    });
</script>

<body>
    <div class="wrapper">
        <div id="sidebar_page"></div>
        <!-- Page Content  -->
        <div id="content" class="mr250">
            <div id="navbar_page"></div>
            <div id="main" class="row">
                <div class="col-md-12">
                @if(empty($shopping_cart))
                    <table class="table table-striped " id="table_cart">
                        <thead>
                            <tr>
                                <tr>
                                    <th></th>
                                    <th>商品圖片</th>
                                    <th>商品名稱</th>
                                    <th>商品價格</th>
                                    <th>商品數量</th>
                                    <th>總金額</th>
                                    <th>得標時間</th>
                                </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="7">無資料</td>
                            </tr>
                        </tbody>
                    </table>


                @else
                <?php $item=1;?>
                    @foreach($shopping_cart as $page => $collection)
                        {{$page}}<hr>
                        <table class="table table-striped tablecart" id="table_cart">  
                        <thead>
                            <tr>
                                <tr>
                                    <th></th>
                                    <th>商品圖片</th>
                                    <th>商品名稱</th>
                                    <th>商品價格</th>
                                    <th>商品數量</th>
                                    <th>總金額</th>
                                    <th>得標時間</th>
                                </tr>
                        </thead>
                        <tbody>
                        
                                <form id="checkout" action="{{ route('checkout') }}">{{ csrf_field() }}
                                    @foreach($collection as $cart)
                                    <?php $item++;?>
                                        <tr>
                                        <td>
                                            <div class="custom-control custom-checkbox ml-4">
                                                <input type="checkbox" class="custom-control-input" id="{{$item}}" name="goods[]" value="{{$cart->page_name}},{{$cart->fb_id}},{{$cart->name}},{{$cart->goods_name}},{{$cart->goods_price}},{{$cart->goods_num}}">
                                                <label class="custom-control-label" for="{{$item}}"></label>

                                            </div>
                                        </td>
                                        <td>
                                            <img src=""
                                            />
                                        </td>
                                        <td>{{$cart->goods_name}}</td>
                                        <td>{{$cart->goods_price}}</td>
                                        <td>{{$cart->goods_num}}</td>
                                        <td>{{(int)($cart->goods_price)*(int)($cart->goods_num)}}</td>
                                        <td></td>
                                        </tr>
                                        @endforeach
                                
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="7">
                                <input type="submit" value="結帳" class="btn btn-secondary">
                                </form>
                                </td>
                            </tr>
                        </tfoot>
                        </table>
                    @endforeach                          
                @endif
                </div>
            </div>
        </div>
        <!-- Cotent end-->
    </div>


    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ"
        crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm"
        crossorigin="anonymous"></script>
    <!-- My JS -->
    <script src="js/Live_go.js"></script>
    <!-- DataTable + Bootstrap 4  cdn引用-->
    <script defer src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script defer src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
</body>

</html>