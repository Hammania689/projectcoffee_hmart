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

		echo "</table>
				<table class='table table-striped'>
				<h3>  Top 3 types of product that customers buy</h3>
				<thead-dark>
					<tr>
					  <th scope='col'>Type</th>
					  <th scope='col'>Amount Sold</th>
					</tr>
				  </thead>
				  <tbody>";
		  while($row = $result->fetch_assoc())
		  {
			  
			//   if($prev_type != $row["Type"])
			// 	{ 
			// 		echo "<br>";
			// 		echo "Products of Type :" . $row["Type"];
			// 		echo "<br>";
            //     }
                
			  
			//   $prev_type = $row["Type"];
			echo "<tr><td>"  . $row['Type'] . "</td><td>" . $row['Sold'] .  "</td></tr>";

            //   echo $rank. ".)" . " " . $row["Type"] . " " . $row["Sold"]. " Units" ."<br>"; 
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



<!-- JS files--> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> 
<script src="js/bootstrap.min.js"></script> 
<script src="js/jquery.backstretch.min.js"></script> 
<script src="js/jquery.countdown.js"></script> 
<script type="text/javascript" src="js/jquery.subscribe.js"></script> 
<script src="js/main.js"></script>
</body>
</html>
