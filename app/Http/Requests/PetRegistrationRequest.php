<?php

namespace App\Http\Requests;

use App\Data\Validations\PetRegistrationValidations;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PetRegistrationRequest extends FormRequest
{
    public function all($keys = null)
    {
        $data = parent::all($keys);

        foreach ($data as $key => $value) {
            if (is_string($value)) {
                $data[$key] = strtolower($value);
            }
        }

        return $data;
    }

    public function rules(): array
    {
        $attributes = $this->all();

        return PetRegistrationValidations::rules($attributes);
    }


    public function rulesToJson(): array
    {
        $attributes = $this->all();

        $rules = $this->rules();

        $jsonRules = [];

        foreach ($rules as $field => $fieldRules) {
            // Ensure $fieldRules is an array
            if (!is_array($fieldRules)) {
                $fieldRules = [$fieldRules];
            }

            foreach ($fieldRules as $rule) {
                if (method_exists($rule, '__toString')) {
                    $jsonRules[$field][] = (string) $rule;
                } else if (is_string($rule)) {
                    $jsonRules[$field][] = $rule;
                }
            }
        }

        return $jsonRules;
    }
}
