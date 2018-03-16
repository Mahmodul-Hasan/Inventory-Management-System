

<!Doctype html>
<html>
<script>
 function validate1(){
	flag=true;
	m = document.getElementById("msg");
	if(document.fm.username.value.length == 0){
		m.innerHTML="Username can not be null";
		m.style.color="red";
		flag=false;
		
	}
	else if(document.fm.password.value.length==0){
		m.innerHTML="Password can not be null";
		m.style.color="red";
		flag=false;

	/*var x = document.forms["fm"]["username"].value;
    if (x == "") {
        alert("Name must be filled out");
        return false;
    }*/
		
	}
	return flag;
}
</script>

<head>
	<title> Login Page</title>
	<link rel = "stylesheet" type="text/css" href="style.css">
</head>
<body>
<br><br><br><br><br><br><br><br>
	<div id="frm">
		<form name="fm" action="login_validation.php" method="POST" onsubmit="return validate1()">
			<table id="tl">
				<tr>
					<td>
						<label>User ID</label>
					</td>
					<td>
						<input type="text" name="username" id = "idfield">
					</td>
				</tr>
				<tr>
					<td><br></td>
				</tr>
				<tr>
					<td>
						<label>Password</label>
					</td>
					<td>
						<input type="password" name="password" id="pass">
					</td>
				</tr>
				<tr>
					<td><br></td>
				</tr>
				<tr>
					<td> </td>
					<td> <input type="submit" id = "lgbtn" value="Login"></td>
				</tr>
				<tr>
				    <td></td>
					<td> <span id="msg"> </span> </td>
				</tr>
			</table>
		</form>
	</div>
</body>
</html>