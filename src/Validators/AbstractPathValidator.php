<?php

namespace Do6po\LaravelJodit\Validators;

use Illuminate\Contracts\Validation\Rule;

abstract class AbstractPathValidator implements Rule
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
