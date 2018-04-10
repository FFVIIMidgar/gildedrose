<?php
/**
 * Base_Service
 *
 * Base class for all services.
 * 
 * @author A.J. Rodriguez <avrodriguezjr@gmail.com>
 */

namespace API\Service;

abstract class Base_Service {
	/**
	 * Associated DAO.
	 * @var \API\DAO\Base_DAO
	 */
	protected $dao;

	/**
	 * Constructs a new Base_Service.
	 * 
	 * @param \API\DAO\Base_DAO $dao Associated DAO
	 */
	public function __construct($dao) {
		$this->dao = $dao;
	}
}
?>
