<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ChartController;



//admin dashboard link
Route::prefix('dashboard')->group(function () {
    Route::get('admin',[AdminController::class,'index'])->name('admin');
});

Route::middleware(['auth'])->group(function () {
  //admin profile
Route::get('admin/profile',[AdminController::class,'adminProfile'])->name('admin.profile');

//user info
Route::get('user/info',[AdminController::class,'userInfo'])->name('user.info');

//user actions
Route::post('create/user',[AdminController::class,'createUser'])->name('create.user');
Route::post('user/update/{id}',[AdminController::class,'userUpdate'])->name('update.user');
Route::post('admin/update/user/password/{id}',[AdminController::class,'updatePassword'])->name('admin.update.user.password');
Route::get('users/{id}',[AdminController::class,'destroy'])->name('destroy.user');
Route::post('admin/delete/categories',[AdminController::class,'deleteSelectedCategories'])->name('admin.delete.selected.categories');
Route::post('admin/delete/users',[AdminController::class,'deleteSelected'])->name('admin.deleted.selected');
Route::get('user/profile/{id}',[AdminController::class,'userProfile'])->name('user.profile');

//guest request
Route::get('ajax-chart-data-user', [AdminController::class,'getDataUser'])->name('getDataUser');
Route::get('get-web-requests', [AdminController::class,'webRequests'])->name('get-web-requests');
Route::get('get-niche-requests', [AdminController::class,'nicheRequests'])->name('get-niche-requests');

//user request datd
Route::get('get-user-requests', [AdminController::class,'userRequestsData'])->name('get-user-requests');

Route::post('user/new/price/{id}',[AdminController::class,'newPrice'])->name('user.new.price');
Route::post('user/niche/new/price/{id}',[AdminController::class,'nicheNewPrice'])->name('user.niche.new.price');

Route::get('admin/show/user/request/search',[AdminController::class,'showSearch'])->name('showSearch');
Route::get('admin/show/user/request/{id}',[AdminController::class,'showSingleRequest'])->name('admin.show.single.request');
Route::get('admin/show/guest/requests',[AdminController::class,'showGuestRequests'])->name('admin.show.guest.request');
Route::get('admin/show/all/guest/requests',[AdminController::class,'allGuestRequests'])->name('admin.allGuestRequests');
Route::get('admin/ad/guest/request',[AdminController::class,'addGuestRequestForm'])->name('admin.add.guest.request');
Route::post('admin/store/guest/request',[AdminController::class,'storeGuestRequest'])->name('admin.store.guest.request');
Route::post('admin/delete/users/requests',[AdminController::class,'deleteSelectedREquest'])->name('admin.delete.selected.request');
Route::get('admin/guest/approved/{id}',[AdminController::class,'guestRequestApprove'])->name('admin.guest.request.approved');
Route::get('admin/guest/rejected/{id}',[AdminController::class,'nicheRejected'])->name('admin.guest.request.rejected');
Route::get('admin/guest/deleted/{id}',[AdminController::class,'guestRequestDelete'])->name('admin.guest.delete.request');
Route::get('admin/show/guest/deleted/requests',[AdminController::class,'showGuestDeleted'])->name('admin.guest.deleted.requests');
Route::get('admin/restored/requests/{id}',[AdminController::class,'restoreRequest'])->name('admin.restore.requests');
Route::get('admin/clear/trash/{id}',[AdminController::class,'forceDelete'])->name('admin.delete.permanently.requests');
Route::get('admin/make/admin/{id}',[AdminController::class,'makeAdmin'])->name('make.admin');
Route::get('admin/edit/request/{id}',[AdminController::class,'editRequest'])->name('admin.edit.request');
Route::post('admin/change/request/{id}',[AdminController::class,'updateRequest'])->name('admin.update.request');


//searchbar
Route::get('admin/search/users',[AdminController::class,'search'])->name('admin.serach.user');
//advance filter
Route::post('filter/advance',[AdminController::class,'filter'])->name('filter.route');
//add category via admin panel
Route::post('add/category',[AdminController::class,'addCategory'])->name('add.category');
Route::get('show/categories',[AdminController::class,'showCategories'])->name('admin.show.categories');
Route::post('edit/category/{id}',[AdminController::class,'editCategory'])->name('admin.edit.category');
Route::get('delete/category/{id}',[AdminController::class,'deleteCategory'])->name('admin.delete.category');

// charts route
Route::get('request/chart/{requestName}',[AdminController::class,'requestChart'])->name('request.data');
Route::get('request/today/{status}',[AdminController::class,'today'])->name('today');
Route::get('request/yesterday/{status}',[AdminController::class,'yesterdayStats'])->name('yesterday');
Route::get('request/sevenDays/{status}',[AdminController::class,'sevenDays'])->name('seven.days');
Route::get('request/thirty/days/{status}',[AdminController::class,'lastThirtyDays'])->name('thirty.days');
Route::get('request/this/month/{status}',[AdminController::class,'thisMonth'])->name('this.month');
Route::get('request/last/month/{status}',[AdminController::class,'lastMonth'])->name('last.month');
Route::get('request/custom/range/{status}',[AdminController::class,'customRange'])->name('custom.range');
Route::get('specific/chart/view',[AdminController::class,'xyz'])->name('specific');
Route::get('specific/chart',[AdminController::class,'specific_chart'])->name('specific.chart');

//user/permission
Route::post('admin/allow/user/{id}',[AdminController::class,'permissions'])->name('admin.user.permissions');
Route::get('get/details/{id}',[AdminController::class,'getDetails'])->name('getDetails');
Route::get('get/niche/details/{id}',[AdminController::class,'getNicheDetails'])->name('getNicheDetails');
//ajex route
Route::get('get/url',[AdminController::class,'getUrl'])->name('getUrl');
Route::get('get/webname',[AdminController::class,'getName'])->name('getName');
//niche
Route::get('admin/add/niche',[AdminController::class,'addNicheForm'])->name('admin.add.niche');
Route::post('admin/store/niche',[AdminController::class,'addStoreNiche'])->name('admin.store.niche');
Route::get('admin/show/niches',[AdminController::class,'addShowNiches'])->name('admin.show.niches');
Route::get('admin/show/niche/{id}',[AdminController::class,'showSingleNiche'])->name('admin.show.single.niche');
Route::get('admin/edit/niche/{id}',[AdminController::class,'editNicheRequest'])->name('admin.edit.niche.request');
Route::post('admin/change/niche/{id}',[AdminController::class,'updateNicheRequest'])->name('admin.chnage.niche');
Route::get('admin/approve/niche/{id}',[AdminController::class,'nicheApprove'])->name('admin.niche.approved');
Route::get('admin/pending/niche/{id}',[AdminController::class,'nichePending'])->name('admin.niche.pending');
Route::get('admin/rejected/niche/{id}',[AdminController::class,'nicheReject'])->name('admin.niche.rejected');
Route::get('admin/niche/remove/{id}',[AdminController::class,'nicheDelete'])->name('admin.niche.deleted');
Route::get('admin/show/deleted/niches',[AdminController::class,'showDeleteNiches'])->name('admin.show.deleted.niche');
Route::get('admin/changing/niche/{id}',[AdminController::class,'restoreNiche'])->name('admin.restore.niche');
Route::get('admin/clear/niche/{id}',[AdminController::class,'clearNiche'])->name('admin.delete.permanently.niche');
Route::post('admin/delete/niches',[AdminController::class,'deleteSelectedNiches'])->name('admin.delete.selected.niches');


});
Route::get('/export', [App\Http\Controllers\CsvExportController::class,'exportExcel'])->name('export.xl');
