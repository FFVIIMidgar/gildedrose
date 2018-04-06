<?php
namespace API\DAO;

use \API\DAO\Base_DAO;
use \API\Database\Database;

class Guest_DAO extends Base_DAO {
	public function create_guest($guest) {
		$sql = 'INSERT INTO tblGuest (FirstName, LastName, Email) 
			VALUES (:first_name, :last_name, :email);';

		$database = new Database();
		$connection = $database->connect();
    	$statement = $connection->prepare($sql);
    	
    	$statement->bindParam(':first_name', $guest->get_first_name(), \PDO::PARAM_STR);
    	$statement->bindParam(':last_name', $guest->get_last_name(), \PDO::PARAM_STR);
    	$statement->bindParam(':email', $guest->get_email(), \PDO::PARAM_STR);

    	$statement->execute();
	}

	public function get_guest_id_by_email($email) {
		$sql = 'SELECT ID FROM tblGuest WHERE email = :email;';

		$database = new Database();
		$connection = $database->connect();
    	$statement = $connection->prepare($sql);

    	$statement->bindParam(':email', $email, \PDO::PARAM_STR);

    	$statement->execute();

    	return $statement->fetch(\PDO::FETCH_ASSOC);
	}
}
?>