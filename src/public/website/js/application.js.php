<?php

require PUBLIC_WIDGETS . "js/application.js.php";
require PUBLIC_WIDGETS . "js/modal.new.js.php";
require PUBLIC_WIDGETS . "js/ajax.new.js.php";
require PUBLIC_WIDGETS . "js/loadWidget.js.php";

?>

const app = new Application();
const ajax = new AjaxApp();
const modal = new ModalApp();

$(document).ready(function () {
    app.load();
});
