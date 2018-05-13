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
		$result = $conn->query("SELECT storeName as Store, sum(amountSold) as 'Total Sales', store_ID
        from sales inner join store on store.ID = sales.store_ID
        group by store_ID -- Allows the aggreate function sum based on each store to occur
        order by sum(amountSold) desc -- Order the results from largest to smallest
        limit 5");
		
		//-- Cap the ranking at the top 20 items
		
		$prev_store = "";
		$rank = 1;


		echo "</table>
				<table class='table table-striped'>
				<h3> Top 5 Stores</h3>
				<thead-dark>
					<tr>
					  <th scope='col'>Rank</th>
					  <th scope='col'>Store</th>
					  <th scope='col'>ID</th>
					  <th scope='col'>Amount Sold</th>
					</tr>
				  </thead>
				  <tbody>";
        
		// $result = $conn-> query($sql);
		while($row = $result->fetch_assoc())
		{
            // echo  $row["Store"] . "                ||" . $row["store_ID"] . " ||" .  $row["Total Sales"] ." <br>"; 
			echo "<tr><td>" . $rank . "</td><td>" . $row['Store'] . "</td><td>" . $row['store_ID'] .  "</td><td>" . $row['Total Sales'] .  "</td></tr>";
			
			$rank++;
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
