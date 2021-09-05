<?php
/*	The stores file will display the stores that currently have the product
	that the user inputted(productid). Here the user inputs the storeid to 
	pick the location from which the product will be delivered from. After
	submitting the form, the user will be directed to purchaseConfirm file.
*/
if(session_status() !== PHP_SESSION_ACTIVE) session_start();

if(!isset($_SESSION['userid'])){
	session_unset();
	session_destroy();
	header("Location: login.php");
}

include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST['store'])){
	$item = test_input($_POST["item"]);
	
	$store_query = "	SELECT store.storeid, store.storename, store_address.building, store_address.street, store_address.city, store_address.zipcode, stock.amount
						FROM store
						INNER JOIN store_address
						ON store.storeid = store_address.storeid
						INNER JOIN stock
						ON store.storeid = stock.storeid
						INNER JOIN product
						ON stock.productid = product.productid
						WHERE product.productid = ?";
	$stmt_store_query = $conn->prepare($store_query);
	$stmt_store_query->bind_param('i', $item);
	$stmt_store_query->execute();
	$result = $stmt_store_query->get_result();
	
	if($result->num_rows > 0){
		$_SESSION["item"] = $item;
		
		echo"
		<form action='purchaseConfirm.php' method='POST'>
		Type STORE ID of Product: <br> 
		<input type='text' name = 'store' required/> <br>
		<input type='submit' name='confirm' value = 'Submit' /> <br>
		</form>
		
		<table>
		<thead>
		<tr>
			<th>Store ID</th>
			<th>Store Name</th>
			<th>Store Address</th>
			<th>Quantity Left</th>
		</tr>
		</thead>
		<tbody>
		";
		while($row = $result->fetch_assoc()){;
		echo"
		<tr>
			<td>" . $row['storeid'] . "</td>
			<td>" . $row['storename'] . "</td>
			<td>" . $row['building'] . " " . $row['street'] . " " . $row['city'] . " " . $row['zipcode'] . "</td>
			<td>" . $row['amount'] . "</td>
		</tr>";
		}
	}
	else{
		echo "There are currently no stores that have this product or Invalid UPC. <br>";
		
	}
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
<a href="products.php">Go back</a>