


// Datatable  
$(document).ready(function () {

    var default_language =  {
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
    };


    var language = {
        "sProcessing": "處理中...",
        "sLengthMenu": "<button type='button' id='d_new'  class='btn btn-primary'>新增</button>  <button type='button' id='d_edit' class='btn btn-info'>修改</button>  <button type='button' id='d_delete' class='btn btn-danger mr-1'>刪除</button>_MENU_ 顯示筆數",
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
    };


    var language_list_edit = {
        "sProcessing": "處理中...",
        "sLengthMenu": " <button type='button' id='d_edit' class='btn btn-info mr-1'>更改訂單狀態</button>_MENU_ 顯示筆數",
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
    };


    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $("#d_edit").click(function () {
        
            alertify.confirm('更改訂單狀態', '<select  class="custom-select" id="select_status"><option selected value="unpaid">未付款</option><option value="undelivered">等待出貨中</option><option value="delivered">運送中</option><option value="finished">訂單完成</option><option value="canceled">訂單取消</option></select>', 
            function(){
                var status=$('#select_status option:selected').val();
                var order_id=$("#order_id").html();
                $.ajax({
                        /* the route pointing to the post function */
                        url: '/OrderStatusChange',
                        type: 'POST',
                        /* send the csrf-token and the input to the controller */
                        data: { order_id:order_id,status:status},
                        dataType: 'JSON',
                        /* remind that 'data' is the response of the AjaxController */
                        success: function (data) {
                            console.log(JSON.stringify(data));
                            $("#order_status").html(JSON.stringify(data));
                            alertify.success('更改成功！');
                        },
                        error: function(xhr, status, error) {
                            // console.log(error);
                            // console.log(XMLHttpRequest.status);
                            // console.log(XMLHttpRequest.responseText);
                            alertify.error("連線錯誤！請稍後再試！");
                        }
                }); 
            }, 
            function(){ alertify.error('更改失敗！')});

        });

    });


    
    $('#table_member_bid_list_detail').DataTable({

        language: default_language
    });

    $('#table_bid_list_detail').DataTable({
        "columns": [
            {
                "defaultContent": '',
                "orderable": false,
            },
            {
                "defaultContent": '',
                "orderable": false,
            },
            { "data": "goods_name" },
            { "data": "unit_price" },
            { "data": "count" },
            { "data": "total_price" },

        ],
        language: language_list_edit
    });



    $('#table_source').DataTable({
        "columns": [
            {
                "defaultContent": '',
                "orderable": false,
                "data": "Controler",

            },
            {
                "defaultContent": '',
                "orderable": false,
                "data": "pic",

            },
            { "data": "Order_number" },
            { "data": "bidder" },
            { "data": "product" },
            { "data": "content" },
            { "data": "price" },
            { "data": "remarks" },
            { "data": "time" },
        ],
        language: language
        , "order": [[2, 'asc']]
    });

    $('#table_nocontroler').DataTable({
        "columns": [
            {
                "defaultContent": '',
                "orderable": false,
                "data": "bid_pic",
            },
            { "data": "bid_name" },
            { "data": "Order_number" },
            { "data": "total_price" },
            { "data": "status" },
            {
                "defaultContent": '',
                "orderable": false,
                "data": "btn",
            },
        ],
        language: language
    });





    $('#table_list_detail').DataTable({
        "columns": [
            {
                "defaultContent": '',
                "orderable": false,
                "data": "controler",
            },
            { "data": "Order_number" },
            { "data": "time" },
            { "data": "Logistics" },
            { "data": "price" },
            { "data": "status" },
            {
                "defaultContent": '',
                "orderable": false,
                "data": "btn",
            },
        ],
        language: language
    });


    $('#dtProduct').DataTable({
        language: language,
        "columns": [
            {
                "defaultContent": '',
                "orderable": false,
                "data": "controler",
            },
            { "data": "pic" },
            { "data": "name" },
            { "data": "num" },
            { "data": "sellnum" },
            {
                "defaultContent": '',
                "orderable": false,
                "data": "print"
            },
        ], "order": [[1, 'asc']]
    });
    $('#dtAccount').DataTable({

        language: default_language,
        "columns": [
            {
                "defaultContent": '',
                "orderable": false,
                "data": "pic",

            },
            { "data": "name" },
            { "data": "evaluation" },
            { "data": "Shopping_amount" },
            {
                "defaultContent": '',
                "orderable": false,
                "data": "print"
            },
        ], "order": [[1, 'asc']]
    });
});

