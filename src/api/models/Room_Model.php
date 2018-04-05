<?php
namespace API\Model;

use \API\Model\Base_Model;

class Room_Model extends Base_Model {
	private $id;
	private $room_number;
	private $max_occupancy;
	private $max_storage;

	public function __construct($id, $room_number, $max_occupancy, $max_storage, $bookings) {
		parent::__construct();

		$this->id = $id;
		$this->room_number = $room_number;
		$this->max_occupancy = $max_occupancy;
		$this->max_storage = $max_storage;
	}

	public function get_id() {
		 return $this->id;
	}

	public function get_room_number() {
		return $this->room_number;
	}

	public function get_max_occupancy() {
		return $this->max_occupancy;
	}

	public function get_max_storage() {
		return $this->max_storage;
	}
}
?>