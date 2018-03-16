<?php 
session_start();
if($_SESSION["mgr"] == "false"){
	header("location: Login.php");
}
include("manager_side_bar.html");
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
		#cd{
			margin-left: 300px;
		}
	</style>
</head>
<body>
	
	<br><br>
	<div id="bd">
		<h1 align="center"> This is Manager Home Page </h1>
	</div>
</body>
</html>

