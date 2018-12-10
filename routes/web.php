<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */
use Illuminate\Support\Facades\Auth;

Route::get('/', 'HomePageController@HomePageShow');
//Route::post('/checkout_return', 'ECPayController@CheckoutReturn')->name('checkout_return');

Route::post('/ecpayCheckout', 'ECPayController@checkout');
Route::get('/ecpayCheckout', 'ECPayController@checkout');

Route::post('/OrderResult', 'ECPayController@payReturn');
Route::get('/OrderResult', 'ECPayController@payReturn');









Auth::routes();

Route::get('/login/facebook', 'Auth\LoginController@redirectToFacebookProvider');
Route::get('login/facebook/callback', 'Auth\LoginController@handleProviderFacebookCallback');
Route::get('logout', 'Auth\LoginController@logout');
// Route::get('/webhook', 'MessengerWebhook@index')->name('webhook');
 //chatbot
//  Route::get('/messengerbot', 'MessengerWebhook@index');
//  Route::post('/messengerbot', 'MessengerWebhook@index');

Route::group(['middleware' => [
    'auth',
]], function () {
    //賣家首頁
    Route::get('/seller_index', 'SellerIndexController@show')->name('seller_index');
    //設定粉絲團
    Route::get('/set_page', 'SetpageController@show')->name('set_page');
    Route::post('/save_page', 'SetpageController@CreateOrUpdatePage')->name('save_page');
    //laravel首頁
    Route::get('/home', 'HomeController@index')->name('home');
    //直播頁面
    Route::get('/index_load', 'StreamingIndexController@index_load')->name('index_load');
    Route::get('/index_show', 'StreamingIndexController@index_show');
    //ajax
    Route::get('/update_message', 'StreamingIndexController@update_message');
    Route::post('/update_message', 'StreamingIndexController@update_message');

    Route::get('/reply', 'StreamingIndexController@private_reply');
    Route::post('/reply', 'StreamingIndexController@private_reply');

    Route::get('/start_record', 'StreamingIndexController@start_record');
    Route::post('/start_record', 'StreamingIndexController@start_record');

    Route::get('/end_record', 'StreamingIndexController@end_record');
    Route::post('/end_record', 'StreamingIndexController@end_record');

    Route::get('/end_record_top_price', 'StreamingIndexController@end_record_top_price');
    Route::post('/end_record_top_price', 'StreamingIndexController@end_record_top_price');

    Route::get('/store_streaming_order', 'StreamingIndexController@store_streaming_order');
    Route::post('/store_streaming_order', 'StreamingIndexController@store_streaming_order');

    Route::get('/add_comment', 'StreamingIndexController@add_comment');
    Route::post('/add_comment', 'StreamingIndexController@add_comment');

    Route::get('/get_streaming_productInfo', 'StreamingIndexController@get_streaming_productInfo');
    Route::post('/get_streaming_productInfo', 'StreamingIndexController@get_streaming_productInfo');

    
    //買家購物車
    Route::get('/buyer_index', 'BuyerIndexController@show')->name('buyer_index');
    //得標者頁面
    Route::get('/bid_winner', 'BidWinnerController@show')->name('bid_winner');
    //買家結帳
    Route::post('/checkout', 'CheckoutController@CheckOut')->name('checkout');
    Route::post('/checkout_form', 'CheckoutController@CheckoutForm')->name('checkout_form');


    //商城商品新增修改顯示
    Route::get('/AddProduct_show', 'MallProductController@AddProduct_show')->name('AddProduct_show');
    Route::get('/EditProduct_show', 'MallProductController@EditProduct_show')->name('EditProduct_show');
    Route::get('/product_overview', 'MallProductController@ProductOverview')->name('product_overview');
    Route::get('/shopping_mall', 'MallProductController@ShowMall')->name('shopping_mall');
    Route::post('/add_product', 'MallProductController@AddNewProduct')->name('add_product');
    Route::post('/edit_product', 'MallProductController@EditProduct')->name('edit_product');
    Route::post('/delete_product', 'MallProductController@DeleteProduct')->name('delete_product');

    
    //賣家訂單查看
    Route::get('/seller_order', 'SellerOrderController@SellerOrderAll')->name('seller_order');
    Route::get('/seller_order_detail', 'SellerOrderController@SellerOrderDetail')->name('seller_order_detail');
    Route::get('/seller_order_unpaid', 'SellerOrderController@SellerOrderUnpaid')->name('seller_order_unpaid');
    Route::get('/seller_order_undelivered', 'SellerOrderController@SellerOrderUndelivered')->name('seller_order_undelivered');
    Route::get('/seller_order_delivered', 'SellerOrderController@SellerOrderDelivered')->name('seller_order_delivered');
    Route::get('/seller_order_finished', 'SellerOrderController@SellerOrderFinished')->name('seller_order_finished');
    Route::get('/seller_order_canceled', 'SellerOrderController@SellerOrderCanceled')->name('seller_order_canceled');

    //更改訂單狀態
    Route::post('/OrderStatusChange','SellerOrderController@StatusChange')->name('OrderStatusChange');
    Route::get('/OrderStatusChange','SellerOrderController@StatusChange')->name('OrderStatusChange');
    

    //訂單PDF
    Route::get('/downloadPDF','SellerOrderController@downloadPDF')->name('download');
    Route::get('/download_pdf','SellerOrderController@download_pdf')->name('download_pdf');
    Route::post('/download_pdf','SellerOrderController@download_pdf')->name('download_pdf');

    //買家訂單查看
    Route::get('/buyer_order', 'BuyerOrderController@BuyerOrderAll')->name('buyer_order');
    Route::get('/buyer_order_unpaid', 'BuyerOrderController@BuyerOrderUnpaid')->name('buyer_order_unpaid');
    Route::get('/buyer_order_undelivered', 'BuyerOrderController@BuyerOrderUndelivered')->name('buyer_order_undelivered');
    Route::get('/buyer_order_delivered', 'BuyerOrderController@BuyerOrderDelivered')->name('buyer_order_delivered');
    Route::get('/buyer_order_finished', 'BuyerOrderController@BuyerOrderFinished')->name('buyer_order_finished');
    Route::get('/buyer_order_canceled', 'BuyerOrderController@BuyerOrderCanceled')->name('buyer_order_canceled');

    //棄標黑名單
    Route::get('/bid_blacklist', 'BidWinnerController@Blacklist')->name('bid_blacklist');
    Route::get('/catch_blacklist', 'BidWinnerController@Blacklist_check')->name('catch_blacklist');
    Route::get('/blacklist_time', 'BidWinnerController@Blacklist_time')->name('blacklist_time');
    Route::post('/set_blacklist_time', 'BidWinnerController@Set_BlacklistTime')->name('set_blacklist_time');

    //設定公司info
    Route::get('/company_info', 'SetpageController@CompanyInfoSetting')->name('company_info');
    Route::post('/set_company_info', 'SetpageController@Set_CompanyInfo')->name('set_company_info');
    Route::get('/delivery', 'SetpageController@DeliverySetting')->name('delivery');
    
    
   
    //設定直播拍賣商品
    Route::get('/SetProduct_show', 'StreamingProductController@SetStreamingProduct_show')->name('SetProduct_show');
    Route::post('/set_product', 'StreamingProductController@SetStreamingProduct')->name('set_product');
    Route::get('/EditStreamingProduct_show', 'StreamingProductController@EditStreamingProduct_show')->name('EditStreamingProduct_show');
    Route::post('/edit_streaming_product', 'StreamingProductController@EditProduct')->name('edit_streaming_product');
    Route::get('/StreamingProductOverview', 'StreamingProductController@ProductOverview')->name('StreamingProductOverview');
    Route::post('/delete_streaming_product', 'StreamingProductController@DeleteProduct')->name('delete_streaming_product');

    //營收
    Route::get('/daily_revenue', 'RevenueController@DailyRevenue')->name('daily_revenue');
    Route::get('/monthly_revenue', 'RevenueController@MonthlyRevenue')->name('monthly_revenue');

    //會員
    Route::get('/membership', 'MembershipController@index')->name('membership');
    Route::get('/member_detail', 'MembershipController@detail')->name('member_detail');

    //網紅
    Route::get('/InternetCelebrityMatch', 'MallProductController@InternetCelebrityMatch')->name('InternetCelebrityMatch');
    
    
    
});





