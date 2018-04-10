<?php
/**
 * Booking_Model
 *
 * Model for booking objects. 
 *
 * @author A.J. Rodriguez <avrodriguezjr@gmail.com>
 */ 

namespace API\Model;

use \API\Model\Base_Model;

class Booking_Model extends Base_Model {
	/**
	 * ID.
	 * @var int $id
	 */
	private $id;

	/**
	 * Guest ID.
	 * @var int $guest_id
	 */
	private $guest_id;

	/**
	 * Room ID.
	 * @var int $room_id
	 */
	private $room_id;

	/**
	 * Check in date.
	 * @var DateTime $check_in_date
	 */
	private $check_in_date;

	/**
	 * Check out date.
	 * @var DateTime $check_out_date
	 */
	private $check_out_date;

	/**
	 * Item count.
	 * @var int $item_count
	 */
	private $item_count;

	/**
	 * Guest object.
	 * @var \API\Model\Guest_Model $guest
	 */
	private $guest;

	/**
	 * Room object.
	 * @var \API\Model\Room_Model $room
	 */
	private $room;

	/**
	 * Constructs a new Booking_Model.
	 *
	 * @param int                    $id             ID
	 * @param int                    $guest_id       Guest ID
	 * @param int                    $room_id        Room ID
	 * @param DateTime               $check_in_date  Check in date
	 * @param DateTime               $check_out_date Check out date
	 * @param int                    $item_count     Item count
	 * @param \API\Model\Guest_Model $guest          Guest object
	 * @param \API\Model|Room_Model  $room           Room object
	 */
	public function __construct($id, $guest_id, $room_id, $check_in_date, $check_out_date, $item_count, $guest, $room) {
		parent::__construct();

		$this->id = $id;
		$this->guest_id = $guest_id;
		$this->room_id = $room_id;
		$this->check_in_date = $check_in_date;
		$this->check_out_date = $check_out_date;
		$this->item_count = $item_count;
		$this->guest = $guest;
		$this->room = $room;
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
	 * Sets the guest ID.
	 *
	 * @param int $guest_id Guest ID
	 */
	public function set_guest_id($guest_id) {
		$this->guest_id = $guest_id;
	}

	/**
	 * Returns the guest ID.
	 *
	 * @return int Guest ID
	 */
	public function get_guest_id() {
		return $this->guest_id;
	}

	/**
	 * Sets the room ID.
	 *
	 * @param int $room_id Room ID
	 */
	public function set_room_id($room_id) {
		$this->room_id = $room_id;
	}

	/**
	 * Returns the room ID.
	 *
	 * @return int Room ID
	 */
	public function get_room_id() {
		return $this->room_id;
	}

	/**
	 * Sets the check in date.
	 *
	 * @param DateTime $check_in_date Check in date
	 */
	public function set_check_in_date($check_in_date) {
		$this->check_in_date = $check_in_date;
	}


	/**
	 * Returns the check in date.
	 *
	 * @return DateTime Check in date
	 */
	public function get_check_in_date() {
		return $this->check_in_date;
	}

	/** 
	 * Sets the check out date.
	 * 
	 * @param DateTime $check_out_date Check out date
	 */
	public function set_check_out_date($check_out_date) {
		$this->check_out_date = $check_out_date;
	}

	/**
	 * Returns the check out date.
	 *
	 * @return DateTime Check out date
	 */
	public function get_check_out_date() {
		return $this->check_out_date;
	}

	/**
	 * Sets the item count.
	 *
	 * @param int $item_count Item count
	 */
	public function set_item_count($item_count) {
		$this->item_count = $item_count;
	}

	/**
	 * Returns the item count.
	 *
	 * @return int Item count
	 */
	public function get_item_count() {
		return $this->item_count;
	}

	/**
	 * Sets the guest object.
	 *
	 * @param \API\Model\Guest_Model $guest Guest object
	 */
	public function set_guest($guest) {
		$this->guest = $guest;
	}

	/**
	 * Returns the guest object.
	 *
	 * @return \API\Model\Guest_Model Guest object
	 */
	public function get_guest() {
		return $this->guest;
	}

	/**
	 * Sets the room object.
	 *
	 * @param \API\Model\Room_Model $room Room object
	 */
	public function set_room($room) {
		$this->room = $room;
	}

	/**
	 * Returns the room object.
	 *
	 * @return \API\Model\Room_Model Room object
	 */
	public function get_room() {
		return $this->room;
	}
}
?>