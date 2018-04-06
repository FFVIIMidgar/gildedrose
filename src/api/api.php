<?php
require __DIR__ . '/../../vendor/autoload.php';

use \API\Controller\Booking_Controller;
use \API\Controller\Room_Controller;
use \API\DAO\Booking_DAO;
use \API\DAO\Room_DAO;
use \API\Service\Booking_Service;
use \API\Service\Room_Service;
use \Slim\App;

$app = new App([
	'settings' => [
		'displayErrorDetails' => true
	]
]);

$container = $app->getContainer();

$booking_dao = new Booking_DAO();
$room_dao = new Room_DAO();
$booking_service = new Booking_Service($booking_dao);
$room_service = new Room_Service($room_dao);
$booking_controller = new Booking_Controller($booking_service);
$room_controller = new Room_Controller($room_service);

$container['Room_Controller'] = function() use ($room_controller) {
	return $room_controller;
};

$container['Booking_Controller'] = function() use ($booking_controller) {
	return $booking_controller;
};

require_once __DIR__ . '/routes.php';
?>