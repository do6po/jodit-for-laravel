<?php

namespace Do6po\LaravelJodit\Tests\Helpers\Traits;

use ReflectionException;
use ReflectionMethod;

trait AccessModificationTrait
{
    /**
     * @param $object
     * @param string $methodName
     * @return ReflectionMethod
     * @throws ReflectionException
     */
    public function setMethodAsPublic($object, string $methodName)
    {
        $method = new ReflectionMethod($object, $methodName);

        $method->setAccessible(true);

        return $method;
    }
}
