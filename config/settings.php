<?php
    // Current server address
	$host = $_SERVER['SERVER_ADDR'];
    // Init global variables
	define('BASE_URL', 'http://'.$host. '/'); // Website base URL
	define('DB_HOST', $host); // Database host
	define('DB_USER', 'developer'); // Database username
	define('DB_PASS', '199MbNPnDrcchKrJ'); // Database user password
    define('DB_NAME', 'queuing_db'); // Database name
?>