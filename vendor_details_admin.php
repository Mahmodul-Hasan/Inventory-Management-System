<?php 
session_start();
if($_SESSION["admin"] == "false"){
	header("location: Login.php");
}
require("db.php");
include("admin_side_bar.html");
$result = getJSONFromDB("select * from vendor");
$result = json_decode($result, true);

if(isset($_GET["did"]))
{//deleting a customer
	$id = $_GET["did"];
	deleteFromDB("delete from vendor where vendor_id = $id");
	header("Location: vendor_details_admin.php");
}
if(isset($_REQUEST["create_new_vendor"]))
{
	if(strlen((string)$_REQUEST["vnd_name"])!=0)
	{
		$name = $_REQUEST["vnd_name"];
		$contact = $_REQUEST["vnd_contact_no"];
		$email = $_REQUEST["vnd_email"];
		$address = $_REQUEST["vnd_address"];

		$idresult = getJSONFromDB("select max(vendor_id) as vendor_id from vendor");
		$idresult = json_decode($idresult, true);
		$id = $idresult[0]["vendor_id"];
		$id = $id + 1;
		insertIntoDB("insert into vendor values ('$id', '$name', '$contact', '$email', '$address')");

		header("Location: vendor_details_admin.php");		
	}
	else{
		header("Location: vendor_details_admin.php");
	}
	
}
if(isset($_REQUEST["update_vendor"]) )
{
	if(!isset($_REQUEST["vnd_id"]) || strlen((String)$_REQUEST["vnd_id"])==0)
	{
		header("Location: vendor_details_admin.php");
	}
	$id = $_REQUEST["vnd_id"];
	$result = getJSONFromDB("select * from vendor where vendor_id = $id");
	$result = json_decode($result, true);
	if(isset($_REQUEST["vnd_name"]) && strlen((String)$_REQUEST["vnd_name"])!=0)
	{
		$name = $_REQUEST["vnd_name"];
	}
	else{
		$name = $result[0]["vendor_name"];
	}
	if(isset($_REQUEST["vnd_contact_no"]) && strlen($_REQUEST["vnd_contact_no"])!=0)
	{
		$contact = $_REQUEST["vnd_contact_no"];
	}
	else{
		$contact = $result[0]["vendor_contact_no"];
	}
	if(isset($_REQUEST["vnd_email"]) && strlen($_REQUEST["vnd_email"])!=0)
	{
		$email = $_REQUEST["vnd_email"];
	}
	else{
		$email = $result[0]["vendor_email"];
	}
	if(isset($_REQUEST["vnd_address"]) && strlen($_REQUEST["vnd_address"])!=0)
	{
		$address = $_REQUEST["vnd_address"];
	}
	else{
		$address = $result[0]["vendor_address"];
	}
	updateIntoDB("update vendor set vendor_name = '$name', vendor_contact_no = '$contact', 
		vendor_email = '$email', vendor_address = '$address' where vendor_id = $id");
	header("Location: vendor_details_admin.php");

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
			width: 600px;
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
				<th>Vendor ID</th> <th>Name</th> <th> Contact</th> <th> Email </th> <th>Address</th> <th>Delete</th>
				<?php 
					for($i=0;$i<sizeof($result);$i++){
						$id = $result[$i]["vendor_id"];
						$name = $result[$i]["vendor_name"];
						$address = $result[$i]["vendor_address"];
						$email = $result[$i]["vendor_email"];
						$contact = $result[$i]["vendor_contact_no"];
						echo "<tr>
							<td>$id</td>
							<td>$name</td>
							<td>$contact</td>
							<td>$email</td>
							<td>$address</td>
							<td><a href='vendor_details_admin.php?did=$id'>Delete</a></td>
						 </tr>";
					}
				 ?>
			</table>
		</div>
		<div class="right">
			<form action="vendor_details_admin.php" method="POST">
				<table id="tbb">
					<tr>
						<th>Add new Vendor</th>
					</tr>

					<tr>
						<td>Name</td>
						<td><input type="text" name="vnd_name"></td>
					</tr>
					<tr>
						<td>Address</td>
						<td><input type="text" name="vnd_address"></td>
					</tr>
					<tr>
						<td>Email</td>
						<td><input type="text" name="vnd_email"></td>
					</tr>
					<tr>
						<td>Contact No</td>
						<td><input type="text" name="vnd_contact_no"></td>
					</tr>
					<tr>
						<td></td>
						<td> <input type="submit" name="create_new_vendor" value="Add Vendor"></td>
					</tr>
				</table>
			</form>
		</div>
		<div class="right">
		<br><br>
			<form action="vendor_details_admin.php" method="POST">
				<table id="tbb">
					<tr>
						<th>Update</th>
					</tr>
					<tr>
						<td>Enter ID</td>
						<td><input type="number" name="vnd_id"></td>
					</tr>
					<tr>
						<td>New Address</td>
						<td><input type="text" name="vnd_address"></td>
					</tr>
					<tr>
						<td>New Email</td>
						<td><input type="text" name="vnd_email"></td>
					</tr>
					<tr>
						<td>New Contact No</td>
						<td><input type="text" name="vnd_contact_no"></td>
					</tr>

					<tr>
						<td></td>
						<td> <input type="submit" name="update_vendor" value="Update Vendor"></td>
					</tr>
				</table>
			</form>
		</div>
	</div>
</body>
</html>

