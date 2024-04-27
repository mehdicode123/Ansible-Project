<?php
// MySQL server configuration
$db_host = 'localhost'; // Assuming MySQL server is running on the same host
$db_port = '3306'; // Default MySQL port

// Staging database configuration
$stag_db_name = 'db_stag'; // Staging database name
$stag_user = 'user2'; // Staging MySQL user
$stag_password = '46569610mmnn321'; // Staging MySQL password

// Production database configuration
$prod_db_name = 'db_prod'; // Production database name
$prod_user = 'user1'; // Production MySQL user
$prod_password = '46569610mmnn321'; // Production MySQL password

// Connect to Staging database
$stag_link = mysqli_connect($db_host, $stag_user, $stag_password, $stag_db_name, $db_port);

// Check if the connection to Staging database was successful
if (!$stag_link) {
    die('Could not connect to Staging database: ' . mysqli_connect_error());
}

// Connection successful message for Staging database
echo 'Connected successfully to Staging database.<br>';

// Close the Staging database connection
mysqli_close($stag_link);

// Connect to Production database
$prod_link = mysqli_connect($db_host, $prod_user, $prod_password, $prod_db_name, $db_port);

// Check if the connection to Production database was successful
if (!$prod_link) {
    die('Could not connect to Production database: ' . mysqli_connect_error());
}

// Connection successful message for Production database
echo 'Connected successfully to Production database.<br>';

// Echo "Hello world!" after two connection messages
echo 'Hello world!';
?>

