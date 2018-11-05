<nav class="navbar-ft navbar-expand-sm">
    <div class="container-fluid">
        <div class="collapse navbar-collapse  col-offset-1" id="#">
            <ul class="nav-shop navbar-nav">
                <li class="float-right">
                    <button type="button" class="btn btn-outline-dark" id="sidebarCollapse" class="btn">
                        <i class="fas fa-align-left"></i>
                    </button>
                </li>
                <li class="nav-item-shop">
                    <a class="nav-link" href="#">追蹤我們
                        <i class="icofont icofont-social-facebook"></i>
                        <i class="icofont icofont-social-instagram"></i>
                    </a>
                </li>
            </ul>
            <ul class="nav-shop navbar-nav ml-auto">
                <li class="nav-item-shop">
                    <a class="nav-link" href="#">
                        <i class="icofont icofont-ui-video-play"></i> 節目表</a>
                </li>
                <li class="nav-item-shop">
                    <a class="nav-link" href="#">
                        <i class="icofont icofont-list"></i> 歷史訂單</a>
                </li>
                <li class="nav-item-shop">
                    <a class="nav-link" href="#">
                        <i class="icofont icofont-social-kakaotalk"></i> 提醒</a>
                </li>
                <li class="dropdown ml-auto">
                    <a href="#" id="Account" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="https://graph.facebook.com/{{Auth::user()->fb_id}}/picture" class="rounded-circle mt-1"
                        />
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="Account">
                        <a class="dropdown-item" href="{{ route('buyer_index') }}">來去逛逛</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                            {{ __('登出') }}</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>

<nav class="navbar-sec navbar-expand-sm ">
    <div class="container-fluid ">
        <div class="collapse navbar-collapse" id="#">
            <ul class="nav-shop navbar-nav col-md-3 col-offset-1">
                <li>
                    <H3 style="font-family:Microsoft JhengHei;" class="mt-2 text-nowrap">
                        <img src="img/livego.png" />來福逛逛</H3>
                </li>
            </ul>
            <ul class="nav-shop col-md-7 ">
                <div class="input-group"  id="search-box">
                    <input class="form-control py-2 border-right-0 border" type="search" placeholder="Search">
                    <div class="input-group-append ">
                        <div class="input-group-text align-middle" id="btnGroupAddon2">
                            <i class="fa fa-search"></i>
                        </div>
                    </div>
                </div>
            </ul>
            <ul class="nav-shop navbar-nav ml-auto col-md-1">
                <li class="nav-item-shop">
                    <a class="nav-link" href="#">
                        <a href="{{ route('buyer_index') }}"><i class="icofont icofont-cart-alt text-center h3"></i></a>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>