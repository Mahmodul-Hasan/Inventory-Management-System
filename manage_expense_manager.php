<?php 
session_start();
if($_SESSION["mgr"] == "false"){
	header("location: Login.php");
}
require("db.php");
include("manager_side_bar.html");
$manager_id = $_SESSION['manager_id'];

$result = getJSONFromDB("select bill_id, house_rent, electricity_bill, others, month, bill_date, (house_rent + electricity_bill + others) as total from monthly_expense where manager_id = '$manager_id'");
$result = json_decode($result, true);

if(isset($_GET["did"]))
{//deleting a customer
	$id = $_GET["did"];
	deleteFromDB("delete from monthly_expense where bill_id = $id");
	header("Location: manage_expense_manager.php");
}
if(isset($_REQUEST["create_new_bill"]))
{
	if(strlen((string)$_REQUEST["house_rent"])!=0 || strlen((string)$_REQUEST["electricity_bill"]) !=0 || strlen((string)$_REQUEST["others"])!=0)
	{
		$house_rent = $_REQUEST["house_rent"];
		$electricity_bill = $_REQUEST["electricity_bill"];
		$month = $_REQUEST["month"];
		$others = $_REQUEST["others"];
		$date = date('Y-m-d');

		$idresult = getJSONFromDB("select max(bill_id) as bill_id from monthly_expense");
		$idresult = json_decode($idresult, true);
		$bill_id = $idresult[0]["bill_id"];
		$bill_id = $bill_id + 1;
		insertIntoDB("insert into monthly_expense VALUES ('$bill_id', '$manager_id', '$house_rent', '$electricity_bill','$others', '$date', '$month')");
		header("Location: manage_expense_manager.php");		
	}
	else{
		header("Location: manage_expense_manager.php");
	}	
}

if(isset($_REQUEST["update_bill"]) )
{
	if(!isset($_REQUEST["bill_id"]) || strlen((String)$_REQUEST["bill_id"])==0)
	{
		header("Location: manage_expense_manager.php");
	}
	$id = $_REQUEST["bill_id"];
	$result = getJSONFromDB("select * from monthly_expense where bill_id = $id");
	$result = json_decode($result, true);
	if(isset($_REQUEST["electricity_bill"]) && strlen((String)$_REQUEST["electricity_bill"])!=0)
	{
		$electricity_bill = $_REQUEST["electricity_bill"];
	}
	else{
		$electricity_bill = $result[0]["electricity_bill"];
	}
	if(isset($_REQUEST["house_rent"]) && strlen($_REQUEST["house_rent"])!=0)
	{
		$house_rent = $_REQUEST["house_rent"];
	}
	else{
		$house_rent = $result[0]["house_rent"];
	}
	if(isset($_REQUEST["others"]) && strlen($_REQUEST["others"])!=0)
	{
		$others = $_REQUEST["others"];
	}
	else{
		$others = $result[0]["others"];
	}
	updateIntoDB("update monthly_expense set electricity_bill = '$electricity_bill', house_rent = '$house_rent', others = '$others' where bill_id = '$id' and manager_id = $manager_id");
	header("Location: manage_expense_manager.php");

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
				<h2>Bills Created by You</h2>
				<th>Bill ID</th> <th>House Rent</th> <th> Electricity </th> <th>others</th><th>Bill Date</th><th>Month</th> 
				<th>Total</th><th>Delete</th>
				<?php 
					for($i=0;$i<sizeof($result);$i++){
						$id = $result[$i]["bill_id"];
						$house_rent = $result[$i]["house_rent"];
						$electricity = $result[$i]["electricity_bill"];
						$others = $result[$i]["others"];
						$date = $result[$i]["bill_date"];
						$month = $result[$i]["month"];
						$total = $result[$i]["total"];
						echo "<tr>
							<td>$id</td>
							<td>$house_rent</td>
							<td>$electricity</td>
							<td>$others</td>
							<td>$date</td>
							<td>$month</th>
							<td>$total</td>
							<td><a href='manage_expense_manager.php?did=$id'>Delete</a></td>
						 </tr>";
					}
				 ?>
			</table>
		</div>
		<div class="right">
			<div>
				<form action="manage_expense_manager.php" method="POST">
					<table id="tbb">
						<h3>Create New Bill</h3>

						<tr>
							<td>House Rent</td>
							<td><input type="number" name="house_rent"></td>
						</tr>
						<tr>
							<td>Electricity</td>
							<td><input type="number" name="electricity_bill"></td>
						</tr>
						<tr>
							<td>Others</td>
							<td><input type="number" name="others"></td>
						</tr>
						<tr>
							<td>Select Month</td>
							<td>
								<select name="month">
									<option value="January">January</option>
									<option value="February">February</option>
									<option value="March">March</option>
									<option value="April">April</option>
									<option value="May">May</option>
									<option value="June">June</option>
									<option value="July">July</option>
									<option value="August">August</option>
									<option value="September">September</option>
									<option value="October">October</option>
									<option value="December">November</option>
									<option value="December">Decebmer</option>
								</select>
							</td>
						</tr>
						<tr>
							<td></td>
							<td> <input type="submit" name="create_new_bill" value="Create Bill"></td>
						</tr>
					</table>
				</form>
			</div>
			<div>
			<br><br>
				<form action="manage_expense_manager.php" method="POST">
					<table id="tbb">
						<h3>Update Bill Info</h3>
						<tr>
							<td>Enter ID</td>
							<td><input type="number" name="bill_id"></td>
						</tr>
						<tr>
							<td>Electricity Bill</td>
							<td><input type="number" name="electricity_bill"></td>
						</tr>
						<tr>
							<td>House Rent</td>
							<td><input type="number" name="house_rent"></td>
						</tr>
						<tr>
							<td>Others</td>
							<td><input type="number" name="others"></td>
						</tr>

						<tr>
							<td></td>
							<td> <input type="submit" name="update_bill" value="Update Bill"></td>
						</tr>
					</table>
				</form>
			</div>
		</div>
	</div>
</body>
</html>