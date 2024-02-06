<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserAuthRequest extends FormRequest
{
    public function rules()
    {
        return [
            'authId' => 'required|string',
        ];
    }
}
