<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;
use Src\Domain\Profile\Infrastructure\Model\Profile;

class VerifyUniqueEmail implements ValidationRule
{
    public function __construct(private string $profileId) {}

    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (Profile::where('id', '!=', $this->profileId)->where('email', $value)->first() !== null) {
            $fail('The :attribute already exists.');
        }
    }
}
