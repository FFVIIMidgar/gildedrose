<?php
namespace API\DAO;

use \API\DAO\Base_DAO;
use \API\Database\Database;

class Gnome_Squad_DAO extends Base_DAO {
	public function get_cleaning_id_by_room_id_and_date($room, $date) {
		$sql = 'SELECT ID FROM tblGnomeSquad WHERE RoomID = :room_id AND Date = :date;';

		$database = new Database();
		$connection = $database->connect();
    	$statement = $connection->prepare($sql);

    	$statement->bindParam(':room_id', $room->get_id(), \PDO::PARAM_INT);
    	$statement->bindParam(':date', $date, \PDO::PARAM_STR);

    	$statement->execute();

    	return $statement->fetch(\PDO::FETCH_ASSOC);
	}

	public function get_latest_cleaning_by_date($date) {
		$sql = 'SELECT ID, RoomID, Date, StartTime, EndTime FROM tblGnomeSquad 
			WHERE date = :date
			ORDER BY EndTime DESC LIMIT 1;';

		$database = new Database();
		$connection = $database->connect();
    	$statement = $connection->prepare($sql);

    	$statement->bindParam(':date', $date, \PDO::PARAM_STR);

    	$statement->execute();

    	return $statement->fetch(\PDO::FETCH_ASSOC);
	}

	public function create_new_cleaning($cleaning) {
		$sql = 'INSERT INTO tblGnomeSquad (RoomID, Date, StartTime, EndTime)
			VALUES (:room_id, :date, :start_time, :end_time)';

		$database = new Database();
		$connection = $database->connect();
    	$statement = $connection->prepare($sql);

    	$statement->bindParam(':room_id', $cleaning->get_room_id());
    	$statement->bindParam(':date', $cleaning->get_date());
    	$statement->bindParam(':start_time', $cleaning->get_start_time());
    	$statement->bindParam(':end_time', $cleaning->get_end_time());

    	$statement->execute();
	}
}
?>