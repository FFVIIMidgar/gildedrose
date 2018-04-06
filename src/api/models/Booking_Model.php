<?php
namespace API\Model;

use \API\Model\Base_Model;

class Booking_Model extends Base_Model {
	private $id;
	private $guest_id;
	private $room_id;
	private $check_in_date;
	private $check_out_date;
	private $item_count;

	public function __construct($id, $guest_id, $room_id, $check_in_date, $check_out_date, $item_count) {
		parent::__construct();

		$this->id = $id;
		$this->guest_id = $guest_id;
		$this->room_id = $room_id;
		$this->check_in_date = $check_in_date;
		$this->check_out_date = $check_out_date;
		$this->item_count = $item_count;
	}

	public function get_id() {
		return $this->id;
	}

	public function get_guest_id() {
		return $this->guest_id;
	}

	public function get_room_id() {
		return $this->room_id;
	}

	public function get_check_in_date() {
		return $this->check_in_date;
	}

	public function get_check_out_date() {
		return $this->check_out_date;
	}

	public function get_item_count() {
		return $this->item_count;
	}
}
?>