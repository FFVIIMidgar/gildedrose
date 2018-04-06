<?php
namespace API\Service;

use \API\Model\Gnome_Squad_Model;
use \API\Service\Base_Service;

class Gnome_Squad_Service extends Base_Service {
	public function __construct($dao) {
		parent::__construct($dao);
	}

	public function add_to_gnome_schedule($room, $date) {
		$next_day = \DateTime::createFromFormat('Y-m-d', $date)->add(new \DateInterval('P1D'))->format('Y-m-d');

		if (!$this->exists_in_schedule($room, $next_day)) {
			$results = $this->dao->get_latest_cleaning_by_date($next_day);

			if (empty($results)) {
				$start_time = '10:00:00';
			} else {
				$cleaning = new Gnome_Squad_Model($results['ID'], $results['RoomID'], $results['Date'], $results['StartTime'], $results['EndTime']);
				$start_time = $cleaning->get_end_time();
			}

			$interval = $room->get_max_occupancy() == 2 ? 'PT2H' : 'PT1H30M';
			$end_time = \DateTime::createFromFormat('H:i:s', $start_time)->add(new \DateInterval($interval))->format('H:i:s');

			$cleaning = new Gnome_Squad_Model(null, $room->get_id(), $next_day, $start_time, $end_time);
			$this->dao->create_new_cleaning($cleaning);
		}
	}

	private function exists_in_schedule($room, $date) {
		return !empty($this->dao->get_cleaning_id_by_room_id_and_date($room, $date));
	}
}
?>