<?php
/*	The purchaseConfirmCheck file perform the queries that will create a new
	record in the orders and order_item tables. A transaction is used while
	performing the queries to prevent any inconsistencies or problems if there
	were multiple queries happening at the same time for the database.
*/
if(session_status() !== PHP_SESSION_ACTIVE) session_start();

if(!isset($_SESSION['userid'])){
	session_unset();
	session_destroy();
	header("Location: login.php");
}

include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST['confirmCheck'])){
	
	date_default_timezone_set('America/New_York');
	$date = date('Y-m-d');
	$storeid = $_SESSION["store"];
	$userid = $_SESSION["userid"];
	$item = $_SESSION["item"];
	
	$addressCheck_query = "	SELECT *
							FROM customer_address
							WHERE userid = ?";
	$stmt_addressCheck_query = $conn->prepare($addressCheck_query);
	$stmt_addressCheck_query->bind_param('i', $userid);
	$stmt_addressCheck_query->execute();
	$result = $stmt_addressCheck_query->get_result();

	if($result->num_rows > 0){
		
		$conn->begin_transaction();
		
		try{
			$order_query = "INSERT INTO orders(storeid, userid, orderdate, status) VALUES(?, ?, ?, 'pending')";
			$stmt_order_query = $conn->prepare($order_query);
			$stmt_order_query->bind_param('iis', $storeid, $userid, $date);
			$stmt_order_query->execute();
			
			$orderitem_query = "INSERT INTO order_item(orderid, productid, amount) VALUES(LAST_INSERT_ID(), ?, 1)";
			$stmt_orderitem_query = $conn->prepare($orderitem_query);
			$stmt_orderitem_query->bind_param('i', $item);
			$stmt_orderitem_query->execute();
		
			$stock_query = "UPDATE stock SET amount = amount - 1 WHERE storeid = ? and productid = ?";
			$stmt_stock_query = $conn->prepare($stock_query);
			$stmt_stock_query->bind_param('ii', $storeid, $item);
			$stmt_stock_query->execute();
			
			$conn->commit();
			
			unset($_SESSION['storeid']);
			unset($_SESSION['item']);
			
			echo "ORDER SUBMITTED AND PLACED <br>
				<a href='userpage.php'>Go back to userpage</a>";
		}
		catch(mysqli_sqk_exception $exception){
			mysqli_rollback($mysqli);
			unset($_SESSION['storeid']);
			unset($_SESSION['item']);
			echo "ERROR! Order has not been submitted and placed! Try again! <br>
				<a href='userpage.php'>Go back to userpage</a>";
		}
		
	}
	else{
		echo "You do not have an address! <br> Update your address on your userpage! <br> 
			<a href='userpage.php'>Go back to userpage</a>";
	}
}
else{
	echo "You did not confirm your purchase <br>
		<a href='userpage.php'>Go back to userpage</a>";
}

?>