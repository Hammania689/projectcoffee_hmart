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

		echo "<h1> Note not every store has 20 transactions. Not every State is Included </h1> ";
		echo "<br>";

		$result = $conn->query("SELECT @cur_rank, productName as Product, units as 'Units Sold', storeState as State, store_ID as Store
		from (SELECT product_ID as upc, amountSold as units_sold, store_ID, storeState,  @cur_rank := IF(@cur_state = storeState, @cur_rank + 1, 1) , 
              @cur_state := storeState,@units := amountSold as units
			  from  (	select product_ID, amountSold, store_ID, storeState
							from sales inner join store on store.ID = sales.store_ID
							order by storeState, amountSold desc) as top_items) as rankings inner join product on upc = product.ID  where @cur_rank <= 20");
		
		//-- Cap the ranking at the top 20 items
		
		$prev_state = "";
		$prev_prod = "";
		$rank = 1;

		// $result = $conn-> query($sql);
		while($row = $result->fetch_assoc())
		{
			if ($prev_state == $row["State"])
				{
					$rank++;

				}
			else 
				{
					echo "<br>";
					echo "Top 20 for ". $row["State"];
					echo "<br>";
					
					$rank = 1;
				}
			
			if ($rank <= 20)
				echo $rank . ".) " . $row["Product"] . " " . $row["Units Sold"]  . " ". " <br>"; 
			$prev_state = $row["State"];
		}
		
		$conn-> close(); 
	}
?>
