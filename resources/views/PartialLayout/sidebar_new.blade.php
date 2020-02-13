{{-- <nav id="sidebar">
    <div class="row">
        <ul class="list-unstyled component_icon col-md-4 pl-3" id="sidebaricon">
            <li class="pt-3 pb-3">
                <img src="img/logo(white).png" style="height: 4rem;" alt="">
            </li>
            <li>
                <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false"
                    class="dropdown-toggle text-center">
                    <i class="fa fa-home"></i>
                </a>
            </li>
            <li>
                <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false"
                    class="dropdown-toggle text-center">
                    <i class="fa fa-user-circle"></i>
                </a>
            </li>
            <ul class="position-fixed list-unstyled " style="bottom: 0;z-index: 2008;">
                <li class="position-fixed list-unstyled"  style="bottom: 0;z-index: 2008;">
                    <span class="Timer text-center"></span>
                    <br>
                    <a id="sidebarCollapse" class="text-center">
                        <i class="fa fa-angle-double-left"></i>
                    </a>
                </li>
            </ul>
        </ul>
        <ul class="list-unstyled components col-md-8" id="sidebarcontent">
            <ul class="collapse list-unstyled " id="homeSubmenu" data-parent="#sidebar">
                <li>
                    <a href="#">Home 1</a>
                </li>
                <li>
                    <a href="#">Home 2</a>
                </li>
                <li>
                    <a href="#">Home 3</a>
                </li>
            </ul>
            <ul class="collapse list-unstyled" id="pageSubmenu" data-parent="#sidebar">
                <li>
                    <a href="#">Page 1</a>
                </li>
                <li>
                    <a href="#">Page 2</a>
                </li>
                <li>
                    <a href="#">Page 3</a>
                </li>
            </ul>
        </ul>
    </div>
</nav> --}}
<nav id="sidebar" class="active">
    <div class="row">
        <ul class="list-unstyled component_icon col-md-4 pl-3" id="sidebaricon">
            <li class="pt-3 pb-3">
                <img src="img/logo(white).png" style="height: 4rem;" alt="">
            </li>
            <li onclick="location.href='{{ route('streaming_index') }}';" data-toggle="tooltip" data-placement="right" title="開啟直播">
                <a data-toggle="collapse" aria-expanded="false"
                    class="dropdown-toggle text-center">
                    <i class="fas fa-podcast"></i>
                </a>
            </li>
            <li onclick="location.href='{{ route('setting') }}';" data-toggle="tooltip" data-placement="right" title="粉絲團設定">
                <a data-toggle="collapse" aria-expanded="false"
                    class="dropdown-toggle text-center">
                    <i class="fas fa-cog"></i>
                </a>
            </li>
            <li onclick="location.href='{{ route('product_show') }}';" data-toggle="tooltip" data-placement="right" title="商品總覽">
                <a data-toggle="collapse" aria-expanded="false"
                    class="dropdown-toggle text-center">
                    <i class="fas fa-box-open"></i>
                </a>
            </li>
            <li onclick="location.href='{{ route('order') }}';" data-toggle="tooltip" data-placement="right" title="訂單總覽">
                <a data-toggle="collapse" aria-expanded="false"
                    class="dropdown-toggle text-center">
                    <i class="fas fa-copy"></i>
                </a>
            </li>
            <li onclick="location.href='{{ route('member') }}';" data-toggle="tooltip" data-placement="right" title="會員總覽">
                <a data-toggle="collapse" aria-expanded="false"
                    class="dropdown-toggle text-center">
                    <i class="fas fa-user"></i>
                </a>
            </li>
            <ul class="position-fixed list-unstyled " style="bottom: 0;z-index: 2008;">
                <li class="position-fixed list-unstyled"  style="bottom: 0;z-index: 2008;">
                    <span class="Timer text-center"></span>
                    <br>
                    {{-- <a id="sidebarCollapse" class="text-center">
                        <i class="fa fa-angle-double-left"></i>
                    </a> --}}
                </li>
            </ul>
        </ul>
    </div>
</nav>

<style>
    #content{
        width: calc(100% - 83.3333333px) !important;
    }
    #sidebar{
        margin-left: -166.666667px !important;
        transition: all 0.3s;
        
    }
    #sidebar #sidebaricon{
    margin-left:  166.666667px;
    transition: all 0.3s;
    }
</style>