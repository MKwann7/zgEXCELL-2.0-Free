<?php
/**
 * SHELL _site_core Extention for zgWeb.Solutions Web.CMS.App
 */

define("App", true);
define("Appversion", "2.0.0");
define("XT", ".php");
define("AppCore", dirname(__FILE__)."/");

// Load Core Files
require(AppCore.'engine/system.load'.XT);

// Load App Engine
App::Load();

// Execute App
App::Run();