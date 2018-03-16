<?php 
session_start();
if($_SESSION["admin"] == "false"){
	header("location: Login.php");
}
require("db.php");
include("admin_side_bar.html");
$result = getJSONFromDB("select * from manager");
$result = json_decode($result, true);

if(isset($_GET["did"]))
{//deleting a customer
	$id = $_GET["did"];
	deleteFromDB("delete from manager where manager_id = $id");
	deleteFromDB("delete from users where user_id = $id");
	header("Location: manage_managers_admin.php");
}
if(isset($_REQUEST["create_new_mgr"]))
{
	if(strlen((string)$_REQUEST["mgr_name"])!=0)
	{
		$name = $_REQUEST["mgr_name"];
		$salary = $_REQUEST["mgr_salary"];
		$email = $_REQUEST["mgr_email"];
		$contact = $_REQUEST["mgr_contact_no"];
		$date = date('Y-m-d');

		$idresult = getJSONFromDB("select max(manager_id) as manager_id from manager");
		$idresult = json_decode($idresult, true);
		$id = $idresult[0]["manager_id"];
		$id = $id + 1;
		insertIntoDB("insert into manager values ('$id', '$name', '$date', '$salary', '$email', '$contact')");
		insertIntoDB("insert into users VALUES($id, 'mgr', 'pass', 'active')");

		header("Location: manage_managers_admin.php");		
	}
	else{
		header("Location: manage_managers_admin.php");
	}
	
}
if(isset($_REQUEST["update_mgr"]) )
{
	if(!isset($_REQUEST["mgr_id"]) || strlen((String)$_REQUEST["mgr_id"])==0)
	{
		header("Location: manage_managers_admin.php");
	}
	$id = $_REQUEST["mgr_id"];
	$result = getJSONFromDB("select * from manager where manager_id = $id");
	$result = json_decode($result, true);
	if(isset($_REQUEST["mgr_salary"]) && strlen((String)$_REQUEST["mgr_salary"])!=0)
	{
		$salary = $_REQUEST["mgr_salary"];
	}
	else{
		$salary = $result[0]["manager_salary"];
	}
	if(isset($_REQUEST["mgr_contact_no"]) && strlen($_REQUEST["mgr_contact_no"])!=0)
	{
		$contact = $_REQUEST["mgr_contact_no"];
	}
	else{
		$contact = $result[0]["manager_contact_no"];
	}
	if(isset($_REQUEST["mgr_email"]) && strlen($_REQUEST["mgr_email"])!=0)
	{
		$email = $_REQUEST["mgr_email"];
	}
	else{
		$email = $result[0]["manager_email"];
	}
	updateIntoDB("update manager set manager_salary = $salary, manager_contact_no = '$contact', 
		manager_email = '$email' where manager_id = $id");
	header("Location: manage_managers_admin.php");

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
				<h2>List of Managers</h2>
				<th>Manager ID</th> <th>Name</th> <th> Hire Date</th> <th> Salary </th> <th>Email</th> <th>Contact No</th><th>Delete</th>
				<?php 
					for($i=0;$i<sizeof($result);$i++){
						$id = $result[$i]["manager_id"];
						$name = $result[$i]["manager_name"];
						$hiredate = $result[$i]["hire_date"];
						$sal = $result[$i]["manager_salary"];
						$email = $result[$i]["manager_email"];
						$phn = $result[$i]["manager_contact_no"];
						echo "<tr>
							<td>$id</td>
							<td>$name</td>
							<td>$hiredate</td>
							<td>$sal</td>
							<td>$email</td>
							<td>$phn</td>
							<td><a href='manage_managers_admin.php?did=$id'>Delete</a></td>
						 </tr>";
					}
				 ?>
			</table>
		</div>
		<div class="right">
			<div>
			<form action="manage_managers_admin.php" method="POST">
				<table id="tbb">
					<h3>Create New Manager</h3>

					<tr>
						<td>Name</td>
						<td><input type="text" name="mgr_name"></td>
					</tr>
					<tr>
						<td>Salary</td>
						<td><input type="number" name="mgr_salary"></td>
					</tr>
					<tr>
						<td>Email</td>
						<td><input type="text" name="mgr_email"></td>
					</tr>
					<tr>
						<td>Contact No</td>
						<td><input type="text" name="mgr_contact_no"></td>
					</tr>
					<tr>
						<td></td>
						<td> <input type="submit" name="create_new_mgr" value="Add Manager"></td>
					</tr>
				</table>
			</form>
		</div>
		<div>
		<br><br>
			<form action="manage_managers_admin.php" method="POST">
				<table id="tbb">
					<h3>Update Manager</h3>
					<tr>
						<td>Enter ID</td>
						<td><input type="number" name="mgr_id"></td>
					</tr>
					<tr>
						<td>New Salary</td>
						<td><input type="number" name="mgr_salary"></td>
					</tr>
					<tr>
						<td>New Email</td>
						<td><input type="text" name="mgr_email"></td>
					</tr>
					<tr>
						<td>New Contact No</td>
						<td><input type="text" name="mgr_contact_no"></td>
					</tr>

					<tr>
						<td></td>
						<td> <input type="submit" name="update_mgr" value="Update Manager"></td>
					</tr>
				</table>
			</form>
		</div>
		</div>
	</div>
</body>
</html>

