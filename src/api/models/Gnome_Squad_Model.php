<?php
/**
 * Gnome_Squad_Model
 *
 * Model for Gnome Squad (cleaning) objects.
 *
 * @author A.J. Rodriguez <avrodriguezjr@gmail.com>
 */

namespace API\Model;

use \API\Model\Base_Model;

class Gnome_Squad_Model extends Base_Model {
	/**
	 * ID.
	 * @var int $id
	 */
	private $id;

	/**
	 * Room ID.
	 * @var int $room_id
	 */
	private $room_id;

	/**
	 * Date.
	 * @var DateTime $date
	 */
	private $date;

	/**
	 * Start time.
	 * @var DateTime $start_time
	 */
	private $start_time;

	/**
	 * End time.
	 * @var DateTime $end_time
	 */
	private $end_time;

	/**
	 * Room object.
	 * @var \API\Model\Room_Model $room
	 */
	private $room;

	/**
	 * Constructs a new Room_Model.
	 *
	 * @param int                   $id         ID
	 * @param int                   $room_id    Room ID
	 * @param DatTime               $date       Date
	 * @param DateTime              $start_time Start time
	 * @param DateTime              $end_time   End time
	 * @param \API\Model\Room_Model $room       Room object
	 */
	public function __construct($id, $room_id, $date, $start_time, $end_time, $room) {
		parent::__construct();
		$this->id = $id;
		$this->room_id = $room_id;
		$this->date = $date;
		$this->start_time = $start_time;
		$this->end_time = $end_time;
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
	 * Sets the date.
	 *
	 * @param DateTime $date Date
	 */
	public function set_date($date) {
		$this->date = $date;
	}

	/**
	 * Returns the date.
	 *
	 * @return DateTime Date
	 */
	public function get_date() {
		return $this->date;
	}

	/**
	 * Sets the start time.
	 *
	 * @param DateTime $start_time Start time
	 */
	public function set_start_time($start_time) {
		$this->start_time = $start_time;
	}

	/**
	 * Returns the start time.
	 *
	 * @return DateTime Start time
	 */
	public function get_start_time() {
		return $this->start_time;
	}

	/**
	 * Sets the end time.
	 *
	 * @param DateTime $end_time End time
	 */
	public function set_end_time($end_time) {
		$this->end_time = $end_time;
	}

	/**
	 * Returns the end time.
	 *
	 * @return DateTime End time
	 */
	public function get_end_time() {
		return $this->end_time;
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