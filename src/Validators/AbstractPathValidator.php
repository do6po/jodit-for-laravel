<?php

namespace Do6po\LaravelJodit\Validators;

use Illuminate\Contracts\Validation\ValidationRule;

abstract class AbstractPathValidator implements ValidationRule
{
    protected function getDirNesting(string $value): int
    {
        $dirs = 0;

        if (preg_match_all('/\/?(?<dir>[^.^\/]+)\/?/', $value, $match)) {
            $dirs = count($match['dir']);
        }

        return $dirs;
    }
}
