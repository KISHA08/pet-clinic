<?php
$hostname = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "pet_clinic";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = mysqli_connect($hostname, $dbuser, $dbpass, $dbname);
    if (!$conn) {
        throw new Exception("Failed to connect to MySQL: " . mysqli_connect_error());
    } else {
        //echo "Connection successful";
    }
} catch (Exception $e) {
    die("Connection error: " . $e->getMessage());
}
?>