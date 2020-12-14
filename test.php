	// $username = 'test';
		// $dbname = 'railway_tickets';
		// $host = 'localhost';
		// $password = '123';
		// $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

		// for($k =0; $k<$pass_no; $k++){
		// 	try{
		// 	$sql = 'CALL ticket_booking($pass_list_name[$k], $train_no, $doj, $class, $pass_list_gender[$k])';	
		// 	mysql_query($conn, $sql);
	 //    }

		// header('Location: ticket.php');

			 require_once 'dbconfig.php';
         try {
             $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
             // execute the stored procedure
             $sql = 'CALL ticket_booking($pass_list_name[0], $train_no, $doj, $class, $pass_list_gender[0])';
             // call the stored procedure
             $q = $pdo->query($sql);
             $q->setFetchMode(PDO::FETCH_ASSOC);
   		      } catch (PDOException $e) {
  	          die("Error occurred:" . $e->getMessage());
        }