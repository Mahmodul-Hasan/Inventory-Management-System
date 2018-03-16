<?php 
session_start();
if($_SESSION["admin"] == "false"){
	header("location: Login.php");
}
require("db.php");
include("admin_side_bar.html");
$result = getJSONFromDB("select customer.customer_name, customer.customer_contact_no, customer_email from customer");
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
			<h2>List of Customers</h2>
				<th>Customer Name</th> <th> Contact No </th> <th> Email </th> 
				<?php 
					for($i=0;$i<sizeof($result);$i++){
						$name = $result[$i]["customer_name"];
						$contact = $result[$i]["customer_contact_no"];
						$email = $result[$i]["customer_email"];
						echo "<tr>
							<td>$name</td>
							<td>$contact</td>
							<td>$email</td>
						 </tr>";
					}
				 ?>
			</table>
		</div>

	</div>
</body>
</html>

