<?php
/**
 * Booking_Controller
 *
 * Controller for booking routes.
 *
 * @author A.J. Rodriguez <avrodriguezjr@gmail.com>
 */ 

namespace API\Controller;

use \API\Controller\Base_Controller;
use \API\DAO\Guest_DAO;
use \API\DAO\Room_DAO;
use \API\Model\Guest_Model;
use \API\Service\Guest_Service;
use \API\Service\Room_Service;
use \DateTime;
use \Exception;

class Booking_Controller extends Base_Controller {
	/**
	 * Constructs a new Booking_Controller.
	 *
	 * @param \API\Service\Booking_Service $service Associated service
	 */
	public function __construct($service) {
		parent::__construct($service);
	}

	/**
	 * Handles the /booking/book route.
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request  Request
	 * @param \Psr\Http\Message\ResponseInterface      $response Response
	 * @param string[]                                 $args     Arguments
	 *
	 * @return \Psr\Http\Message\ResponseInterface Response
	 */
	public function book_room($request, $response, $args) {
		try {
			// Decode and check the request body.
			$body = json_decode($request->getBody(), true);
			$this->check_request_body($body);
			
			// Extract and check parameters.
			$date = isset($body['date']) ? DateTime::createFromFormat('Y-m-d', $body['date']) : null;
			$item_count = isset($body['itemCount']) ? intval($body['itemCount']) : null;
			$first_name = isset($body['firstName']) ? $body['firstName'] : null;
			$last_name = isset($body['lastName']) ? $body['lastName'] : null;
			$email = isset($body['email']) ? $body['email'] : null;
			$this->check_request_parameters([$date, $item_count, $first_name, $last_name, $email]);

			// Initialize other services needed.
			$room_service = new Room_Service(new Room_DAO());
			$guest_service = new Guest_Service(new Guest_DAO());

			// Create a new guest object for booking.
			$guest = new Guest_Model(null, $first_name, $last_name, $email);

			// Add the guest if it doesn't exist in the database.
			$guest_service->create_guest_if_not_exist($guest);

			// Book the room on the given date
			$available_rooms = $room_service->get_room_availability($date, $item_count);
			$booking_results = $this->service->book_room($guest, $date, $item_count, $available_rooms);

			// Send back the JSON results.
			$response->getBody()->write($this->service->json_encode_booking_results($booking_results));
			return $response;
		} catch (Exception $e) {
			// Send back the error.
			$response->getBody()->write($this->create_error($e));
			return $response;
		}
	}
}
?>


