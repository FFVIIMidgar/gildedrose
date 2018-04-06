<?php
namespace API\Controller;

use \API\Controller\Base_Controller;

class Room_Controller extends Base_Controller {
	public function __construct($service) {
		parent::__construct($service);
	}

	public function get_room_availability($request, $response, $args) {
		try {
			$date = $request->getParam('date');
			$item_count = $request->getParam('itemCount');
			$this->check_request_parameters([$date, $item_count]);

			$available_rooms = $this->service->get_room_availability($date, $item_count);
			
			return $this->service->json_encode_available_rooms($date, $item_count, $available_rooms);
		} catch (\Exception $e) {
			echo $this->create_error($e);
		}
	}
}
?>