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
					echo "<br>";
					echo "Top 20 for ". $row["Store"]. " ". $row["store_ID"];
					echo "<br>";
					
					$rank = 1;
				}

			echo $rank . ".) " . $row["Product"] . " " . $row["Units Sold"]  . " " . $row["Store"] ." <br>"; 
			$prev_store = $row["store_ID"];
		}

		$conn-> close(); 
	}
?>
