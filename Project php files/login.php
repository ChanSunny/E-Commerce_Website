<?php 
/*	The login file ask for the user to input their email and password to verify
	their credentials for allowing access to the database and further webpages.
	After submitting inputs, users are sent to the loginCheck file to verify.*/
	
//Makes sure the session variables are deleted and wiped.	
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
	session_unset();
	session_destroy();
}
?>
LOG IN HERE <br>
<form action="loginCheck.php" method="POST">
	Email: <input type="text" name = "email" required/> <br>
	Password: <input type="password" name = "password" required/><br>
	<input type="submit" name="login" value = "login" />
</form>

<a href="index.php">Go back</a>