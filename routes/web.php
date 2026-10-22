<?php

use App\Http\Controllers\web\WebViewController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminAuthController;
use App\Http\Controllers\admin\PaymentController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Doctor\DoctorDashboardController;
use App\Http\Controllers\Doctor\DoctorSettingsController;
use App\Http\Controllers\Doctor\DoctorPageController;
use App\Http\Controllers\Doctor\DoctorServiceController;
use App\Http\Controllers\Doctor\DoctorSubscriptionController;
use App\Http\Controllers\Admin\SaaSAdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Patient Booking & Clinic Pages (Tenant-aware via TenantMiddleware)
Route::get('/', [WebViewController::class, 'appoinment'])->name('home');
Route::get('contact', [WebViewController::class, 'contact']);
Route::get('about', [WebViewController::class, 'about']);
Route::get('facilities', [WebViewController::class, 'facilities']);
Route::get('testimonials', [WebViewController::class, 'testimonials']);
Route::get('gallery', [WebViewController::class, 'gallery']);
Route::get('faq', [WebViewController::class, 'faq']);
Route::get('career', [WebViewController::class, 'career']);
Route::get('paralysis_stroke', [WebViewController::class, 'paralysis_stroke']);
Route::get('migraine', [WebViewController::class, 'migraine']);
Route::get('fits_treatment', [WebViewController::class, 'fits_treatment']);
Route::get('parkinson-disease', [WebViewController::class, 'parkinson_disease']);
Route::get('neck_back_pain', [WebViewController::class, 'neck_back_pain']);
Route::get('brain_fever', [WebViewController::class, 'brain_fever']);
Route::get('dizziness_vertigo', [WebViewController::class, 'dizziness_vertigo']);
Route::get('muscle-disorders', [WebViewController::class, 'muscle_disorders']);
Route::get('memory', [WebViewController::class, 'memory']);
Route::get('pediatric', [WebViewController::class, 'pediatric']);
Route::get('appoinment', [WebViewController::class, 'appoinment']);
Route::get('get-timeslots', [WebViewController::class, 'getTimeSlots']);
Route::post('/check_availability', [WebViewController::class, 'checkAvailability']);

Route::any('/book_appointment', [WebViewController::class, 'book_appointment']);
Route::get('/lookup-patient', [WebViewController::class, 'lookupPatient'])->name('lookup_patient');
Route::post('/generate-order', [WebViewController::class, 'generateOrder']);
Route::post('/payment-success', [WebViewController::class, 'paymentSuccess']);
Route::post('/payment-failed', [WebViewController::class, 'paymentFailed']);
Route::get('/booking-success/{order_id}', [WebViewController::class, 'bookingSuccess']);
Route::get('/booking-failed/{order_id}', [WebViewController::class, 'bookingFailed']);
Route::get('/invoice/{id}', [WebViewController::class, 'show'])->name('invoice.show');

// Public Notice API endpoint aliases
Route::get('/notice-api', [\App\Http\Controllers\api\NoticeController::class, 'getNotice']);
Route::get('/get-notice', [\App\Http\Controllers\api\NoticeController::class, 'getNotice']);

// Dynamic Custom Pages & Clinic-Scoped URLs
Route::get('/page/{slug}', [WebViewController::class, 'viewCustomPage'])->name('clinic.page');

// Clinic-Scoped Routes (Every clinic has its own unique URL namespace: /c/{clinic_slug})
Route::group(['prefix' => 'c/{clinic_slug}'], function () {
    Route::get('/', [WebViewController::class, 'appoinment'])->name('clinic.home');
    Route::get('/appoinment', [WebViewController::class, 'appoinment'])->name('clinic.appoinment');
    Route::any('/book_appointment', [WebViewController::class, 'book_appointment'])->name('clinic.book_appointment');
    Route::get('/lookup-patient', [WebViewController::class, 'lookupPatient'])->name('clinic.lookup_patient');
    Route::post('/generate-order', [WebViewController::class, 'generateOrder'])->name('clinic.generate_order');
    Route::post('/payment-success', [WebViewController::class, 'paymentSuccess'])->name('clinic.payment_success');
    Route::post('/payment-failed', [WebViewController::class, 'paymentFailed'])->name('clinic.payment_failed');
    Route::get('/booking-success/{order_id}', [WebViewController::class, 'bookingSuccess'])->name('clinic.booking.success');
    Route::get('/booking-failed/{order_id}', [WebViewController::class, 'bookingFailed'])->name('clinic.booking.failed');
    Route::get('/invoice/{id}', [WebViewController::class, 'show'])->name('clinic.invoice.show');
    Route::get('/page/{slug}', [WebViewController::class, 'viewCustomPage'])->name('clinic.page.slug');
    Route::get('/get-timeslots', [WebViewController::class, 'getTimeSlots']);
    Route::post('/check_availability', [WebViewController::class, 'checkAvailability']);
});


// ==========================================
// Google OAuth & Doctor Onboarding Flow
// ==========================================
Route::get('/auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

Route::middleware(['auth'])->group(function () {
    Route::get('/clinic/onboarding', [GoogleAuthController::class, 'showOnboarding'])->name('clinic.onboarding');
    Route::post('/clinic/onboarding', [GoogleAuthController::class, 'completeOnboarding'])->name('clinic.onboarding.submit');
    Route::get('/doctor/onboarding', fn() => redirect()->route('clinic.onboarding'))->name('doctor.onboarding');
    Route::post('/doctor/onboarding', [GoogleAuthController::class, 'completeOnboarding'])->name('doctor.onboarding.submit');
});

// ==========================================
// Clinic Portal Routes (All prefix 'clinic', as 'clinic.')
// ==========================================
Route::group(['prefix' => 'clinic', 'as' => 'clinic.', 'middleware' => ['auth']], function () {
    Route::get('/dashboard', [DoctorDashboardController::class, 'index'])->name('dashboard');

    // Clinic Settings & Razorpay
    Route::get('/settings', [DoctorSettingsController::class, 'index'])->name('settings');
    Route::post('/settings/profile', [DoctorSettingsController::class, 'updateProfile'])->name('settings.profile');
    Route::post('/settings/razorpay', [DoctorSettingsController::class, 'updateRazorpay'])->name('settings.razorpay');
    Route::post('/settings/branding', [DoctorSettingsController::class, 'updateBranding'])->name('settings.branding');
    Route::post('/settings/domain', [DoctorSettingsController::class, 'updateDomain'])->name('settings.domain');

    // Clinic Services Management
    Route::post('/services/seed-defaults', [DoctorServiceController::class, 'seedDefaults'])->name('services.seed_defaults');
    Route::post('/services/{id}/toggle-status', [DoctorServiceController::class, 'toggleStatus'])->name('services.toggle_status');
    Route::resource('services', DoctorServiceController::class);

    // Custom Pages Builder
    Route::post('/pages/seed-defaults', [DoctorPageController::class, 'seedDefaults'])->name('pages.seed_defaults');
    Route::resource('pages', DoctorPageController::class);

    // Subscription & Billing
    Route::get('/subscription', [DoctorSubscriptionController::class, 'index'])->name('subscription.index');
    Route::post('/subscription/order', [DoctorSubscriptionController::class, 'createOrder'])->name('subscription.order');
    Route::post('/subscription/verify', [DoctorSubscriptionController::class, 'verifyPayment'])->name('subscription.verify');

    // Clinic Support & Help Center
    Route::get('/support', [DoctorDashboardController::class, 'support'])->name('support');
});

// Backward-compatibility redirect from legacy /doctor/* routes to /clinic/*
Route::middleware(['auth'])->group(function () {
    Route::get('/doctor/dashboard', fn() => redirect()->route('clinic.dashboard'))->name('doctor.dashboard');
    Route::get('/doctor/settings', fn() => redirect()->route('clinic.settings'))->name('doctor.settings');
    Route::get('/doctor/services', fn() => redirect()->route('clinic.services.index'))->name('doctor.services.index');
    Route::get('/doctor/subscription', fn() => redirect()->route('clinic.subscription.index'))->name('doctor.subscription.index');
    Route::get('/doctor/support', fn() => redirect()->route('clinic.support'))->name('doctor.support');
    Route::get('/doctor/{any}', function ($any) {
        return redirect('/clinic/' . $any);
    })->where('any', '.*');
});


// ==========================================
// Super Admin SaaS Platform Routes
// ==========================================
Route::group(['prefix' => 'admin/saas', 'as' => 'admin.saas.', 'middleware' => ['auth', 'super_admin']], function () {
    Route::get('/dashboard', [SaaSAdminController::class, 'dashboard'])->name('dashboard');

    // Clinics Management
    Route::get('/clinics', [SaaSAdminController::class, 'clinics'])->name('clinics');
    Route::get('/clinics/create', [SaaSAdminController::class, 'createClinic'])->name('clinic.create');
    Route::post('/clinics', [SaaSAdminController::class, 'storeClinic'])->name('clinic.store');
    Route::get('/clinics/{id}/edit', [SaaSAdminController::class, 'editClinic'])->name('clinic.edit');
    Route::put('/clinics/{id}', [SaaSAdminController::class, 'updateClinic'])->name('clinic.update');
    Route::get('/clinics/{id}/impersonate', [SaaSAdminController::class, 'impersonate'])->name('impersonate');
    Route::get('/clinics/{id}/visit-plan', [SaaSAdminController::class, 'visitDoctorPlan'])->name('visit_doctor_plan');
    Route::get('/stop-impersonate', [SaaSAdminController::class, 'stopImpersonate'])->name('stop_impersonate');

    // Plans Management
    Route::get('/plans', [SaaSAdminController::class, 'plans'])->name('plans');
    Route::get('/plans/create', [SaaSAdminController::class, 'createPlan'])->name('plan.create');
    Route::post('/plans', [SaaSAdminController::class, 'storePlan'])->name('plan.store');
    Route::get('/plans/{id}/edit', [SaaSAdminController::class, 'editPlan'])->name('plan.edit');
    Route::put('/plans/{id}', [SaaSAdminController::class, 'updatePlan'])->name('plan.update');
    Route::post('/plans/{id}/toggle-status', [SaaSAdminController::class, 'togglePlanStatus'])->name('plan.toggle_status');

    // Clinic Special Feature Access & VIP Grants
    Route::post('/clinics/{id}/extra-access', [SaaSAdminController::class, 'updateClinicExtraAccess'])->name('clinic.extra_access');
    Route::post('/clinics/{id}/revoke-extra-access', [SaaSAdminController::class, 'revokeClinicExtraAccess'])->name('clinic.revoke_extra_access');

    // Audit Logs
    Route::get('/logs', [SaaSAdminController::class, 'logs'])->name('logs');

    // Platform Razorpay Credentials
    Route::get('/payment-settings', [SaaSAdminController::class, 'platformPaymentSettings'])->name('payment_settings');
    Route::post('/payment-settings', [SaaSAdminController::class, 'updatePlatformPaymentSettings'])->name('payment_settings.update');
});
