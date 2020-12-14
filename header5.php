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
	
	width: 100px;
	display: inline-block;
	height: 30px;
	padding-left: 100px;
	line-height: 30px;
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
	width: auto;
	padding-right: auto;
	background-color: orange;
	color:black;
}

ul li{
	cursor: pointer;
	margin-left: 80px;
}
	</style>

</head>
<body link="white" alink="white" vlink="white">
     <div class="container dark">
        <div class="wrapper">
          <div class="Menu">
            <ul id="navmenu">
            <li>
            		<a HREF="login.php">Login</a>            		
            </li>
            <li><a href="create_agent.php">Create Account</a></li>
            </ul>
          </div>
        </div>
      </div>
</body>
</html>