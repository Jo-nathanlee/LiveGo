@extends('layouts.master')

@section('title','金流設定')
@section('heads')
<script>
    function message_danger() {
        // error_code 接收錯誤代碼 error_msg 接收錯誤提示訊息
        var alert_div = document.createElement("div");
        alert_div.setAttribute('id', 'data_info');
        alert_div.setAttribute("class", "card-body align-middle h5 text-center bg-light");
        alert_div.innerHTML =
            "<strong><i class='icofont icofont-exclamation-circle h1'></i> </strong><div class='mt-4'>  {{ session('alert') }}</div>";
        var warp_div = document.createElement("div");

        warp_div.setAttribute("class", "card shadow show_msg_center  w-25 bg-light")
        warp_div.append(alert_div);
        $("html").append(warp_div);

        setTimeout(
            function () {
                $("#data_info").fadeToggle(1000);
            }, 2000);
        setTimeout(
            function () {
                $("#data_info").parent().remove();
            }, 3000);
    }
</script>
@stop

@section('wrapper')
<div class="wrapper">
    <div id="sidebar_page"></div>
@stop
@section('navbar')
    <!-- Page Content  -->
    <div id="content">
        <div id="navbar_page"></div>
        <!--Nav bar end-->
@stop
@section('content')
@if (session('alert'))
<script>
    message_danger();
</script>
@endif
        <div id="main" class="row">
            <div class="col-md-12">
                <form>
                    <div class="card">
                        <div class="card-body">
                            <font class="align-middle">本島常溫宅配</font>

                            <div class="onoffswitch1 float-right">
                                <input type="checkbox" name="onoffswitch1" class="onoffswitch1-checkbox" id="TW_Microtherm_Shipment">
                                <label class="onoffswitch1-label" for="TW_Microtherm_Shipment">
                                    <span class="onoffswitch1-inner"></span>
                                    <span class="onoffswitch1-switch"></span>
                                </label>
                            </div>
                            <div class="float-right">
                                <font class="align-middle text-right edit-money">$60</font>
                                <i class="icofont icofont-edit align-middle edit-icon"></i>
                            </div>
                        </div>
                        <div class="card-body">
                            <font class="align-middle">本島低溫宅配</font>
                            <div class="onoffswitch1 float-right">
                                <input type="checkbox" name="onoffswitch1" class="onoffswitch1-checkbox" id="TW_Homoeothermy_Shipment">
                                <label class="onoffswitch1-label" for="TW_Homoeothermy_Shipment">
                                    <span class="onoffswitch1-inner"></span>
                                    <span class="onoffswitch1-switch"></span>
                                </label>
                            </div>
                            <div class="float-right">
                                <font class="align-middle text-right edit-money">$60</font>
                                <i class="icofont icofont-edit align-middle edit-icon"></i>
                            </div>
                        </div>
                        <div class="card-body">
                            <font class="align-middle">外島常溫宅配</font>
                            <div class="onoffswitch1 float-right">
                                <input type="checkbox" name="onoffswitch1" class="onoffswitch1-checkbox" id="Microtherm_Shipment">
                                <label class="onoffswitch1-label" for="Microtherm_Shipment">
                                    <span class="onoffswitch1-inner"></span>
                                    <span class="onoffswitch1-switch"></span>
                                </label>
                            </div>
                            <div class="float-right">
                                <font class="align-middle text-right edit-money">$60</font>
                                <i class="icofont icofont-edit align-middle edit-icon"></i>
                            </div>
                        </div>
                        <div class="card-body">
                            <font class="align-middle">外島常溫宅配</font>
                            <div class="onoffswitch1 float-right">
                                <input type="checkbox" name="onoffswitch1" class="onoffswitch1-checkbox" id="Homoeothermy_Shipment">
                                <label class="onoffswitch1-label" for="Homoeothermy_Shipment">
                                    <span class="onoffswitch1-inner"></span>
                                    <span class="onoffswitch1-switch"></span>
                                </label>
                            </div>
                            <div class="float-right">
                                <font class="align-middle text-right edit-money">$60</font>
                                <i class="icofont icofont-edit align-middle edit-icon"></i>
                            </div>
                        </div>

                        <div class="card-body">
                            <font class="align-middle">本島店到店常溫運送</font>
                            <div class="onoffswitch1 float-right">
                                <input type="checkbox" name="TW_Homoeothermy_711" class="onoffswitch1-checkbox" id="TW_Homoeothermy_711">
                                <label class="onoffswitch1-label" for="TW_Homoeothermy_711">
                                    <span class="onoffswitch1-inner"></span>
                                    <span class="onoffswitch1-switch"></span>
                                </label>
                            </div>
                            <div class="float-right">
                                <font class="align-middle text-right edit-money">$60</font>
                                <i class="icofont icofont-edit align-middle edit-icon"></i>
                            </div>
                        </div>

                        <div class="card-body">
                            <font class="align-middle">本島店到店低溫運送</font>
                            <div class="onoffswitch1 float-right">
                                <input type="checkbox" name="TW_Microtherm_711" class="onoffswitch1-checkbox" id="TW_Microtherm_711">
                                <label class="onoffswitch1-label" for="TW_Microtherm_711">
                                    <span class="onoffswitch1-inner"></span>
                                    <span class="onoffswitch1-switch"></span>
                                </label>
                            </div>
                            <div class="float-right">
                                <font class="align-middle text-right edit-money">$60</font>
                                <i class="icofont icofont-edit align-middle edit-icon run"></i>
                            </div>
                        </div>
                        <div class="card-footer">
                            全館滿額運費設定
                        </div>
                    </div>
                    <div class="form-row text-center mt-4">
                        <div class="col-12">
                            <button type="submit" id="btnEdit" class="btn btn-outline-success ">修改</button>
                            <button type="submit" id="btnSubmit" class="btn btn-outline-success d-none">送出</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Cotent end-->
</div>
@stop 
@section('footer')
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ"
        crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm"
        crossorigin="anonymous"></script>
    <!-- My JS -->
    <script src="js/Live_go.js"></script>
    <!--alertify-->
    <script src="js/Live_go.js"></script>
@stop