 <?php 
 	session_start();
 	$login_message = "";
 	if(!isset($_SESSION['email'])){
 		$login_message = "Login First!";
 	}

 	$message = "";
	if (isset($_POST['submit'])) {
		$conn = mysqli_connect("localhost","test","123","railway_tickets");
		if(!$conn){ 
			$message = "Error".mysql_error();
			echo "Error".mysql_error();
		}

		$train_no = $_POST['train_no'];
		$num_pass = $_POST['num_pass'];
		$doj = $_POST['DOJ'];
		$coach_typ = $_POST['coach_type'];
		$user = [$train_no, $num_pass, $doj, $coach_typ];
		$_SESSION['user'] = $user;


		//$sql = "SELECT trainnum FROM train WHERE trainnum = '$train_no'";
		//$result = $conn->query($sql);
		//$r =  mysqli_fetch_array($result, MYSQLI_ASSOC);

		$sql = "SELECT trainnum, date_of_journey, accoachnum, sleepercoachnum FROM train_details WHERE trainnum = '$train_no' and date_of_journey = '$doj'";

		$result1 = $conn->query($sql);
		$r1 =  mysqli_fetch_array($result1, MYSQLI_ASSOC);

		$flag = 0;
	

		/*if(!empty($r)&&!(empty($r1))){
			if($coach_typ == 'AC'){
				$sql = "SELECT trainnum, current_seat, seats_available FROM ac_seats_availability WHERE trainnum = '$train_no' and date_of_journey = '$doj'";
				$result2 = $conn->query($sql);
				$r2 =  mysqli_fetch_array($result2, MYSQLI_ASSOC);
			}
			else{
				$sql = "SELECT trainnum, current_seat, seats_available FROM sleeper_seats_availability WHERE trainnum = '$train_no' and date_of_journey = '$doj'";
				$result2 = $conn->query($sql);
				$r2 =  mysqli_fetch_array($result2, MYSQLI_ASSOC);
			}

		

			if((int)$r2['seats_available'] >= (int)$num_pass){
				header('Location: enter_details.php');
			}
			else{
				$message =  "Alert! No Seats are available.";
			}

		}*/
		if(!(empty($r1))){
			if($coach_typ == 'AC'){
				$num_passint=(int)$num_pass;
				$sql = "UPDATE ac_seats_availability SET seats_available=seats_available-$num_passint WHERE trainnum = '$train_no' and date_of_journey = '$doj'";
				$result2 = $conn->query($sql);
				if($result2===TRUE)
				{
					header('Location: enter_details.php');
				}
				else{
					$message ="Seats not available";
				}

			}
			else{
				$num_passint=(int)$num_pass;
				$sql = "UPDATE sleeper_seats_availability SET seats_available=seats_available-$num_passint WHERE trainnum = '$train_no' and date_of_journey = '$doj'";
				$result2 = $conn->query($sql);
				if($result2===TRUE)
				{
					header('Location: enter_details.php');
				}
				else{
					$message ="Seats not available";
				}
			}

		}
		else{
			$message = "Alert! Train is not avaible on that day.";
		}

		// header('Location: enter_details.php');
	}

 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Book a ticket</title>
</head>
	<style>
		#booktkt	{
			margin:auto;
			margin-top: 70px;
			width: 50%;
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
		#journeytext1	{
			color: white;
			font-size: 28px;
			font-family:"Comic Sans MS", cursive, sans-serif;
		}
		#alert	{
			color: red;
			font-size: 20px;
			font-family:"Comic Sans MS", cursive, sans-serif;
		}
	/*	#trains	{
			margin-left: 90px;
			font-size: 15px;
		}*/
		#submit	{
			margin-left: 320px;
			margin-bottom: 20px;
			margin-top: 5px;
			padding: 10px 10px;
			font-size: 20px;
			border-radius: 10px;
		}
		.data1  {
		font-size: 23px;
		padding-bottom: 5px;
		color: white;
		}

	</style>
	<script>
		function validate3()	{
			var num_pass = document.forms['booktkt']["num_pass"].value;
			var train_no = document.forms['booktkt']["train_no"].value;
			if(train_no<0){
				alert("Enter Valid Train Number");
				return false;
			}
			else if(num_pass<0){
				alert("Enter Valid Number of Passengers");
				return false;
			}

		return true;
		}
	</script>


<body>
	
	 <?php include ('header3.php'); ?> 

	<div id="booktkt">
	<h1 align="center" id="journeytext1">Enter Ticket Details</h1><br/><br/>
	<p align="left" id = "alert"> <?php echo $message; ?></p>
	<p align="left" id = "alert"> <?php echo $login_message; ?></p>
	<form action="Booking_desk.php" name="booktkt"  onsubmit="return validate3()" method="post">

		<table>
			<tr>
				<td>
					<div class="data1"> Enter Train Number:</div>
				</td>
				<td>
					<input type="number" inputmode="numeric" id="train_no" size="30" max="999999" name="train_no" required />
				</td>
			</tr>
			<tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr>

			<tr>
				<td>
					<div class="data1"> Number of Passengers:</div>
				</td>
				<td>
					<input type="number" name="num_pass" size="30" max="999999" required >
				</td>
			</tr>

			<tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr>

			<tr>
				<td>
					<div class="data1"> Date of Journey:</div>
				</td>
				<td>
					<input type="Date" name="DOJ" id="DOJ" placeholder="Date" required>
				</td>
			</tr>

			
			<tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr>

			<tr>
				<td>
					<div class="data1">Coach Type</div>
				</td>
				<td>
					<select id="coach_type" name="coach_type">
					    <option value="AC">AC Coach</option>
					    <option value="Sleeper">Sleeper Coach</option>
					</select>
				</td>
			</tr>



		</table>

		<br/><br/>
		<input type="submit" name="submit" id="submit" class="button" />
	</form>
	</div>
	</body>
</html>