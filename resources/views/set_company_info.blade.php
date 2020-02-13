@extends('layouts.master')

@section('title','設定公司資訊')



@section('wrapper')
<div class="wrapper">
@stop
@section('navbar')
    <div id="content">
        @stop
        @section('content')
        {{-- @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif --}}
        <div class="container-fluid all_content overflow-auto" id="List_Manage_Detail">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('set_company_info') }}" enctype="multipart/form-data" method="POST">
                            {{ csrf_field() }}
                                <div id="company_info">                 
                                    <div class="input-group mb-4">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-secondary" type="button">商家負責人姓名設定</button>
                                        </div>
                                        <input type="text" name="sender_name" maxlength="255" value="{{ $company_info->sender_name }}" class="form-control" placeholder="請輸入退貨時簽收人姓名 ...">
                                    </div> 
                                    <div class="input-group mb-4">
                                            <div class="input-group-prepend">
                                                <button class="btn btn-secondary" type="button">商家負責人電話設定</button>
                                            </div>
                                            <input type="text" name="sender_cell"  pattern='\d{4}\d{6}' maxlength="10" value="{{ $company_info->sender_cell }}" class="form-control" placeholder="請輸入退貨時簽收人電話 ...">
                                        </div>            
                                    <div class="input-group mb-4">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-secondary"  type="button">商家地址設定</button>
                                        </div>
                                        <input type="text" name="address" maxlength="255" value="{{ $company_info->company_address }}" class="form-control" placeholder="請輸入地址 ...">
                                    </div>
                                </div>
                                <!-- <hr> -->
                                <div class="input-group mb-4 d-none">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-secondary" type="button">銀行代碼</button>
                                    </div>
                                    <input type="text" name="bankcode" maxlength="10" value="{{ $company_info->bank_code }}" class="form-control" placeholder="請輸入銀行代碼 ...">
                                </div>
                                <div class="input-group mb-4 d-none">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-secondary" type="button">銀行名稱</button>
                                    </div>
                                    <input type="text" name="bankname" maxlength="50" value="{{ $company_info->bank_name }}" class="form-control" placeholder="請輸入銀行名稱 ...">
                                </div>
                                <div class="input-group mb-4 d-none">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-secondary" type="button">帳戶名稱</button>
                                    </div>
                                    <input type="text" name="bankaccount" maxlength="100"  value="{{ $company_info->bank_account }}" class="form-control" placeholder="請輸入帳戶名稱 ...">
                                </div>
                                <hr>
                                <div id="black_time">
                                    <div class="input-group mb-4">
                                        <div class="input-group-prepend">
                                            <span class="btn btn-secondary">棄標時間設定 <sub>(小時)</sub></span>
                                        </div>
                                        <input type="number" name="deadlinetime"  min="0" value="{{ $company_info->deadline_time }}" class="form-control" placeholder="請設定棄標時間 ...">
                                    </div>
                                </div>
                                <hr>
                                    <div class="input-group mb-4">
                                        <div class="input-group-prepend">
                                            <span class="btn btn-secondary">免運費價錢設定</span>
                                        </div>
                                        <input type="number" name="free_shipping"  min="0" value="{{ $company_info->free_shipping }}" class="form-control" placeholder="請設定免運費價錢 ...">
                                    </div>
                                <hr>
                                    <div class="input-group">
                                        <div class="input-group-prepend pr-3">
                                            <span class="btn btn-secondary">開啟綠界</span>
                                        </div>
                                        @if($company_info->ecpay == 'true')
                                            <div class="custom-control custom-radio  mr-3 pt-2">
                                                <input type="radio" id="customRadio1"  name="ecpay" value="是" class="custom-control-input" checked>
                                                <label class="custom-control-label" for="customRadio1">開啟綠界服務</label>
                                            </div>
                                            <div class="custom-control custom-radio pt-2">
                                                <input type="radio" id="customRadio2"   name="ecpay" value="否" class="custom-control-input ">
                                                <label class="custom-control-label" for="customRadio2">關閉綠界服務</label>
                                            </div>
                                        @else
                                            <div class="custom-control custom-radio  mr-3 pt-2">
                                                <input type="radio" id="customRadio1"  name="ecpay" value="是" class="custom-control-input">
                                                <label class="custom-control-label" for="customRadio1">開啟綠界服務</label>
                                            </div>
                                            <div class="custom-control custom-radio pt-2">
                                                <input type="radio" id="customRadio2"   name="ecpay" value="否" class="custom-control-input" checked    >
                                                <label class="custom-control-label" for="customRadio2">關閉綠界服務</label>
                                            </div>
                                        @endif
                                    </div>
                            
                                <hr>
                                @if($company_info->ecpay != 'true')
                                <div id="ecpay_info"  class="d-none">
                                @else
                                <div id="ecpay_info"  class="">
                                @endif
                                    <div class="input-group mb-4">
                                        <div class="input-group-prepend">
                                            <span class="btn btn-secondary">商家代號</span>
                                        </div>
                                        <input type="password" name="merchant_code" maxlength="50"  value="{{ $company_info->merchant_code }}" class="form-control" placeholder="請輸入商家代號 ...">
                                    </div>
                                    <div class="input-group mb-4">
                                        <div class="input-group-prepend">
                                            <span class="btn btn-secondary">綠界 - 介接Hashkey</span>
                                        </div>
                                        <input type="password" name="Hashkey" maxlength="255"  value="{{ $company_info->hashkey }}" placeholder="請輸入介接Hashkey ..."  class="form-control">
                                    </div>
                                    <div class="input-group mb-4">
                                        <div class="input-group-prepend">
                                            <span class="btn btn-secondary">綠界 - 介接HashIV</span>
                                        </div>
                                        <input type="password" name="HashIV" maxlength="255"  value="{{ $company_info->hashiv }}" placeholder="請輸入介接HashIV ..." class="form-control">
                                    </div>
                                </div>
                                <div class="form-row text-center">
                                    <div class="col-12">
                                        <input type="submit" id="btnSubmit" class="btn btn-secondary" value="確定">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cotent end-->
</div>
<script>
    $( document ).ready(function() {
        $("input[type=radio][name=ecpay]").change(function(){
            console.log($("input[type=radio][name='ecpay']:checked").val());
            if($("input[type=radio][name='ecpay']:checked").val()=="否"){
                $("#ecpay_info").removeClass().addClass('d-none');
                
            }else{
                $("#ecpay_info").removeClass();
            }
        });

        const driver = new Driver();

        driver.defineSteps([
                {
                    element: '#company_info',
                    popover: {
                        title: '輸入商家地址與電話',
                        description: '資訊會在來福逛逛中顯示！',
                        position: 'bottom'
                    }
                },
                {
                    element: '#black_time',
                    popover: {
                        title: '輸入棄標時間',
                        description: '買家得標時如果沒有在設定時間付款，則會直接變成棄標',
                        position: 'bottom'
                    }
                },
                {
                    element: '#List_Manage_Detail > div > div > div > div > form > div:nth-child(11)',
                    popover: {
                        title: '選擇是否要開啟綠界服務',
                        description: '開啟綠界付款時的付費選項',
                        position: 'bottom'
                    }
                },
                {
                    element: '#ecpay_info',
                    popover: {
                        title: '輸入第三方支付平台 - 綠界資訊',
                        description: '如果尚未申請請先於綠界申請帳號',
                        position: 'bottom'
                    }
                },
                {
                    element: '#btnSubmit',
                    popover: {
                        title: '點選確定',
                        description: '儲存商家基本設定資訊',
                        position: 'top'
                    }
                },
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