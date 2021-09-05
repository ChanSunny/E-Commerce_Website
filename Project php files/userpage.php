<?php
/*	The userpage file is where the user click on the corresponding links
	to perform an action, such as viewing products or updating phone number.
*/
if(session_status() !== PHP_SESSION_ACTIVE) session_start();

if(!isset($_SESSION['userid'])){
	session_unset();
	session_destroy();
	header("Location: login.php");
}

?>
<body>
	<a href="products.php">View/Purchase Products</a>
	<br>
	<a href="orders.php">Your Orders</a>
	<br>
	<a href="phoneupdate.php">Update Phone Number</a>
	<br>
	<a href="addressupdate.php">Update Address</a>
	<br>
	<a href="login.php">Log Out</a>
</body>
