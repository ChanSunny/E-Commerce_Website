<?php/*	The register file allows new users to create an account for the webpage.	Users are asked to input their email, password, first name, and last name.*/if(session_status() !== PHP_SESSION_ACTIVE) session_start();?><form action="registerCheck.php" method="POST">    Email: <input type="text" name = "email" required/> </br>	Password: <input type="password" name = "password" required/></br>	First Name: <input type="text" name = "first" required/> </br>	Last Name: <input type="text" name = "last" required/> </br>	<input type="submit" name="register" value = "Register" /></form><a href="index.php">Go back</a>