<?php
namespace API\Model;

use \API\Model\Base_Model;

class Room_Model extends Base_Model {
	private $id;
	private $room_number;
	private $max_occupancy;
	private $max_storage;
	private $bookings;

	public function __construct($id, $room_number, $max_occupancy, $max_storage, $bookings) {
		parent::__construct();

		$this->id = $id;
		$this->room_number = $room_number;
		$this->max_occupancy = $max_occupancy;
		$this->max_storage = $max_storage;
		$this->bookings = $bookings;
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

	public function get_bookings() {
		return $this->bookings;
	}

	public function add_booking($booking) {
		$this->bookings[] = $booking;
	}

	public function get_guest_occupancy_by_date($date) {
		$occupancy = 0;

		foreach ($this->bookings as $booking) {
			if ($booking->get_check_in_date() === $date) {
				$occupancy++;
			}
		}

		return $occupancy;
	}

	public function get_remaining_guest_occupancy_by_date($date) {
		return $this->max_occupancy - $this->get_guest_occupancy_by_date($date);
	}

	public function get_storage_occupancy_by_date($date) {
		$occupancy = 0;

		foreach ($this->bookings as $booking) {
			if ($booking->get_check_in_date() === $date) {
				$occupancy += $booking->get_item_count();
			}
		}

		return $occupancy;
	}

	public function get_remaining_storage_occupancy_by_date($date) {
		return $this->max_storage - $this->get_storage_occupancy_by_date($date);
	}
}
?>