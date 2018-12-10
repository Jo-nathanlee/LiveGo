<nav id="sidebar" class="sidebar_shadow">
    <div class="sidebar-header">
        <h3 class="Z_top">
        <a href="{{ route('seller_index') }}" ><img src="img/livego.png" class="s" />Live GO</h3></a>
    </div>

    <ul class="list-unstyled components">
        <p></p>
        <li>
            <a href="{{ route('index_load') }}">
                <i class="icofont icofont-video-cam"></i>開啟直播</a>
        </li>
        <li>
            <a href="{{ route('StreamingProductOverview') }}">
                <i class="icofont icofont-settings-alt"></i>直播商品設定</a>
        </li>
        <li>
            <a href="#pageSubmenuㄉ" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <i class="icofont icofont-home"></i>粉絲團設定
            </a>
            <ul class="collapse list-unstyled" id="pageSubmenuㄉ">
                <li>
                    <a href="{{ route('set_page') }}">綁定粉絲團</a>
                </li>
                <li>
                    <a href="{{ route('company_info') }}">商城基本設定</a>
                </li>
                <li>
                    <a href="{{ route('delivery') }}">物流設定</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="{{ route('bid_winner') }}" >
                <i class="icofont icofont-list"></i>得標者清單</a>
        </li>
        <li>
            <a href="{{ route('membership') }}" >
                <i class="icofont icofont-male"></i>會員名單</a>
        </li>
        <li>
            <a href="{{ route('seller_order') }}" >
                <i class="icofont icofont-paper"></i>我的訂單</a>
        </li>
        <li>
            <a href="#pageSubmenuˇ" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <i class="icofont icofont-investigator"></i>棄標黑名單
            </a>
            <ul class="collapse list-unstyled" id="pageSubmenuˇ">
                <li>
                    <a href="{{ route('bid_blacklist') }}">棄標黑名單</a>
                </li>
                <li>
                    <a href="{{ route('blacklist_time') }}">棄標時間設定</a>
                </li>
            </ul>
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

