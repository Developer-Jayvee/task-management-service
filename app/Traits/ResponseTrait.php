<?php

namespace App\Traits;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Throwable;

trait ResponseTrait
{
    /**
     * Success Response Default
     *
     * @param  array|string|null  $data
     */
    public function successResponse(mixed $data = null, string $message = 'Succes', int $code = 200): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
            'status' => true,
        ], $code);
    }

    /**
     * Error Response Default
     */
    public function errorResponse(Exception|Throwable $exception, ?string $message = null, int $code = 500): JsonResponse
    {
        Log::error($exception->getMessage(), [
            'trace' => $exception->getTrace(),
            'line' => $exception->getLine(),
            'code' => $exception->getCode(),
        ]);

        return response()->json([
            'message' => $message ?? $exception->getMessage() ?? 'Please try again later.',
            'status' => false,
            'data' => null,
        ], $exception->getCode() > 400 ? $exception->getCode() : $code);
    }
}
