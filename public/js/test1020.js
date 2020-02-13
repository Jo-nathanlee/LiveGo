$(document).ready(function () {  //把原在上方的側邊攔按鈕移至側邊攔底

    $('#sidebarCollapse_2').on('click', function () {
        $('#sidebar').toggleClass('active');
    });

});  

$("#order_wrapper .row:nth-child(3) .col-md-7").addClass("col-md-12");
$("#order_wrapper .row:nth-child(1) .col-md-6").addClass("col-md-3");

function al_sel_max(){
	$('.col-md-6_R').css({'flex':'0 0 100%'}); 
	$('.col-md-6_R').css({'max-width':'100%'}); 
	$('.col-md-6_L').css({'display':'none'}); 
	$('.al_sel_min').css({'display':' inline-block'}); 
	$('.al_sel_max').css({'display':' none'});
}
function al_sel_min(){
	$('.col-md-6_R').css({'flex':'0 0 50%'}); 
	$('.col-md-6_R').css({'max-width':'50%'}); 
	$('.col-md-6_L').css({'display':'block'}); 
	$('.al_sel_min').css({'display':' none'}); 
	$('.al_sel_max').css({'display':' inline-block'});
}


function show_W(){	 
		$('input[type=radio][name=sel]').change(function() {
        if (this.value == 'all') {
             	$('.V_general').css({'display':'block'});
			 	$('.V_Advanced').css({'display':'block'});
			 	$('.V_VIP').css({'display':'block'});
			 	$('.V_VVIP').css({'display':'block'});
			 	$('.V_lock').css({'display':'block'});
			 	$('.sel_ck_box_all').css({'display':'inline-block'});
			 	$('.sel_ck_box_bk').css({'display':'none'});
			 	$('.sel_ck_box_mb').css({'display':'none'});
        }
        else if (this.value == 'bk') {
            $('.V_lock').css({'display':'none'});
            $('.sel_ck_box_all').css({'display':'none'});
            $('.sel_ck_box_bk').css({'display':'inline-block'});
            $('.sel_ck_box_mb').css({'display':'none'});
        }
        else if (this.value == 'mb') {
            $('.sel_ck_box_all').css({'display':'none'});
            $('.sel_ck_box_bk').css({'display':'none'});
            $('.sel_ck_box_mb').css({'display':'inline-block'});
        }
    });
}	


function ck_goods(checkbox,x){
	if(checkbox.checked == true){
	 
	$('.ck_box'+x).css({'display':'block'}); 
	}
	else{
	 $('.ck_box'+x).css({'display':'none'}); 
	}
}

$( "#other" ).click(function() {
	$( "#target" ).click();
  });

function order_ck(checkbox,x){ //勾選訂單
	

	if(checkbox.checked == true){
		$('table.dataTable tbody>tr[number='+x+']').css({'background-color':'#fafafa'}); 
		$('table.dataTable tbody>tr[number='+x+']>th').css({'z-index':'1501','background-color':'#fafafa','position':'relative'}); 
		$('table.dataTable tbody>tr[number='+x+']>td').css({'z-index':'1501','background-color':'#fafafa','position':'relative'}); 		
	}
	else{
		$('table.dataTable tbody>tr[number='+x+']').css({'background-color':'#FFFFFF'}); 
		$('table.dataTable tbody>tr[number='+x+']>th').css({'z-index':'1','background-color':'#FFFFFF'}); 
		$('table.dataTable tbody>tr[number='+x+']>td').css({'z-index':'1','background-color':'#FFFFFF'}); 
		
	}
	var check=$("input[name='sel_or']:checked").length;
	if(check==0){
		$(".order_top_cg").attr("disabled",true);
		$('.order_top_re').css({'background-color':'#eeeeee','color':'#464646','cursor':'auto'}); 
		$('.order_top_cg').css({'background-color':'#eeeeee','color':'#464646','cursor':'auto'}); 
		$('.mask').css({'display':'none'}); 
		$('.order_L_box').css({'z-index':'1'}); 
		order_cg_cg1();
	}
	else{
		$(".order_top_cg").attr("disabled",false);
		$('.order_top_re').css({'background-color':'#ff4747','color':'#FFFFFF','cursor':'pointer'}); 
		$('.order_top_cg').css({'background-color':'#4bb77d','color':'#FFFFFF','cursor':'pointer'}); 
	}
}

function cg_order_status(){ //訂單更改狀況

	$('.mask').css({'display':'block'}); 
	$('.order_L_box').css({'z-index':'1501'}); 
	$('.order_L_box ul>li:nth-child(9)').css({'display':'block'}); 
	$('.order_L_box ul>li:nth-child(1)').css({'display':'none'}); 
}
function order_cg_no(){ //取消訂單更改
	order_cg_cg1();
}






function cart_ck(checkbox,x){ //勾選商品
	if(checkbox.checked == true){
		$('.cart_ck_box'+x+' img').css({'display':'block'}); 	
	}
	else{
		$('.cart_ck_box'+x+' img').css({'display':'none'}); 
		
	}
	if(x==0){
		if($("#cart_ck0").prop("checked")){//如果全選按鈕有被選擇的話（被選擇是true）
			$('.cart_S1_top_ck_all').css({'color':'#726e6f'}); 
	    	$("input[name='sel_cart']").prop("checked",true);//把所有的核取方框的property都變成勾選
	    	var check=$("input[name='sel_cart']:checked").length;
	    	for(i=0;i<=check;i++){
	    		$('.cart_ck_box'+i+' img').css({'display':'block'}); 	
	    	}
	   	}
	   	else{
	   		$('.cart_S1_top_ck_all').css({'color':'#cacaca'}); 
	    	$("input[name='sel_cart']").prop("checked",false);//把所有的核取方框的property都取消勾選
	    	var check=$("input[name='sel_cart']").length;
	    	for(i=0;i<=check;i++){
	    		$('.cart_ck_box'+i+' img').css({'display':'none'}); 	
	    	}
	   	}
	}
}
function cart_how_ck(radio,x){ //勾選宅配方式
	if(radio.checked == true){
		if(x==1){
			$('.cart_how_ck_box1').addClass('cart_how_ck_box_K');
			$('.cart_how_ck_box2').removeClass('cart_how_ck_box_K');
			$('.cart_S2_wh_box').css({'display':'none'});
			$('.cart_S2_data_box u').css({'display':'none'});
		}
		else if(x==2){
			$('.cart_how_ck_box2').addClass('cart_how_ck_box_K');
			$('.cart_how_ck_box1').removeClass('cart_how_ck_box_K');
			$('.cart_S2_wh_box').css({'display':'inline-block'});
			$('.cart_S2_data_box u').css({'display':'inline-block'});
		}
	}
}

function cart_pay_ck(radio,x){ //勾選宅配方式
	if(radio.checked == true){
		if(x==1){
			$('.cart_pay_ck_box1').addClass('cart_pay_ck_box_K');
			$('.cart_pay_ck_box2').removeClass('cart_pay_ck_box_K');
		}
		else if(x==2){
			$('.cart_pay_ck_box2').addClass('cart_pay_ck_box_K');
			$('.cart_pay_ck_box1').removeClass('cart_pay_ck_box_K');
		}
	}
}