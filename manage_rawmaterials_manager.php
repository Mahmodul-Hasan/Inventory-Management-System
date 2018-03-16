<?php 
session_start();
if($_SESSION["mgr"] == "false"){
	header("location: Login.php");
}
require("db.php");
include("manager_side_bar.html");
$managerId = $_SESSION['manager_id'];

$result = getJSONFromDB("select raw_materials.material_id, raw_materials.material_name, vendor.vendor_name, raw_materials.available_stock, raw_materials.material_unit_price, raw_materials.production_date from raw_materials inner join vendor on raw_materials.vendor_id = vendor.vendor_id");
$result = json_decode($result, true);

$loadVendorsCB = getJSONFromDB("select * from vendor");
$loadVendorsCB = json_decode($loadVendorsCB, true);

if(isset($_GET["did"]))
{//deleting a item
	$id = $_GET["did"];
	deleteFromDB("delete from raw_materials where material_id = $id");
	header("Location: manage_rawmaterials_manager.php");
}
if(isset($_REQUEST["add_new_material"]))
{
	if(strlen((string)$_REQUEST["material_name"])!=0 && strlen((string)$_REQUEST["vendor_id"])!=0)
	{
		$name = $_REQUEST["material_name"];
		$vendorId = $_REQUEST["vendor_id"];
		$price = $_REQUEST["material_unit_price"];
		$stock = $_REQUEST["material_stock"];
		$pdate = date('Y-m-d');

		$idresult = getJSONFromDB("select max(material_id) as material_id from raw_materials");
		$idresult = json_decode($idresult, true);
		$id = $idresult[0]["material_id"];
		$id = $id + 1;
		insertIntoDB("insert into raw_materials VALUES ('$id', '$managerId', '$vendorId', '$name', '$price', '$stock', '$pdate')");
		header("Location: manage_rawmaterials_manager.php");		
	}
	else{
		header("Location: manage_rawmaterials_manager.php");
	}
}

if(isset($_REQUEST["update_material"]) )
{
	if(!isset($_REQUEST["item_id"]) || strlen((String)$_REQUEST["item_id"])==0)
	{
		header("Location: manage_rawmaterials_manager.php");
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
	header("Location: manage_rawmaterials_manager.php");

}
if(isset($_REQUEST["add_stock"])){

	if(!isset($_REQUEST["material_id"]) || strlen((String)$_REQUEST["material_id"])==0)
	{
		header("Location: manage_rawmaterials_manager.php");
	}
	$id = $_REQUEST["material_id"];
	$stock = $_REQUEST["material_stock"];
	updateIntoDB("update raw_materials set available_stock = available_stock + '$stock' where material_id = '$id'");
	header("Location: manage_rawmaterials_manager.php");
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
				<h2>List of Raw Materials</h2>
				<th>Material ID</th> <th>Material Name</th> <th> Vendor </th> <th>Unit Price</th><th>Item Stock</th><th>Received Date</th> <th>Delete</th>
				<?php 
					for($i=0;$i<sizeof($result);$i++){
						$id = $result[$i]["material_id"];
						$name = $result[$i]["material_name"];
						$vendor = $result[$i]["vendor_name"];
						$price = $result[$i]["material_unit_price"];
						$stock = $result[$i]["available_stock"];
						$pdate = $result[$i]["production_date"];
						echo "<tr>
							<td>$id</td>
							<td>$name</td>
							<td>$vendor</td>
							<td>$price</td>
							<td>$stock</td>
							<td>$pdate</td>
							<td><a href='manage_rawmaterials_manager.php?did=$id'>Delete</a></td>
						 </tr>";
					}
				 ?>
			</table>
		</div>
		<div class="right">
			<div>
				<form action="manage_rawmaterials_manager.php" method="POST">
					<table id="tbb">
						<h3>Add new Material</h3>

						<tr>
							<td>Material Name</td>
							<td><input type="text" name="material_name"></td>
						</tr>
						<tr>
							<td>vendor</td>
							<td>
								<select name="vendor_id">
									<?php for($i=0;$i<sizeof($loadVendorsCB);$i++){
										$cid = $loadVendorsCB[$i]["vendor_id"];
										$cname = $loadVendorsCB[$i]["vendor_name"]; ?>
										<option value="<?php echo "$cid"; ?>"> <?php echo "$cname"; ?> </option>
										<?php } ?>	
								</select>
							</td>
						</tr>
						<tr>
							<td>Price</td>
							<td><input type="number" name="material_unit_price"></td>
						</tr>
						<tr>
							<td>Stock</td>
							<td><input type="number" name="material_stock"></td>
						</tr>
						<tr>
							<td></td>
							<td> <input type="submit" name="add_new_material" value="Add Item"></td>
						</tr>
					</table>
				</form>
			</div>
			<div>
			<br>
				<form action="manage_rawmaterials_manager.php" method="POST">
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
				<form action="manage_rawmaterials_manager.php" method="POST">
					<table id="tbb">
						<h3>Add Stock</h3>
						<tr>
							<td>Enter ID</td>
							<td><input type="number" name="material_id"></td>
						</tr>
						<tr>
							<td>Add Stock</td>
							<td><input type="number" name="material_stock"></td>
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
