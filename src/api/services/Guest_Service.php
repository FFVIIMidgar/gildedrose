<?php
namespace API\Service;

use \API\Service\Base_Service;

class Guest_Service extends Base_Service {
	public function __construct($dao) {
		parent::__construct($dao);
	}

	public function create_guest_if_not_exist($guest) {
		if (empty($this->dao->get_guest_id_by_email($guest->get_email()))) {
			$this->dao->create_guest($guest);
		}
	}
}
?>