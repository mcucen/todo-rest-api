<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
        $this->reportable(function (Request $request, Throwable $e) {
            return $this->render($request, $e);
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param Exception|Throwable $e
     * @return ResponseAlias
     */
    public function render($request, Exception|Throwable $e)
    {
        switch (true) {
            case $e instanceof \Illuminate\Auth\AuthenticationException:
            case $e instanceof UnauthorizedHttpException:
                return response()->json([
                    'message' => 'Unauthenticated'
                ], 401);
            case $e instanceof \Illuminate\Validation\ValidationException:
                return response()->json([
                    'message' => 'Validation error',
                    'errors' => $e->errors()
                ], 422);
            case $e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException:
                return response()->json([
                    'message' => 'Not found'
                ], 404);
            case $e instanceof \Illuminate\Database\QueryException:
                return response()->json([
                    'message' => 'Query error'
                ], 500);
            default:
                return response()->json([
                    'message' => 'Server error'
                ], 500);
        }
    }
}
