
$(document).ready(function () {

    //altertify css setting
    alertify.defaults.transition = "slide";
    alertify.defaults.theme.ok = "btn btn-primary";
    alertify.defaults.theme.cancel = "btn btn-danger";
    alertify.defaults.theme.input = "form-control";

    setInterval(function() {
    var d = new Date();
    var year = d.getFullYear();
    var month = d.getMonth()+1;
    var day = d.getDate();
    var weekday = d.getDay()
    var hours = d.getHours();
    var Minutes = d.getMinutes();
    var seconds = d.getSeconds();
    if (seconds < 10) {seconds = "0"+seconds;}
    var weekend =['一','二','三','四','五','六','日'];

    var currentTimeString ='<h5>'+ year +'</h5><h5>'+month+'/'+day+'</h5>'+'<h5>《'+weekend[weekday]+'》</h5>'+hours+":"+Minutes+":"+seconds;
    
      $('.Timer').html(currentTimeString);
    }, 1000);

    var $chkboxes = $('.key_chkbox');
    var lastChecked = null;

    $chkboxes.click(function(e) {
        if (!lastChecked) {
            lastChecked = this;
            return;
        }

        if (e.shiftKey) {
            var start = $chkboxes.index(this);
            var end = $chkboxes.index(lastChecked);

            $chkboxes.slice(Math.min(start,end), Math.max(start,end)+ 1).prop('checked', lastChecked.checked);
        }

        lastChecked = this;
    });

    $("#Product .dropdown-item").on("click", function () {
        $(this).parent().parent().parent().parent().find("td:nth-child(4)").addClass('text-danger').text($(this).attr('money'));
        $(this).parent().parent().parent().parent().find("td:nth-child(5)").addClass('text-danger').text($(this).attr('can_sell'));
        $(this).parent().parent().parent().parent().find("td:nth-child(6)").addClass('text-danger').text($(this).attr('notsure'));
        $(this).parent().parent().parent().parent().find("td:nth-child(7)").addClass('text-danger').text($(this).attr('num'));
        var category = $(this).text();
        var categorys = "";
        $(this).parent().children('a').each(function () {

            if (category == $(this).html()) {
                categorys = categorys + "<b>(" + $(this).html() + ")</b>&nbsp;&nbsp;";
            } else {
                categorys = categorys + "(" + $(this).html() + ")&nbsp;&nbsp;";
            }

        });
        $(this).parent().parent().find('.product_S').html(categorys);
    });

    $("#Product input[name='ckgoods']").change(function () {
        if (this.checked) {
            $("#showcheck").removeClass().addClass('ml-4 badge badge-danger p-2 pr-4');
            $("#showcheck .fa.fa-close.fa-stack-1x").removeClass().addClass('fa fa-close fa-stack-1x');
        } else {
            $("#showcheck").removeClass().addClass('ml-4 badge badge-secondary p-2 pr-4');
            $("#showcheck .fa.fa-close.fa-stack-1x").removeClass().addClass('fa fa-close fa-stack-1x d-none');
        }
    });

    // 圖片上傳
    $("#Upload_Input").change(function (event) {

        if (this.files && this.files[0]) {

            // 新增商品區塊 display none
            $("#Upload_Img").addClass("d-none");
            // 新增img src
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah').css("background-image", "url(" + e.target.result + ")");
                $('#blah').addClass("New_Img");
            }
            reader.readAsDataURL(this.files[0]);
        } else {
            $("#Upload_Img").removeClass("d-none");
        }


        readURL(this);
    });

    function readURL(input) {

        if (input.files && input.files[0]) {

            // 新增商品區塊 display none
            $("#Upload_Img").addClass("d-none");
            // 新增img src
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah').css("background-image", "url(" + e.target.result + ")");
                $('#blah').addClass("New_Img");
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            $("#Upload_Img").removeClass("d-none");
        }
    }

    // 圖片上傳
    $("#prize_image").change(function (event) {


        if (this.files && this.files[0]) {

            // 新增商品區塊 display none
            $("#prize_Input").addClass("d-none");
            // 新增img src
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah_prize').css("background-image", "url(" + e.target.result + ")");
                $('#blah_prize').addClass("New_Img w-25");
            }
            reader.readAsDataURL(this.files[0]);
        } else {
            $("#prize_Input").removeClass("d-none");
        }

    });

    $("#Edit_Input").change(function (event) {

        if (this.files && this.files[0]) {

            // 新增商品區塊 display none
            $("#Edit_Img").addClass("d-none");
            // 新增img src
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah_edit').css("background-image", "url(" + e.target.result + ")");
                $('#blah_edit').addClass("New_Img");
            }
            reader.readAsDataURL(this.files[0]);
        } else {
            $("#Edit_Img").removeClass("d-none");
        }
    });


    $("#sidebar").mCustomScrollbar({
        theme: "minimal"
    });

    $('#sidebarCollapse').on('click', function () {
        $('#sidebar, #content').toggleClass('active');
        $('.collapse.in').toggleClass('in');
        $('a[aria-expanded=true]').attr('aria-expanded', 'false');
        $("#sidebarcontent ul.show").removeClass('show');
    });
    $('#sidebaricon>li').on('click', function () {
        var siderclass = $('#sidebar').attr('class');
        if( siderclass.includes('active')){
            $('#sidebar, #content').toggleClass('active');
        }
        
    });
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();

    });

    $("#facebook_comment a").hover(
        function () {
            $(this).find("button").last().removeClass("invisible");
        }, function () {
            $(this).find("button").last().addClass("invisible");
        }
    );
    $('#addEvent').on('click', function () {
        var children_node = $("#addCategory div").length;
        if (children_node < 8) {
            $("#error_text").removeClass().addClass('text-danger d-none');

            $("#addCategory>div:nth-child(1)").attr("required", true);
            $("#addCategory>div:nth-child(1)").after('<div class="mb-2">\
            <input type="text" name="product_category[]" class="form-control mr-4 w-25 d-inline-block category"\
                placeholder="請輸入商品規格 ..." required>\
            <input type="number" name="product_price[]" class="form-control mr-4 w-25 d-inline-block price"\
            min="0" value="0" required>\
            <input type="number" name="product_num[]" class="form-control mr-4 w-25 d-inline-block stock"\
            min="0" value="0" required>\
            <i class="fas fa-times-circle text-danger cancel_add_goods"  onclick="cancelProduct(this)"></i>\
            </div>' );
        } else {
            $("#error_text").removeClass().addClass('text-danger');
        }
    });
    $('#editEvent').on('click', function () {
        var children_node = $("#editCategory div").length;
        if (children_node < 8) {
            $("#error_text_edit").removeClass().addClass('text-danger d-none');
            $("#addCategory>div:nth-child(1)").attr("required", true);
            $("#editCategory>div:nth-child(1)").after('<div class="mb-2">\
            <input type="text" name="product_category[]" class="form-control mr-4 w-25 d-inline-block category br-10 row_inp_style"\
                placeholder="請輸入商品規格 ..." required>\
            <input type="number" name="product_price[]" class="form-control mr-4 w-25 d-inline-block price br-10 row_inp_style"\
            min="0" value="0" required>\
            <input type="number" name="product_num[]" class="form-control mr-4 w-25 d-inline-block stock br-10 row_inp_style"\
            min="0" value="0" required>\
            <i class="fas fa-times-circle text-danger cancel_add_goods"  onclick="cancelProduct(this)"></i>\
            </div>' );
        } else {
            $("#error_text_edit").removeClass().addClass('text-danger');
        }
    });

    $('#SearchProudct').on('input', function (e) {
        var input = $(this).val();


        $('#PickGoods li').each(function () {
            var li = $(this);
            var anchor = li.children('span').html();
            if (anchor.includes(input)) {
                li.addClass('d-flex');
                li.removeClass('d-none');
            } else {
                li.removeClass('d-flex');
                li.addClass('d-none');
            }
        });
    });

    $('#SearchCompliance').on('input', function (e) {
        var input = $(this).val();


        $('#Compliance li').each(function () {
            var li = $(this);
            var anchor = li.children('span').children('span:first-child').html();
            if (anchor.includes(input)) {
                li.addClass('d-flex');
                li.removeClass('d-none');
            } else {
                li.removeClass('d-flex');
                li.addClass('d-none');
            }
        });
    });

    $('.currencyField').formatCurrency();


    var $chkboxes = $('.chkbox');
    var lastChecked = null;

    /* Use Shift select multiple checkboxes */
    $chkboxes.click(function (e) {
        $chkboxes = $('.chkbox');
        if (!lastChecked) {
            lastChecked = this;
            return;
        }

        if (e.shiftKey) {
            console.log(this);
            var start = $chkboxes.index(this);
            var end = $chkboxes.index(lastChecked);
            $chkboxes.slice(Math.min(start, end), Math.max(start, end) + 1).prop('checked', lastChecked.checked);
        }

        lastChecked = this;
    });

});


function cancelProduct(element) {
    $(element).parent().remove();
}

function addCheck(element) {
    $("#CheckedGoods").append('<li class="list-group-item d-flex justify-content-between align-items-center" onclick="deleteCheck(this);">' +
        element.innerHTML
        + '</li>');
    element.remove();
    var count = $("#CheckedGoodsCount").html();
    count = parseInt(count);
    $("#CheckedGoodsCount").html(count + 1);
}

function deleteCheck(element) {

    $("#PickGoods").append('<li class="list-group-item d-flex justify-content-between align-items-center" onclick="addCheck(this);">' +
        element.innerHTML
        + '</li>');
    element.remove();
    var count = $("#CheckedGoodsCount").html();
    count = parseInt(count);
    $("#CheckedGoodsCount").html(count - 1);
}

