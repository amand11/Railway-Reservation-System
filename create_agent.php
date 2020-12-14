
<?php 


	if (isset($_POST['submit'])) {
		$conn = mysqli_connect("localhost","test","123","railway_tickets");
		if(!$conn){ 
			echo "Error".mysql_error();
		}


		$name = $_POST['name'];
		$email = $_POST['email'];	
		$credit = $_POST['credit'];			
		$success_message = "";

		$sql = "SELECT name, credit_cardno, email from booking_agent where name = '$name' and email = '$email'";

		$result = $conn->query($sql);

	
		
		$r =  mysqli_fetch_array($result, MYSQLI_ASSOC);

		if(!empty($r)){
			$success_message = "exists";
		}
		else{
			
			$sql = "INSERT INTO booking_agent(name, credit_cardno, email) VALUES ('$name', $credit, '$email')";
			
			$rs = $conn->query($sql);
			if($rs === TRUE){
				$success_message = "success";
			}
			else{
				$success_message = "fail";
			}
		}

		$user = $success_message;
		

		header("Location: login.php?user=".$user."");
	}

 ?>



<!DOCTYPE html>
<html>
<head>
	<title>Create New Agent</title>
</head>
<script type="text/javascript">
	function validate()	{
		var Credit=document.forms['login']["credit"].value;
		if(Credit<0){
			alert("Enter Valid Credit Card Number");
			return false;
		}

		return true;
	}
	
</script>
<style type="text/css">
	#loginarea{
		background-color: white;
		width: 40%;
		margin: auto;
		border-radius: 25px;
		border: 2px solid white;
		margin-top: 100px;
		background-color: rgba(0,0,0,0.5);
	    box-shadow: inset -2px -2px rgba(0,0,0,0.5);
	    padding: 40px;
	    font-family:sans-serif;
		font-size: 20px;
		color: white;
	}
	html { 
		background: url(image.jpg) no-repeat center center fixed; 
		-webkit-background-size: cover;
		-moz-background-size: cover;
		-o-background-size: cover;
		background-size: cover;
	}
	#submit	{
			margin-left: 260px;
			margin-bottom: 5px;
			margin-top: 20px;
			padding: 10px 10px;
			font-size: 20px;
			border-radius: 10px;
		}
	#logintext	{
		text-align: center;
	}
	.data	{
		font-size: 23px;
		color: white;
	}
</style>
<body>
	 <?php include ('header6.php'); ?> 
	<div id="loginarea">
	<form id="login" action="create_agent.php" onsubmit="return validate()" method="post" name="login"> 
		  <!-- here its isn;t login.php but reservation_page_html, that's heading of the file name it is in it. -->
	<div id="logintext">Create New Account</div><br/><br/>
	<table>
		<tr><td><div class="data">Enter Name:</div></td><td><input type="text" id="name" size="30" maxlength="30" name="name" required /></td></tr>
		<tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr>

		<tr><td><div class="data">Enter E-Mail ID:</div></td><td><input type="text" id="email" size="30" maxlength="30" name="email"  required/></td></tr>
		<tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr>

		<tr><td><div class="data">Enter Credit Card Number:</div></td><td><input type="number" max=9999999999999999 placeholder="xxxxxxxxxxxxxxxx" name="credit" id="credit"  required /></td></tr>
		<tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr>

	</table>
	<input type="submit" value="submit" name="submit" id="submit" class="button">
	</form></div>
</body>
</html>