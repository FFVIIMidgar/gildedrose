<?php
/**
 * DAO for all guest related database communication.
 *
 * @author A.J. Rodriguez <avrodriguezjr@gmail.com>
 */

namespace API\DAO;

use \API\DAO\Base_DAO;
use \API\Database\Database;
use \PDO;

class Guest_DAO extends Base_DAO {
	/**
	 * Constructs a new Guest_DAO.
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Adds a new guest.
	 *
	 * @param \API\Model\Guest_Model $guest Guest
	 */
	public function create_guest($guest) {
		$sql = 'INSERT INTO tblGuest (FirstName, LastName, Email) 
			VALUES (:first_name, :last_name, :email);';

		// Connect to the database.
		$database = new Database();
		$connection = $database->connect();
    	$statement = $connection->prepare($sql);
    	
    	// Bind parameters.
    	$statement->bindParam(':first_name', $guest->get_first_name(), PDO::PARAM_STR);
    	$statement->bindParam(':last_name', $guest->get_last_name(), PDO::PARAM_STR);
    	$statement->bindParam(':email', $guest->get_email(), PDO::PARAM_STR);

    	// Execute query.
    	$statement->execute();
	}

	/**
	 * Returns the guest ID given the email.
	 *
	 * @param string $email Email
	 *
	 * @return PDOStatement Query results
	 */
	public function get_guest_id_by_email($email) {
		$sql = 'SELECT ID FROM tblGuest WHERE email = :email;';

		// Connect to the database.
		$database = new Database();
		$connection = $database->connect();
    	$statement = $connection->prepare($sql);

    	// Bind parameters.
    	$statement->bindParam(':email', $email, PDO::PARAM_STR);

    	// Execute query.
    	$statement->execute();

    	return $statement->fetch(PDO::FETCH_ASSOC);
	}
}
?>