<?php 
		
		session_start();
		$as = $_SESSION['user'];
		$train_no = $as[0];
		$doj = $as[2];
		$pass_no = $as[1];
		$class = $as[3];
		$agent_email = "Not_logged";
		$agent_email = $_SESSION['email'];
		// print_r($as);
		// echo $agent_email;
		

	if (isset($_POST['submit'])) {

		$conn = mysqli_connect("localhost","test","123","railway_tickets");
		if(!$conn){ 
			die("Error ".mysql_error());
		}

		$pass_list_name = $_POST['name'];
		$pass_list_gender = $_POST['gender'];
		$pass_list_age = $_POST['age'];
	
		// print_r($pass_list_name);

		$pnr_num = '0';


		$sql1 = "CALL pnr_generation('$train_no', '$doj', '$class', @pnr_num)";
		mysqli_query($conn, $sql1);
		

		 	
		for($k=0; $k<$pass_no; $k++)
		{
			$sql = "CALL ticket_booking('$pass_list_name[$k]', '$train_no', '$doj', '$class', '$pass_list_gender[$k]','$pass_list_age[$k]', @pnr_num)";
			 mysqli_query($conn, $sql);
		}

		$sql = "INSERT INTO agent_bookings(email, pnr_booked) VALUES ('$agent_email', @pnr_num)";
		$rs = $conn->query($sql);
		if($rs){
			// echo "\nTrue, done\n";
		}
		else{
			// echo "\nNot\n";
		}


		$sql = "CALL pnr_retrieve(@pnr_num)";
		$rs = mysqli_query($conn, $sql);
		$my_pnr =  mysqli_fetch_array($rs, MYSQLI_ASSOC);
		// echo($my_pnr['pnr']);
		$mypnr = $my_pnr['pnr'];
		// echo $mypnr;

		header("Location: ticket.php?mypnr=".$mypnr."");

	}

 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Enter Details</title>
	<LINK REL="STYLESHEET" HREF="STYLE.CSS">
	<style type="text/css">
		#nametkt	{
			margin:auto;
			margin-top: 100px;
			width: 50%;
			height: 60%;
			padding: auto;
			padding-top: 40px;
			padding-left: 30px;
			padding-right:30px;
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

		#submit	{
			margin-left: 280px;
			margin-bottom: 20px;
			margin-top: 5px;
			padding: 10px 10px;
			font-size: 20px;
			border-radius: 10px;
		}
		.data  {
		color: white;
		font-size: 23px;
		padding-right: 10px;
		padding-bottom: 5px;
		}


	</style>
	<script type="text/javascript">
		function validate2()	{
			var ages=document.forms['nametkt']['age[]'];
			var key;
			for(key=0; key<ages.length; key++){
				if(ages[key].value < 0){
					var t = key + 1;
					alert("Enter Valid value of "+ t +" numberd Passengers Age");
					return false;
				}
			}
			return true;
		}
	</script>
</head>
<body>
	 <?php include ('header3.php'); ?> 

	<div style="background-image: url('img_girl.jpg');">
	<div id="nametkt">
	<h1 align="center" id="journeytext">Enter Details of the Passengers</h1><br/><br/>

	<h2>
		<table>
			<tr>
				<td></td> <td></td> 
				<td class="data">Train Number: <?php echo $train_no; ?></td>
				<td></td> <td></td> <td></td> <td></td> <td></td> 
				<td class="data">Date of Journey: <?php echo $doj; ?></td>
				<td></td> <td></td> <td></td> <td></td> <td></td> 
				<td class="data">Class: <?php echo $class; ?></td>
			</tr>
			<tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr>
		</table>
	</h2>
	<form method="post" action="enter_details.php" name="nametkt" onsubmit="return validate2()">
		<table>
			<?php for($i = 0; $i<$pass_no; $i++){ ?>
			<tr>
				<td>
					<div class="data"> Name:</div>
				</td>
				<td>
					<input type="text" id="name" name="name[]" required />
				</td>
				<td></td> <td></td> <td></td>
				<td>
					<div class="data">Gender: </div>
				</td>
				<td>
					<select id="gender" name="gender[]">
					    <option value="M">Male</option>
					    <option value="F">Female</option>
					</select>
				</td>
				<td></td> <td></td> <td></td>
				<td>
					<div class="data"> Age: </div>
				</td>
				<td>
					<input type="number" id = "age" name="age[]" required>
				</td>

			</tr>
			

		<?php } ?>

		</table>

		<br/><br/>
		<input type="submit" name="submit" id="submit" class="button" />

	</form>
	</div>
	</body>
	</html>
