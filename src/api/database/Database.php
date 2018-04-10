<?php
/**
 * Database
 *
 * Handles database connections.
 *
 * @author A.J. Rodriguez <avrodriguezjr@gmail.com>
 */

namespace API\Database;

use \PDO;

class Database {
	/**
	 * Host.
	 * @var string $host
	 */
	private $host;

	/**
	 * Database.
	 * @var string $database
	 */
	private $database;

	/**
	 * Username.
	 * @var string $username
	 */
	private $username;

	/**
	 * Password.
	 * @var string $password
	 */
	private $password;

	/**
	 * Constructs a new Database.
	 */
	public function __construct() {
		require __DIR__ . '/../../config/config.php';

		$this->host = $config['database']['host'];
		$this->database = $config['database']['database'];
		$this->username = $config['database']['username'];
		$this->password = $config['database']['password'];
	}

	/**
	 * Connects to the database and returns the connection.
	 *
	 * @return PDO Database connection
	 */
	public function connect() {
		$connection_string = 'mysql:host=' . $this->host .';dbname=' . $this->database . ';';
		$connection = new PDO($connection_string, $this->username, $this->password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		return $connection;
	}
}
?>