<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class UserExceptions extends Exception
{
    public function __construct($message = null, $code = 0, Exception $previous = null) {
        $message = $message ?? __('errors.user_data_failed');
        parent::__construct($message, $code, $previous);
    }

    /**
     * @param Exception $e
     * @return UserExceptions
     */
    public static function userDataNotFound(Exception $e): UserExceptions
    {
        $message = __('errors.no_data') . $e->getMessage();
        return new self($message, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @return UserExceptions
     */
    public static function userIdNotFound(): UserExceptions
    {
        return new self(__('errors.no_user_id_found'), Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function report() {
        // Log the exception or send it to an external service
        Log::error($this->getMessage());
    }

    public function render($request) {
        // in the event the exception is not caught lets render this
        return response()->json([
            'error' => $this->getMessage(),
        ], 422);
    }
}
