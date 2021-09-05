<?php
/*	The addressupdateCheck file changes the user's address. First, the file checks
	if the zipcode is 5 digits of integers before performing the sql queries. If not,
	the webpage will display a message that the zipcode is invalid. Next, there is a
	sql query that attempts to find the user's current address. If the query finds the
	address, there is a new sql query that updates the informatiom. If the search query
	can not find it, there is a query that will insert a new record into the database in
	the customer_address table.
*/
include 'connect.php';
if(session_status() !== PHP_SESSION_ACTIVE) session_start();

if(!isset($_SESSION['userid'])){
	session_unset();
	session_destroy();
	header("Location: login.php");
}
$building = $street = $city = $zipcode ="";

if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST['addressupdateCheck'])){
	$building = test_input($_POST["building"]);
	$street = test_input($_POST["street"]);
	$city = test_input($_POST["city"]);
	$zipcode = test_input($_POST["zipcode"]);
	$zipcodelength = strlen($zipcode);
	
	if($zipcodelength != 5 or !is_numeric($zipcode)){
		echo "Invalid zipcode! Try again";
	}
	else{
		$currentuser = $_SESSION['userid'];
		$check_query = "SELECT userid
						FROM customer_address 
						WHERE userid = ?";
		$stmt_check_query = $conn->prepare($check_query);
		$stmt_check_query->bind_param('i',$currentuser);
		$stmt_check_query->execute();
		$result = $stmt_check_query->get_result();
		
		if($result->num_rows === 1){
			$update_query = "UPDATE customer_address
							SET building = ?,
								street = ?,
								city = ?,
								zipcode = ?
							WHERE userid = ?";
			$stmt_update_query = $conn->prepare($update_query);
			$stmt_update_query->bind_param('ssssi', $building, $street, $city, $zipcode, $currentuser);
			if($stmt_update_query->execute()){
			header("Location: addressupdate.php");
			}
			else{
				echo "Try again, invalid Address!";
			}
		}
		else{
			$insert_query = "INSERT INTO customer_address(userid, building, street, city, zipcode) 
							VALUES (?,?,?,?,?)";
			$stmt_insert_query = $conn->prepare($insert_query);
			$stmt_insert_query->bind_param("issss",$currentuser,$building,$street,$city,$zipcode);
			$stmt_insert_query->execute();
			header("Location: addressupdate.php");
		}
	}
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>
<br>
<a href="addressupdate.php">Go back</a>