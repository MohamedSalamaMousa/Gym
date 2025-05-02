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
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\CaptainController;
use App\Http\Controllers\Admin\FinancialReportController;
use App\Http\Controllers\Admin\GymSupplyController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\SubscriptionPaymentController;

use App\Models\SubscriptionPayment;

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
        Route::controller(AdminUserController::class)->prefix('/mangers')->group(function () {
            Route::get('/', 'index')->name('admin.manger');
            Route::get('/create', 'create')->name('admin.manger.create');
            Route::post('/store', 'store')->name('admin.manger.store');
            Route::get('/edit/{id}', 'edit')->name('admin.manger.edit');
            Route::post('/update/{id}', 'update')->name('admin.manger.update');
            Route::get('/delete/{id}', 'delete')->name('admin.manger.delete');
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
            Route::post('/create', [ServiceController::class, 'store'])->name('admin.service.store');
            // Route to update the service
            Route::post('/update', [ServiceController::class, 'update'])->name('admin.service.update');

            Route::get('delete/{id}', [ServiceController::class, 'destroy'])->name('admin.service.destroy');
            Route::put('/{id}/status', [ServiceController::class, 'toggleStatus'])->name('admin.service.toggleStatus');
        });
        Route::controller(MemberController::class)->prefix('/members')->group(function () {
            Route::get('/', 'index')->name('admin.member.index');
            Route::post('/create',  'store')->name('admin.member.store');
            // Route to update the service
            Route::get('/edit/{id}', 'edit')->name('admin.member.edit');
            Route::post('/update/{id}',  'update')->name('admin.member.update');
            Route::get('/delete/{id}',  'destroy')->name('admin.member.destroy');
        });
        Route::controller(SubscriptionController::class)->prefix('/subscriptions')->group(function () {
            Route::get('/', 'index')->name('admin.subscription.index');
            Route::post('/create',  'store')->name('admin.subscription.store');
            // Route to update the service
            Route::get('/edit/{id}', 'edit')->name('admin.subscription.edit');
            Route::post('/update/{id}',  'update')->name('admin.subscription.update');
            Route::get('/show/{id}',  'show')->name('admin.subscription.show');
            Route::get('/{id}/invoice',  'invoice')->name('admin.subscription.invoice');
            Route::post('freeze',  'freeze')->name('admin.subscription.freeze');
            Route::get('/delete/{id}',  'destroy')->name('admin.subscription.destroy');
            Route::get('/export', [SubscriptionController::class, 'export'])->name('admin.subscription.export');
            Route::get('/unpaid',  'unpaid')->name('admin.subscription.unpaid');
        });
        //captains
        Route::controller(CaptainController::class)->prefix('/captains')->group(function () {
            Route::get('/', 'index')->name('admin.captain.index');
            Route::post('/create',  'store')->name('admin.captain.store');
            Route::post('/{captain}/adjust-wallet',  'adjustWallet')->name('admin.captain.adjustWallet');

            Route::get('/edit/{id}', 'edit')->name('admin.captain.edit');
            Route::post('/update/{id}',  'update')->name('admin.captain.update');
            Route::get('/show/{id}',  'show')->name('admin.captain.show');
            Route::get('/delete/{id}',  'destroy')->name('admin.captain.destroy');
            Route::delete('/{id}/clear-wallet',  'clearWallet')->name('admin.captain.clearWallet');
        });
        Route::controller(GymSupplyController::class)->prefix('/gym-supplies')->group(function () {
            Route::get('/', 'index')->name('admin.gymSupply.index');
            Route::post('/create',  'store')->name('admin.gymSupply.store');


            Route::get('/edit/{id}', 'edit')->name('admin.gymSupply.edit');
            Route::post('/update/{id}',  'update')->name('admin.gymSupply.update');
            Route::get('/delete/{id}',  'destroy')->name('admin.gymSupply.destroy');
        });
        Route::controller(SubscriptionPaymentController::class)->prefix('/subscription_payment')->group(function () {

            Route::post('/create',  'store')->name('admin.subscription.payment.store');
        });
        Route::controller(FinancialReportController::class)->prefix('/FinancialReport')->group(function () {

            Route::get('/',  'showFinancialReports')->name('admin.reports.financial.index');
            Route::get('/pdf', 'exportFinancialReportPDF')->name('admin.reports.financial.pdf');
        });

        //attendance
        Route::controller(AttendanceController::class)->prefix('/attendance')->group(function () {
            Route::get('/scan', 'index')->name('admin.attendance.scan');
            Route::post('/mark',  'markAttendance')->name('admin.attendance.mark');
            Route::get('/search',  'searchForm')->name('admin.attendance.search.form');
            Route::post('/search',  'search')->name('admin.attendance.search');
            Route::post('/manual',  'manualMarkAttendance')->name('admin.attendance.manualMark');
            Route::get('/manual/show',  'showManualAttendanceForm')->name('admin.attendance.manualView');
        });
    });
});
