<?php
/**
 * SHELL _site_core Extention for zgWeb.Solutions Web.CMS.App
 */

if (!defined("App")) { die("Illegal Access"); }

define("AppLibraries", AppCore."engine/libraries/");
define("AppEngine", AppCore."engine/");
define("AppEngineCore", AppEngine."core/");
define("AppCoreData", AppEngineCore."data/");
define("AppModules", AppCore."modules/");
define("AppWebsiteData", AppCore."website/");
define("AppWebsiteTheme", AppWebsiteData."template/");
define("WebTheme", WebCore . "website/theme/");
