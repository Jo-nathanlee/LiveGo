    @extends('layouts.master')

@section('title','綁定粉絲團')

@section('wrapper')
<div class="wrapper">
@stop
    <!-- Page Content  -->
    @section('navbar')   
    <div id="content">     
            <!--Nav bar end-->
        @stop
        @section('content')          
        <div class="container-fluid all_content overflow-auto" id="ChooseFanGroup">
            <div class="row">
                <div class="col-md-12">
                    <form id="Chose_fan" action="{{ route('save_page') }}" method="POST">
                        {{ csrf_field() }} 
                        @foreach($page as $key)
                        <div class="media bg-white p-4 rounded border">
                            <img class="d-flex mr-3" src="{{$key[2]}}">
                            <div class="media-body">
                                <h5 class="mt-0">{{$key[0]}}</h5>
                                粉絲團ID：{{$key[1]}}
                            </div>
                            <div class="m-auto">
                                <div class="custom-control custom-checkbox">
                                    @if($key[4])
                                    <input type="checkbox" class="custom-control-input"  id="{{$key[1]}}" name="id" value="{{$key[1]}},{{$key[0]}},{{$key[3]}},{{$key[2]}}" checked>
                                    @else
                                    <input type="checkbox" class="custom-control-input"  id="{{$key[1]}}" name="id" value="{{$key[1]}},{{$key[0]}},{{$key[3]}},{{$key[2]}}">
                                    @endif
                                    <!--id擺放粉絲團ID-->
                                    <label class="custom-control-label" for="{{$key[1]}}"></label>
                                    <!--for擺放粉絲團ID-->
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <div class="text-center mt-2">
                            <input type="submit" class="btn btn-secondary " value="確定">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Cotent end-->
    </div>
</div>
<script>
    $( document ).ready(function() {
        const driver = new Driver();

        driver.defineSteps([
                {
                    element: '#sidebarCollapse',
                    popover: {
                        title: '點選按鈕',
                        description: '可以縮放左方導覽列',
                        position: 'bottom'
                    }
                },
                {
                    element: '.dropdown.dropleft',
                    popover: {
                        title: '點選頭像',
                        description: '可以登出或是到來福逛逛頁面',
                        position: 'left'
                    }
                },
                {
                    element: '.media.bg-white.p-4.rounded.border',
                    popover: {
                        title: '選取想要開直播的粉絲團',
                        description: '只有加入LiveGO企業平台之粉絲團才能使用此系統！',
                        position: 'bottom'
                    }
                },
                {
                    element: '.custom-control.custom-checkbox',
                    popover: {
                        title: '選取粉絲團',
                        description: '勾選管理之粉絲團',
                        position: 'left-bottom'
                    }
                },
                {
                    element: '.btn.btn-secondary ',
                    popover: {
                        title: '點選確定',
                        description: '儲存管理之粉絲團',
                        position: 'top'
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
