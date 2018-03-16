<?php 
//session_start();
session_start();
if($_SESSION["admin"] == "false"){
	header("location: Login.php");
}
require("db.php");
include("admin_side_bar.html");
$result = getJSONFromDB("select items.item_id, items.item_name, categories.category_name, items.item_price, items.item_stock, items.production_date from items INNER JOIN categories on items.category_id = categories.category_id");
$result = json_decode($result, true);
?>

<!DOCTYPE html>
<html>
<head>
	<style>
		#bd{
			margin-left: 250px;
		}

		#tbb{
			border-collapse: collapse;
		}
		#tbb th{
			text-align: left;
			background-color: #3a6070;
			color: #FFF;
			padding: 4px 30px 4px 8px;
		}
		#tbb td{
			border : 1px solid #e3e3e3;
			padding: 4px 8px;
		}
		
	</style>
</head>
<body>
	
	<br><br>
	<div id="bd">
		<div class = "left">
			<table id="tbb">
			<h2>List of Items</h2>
				<th>Item ID</th> <th>Name</th> <th> Category </th> <th> Price </th> <th>Stock </th> <th>Production Date </th> 
				<?php 
					for($i=0;$i<sizeof($result);$i++){
						$id = $result[$i]["item_id"];
						$item_name = $result[$i]["item_name"];
						$category = $result[$i]["category_name"];
						$price = $result[$i]["item_price"];
						$stock = $result[$i]["item_stock"];
						$date = $result[$i]["production_date"];
						echo "<tr>
							<td>$id</td>
							<td>$item_name</td>
							<td>$category</td>
							<td>$price</td>
							<td>$stock</td>
							<td>$date</td>
						 </tr>";
					}
				 ?>
			</table>
		</div>

	</div>
</body>
</html>

