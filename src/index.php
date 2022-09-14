<?php

const APP_CORE = __DIR__ . "/";
const APP_START = "Web";

// Load Core Files
/** @var App\Core\App $app */
$app = require(APP_CORE . 'engine/system.load.php');

// Load App Engine
$app->load();

// Execute App
$app->run();

