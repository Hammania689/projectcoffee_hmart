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
		$result = $conn->query("SELECT storeName as 'Store Name', store.ID as 'StoreID', productName as 'Product Name', productType as 'Type', amountSold as 'Sold'

        from sales inner join product on sales.product_ID = product.ID
                    inner join store on sales.store_ID = store.ID
        GROUP BY store.ID
        ORDER BY store.ID
        where productType = 'Cup';
        ");
        //-- where (productType = "Foundation" or productType = "Moisterizer" or productType = "'Cup'" or  or productType = "'Bowl'"  or productType = "Kitchen"  or productType = "Bathroom")  
		
		//-- Cap the ranking at the top 20 items
		

		// $result = $conn-> query($sql);
		while($row = $result->fetch_assoc())
		{

            if ($prev_store == $row["store_ID"])
                $rank++;
            else 
            {
                    echo "<br>";
                    echo "Top 20 for ". $row["Store Name"]. " with ID ". $row["StoreID"];
                    echo "<br>";
                    
                    $rank = 1;
            }

				
			
            echo $rank . ".) " . $row["Product Name"] . " " . $row["Units Sold"]  . " " . $row["Store Name"] . " \t ". $row["StoreID"] ." <br>"; 
			$prev_state = $row["State"];
		}
		
		$conn-> close(); 
	}
?>
