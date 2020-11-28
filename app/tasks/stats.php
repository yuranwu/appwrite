<?php

global $cli;

use Appwrite\Database\Database;
use Appwrite\Database\Document;
use Appwrite\Database\Validator\Authorization;
use Appwrite\Database\Adapter\MySQL as MySQLAdapter;
use Appwrite\Database\Adapter\Redis as RedisAdapter;
use Utopia\CLI\Console;
use Utopia\Config\Config;

$cli
    ->task('stats')
    ->desc('Get Appwrite stats')
    ->action(function () use ($register) {
        
        Console::log('⏳ Aggregating server stats...');

        $consoleDB = new Database();
        $consoleDB->setAdapter(new RedisAdapter(new MySQLAdapter($register), $register));
        $consoleDB->setNamespace('app_console'); // Main DB
        $consoleDB->setMocks(Config::getParam('collections', []));

        Authorization::disable();

        $consoleDB->getCollection([
            'limit' => 0,
            'offset' => 0,
            'filters' => [
                '$collection='.Database::SYSTEM_COLLECTION_PROJECTS,
            ],
        ]);

        Console::log('👉 Total Projects: '.$consoleDB->getSum());

        $consoleDB->getCollection([
            'limit' => 0,
            'offset' => 0,
            'filters' => [
                '$collection='.Database::SYSTEM_COLLECTION_USERS,
            ],
        ]);

        Console::log('👉 Total Users: '.$consoleDB->getSum());

        $consoleDB->getCollection([
            'limit' => 0,
            'offset' => 0,
            'filters' => [
                '$collection='.Database::SYSTEM_COLLECTION_DOMAINS,
            ],
        ]);

        Console::log('👉 Total Domains: '.$consoleDB->getSum());
        
        $consoleDB->getCollection([
            'limit' => 0,
            'offset' => 0,
            'filters' => [
                '$collection='.Database::SYSTEM_COLLECTION_WEBHOOKS,
            ],
        ]);

        Console::log('👉 Total Webhooks: '.$consoleDB->getSum());
        
        $consoleDB->getCollection([
            'limit' => 0,
            'offset' => 0,
            'filters' => [
                '$collection='.Database::SYSTEM_COLLECTION_KEYS,
            ],
        ]);

        Console::log('👉 Total Keys: '.$consoleDB->getSum());
        
        $consoleDB->getCollection([
            'limit' => 0,
            'offset' => 0,
            'filters' => [
                '$collection='.Database::SYSTEM_COLLECTION_CERTIFICATES,
            ],
        ]);

        Console::log('👉 Total Certificates: '.$consoleDB->getSum());
        
        $consoleDB->getCollection([
            'limit' => 0,
            'offset' => 0,
            'filters' => [
                '$collection='.Database::SYSTEM_COLLECTION_PLATFORMS,
            ],
        ]);

        Console::log('👉 Total Platforms: '.$consoleDB->getSum());
    });
