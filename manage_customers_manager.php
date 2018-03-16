<?php 
session_start();
if($_SESSION["mgr"] == "false"){
	header("location: Login.php");
}
require("db.php");
include("manager_side_bar.html");
$result = getJSONFromDB("select * from customer");
$result = json_decode($result, true);

if(isset($_GET["did"]))
{//deleting a customer
	$id = $_GET["did"];
	deleteFromDB("delete from customer where customer_id = $id");
	header("Location: manage_customers_manager.php");
}
if(isset($_REQUEST["create_new_customer"]))
{
	if(strlen((string)$_REQUEST["customer_name"])!=0)
	{
		$name = $_REQUEST["customer_name"];
		$contact = $_REQUEST["customer_contact_no"];
		$email = $_REQUEST["customer_email"];

		$idresult = getJSONFromDB("select max(customer_id) as customer_id from customer");
		$idresult = json_decode($idresult, true);
		$id = $idresult[0]["customer_id"];
		$id = $id + 1;
		insertIntoDB("insert into customer values($id, '$name', '$contact', '$email')");
		header("Location: manage_customers_manager.php");		
	}
	else{
		header("Location: manage_customers_manager.php");
	}
	
}
if(isset($_REQUEST["update_customer"]) )
{
	if(!isset($_REQUEST["customer_id"]) || strlen((String)$_REQUEST["customer_id"])==0)
	{
		header("Location: manage_customers_manager.php");
	}
	$id = $_REQUEST["customer_id"];
	$result = getJSONFromDB("select * from customer where customer_id = $id");
	$result = json_decode($result, true);
	if(isset($_REQUEST["customer_name"]) && strlen((String)$_REQUEST["customer_name"])!=0)
	{
		$name = $_REQUEST["customer_name"];
	}
	else{
		$name = $result[0]["customer_name"];
	}
	if(isset($_REQUEST["customer_contact_no"]) && strlen($_REQUEST["customer_contact_no"])!=0)
	{
		$contact = $_REQUEST["customer_contact_no"];
	}
	else{
		$contact = $result[0]["customer_contact_no"];
	}
	if(isset($_REQUEST["customer_email"]) && strlen($_REQUEST["customer_email"])!=0)
	{
		$email = $_REQUEST["customer_email"];
	}
	else{
		$email = $result[0]["customer_email"];
	}
	updateIntoDB("update customer set customer_name = '$name', customer_contact_no = '$contact', 
		customer_email = '$email' where customer_id = $id");
	header("Location: manage_customers_manager.php");

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
				<h2>List of Customers</h2>
				<th>Customer ID</th> <th>Name</th> <th> Contact NO </th> <th>Email</th><th>Delete</th>
				<?php 
					for($i=0;$i<sizeof($result);$i++){
						$id = $result[$i]["customer_id"];
						$name = $result[$i]["customer_name"];
						$contact = $result[$i]["customer_contact_no"];
						$email = $result[$i]["customer_email"];
						echo "<tr>
							<td>$id</td>
							<td>$name</td>
							<td>$contact</td>
							<td>$email</td>
							<td><a href='manage_customers_manager.php?did=$id'>Delete</a></td>
						 </tr>";
					}
				 ?>
			</table>
		</div>
		<div class="right">
			<div>
				<form action="manage_customers_manager.php" method="POST">
					<table id="tbb">
						<h3>Create New Customer</h3>

						<tr>
							<td>Name</td>
							<td><input type="text" name="customer_name"></td>
						</tr>
						<tr>
							<td>Contact No</td>
							<td><input type="text" name="customer_contact_no"></td>
						</tr>
						<tr>
							<td>Email</td>
							<td><input type="text" name="customer_email"></td>
						</tr>
						<tr>
							<td></td>
							<td> <input type="submit" name="create_new_customer" value="Add Customer"></td>
						</tr>
					</table>
				</form>
			</div>
			<div>
			<br><br>
				<form action="manage_customers_manager.php" method="POST">
					<table id="tbb">
						<h3>Update Customer Info</h3>
						<tr>
							<td>Enter ID</td>
							<td><input type="number" name="customer_id"></td>
						</tr>
						<tr>
							<td>Enter New Name</td>
							<td><input type="text" name="customer_name"></td>
						</tr>
						<tr>
							<td>New Email</td>
							<td><input type="text" name="customer_email"></td>
						</tr>
						<tr>
							<td>New Contact No</td>
							<td><input type="text" name="customer_contact_no"></td>
						</tr>

						<tr>
							<td></td>
							<td> <input type="submit" name="update_customer" value="Update Customer"></td>
						</tr>
					</table>
				</form>
			</div>
		</div>
	</div>
</body>
</html>

