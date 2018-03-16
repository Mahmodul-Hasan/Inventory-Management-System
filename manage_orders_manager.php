<?php 
session_start();
if($_SESSION["mgr"] == "false"){
	header("location: Login.php");
}
require("db.php");
include("manager_side_bar.html");
$managerId = $_SESSION['manager_id'];

//Getting order info 
$result = getJSONFromDB("select orders.order_id, items.item_name, customer.customer_name, customer.customer_contact_no, orders.order_quantity, orders.order_date, orders.total_price from orders inner join items on orders.item_id = items.item_id INNER join customer on orders.customer_id = customer.customer_id");
$result = json_decode($result, true);

//Getting item info for populate combobox
$itemCombo = getJSONFromDB("select * from items");
$itemCombo = json_decode($itemCombo, true);


//deleting an order
if(isset($_GET["did"]))
{//deleting a customer
	$id = $_GET["did"];
	$order = getJSONFromDB("Select * from orders where order_id = $id");
	$order = json_decode($order, true);
	$itemId = $order[0]["item_id"];
	$quantity = $order[0]["order_quantity"];
	updateIntoDB("update items set item_stock = item_stock + $quantity where item_id = $itemId");
	deleteFromDB("delete from orders where order_id = $id");
	header("Location: manage_orders_manager.php");
}
if(isset($_REQUEST["create_new_order"]))
{
	if(strlen((string)$_REQUEST["item_id"])!=0 && strlen((string)$_REQUEST["order_quantity"])!=0 && strlen((string)$_REQUEST["customer_contact_no"])!=0)
	{
		$phn = $_REQUEST["customer_contact_no"];
		$itemId = $_REQUEST["item_id"];
		$quantity = $_REQUEST["order_quantity"];
		$orderDate = date('Y-m-d');

		// check available quantity is enough for order
		$itemList = getJSONFromDB("select * from items where item_id = $itemId");
		$itemList = json_decode($itemList, true);
		
		if($quantity < $itemList[0]["item_stock"]){
			header("Location: manage_orders_manager.php");
		}
		//calculate total price of ordered item
		$totalPrice = $quantity * $itemList[0]["item_price"];

		//check phn no is registered or not;
		$customerId = getJSONFromDB("select customer_id from customer where customer_contact_no = '$phn'");
		$customerId = json_decode($customerId, true);
		if(sizeof($customerId) > 0){
			$cid = $customerId[0]["customer_id"];
		}
		else{
			$id = getJSONFromDB("select max(customer_id) as customer_id from customer");
			$id = json_decode($id, true);
			$cid = $id[0]["customer_id"];
			$cid = $cid + 1;
			insertIntoDB("insert into customer values('$cid', '-', '$phn', '-')");
		}
		//Generating orderid
		$oid = getJSONFromDB("select max(order_id) as order_id from orders");
		$oid = json_decode($oid, true);
		$orderId = $oid[0]["order_id"];
		$orderId = $orderId + 1;

		insertIntoDB("insert into orders VALUES('$orderId', '$itemId', '$managerId', '$cid', '$quantity', '$orderDate', '$totalPrice')");

		// calculate and update new item quantity
		updateIntoDB("update items set item_stock = item_stock - $quantity where item_id = '$itemId'");

		header("Location: manage_orders_manager.php");		
	}
	else{
		header("Location: manage_orders_manager.php");
	}
	
}

?>

<!DOCTYPE html>
<html>
<head>
	<style>
		#bd{
			margin-left: 220px;
		}
		.left{
			width: 800px;
			float: left;
		}
		.right{
			width: 400px;
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
			<table id="tbb">
				<h2>List of Orders</h2>
				<th>Order ID</th> <th>Item Name</th> <th> Customer Name(Contact) </th> <th>Order Quantity</th><th>Order Date</th><th>Total Price</th><th>Delete</th> 
				<?php 
					for($i=0;$i<sizeof($result);$i++){
						$id = $result[$i]["order_id"];
						$itemName = $result[$i]["item_name"];
						$customerName = $result[$i]["customer_name"];
						$quantity = $result[$i]["order_quantity"];
						$date = date('Y-m-d');
						$contact = $result[$i]["customer_contact_no"];
						$totalPrice = $result[$i]["total_price"];
						echo "<tr>
							<td>$id</td>
							<td>$itemName</td>
							<td>$customerName($contact)</td>
							<td>$quantity</td>
							<td>$date</td>
							<td>$totalPrice</td>
							<td><a href='manage_orders_manager.php?did=$id'>Delete</a></td>
						 </tr>";
					}
				 ?>
			</table>
		</div>
		<div class="right">
			<div>
				<form action="manage_orders_manager.php" method="POST">
					<table id="tbb">
						<h3>Create New Order</h3>

						<tr>
							<td>Select Item</td>
							<td>
								<select name="item_id">
								<?php for($i=0;$i<sizeof($itemCombo);$i++){
										$itemid = $itemCombo[$i]["item_id"];
										$itemname = $itemCombo[$i]["item_name"]; ?>
										<option value="<?php echo "$itemid"; ?>"> <?php echo "$itemname($itemid)"; ?> </option>
										<?php } ?>
								</select>
							</td>
						</tr>
						<tr>
							<td>Order Quantity</td>
							<td><input type="number" name="order_quantity"></td>
						</tr>
						<tr>
							<td>Customer Contact</td>
							<td><input type="text" name="customer_contact_no"></td>
						</tr>
						<tr>
							<td></td>
							<td> <input type="submit" name="create_new_order" value="Create Order"></td>
						</tr>
					</table>
				</form>
			</div>
		</div>
	</div>
</body>
</html>

