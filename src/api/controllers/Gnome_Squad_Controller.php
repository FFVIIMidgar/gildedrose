<?php
/**
 * Gnome_Squad_Controller
 *
 * Controller for Gnome Squad (cleaning) routes.
 *
 * @author A.J. Rodriguez <avrodriguezjr@gmail.com>
 */ 

namespace API\Controller;

use \API\Controller\Base_Controller;
use \DateTime;
use \Exception;

class Gnome_Squad_Controller extends Base_Controller {
	/**
	 * Constructs a new Gnome_Squad_Controller.
	 *
	 * @param \API\Service\Gnome_Squad_Service $service Associated Service
	 */
	public function __construct($service) {
		parent::__construct($service);
	}

	/**
	 * Handles the /management/schedule route.
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request  Request
	 * @param \Psr\Http\Message\ResponseInterface      $response Response
	 * @param string[]                                 $args     Arguments
	 *
	 * @return \Psr\Http\Message\ResponseInterface Response
	 */
	public function get_gnome_squad_schedule($request, $response, $args) {
		try {
			// Extract and check parameters.
			$date = $request->getParam('date') ? DateTime::createFromFormat('Y-m-d', $request->getParam('date')) : null;
			$this->check_request_parameters([$date]);

			// Get all cleanings on the given date.
			$cleanings = $this->service->get_cleanings_by_date($date);

			// Send back the JSON results.
			$response->getBody()->write($this->service->json_encode_gnome_squad_schedule($date, $cleanings));
			return $response;
		} catch (Exception $e) {
			// Send back the error.
			$response->getBody()->write($this->create_error($e));
		}
	}
}
?>