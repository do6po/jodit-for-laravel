<?php

namespace Do6po\LaravelJodit\Validators;

class PathValidator extends AbstractPathValidator
{
    public function passes($attribute, $value): bool
    {
        $backs = substr_count($value, '..');

        $dirs = $this->getDirNesting($value);

        return $dirs >= $backs;
    }

    public function message()
    {
        return ':attribute - error! ' . __('Can\'t write file below root directory');
    }
}
