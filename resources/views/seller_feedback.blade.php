@extends('layouts.master')

@section('title','意見回饋')
@section('heads')

@stop

@section('wrapper')
    <div class="wrapper">
@stop
@section('navbar')
    <div id="content">
    <!--Nav bar end-->
@stop
@section('content')
   
        <div  class="container-fluid all_content overflow-auto" id="Product_Manage">        
            <div class="row" >
                <div class="col-12">
                    <form id="feedback_form" action="{{ route('sent_feedback_email') }}" method="POST">
                    {{ csrf_field() }}
                        
                            <div class="form-group">
                                <label for="Recipient">賣家姓名：</label>
                                <input type="text" maxlength="255" class="form-control" id="inputRecipient" value="{{ $user_name }}" placeholder="" readonly>
                            </div>
                            <div class="form-group">
                                <label for="inputContactPhone">賣家粉絲專頁：</label>
                                <input type="text" maxlength="200" class="form-control" id="inputContactPhone" value="{{ $page_name }}" placeholder="" readonly>
                            </div>
                            
                    
                        
                            <div class="form-group">
                                <label for="inputMailingAddress">主旨：</label>
                                <input type="text" maxlength="1024" class="form-control" id="inputMailingAddress" name="mail_title" placeholder="請輸入主旨 ..." required>
                            </div>
                            <div class="form-group">
                                <label for="inputRemark">內容:</label>
                                <textarea class="form-control" maxlength="2048" placeholder="請輸入內容 ..." rows="8" name="mail_content" id="inputRemark" required></textarea>
                            </div>
                    
                    
                            <div class="text-center">
                                <button type="submit" id="btnSubmit" class="btn btn-secondary">送出</button>
                            </div>
                        
                    </form>
                </div>
            </div>
        </div>
    
    <!-- Cotent end-->
</div>
@stop
@section('footer')

@stop