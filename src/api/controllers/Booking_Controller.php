<?php
namespace API\Controller;

use \API\Controller\Base_Controller;
use \API\DAO\Guest_DAO;
use \API\DAO\Room_DAO;
use \API\Model\Guest_Model;
use \API\Service\Guest_Service;
use \API\Service\Room_Service;

class Booking_Controller extends Base_Controller {
	public function __construct($service) {
		parent::__construct($service);
	}

	public function book_room($request, $response, $args) {
		try {
			$body = json_decode($request->getBody(), true);
			$this->check_request_body($body);
			
			$date = isset($body['date']) ? $body['date'] : null;
			$item_count = isset($body['itemCount']) ? $body['itemCount'] : null;
			$first_name = isset($body['firstName']) ? $body['firstName'] : null;
			$last_name = isset($body['lastName']) ? $body['lastName'] : null;
			$email = isset($body['email']) ? $body['email'] : null;
			$this->check_request_parameters([$date, $item_count, $first_name, $last_name, $email]);

			$room_service = new Room_Service(new Room_DAO());
			$guest_service = new Guest_Service(new Guest_DAO());

			$guest = new Guest_Model(null, $first_name, $last_name, $email);
			$guest_service->create_guest_if_not_exist($guest);

			$available_rooms = $room_service->get_room_availability($date, $item_count);
			$booking_results = $this->service->book_room($guest, $date, $item_count, $available_rooms);

			echo $this->service->json_encode_booking_results($booking_results);
		} catch (\Exception $e) {
			echo $this->create_error($e);
		}
	}
}
?>


