<?php
namespace API\Database;

class Database {
	private $hostname;
	private $database;
	private $username;
	private $password;

	public function __construct() {
		$this->host = 'localhost';
		$this->database = 'gildedrose';
		$this->username = 'root';
		$this->password = ''; 
	}

	public function connect() {
		$connection_string = 'mysql:host=' . $this->host .';dbname=' . $this->database . ';';

		$connection = new \PDO($connection_string, $this->username, $this->password);
		$connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

		return $connection;
	}
}
?>