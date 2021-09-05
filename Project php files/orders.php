<?php
/*	the orders file displays the user's orders. There is a sql query
	that finds and selects the user's order according to their userid.
	The page will display relevant information about the user's order,
	such as the order date, status, and the quantity of the product.
*/
if(session_status() !== PHP_SESSION_ACTIVE) session_start();

if(!isset($_SESSION['userid'])){
	session_unset();
	session_destroy();
	header("Location: login.php");
}

include 'connect.php';

$currentuser = $_SESSION["userid"];

$order_query = "SELECT orders.orderid, product.productname, order_item.amount, orders.status, orders.orderdate
			FROM orders
			INNER JOIN order_item
			ON orders.orderid = order_item.orderid
			INNER JOIN product
			ON order_item.productid = product.productid
			WHERE orders.userid = ?";

$stmt_order_query = $conn->prepare($order_query);
$stmt_order_query->bind_param('i', $currentuser);
$stmt_order_query->execute();
$result = $stmt_order_query->get_result();

if($result->num_rows > 0)
{
	echo"
	<table>
	<thead>
		<tr>
			<th>Order ID</th>
			<th>Product</th>
			<th>Quantity</th>
			<th>Status</th>
			<th>Purchased On</th>
		</tr>
	</thead>
	<tbody>
	";
  while($row = $result->fetch_assoc()){;
	echo"
		<tr>
			<td>" . $row['orderid'] . "</td>
			<td>" .$row['productname'] . "</td>
			<td>" .$row['amount'] . "</td>
			<td>" .$row['status'] . "</td>
			<td>" .$row['orderdate'] . "</td>
		</tr>";
  }
}
else
{
  echo "You have no orders.";
}

?>
<br>
<a href="userpage.php">Go back</a>
