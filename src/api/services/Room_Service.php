<?php
/**
 * Service for all Room related operations.
 *
 * @author A.J. Rodriguez <avrodriguezjr@gmail.com>
 */

namespace API\Service;

use \API\DAO\Booking_DAO;
use \API\Model\Booking_Model;
use \API\Model\Guest_Model;
use \API\Model\Room_Model;
use \API\Service\Base_Service;
use \DateTime;

class Room_Service extends Base_Service {
	/**
	 * Constructs a new Room_Service.
	 * 
	 * @param \API\DAO\Room_DAO $dao Associated DAO
	 */
	public function __construct($dao) {
		parent::__construct($dao);
	}

	/**
	 * Returns an array of available rooms available for the given date and item count.
	 *
	 * @param DateTime $date       Given date
	 * @param int      $item_count Item count
	 */
	public function get_room_availability($date, $item_count) {
		// Initialize other DAOs needed.
		$booking_dao = new Booking_DAO();

		$rooms = [];
		$available_rooms = [];

		// Get information for all rooms.
		$results = $this->dao->get_all_rooms();

		foreach ($results as $row) {
			$rooms[$row['ID']] = new Room_Model(
				intval($row['ID']), 
				intval($row['RoomNumber']), 
				intval($row['MaxOccupancy']), 
				intval($row['MaxStorage']),
				[]
			);
		}

		// Get all bookings for the given date.
		$results = $booking_dao->get_bookings_by_check_in_date($date);

		foreach ($results as $row) {
			$guest = new Guest_Model(intval($row['GuestID']), $row['FirstName'], $row['LastName'], $row['Email']);

			$booking = new Booking_Model(
				intval($row['BookingID']), 
				intval($row['GuestID']), 
				intval($row['RoomID']), 
				DateTime::createFromFormat('Y-m-d', $row['CheckInDate']), 
				DateTime::createFromFormat('Y-m-d', $row['CheckOutDate']),
				intval($row['ItemCount']), 
				$guest, 
				null
			);

			$rooms[$booking->get_room_id()]->add_booking($booking);
		}

		// Determine and return which rooms are available.
		foreach ($rooms as $room) {
			if (($room->get_guest_occupancy_by_date($date) < $room->get_max_occupancy()) && 
				($room->get_remaining_storage_occupancy_by_date($date) >= $item_count)) {
				$available_rooms[] = $room;
			}
		}

		return $available_rooms;
	}

	/** 
	 * Returns the available rooms for the given date item count in JSON format.
	 *
	 * @param DateTime                $date            Given date
	 * @param int                     $item_count      Item count
	 * @param \API\Model\Room_Model[] $available_rooms Array of available rooms
	 *
	 * @return string JSON encoded string
	 */
	public function json_encode_available_rooms($date, $item_count, $available_rooms) {
		$json_data = [
			'availableRooms' => [
				'date'          => $date->format('Y-m-d'),
				'numberOfItems' => $item_count,
				'rooms'         => []
			]
		];

		foreach ($available_rooms as $room) {
			$room_data = [
				'roomNumber'                => $room->get_room_number(),
				'guestOccupancy'            => $room->get_guest_occupancy_by_date($date),
				'remainingGuestOccupancy'   => $room->get_max_occupancy() - $room->get_guest_occupancy_by_date($date),
				'maxGuestOccupancy'         => $room->get_max_occupancy(),
				'storageOccupancy'          => $room->get_storage_occupancy_by_date($date),
				'remainingStorageOccupancy' => $room->get_remaining_storage_occupancy_by_date($date),
				'maxStorageOccupancy'       => $room->get_max_storage()
			];

			$json_data['availableRooms']['rooms'][] = $room_data;
		}

		return json_encode($json_data);
	}
}
?>