<?php
/**
 * Service for all Gnome Squad related operations.
 *
 * @author A.J. Rodriguez <avrodriguezjr@gmail.com>
 */

namespace API\Service;

use \API\Model\Gnome_Squad_Model;
use \API\Model\Room_Model;
use \API\Service\Base_Service;
use \DateInterval;
use \DateTime;

class Gnome_Squad_Service extends Base_Service {
	/**
	 * Constructs a new Gnome_Squad_Service.
	 * 
	 * @param \API\DAO\Gnome_Squad_DAO $dao Associated DAO
	 */
	public function __construct($dao) {
		parent::__construct($dao);
	}

	/**
	 * Adds the given room to be cleaned and date to the Gnome Squad schedule.
	 *
	 * @param \API\Model\Room_Model $room Room to be cleaned
	 * @param DateTime              $date Given date
	 */
	public function add_to_gnome_squad_schedule($room, $date) {
		if (!$this->exists_in_schedule($room, $date)) {
			// Get the latest room cleaning to determine when to clean this room.
			$results = $this->dao->get_latest_cleaning_by_date($date);

			// If there are no other cleanings, start as the first cleaning of the day. Otherwise start after the latest cleaning.
			if (empty($results)) {
				$start_time = DateTime::createFromFormat('H:i:s', '10:00:00');
			} else {
				$latest_cleaning = new Gnome_Squad_Model(
					intval($results['ID']), 
					intval($results['RoomID']),
					DateTime::createFromFormat('Y-m-d', $results['Date']),
					DateTime::createFromFormat('H:i:s', $results['StartTime']), 
					DateTime::createFromFormat('H:i:s', $results['EndTime']),
					null
				);

				$start_time = $latest_cleaning->get_end_time();
			}

			// Get the interval string for the cleaning duration and get the end time.
			$interval = $room->get_max_occupancy() == 2 ? 'PT2H' : 'PT1H30M';
			$end_time = DateTime::createFromFormat('H:i:s', $start_time->format('H:i:s'))->add(new DateInterval($interval));

			// Add the new room cleaning to the Gnome Squad scnedule.
			$cleaning = new Gnome_Squad_Model(null, $room->get_id(), $date, $start_time, $end_time, $room);
			$this->dao->create_new_cleaning($cleaning);
		}
	}

	/**
	 * Returns all cleanings on the given date.
	 *
	 * @param DateTime $date Given date
	 *
	 * @return \API\Model\Gnome_Squad_Model[] cleanings on the given date
	 */
	public function get_cleanings_by_date($date) {
		$results = $this->dao->get_cleanings_by_date($date);
		$cleanings = [];

		foreach ($results as $row) {
			$cleanings[] = new Gnome_Squad_Model(
				intval($row['GnomeSquadID']), 
				intval($row['RoomID']), 
				DateTime::createFromFormat('Y-m-d', $row['Date']),
				DateTime::createFromFormat('H:i:s', $row['StartTime']),
				DateTime::createFromFormat('H:i:s', $row['EndTime']), 
				new Room_Model(intval($row['RoomID']), intval($row['RoomNumber']), 0, 0, [])
			);
		}

		return $cleanings;
	}

	/** 
	 * Returns the gnome squad schedule for the given date and cleanings in JSON format.
	 *
	 * @param DateTime                     $date      Given date
	 * @param \API\Model\Gnome_Squad_Model $cleanings Cleanings
	 *
	 * @return string JSON encoded string
	 */
	public function json_encode_gnome_squad_schedule($date, $cleanings) {
		$json_data = [
			'gnomeSquadSchedule' => [
				'date' => $date->format('Y-m-d'),
				'cleanings' => []
			]
		];

		foreach ($cleanings as $cleaning) {
			$json_data['gnomeSquadSchedule']['cleanings'][] = [
				'roomNumber' => $cleaning->get_room()->get_room_number(),
				'startTime' => $cleaning->get_start_time()->format('H:i:s'),
				'endTime' => $cleaning->get_end_time()->format('H:i:s')
			];
		}

		return json_encode($json_data);
	}

	/**
	 * Returns true if the given room and date exists in the Gnome Squad schedule, false otherwise.
	 *
	 * @param \API\Model\Room $room Room
	 * @param DateTime        $date Given date
	 */
	private function exists_in_schedule($room, $date) {
		return !empty($this->dao->get_cleaning_id_by_room_id_and_date($room, $date));
	}
}
?>