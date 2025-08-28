<?php
// db.php - central DB connection file
$DB_HOST = 'localhost';
$DB_USER = 'uei4bkjtcem6s';
$DB_PASS = 'wmhalmspfjgz';
$DB_NAME = 'dba0ucw9zenh7l';
 
$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($mysqli->connect_errno) {
    http_response_code(500);
    echo "DB connection failed: " . $mysqli->connect_error;
    exit;
}
$mysqli->set_charset("utf8mb4");
?>
