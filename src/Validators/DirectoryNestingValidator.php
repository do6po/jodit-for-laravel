<?php

namespace Do6po\LaravelJodit\Validators;

use Closure;

class DirectoryNestingValidator extends AbstractPathValidator
{
    private int $maxNesting;

    public function __construct(int $maxNesting)
    {
        $this->maxNesting = $maxNesting;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->maxNesting <= $this->getDirNesting($value)) {
            $fail(__('Maximum directory nesting is :count', ['count' => $this->maxNesting]));
        }
    }
}
