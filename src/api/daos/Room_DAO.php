<?php
namespace API\DAO;

use \API\DAO\Base_DAO;
use \API\Database\Database;

class Room_DAO extends Base_DAO {
	public function get_all_rooms() {
		$sql = 'SELECT ID, RoomNumber, MaxOccupancy, MaxStorage FROM tblRoom;';

		$database = new Database();
		$connection = $database->connect();
    	$statement = $connection->prepare($sql);
    	
    	$statement->execute();

    	return $statement->fetchAll(\PDO::FETCH_ASSOC);
	}
}
?>