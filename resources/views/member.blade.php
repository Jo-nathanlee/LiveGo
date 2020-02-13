@extends('layouts.master')

@section('title','會員')

@section('head_extension')

<style>
    .right_bottom{
        position:fixed;
        z-index: 200000;
        right: 2.8rem;
        bottom: 2.2rem;
        background-color: #009944;
        width: 3.5rem;
        height: 3.5rem;
        padding: 0.5rem;
        opacity: 0.8;
    }
    .right_bottom:hover {
        opacity: 1 !important;
    }


    .right_bottom img:hover {
        animation: shake 0.82s cubic-bezier(.36,.07,.19,.97) both;
        transform: translate3d(0, 0, 0);
        backface-visibility: hidden;
        perspective: 1000px;
    }

    @keyframes shake {
        10%, 90% {
            transform: translate3d(-1px, 0, 0);
        }
        
        20%, 80% {
            transform: translate3d(2px, 0, 0);
        }

        30%, 50%, 70% {  
            transform: translate3d(-4px, 0, 0);
        }

        40%, 60% {
            transform: translate3d(4px, 0, 0);
        }
    }
</style>
@stop

@section('wrapper')
<div class="wrapper">
@stop
@section('navbar')
    <div id="content">
@stop
        @section('content')
            <table id="member" class="table table-striped  w-100" style="">
                <!-- background-color: green;height: 500px;padding: 1.5rem 1.5rem 0rem 1.5rem; -->
                <thead>
                    <tr>
                        <th>加入時間</th>
                        <th>會員姓名</th>
                        <th>訂單數量</th>
                        <th>總消費總金額</th>
                        <th>每次平均消費金額</th>
                        <th>訂單取消次數</th>
                        <th>黑名單</th>
                        <!-- <th></th> -->
                    </tr>
                </thead>
                <tbody>
                    @foreach ($member as $member)
                    <tr style="height:70px;"> <!-- 一個開始 -->
                        <th scope="row">{{$member->created_at}}</th>
                        <td>
                            <!-- <li class="d-flex align-items-center"> -->
                                <div class="mb_photo">
                                    <img src="https://graph.facebook.com/{{$member->ps_id}}/picture?type=large&access_token={{$page_token}}"
                                    class="nav-link rounded-circle">
                                </div>
                                <span>
                                    <a href="{{ route('member_detail', ['ps_id' => $member->ps_id]) }}"><span class="ml-2" style="display: inline-block;"> {{$member->fb_name}}<i class="fas fa-info-circle or_i_L" aria-hidden="true"></i></span></a> <br>
                                    <!-- <span class="badge badge-pill bg-gray">
                                        <a href="#"> <img src="img/fb.png" style="height: 1rem;" alt="點選查看個人專頁"></a>
                                        陳宣宣
                                    </span> -->
                                </span>

                            <!-- </li> -->
                        </td>
                        <td>{{$member->checkout_times}}</td>
                        <td class="currencyField">{{$member->money_spent}}</td>
                        @if($member->checkout_times > 0)
                            <td class="currencyField">{{ceil($member->money_spent / $member->checkout_times)}}</td>
                        @else 
                            <td class="currencyField">0</td>
                        @endif
                        <td>{{$member->cancel_times}}</td>
                        <td>
                            @if($member->member_type == 0)
                                <label class="switch seventy_percent">
                                    <input type="checkbox" onclick="black(this)" checked="checked" value="{{$member->ps_id}}"  class="chk_box">
                                    <span class="slider round slider-danger"></span>
                                </label>
                            @else
                                <label class="switch seventy_percent">
                                    <input type="checkbox" onclick="black(this)"  value="{{$member->ps_id}}"  class="chk_box">
                                    <span class="slider round slider-danger"></span>
                                </label>
                            @endif
                        </td>
                    </tr>   
                    @endforeach
                    <!-- 一個結尾 -->
                </tbody>
            </table>
            <div class="right_bottom rounded-circle shadow " onclick="location.href='{{ route('member_excel') }}';"  data-toggle="tooltip"
            data-placement="top" title="點選下載會員資料">
                <img src="img/ecxel.png" class="w-100">
            </div>
        @stop 
@section('footer')    


<script>
    var CSRF_TOKEN= $('meta[name="csrf-token"]').attr('content');
    alertify.set('notifier','position', 'top-center');
    //手動得標新增商品
    function black(element){
        $.LoadingOverlay("show");
        $.ajax({
            url: '/black',
            type: 'POST',
            data: { page_id:'{{$page_id}}',psid:$(element).val(),is_active:$(element).prop( 'checked' ),_token:CSRF_TOKEN},
            dataType: 'text',
            success: function (data) {
                $.LoadingOverlay("hide");
                alertify.success('成功更改會員狀態！');
                
            },
            error: function(XMLHttpRequest, status, error) {
                console.log(error);
                console.log(XMLHttpRequest.status);
                console.log(XMLHttpRequest.responseText);
            }
        });
    }

    $('#member').DataTable({
        "pagingType": "full_numbers",

        "oLanguage": {
            "sLengthMenu": "顯示 _MENU_ 筆資料",
            "sInfo": "共 _TOTAL_ 筆資料",
            "sSearch":"",

            "oPaginate": {
              "sFirst":" ",
              "sPrevious": " ",
              "sNext":" ",
              "sLast":" "
          }
        }
        
    });
</script>
@stop

