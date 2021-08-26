<?php

const AppCore = __DIR__ . "/";
const AppStart = "Web";

// Load Core Files
/** @var App\Core\App $app */
$app = require(AppCore.'engine/system.load.php');

// Load App Engine
$app->load();

// Execute App
$app->run();

