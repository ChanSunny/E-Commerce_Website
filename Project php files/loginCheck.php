<?php
/*	The loginCheck file makes sure the user inputted their correct information
	by searching through the database to find the user's login credential. The
	first query searches for the userid and password and then checks if the
	password is correct.*/
include 'connect.php';
if(session_status() !== PHP_SESSION_ACTIVE) session_start();

$email = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST['login'])){
	$email = test_input($_POST["email"]);
	$password = test_input($_POST["password"]);
	
	$check_query = "SELECT customer.userid, customer.email, customer_login.password 
					FROM customer 
					INNER JOIN customer_login
					ON customer.email = customer_login.email
					WHERE customer.email = ?";
	$stmt_query = $conn->prepare($check_query);
	$stmt_query->bind_param('s', $email);
	$stmt_query->execute();
	$result = $stmt_query->get_result();
	
	if($result->num_rows === 1){
		$row = $result->fetch_assoc();
		if(password_verify($password,$row['password'])){
			$_SESSION['userid'] = $row['userid'];
			header("Location: userpage.php");
		}
		else{
			echo "Try again, incorrect login or password.";
		}
	}
	else{
		echo "Try again, user does not exist.";
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
<a href="login.php">Go back</a>