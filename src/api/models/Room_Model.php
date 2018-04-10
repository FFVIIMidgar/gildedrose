<?php
/**
 * Room_Model
 *
 * Model for room objects.
 * @author A.J. Rodriguez <avrodriguezjr@gmail.com>
 */

namespace API\Model;

use \API\Model\Base_Model;

class Room_Model extends Base_Model {
	/**
	 * ID.
	 * @var int $id
	 */
	private $id;

	/**
	 * Room number.
	 * @var int $room_number
	 */
	private $room_number;

	/**
	 * Max occupancy.
	 * @var int $max_occupancy
	 */
	private $max_occupancy;

	/**
	 * Max storage.
	 * @var int $max_storage
	 */
	private $max_storage;

	/**
	 * Array of booking objects.
	 * @var \API\Model\Booking_Model[] $bookings
	 */
	private $bookings;

	/**
	 * Constructs a new Room_Model.
	 *
	 * @param int                        $id            ID
	 * @param int                        $room_number   Room number
	 * @param int                        $max_occupancy Max occupancy
	 * @param int                        $max_storage   Max storage
	 * @param \API\Model\Booking_Model[] $bookings      Array of booking objects
	 */
	public function __construct($id, $room_number, $max_occupancy, $max_storage, $bookings) {
		parent::__construct();

		$this->id = $id;
		$this->room_number = $room_number;
		$this->max_occupancy = $max_occupancy;
		$this->max_storage = $max_storage;
		$this->bookings = $bookings;
	}

	/**
	 * Sets the ID.
	 *
	 * @param int $id ID
	 */
	public function set_id($id) {
		$this->id = $id;
	}

	/**
	 * Returns the ID.
	 *
	 * @return int ID
	 */
	public function get_id() {
		 return $this->id;
	}

	/**
	 * Sets the room number.
	 *
	 * @param int $room_number Room number
	 */
	public function set_room_number($room_number) {
		$this->room_number = $room_number;
	}

	/**
	 * Returns the room number.
	 * 
	 * @return int Room number
	 */
	public function get_room_number() {
		return $this->room_number;
	}

	/**
	 * Sets the max occupancy.
	 *
	 * @param int $max_occupancy Max occupancy
	 */
	public function set_max_occupancy($max_occupancy) {
		$this->max_occupancy = $max_occupancy;
	}

	/**
	 * Returns the max occupancy.
	 *
	 * @return int Max occupancy.
	 */
	public function get_max_occupancy() {
		return $this->max_occupancy;
	}

	/**
	 * Sets the max storage.
	 *
	 * @param int $max_storage Max storage
	 */
	public function set_max_storage($max_storage) {
		$this->max_storage = $max_storage;
	}

	/**
	 * Returns the max storage.
	 *
	 * @return int Max storage
	 */
	public function get_max_storage() {
		return $this->max_storage;
	}

	/**
	 * Sets the array of booking objects.
	 *
	 * @param \API\Model\Booking_Model[] $bookings Array of booking objects
	 */
	public function set_bookings($bookings) {
		$this->bookings = $bookings;
	}

	/**
	 * Returns the array of booking objects.
	 *
	 * @return \API\Model\Booking_Model[] Array of booking objects
	 */
	public function get_bookings() {
		return $this->bookings;
	}

	/**
	 * Adds a booking object to the array of booking objects.
	 *
	 * @param \API\Model\Booking_Model $booking Booking object
	 */
	public function add_booking($booking) {
		$this->bookings[] = $booking;
	}

	/**
	 * Returns the guest occupancy on a given date.
	 *
	 * @param DateTime $date Given date
	 *
	 * @return int Guest occupancy
	 */
	public function get_guest_occupancy_by_date($date) {
		$occupancy = 0;

		foreach ($this->bookings as $booking) {
			if ($booking->get_check_in_date()->format('Y-m-d') === $date->format('Y-m-d')) {
				$occupancy++;
			}
		}

		return $occupancy;
	}

	/**
	 * Returns the remaining guest occupancy on a given date.
	 *
	 * @param DateTime $date Given date
	 *
	 * @return int Remaining guest occupancy
	 */
	public function get_remaining_guest_occupancy_by_date($date) {
		return $this->max_occupancy - $this->get_guest_occupancy_by_date($date);
	}

	/**
	 * Returns the storage occupancy on a given date.
	 *
	 * @param DateTime $date Given date
	 *
	 * @return int Storage occupancy
	 */
	public function get_storage_occupancy_by_date($date) {
		$occupancy = 0;

		foreach ($this->bookings as $booking) {
			if ($booking->get_check_in_date()->format('Y-m-d') === $date->format('Y-m-d')) {
				$occupancy += $booking->get_item_count();
			}
		}

		return $occupancy;
	}

	/**
	 * Returns the remaining storage occupancy on a given date.
	 *
	 * @param DateTimee $date Given date
	 *
	 * @return int Remaining storage occupancy
	 */
	public function get_remaining_storage_occupancy_by_date($date) {
		return $this->max_storage - $this->get_storage_occupancy_by_date($date);
	}
}
?>