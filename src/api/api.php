<?php
require __DIR__ . '/../../vendor/autoload.php';

use \API\Controller\Room_Controller;
use \API\DAO\Room_DAO;
use \API\Service\Room_Service;
use \Slim\App;

$app = new App([
	'settings' => [
		'displayErrorDetails' => true
	]
]);

$container = $app->getContainer();

$room_dao = new Room_DAO();
$room_service = new Room_Service($room_dao);
$room_controller = new Room_Controller($room_service);

$container['Room_Controller'] = function() use ($room_controller) {
	return $room_controller;
};

require_once __DIR__ . '/routes.php';
?>