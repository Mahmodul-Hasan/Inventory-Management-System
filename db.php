<?php


function getJSONFromDB($sql){
	$conn = mysqli_connect("localhost", "root", "","ims");
	//echo $sql;
	$result = mysqli_query($conn, $sql)or die(mysqli_error($$conn));
	$arr=array();
	//print_r($result);
	while($row = mysqli_fetch_assoc($result)) {
		$arr[]=$row;
	}
	return json_encode($arr);
}
function deleteFromDB($sql){
	$conn = mysqli_connect("localhost", "root", "","ims");
	//echo $sql;
	$result = mysqli_query($conn, $sql)or die(mysqli_error($$conn));
	return true;
}
function insertIntoDB($sql){
	$conn = mysqli_connect("localhost", "root", "","ims");
	//echo $sql;
	$result = mysqli_query($conn, $sql)or die(mysqli_error($$conn));	
}
function updateIntoDB($sql)
{
	$conn = mysqli_connect("localhost", "root", "","ims");
	//echo $sql;
	$result = mysqli_query($conn, $sql)or die(mysqli_error($$conn));	
}
?>
