<?php 
session_start();
if($_SESSION["admin"] == "false"){
	header("location: Login.php");
}
require("db.php");
include("admin_side_bar.html");
$result = getJSONFromDB("select raw_materials.material_id, raw_materials.material_name, vendor.vendor_name, manager.manager_name, raw_materials.available_stock, raw_materials.material_unit_price FROM raw_materials INNER JOIN vendor on raw_materials.vendor_id = vendor.vendor_id INNER JOIN manager ON raw_materials.manager_id = manager.manager_id");
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
			<h2>List of Raw Materials</h2>
				<th>Material ID</th> <th>Material Name</th> <th> Vendor Name </th> <th> Manager Name </th> <th>Stock </th> <th>Unit Price </th> 
				<?php 
					for($i=0;$i<sizeof($result);$i++){
						$id = $result[$i]["material_id"];
						$material_name = $result[$i]["material_name"];
						$vendor = $result[$i]["vendor_name"];
						$manager = $result[$i]["manager_name"];
						$stock = $result[$i]["available_stock"];
						$price = $result[$i]["material_unit_price"];
						echo "<tr>
							<td>$id</td>
							<td>$material_name</td>
							<td>$vendor</td>
							<td>$manager</td>
							<td>$stock</td>
							<td>$price</td>
						 </tr>";
					}
				 ?>
			</table>
		</div>

	</div>
</body>
</html>

