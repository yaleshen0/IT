<?php

use Overtrue\Wechat\Server;
use Overtrue\Wechat\Message;
use Overtrue\Wechat\User;
use Overtrue\Wechat\Auth;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::any('/', 'WechatController@index');
Route::get('/history', 'LoginController@historyCheck');
Route::get('/{id}/historyDetails', 'LoginController@historyDetails');
Route::get('/history{FromUserName}', 'LoginController@historyCheck');
//Route::any('/', 'IndexController@wechat');
//输入用户名密码后登陆 进入首页同时也是ticket页面
Route::get('/index', 'LoginController@index');
Route::get('/register', 'LoginController@register');
Route::post('/landing', 'LoginController@landing');
//tickets index & closed
Route::post('/tickets/index', 'TicketController@index');
Route::get('/tickets/index', 'TicketController@getIndex');
// Route::post('/tickets/index', 'TicketController@update');
Route::get('/tickets/closed', 'TicketController@closed');
Route::post('/tickets/updateOpen{id}By{employee}{time}', 'TicketController@updateOpen');
Route::post('/tickets/updateHold{id}', 'TicketController@updateHold');
Route::post('/tickets/updateUnhold{id}By{employee}', 'TicketController@updateUnhold');
Route::post('/tickets/updateClose{id}By{employee}', 'TicketController@updateClose');
Route::post('/tickets/referTo{option}By{employee}/{id}', 'TicketController@updateRefer');
Route::get('/tickets/{id}/details', 'TicketController@details');
Route::post('/tickets/changeCategoryTo{option}By{employee}/{id}', 'TicketController@changeCategory');
// tickets search category & search view
Route::get('/tickets/c{cate}Search', 'TicketController@searchCateg');
Route::get('/tickets/cArraySearch/{array}', 'TicketController@searchMultiCateg');
//tickets search priority
Route::get('/tickets/p{prior}Search', 'TicketController@searchPrior');
//Statistic basic/category/user
// Route::get('/statistic/basic', 'StatisticController@basic');
// Route::get('/statistic/category', 'StatisticController@category');
Route::get('/statistic/employee', 'StatisticController@employee');
Route::get('/statistic/index', 'StatisticController@index');
//for forum
Route::get('/forum/index', 'ForumController@index');
Route::get('/forum/create', 'ForumController@create');
Route::post('/forum/save', 'ForumController@save');
Route::post('/forum/uploadImage', 'ForumController@uploadImage');
Route::get('/forum/article/{id}/show', 'ForumController@show');
Route::get('/forum/article/{id}/edit', 'ForumController@edit');
Route::post('/forum/article/{id}/editsave', 'ForumController@editsave');
Route::get('/forum/article/{id}/delete', 'ForumController@delete');
//chat comment post
Route::post('/tickets/{id}/{comment}', 'TicketController@comment');
Route::post('/tickets/{id}+{notice}', 'TicketController@notice');
Route::post('/commentToIt/{id}/{operator}/{comment}', 'TicketController@commentToIt');

