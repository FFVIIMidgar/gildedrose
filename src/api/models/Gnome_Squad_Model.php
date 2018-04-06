<?php
namespace API\Model;

use \API\Model\Base_Model;

class Gnome_Squad_Model extends Base_Model {
	private $id;
	private $room_id;
	private $date;
	private $duration;

	public function __construct($id, $room_id, $date, $duration) {
		parent::__construct();
		$this->id = $id;
		$this->room_id = $room_id;
		$this->date = $date;
		$this->duration = $duration;
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

	public function get_duration() {
		return $this->duration;
	}
}
?>