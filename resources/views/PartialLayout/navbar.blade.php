<?php
use App\Entities\Page;
use Illuminate\Support\Facades\Auth;
$page = Page::where('as_id', Auth::user()->fb_id)->first();
$page_id = $page->page_id;
$page_token = $page->page_token;
$page_name = $page->page_name;
?>
<nav class="navbar navbar-expand-lg navbar-light ">
    <img src="img/foot.png" alt="foot" class="foot_img">
    <div class="container-fluid">
        <div class="user_pn">
            <div class="user_p">
                <img src="https://graph.facebook.com/{{$page_id}}/picture?type=large&access_token={{$page_token}}" alt="photo">
            </div>
            <div class="user_n">{{$page_name}}</div>
        </div>
        <button class="btn btn-dark d-none ml-auto" id="cellphone_drop" data-toggle="modal" data-target="#cellModal" type="button">
            <i class="fas fa-align-justify"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="nav navbar-nav ml-auto">
                <li class="nav-item ">
                    <a href="" class="nav-link small text-muted navbar_R1">改版資訊 v2.3</a>
                </li>
                <li class="nav-item ">
                        <a href="{{ route('buyer_shop', ['page_id'=>$page_id]) }}" class="nav-link navbar_R23" data-toggle="tooltip" data-placement="top" title="來去逛逛" style="margin-left: 5px;">
                        <i class="fas fa-shopping-cart"></i></a>
                </li>
                <li class="nav-item ">
                    <a href="{{ route('logout') }}" class="nav-link navbar_R23" data-toggle="tooltip" data-placement="top" title="登出"><i
                            class="fa fa-power-off"></i></a>
                </li>
            </ul>
        </div>
    </div>
</nav>
