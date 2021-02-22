<?php
ini_set('memory_limit','512M');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('default_socket_timeout', -1);

error_reporting(E_ALL);

require_once __DIR__.'/init.php';

use Utopia\App;
use Utopia\CLI\CLI;
use Utopia\CLI\Console;

$cli = new CLI();

include 'tasks/doctor.php';
include 'tasks/maintenance.php';
include 'tasks/install.php';
include 'tasks/migrate.php';
include 'tasks/sdks.php';
include 'tasks/ssl.php';
include 'tasks/vars.php';

$cli
    ->task('version')
    ->desc('Get the server version')
    ->action(function () {
        Console::log(App::getEnv('_APP_VERSION', 'UNKNOWN'));
    });

$cli->run();