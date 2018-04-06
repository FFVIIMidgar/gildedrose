<?php
$app->get('/api/v1/rooms/available', 'Room_Controller:get_room_availability');
$app->post('/api/v1/booking/book', 'Booking_Controller:book_room');
?>