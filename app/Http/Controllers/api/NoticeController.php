<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class NoticeController extends Controller
{
    /**
     * Get the active frontend notice and clinic settings.
     * Publicly accessible API for frontend HTML pages.
     */
    public function getNotice(Request $request): JsonResponse
    {
        $setting = Setting::first();

        $notice = $setting ? ($setting->frontend_notice ?? '') : '';

        $response = [
            'status' => true,
            'message' => 'Notice fetched successfully.',
            'has_notice' => !empty(trim($notice)),
            'notice' => $notice,
            'notice_html' => !empty($notice) ? nl2br(e($notice)) : '',
            'data' => [
                'notice' => $notice,
                'clinic_phone_number' => $setting->clinic_phone_number ?? '',
                'pay_amount' => $setting->pay_amount ?? '',
                'updated_at' => $setting->updated_at ? $setting->updated_at->toIso8601String() : null,
            ]
        ];

        return response()->json($response, 200, [
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods' => 'GET, OPTIONS',
            'Access-Control-Allow-Headers' => 'Content-Type, X-Requested-With, Authorization, Origin, Accept',
        ]);
    }
}
