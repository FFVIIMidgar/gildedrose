<?php
namespace API\Service;

class Base_Service {
	private $daos;

	public function __construct($daos) {
		$this->daos = $daos;
	}
}
?>
