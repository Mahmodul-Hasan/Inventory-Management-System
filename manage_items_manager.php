<?php 
session_start();
if($_SESSION["mgr"] == "false"){
	header("location: Login.php");
}
require("db.php");
include("manager_side_bar.html");

$result = getJSONFromDB("select items.item_id, items.item_name, categories.category_name, items.item_price, items.item_stock, items.production_date from items inner join categories on items.category_id = categories.category_id");
$result = json_decode($result, true);

$loadCategoriesCB = getJSONFromDB("select * from categories");
$loadCategoriesCB = json_decode($loadCategoriesCB, true);

if(isset($_GET["did"]))
{//deleting a item
	$id = $_GET["did"];
	deleteFromDB("delete from items where item_id = $id");
	header("Location: manage_items_manager.php");
}
if(isset($_REQUEST["add_new_item"]))
{
	if(strlen((string)$_REQUEST["item_name"])!=0 && strlen((string)$_REQUEST["category_id"])!=0)
	{
		$name = $_REQUEST["item_name"];
		$categoryId = $_REQUEST["category_id"];
		$price = $_REQUEST["item_price"];
		$stock = $_REQUEST["item_stock"];
		$pdate = date('Y-m-d');

		$idresult = getJSONFromDB("select max(item_id) as item_id from items");
		$idresult = json_decode($idresult, true);
		$id = $idresult[0]["item_id"];
		$id = $id + 1;
		insertIntoDB("insert into items VALUES ('$id', '$name', '$categoryId', '$price', '$stock', '$pdate')");
		header("Location: manage_items_manager.php");		
	}
	else{
		header("Location: manage_items_manager.php");
	}
}

if(isset($_REQUEST["update_item"]) )
{
	if(!isset($_REQUEST["item_id"]) || strlen((String)$_REQUEST["item_id"])==0)
	{
		header("Location: manage_items_manager.php");
	}
	$id = $_REQUEST["item_id"];
	$result = getJSONFromDB("select * from items where item_id = $id");
	$result = json_decode($result, true);
	if(isset($_REQUEST["item_name"]) && strlen((String)$_REQUEST["item_name"])!=0)
	{
		$name = $_REQUEST["item_name"];
	}
	else{
		$name = $result[0]["item_name"];
	}
	if(isset($_REQUEST["item_price"]) && strlen($_REQUEST["item_price"])!=0)
	{
		$price = $_REQUEST["item_price"];
	}
	else{
		$price = $result[0]["item_price"];
	}
	if(isset($_REQUEST["item_stock"]) && strlen($_REQUEST["item_stock"])!=0)
	{
		$stock = $_REQUEST["item_stock"];
	}
	else{
		$stock = $result[0]["item_stock"];
	}
	updateIntoDB("update items set item_name = '$name', item_price = '$price', item_stock = '$stock' where item_id = '$id'");
	header("Location: manage_items_manager.php");

}
if(isset($_REQUEST["add_stock"])){

	if(!isset($_REQUEST["item_id"]) || strlen((String)$_REQUEST["item_id"])==0)
	{
		header("Location: manage_items_manager.php");
	}
	$id = $_REQUEST["item_id"];
	$stock = $_REQUEST["item_stock"];
	updateIntoDB("update items set item_stock = item_stock + '$stock' where item_id = '$id'");
	header("Location: manage_items_manager.php");
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
			width: 700px;
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
				<h2>List of Items</h2>
				<th>Item ID</th> <th>Item Name</th> <th> Category </th> <th>Unit Price</th><th>Item Stock</th>
				<th>Production Date</th><th>Delete</th>
				<?php 
					for($i=0;$i<sizeof($result);$i++){
						$id = $result[$i]["item_id"];
						$name = $result[$i]["item_name"];
						$category = $result[$i]["category_name"];
						$price = $result[$i]["item_price"];
						$stock = $result[$i]["item_stock"];
						$pdate = $result[$i]["production_date"];
						echo "<tr>
							<td>$id</td>
							<td>$name</td>
							<td>$category</td>
							<td>$price</td>
							<td>$stock</td>
							<td>$pdate</td>
							<td><a href='manage_items_manager.php?did=$id'>Delete</a></td>
						 </tr>";
					}
				 ?>
			</table>
		</div>
		<div class="right">
			<div>
				<form action="manage_items_manager.php" method="POST">
					<table id="tbb">
						<h3>Add new Item</h3>

						<tr>
							<td>Item Name</td>
							<td><input type="text" name="item_name"></td>
						</tr>
						<tr>
							<td>Category</td>
							<td>
								<select name="category_id">
									<?php for($i=0;$i<sizeof($loadCategoriesCB);$i++){
										$cid = $loadCategoriesCB[$i]["category_id"];
										$cname = $loadCategoriesCB[$i]["category_name"]; ?>
										<option value="<?php echo "$cid"; ?>"> <?php echo "$cname"; ?> </option>
										<?php } ?>	
								</select>
							</td>
						</tr>
						<tr>
							<td>Price</td>
							<td><input type="number" name="item_price"></td>
						</tr>
						<tr>
							<td>Stock</td>
							<td><input type="number" name="item_stock"></td>
						</tr>
						<tr>
							<td></td>
							<td> <input type="submit" name="add_new_item" value="Add Item"></td>
						</tr>
					</table>
				</form>
			</div>
			<div>
			<br>
				<form action="manage_items_manager.php" method="POST">
					<table id="tbb">
						<h3>Update Item</h3>
						<tr>
							<td>Enter ID</td>
							<td><input type="number" name="item_id"></td>
						</tr>
						<tr>
							<td>Enter New Name</td>
							<td><input type="text" name="item_name"></td>
						</tr>
						<tr>
							<td>New price</td>
							<td><input type="number" name="item_price"></td>
						</tr>
						<tr>
							<td>New Stock</td>
							<td><input type="number" name="item_stock"></td>
						</tr>

						<tr>
							<td></td>
							<td> <input type="submit" name="update_item" value="Update Item"></td>
						</tr>
					</table>
				</form>
			</div>
			<div>
			<br>
				<form action="manage_items_manager.php" method="POST">
					<table id="tbb">
						<h3>Add Stock</h3>
						<tr>
							<td>Enter ID</td>
							<td><input type="number" name="item_id"></td>
						</tr>
						<tr>
							<td>Add Stock</td>
							<td><input type="number" name="item_stock"></td>
						</tr>
						<tr>
							<td></td>
							<td> <input type="submit" name="add_stock" value="Add Stock"></td>
						</tr>
					</table>
				</form>
			</div>
		</div>
	</div>
</body>
</html>

