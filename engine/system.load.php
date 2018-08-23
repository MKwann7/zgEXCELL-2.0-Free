<?php
/**
 * SHELL _site_core Extention for zgWeb.Solutions Web.CMS.App
 */

if (!defined('App')) { die('Illegal Access'); }

// Load App Class
require(AppCore."engine/core/definitions".XT);

// Load App Class
require(AppLibraries."app.class".XT);

// Load zgCORE Class
require(AppLibraries."core.class".XT);

// Load zgACCOUNT Class
require(AppLibraries."account.class".XT);

// Load zgFILE Class
require(AppLibraries."file.class".XT);

// Load zgCOM Class
require(AppLibraries."communication.class".XT);

// Load Custom Functions
require(AppLibraries."custom.functions".XT);

// Load Module Base
require(AppEngineCore . "module.base".XT);

// Load Model Base
require(AppEngineCore . "model.base".XT);