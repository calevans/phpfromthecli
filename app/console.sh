#!/usr/bin/env php
<?php
require_once __DIR__.'/../vendor/autoload.php'; 

use phpfromthecli\Command;
use Symfony\Component\Console\Application;

Dotenv::load(dirname(__FILE__) . '/../config/','twitter.env');

$app = new Application('PHPFromTheCLI', '1.0');
$app->addCommands([new Command\SearchCommand(),
	               new Command\TestCommand(),
	               new Command\EchoCommand()
    ]);
$app->run();