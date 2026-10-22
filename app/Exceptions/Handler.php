<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        // Handle CSRF Token Mismatch / Session Expiration on Form Submissions
        $this->renderable(function (\Illuminate\Session\TokenMismatchException $e, $request) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'CSRF token mismatch or session expired',
                    'error' => 'Please refresh and try again',
                ], 419);
            }

            return redirect()->guest(route('login'))
                ->with('session_expired', true)
                ->with('error', 'Your session or security token has expired. Please log in again to continue.');
        });
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson() || $request->is('api/*')) {
            // Return JSON response for API
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated',
                'error' => 'Invalid or missing token',
            ], 401);
        }

        // Return proper redirect for web browser requests
        return redirect()->guest(route('login'))
            ->with('session_expired', true)
            ->with('error', 'Your session has expired due to inactivity. Please log in again to continue.');
    }

}
