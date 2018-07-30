<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <!-- emoji css & js  -->
    <link rel="stylesheet" href="css/emojionearea.css">
    <script src="js/emojionearea.js"></script>
    <!-- altertify CSS & JS -->
    <link rel="stylesheet" href="css/alertify.min.css">
    <script src="js/alertify.min.js"></script>
</head>
<script>
    $(function () {
        $("#navbar_page").load("navbar_page.html");
        $("#sidebar_page").load("sidbar_page.html");
    });



      $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
            //抓取留言
            setInterval(function () {
                ajax();
            }, 500);
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            function ajax() {

            $.ajax({
                    /* the route pointing to the post function */
                    url: '/update_message',
                    type: 'POST',
                    /* send the csrf-token and the input to the controller */
                    data: { video_id:'{{$video_id}}',page_token:'{{$token}}',_token:CSRF_TOKEN},   //
                    dataType: 'JSON',
                    /* remind that 'data' is the response of the AjaxController */
                    success: function (data) {
                        if(data!=null)
                        {
                            $("#tbody").children().remove();
                        $.each(data, function(i, comment) {
                            $( "#tbody" ).append(
                            "<tr class='border-bottom'> <td>\
                                        <img src='' />\
                                    </td><td><h6>"+comment.from.name+
                                "<i class='icofont icofont-star'></i>\
                                 <i class='icofont icofont-star'></i>\
                                 <i class='icofont icofont-star'></i>\
                                 <i class='icofont icofont-star'></i>\
                                </h6>\
                                <small>"+comment.message+"</small>\
                                    </td>\
                                    <td>\
                                        <button type='button' class='btn btn-xm btn-primary'>\
                                            <i class='icofont icofont-speech-comments'></i>訊息</button>\
                                        <button type='button' class='btn btn-xm btn-danger'>置頂</button>\
                                        <button type='button' class='btn btn-xm btn-danger'>得標</button>\
                                    </td></tr>");
                            });
                        }
                    }
            });
            }


            //按開始競標
            $( "#time_start" ).click(function() {
                var goods_name=$("#goods_name").val();
                alertify.prompt('系統訊息', '請確認商品名稱是否為'+goods_name+'?'
            , function (evt, value) {
                CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                var now=new Date();
                var start_time=now.getFullYear()+"-"+(now.getMonth()+1)+"-"+now.getDate()+" "+now.getHours()+":"+now.getMinutes()+":"+now.getSeconds();
                    $.ajax({
                            /* the route pointing to the post function */
                            url: '/start_record',
                            type: 'POST',
                            /* send the csrf-token and the input to the controller */
                            data: { start_time:start_time},
                            dataType: 'JSON',
                            /* remind that 'data' is the response of the AjaxController */
                            success: function (data) {
                                //禁止修改名稱及+1最高價制
                                $("#goods_name").attr("disabled", true);
                                $("#type").attr("disabled", true);
                                //start->end
                                $("#time_start").removeClass("d-block").addClass("d-none");
                                $("#time_end").removeClass("d-none").addClass("d-block");

                                $("#buyer_list").children().remove();
                                $( "#buyer_list" ).append("<li class='list-group-item list-group-item-action list-group-item-info '>\
                                    <B>得標清單</B>\
                                </li>");
                            },
                            error: function(xhr, status, error) {
                                alert(error);
                            }
                    });

            });





            });


            //按結束競標
            $( "#time_end" ).click(function() {

                var type=$("#type").find("option:selected").val();
                var now=new Date();
                var end_time=now.getFullYear()+"-"+(now.getMonth()+1)+"-"+now.getDate()+" "+now.getHours()+":"+now.getMinutes()+":"+now.getSeconds();
                //+1制
                if(type==1)
                {
                    $.ajax({
                            /* the route pointing to the post function */
                            url: '/end_record',
                            type: 'POST',
                            /* send the csrf-token and the input to the controller */
                            data:{ video_id:'{{$video_id}}',page_token:'{{$token}}',end_time:end_time},
                            dataType: 'JSON',
                            /* remind that 'data' is the response of the AjaxController */
                            success: function (data) {
                                if(data!="")
                                {
                                    var data = JSON.parse(data);
                                    $.each(data, function(i, comment) {
                                    $( "#buyer_list" ).append("<li class='list-group-item '>\
                                    <div id='bid-list-iformation ' aria-labelledby='Notice '>\
                                        <a>\
                                            <div class='text-truncate w-100 '>\
                                                <div class='d-flex w-100 justify-content-between '>\
                                                    <h6 class='mb-1 '>\
                                                        <b>"+comment.name+"</b>\
                                                    </h6>\
                                                    <small class='text-muted float-right ' >\
                                                        <button type='button' class='btn btn-xm btn-danger' ='delete'>刪除</button>\
                                                    </small>\
                                                    <input type='hidden' id='fb_id' value='"+comment.id+"'>\
                                                    <input type='hidden' id='message_time' value='"+comment.message_time+"'></div>\
                                                    <input type='hidden' id='message_id' value='"+comment.message_id+"'></div>\
                                                <small id='comment'>"+comment.message+"</small>\
                                            </div>\
                                        </a>\
                                    </div>\
                                </li>");
                                     });
                                     $( "#buyer_list" ).append("<li class='sticky-bottom list-group-item border-top-0'>\
                                    <div class='col-md-12 text-center'>\
                                        <button type='button' id='confirm' class='btn btn-secondary  btn-block' >確定</button>\
                                    </div>\
                                </li>");
                                }
                            },
                            error: function(xhr, status, error) {
                                alert(error);
                            }

                    });
                }
                //最高價制
                else
                {
                    $.ajax({
                            /* the route pointing to the post function */
                            url: '/end_record_top_price',
                            type: 'POST',
                            /* send the csrf-token and the input to the controller */
                            data: { video_id:'{{$video_id}}',page_token:'{{$token}}',time:end_time},
                            dataType: 'JSON',
                            /* remind that 'data' is the response of the AjaxController */
                            success: function (data) {
                                if(data!=null)
                                {
                                    var data = JSON.parse(data);
                                    var price=data[0].price;
                                    $("#goods_price").val(price);
                                    $( "#buyer_list" ).append("<li class='list-group-item '>\
                                    <div id='bid-list-iformation ' aria-labelledby='Notice '>\
                                        <a>\
                                            <div class='text-truncate w-100 '>\
                                                <div class='d-flex w-100 justify-content-between '>\
                                                    <h6 class='mb-1 '>\
                                                        <b>"+data[0].name+"</b>\
                                                    </h6>\
                                                    <small class='text-muted float-right ' >\
                                                        <button type='button' class='btn btn-xm btn-danger' ='delete'>刪除</button>\
                                                    </small>\
                                                    <input type='hidden' id='fb_id' value='"+data[0].id+"'>\
                                                    <input type='hidden' id='message_time' value='"+data[0].message_time+"'></div>\
                                                    <input type='hidden' id='message_id' value='"+data[0].message_id+"'></div>\
                                                <small id='comment'>"+data[0].price+"</small>\
                                            </div>\
                                        </a>\
                                    </div>\
                                </li>");
                                }
                            },
                            error: function(xhr, status, error) {
                                alert(error);
                            }
                    });
                }
                $("#time_end").removeClass("d-block").addClass("d-none");
                $("#time_start").removeClass("d-none").addClass("d-block");
            });

            //得標清單點擊刪除
            $( "#delete" ).each(function(index) {
                $(event.target).click(function(e){
                    $(event.target).parent().remove();
                });
            });
            //點擊確認後，將得標清單轉成array or json傳至後台存入資料庫
            $('#buyer_list').on('click','button', function(){
                var buyer = [];

                for (i = 2; i < $("#buyer_list>li").length; i++) {
                    var name = $("ul li:nth-child("+i+")").find("b").html();
                    var comment = $("ul li:nth-child("+i+")").find("#comment").html();
                    var id=$("ul li:nth-child("+i+")").find("#fb_id").val();
                    var message_id=$("ul li:nth-child("+i+")").find("#message_id").val();
                    tmp = {
                        'name': name,
                        'comment': comment,
                        'id':id,
                        'message_id':message_id,
                    };

                    buyer.push(tmp);
                }
                var type=$("#type").find("option:selected").val();
                var goods_name=$("#goods_name").val();
                var goods_price=$("#goods_price").val();
                var note=$("#note").val();

                $.ajax({
                            /* the route pointing to the post function */
                            url: '/store_streaming_order',
                            type: 'POST',
                            /* send the csrf-token and the input to the controller */
                            data: {type:type,buyer:buyer,goods_name:goods_name,note:note,page_token:'{{$token}}',goods_price:goods_price,_token:CSRF_TOKEN},
                            dataType: 'JSON',
                            /* remind that 'data' is the response of the AjaxController */
                            success: function (data) {
                                $("#buyer_list").children().remove();
                                $( "#buyer_list" ).append("<li class='list-group-item list-group-item-action list-group-item-info '>\
                                    <B>得標清單</B>\
                                </li>");
                                alert("得標訊息已私訊得標者!");
                            },
                            error: function(XMLHttpRequest, status, error) {
                                alert(error);
                                alert(XMLHttpRequest.status);
                                alert(XMLHttpRequest.responseText);
                            }
                    });
            });





       });

                //貼文留言
                function enter_event(event) {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                var x = event.which || event.keyCode;
                if(x==13)
                {
                    var comment_message=$(".emojionearea-editor").text();
                    $.ajax({
                            /* the route pointing to the post function */
                            url: '/add_comment',
                            type: 'POST',
                            /* send the csrf-token and the input to the controller */
                            data: {comment:comment_message,post_video_id:'{{$post_video_id}}',page_token:'{{$token}}',_token:CSRF_TOKEN},
                            dataType: 'JSON',
                            /* remind that 'data' is the response of the AjaxController */
                            success: function (data) {
                                $(".emojionearea-editor").html("");
                            },
                            error: function(XMLHttpRequest, status, error) {
                                $(".emojionearea-editor").html("");
                                alert(error);
                                alert(XMLHttpRequest.status);
                                alert(XMLHttpRequest.responseText);
                            }
                    });
                }
                 }
</script>


<body>
    <div class="wrapper">
        <div id="sidebar_page"></div>
        <!-- Page Content  -->
        <div id="content">
            <div id="navbar_page"></div>
            <!--Nav bar end-->
            <div id="main" class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div id="main-top" class="col-md-12 row">
                            <div class="col-md-5">
                                <!-- <iframe src="{!! $url !!}" class="float-left" width="300" height="400" style="border:none;overflow:hidden" scrolling="no"
                                    frameborder="0" allowTransparency="true" allow="encrypted-media" allowFullScreen="true"></iframe> -->
                                    {!! $url !!}
                            </div>
                            <div class="col-md-7">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">商品名稱 :</span>
                                    </div>
                                    <input type="text" class="form-control" id="goods_name">
                                    <div class="input-group-append dropright">
                                        <button type="button" class="btn btn-outline-secondary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="icofont icofont-animal-elephant"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">成交價格 :</span>
                                    </div>
                                    <input type="text" class="form-control" id="goods_price">
                                    <div class="input-group-append dropright">
                                        <button type="button" class="btn btn-outline-secondary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="icofont icofont-animal-elephant"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">商品備註 :</span>
                                    </div>
                                    <input type="text" class="form-control" id="note">
                                    <div class="input-group-append dropright">
                                        <button type="button" class="btn btn-outline-secondary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="icofont icofont-animal-elephant"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">得標模式 :</span>
                                    </div>
                                    <select class="custom-select h-100" id="type">
                                        <option class="dropdown-item" value="1" selected>+1</option>
                                        <option class="dropdown-item" value="2">競標</option>
                                    </select>
                                </div>
                                <div class="input-group">
                                    <button type="button" id="time_start" class="btn btn-outline-secondary col-md-12 d-block ">開始競標</button>
                                    <button type="button" id="time_end" class="btn btn-outline-secondary col-md-12 d-none ">結束競標</button>
                                </div>
                            </div>
                        </div>
                        <div id="main-down " class="col-md-12 pt-4">
                            <ul class="list-group float-right border-bottom bid-list " id="buyer_list">
                                <li class="list-group-item list-group-item-action list-group-item-info sticky-top">
                                    <B>得標清單</B>
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div id="fb-comments" class="row">
                        <table class="table" id="table">
                            <tbody class="border-right border-left rounded-top" id="tbody">



                            </tbody>
                            <tfoot class="border">
                                <tr>
                                    <td class="form-inline ">
                                        <div class="col-md-1">
                                            <img src="https://scontent.ftpe7-1.fna.fbcdn.net/v/t1.0-1/p80x80/27544740_1698786326811478_2378412843466290049_n.jpg?_nc_cat=0&_nc_eui2=AeGj2lxirc9EFStzOmhxpwG5oJnoKPn6THKaB_rWhyr3AO6qrYkHnq9vWuBhSJBfRUZozTnIRqtjP1BgvUx1G4ZhlzxZshNmhPq7uyI8CZzc1g&oh=1aeb5d31f5b4bf76c2b61083d338f9f7&oe=5BB809E9"
                                                class="rounded-circle" />
                                        </div>
                                        <div class="col-md-11">
                                            <div id="comment_icon">
                                                <i class="icofont icofont-audio"></i>
                                            </div>
                                            <input type="text" id="comment-message" class="ml-3 mr-4" placeholder="留言 ..." onkeypress="myFunction(event)">

                                            <script type="text/javascript">
                                                $(document).ready(function () {
                                                    $("#comment-message").emojioneArea({
                                                        autocomplete: true,
                                                        tones: true,
                                                        shortnames: true,
                                                        search: false
                                                    });
                                                });
                                            </script>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Cotent end-->
    </div>

    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js " integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ "
        crossorigin="anonymous "></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js " integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm "
        crossorigin="anonymous "></script>
    <!-- My JS -->
    <script src="js/Live_go.js "></script>
</body>

</html>
