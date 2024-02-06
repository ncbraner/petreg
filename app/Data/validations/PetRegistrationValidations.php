<?php

namespace App\Data\Validations;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;

class PetRegistrationValidations
{
    protected array $attributes;

    /**
     * PetRegistrationValidations constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->setData($attributes);
    }

    /**
     * Set the attributes.
     *
     * @param array $attributes
     * @return $this
     */
    public function setData(array $attributes): self
    {
        $this->attributes = array_map(function ($value) {
            return is_string($value) ? strtolower($value) : $value;
        }, $attributes);

        return $this;
    }

    /**
     * Get the validation rules.
     *
     * @param array $attributes
     * @return array
     */
    public static function rules(array $attributes): array
    {
        return [
            'name' => ['required', 'string', Rule::in(['larry', 'bob'])],
            'type' => ['required', 'string', Rule::in(['dog', 'cat'])],
            'breed' => 'required|int',
            'breedDetail' => 'required|string|max:255',
            'gender' => ['required', Rule::in(['male', 'female'])],
            'mixDetail' => [
                Rule::requiredIf(function () use ($attributes) {
                    return $attributes['breed'] == 1 && $attributes['breedDetail'] == 'I don\'t know';
                }),
                'nullable',
                'string',
            ],
        ];
    }

    /**
     * Get the type rules.
     *
     * @param array $attributes
     * @return array
     */
    public static function typeRules(array $attributes = []): array
    {
        $rules = self::rules([]);

        return ['type' => $rules['type']];
    }

    /**
     * Convert the rules to JSON.
     *
     * @return string
     */
    public static function rulesToJson(): string
    {
        $rules = self::rules([]);

        $jsonRules = [];

        foreach ($rules as $field => $fieldRules) {
            if (!is_array($fieldRules)) {
                $fieldRules = [$fieldRules];
            }

            foreach ($fieldRules as $rule) {
                if ($rule instanceof \Illuminate\Validation\Rules\In) {
                    $jsonRules[$field][] = (string)$rule;
                } else if (is_string($rule)) {
                    $jsonRules[$field][] = $rule;
                } else {
                    // Handle other types of rules here
                }
            }
        }

        return json_encode($jsonRules);
    }

    /**
     * Validate the attributes.
     *
     * @return ValidatorContract
     */
    public function validate(): ValidatorContract
    {
        $validator = Validator::make($this->attributes, self::rules($this->attributes));

        if ($validator->fails()) {
            return $validator;
        }

        return $validator;
    }
}
