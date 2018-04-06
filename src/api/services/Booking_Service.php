<?php
namespace API\Service;

use \API\DAO\Gnome_Squad_DAO;
use \API\DAO\Guest_DAO;
use \API\Model\Booking_Model;
use \API\Service\Base_Service;
use \API\Service\Gnome_Squad_Service;

class Booking_Service extends Base_Service {
	public function __construct($dao) {
		parent::__construct($dao);
	}

	public function book_room($guest, $date, $item_count, $available_rooms) {
		if ($date < date('Y-m-d')) {
			return 'A room cannot be booked before today.';
		}

		if (empty($available_rooms)) {
			return 'There are no available rooms with the given criteria.';
		}

		$guest_dao = new Guest_DAO();

		$guest_id = $guest_dao->get_guest_id_by_email($guest->get_email())['ID'];
		$guest->set_id($guest_id);

		if ($this->guest_already_booked($guest, $date)) {
			return 'Guest already booked for another room on ' . $date . '.';
		}

		$room = $this->get_best_room($guest, $date, $item_count, $available_rooms);
		$this->dao->create_booking($guest, $date, $item_count, $room);

		$gnome_squad_service = new Gnome_Squad_Service(new Gnome_Squad_DAO());
		$gnome_squad_service->add_to_gnome_schedule($room, $date);

		$booking_id = $this->dao->get_booking_id_by_guest_and_date($guest, $date)['ID'];
		$next_day = \DateTime::createFromFormat('Y-m-d', $date)->add(new \DateInterval('P1D'))->format('Y-m-d');

		$booking = new Booking_Model($booking_id, $guest->get_id(), $room->get_id(), $date, $next_day, $item_count, $guest, $room);

		return $booking;
	}

	public function json_encode_booking_results($booking_results) {
		$json_data = [
			'bookingResults' => []
		];

		if ($booking_results instanceof Booking_Model) {
			$json_data['bookingResults'] = [
				'status'           => 'success',
				'bookingDetails'   => [
					'firstName'    => $booking_results->get_guest()->get_first_name(),
					'lastName'     => $booking_results->get_guest()->get_last_name(),
					'email'        => $booking_results->get_guest()->get_email(),
					'roomNumber'   => $booking_results->get_room()->get_room_number(),
					'checkInDate'  => $booking_results->get_check_in_date(),
					'checkOutDate' => $booking_results->get_check_out_date(),
					'itemCount'    => $booking_results->get_item_count()
				]
			];
		} else {
			$json_data['bookingResults'] = [
				'status' => 'failed',
				'reason' => $booking_results
			];
		}

		return json_encode($json_data);
	}

	private function guest_already_booked($guest, $date) {
		return !empty($this->dao->get_booking_id_by_guest_and_date($guest, $date));
	}

	private function get_best_room($guest, $date, $item_count, $available_rooms) {
		$best_room = null;
		$current_priority = 0;

		foreach ($available_rooms as $room) {
			$room_priority = $this->get_room_priority($date, $item_count, $room);
			
			if ($best_room === null || $room_priority > $current_priority) {
				$best_room = $room;
				$current_priority = $room_priority;
			}
		}

		return $best_room;
	}

	private function get_room_priority($date, $item_count, $room) {
		$priority = 0;

		if ($room->get_remaining_guest_occupancy_by_date($date) == 1) {
			if ($item_count === $room->get_remaining_storage_occupancy_by_date($date)) {
				$priority = 4;
			} else {
				$priority = 3;
			}
		} else {
			if ($item_count === $room->get_remaining_storage_occupancy_by_date($date)) {
				$priority = 2;
			} else {
				$priority = 1;
			}
		}

		return $priority;
	}
}
?>