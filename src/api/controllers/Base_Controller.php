<?php
namespace API\Controller;

use \API\Service\Base_Service;

class Base_Controller {
	protected $service;

	public function __construct(Base_Service $service) {
		$this->service = $service;
	}
}
?>