<?php 
session_start();
if($_SESSION["admin"] == "false"){
	header("location: Login.php");
}
require("db.php");
include("admin_side_bar.html");
$result = getJSONFromDB("select * from categories");
$result = json_decode($result, true);

if(isset($_GET["did"]))
{
	$id = $_GET["did"];
	deleteFromDB("delete from categories where category_id = $id");
	header("Location: view_categories_admin.php");
}
if(isset($_REQUEST["create_new_category"]))
{
	$category_name = $_REQUEST["category_name"];
	insertIntoDB("insert into categories values('Null', '$category_name')");
	header("Location: view_categories_admin.php");	
}
if(isset($_REQUEST["update_category"]))
{
	$id = $_REQUEST["idnum"];
	$newName = $_REQUEST["new_cat_name"];
	updateIntoDB("update categories set category_name = '$newName' where category_id = $id");
	header("Location: view_categories_admin.php");
}
?>

<!DOCTYPE html>
<html>
<head>
	<style>
		
		#bd{
			margin-left: 300px;
		}
		.left{
			width: 50%;
			float: left;
		}
		.right{
			width: 50%;
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
	</style>
</head>
<body>
	<br><br>
	<div id="bd">
		<div class="left">
			<table id="tbb">
			<h2>List of Categories</h2>
				<th>Category ID</th> <th>Categroy Name</th>  <th>Delete</th>
				<?php 
					for($i=0;$i<sizeof($result);$i++){
						$cid = $result[$i]["category_id"];
						$cname = $result[$i]["category_name"];
						echo "<tr>
							<td>$cid</td>
							<td>$cname</td>
							<td><a href='view_categories_admin.php?did=$cid'>Delete</a></td>
						 </tr>";
					}
				 ?>
			</table>
		</div>
		<div class="right">
			<div>
			<form action="view_categories_admin.php" method="POST">
				<table id="tbb">
					<h2>Create new Category</h2>

					<tr>
						<td>Insert Category Name</td>
						<td><input type="text" name="category_name"></td>
					</tr>
					<tr>
						<td></td>
						<td> <input type="submit" name="create_new_category" value="Create New"></td>
					</tr>
				</table>
			</form action="view_categories_admin.php" method="POST">
		</div>
		<br><br>
		<div>
			<form>
				<br><br>
				<table id="tbb">
					<h2>Update Category</h2>
					<tr>
						<td>Insert Id</td>
						<td><input type="number" name="idnum"></td>
					</tr>
					<tr>
						<td>Insert Updated Name</td>
						<td><input type="text" name="new_cat_name"></td>
					</tr>
					<tr>
						<td></td>
						<td> <input type="submit" name="update_category" value="Update"></td>
					</tr>
				</table>
			</form>
		</div>
		</div>
	</div>
</body>
</html>
