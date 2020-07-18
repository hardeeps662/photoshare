<?php 

$servername = "localhost";
//$servername = "a2plcpnl0945.prod.iad2.secureserver.net";
$username = "";
$password = "";
$dbname = "";
//$port = "";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// DATABASE VARIABLES **************************


//SET AS DEFAULT INDIAN TIME;
date_default_timezone_set('Asia/Kolkata');


?>