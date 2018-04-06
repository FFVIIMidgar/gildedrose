<?php
namespace API\Service;

use \API\DAO\Booking_DAO;
use \API\Model\Booking_Model;
use \API\Model\Room_Model;
use \API\Service\Base_Service;

class Room_Service extends Base_Service {
	public function __construct($dao) {
		parent::__construct($dao);
	}

	public function get_room_availability($date, $item_count) {
		$booking_dao = new Booking_DAO();
		$rooms = [];
		$available_rooms = [];

		$results = $this->dao->get_all_rooms();

		foreach ($results as $row) {
			$rooms[$row['ID']] = new Room_Model($row['ID'], $row['RoomNumber'], $row['MaxOccupancy'], $row['MaxStorage'], []);
		}

		$results = $booking_dao->get_bookings_by_check_in_date($date);

		foreach ($results as $row) {
			$check_in_date = new \DateTime($row['CheckInDate']);
			$check_in_date = $check_in_date->format('Y-m-d');
			$check_out_date = new \DateTime($row['CheckOutDate']);
			$check_out_date = $check_out_date->format('Y-m-d');

			$booking = new Booking_Model($row['ID'], $row['GuestID'], $row['RoomID'], $check_in_date, $check_out_date, $row['ItemCount']);
			$rooms[$booking->get_room_id()]->add_booking($booking);
		}

		foreach ($rooms as $room) {
			$room_storage_remaining = $room->get_max_storage() - $room->get_storage_occupancy_by_date($date);

			if (($room->get_guest_occupancy_by_date($date) < $room->get_max_occupancy()) && ($room_storage_remaining >= $item_count)) {
				$available_rooms[] = $room;
			}
		}

		return $available_rooms;
	}

	public function json_encode_available_rooms($date, $item_count, $available_rooms) {
		$json_data = [
			'availableRooms' => [
				'date'          => $date,
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
				'remainingStorageOccupancy' => $room->get_max_storage() - $room->get_storage_occupancy_by_date($date),
				'maxStorageOccupancy'       => $room->get_max_storage()
			];

			$json_data['availableRooms']['rooms'][] = $room_data;
		}

		return json_encode($json_data);
	}
}
?>