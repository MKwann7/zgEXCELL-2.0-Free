<?php

header('Content-Type:text/javascript');

require PUBLIC_PORTAL . "js/libraries.js.php";
require PUBLIC_PORTAL . "js/general.js.php";
require PUBLIC_PORTAL . "js/authentication.js.php";
require PUBLIC_WIDGETS . "js/application.js.php";
require PUBLIC_WIDGETS . "js/modal.new.js.php";
require PUBLIC_WIDGETS . "js/ajax.new.js.php";
require PUBLIC_PORTAL . "js/vueComponent.js.php";
require PUBLIC_PORTAL . "js/shoppingCart.js.php";

?>

const ajax = new AjaxApp();
const modal = new ModalApp();
