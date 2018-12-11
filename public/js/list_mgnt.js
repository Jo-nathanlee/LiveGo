


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
        "sLengthMenu": "<button type='button' id='d_new' class='btn btn-primary'>新增</button>  <button type='button' id='d_edit' class='btn btn-info'>修改</button>  <button type='button' id='d_delete' class='btn btn-danger mr-1'>刪除</button>_MENU_ 顯示筆數",
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
        "sLengthMenu": " <button type='button' id='d_edit' class='btn btn-info mr-1'>更改訂單狀態</button>_MENU_ 顯示筆數 <span id='statue_detail'>556</span>",
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
        $("#d_edit").click(function () {
            alertify.confirm('Confirm Title', '<select class="custom-select" id="select_statue"><option selected>選取更改訂單狀態</option><option value="1">未付款</option><option value="2">等待出貨中</option><option value="3">運送中</option><option value="4">訂單完成</option><option value="5">訂單取消</option></select>', function(){ alertify.success('Ok') }
            , function(){ alertify.error('Cancel')});

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

    $('#table_source_nodata').DataTable({
        "columns": [
            {
                "defaultContent": '',
                "orderable": false,
                "data": "Controler",

            },
            { "data": "Order_name" },
            {
                "defaultContent": '',
                "orderable": false,
                "data": "pic",

            },
            { "data": "Order_goods_name" },
            { "data": "unit_price" },
            { "data": "count" },
            { "data": "total_price" },
            { "data": "content" },
            { "data": "remarks" },
            { "data": "time" },
        ],
        language: default_language
        
    });

    $('#table_source').DataTable({
        "columns": [
            {
                "defaultContent": '',
                "orderable": false,
                "data": "Controler",

            },
            { "data": "Order_name" },
            {
                "defaultContent": '',
                "orderable": false,
                "data": "pic",

            },
            { "data": "Order_goods_name" },
            { "data": "unit_price" },
            { "data": "count" },
            { "data": "total_price" },
            { "data": "content" },
            { "data": "remarks" },
            { "data": "time" },
        ],
        language: default_language
        
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
        language: default_language
    });

    $('#table_buyer_order').DataTable({
        "columns": [
            {
                "defaultContent": '',
                "orderable": false,
                "data": "bid_pic",
            },
            { "data": "goods_name" },
            { "data": "total_price" },
            { "data": "goods_count" },
        ],
        language: default_language
    });

    $('#table_blacklist').DataTable({
        "columns": [
            {
                "defaultContent": '',
                "orderable": false,
                "data": "bid_pic",
            },
            { "data": "black_ID"},
            { "data": "black_name" },
            { "data": "counts" },
            { "data": "status" },
            {
                "defaultContent": '',
                "orderable": false,
                "data": "btn",
            },
        ],
        language: default_language
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
            { "data": "shop_times" },
            { "data": "counts" },
            {"data":"shop_total_price"},
            {"date":"Evaluation"},
            {
                "defaultContent": '',
                "orderable": false,
                "data": "print"
            },
        ], "order": [[1, 'asc']]
    });
});

