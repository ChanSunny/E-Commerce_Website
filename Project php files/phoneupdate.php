<?php
/*	The phoneupdate file allows the users to update their phonenumber. In addition,
	this file checks if the user has an existing phone number or not. The file will
	show the user's current phone number.
*/
include 'connect.php';
if(session_status() !== PHP_SESSION_ACTIVE) session_start();

if(!isset($_SESSION['userid'])){
	session_unset();
	session_destroy();
	header("Location: login.php");
}
?>

Current Phone:

<?php 
$currentuser = $_SESSION['userid'];

$check_query = "SELECT phone
				FROM customer_phone
				WHERE userid = ?";
$stmt_check_query = $conn->prepare($check_query);
$stmt_check_query->bind_param('i',$currentuser);
$stmt_check_query->execute();
$result = $stmt_check_query->get_result();

if($result->num_rows === 1){
	$row = $result->fetch_assoc();
	echo "<br>" . $row['phone'];
	}
	else{
		echo "No Phone Numbers";
	}
?>
<br>
Change/Update your phone by filling out the form below.
<form action="phoneupdateCheck.php" method="POST">
	Phone Number: <input type="text" name = "phone" required/><br>
	<input type="submit" name="phoneupdate" value = "Submit" />
</form>

<a href="userpage.php">Go back</a>