<?php

namespace Appwrite\Repository;

#[\Attribute(\Attribute::TARGET_PARAMETER)]
class RequestMethod
{
    public function __construct(
        public string $methodName,
        public array  $args = []
    )
    {
    }
}