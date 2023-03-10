<?php

namespace App\Rules;

use App\Helpers\Converter;
use App\Helpers\PhpSettings;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Storage;

class MaxFileSizeRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $uploadSize = Converter::toBytes(PhpSettings::uploadMaxFilesize());
        $postSize = Converter::toBytes(PhpSettings::postMaxSize());

        $fileSize = $value->getSize();

        if($fileSize > $uploadSize || $fileSize > $postSize) {
            $maxSize = $postSize <= $uploadSize ? PhpSettings::postMaxSize() : PhpSettings::uploadMaxFilesize();
            $fail("The :attribute size must be < $maxSize.");
        }

    }
}
