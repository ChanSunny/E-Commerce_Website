<?php
/*	The phoneupdateCheck file changes the user's phone number. The file first checks
	if the user inputted a 10 digit integer(assuming that the phone number exist
	if it is ten digits and it is a US phone number). Next, the file checks if
	the user has an existing phone number. If so, a sql query is used to update the
	phone number. If not, a sql query is used to insert the user's phone number.
*/
include 'connect.php';
if(session_status() !== PHP_SESSION_ACTIVE) session_start();

if(!isset($_SESSION['userid'])){
	session_unset();
	session_destroy();
	header("Location: login.php");
}
$building = $street = $city = $zipcode ="";

if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST['phoneupdate'])){
	$phone = test_input($_POST["phone"]);
	$phonelength = strlen($phone);
	
	if($phonelength != 10 or !is_numeric($phone)){
		echo "Invalid phone number! Try again";
	}
	else{
		$currentuser = $_SESSION['userid'];
		
		$check_query = "SELECT userid
						FROM customer_phone
						WHERE userid = ?";
		$stmt_check_query = $conn->prepare($check_query);
		$stmt_check_query->bind_param('i',$currentuser);
		$stmt_check_query->execute();
		$result = $stmt_check_query->get_result();
		
		if($result->num_rows === 1){
			$update_query = "UPDATE customer_phone
							SET phone = ?
							WHERE userid = ?";
			$stmt_update_query = $conn->prepare($update_query);
			$stmt_update_query->bind_param('si', $phone, $currentuser);
			$stmt_update_query->execute();
			
			header("Location: phoneupdate.php");
		}
		else{
			$insert_query = "INSERT INTO customer_phone(userid, phone) 
							VALUES (?,?)";
			$stmt_insert_query = $conn->prepare($insert_query);
			$stmt_insert_query->bind_param("ii",$currentuser,$phone);
			$stmt_insert_query->execute();
			
			header("Location: phoneupdate.php");
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
<a href="phoneupdate.php">Go back</a>