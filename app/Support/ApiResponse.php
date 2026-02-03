<?php
 
namespace App\Support;
 
use Illuminate\Http\JsonResponse;
 
class ApiResponse
{
    /**
     * success response JSON format
     * @param string $message
     * @param mixed|null $data
     * @param string $code
     * @param int $status
     * @param array $meta
     * @return JsonResponse
     */
    public static function success(
        string $message,
        mixed $data = null,
        string $code = "SUCCESS",
        int $status = 200,
        array $meta = []
    ): JsonResponse {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
            'code' => $code,
            'meta' => $meta
        ], $status);
    }
 
    /**
     * error response JSON format
     * @param string $message
     * @param string $code
     * @param array $errors
     * @param int $status
     * @return JsonResponse
     */
 
    public static function error(
        string $message,
        string $code,
        array $errors = [],
        int $status = 400,
    ): JsonResponse {
        return response()->json([
            'success' => false,
            'message' => $message,
            'code' => $code,
            'errors' => $errors,
        ], $status);
    }
 
}