<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NotLessThan implements ValidationRule
{
    public function __construct(protected string $minField) {}

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $data = request()->all();

        // If the other field is not set, return.
        if (!isset($data[$this->minField])) {
            return;
        }

        if ((int)$value < (int)$data[$this->minField]) {
            $fail("The {$attribute} must be greater than or equal to {$this->minField}.");
        }
    }
}
