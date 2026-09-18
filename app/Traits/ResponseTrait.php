<?php

namespace App\Traits;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;
use Throwable;

trait ResponseTrait
{
    
    /**
     * Success Response Default
     *
     * @param array|string|null $data
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    public function successResponse(JsonResource|array|string|null $data = null , string $message = "Succes" , int $code = 200 ): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
            'status' => true
        ],$code);
    }
    /**
     * Error Response Default
     *
     * @param Exception|Throwable $exception
     * @param string|null $message
     * @param int $code
     * @return JsonResponse
     */
    public function errorResponse(Exception|Throwable $exception ,string|null $message = null, int $code = 500): JsonResponse
    {
        Log::error($exception->getMessage(),[
            'trace' => $exception->getTrace(),
            'line' => $exception->getLine(),
            'code' => $exception->getCode()
        ]);

        return response()->json([
            'message' => $message ?? $exception->getMessage() ?? "Please try again later.",
            'status' => false,
            'data' => null
        ],$exception->getCode() > 400 ? $exception->getCode() : $code);
    }
}
