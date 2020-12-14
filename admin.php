<?php

	$message="";
	if (isset($_POST['submit'])) {
		$conn = mysqli_connect("localhost","test","123","railway_tickets");
		if(!$conn){ 
			echo "Error".mysql_error();
		}
		$train_no = $_POST['Train_No'];
		$doj = $_POST['DOJ'];
		$ac_coach_num = $_POST['num_coach_ac'];
		$sleeper_coach_num = $_POST['num_coach_sl'];

		$sql = "CALL train_entry('$train_no', '$doj', '$ac_coach_num', '$sleeper_coach_num')";
		if(!mysqli_query($conn, $sql))
		{
			$message=mysqli_error($conn);
		}
		else if($train_no<0||$ac_coach_num<0||$sleeper_coach_num<0){
			$message = "Error: Entered Negative Value";
		}
		else
		{
			$message="Train successfully entered";
		}

	}
 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Admin</title>
</head>
	
	<style type="text/css">
		#admin	{
			margin:auto;
			margin-top: 60px;
			font-size: 20px;
			width: 45%;
			height: 60%;
			padding: auto;
			padding-top: 40px;
			padding-left: 20px;
			border: 2px solid white;
			background-color: rgba(0,0.1,0.2,0.5);
	    	/*box-shadow: inset -2px -2px rgba(0,0,0,0.5);*/
			border-radius: 25px;
		}
		html { 
		  background: url(image.jpg) no-repeat center center fixed; 
		  -webkit-background-size: cover;
		  -moz-background-size: cover;
		  -o-background-size: cover;
		  background-size: cover;
		}
		#journeytext	{
			color: white;
			font-size: 28px;
			font-family:"Comic Sans MS", cursive, sans-serif;
		}
		#trains	{
			margin-left: 90px;
			font-size: 15px;
		}
		#submit	{
			margin-left: 240px;
			margin-bottom: 40px;
			margin-top: 30px
		}
		#alert	{
			color: red;
			font-size: 20px;
			font-family:"Comic Sans MS", cursive, sans-serif;
		}
		.data  {
			font-size: 23px;
		color: white;
		}
		.button	{
			margin-left: 100px;
			margin-bottom: 20px;
			margin-top: 20px;
			padding: 10px 10px;
			font-size: 20px;
			border-radius: 10px;
		}


	</style>
	<script type="text/javascript">
		function validate1()	{
			var train_num=document.forms['admin']["Train_No"].value;
			var num_ac=document.forms['admin']["num_coach_ac"].value;
			var num_sl=document.forms['admin']["num_coach_sl"].value;
			if(num_ac<0||num_sl<0)
			{
				alert("Enter Valid Number of Coaches");
				return false;		
			}
			else if(train_num<0){
				alert("Enter Valid Train Number Number");
				return false;	
			}

			return true;

		}
	</script>

<body>
	 <?php include ('header5.php'); ?> 
	
	<div id="admin">
	<h1 align="center" id="journeytext">Enter Details to Release the Train</h1><br/><br/>
	<p align="left" id = "alert"> <?php echo $message; ?></p>
	<form  action="admin.php" name="admin" onsubmit="return validate1()" method="post">
<!-- <form id="login" action="login.php" onsubmit="return validate()" method="post" name="login"> -->

		<table>
			<tr>
				<td>
					<div class="data"> Enter Train Number:</div>
				</td>
				<td>
					<input type="number" inputmode="numeric" id="Train_No" size="30" max="999999" name="Train_No"/>
				</td>
			</tr>
			<tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr>


			<tr>
				<td>
					<div class="data"> Date of Journey:</div>
				</td>
				<td>
					<input type="Date" name="DOJ" id="DOJ" placeholder="Date">
				</td>
			</tr>

			<tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr>

			<tr>
				<td>
					<div class="data"> Number of AC Coaches:</div>
				</td>
				<td>
					<input type="number" name="num_coach_ac" id="num_coach_ac"  max="999999" >
				</td>
			</tr>

			<tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr>

			<tr>
				<td>
					<div class="data"> Number of Sleeper Coaches:</div>
				</td>
				<td>
					<input type="number" name="num_coach_sl" id="num_coach_sl"  max="999999" >
				</td>
			</tr>

			<tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr>


		</table>

					<input type="submit" name="submit" id="submit" class="button" />
					<!-- <input type="button" value="Remove" id="remove" class="button" />	 -->		
	</form>
	</div>
	</body>
	</html>
