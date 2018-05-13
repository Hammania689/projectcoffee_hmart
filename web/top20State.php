
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

		echo "<h3> Note not every store has 20 transactions. Not every State is Included </h3> ";
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
					echo (" </tbody>
				</table>
				<table class='table table-striped'>
				<h4> Top 20 Products for ". $row["State"]. "</h4>
				<thead-dark>
					<tr>
					  <th scope='col'>Rank</th>
					  <th scope='col'>Product</th>
					  <th scope='col'>Amount Sold</th>
					  <th scope='col'>Store</th>
					</tr>
				  </thead>
				  <tbody>");
					
					$rank = 1;
				}
			
			if ($rank <= 20)
			{
				echo "<tr><td>" . $rank . "</td><td>" . $row['Product'] . "</td><td>" . $row['Units Sold'] .  "</td><td>" . $row['Store'] .  "</td></tr>";
			}
				// echo $rank . ".) " . $row["Product"] . " " . $row["Units Sold"]  . " ".  . $row["Units Sold"]  ." <br>";
				 
			$prev_state = $row["State"];
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

