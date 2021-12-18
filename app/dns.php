<?php

require_once __DIR__.'/init.php';

use Appwrite\DNS\Server;
use Appwrite\DNS\Server\Native;
use Appwrite\DNS\Server\Swoole;
use Utopia\CLI\Console;

Console::success('DNS server started successfully');

$server = new Server(new Native());

$server->start();