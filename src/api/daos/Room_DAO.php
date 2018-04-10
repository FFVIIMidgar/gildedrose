<?php
/**
 * DAO for all room related database communication.
 *
 * @author A.J. Rodriguez <avrodriguezjr@gmail.com>
 */

namespace API\DAO;

use \API\DAO\Base_DAO;
use \API\Database\Database;
use \PDO;

class Room_DAO extends Base_DAO {
	/**
	 * Constructs a new Guest_DAO.
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Returns all of the rooms.
	 *
	 * @return PDOStatement Query results
	 */
	public function get_all_rooms() {
		$sql = 'SELECT ID, RoomNumber, MaxOccupancy, MaxStorage FROM tblRoom;';

		// Connect to the database.
		$database = new Database();
		$connection = $database->connect();
    	$statement = $connection->prepare($sql);
    	
    	// Execute query.
    	$statement->execute();

    	return $statement->fetchAll(PDO::FETCH_ASSOC);
	}
}
?>