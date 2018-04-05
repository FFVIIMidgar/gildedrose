<?php
namespace API\Model;

use \API\Model\Base_Model;

class Guest_Model extends Base_Model {
	private $id;
	private $first_name;
	private $last_name;
	private $email;

	public function __construct($id, $first_name, $last_name, $email) {
		parent::__construct();

		$this->id = $id;
		$this->first_name = $first_name;
		$this->last_name = $last_name;
		$this->email = $email;
	}

	public function get_id() {
		return $this->id;
	}

	public function get_first_name() {
		return $this->first_name;
	}

	public function get_last_name() {
		return $this->last_name;
	}

	public function get_email() {
		return $this->email;
	}
}
?>