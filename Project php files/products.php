<?php
/*	The products file displays the available products within the store. There is an
	sql query that selects the products. In addition, users can input the product's 
	productid(UPC) into the search box to purchase their items.
*/
if(session_status() !== PHP_SESSION_ACTIVE) session_start();

if(!isset($_SESSION['userid'])){
	session_unset();
	session_destroy();
	header("Location: login.php");
}

include 'connect.php';

$products_query = "SELECT productid, product.productname, product.price, brand.brandname
			FROM product
			INNER JOIN brand
			ON product.brandid = brand.brandid";

$stmt_products_query = $conn->prepare($products_query);
$stmt_products_query->execute();
$result = $stmt_products_query->get_result();

if($result->num_rows > 0)
{
	echo"
	<form action='stores.php' method='POST'>
	Type UPC of Product to Purchase: <br> 
	<input type='text' name = 'item' required/> <br>
	<input type='submit' name='store' value = 'Purchase' /> <br>
	</form>
	
	<table>
	<thead>
		<tr>
			<th>UPC</th>
			<th>Product Name</th>
			<th>Price</th>
			<th>Brand</th>
		</tr>
	</thead>
	<tbody>
	";
  while($row = $result->fetch_assoc()){;
	echo"
		<tr>
			<td>" . $row['productid'] . "</td>
			<td>" . $row['productname'] . "</td>
			<td>" . $row['price'] . "</td>
			<td>" . $row['brandname'] . "</td>
		</tr>";
  }
}
else
{
  echo "No data found.";
}

?>
<a href="userpage.php">Go back</a>
