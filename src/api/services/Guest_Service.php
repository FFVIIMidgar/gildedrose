<?php
/**
 * Service for all Guest related operations.
 *
 * @author A.J. Rodriguez <avrodriguezjr@gmail.com>
 */

namespace API\Service;

use \API\Service\Base_Service;

class Guest_Service extends Base_Service {
	/**
	 * Constructs a new Guest_Service.
	 * 
	 * @param \API\DAO\Guest_DAO $dao Associated DAO
	 */
	public function __construct($dao) {
		parent::__construct($dao);
	}

	/**
	 * Adds a new guest if it does not exist.
	 *
	 * @param \API\Model\Guest_Model $guest Guest
	 */
	public function create_guest_if_not_exist($guest) {
		if (empty($this->dao->get_guest_id_by_email($guest->get_email()))) {
			$this->dao->create_guest($guest);
		}
	}
}
?>