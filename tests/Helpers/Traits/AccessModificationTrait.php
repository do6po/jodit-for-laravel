<?php

namespace Do6po\LaravelJodit\Tests\Helpers\Traits;

use ReflectionException;
use ReflectionMethod;

trait AccessModificationTrait
{
    /**
     * @throws ReflectionException
     */
    public function setMethodAsPublic($object, string $methodName): ReflectionMethod
    {
        $method = new ReflectionMethod($object, $methodName);

        $method->setAccessible(true);

        return $method;
    }
}
