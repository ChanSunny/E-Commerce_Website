<?php
/*	The purchaseConfirm file will confirm if the productid and storeid
	is valid. After confirming that it is valid, it will store the values
	in the session variables to be used super globally.
*/
if(session_status() !== PHP_SESSION_ACTIVE) session_start();

if(!isset($_SESSION['userid'])){
	session_unset();
	session_destroy();
	header("Location: login.php");
}

include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST['confirm'])){
	$store = test_input($_POST["store"]);
	$item = $_SESSION["item"];
	
	$confirm_query = "	SELECT product.productname, store.storename
						FROM product
						INNER JOIN stock
						ON product.productid = stock.productid
						INNER JOIN store
						ON stock.storeid = store.storeid
						WHERE store.storeid = ? and product.productid = ?";
	$stmt_confirm_query = $conn->prepare($confirm_query);
	$stmt_confirm_query->bind_param('ii',$store,$item);
	$stmt_confirm_query->execute();
	$result = $stmt_confirm_query->get_result();
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){;
			$_SESSION["store"] = $store;
			
			echo"Are you sure you want to purchase: <br>"
				. $row['productname'] . "<br> from " . $row['storename'] . "?
				<form action='purchaseConfirmCheck.php' method='POST'>
				<input type='submit' name='confirmCheck' value = 'YES' /> <br>
				If not:";	
		}
	}
	else{
		echo "INVALID STORE ID";
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
<a href="products.php">Go back</a>