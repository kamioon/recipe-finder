<?php

declare(strict_types=1);

const APP_DIR = __DIR__ . '/Application';
require_once __DIR__ . "/vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();