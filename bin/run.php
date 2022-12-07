#!/usr/bin/env php
<?php

declare(strict_types=1);

use Symfony\Component\Console\Application;
use App\Console\FindRecipeCommand;

const ROOT_DIR = __DIR__ . '/..';
const APP_DIR = __DIR__ . '/src';
require_once __DIR__ . "/../vendor/autoload.php";

try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../");
    $dotenv->load();
    $app = new Application($_ENV["APP_NAME"], $_ENV["APP_VERSION"]);
    $app->add(new FindRecipeCommand());
    $app->run();
} catch (\Exception $e) {
    die($e->getMessage());
}