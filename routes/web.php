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


//---ajax----

	Route::get('/ajax',function() {
   return view('messagePage');
});
Route::post('/getmsg','AjaxController@index');



////------Gallery---------
	Route::get('/gallery', 'gallery@index')->name('gallery');
	Route::get('/gallery/search', 'gallery@search');
	Route::get('/gallery/searchByTag', 'gallery@searchByTag')->name('gallery.searchByTag');
	Route::get('/gallery/sort', 'gallery@sort')->name('gallery.sort');

////------Singleview---------
	Route::get('/singleview', 'singleview@index')->name('singleview');
	Route::post('/singleview/postCart', 'singleview@postCart')->name('singleview.postCart');
	Route::get('/singleview/getCart', 'singleview@getCart')->name('singleview.getCart');
	Route::get('/singleview/clearCart', 'singleview@clearCart')->name('singleview.clearCart');

Route::get('/create', 'create@index')->name('create');
Route::get('/cart', 'cart@index')->name('cart');

///-------Share---------------------
Route::get('/share', 'shareController@index')->name('share');
Route::post('/create/share', 'shareController@addToShared')->name('shareController.addToShared');
Route::post('/create/submitShare', 'shareController@commentToShare')->name('shareController.commentToShare');
Route::get('/share/comment', 'shareController@shareComment')->name('shareComment');
Route::post('/share/productForShare', 'shareController@productForShare')->name('productForShare');


/////---------Create----------------
	Route::post('/create/Mcart', 'create@addToCart')->name('create.addToCart');
	Route::post('/create/Scart', 'create@addToSell')->name('create.addToSell');
    Route::post('/create/Sell', 'create@productForSell')->name('create.productForSell');

/////---------Registration------------
	Route::get('/registration', 'registration@index')->name('registration');
	Route::post('/registration', 'registration@register')->name('registration.register');

////------login---------------------
	Route::get('/login', 'login@index')->name('login');
	Route::post('/login', 'login@verify')->name('login.verify');
	Route::get('/logout', 'logout@sessionRemove')->name('logout');




Route::get('/', 'gallery@index');



//////----------Route-------group---------------------------

Route::group(['middleware' => ['loginCheck']], function(){

////------home--------
	Route::get('/home', 'home@index')->name('home');
	Route::post('/home/addProduct', 'home@addProduct')->name('home.addProduct');
	Route::get('/home/edit', 'home@editProduct')->name('home.editProduct');
	Route::post('/home/updateProduct', 'home@updateProduct')->name('home.updateProduct');
	Route::get('/home/deleteProduct', 'home@deleteProduct')->name('home.deleteProduct');
	Route::get('/home/orderStatus', 'home@orderStatus')->name('home.orderStatus');
	Route::get('/home/orderDelete', 'home@orderDelete')->name('home.orderDelete');
	Route::post('/home/updateUserAddress', 'home@updateUserAddress')->name('home.updateUserAddress');
	Route::post('/home/updateUserInfo', 'home@updateUserInfo')->name('home.updateUserInfo');
	Route::get('/home/deleteUser', 'home@deleteUser')->name('home.deleteUser');
	Route::get('/ordersPrint','home@ordersPrint')->name('print.orders');
	Route::get('/productsPrint','home@productsPrint')->name('print.products');
	Route::get('/usersPrint','home@usersPrint')->name('print.users');
	Route::get('/profitPrint','home@profitPrint')->name('print.profit');

	Route::get('/invoicePrint','cart@invoicePrint')->name('print.invoice');

	Route::get('/gallery/searchEmail','gallery@searchEmail');

////---------Message--------
	Route::post('/messageSend','home@send')->name('message.send');
	

////-------Cart----------
	Route::post('/cart/placeOrder', 'cart@placeOrder')->name('cart.placeOrder');
});


