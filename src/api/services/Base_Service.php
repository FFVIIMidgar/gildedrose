<?php
namespace API\Service;

class Base_Service {
	protected $dao;

	public function __construct($dao) {
		$this->dao = $dao;
	}
}
?>
