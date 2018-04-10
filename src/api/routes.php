<?php
/**
 * routes.php

 * Handles all API routing as well as their HTTP methods.
 *
 * @author A.J. Rodriguez <avrodriguezjr@gmail.com>
 */

$app->group('/api/v' . $config['version'] .'/', function() {
	$this->get('rooms/available', 'Room_Controller:get_room_availability');
	$this->get('management/schedule', 'Gnome_Squad_Controller:get_gnome_squad_schedule');
	$this->post('booking/book', 'Booking_Controller:book_room');
});
?>