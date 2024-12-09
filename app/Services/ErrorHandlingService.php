<?php

namespace App\Services;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ErrorHandlingService
{
      /**
     * API hatalarını yakalamak ve uygun bir şekilde döndürmek.
     * 
     * @param Exception $exception
     * @return array
     */
    public function handleError(Exception $exception)
    {
        // Genel hatalar için log tutma işlemi
        Log::error($exception->getMessage(), ['exception' => $exception]);

        // Kullanıcıya gösterilecek genel hata mesajı
        $message = 'Bir hata oluştu. Lütfen tekrar deneyin.';

        // Hata türüne göre farklı durum kodları döndürme
        if ($exception instanceof ModelNotFoundException) {
            $message = 'Veri bulunamadı.';
            return $this->formatResponse($message, Response::HTTP_NOT_FOUND);
        }

        if ($exception instanceof ValidationException) {
            return $this->formatResponse($exception->errors(), Response::HTTP_BAD_REQUEST);
        }

        return $this->formatResponse($message, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Hata yanıtını formatlamak.
     *
     * @param string|array $message
     * @param int $statusCode
     * @return array
     */
    private function formatResponse($message, $statusCode)
    {
        return [
            'status' => 'error',
            'message' => $message,
            'status_code' => $statusCode
        ];
    }
}