$( document ).ready(function() {
    
    //#region call 開場特效 function
    setTimeout ("delete_firstAnimation()", 500);
    setTimeout ("delete_secondAnimation()", 1490);
    setTimeout ("show_logo()", 1500);
    setTimeout ("delete_allAnimation()", 3500);
    setTimeout ("show_curtain()", 3400);
    setTimeout ("delete_curtain()", 3800);
    setTimeout ("html_static()", 3500);
    setTimeout ("strWatchVideo()", 4000);
    
    //#endregion

});
//#region  處理開場特效 function
function delete_firstAnimation()
{
    $("#fisrtAnimation").css({"display": "none"});
}

function delete_secondAnimation()
{
    $("#secondAnimation").css({"display": "none"});
}

function show_logo(){
    $("#thirdAnimation").css({"display": "block"});
    $(".lineAnimation").css({"display": "block"});
}

function delete_allAnimation(){
    $("#LoadingDIv").css({"display": "none"});
    $("#Loading_sm").css({"display": "none"});
    $("#Loading_sm").removeClass("d-sm-block");
    $("#Loading_sm").removeClass("d-block");
    $("#LoadingDIv").removeClass("d-md-block");

}

function show_curtain(){
    $(".curtain-panel").css({"display": "block"});
}

function delete_curtain(){
    $(".curtain-panel").css({"display": "none"});
}

function html_static(){
    $("html").css({"overflow-y": "auto"});
    $("#main").css({"display": "block"});
}

function strWatchVideo(){
    $("#strWatchVideo").css({"display": "block"});
}
//#endregion

//數字特效
$('.count').each(function () {
    $(this).prop('Counter',0).animate({
        Counter: $(this).text()
    }, {
        duration: 5000,
        easing: 'swing',
        step: function (now) {
            $(this).text(Math.ceil(now));
          
        }
    });
});

$(window).scroll(function() {

    var scrollTop = $(this).scrollTop();
    

    var first_row_Top = $(".fisrt_row").position().top;
    var second_row_Top = $(".second_row").position().top;  
    var foot_printbottom= $(window).height() - $(".foot_print").height();

    
 
    if(scrollTop>=foot_printbottom){
        $(".first_foot").addClass("foot_print_1").removeClass("invisible");
        $(".second_foot").addClass("foot_print_2");
        setTimeout (function(){$(".second_foot").removeClass("invisible");}, 1000);
        $(".third_foot").addClass("foot_print_3");
        setTimeout (function(){$(".third_foot").removeClass("invisible");}, 2000);
        $(".fourth_foot").addClass("foot_print_4");
        setTimeout (function(){$(".fourth_foot").removeClass("invisible");}, 3000);
        $(".fifth_foot").addClass("foot_print_5");
        setTimeout (function(){$(".fifth_foot").removeClass("invisible");}, 4000);
        $(".sixth_foot").addClass("foot_print_6");
        setTimeout (function(){$(".sixth_foot").removeClass("invisible");}, 5000);
    }

    if(scrollTop >= first_row_Top){
        $(".fisrt_row").addClass("fadeIn_animation");
    }
    if(scrollTop >= second_row_Top){
        $(".second_row").addClass("fadeIn_animation");
    }
});


 //#region call 開場特效 function
 
var modal = document.getElementById('myModal');

// Get the button that opens the modal
var btn = document.getElementsByClassName("mydiv")[0];
var btn2 = document.getElementsByClassName("xs_watch_video")[0];


// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
    modal.style.display = "block";
}
btn2.onclick = function() {
    modal.style.display = "block";
}
// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
    document.getElementById("LiveGO_Video").pause(); 
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
        document.getElementById("LiveGO_Video").pause(); 
    }
}

 //#endregion

 //Smartsupp Live Chat script

 var _smartsupp = _smartsupp || {};
 _smartsupp.key = '5b35ab9e0c01a24c8282e3269730c72636220aab';
 window.smartsupp||(function(d) {
   var s,c,o=smartsupp=function(){ o._.push(arguments)};o._=[];
   s=d.getElementsByTagName('script')[0];c=d.createElement('script');
   c.type='text/javascript';c.charset='utf-8';c.async=true;
   c.src='https://www.smartsuppchat.com/loader.js?';s.parentNode.insertBefore(c,s);
 })(document);

