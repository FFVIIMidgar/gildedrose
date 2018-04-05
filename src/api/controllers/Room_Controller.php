<?php
namespace API\Controller;

use \API\Controller\Base_Controller;
use \API\Service\Room_Service;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class Room_Controller extends Base_Controller {
	public function __construct(Room_Service $service) {
		parent::__construct($service);
	}

	public function get_room_availability(Request $request, Response $response, $args) {
		echo 'Called get_room_availability';
	}
}
?>