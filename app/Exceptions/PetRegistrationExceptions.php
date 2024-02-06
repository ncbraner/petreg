<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;


class PetRegistrationExceptions extends Exception
{
    public function __construct($message = null, $code = 0, Exception $previous = null) {
        $message = $message ?? __('errors.pet_registration_failed');
        parent::__construct($message, $code, $previous);
    }

    public static function invalidData($e): PetRegistrationExceptions
    {
        $message = __('errors.invalid_data') . $e->all()[0];
        return new self($message, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public static function invalidBreed(): PetRegistrationExceptions
    {
        return new self(__('errors.invalid_breed'), Response::HTTP_UNPROCESSABLE_ENTITY);
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
