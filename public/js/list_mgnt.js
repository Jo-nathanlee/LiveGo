
// tablepage
// $(document).ready(function () {
//     $("#table_source").tablepage($("#list_table_page"), 5);
// });

// $(document).ready(function () {
//     $('#datetimepicker_form').datetimepicker({
//         locale: 'zh-tw'
//     });
//     $('#datetimepicker_to').datetimepicker({
//         locale: 'zh-tw'
//     });
// });


// Datatable  
$(document).ready(function () {
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
        language: {
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
        }, "order": [[2, 'asc']]
    });

    $('#table_nocontroler').DataTable({
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
            { "data": "status" }
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
        }, "order": [[1, 'asc']]
    });
    $('#dtProduct').DataTable({
        language: {
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
        },
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
                "sNext": "下頁",
                "sLast": "末頁"
            },
            "oAria": {
                "sSortAscending": ": 以升序排列此列",
                "sSortDescending": ": 以降序排列此列"
            }
        },
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

