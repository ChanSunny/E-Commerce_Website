<?php
/*	The addressupdate file allows the users to update their address. In addition,
	this file checks if the user has an existing address or not. The file will
	show the user's current address.
*/
include 'connect.php';
if(session_status() !== PHP_SESSION_ACTIVE) session_start();

if(!isset($_SESSION['userid'])){
	session_unset();
	session_destroy();
	header("Location: login.php");
}
?>

Current Address:

<?php 
$currentuser = $_SESSION['userid'];

$check_query = "SELECT building, street, city, zipcode
				FROM customer_address
				WHERE userid = ?";
$stmt_check_query = $conn->prepare($check_query);
$stmt_check_query->bind_param('i',$currentuser);
$stmt_check_query->execute();
$result = $stmt_check_query->get_result();

if($result->num_rows === 1){
		$row = $result->fetch_assoc();
		echo $row['building'] ." ". $row['street'] .", ". $row['city'] .", ". $row['zipcode'];
	}
	else{
		echo "No Address";
	}
?>
<br>
Change your address by filling out the form below.
<form action="addressupdateCheck.php" method="POST">
	Building: <input type="text" name = "building" required/> <br>
	Street: <input type="text" name = "street" required/><br>
	City: <input type="text" name = "city" required/><br>
	Zipcode: <input type="text" name = "zipcode" required/><br>
	<input type="submit" name="addressupdateCheck" value = "Submit" />
</form>

<a href="userpage.php">Go back</a>