<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\admin\AdminAuthController;
use App\Http\Controllers\admin\UserManagementController;
use App\Http\Controllers\admin\ClientController;
use App\Http\Controllers\admin\ReportController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\PaymentController;
use App\Http\Controllers\admin\TimeSlotController;
use App\Http\Controllers\admin\AvailabilityController;
use App\Http\Controllers\admin\SettingController;
use App\Http\Controllers\admin\PatientController;

Route::get('login', [AdminAuthController::class, 'login'])->name('login');
Route::get('back-to-admin', [AdminAuthController::class, 'backToAdmin']);
Route::post('admin-login-action', [AdminAuthController::class, 'adminLoginAction']);
Route::get('forgot-password', [AdminAuthController::class, 'forgotPassword']);
Route::post('admin-forgot-action', [AdminAuthController::class, 'adminForgotAction']);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['App\Http\Middleware\AdminAuth']], function () {
    Route::get('dashboard', [AdminAuthController::class, 'dashboard']);
    Route::get('profile', [AdminAuthController::class, 'profile']);
    Route::put('/admin/profile/update', [AdminAuthController::class, 'updateProfile'])->name('profile.update');
    Route::put('/admin/password/update', [AdminAuthController::class, 'updatePassword'])->name('password.update');
    Route::get('logout', [AdminAuthController::class, 'logout']);


    Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
        Route::get('/', [UserManagementController::class, 'userList']);

        Route::get('add', [UserManagementController::class, 'userAdd']);
        Route::get('edit/{id}', [UserManagementController::class, 'edit'])->name('admin.user.edit');
        Route::post('save_user/{id?}', [UserManagementController::class, 'save_user'])->name('admin.user.save');
        Route::get('delete/{id}', [UserManagementController::class, 'destroyUser']);

        Route::post('statusChange', [UserManagementController::class, 'statusChange']);
        Route::get('approved_user/{id}', [UserManagementController::class, 'approved_user']);

        Route::get('approved_user_edit/{id}', [UserManagementController::class, 'approved_user_edit']);
        Route::post('approved_user_update', [UserManagementController::class, 'approved_user_update']);

    });


    Route::group(['prefix' => 'category', 'as' => 'category.'], function () {
        Route::get('/', [CategoryController::class, 'category_list']);
    });

    Route::group(['prefix' => 'patient', 'as' => 'patient.'], function () {
        Route::get('/', [PatientController::class, 'patient_list']);
    });

    Route::get('booking_history', [PatientController::class, 'booking_history']);
    Route::get('history_of_customer', [PatientController::class, 'history_of_customer']);
    Route::get('booking-history/view/{id}', [PatientController::class, 'view_booking_history']);
    Route::get('booking_details/{id}', [PatientController::class, 'booking_details']);
    Route::get('patient-history/view/{id}', [PatientController::class, 'view_patient_history']);
    Route::get('patient-history/status-change/{id}', [PatientController::class, 'statusChangePage'])->name('patient.status.change');
    Route::post('patient-history/update-status/{id}', [PatientController::class, 'updateStatus']);
    Route::get('patient_history/delete/{id}', [PatientController::class, 'delete'])->name('patient_history.delete');


    Route::group(['prefix' => 'time_slot', 'as' => 'time_slot.'], function () {
        Route::get('/', [TimeSlotController::class, 'time_slot_list']);
        Route::get('time_slot_add', [TimeSlotController::class, 'time_slot_add']);
        Route::post('time_slot_submit/{id?}', [TimeSlotController::class, 'time_slot_submit']);
        Route::get('/edit/{id}', [TimeSlotController::class, 'edit_time_slot']);
        Route::get('delete/{id}', [TimeSlotController::class, 'delete_time_slot'])->name('time_slot.delete');


    });

    Route::group(['prefix' => 'availability', 'as' => 'availability.'], function () {
        Route::get('/', [AvailabilityController::class, 'availability_list']);
        Route::get('availability_calander_list', [AvailabilityController::class, 'availability_calander_list']);
        Route::post('/availability_submit/{id?}', [AvailabilityController::class, 'store'])->name('availability.store'); // Insert/Update
        Route::get('/edit/{id}', [AvailabilityController::class, 'edit'])->name('admin.availability.edit');
        Route::get('/delete/{id}', [AvailabilityController::class, 'destroy'])->name('admin.availability.delete');
        Route::get('get_unavailable_dates', [AvailabilityController::class, 'getUnavailableDates']);
        Route::get('get_big_calander_unavailable_dates', [AvailabilityController::class, 'get_big_calander_unavailable_dates']);
        Route::get('get_time_slots', [AvailabilityController::class, 'get_time_slots']);
        Route::post('mark_unavailable', [AvailabilityController::class, 'markUnavailable']);
    });
    

    Route::group(['prefix' => 'setting', 'as' => 'setting.'], function () {
        Route::get('/', [SettingController::class, 'setting_list']);
        Route::post('/setting_submit/{id?}', [SettingController::class, 'store'])->name('setting.store'); // Insert/Update
        Route::get('/edit/{id}', [SettingController::class, 'edit'])->name('admin.setting.edit');
        Route::get('/delete/{id}', [SettingController::class, 'destroy'])->name('admin.setting.delete');
        Route::post('update-payment-permission', [SettingController::class, 'updatePaymentPermission']);
    });



    Route::group(['prefix' => 'payments', 'as' => 'payments.'], function () {
        Route::get('/', [PaymentController::class, 'payments_list']);
        Route::get('add', [PaymentController::class, 'payments_add']);
    });

    Route::group(['prefix' => 'report', 'as' => 'report.'], function () {
        Route::get('attendance_master_report', [ReportController::class, 'attendance_master_report']);
        Route::get('user', [ReportController::class, 'user_report']);
        Route::get('payment', [ReportController::class, 'payment_report']);
    });

});
