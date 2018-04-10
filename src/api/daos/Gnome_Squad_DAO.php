<?php
/**
 * DAO for all Gnome Squad (cleaning) related database communication.
 *
 * @author A.J. Rodriguez <avrodriguezjr@gmail.com>
 */

namespace API\DAO;

use \API\DAO\Base_DAO;
use \API\Database\Database;
use \PDO;

class Gnome_Squad_DAO extends Base_DAO {
	/**
	 * Creates a new Gnome_Squad_DAO.
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Returns the cleaning ID given the room and date.
	 *
	 * @param \API\Model\Room_Model $room Room
	 * @param DateTime              $date Given date
	 *
	 * @return PDOStatement Query results
	 */
	public function get_cleaning_id_by_room_id_and_date($room, $date) {
		$sql = 'SELECT ID FROM tblGnomeSquad WHERE RoomID = :room_id AND Date = :date;';

		// Connect to the database.
		$database = new Database();
		$connection = $database->connect();
    	$statement = $connection->prepare($sql);

    	// Bind parameters.
    	$statement->bindParam(':room_id', $room->get_id(), PDO::PARAM_INT);
    	$statement->bindParam(':date', $date->format('Y-m-d'), PDO::PARAM_STR);

    	// Execute query.
    	$statement->execute();

    	return $statement->fetch(PDO::FETCH_ASSOC);
	}

	/**
	 * Returns the latest cleaning given the date.
	 *
	 * @param DateTime $date Given date
	 *
	 * @return PDOStatement Query results
	 */
	public function get_latest_cleaning_by_date($date) {
		$sql = 'SELECT ID, RoomID, Date, StartTime, EndTime FROM tblGnomeSquad 
			WHERE date = :date
			ORDER BY EndTime DESC LIMIT 1;';

		// Connect to the database.
		$database = new Database();
		$connection = $database->connect();
    	$statement = $connection->prepare($sql);

    	// Bind parameters.
    	$statement->bindParam(':date', $date->format('Y-m-d'), PDO::PARAM_STR);

    	// Execute query.
    	$statement->execute();

    	return $statement->fetch(PDO::FETCH_ASSOC);
	}

	/**
	 * Adds a new cleaning given the cleaning object.
	 *
	 * @param \API\Model\Gnome_Squad_Model $cleaning Cleaning object
	 */
	public function create_new_cleaning($cleaning) {
		$sql = 'INSERT INTO tblGnomeSquad (RoomID, Date, StartTime, EndTime)
			VALUES (:room_id, :date, :start_time, :end_time)';

		// Connect to the database.
		$database = new Database();
		$connection = $database->connect();
    	$statement = $connection->prepare($sql);

    	// Bind parameters.
    	$statement->bindParam(':room_id', $cleaning->get_room_id(), PDO::PARAM_INT);
    	$statement->bindParam(':date', $cleaning->get_date()->format('Y-m-d'), PDO::PARAM_STR);
    	$statement->bindParam(':start_time', $cleaning->get_start_time()->format('H:i:s'), PDO::PARAM_STR);
    	$statement->bindParam(':end_time', $cleaning->get_end_time()->format('H:i:s'), PDO::PARAM_STR);

    	// Execute query.
    	$statement->execute();
	}

	/**
	 * Returns cleanings given the date.
	 *
	 * @param DateTime $date Given date
	 *
	 * @return PDOStatement[] Query results
	 */
	public function get_cleanings_by_date($date) {
		$sql = 'SELECT 
				g.ID AS GnomeSquadID, 
				g.RoomID AS RoomID, 
				g.Date AS Date,
				g.StartTime AS StartTime, 
				g.EndTime AS EndTime, 
				r.RoomNumber AS RoomNumber 
			FROM tblGnomeSquad g
			INNER JOIN tblRoom r ON g.RoomID = r.ID
			WHERE Date = :date
			ORDER BY StartTime ASC;';

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
}
?>