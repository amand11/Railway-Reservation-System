
<?php 
	session_start();


	

	$as = "";
	$as = $_GET['user'];
	$message="";
	if($as == 'success'){
		$as = "Account Succesfully created";
	}
	elseif ($as == 'fail') {
		$as = "Failed";
	}
	else if($as == 'exists'){
		$as = "Account Already Exists";
	}

	if (isset($_POST['submit'])) {
		$conn = mysqli_connect("localhost","test","123","railway_tickets");
		if(!$conn){ 
			echo "Error".mysql_error();
		}


		$name = $_POST['name'];
		$email = $_POST['email'];	
		$card_no= $_POST['credit'];

		$_SESSION['email'] = $email;

		$sql = "SELECT name, credit_cardno, email from booking_agent where name = '$name' and email = '$email' and credit_cardno='$card_no'";

		$result = $conn->query($sql);

		// echo mysql_num_rows(result);
		// if(mysql_num_rows(result) == 0){
		// 	echo "Agent Details are Wrong";
		// 	// sleep(5);
		// 	header('Location: Booking_desk.php');
		// }
		//echo "\n";
		//echo $_POST['credit'];
		//echo "\n";
		$r =  mysqli_fetch_array($result, MYSQLI_ASSOC);


		if(isset($r)){
			header('Location: Booking_desk.php');
		}
		else{
			$message="User account does not exist";
			unset($_SESSION["email"]);
			//header('Location: login.php');
		}

	}

 ?>



<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
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
			margin-bottom: 7px;
			margin-top: 15px;
			padding: 10px 10px;
			font-size: 20px;
			border-radius: 10px;
		}
	#alert	{
			color: red;
			font-size: 20px;
			font-family:"Comic Sans MS", cursive, sans-serif;
		}
	#logintext	{
		font-size: 30px;
		text-align: center;
	}
	.data	{
			font-size: 23px;
		color: white;
	}
</style>
<body>
	 <?php include ('header2.php'); ?> 
	<div id="loginarea">
	<form id="login" action="login.php" onsubmit="return validate()" method="post" name="login"> 
		  <!-- here its isn;t login.php but reservation_page_html, that's heading of the file name it is in it. -->
	<div id="logintext">Login to Indian Railways!</div><br/><br/>
	<p align="left" id = "alert"> <?php echo $message; ?></p>
	<p id="alert">	<?php echo $as; ?></p>
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