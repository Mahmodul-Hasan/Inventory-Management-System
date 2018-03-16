<?php
session_start();
$_SESSION['admin'] = "false";
$_SESSION['mgr'] = "false";


require("db.php");

$username = $_REQUEST['username'];
$pass = $_REQUEST['password'];


$sql = "select * from users where user_id = '$username' and password = '$pass'";
$result = getJSONFromDB($sql);
$result = json_decode($result, true);


if(isset($result[0]["user_id"]) && $result[0]["user_id"] == $username && $result[0]["password"] == $pass){
	if($result[0]["role"] == "admin" && $result[0]["status"] == "active"){
		$_SESSION['admin'] = "true";
		$_SESSION['adminid'] = $username;
		header("Location: admin.php");	
	}
	elseif ($result[0]["role"] == "mgr" && $result[0]["status"] == "active") {
		$_SESSION['mgr'] = "true";
		$_SESSION['manager_id'] = $result[0]["user_id"];
		header("Location: manager.php");
	}
	else{
		echo "<h1> You have been blocked </h1> <h3>Contact your admin to solve the issue</h3>";
	}
	
}
else
{
	header("Location: login.php");
}

?>