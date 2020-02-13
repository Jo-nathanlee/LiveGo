@extends('layouts.master')

@section('title','棄標黑名單')
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
        <div class="container-fluid all_content overflow-auto" id="Black_List">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <table id="table_blacklist" class="table" >
                                <thead>
                                    <tr>
                                        <th>圖片</th>
                                        <th>姓名</th>
                                        <th>棄標次數</th>
                                        <th>狀態</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($blacklist as $blacklist)
                                    <tr id="blacklist_item">
                                        <td scope="row">
                                            <img id="blacklist_img" src="https://graph.facebook.com/{{  $blacklist->fb_id }}/picture?type=normal&access_token={{ $page_token }}" class="img-fluid img" style="height:64px;width:64px">
                                        </td>
                                        <td>{{ $blacklist->fb_name }}</td>
                                        <td>{{ $blacklist->blacklist_times }}</td>
                                        @if( $blacklist->is_block == "正常")
                                            <td id="{{ $blacklist->fb_id }}"><span class="badge is_block badge-success" id="is_block" >{{ $blacklist->is_block }}</span></td>
                                        @else 
                                            <td id="{{ $blacklist->fb_id }}"><span class="badge is_block badge-danger" id="is_block" >{{ $blacklist->is_block }}</span></td>
                                        @endif
                                        <td><button class="btn btn-sm btn-outline-secondary" onclick="Edit_Block_State('{{ $blacklist->fb_id }}')">更改狀態</button></td>
                                        <td><button class="btn btn-secondary" onclick="location.href='{{route('bid_blacklist_detail', ['key' =>$blacklist->fb_id ])}}';">查看詳情</button></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>   
                    </div>
                </div>
                <!-- 訂單列表end -->
            </div>
        </div>        
    </div>
    <!-- Cotent end-->
</div>

<script>
    $( document ).ready(function() {
        const driver = new Driver();
        driver.defineSteps([
                {
                    element: '#table_blacklist_length > label',
                    popover: {
                        title: '選取資料筆數',
                        description: '調整顯示黑名單會員筆數',
                        position: 'bottom'
                    }
                },
                {
                    element: '#table_blacklist_filter > label',
                    popover: {
                        title: '快速尋找黑名單會員',
                        description: '只需輸入關鍵字即可！',
                        position: 'bottom'
                    }
                },
                {
                    element: '#Black_List',
                    popover: {
                        title: '查看姓名、棄標次數與狀態',
                        description: '從中可以輕鬆得知粉絲購物狀況',
                        position: 'left',
                        padding: -45
                    }
                },
                {
                    element: '#blacklist_item > td:nth-child(5) > button',
                    popover: {
                        title: '更改黑名單狀態',
                        description: '點選進入修改頁面',
                        position: 'left'
                    }
                },
                {
                    element: '#blacklist_item > td:nth-child(6) > button',
                    popover: {
                        title: '點選查看詳情',
                        description: '查看進一步黑名單會員資訊',
                        position: 'left-bottom'
                    }
                }
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