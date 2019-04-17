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

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');


Route::post('/logins', [
	'uses'	=> 'UserController@postLogin',
	'as'	=> 'postLogin'
]);

Route::get('/logins', function () {
    return redirect()->route('login');
});

Route::get('/login', [
	'uses'	=> 'UserController@index',
	'as'	=> 'login'
]);


Route::group([
	
	'middleware'	=> 'auth'

	], function(){

        Route::get('/getName', [
            'uses'	=> 'HomeController@getname',
            'as'	=> 'nameUsers'
        ]);

        Route::get('/', [
            'uses'	=> 'HomeController@index',
            'as'	=> 'homeUsers'
        ]);

        Route::get('/logout', [
            'uses'	=> 'UserController@logout',
            'as'	=> 'logout'
        ]);

        Route::get('/datacutis', [
            'uses'	=> 'CutiController@index',
            'as'	=> 'dataCutis'
        ]);

        Route::post('/addCuti', [
            'uses'	=> 'CutiController@addCuti',
            'as'	=> 'addCuti'
        ]);

        Route::get('/data-permintaan-cutis', [
            'uses'	=> 'CutiController@dataPermintaanCuti',
            'as'	=> 'dataPermintaanCuti'
        ]);

        Route::get('/cuti/tolak/{id}', [
            'uses'	=> 'CutiController@tolakPermintaanCuti',
            'as'	=> 'tolakPermintaanCuti'
        ]);

        Route::get('/cuti/terima/{id}', [
            'uses'	=> 'CutiController@terimaPermintaanCuti',
            'as'	=> 'terimaPermintaanCuti'
        ]);

        Route::get('/cutidetail/{id}', 'CutiController@cutidetail');

        Route::get('/cutidetailsaya/{id}', 'CutiController@cutisayadetail');


        //cetak
        Route::get('/cetak/{id}', 'CutiController@cetak');
        Route::get('/cetakadmin/{id}', 'CutiController@cetakAdmin');

        Route::get('/print/{id}', 'CutiController@print');
        Route::get('/print_admin/{id}', 'CutiController@parintAdmin');


});

Route::group([
	
	'middleware'	=> ['role:admin','auth']]

	,function(){

        Route::get('/admin', function(){
            return "test";
        });

});
