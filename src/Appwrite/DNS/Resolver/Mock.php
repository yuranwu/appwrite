<?php

namespace Appwrite\DNS\Resolver;

use Socket;
use Appwrite\DNS\Resolver;

class Mock extends Resolver
{   
    /**
     * Resolve DNS Record
     * 
     * @param string $domain
     * @param string $type
     */
    public function resolve(string $domain, string $type): string {
        return '127.0.0.1';
    }
}