
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="">
<!--<![endif]-->

<head>
<meta charset="utf-8">
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>H Mart</title>

<link rel="stylesheet" href="css/bootstrap.min.css'">
<link rel="stylesheet" href="css/main.css">
<link rel="stylesheet" href="css/responsive.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
</head>
<?php
	// if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
		// 	$uri = 'https://';
		// } else {
			// 	$uri = 'http://';
			// }
			// $uri .= $_SERVER['HTTP_HOST'];
			// header('Location: '.$uri.'/dashboard/');
			// exit;
			
			$servername = "coffee-gave-me-gas.cgzqmhf3sjbn.us-east-2.rds.amazonaws.com:3306";
			$username = "root";
			$password = "csc4112018";
			$dbname = "projectcoffee";					
			// Create connection
			$conn = new mysqli($servername, $username, $password, $dbname);
			// Check connection
			if ($conn->connect_error) 
			{
				die("Connection failed: " . $conn->connect_error);
			}
			else
			{
				echo "<h2> Note not every store has 20 transactions </h2> ";
				echo "<br>";
				
				
				
				$result = $conn->query("SELECT @cur_rank, productName as Product, units as 'Units Sold', storeName as Store, store_ID
		from (select product_ID as upc, amountSold as units_sold, store_ID, storeName,
					-- Leveraged mysql session variables to track ranking 
					-- If the store_ID is = to the previous one than increase the rank, otherwise start back at 1
					  @cur_rank := IF(@store = store_ID, @cur_rank + 1, 1) as Rank, 
					  @store := store_ID,
					  @units := amountSold as units  
						-- In order to get the correct ranking order a Subquery of each stores products sales in descending order is needed
						from  (	select product_ID, amountSold, store_ID, storeName 					 
									from sales inner join store on store.ID = sales.store_ID
									order by store_ID, amountSold desc) as top_items
		) as rankings inner join product on upc = product.ID
		-- Cap the ranking at the top 20 items
		where @cur_rank <= 20;");
		
		$prev_store = "";
		$prev_prod = "";
		$rank = 1;
		
		// $result = $conn-> query($sql);
		while($row = $result->fetch_assoc())
		{
			if ($prev_store == $row["store_ID"])
			$rank++;
			else 
			{
				// echo "</tbody>
				// </table>";
				// echo "<br>";
				echo (" </tbody>
				</table>
				<table class='table table-striped'>
				<h4> Top 20 Products for ". $row["Store"]. " ". $row["store_ID"]. "</h4>
				<thead-dark>
					<tr>
					  <th scope='col'>Rank</th>
					  <th scope='col'>Product</th>
					  <th scope='col'>Amount Sold</th>
					</tr>
				  </thead>
				  <tbody>");
					$rank = 1;
				}
				
			// echo  " <tr>"."<td>". $rank . "<td>" . $row["Product"] . "<td> " . $row["Units Sold"]  . " <td>" . " <tr>"; 
			echo "<tr><td>" . $rank . "</td><td>" . $row['Product'] . "</td><td>" . $row['Units Sold'] .  "</td></tr>";
			$prev_store = $row["store_ID"];
		}

		$conn-> close(); 
	}
?>


<!-- JS files--> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> 
<script src="js/bootstrap.min.js"></script> 
<script src="js/jquery.backstretch.min.js"></script> 
<script src="js/jquery.countdown.js"></script> 
<script type="text/javascript" src="js/jquery.subscribe.js"></script> 
<script src="js/main.js"></script>
</body>
</html>

