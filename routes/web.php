<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\User\FrontendController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\CsvExportController;
use Illuminate\Support\Facades\Auth;

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

@include_once('admin_web.php');
Route::view('demo','demo');
Route::get('/', function () {
    return view('authentication.login');
})->name('index');
Route::get('ajax-chart-data', [AdminController::class,'getData'])->name('ajaxChart');


Route::get('linechart', 'LinechartController@linechart');
//user routes
Route::get('user/dashboard',[FrontendController::class,'index'])->name('dashboard')->middleware('auth');
Route::view('user/profile', 'user/profile/profile')->name('profile');
Route::post('user/change/profile',[FrontendController::class,'userUpdateProfile'])->name('user.update.profile');
Route::get('user/show/profile/{id}',[FrontendController::class,'userShowProfile'])->name('user.show.profile');
Route::get('show/niche/form',[FrontendController::class,'showNicheForm'])->name('show.niche.form');
Route::post('add/niche',[FrontendController::class,'addWebsite'])->name('user.store.website');
Route::get('user/requests',[FrontendController::class,'user_request'])->name('user.requests');
Route::get('user/edit/requests/{id}',[FrontendController::class,'userEditRequest'])->name('user.edit.request');
Route::post('user/change/requests/{id}',[FrontendController::class,'userUpdateRequest'])->name('user.edit.request.post');

Route::get('logout',[LoginController::class,'logout'])->name('logout');
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('export', [AdminController::class,'export'])->name('export.excel');
Route::post('import/store',[AdminController::class,'importstore'])->name('import.excel');
Route::get('/add/web', function () {
    return view('pages.user.user-add');
})->name('addWeb');
