<?php

require_once __DIR__.'/init.php';

use Appwrite\DNS\Server;
use Appwrite\DNS\Adapter\Native;
use Appwrite\DNS\Adapter\Swoole;
use Appwrite\DNS\Resolver\Mock;
use Utopia\CLI\Console;

Console::success('DNS server started successfully');

$server = new Server(new Native(), new Mock);

$server->start();