<?php

namespace Do6po\LaravelJodit\Validators;

use Closure;

class PathValidator extends AbstractPathValidator
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $backs = substr_count($value, '..');

        $dirs = $this->getDirNesting($value);

        if ($dirs < $backs) {
            $fail(':attribute - error! ' . __('Can\'t write file below root directory'));
        }
    }
}
