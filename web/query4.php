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

					echo "</table>
				<table class='table table-striped'>
				<h3> 
				Products of Type :" . $row["Type"] . " </h3>
				<thead-dark>
					<tr>
					  <th scope='col'>Store</th>
					  <th scope='col'>Product Type</th>
					  <th scope='col'>Amount Sold</th>
					</tr>
				  </thead>
				  <tbody>";
				}
			  
			  $prev_type = $row["Type"];
			echo "<tr><td>"  . $row['StoreName'] . "</td><td>" . $row['Type'] .  "</td><td>" . $row['Sold'] .  "</td></tr>";
			  
			//   echo  $row["StoreName"] . " " . $row["Type"] . " " . $row["Sold"] ."<br>"; 
		  }		
	  }
	  else
	  {
		  echo "There is no Data Found";
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
