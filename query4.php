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
		$result = $conn->query("SELECT storeName as StoreName, productType as Type, MAX(amountSold) as Sold
		FROM sales 	INNER JOIN product ON sales.product_ID = product.ID
					INNER JOIN store   ON sales.store_ID = store.ID
		WHERE productType = \"'Cup'\" OR productType = \"'Bowl'\" OR productType = \"Outdoor\" OR productType = \"Living Room\" 
		OR productType = 'Foundation' OR productType = 'Moisterizer'
		GROUP BY store.ID
		ORDER BY productType;");

	  $prev_type = "";

      if($result->num_rows > 0) 
	  {
		  while($row = $result->fetch_assoc())
		  {
			  
			  if($prev_type != $row["Type"])
				{ 
					echo "<br>";
					echo "Products of Type :" . $row["Type"];
					echo "<br>";
				}
			  
			  $prev_type = $row["Type"];
			  echo  $row["StoreName"] . " " . $row["Type"] . " " . $row["Sold"] ."<br>"; 
		  }		
	  }
	  else
	  {
		  echo "There is no Data Found";
	  }
		
		$conn-> close(); 
	}
?>
