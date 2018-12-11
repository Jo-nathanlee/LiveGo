<!-- Page Content  -->
<?php
$page = Page::where('fb_id', Auth::user()->fb_id)->first();
$page_id = $page->page_id;
?>
<nav class="navbar navbar-expand-sm ">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="#">
            <ul class="nav navbar-nav">
                <li class="float-right">
                    <button type="button" id="sidebarCollapse" class="btn">
                        <i class="fas fa-align-left"></i>
                    </button>
                </li>
            </ul>
            <ul class="nav navbar-nav ml-auto">
                @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @else
                <!-- <li class="nav-item dropdown ml-auto">
                    <a class="nav-link" href="#" id="Notice" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        通知
                        <sup>
                            <span class="badge rounded-circle badge-danger"></span>
                        </sup>
                    </a>
                    <div id="notification-list" class="dropdown-menu dropdown-menu-right" aria-labelledby="Notice">
                        <a href="#">
                            <img src="">
                            <div class="notification-message">
                            </div>
                        </a>
                    </div>
                </li> -->
                <li class="dropdown ml-auto">
                    <a href="#" id="Account" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="https://graph.facebook.com/{{Auth::user()->fb_id}}/picture" class="rounded-circle"
                        />
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="Account">
                        <a class="dropdown-item" href="{{ route('buyer_index', ['page_id'=>$page_id]) }}">來福逛逛</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                       {{ __('登出') }}</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>