<nav id="sidebar" class="sidebar_shadow">
    <div class="sidebar-header">
        <h3 class="Z_top">
        <a href="{{ route('seller_index') }}" ><img src="img/livego.png" class="s" />Live GO</h3></a>
    </div>

    <ul class="list-unstyled components">
        <p></p>
        <li>
            <a href="{{ route('set_page') }}" >
                <i class="icofont icofont-home"></i>粉絲團設定</a>
        </li>
        <li>
            <a href="{{ route('index_load') }}">
                <i class="icofont icofont-video-cam"></i>開啟直播</a>
        </li>
        <li>
            <a href="{{ route('SetProduct_show') }}">
                <i class="icofont icofont-settings-alt"></i>直播商品設定</a>
        </li>
        <li>
            <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <i class="icofont icofont-prestashop"></i>來福逛逛設定</a>
            <ul class="collapse list-unstyled" id="pageSubmenu">
                <li>
                    <a href="{{ route('AddProduct_show') }}">新增商品</a>
                </li>
                <li>
                    <a href="{{ route('product_overview') }}">來福逛逛總覽</a>
                </li>
            </ul>
        </li>
        <!-- <li>
            <a href="#">
                <i class="icofont icofont-gift"></i>抽獎</a>
        </li> -->
    </ul>
</nav>
