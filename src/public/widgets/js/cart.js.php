<?php

header('Content-Type:text/javascript');

require PublicPortal . "js/libraries.js.php";
require PublicPortal . "js/general.js.php";
require PublicPortal . "js/authentication.js.php";
require PublicWidgets . "js/application.js.php";
require PublicWidgets . "js/modal.js.php";
require PublicWidgets . "js/ajax.js.php";
require PublicPortal . "js/vueComponent.js.php";
require PublicPortal . "js/shoppingCart.js.php";

?>

const ajax = new AjaxApp();
const modal = new ModalApp();
