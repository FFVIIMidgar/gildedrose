<?php
/**
 * api.php
 *
 * API bootstrap code. Sets up controllers, services, DAOs, routes, and containers.
 *
 * @author A.J. Rodriguez <avrodriguezjr@gmail.com>
 */

require __DIR__ . '/../../vendor/autoload.php';

require_once __DIR__ . '/../config/config.php';

use \API\Controller\Booking_Controller;
use \API\Controller\Gnome_Squad_Controller;
use \API\Controller\Room_Controller;
use \API\DAO\Booking_DAO;
use \API\DAO\Gnome_Squad_DAO;
use \API\DAO\Room_DAO;
use \API\Service\Booking_Service;
use \API\Service\Gnome_Squad_Service;
use \API\Service\Room_Service;
use \Slim\App;

// Initialize DAOs.
$booking_dao = new Booking_DAO();
$gnome_squad_dao = new Gnome_Squad_DAO();
$room_dao = new Room_DAO();

// Initialize services.
$booking_service = new Booking_Service($booking_dao);
$gnome_squad_service = new Gnome_Squad_Service($gnome_squad_dao);
$room_service = new Room_Service($room_dao);

// Initialize controllers.
$booking_controller = new Booking_Controller($booking_service);
$gnome_squad_controller = new Gnome_Squad_Controller($gnome_squad_service);
$room_controller = new Room_Controller($room_service);

// Error details are shown for development.
$app = new App([
	'settings' => [
		'displayErrorDetails' => true
	]
]);

$container = $app->getContainer();

// Register controllers.
$container['Booking_Controller'] = function() use ($booking_controller) {
	return $booking_controller;
};

$container['Gnome_Squad_Controller'] = function() use ($gnome_squad_controller) {
	return $gnome_squad_controller;
};

$container['Room_Controller'] = function() use ($room_controller) {
	return $room_controller;
};

require_once __DIR__ . '/routes.php';
?>