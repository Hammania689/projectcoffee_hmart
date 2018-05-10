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
		$result = $conn->query("SELECT storeName as Store, sum(amountSold) as 'Total Sales', store_ID
        from sales inner join store on store.ID = sales.store_ID
        group by store_ID -- Allows the aggreate function sum based on each store to occur
        order by sum(amountSold) desc -- Order the results from largest to smallest
        limit 5");
		
		//-- Cap the ranking at the top 20 items
		
		$prev_store = "";
		$rank = 1;

        echo "<br>";
        echo "Top 5 Stores ";
        echo "<br>";
        
        echo "Store Name  || Store ID || Total Sales ";
        echo "<br>";
        
		// $result = $conn-> query($sql);
		while($row = $result->fetch_assoc())
		{
            echo  $row["Store"] . "                ||" . $row["store_ID"] . " ||" .  $row["Total Sales"] ." <br>"; 
            $rank++;
		}
		
		$conn-> close(); 
	}
?>

