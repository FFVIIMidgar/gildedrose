<?php
/**
 * DAO for all booking related database communication.
 *
 * @author A.J. Rodriguez <avrodriguezjr@gmail.com>
 */

namespace API\DAO;

use \API\DAO\Base_DAO;
use \API\Database\Database;
use \DateInterval;
use \DateTime;
use \PDO;

class Booking_DAO extends Base_DAO {
	/**
	 * Creates a new Booking_DAO.
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Returns all bookings by check in date.
	 *
	 * @param DateTime $date Given date
	 *
	 * @return PDOStatement[] Query results
	 */
	public function get_bookings_by_check_in_date($date) {
		$sql = 'SELECT 
				b.ID AS BookingID, 
				b.GuestID AS GuestID, 
				b.RoomID AS RoomID, 
				b.CheckInDate AS CheckInDate,
				b.CheckOutDate AS CheckOutDate,
				b.ItemCount AS ItemCount,
				g.FirstName AS FirstName,
				g.LastName AS LastName,
				g.Email AS Email
			FROM tblBooking b
			INNER JOIN tblGuest g ON b.GuestID = g.ID
			WHERE CheckInDate = :date;';

		// Connect to the database.
		$database = new Database();
		$connection = $database->connect();
    	$statement = $connection->prepare($sql);
    	
    	// Bind parameters.
    	$statement->bindParam(':date', $date->format('Y-m-d'), PDO::PARAM_STR);

    	// Execute query.
    	$statement->execute();

    	return $statement->fetchAll(PDO::FETCH_ASSOC);
	}

	/**
	 * Returns the booking ID given the guest and date.
	 *
	 * @param \API\Model\Guest_Model $guest Guest
	 * @param DateTime               $date  Given date
	 *
	 * @return PDOStatement Query results
	 */
	public function get_booking_id_by_guest_and_date($guest, $date) {
		$sql = 'SELECT ID FROM tblBooking WHERE GuestID = :guest_id AND CheckInDate = :date;';

		// Connect to the database.
		$database = new Database();
		$connection = $database->connect();
    	$statement = $connection->prepare($sql);

    	// Bind parameters.
    	$statement->bindParam(':guest_id', $guest->get_id(), PDO::PARAM_INT);
    	$statement->bindParam(':date', $date->format('Y-m-d'), PDO::PARAM_STR);

    	// Execute query.
    	$statement->execute();

    	return $statement->fetch(PDO::FETCH_ASSOC);
	}

	/**
	 * Creates a new booking given the booking object.
	 *
	 * @param \API\Model\Booking_Model $booking Booking
	 */
	public function create_booking($booking) {
		$sql = 'INSERT INTO tblBooking (GuestID, RoomID, CheckInDate, CheckOutDate, ItemCount) 
			VALUES (:guest_id, :room_id, :check_in_date, :check_out_date, :item_count);';

		// Connect to the database.
		$database = new Database();
		$connection = $database->connect();
    	$statement = $connection->prepare($sql);

    	// Bind parameters.
    	$statement->bindParam(':guest_id', $booking->get_guest()->get_id(), PDO::PARAM_INT);
    	$statement->bindParam(':room_id', $booking->get_room()->get_id(), PDO::PARAM_INT);
    	$statement->bindParam(':check_in_date', $booking->get_check_in_date()->format('Y-m-d'), PDO::PARAM_STR);
    	$statement->bindParam(':check_out_date', $booking->get_check_out_date()->format('Y-m-d'), PDO::PARAM_STR);
    	$statement->bindParam(':item_count', $booking->get_item_count(), PDO::PARAM_INT);

    	// Execute query.
    	$statement->execute();
	}
}
?>