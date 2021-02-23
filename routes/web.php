<?php

use Illuminate\Support\Facades\Route;

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
Broadcast::routes();

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/like', 'HomeController@like')->name('like');
Route::post('/dislike', 'HomeController@dislike')->name('dislike');
Route::post('/update', 'SettingController@update')->name('update');

Route::resource('perfil', 'PerfilController', ['except' => ['destroy']]);
Route::post('/perfil/destroy', 'PerfilController@destroy')->name('perfil.destroy');

Route::get('/index', 'PhotoController@index')->name('photo.index');
Route::post('/upload', 'PhotoController@upload')->name('photo.upload');
Route::get('/fetch', 'PhotoController@fetch')->name('photo.fetch');
Route::get('/delete', 'PhotoController@delete')->name('photo.delete');

Route::resource('livechat', 'LivechatController');

Route::get('/leida', function(){
    Auth::user()->unreadNotifications->markAsRead();
});


