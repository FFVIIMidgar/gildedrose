<?php
/**
 * test.php
 *
 * A simple command line UI to test the API. It is assumed that all input is valid.
 *
 * @author A.J. Rodriguez <avrodriguezjr@gmail.com>
 */

print_main_menu();

// Program will keep running until the user wishes to terminate.
while ($line = readLine('Input option ("help" to print menu): ')) {
	switch ($line) {
		case '1':
			process_room_availability();
			break;

		case '2':
			process_booking();
			break;

		case '3':
			process_gnome_squad_schedule();
			break;

		case '4':
			exit;
			break;

		case 'help':
			print_main_menu();
			break;

		default:
			process_invalid_option();
	}
}

/**
 * Prints the main menu.
 */
function print_main_menu() {
	echo "---------------------\n";
	echo "Gilded Rose Main Menu\n";
	echo "---------------------\n";
	echo "1. View room availability.\n";
	echo "2. Book a room.\n";
	echo "3. View Gnome Squad schedule.\n";
	echo "4. Quit.\n\n";
}

/**
 * Processes the "View room availability" option.
 */
function process_room_availability() {
	// Get input.
	$date = readLine('Enter date: ');
	$item_count = readLine('Enter number of items: ');
	echo "\n";

	// Make the GET request.
	$available_rooms = json_decode(file_get_contents('http://localhost/gildedrose/api/v1/rooms/available?date=' . $date . '&itemCount=' . $item_count), true);

	//Output the results.
	echo "Room Availability\n";
	echo "-----------------\n";
	print_r('Date: ' . $available_rooms['availableRooms']['date'] . "\n");
	echo 'Number of items: ' . $available_rooms['availableRooms']['numberOfItems'] . "\n\n";
	echo "Rooms available:\n\n";

	$rooms = $available_rooms['availableRooms']['rooms'];

	if (empty($rooms)) {
		echo "None\n\n";
	} else {
		foreach ($rooms as $room) {
			echo 'Room Number: ' . $room['roomNumber'] . "\n";
			echo 'Guest Occupancy: ' . $room['guestOccupancy'] . "\n";
			echo 'Remaining Guest Occupancy: ' . $room['remainingGuestOccupancy'] . "\n";
			echo 'Max Guest Occupancy: ' . $room['maxGuestOccupancy'] . "\n";
			echo 'Storage Occupancy: ' . $room['storageOccupancy'] . "\n";
			echo 'Remaining Storage Occupancy: ' . $room['remainingStorageOccupancy'] . "\n";
			echo 'Max Storage Occupancy: '. $room['maxStorageOccupancy'] . "\n\n";
		}

	}
}

/**
 * Processes the "Book a room" option.
 */
function process_booking() {
	// Get input.
	$name = readLine('Enter name: ');
	$email = readLine('Enter email: ');
	$date = readLine('Enter booking date: ');
	$item_count = readLine('Enter number of items: ');
	echo "\n";

	$name = explode(' ', $name);
	$first_name = $name[0];
	$last_name = $name[1];

	// Prepare data for the request.
	$data = json_encode([
		'firstName' => $first_name,
		'lastName'  => $last_name,
		'email'     => $email,
		'date'      => $date,
		'itemCount' => $item_count
	]);


	$url = 'http://localhost/gildedrose/api/v1/booking/book';
	
	// Make the POST request.
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-type: application/json']);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	$response = curl_exec($ch);
	$response_status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

	// Output the results.
	echo "Booking Results\n";
	echo "---------------\n";

	$booking_results = json_decode($response, true)['bookingResults'];

	if ($booking_results['status'] === 'success') {
		$booking_details = $booking_results['bookingDetails'];
		echo "Booking successful!\n\n";
		echo "Booking Results:\n\n";
		echo 'Name: ' . $booking_details['firstName'] . ' ' . $booking_details['lastName'] . "\n";
		echo 'Email: ' . $booking_details['email'] . "\n";
		echo 'Room Number: ' . $booking_details['roomNumber'] . "\n";
		echo 'Check In Date: ' . $booking_details['checkInDate'] . "\n";
		echo 'Check Out Date: ' . $booking_details['checkOutDate'] . "\n";
		echo 'Number of Items: ' . $booking_details['numberOfItems'] . "\n\n";

	} else {
		echo 'Error: ' . $booking_results['reason']. "\n\n";
	}
}

/**
 * Process the "View Gnome Squad schedule" option.
 */
function process_gnome_squad_schedule() {
	// Get input.
	$date = readLine('Enter date: ');
	echo "\n";

	// Make the GET request.
	$gnome_squad_schedule = json_decode(file_get_contents('http://localhost/gildedrose/api/v1/management/schedule?date=' . $date), true);

	// Output the results.
	echo "Gnome Squad Schedule\n";
	echo "--------------------\n";
	echo 'Date: ' . $gnome_squad_schedule['gnomeSquadSchedule']['date'] . "\n\n";
	echo "Schedule:\n\n";

	$cleanings = $gnome_squad_schedule['gnomeSquadSchedule']['cleanings'];

	if (empty($cleanings)) {
		echo "No cleanings scheduled.\n\n";
	} else {
		foreach ($cleanings as $cleaning) {
			echo 'Room Number: ' . $cleaning['roomNumber'] . "\n";
			echo 'Start Time: ' . $cleaning['startTime'] . "\n";
			echo 'End Time: ' . $cleaning['endTime'] . "\n\n";
		}
	}
}

/**
 * Processes any invalid input.
 */
function process_invalid_option() {
	echo "Invalid option.\n\n";
}
?>