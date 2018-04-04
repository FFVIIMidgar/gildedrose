<?php
require __DIR__ . '/../../vendor/autoload.php';

use \Slim\App as App;

$app = new App();
$container = $app->getContainer();

require_once __DIR__ . '/routes.php';
?>