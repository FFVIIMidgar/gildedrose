<?php
namespace API\DAO;

use \API\DAO\Base_DAO;
use \API\Database\Database;

class Booking_DAO extends Base_DAO {
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

		$database = new Database();
		$connection = $database->connect();
    	$statement = $connection->prepare($sql);
    	
    	$statement->bindParam(':date', $date, \PDO::PARAM_STR);

    	$statement->execute();

    	return $statement->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function get_booking_id_by_guest_and_date($guest, $date) {
		$sql = 'SELECT ID FROM tblBooking WHERE GuestID = :guest_id AND CheckInDate = :date;';

		$database = new Database();
		$connection = $database->connect();
    	$statement = $connection->prepare($sql);

    	$statement->bindParam(':guest_id', $guest->get_id(), \PDO::PARAM_INT);
    	$statement->bindParam(':date', $date, \PDO::PARAM_STR);

    	$statement->execute();

    	return $statement->fetch(\PDO::FETCH_ASSOC);
	}

	public function create_booking($guest, $date, $item_count, $room) {
		$next_day = \DateTime::createFromFormat('Y-m-d', $date)->add(new \DateInterval('P1D'))->format('Y-m-d');

		$sql = 'INSERT INTO tblBooking (GuestID, RoomID, CheckInDate, CheckOutDate, ItemCount) 
			VALUES (:guest_id, :room_id, :check_in_date, :check_out_date, :item_count);';

		$database = new Database();
		$connection = $database->connect();
    	$statement = $connection->prepare($sql);

    	$statement->bindParam(':guest_id', $guest->get_id(), \PDO::PARAM_INT);
    	$statement->bindParam(':room_id', $room->get_id(), \PDO::PARAM_INT);
    	$statement->bindParam(':check_in_date', $date, \PDO::PARAM_STR);
    	$statement->bindParam(':check_out_date', $next_day, \PDO::PARAM_STR);
    	$statement->bindParam(':item_count', $item_count, \PDO::PARAM_INT);

    	$statement->execute();
	}
}
?>