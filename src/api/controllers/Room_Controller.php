<?php
/**
 * Room_Controller
 *
 * Controller for room routes.
 *
 * @author A.J. Rodriguez <avrodriguezjr@gmail.com>
 */

namespace API\Controller;

use \API\Controller\Base_Controller;
use \DateTime;
use \Exception;

class Room_Controller extends Base_Controller {
	/**
	 * Constructs a new Room_Controller.
	 *
	 * @param \API\Service\Room_Service $service Associated service
	 */
	public function __construct($service) {
		parent::__construct($service);
	}

	/**
	 * Handles the /rooms/available route.
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request  Request
	 * @param \Psr\Http\Message\ResponseInterface      $response Response
	 * @param string[]                                 $args     Arguments
	 *
	 * @return \Psr\Http\Message\ResponseInterface Response
	 */
	public function get_room_availability($request, $response, $args) {
		try {
			// Extract and check parameters.
			$date = $request->getParam('date') ? DateTime::createFromFormat('Y-m-d', $request->getParam('date')) : null;
			$item_count = $request->getParam('itemCount') !== null ? intval($request->getParam('itemCount')) : null;
			$this->check_request_parameters([$date, $item_count]);

			// Get all available rooms on the given date with the given item count.
			$available_rooms = $this->service->get_room_availability($date, $item_count);
			
			// Send back the JSON results.
			$response->getBody()->write($this->service->json_encode_available_rooms($date, $item_count, $available_rooms));
			return $response;
		} catch (Exception $e) {
			// Send back the error.
			$response->getBody()->write($this->create_error($e));
		}
	}
}
?>