$(document).ready(function () {
    $('#sidebarCollapse').on('click', function () {
    $('#sidebar').toggleClass('active');
    });

    //collapse 點選其他選單時收起      
    $("#pageSubmenu").on("show.bs.collapse", function(){
    $("#homeSubmenu").collapse('hide');
    });
    $("#homeSubmenu").on("show.bs.collapse", function(){
    $("#pageSubmenu").collapse('hide');
    });  
    
    //關閉視窗
    $(".activity_close").click(function(){
        $("#activity").removeClass("visible").addClass("invisible");
    });

    $("#btn_activity").click(function(){
        $("#activity").removeClass("invisible").addClass("visible");
    });
});

// checkbox 單選
$('#main #Chose_fan div div div input').click(function(){
    if($(this).prop('checked')){
    $('#main #Chose_fan div div div input:checkbox').prop('checked',false);
    $(this).prop('checked',true);
    }
}); 

//alertfy

$(function(){
    $('.run').click(function(event){
        alertify.confirm('hello','want to fk u ','yes').show();
    });
});
