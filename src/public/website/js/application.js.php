<?php

require PublicWidgets . "js/application.js.php";
require PublicWidgets . "js/modal.js.php";
require PublicWidgets . "js/ajax.js.php";
require PublicWidgets . "js/loadWidget.js.php";

?>

const app = new Application();
const ajax = new AjaxApp();
const modal = new ModalApp();

$(document).ready(function () {
    app.load();
});
