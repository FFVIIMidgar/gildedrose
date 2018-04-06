<?php
namespace API\DAO;

use \API\DAO\Base_DAO;
use \API\Database\Database;

class Booking_DAO extends Base_DAO {
	public function get_bookings_by_check_in_date($date) {
		$sql = 'SELECT ID, GuestID, RoomID, CheckInDate, CheckOutDate, ItemCount FROM tblBooking
			WHERE CheckInDate = :date;';

		$database = new Database();
		$connection = $database->connect();
    	$statement = $connection->prepare($sql);
    	
    	$statement->bindParam(':date', $date, \PDO::PARAM_STR);

    	$statement->execute();

    	return $statement->fetchAll(\PDO::FETCH_ASSOC);
	}
}
?>