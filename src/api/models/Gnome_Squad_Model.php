<?php
namespace API\Model;

use \API\Model\Base_Model;

class Gnome_Squad_Model extends Base_Model {
	private $id;
	private $room_id;
	private $date;
	private $start_time;
	private $end_time;

	public function __construct($id, $room_id, $date, $start_time, $end_time) {
		parent::__construct();
		$this->id = $id;
		$this->room_id = $room_id;
		$this->date = $date;
		$this->start_time = $start_time;
		$this->end_time = $end_time;
	}

	public function get_id() {
		return $this->id;
	}

	public function get_room_id() {
		return $this->room_id;
	}

	public function get_date() {
		return $this->date;
	}

	public function get_start_time() {
		return $this->start_time;
	}

	public function get_end_time() {
		return $this->end_time;
	}
}
?>