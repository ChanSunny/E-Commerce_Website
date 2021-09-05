<?php
/*	The index file is where the users will start when they access the webpage.The file 
	provides two links:Login and Register. Login link will send the users to the login
	file while the Register link will send the sends to the register file.*/

//Makes sure the session variables are deleted and wiped.
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
	session_unset();
	session_destroy();
}
?>

<body>
	<a href="login.php">Login</a>
	<br>
	<a href="register.php">Register</a>
</body>
