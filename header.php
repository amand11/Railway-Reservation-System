<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		.container
{
	width: 100%;

}
.wrapper
{
	width: 900px;
	margin: auto;
}
.dark
{
	background-color: #b35028;
	color: white;
}

*{
	margin:0px;
	}
ul li
{
	
	width: 150px;
	display: inline-block;
	height: 35px;
	padding-left: 60px;
	line-height: 35px;
	text-align: center;
}
ul li a
{
	color: white;
	text-decoration: none;
	display: block;
}

ul li a:hover
{
	background-color: orange;
	color:black;
}

ul li{
	cursor: pointer;
	margin-left: 45px;
}
	</style>

</head>
<body link="white" alink="white" vlink="white">
     <div class="container dark">
        <div class="wrapper">
          <div class="Menu">
            <ul id="navmenu">
            <li><A HREF="Booking_desk.php">Book another Ticket</A></li>
            <li>
            	<?php if(isset($_SESSION['email'])){ ?>
            		<a href="logout.php"> Logout Here</a>
            		<?php } else{ ?>
            			<a HREF="login.php">Login</a>            		
            		<?php } ?>
            </li>
            <li>
            	<?php if (isset($_SESSION['email'])): ?>
            		<?php echo $_SESSION['email']; ?>
					
            	<?php endif ?>
            </li>
            </ul>
          </div>
        </div>
      </div>
</body>
</html>