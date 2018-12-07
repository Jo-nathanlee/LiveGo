$(document).ready(function () {
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $('#drp_product .dropdown-item').on('click', function(){
        
        $('#goods_name').val($(this).text());
        $.ajax({
            /* the route pointing to the post function */
            url: '/get_streaming_productInfo',
            type: 'POST',
            /* send the csrf-token and the input to the controller */
            data: { goods_name:$(this).text(),_token:csrfToken},
            dataType: 'JSON',
            /* remind that 'data' is the response of the AjaxController */
            success: function (data) {
                console.log(data[0]);
                if(data!="")
                {
                    $('#goods_price').val(data[0].goods_price);
                    $('#note').val(data[0].description);
                }
            },
            error: function(xhr, status, error) {
                // alert(error);
                // alert(XMLHttpRequest.status);
                // alert(XMLHttpRequest.responseText);
            }
        });

        //可以get this id
    });

    //判斷棄標=========================================================================
    $.ajax({
        /* the route pointing to the post function */
        url: '/catch_blacklist',
        type: 'POST',
        /* send the csrf-token and the input to the controller */
        // data: { },
        // dataType: 'JSON',
        /* remind that 'data' is the response of the AjaxController */
        success: function (data) {
            console.log(data[0]);
            if(data!="")
            {
               
            }
        },
        error: function(xhr, status, error) {
            alert(error);
            alert(XMLHttpRequest.status);
            alert(XMLHttpRequest.responseText);
        }
    });




    //=================================================================================



    $('.product_size_info div').on('click', function(){
        $('.product_size_info div').removeClass('product_action');
        $('.product_size_info div').addClass('text-black-50');
        $(this).removeClass('text-black-50');
        $(this).addClass('product_action');
        //可以get this id
    });

    $('#Terms_content').on('click', function(){
        $('#Terms_content').addClass('d-none');
    });
    $('#Privacy').on('click', function(){
        $('#Terms_content').removeClass('d-none');
    });


    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active');
        $('#content').toggleClass('active');
        $('#sidebar_shop').toggleClass('active');
    });

    //collapse 點選其他選單時收起      
    $("#pageSubmenu").on("show.bs.collapse", function () {
        $("#homeSubmenu").collapse('hide');
    });
    $("#homeSubmenu").on("show.bs.collapse", function () {
        $("#pageSubmenu").collapse('hide');
    });

    //關閉視窗
    $(".activity_close").click(function () {
        $("#activity").addClass("d-none");
    });

    $("#btnEdit").click(function () {
        $("#btnSubmit").removeClass("d-none");
        $("#btnEdit").addClass("d-none");
    });

    $("#btnSubmit").click(function () {
        $("#btnEdit").removeClass("d-none");
        $("#btnSubmit").addClass("d-none");
    });

    $("#btnDelete_pic").click(function () {
        $("#Upload_div").addClass("invisible");
        $("#imgInp").val('');
        $("#activity").addClass("d-none");
        $("#blah").removeClass("d-none");
    });


    $('#table_normal').DataTable({
        "columns": [
            { "data": "date" },
            { "data": "income" },
            { "data": "Growth" },
            { "data": "Controler" },
        ],
        language: {
            "sProcessing": "處理中...",
            "sLengthMenu": "_MENU_ 顯示筆數",
            "sZeroRecords": "沒有結果",
            "sInfo": " 顯示第 _START_ 至 _END_ 項結果，共 _TOTAL_ 項",
            "sInfoEmpty": "顯示第 0 至 0 項結果，共 0 項",
            "sInfoFiltered": "(由 _MAX_ 項結果過濾)",
            "sInfoPostFix": "", "sSearch": "<i class='icofont icofont-search'> </i>",
            "sUrl": "", "sEmptyTable": "表單沒有任何資料",
            "sLoadingRecords": "載入中...",
            "sInfoThousands": ",",
            "oPaginate": {
                "sFirst": "首頁",
                "sPrevious": "上頁",
                "sNext": "下頁", "sLast":
                    "末頁"
            },
            "oAria": {
                "sSortAscending": ": 以升序排列此列",
                "sSortDescending": ": 以降序排列此列"
            }
        }
    });

    $('#table_normal tbody').on('click', 'td button', function () {
        var tr = $(this).closest('tr');
        var row = $('#table_normal').DataTable().row(tr);
        format(row.data());
    });
    function format(d) {
        console.log(d.date + d.income + d.Growth); //後端抓取值
    }



    // shopping dt
    $('.tablecart').DataTable({
        "columns": [
            {
                "defaultContent": '',
                "orderable": false,
                "data": "controler",

            },
            {
                "data": "picture",
                "defaultContent": '',
                "orderable": false,
            },
            { "data": "name" },
            { "data": "price" },
            { "data": "amounth" },
            { "data": "total_price" },
            { "data": "bid_time" },
        ],
        language: {
            "sProcessing": "處理中...",
            "sLengthMenu": "_MENU_ 顯示筆數",
            "sZeroRecords": "沒有結果",
            "sInfo": " 顯示第 _START_ 至 _END_ 項結果，共 _TOTAL_ 項",
            "sInfoEmpty": "顯示第 0 至 0 項結果，共 0 項",
            "sInfoFiltered": "(由 _MAX_ 項結果過濾)",
            "sInfoPostFix": "", "sSearch": "<i class='icofont icofont-search'> </i>",
            "sUrl": "", "sEmptyTable": "表單沒有任何資料",
            "sLoadingRecords": "載入中...",
            "sInfoThousands": ",",
            "oPaginate": {
                "sFirst": "首頁",
                "sPrevious": "上頁",
                "sNext": "下頁", "sLast":
                    "末頁"
            },
            "oAria": {
                "sSortAscending": ": 以升序排列此列",
                "sSortDescending": ": 以降序排列此列"
            }
        }, "order": [[2, 'asc']]
    });

    $('#table_normal tbody').on('click', 'td button', function () {
        var tr = $(this).closest('tr');
        var row = $('#table_normal').DataTable().row(tr);
        format(row.data());
    });
    function format(d) {
        console.log(d.date + d.income + d.Growth); //後端抓取值
    }

});



// checkbox 單選
$('#main #Chose_fan div div div input').click(function () {
    if ($(this).prop('checked')) {
        $('#main #Chose_fan div div div input:checkbox').prop('checked', false);
        $(this).prop('checked', true);
    }
});



//alertfy

$(function () {
    $('.run').click(function (event) {
        alertify.confirm('hello', 'want to fk u ', 'yes').show();
    });
});

//edit img 
$('#pictureEdit').mouseenter(function () {
    $('#pictureEdit').addClass('mh-on')
    $('.pictureEdit_item').removeClass('invisible')
    $(".pictureEdit_item").css({ top: $("#pictureEdit").height() / 4, left: $("#pictureEdit").position().left + $("#pictureEdit").width() / 2.15 });
}).mouseleave(function () {
    $('#pictureEdit').removeClass('mh-on')
    $('.pictureEdit_item').addClass('invisible')
})
$(".pictureEdit_item").click(function () {
    $("#activity").removeClass("d-none");


    //////
    var options =
    {
        imageBox: '.imageBox',
        thumbBox: '.thumbBox',
        spinner: '.spinner',
        imgSrc: 'avatar.png'
    }
    var cropper;
    var reader = new FileReader();

    
    options.imgSrc = "img/59891.jpg";
    cropper = new cropbox(options);
    cropper.zoomStart();

    reader.readAsDataURL(options.files[0]);
    options.files = [];
    
});





//up load img
function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#product_upload_img').attr('src', e.target.result);
            $("#blah").addClass("d-none");
            $("#Upload_div").removeClass("invisible");
            $('#Upload_div').attr('style', 'background-color:#f3f3f3');
            $('#Upload_div').addClass('border');
            $('#Upload_div ').mouseenter(function () {
                $('#Upload_div ').addClass('mh-on')
                $('.editicon_pic').removeClass('invisible')
                $(".editicon_pic").css({ top: $("#blah").height() / 4, left: $("#Upload_div").position().left + $("#Upload_div").width() / 2.15 });
            }).mouseleave(function () {
                $('#Upload_div').removeClass('mh-on')
                $('.editicon_pic').addClass('invisible')
            })
            $('.editicon_pic ').mouseenter(function () {
                $('#Upload_div ').addClass('mh-on')
                $('.editicon_pic').removeClass('invisible')
                $(".editicon_pic").css({ top: $("#blah").height() / 4, left: $("#Upload_div").position().left + $("#Upload_div").width() / 2.15 });
            }).mouseleave(function () {
                $('#Upload_div').removeClass('mh-on')
                $('.editicon_pic').addClass('invisible')
            })

            $(".editicon_pic").click(function () {
                $("#activity").removeClass("d-none");
                this.ratio*=0.9;
                setBackground();
            });
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$("#imgInp").change(function () {
    readURL(this);
});

function message_danger() {
    // error_code 接收錯誤代碼 error_msg 接收錯誤提示訊息
    var alert_div = document.createElement("div");
    alert_div.setAttribute('id', 'data_info');
    alert_div.setAttribute("class", "card-body align-middle h5 text-center bg-light");
    alert_div.innerHTML =
        "<strong><i class='icofont icofont-exclamation-circle h1'></i> </strong><div class='mt-4'>直播尚未開起，請先開起直播</div>";
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
