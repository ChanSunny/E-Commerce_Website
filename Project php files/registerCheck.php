<?php
/*	The registerCheck file takes the user's input and insert a new
	record into the customer table. If the insert query fails, it
	means that either the user inputted incorrect information or
	the user already created the account by their given information.*/
include 'connect.php';
if(session_status() !== PHP_SESSION_ACTIVE) session_start();
$email = $password = $first = $last = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST['register'])){
	$email = test_input($_POST["email"]);
	$password = test_input($_POST["password"]);
	$first = test_input($_POST["first"]);
	$last = test_input($_POST["last"]);
	$hash_password = password_hash($password, PASSWORD_DEFAULT);
	
	$register_query = "INSERT INTO customer(first, last, email) VALUES(?, ?, ?)";
	$stmt_register_query = $conn->prepare($register_query);
	$stmt_register_query->bind_param('sss', $first, $last, $email);
	
	if($stmt_register_query->execute()){		
		$password_query = "INSERT INTO customer_login(email, password) 
						   VALUES(?, ?)";
		$stmt_password_query = $conn->prepare($password_query);
		$stmt_password_query->bind_param('ss', $email, $hash_password);
		if($stmt_password_query->execute()){
			echo "Registration success! <br>
			<a href='index.php'>Go back</a>";
		}
		else{
			echo "Password failed";
		}
	}
	else{
		echo "Registration failed <br>
		<a href='register.php'>Go back and try again</a>";
	}
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>