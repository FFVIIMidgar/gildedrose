<?php
/**
 * Service for all booking related operations.
 *
 * @author A.J. Rodriguez <avrodriguezjr@gmail.com>
 */

namespace API\Service;

use \API\DAO\Gnome_Squad_DAO;
use \API\DAO\Guest_DAO;
use \API\Model\Booking_Model;
use \API\Service\Base_Service;
use \API\Service\Gnome_Squad_Service;
use \DateInterval;
use \DateTime;

class Booking_Service extends Base_Service {
	/**
	 * Constructs a new Booking_Service.
	 * 
	 * @param \API\DAO\Booking_DAO $dao Associated DAO
	 */
	public function __construct($dao) {
		parent::__construct($dao);
	}

	/**
	 * Books a room given the guest, date, item count, and array of available rooms.
	 * Returns the booking if successful and an error string otherwise.
	 *
	 * @param \API\Model\Guest_Model  $guest           Guest
	 * @param DateTime                $date            Given date
	 * @param int                     $item_count      Item count
	 * @param \API\Model\Room_Model[] $available_rooms Array of available rooms
     *
     * @return \API\Model\Booking_Model|string Booking if successful and an error string otherwise
	 */ 
	public function book_room($guest, $date, $item_count, $available_rooms) {
		$next_day = DateTime::createFromFormat('Y-m-d', $date->format('Y-m-d'))->add(new DateInterval('P1D'));

		// Room cannot be booked before today.
		if ($date->format('Y-m-d') < date('Y-m-d')) {
			return 'A room cannot be booked before today.';
		}

		// There are no available rooms.
		if (empty($available_rooms)) {
			return 'There are no available rooms with the given criteria.';
		}

		// Initialize other DAOs needed.
		$guest_dao = new Guest_DAO();

		// Get and set the guest's ID.
		$guest_id = $guest_dao->get_guest_id_by_email($guest->get_email())['ID'];
		$guest->set_id($guest_id);

		// Guest already booked.
		if ($this->guest_already_booked($guest, $date)) {
			return 'Guest already booked for another room on ' . $date->format('Y-m-d') . '.';
		}

		// Book the best room available.
		$room = $this->get_best_room($date, $item_count, $available_rooms);
		$booking = new Booking_Model(null, $guest->get_id(), $room->get_id(), $date, $next_day, $item_count, $guest, $room);
		$this->dao->create_booking($booking);

		// Initialize other services needed.
		$gnome_squad_service = new Gnome_Squad_Service(new Gnome_Squad_DAO());

		// Add the room's cleaning to the Gnome Squad schedule.
		$gnome_squad_service->add_to_gnome_squad_schedule($room, $next_day);

		// Return the booking.
		$booking_id = intval($this->dao->get_booking_id_by_guest_and_date($guest, $date)['ID']);
		$booking->set_id($booking_id);

		return $booking;
	}

	/** 
	 * Returns the given booking results in JSON format.
	 *
	 * @param mixed $booking_results Booking results. Either a booking object or a string
	 *
	 * @return string JSON encoded string
	 */
	public function json_encode_booking_results($booking_results) {
		$json_data = [
			'bookingResults' => []
		];

		if ($booking_results instanceof Booking_Model) {
			$json_data['bookingResults'] = [
				'status'         => 'success',
				'bookingDetails' => [
					'firstName'     => $booking_results->get_guest()->get_first_name(),
					'lastName'      => $booking_results->get_guest()->get_last_name(),
					'email'         => $booking_results->get_guest()->get_email(),
					'roomNumber'    => $booking_results->get_room()->get_room_number(),
					'checkInDate'   => $booking_results->get_check_in_date()->format('Y-m-d'),
					'checkOutDate'  => $booking_results->get_check_out_date()->format('Y-m-d'),
					'numberOfItems' => $booking_results->get_item_count()
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

	/**
	 * Returns true if the given guest has booked on the given date, false otherwise.
	 *
	 * @param \API\Model\Guest_Model $guest Guest
	 * @param DateTime               $date  Given date
	 *
	 * @return bool True if booked, false otherwise
	 */
	private function guest_already_booked($guest, $date) {
		return !empty($this->dao->get_booking_id_by_guest_and_date($guest, $date));
	}

	/**
	 * Returns the best room to book given the date, item count, and array of available rooms.
	 *
	 * @param DateTime                $date            Given date
	 * @param int $item               $item_count      Item count
	 * @param \API\Model\Room_Model[] $available_rooms Array of available rooms
	 *
	 * @return \API\Model\Room_Model The best room
	 */
	private function get_best_room($date, $item_count, $available_rooms) {
		$best_room = null;
		$current_priority = 0;

		foreach ($available_rooms as $room) {
			$room_priority = $this->get_room_priority($date, $item_count, $room);
			
			if ($best_room === null || $room_priority < $current_priority) {
				$best_room = $room;
				$current_priority = $room_priority;
			}
		}

		return $best_room;
	}

	/**
	 * Returns the room priority given the date, item count, and room.
	 *
	 * The priority is determined as follows:
	 *     P1: No other guests have occupied the room and the remaining storage occupancy is equal to the item count.
	 *     P2: No other guests have occupied the room and the remaining storage occupancy is not equal to the item count.
	 *     P3: Other guests have occupied the room and the remaining storage occupancy is equal to the item count.
	 *     P4: Other guests have occupied the room and the remaining storage occupancy is not equal to the item count.
	 *
	 * @param DateTime              $date       Given date
	 * @param int                   $item_count Item count
	 * @param \API\Model\Room_Model $room       Potential room
	 *
	 * @return int Priority
	 */
	private function get_room_priority($date, $item_count, $room) {
		$priority = 0;

		if ($room->get_guest_occupancy_by_date($date) === 0) {
			if ($item_count === $room->get_remaining_storage_occupancy_by_date($date)) {
				$priority = 1;
			} else {
				$priority = 2;
			}
		} else {
			if ($item_count === $room->get_remaining_storage_occupancy_by_date($date)) {
				$priority = 3;
			} else {
				$priority = 4;
			}
		}

		return $priority;
	}
}
?>