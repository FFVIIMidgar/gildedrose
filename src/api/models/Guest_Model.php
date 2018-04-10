<?php
/**
 * Guest_Model
 *
 * Model for guest objects.
 *
 * @author A.J. Rodriguez <avrodriguezjr@gmail.com>
 */

namespace API\Model;

use \API\Model\Base_Model;

class Guest_Model extends Base_Model {
	/**
	 * ID.
	 * @var int $id
	 */
	private $id;

	/**
	 * First name.
	 * @var string $first_name
	 */
	private $first_name;

	/**
	 * Last name.
	 * @var string $last_name
	 */
	private $last_name;

	/**
	 * Email.
	 * @var string $email
	 */
	private $email;

	/**
	 * Constructs a new Guest_Model.
	 *
	 * @param int    $id         ID
	 * @param string $first_name First name
	 * @param string $last_name  Last name
	 * @param string $email      Email
	 */
	public function __construct($id, $first_name, $last_name, $email) {
		parent::__construct();

		$this->id = $id;
		$this->first_name = $first_name;
		$this->last_name = $last_name;
		$this->email = $email;
	}

	/**
	 * Sets the ID.
	 *
	 * @param int $id ID
	 */
	public function set_id($id) {
		$this->id = $id;
	}

	/**
	 * Returns the ID.
	 *
	 * @return int ID
	 */
	public function get_id() {
		return $this->id;
	}

	/**
	 * Sets the first name.
	 *
	 * @param string $first_name First name
	 */
	public function set_first_name($first_name) {
		$this->first_name = $first_name;
	}

	/**
	 * Returns the first name.
	 *
	 * @return string First name
	 */
	public function get_first_name() {
		return $this->first_name;
	}

	/**
	 * Sets the last name.
	 *
	 * @param string $last_name Last name
	 */
	public function set_last_name($last_name) {
		$this->last_name = $last_name;
	}

	/**
	 * Returns the last name.
	 *
	 * @return string Last name
	 */
	public function get_last_name() {
		return $this->last_name;
	}

	/**
	 * Sets the email.
	 *
	 * @param string $email Email
	 */
	public function set_email($email) {
		$this->email = $email;
	}

	/**
	 * Returns the email.
	 *
	 * @return string Email
	 */
	public function get_email() {
		return $this->email;
	}
}
?>