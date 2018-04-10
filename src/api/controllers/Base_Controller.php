<?php
/**
 * Base_Controller
 *
 * Base class for all controllers.
 *
 * @author A.J. Rodriguez <avrodriguezjr@gmail.com>
 */

namespace API\Controller;

use \Exception;

abstract class Base_Controller {
	/**
	 * Associated service.
	 * @var \API\Service\Base_Service $service
	 */
	protected $service;

	/**
	 * Constructs a new Base_Controller.
	 *
	 * @param \API\Service\Base_Service $service Associated service
	 */
	public function __construct($service) {
		$this->service = $service;
	}

	/**
	 * Checks to see if the request body is valid, i.e. it is well-formatted. 
	 * Returns true if valid and throws an exception otherwise.
	 *
	 * @param mixed[] $body Decoded JSON data
	 *
	 * @return bool True if the request body is valid
	 *
	 * @throws Exception if the request body is invalid
	 */
	protected function check_request_body($body) {
		if (empty($body)) {
			throw new Exception('Request body is invalid.');
		}

		return true;
	}

	/**
	 * Checks to see if the passed parameters contain values, i.e. not null. 
	 * Returns true if the parameters contain values and throws an exception otherwise.
	 *
	 * @param mixed[] $parameters Array of parameters
	 *
	 * @return bool True if the parameters contain values
	 *
	 * @throws Exception if any parameter is null
	 */
	protected function check_request_parameters($parameters) {
		foreach ($parameters as $parameter) {
			if ($parameter === null) {
				throw new Exception('One or more required request parameters are missing.');
			}
		}

		return true;
	}


	/**
	 * Returns a JSON encoded string that contains the message of the given exception.
	 *
	 * @param Exception $e The exception
	 *
	 * @return string JSON encoded string of the error message
	 */
	protected function create_error(Exception $e) {
		$error = [
			'error' => [
				'message' => $e->getMessage()
			]
		];

		return json_encode($error);
	}
}
?>