<?php 
session_start();
if($_SESSION["admin"] == "false"){
	header("location: Login.php");
}
require("db.php");

include("admin_side_bar.html");
$mostOrderMadeBy = getJSONFromDB("select customer_contact_no,customer_name from customer WHERE customer_id = (select customer_id from orders having MAX(order_id))");
$mostOrderMadeBy = json_decode($mostOrderMadeBy, true);
$mostOrderedItem = getJSONFromDB("select item_id,item_name from items WHERE item_id = (select item_id from orders having MAX(order_id))");
$mostOrderedItem = json_decode($mostOrderedItem, true);
$totalOrders = getJSONFromDB("select count(order_id) as total_order from orders");
$totalOrders = json_decode($totalOrders, true);
$totalItemsInInventory = getJSONFromDB("select COUNT(item_id) as total_items from items where item_stock > 0");
$totalItemsInInventory = json_decode($totalItemsInInventory, true);

$totalExpenses = getJSONFromDB("select month, (house_rent + electricity_bill + others) as total_expense from monthly_expense group by month");
$totalExpenses = json_decode($totalExpenses, true);
?>

<!DOCTYPE html>
<html>
<head>
	<style>
		#bd{
			margin-left: 250px;
		}
		.left{
			width: 600px;
			float: left;
		}
		.right{
			width: 600px;
			float: right;
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
		#cd{
			margin-left: 300px;
		}
	</style>
</head>
<body>
	
	<br><br>
	<div id="bd">
		<div class = "left">
			<h1> Monthly Report</h1>
			<table id="tbb">
				<th>Option</th> <th>Name/Quantity</th> 
				<?php 
					$most_order_made_by = $mostOrderMadeBy[0]["customer_name"]."(".$mostOrderMadeBy[0]["customer_contact_no"].")";
					$most_ordered_item = $mostOrderedItem[0]["item_name"]."(".$mostOrderedItem[0]["item_id"].")";
					$total_orders = $totalOrders[0]["total_order"];
					$total_item_in_inventory = $totalItemsInInventory[0]["total_items"];
					echo "<tr>
						<td>Most Order Made By</td>
						<td>$most_order_made_by</td>
						</tr>
						<tr>
						<td>Most Ordered Item</td>
						<td>$most_ordered_item</td>
						</tr>
						<tr>
						<td>Total Orders</td>
						<td>$total_orders</td>
						<tr>
						<td>Total Sold Items</td>
						<td>$total_item_in_inventory</td>
					</tr>";
				 ?>
			</table>
		</div>
		<div class="right">
			<h1> Other Expenses</h1>
			<table id="tbb">
				<th>Month</th> <th>Total Expenses</th> 
				<?php 
					for($i=0;$i<sizeof($totalExpenses);$i++){
						$month = $totalExpenses[$i]["month"];
						$te = $totalExpenses[$i]["total_expense"];
						echo "<tr>
						<td>$month</td>
						<td>$te</td>
					    </tr>";
					}
				?>
			</table>
		</div>
	</div>
</body>
</html>

