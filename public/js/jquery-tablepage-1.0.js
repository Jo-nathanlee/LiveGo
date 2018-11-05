/*
作者：hsu po-wei
E-Mail：hpw925@hotmail.com
授權：GPL 3
*/

(function ($) {

	$.fn.tablepage = function (oObj, dCountOfPage) {

		var dPageIndex = 1;
		var dNowIndex = 1;
		var sPageStr = "";
		var dCount = 0;
		var oSource = $(this);
		var sNoSelColor = "#CCCCCC";
		var sSelColor = "black";
		var sFontColor = "white";

		change_page_content();

		function change_page_content() {
			//取得資料筆數
			dCount = oSource.children().children().length - 1;


			if (dCount > dCountOfPage) {
				//顯示頁碼
				sPageStr = "";
				dPageIndex = 1;
				if (dNowIndex != 1) {
					sPageStr += "<a class='btn mr-1'><i class='icofont icofont-caret-left'></i><font style='display:none'>" + (dNowIndex - 1) + "</font></a>";
				}else{
					sPageStr+= "<a class='btn mr-1'></a>";
				}
				for (var i = 1; i <= dCount; i += dCountOfPage) {

					sPageStr += "<a><font class='btn btn-outline-dark mr-1'>" + (dPageIndex++) + "</font></a>";
				}
				if (dNowIndex < dCount/dCountOfPage) {
					var currenypage = parseInt(dNowIndex);
					sPageStr += "<a class='btn mr-3'><i class='icofont icofont-caret-right'></i><font style='display:none'>" + (currenypage + 1) + "</font></a>";
				}else{
					sPageStr+= "<a class='btn mr-1'></a>";
				}
				sPageStr += "";
			}


			oObj.html(sPageStr);

			dPageIndex = 1;

			//過濾表格內容
			oSource.children().children("tr").each(function () {

				if (dPageIndex <= (((dNowIndex - 1) * dCountOfPage) + 1) || dPageIndex > ((dNowIndex * dCountOfPage) + 1)) {
					$(this).hide();
				}
				else {
					$(this).show();
				}

				dPageIndex++;
			});

			oSource.children().children("tr").first().show(); //head一定要顯示

			//加入換頁事件
			oObj.children().each(function () {

				$(this).click(function () {

					dNowIndex = $(this).find("font").text();

					if (dNowIndex > 0) {
						change_page_content();
					}
				});
			});
		}
	};
})(jQuery);


