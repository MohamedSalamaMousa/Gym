<?php



use App\Models\Admin;


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;


use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\Admin\ProfileController;

use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\AdminPanelController;
use App\Http\Controllers\Admin\ServiceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/




Route::get('SwitchLang/{lang}', function ($lang) {
    session()->put('Lang', $lang);
    app()->setLocale($lang);
    if (auth()->check()) {
        $admin = Admin::find(auth()->user()->id)->update(['language' => $lang]);
    }
    return Redirect::back();
});


Route::prefix('/AdminPanel')->group(function () {
    Route::controller(AdminLoginController::class)->group(function () {
        Route::get('/login', 'login')->name('AdminLogin');
    });
    Route::middleware('auth')->group(function () {
        Route::get('/', [AdminPanelController::class, 'index'])->name('AdminPanel');
        Route::get('/read-all-notifications', [AdminPanelController::class, 'readAllNotifications'])->name('admin.notifications.readAll');
        Route::get('/notification/{id}/details', [AdminPanelController::class, 'notificationDetails'])->name('admin.notification.details');
        Route::get('/logout', [LoginController::class, 'logout'])->name('AdminLogout');
        Route::controller(AdminUserController::class)->prefix('/member')->group(function () {
            Route::get('/', 'index')->name('admin.member');
            Route::get('/create', 'create')->name('admin.member.create');
            Route::post('/store', 'store')->name('admin.member.store');
            Route::get('/edit/{id}', 'edit')->name('admin.member.edit');
            Route::post('/update/{id}', 'update')->name('admin.member.update');
            Route::get('/delete/{id}', 'delete')->name('admin.member.delete');
            //users

        });

        Route::controller(RoleController::class)->prefix('/role')->group(function () {
            Route::get('/', 'index')->name('admin.role');
            Route::post('/store', 'store')->name('admin.role.store');
            Route::post('/update/{id}', 'update')->name('admin.role.update');
            Route::get('/delete/{id}', 'delete')->name('admin.role.delete');
        });
        Route::controller(ProfileController::class)->prefix('/profile')->group(function () {
            Route::get('/', 'index')->name('admin.profile');
            Route::post('/update/{id}', 'update')->name('admin.profile.update');
        });

        Route::controller(ServiceController::class)->prefix('/services')->group(function () {
            Route::get('/', 'index')->name('admin.service');
            Route::post('/services', [ServiceController::class, 'store'])->name('admin.service.store');
            // Route to update the service
            Route::post('admin/services/update', [ServiceController::class, 'update'])->name('admin.service.update');

            Route::delete('/services/delete/{id}', [ServiceController::class, 'destroy'])->name('admin.service.destroy');
        });
    });
});