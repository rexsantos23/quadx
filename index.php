<?php

require './vendor/autoload.php';

$controller = new Controller\OrderController();

$response = $controller->index();

print($response);

?>