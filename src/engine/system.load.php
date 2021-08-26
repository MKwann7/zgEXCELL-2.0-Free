<?php
/**
 * SHELL _site_core Extention for zgWeb.Solutions Web.CMS.App
 */

define("App", true);
define("Appversion", "2.0.0");
define("XT", ".php");

// Load App Class
require AppCore . "engine/core/definitions" . XT;

// Load Custom Functions
require AppLibraries . "custom.functions" . XT;

// Autoload Class
require AppCore . "engine/core/auto.load" . XT;

// App Class Instantiation
return require AppCore . "engine/core/app.service" . XT;
