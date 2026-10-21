<?php

use App\Http\Controllers\web\WebViewController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminAuthController;
use App\Http\Controllers\admin\PaymentController;

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

// Route::get('/', function () {
//     return view('welcome');
// });
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
Route::post('/generate-order', [WebViewController::class, 'generateOrder']);
Route::post('/payment-success', [WebViewController::class, 'paymentSuccess']);
Route::post('/payment-failed', [WebViewController::class, 'paymentFailed']);
Route::get('/booking-success/{order_id}', [WebViewController::class, 'bookingSuccess']);
Route::get('/booking-failed/{order_id}', [WebViewController::class, 'bookingFailed']);
Route::get('/invoice/{id}', [WebViewController::class, 'show'])->name('invoice.show');

// Public Notice API endpoint aliases
Route::get('/notice-api', [\App\Http\Controllers\api\NoticeController::class, 'getNotice']);
Route::get('/get-notice', [\App\Http\Controllers\api\NoticeController::class, 'getNotice']);

