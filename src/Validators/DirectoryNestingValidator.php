<?php

namespace Do6po\LaravelJodit\Validators;

class DirectoryNestingValidator extends AbstractPathValidator
{
    private int $maxNesting;

    public function __construct(int $maxNesting)
    {
        $this->maxNesting = $maxNesting;
    }

    public function passes($attribute, $value): bool
    {
        return $this->maxNesting > $this->getDirNesting($value);
    }

    public function message()
    {
        return __('Maximum directory nesting is :count', ['count' => $this->maxNesting]);
    }
}
