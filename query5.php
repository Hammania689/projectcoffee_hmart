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
		$result = $conn->query("SELECT productType as Type, productName as ProductName, amountSold as Sold
        FROM product INNER JOIN sales ON product.ID = sales.product_ID
        WHERE productType != \"Bedroom\"
        GROUP BY productType
        ORDER BY MAX(amountSold) DESC
        LIMIT 3;");


	  $prev_type = "";
      $rank = 1;

      if($result->num_rows > 0) 
	  {
		  while($row = $result->fetch_assoc())
		  {
			  
			//   if($prev_type != $row["Type"])
			// 	{ 
			// 		echo "<br>";
			// 		echo "Products of Type :" . $row["Type"];
			// 		echo "<br>";
            //     }
                
			  
			//   $prev_type = $row["Type"];

              echo $rank. ".)" . " " . $row["Type"] . " " . $row["Sold"]. " Units" ."<br>"; 
              $rank++;
		  }		
	  }
	  else
	  {
		  echo "There is no Data Found";
	  }
		
		$conn-> close(); 
	}
?>


