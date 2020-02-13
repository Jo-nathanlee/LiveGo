<nav id="sidebar" class="active">
    <div class="row">
        <ul class="list-unstyled component_icon col-md-4 pl-3" id="sidebaricon">
            <li class="pt-3 pb-3">
                <img src="img/logo(white).png" style="height: 4rem;" alt="">
            </li>
            <li onclick="location.href='{{ route('buyer_shop', ['page_id'=>$page_id]) }}';" data-toggle="tooltip" data-placement="right" title="商城">
                <a data-toggle="collapse" aria-expanded="false"
                    class="dropdown-toggle text-center">
                    <i class="fas fa-home"></i>
                </a>
            </li>
            <li onclick="location.href='{{ route('buyer_cart', ['page_id'=>$page_id, 'uid'=>$ps_id]) }}';" data-toggle="tooltip" data-placement="right" title="購物車">
                <a data-toggle="collapse" aria-expanded="false"
                    class="dropdown-toggle text-center">
                    <i class="fas fa-shopping-bag"></i>
                </a>
            </li>
            <li onclick="location.href='{{ route('remittance', ['page_id'=>$page_id]) }}';" data-toggle="tooltip" data-placement="right" title="匯款資訊">
                <a data-toggle="collapse" aria-expanded="false"
                    class="dropdown-toggle text-center">
                    <i class="fa fa-credit-card" aria-hidden="true"></i>
                </a>
            </li>
            <!-- <li>
                <a href="userOrder" data-toggle="collapse" aria-expanded="false"
                    class="dropdown-toggle text-center">
                    <i class="fa fa-clipboard"></i>
                </a>
            </li> -->
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
<div class="modal fade" id="cellModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-full" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><img src="img/logo(white).png" style="height: 4rem;" alt="">LiveGO ｜ 結帳</h5>
                <h3 class="modal-title pt-2">
                        <div class="user_p">
                            <img src="https://graph.facebook.com/{{Auth::user()->fb_id}}/picture" alt="photo">
                        </div>
                        <div class="user_n">{{Auth::user()->name}}</div>
                    <span aria-hidden="true" class="text-white" class="close h4" data-dismiss="modal" aria-label="Close"><i class="fas fa-align-justify"></i></span>
                </h3>
            </div>
            <div class="modal-body p-4 h1" id="result">
                <ul class="list-group">
                    <li class="list-group-item border-left-0 border-top-0 border-right-0" onclick="location.href='{{ route('buyer_shop', ['page_id'=>$page_id]) }}';"><i class="fas fa-home mr-3"></i>商城</li>
                    <li class="list-group-item border-left-0 border-right-0" onclick="location.href='{{ route('buyer_cart', ['page_id'=>$page_id, 'uid'=>$ps_id]) }}';"><i class="fa fa-shopping-bag mr-3"></i>購物車</li>
                    <li class="list-group-item border-left-0 border-right-0" onclick="location.href='{{ route('remittance', ['page_id'=>$page_id]) }}';"><i class="fa fa-credit-card mr-3" aria-hidden="true"></i>匯款資訊</li>
                </ul>
            </div>
            <div class="modal-footer" style="justify-content: center!important;">
                    <span class="badge badge-pill btn-outline-light border" style="border-color: white;font-size: large;">改版資訊 v2.3</span>｜
                    <span href="" class="nav-link navbar_R23" data-toggle="tooltip" data-placement="top" title="登出"><i
                        class="fa fa-power-off"></i>登出帳號</span>
            </div>
        </div>
    </div>
</div>
<style>

    #result ul li{
        background-color: black;
        color: white;
        border-color: white;
        padding: 1rem;
    }

    .navbar-nav {
        flex-direction: inherit !important;
    }
    #content{
        width: calc(100% - 83.3333333px) !important;
    }
    #sidebar{
        margin-left: -166.666667px !important;
        transition: all 0.3s;
        
    }
    .modal-full {
        min-width: 100%;
        margin: 0;
    }

    .modal-full .modal-content {
        min-height: 100vh;
        background:black;
        color:white;
    }

    #sidebar #sidebaricon{
    margin-left:  166.666667px;
    transition: all 0.3s;
    }

    @media (max-width: 800px) {
        #sidebar {
            display: none;
        }
        #content {
            width: calc(100%) !important;
        }

        .foot_img {
            width: 20px;
            height: 20px;
        }

        #navbarSupportedContent{
            display: none;
        }

        #cellphone_drop{
            display: inline-block !important;
        }
    }

</style>