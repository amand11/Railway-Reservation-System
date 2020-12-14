<?php
	session_start();
	$conn = mysqli_connect("localhost","test","123","railway_tickets");
	if(!$conn){ 
		echo "Error".mysql_error();
	}

	else{
		echo "Success";
	}

	if(isset($_POST['submit'])){
		header('Location:login.php');
	}
	
?>



 <!DOCTYPE html>
 <html>
 <head>
 	<title>Index</title>
 </head>
 <body>
 
<h1>This is index Page</h1>
<br>
<a href="login.php">asdf</a>

<form action="index.php">
		<input type="submit" name="sumit">
</form>


<?php mysql_close($conn) ?>
 </body>
 </html>
