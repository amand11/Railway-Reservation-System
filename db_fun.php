
<?php  
class Railway_Reservation {

    const DB_HOST = 'localhost';
    const DB_NAME = 'railway_tickets';
    const DB_USER = 'test';
    const DB_PASSWORD = '123';

    private $pdo = null;


    public function __construct() {
        // open database connection
        $conStr = sprintf("mysql:host=%s;dbname=%s", self::DB_HOST, self::DB_NAME);
        try {
            $this->pdo = new PDO($conStr, self::DB_USER, self::DB_PASSWORD);
        } catch (PDOException $pe) {
            die($pe->getMessage());
        }
    }

    
}

?>