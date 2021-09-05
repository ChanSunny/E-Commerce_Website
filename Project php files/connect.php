<?php
/*	The connect file is used for the files where the user is logged in. It
	will allow the user to access the database. The password is randomly
	generated.
*/
$servername = "localhost";
$username = "root";
$password = "MQoMaFWJ6tpfvaDG";
$dbname = "bestbuy_database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn === false)
    {
    	die("Database not found! Check the connection.");
    }
?>