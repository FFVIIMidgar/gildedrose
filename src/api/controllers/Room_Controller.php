<?php
namespace API\Controller;

use \API\Controller\Base_Controller;

class Room_Controller extends Base_Controller {
	public function __construct($service) {
		parent::__construct($service);
	}

	public function get_room_availability($request, $response, $args) {
		try {
			$body = json_decode($request->getBody(), true);
			$this->check_request_body($body);

			$date = isset($body['date']) ? $body['date'] : null;
			$item_count = isset($body['itemCount']) ? $body['itemCount'] : null;
			$this->check_request_parameters([$date, $item_count]);

			$date = new \DateTime($date);
			$date = $date->format('Y-m-d');

			$available_rooms = $this->service->get_room_availability($date, $item_count);
			return $this->service->json_encode_available_rooms($date, $item_count, $available_rooms);
		} catch (\Exception $e) {
			echo $this->create_error($e);
		}
	}
}
?>