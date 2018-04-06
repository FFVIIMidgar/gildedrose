<?php
namespace API\Controller;

class Base_Controller {
	protected $service;

	public function __construct($service) {
		$this->service = $service;
	}

	protected function check_request_body($body) {
		if (empty($body)) {
			throw new \Exception('Request body is invalid.');
		}

		return true;
	}

	protected function check_request_parameters($parameters) {
		foreach ($parameters as $parameter) {
			if ($parameter === null) {
				throw new \Exception('One or more required request parameters are missing.');
			}
		}

		return true;
	}


	protected function create_error(\Exception $e) {
		$error = [
			'error' => [
				'message' => $e->getMessage()
			]
		];

		return json_encode($error);
	}
}
?>