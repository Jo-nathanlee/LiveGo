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
use Illuminate\Support\Facades\Gate;
Auth::routes();
Route::get('/', 'HomePageController@HomePageShow');
Route::get('/login/facebook', 'Auth\LoginController@redirectToFacebookProvider');
Route::get('login/facebook/callback', 'Auth\LoginController@handleProviderFacebookCallback');
Route::get('logout', 'Auth\LoginController@logout');



Route::group(['middleware' => [
  'auth','gate_seller'
]], function () {
  // 直播
  Route::get('/streaming_index', 'testController@index_load')->name('streaming_index');
  Route::post('/TopFiveShoper', 'testController@TopFiveShoper')->name('TopFiveShoper');
  Route::post('/update_message', 'testController@StreamingComment')->name('update_message');
  Route::post('/create_product', 'testController@create_product')->name('create_product');
  Route::post('/lucky_draw', 'testController@LuckyDraw')->name('lucky_draw');
  Route::post('/lucky_winner', 'testController@GetWinner')->name('lucky_winner');
  Route::post('/send_comment', 'testController@SendComment')->name('send_comment');
  Route::post('/refresh_drp_product', 'testController@RefreshDrpProduct')->name('refresh_drp_product');
  Route::post('/select_product', 'testController@StoreSelectedProduct')->name('select_product');
  Route::post('/delete_auction', 'testController@DeleteAuctionProduct')->name('delete_auction');
  Route::post('/delete_product', 'ProductController@DeleteProduct')->name('delete_product');
  Route::post('/show_product', 'testController@ShowAuctionProduct')->name('show_product');
  Route::post('/share_product', 'testController@ShareAuctionProduct')->name('share_product');
  Route::post('/update_product', 'testController@UpdateSaleTime')->name('update_product');
  Route::post('/manually_awarded', 'testController@NanuallyAwarded')->name('manually_awarded');
  Route::post('/GetShopThreeDaysCustomer', 'testController@GetShopThreeDaysCustomer')->name('GetShopThreeDaysCustomer');
  Route::post('/TopFiveShoper', 'testController@TopFiveShoper')->name('TopFiveShoper');
  Route::post('/CommoditySalesList', 'testController@CommoditySalesList')->name('CommoditySalesList');

  //商品
  Route::get('/product_show', 'ProductController@ShowPorduct')->name('product_show');
  Route::post('/edit_product', 'ProductController@EditProduct')->name('edit_product');
  Route::post('/product_onoff', 'ProductController@ProductOnOf')->name('product_onoff');
  Route::post('/show_EditProduct', 'ProductController@EditProductShow')->name('show_EditProduct');
  Route::get('/collapseProduct', 'ProductController@collapseProduct')->name('collapseProduct');
  Route::get('/ProductSalesList', 'ProductController@ProductSalesList')->name('ProductSalesList');

  //member
  Route::post('/black', 'MembershipController@BlackMember')->name('black');
  Route::get('/member', 'MembershipController@MemberIndex')->name('member');
  Route::get('/member_detail', 'MembershipController@MemberDetail')->name('member_detail');
  Route::get('/print_member_table', 'MembershipController@PrintMemberTable')->name('print_member_table');


  //excle
  Route::get('/order_excel', 'OrderController@Excel_printer')->name('order_excel');
  Route::get('/streaming_excel', 'testController@streaming_sells_excle')->name('streaming_excel');
  Route::get('/member_excel', 'MembershipController@MemberExcel')->name('member_excel');

  //order
  Route::get('/order', 'OrderController@Order')->name('order');
  Route::post('/order_edit', 'OrderController@Order_edit');
  Route::get('/order_detail', 'OrderController@OrderDetail')->name('order_detail');
  Route::get('/inconfirmed_orders', 'OrderController@InconfirmedOrders')->name('inconfirmed_orders'); 
  Route::post('/submit_EditProduct', 'OrderController@SubmitEditProduct'); 
  Route::post('/submit_AddProduct', 'OrderController@SubmitAddProduct'); 
  Route::get('/show_product', 'OrderController@ShowProduct'); 
  Route::get('/get_ProductNum', 'OrderController@GetProductNum'); 
  Route::post('/delete_order', 'OrderController@DeleteOrder'); 
  Route::post('/refresh_order', 'OrderController@RefreshOrder');   



  
  //setting 
  Route::get('/setting', 'SetpageController@Setting')->name('setting');
  Route::get('/update_manager', 'SetpageController@update_manager')->name('update_manager');
  Route::post('/update_pagedeatil', 'SetpageController@UpdatePagedeatil')->name('update_pagedeatil');
  Route::post('/update_page', 'SetpageController@UpdatePage')->name('update_page');
  Route::post('/update_shipping_fee', 'SetpageController@UpdateShippingFee')->name('update_shipping_fee');
  Route::post('/get_ship_set', 'SetpageController@GetShipSet')->name('get_ship_set');

  Route::post('/excel_upload', 'ProductController@excel_upload')->name('excel_upload');



});

Route::group(['middleware' => [
  'auth'
]], function () {

  //買家購物車
  Route::get('/buyer_cart', 'CheckoutController@cart_show')->name('buyer_cart');
  Route::post('/checkout', 'CheckoutController@Checkout')->name('checkout');
  Route::get('/getMart_area', 'ShopController@getMart_area')->name('getMart_area');
  Route::get('/getMart_address', 'ShopController@getMart_address')->name('getMart_address');
  Route::get('/remittance', 'ShopController@Remittance')->name('remittance');

  //商城
  Route::get('/buyer_shop', 'ShopController@ShowShop')->name('buyer_shop');
  Route::post('/shop_product', 'ShopController@ShopProduct')->name('shop_product');
  Route::post('/shop_add_cart', 'ShopController@AddToCart')->name('shop_add_cart');


});
