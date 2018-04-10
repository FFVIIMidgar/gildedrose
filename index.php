<?php
/**
 * index.php
 *
 * API entry point.
 *
 * @author A.J. Rodriguez <avrodriguezjr@gmail.com>
 */

require_once 'src/api/api.php';

// Set the default timezone to New York, to avoid warnings thrown when dealing with date/time objects.
date_default_timezone_set('America/New_York');

$app->run();
?>