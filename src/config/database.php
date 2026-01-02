<?php 

    class Database {

        private static ?Database $instance = null ;

        private Pdo $db ;

        private function __construct(string $dbn , string $usrname , string $password) {
            try {

                $this -> db = new pdo ($dbn, $usrname, $password);
                $this -> db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION) ;
                $this -> db -> setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE , PDO::FETCH_ASSOC) ;
            }catch (Exception $e) {
                throw new Exception("Database connection failed: " . $e->getMessage());
            }

        }

        public static function getInstance(?string $dbn = null , ?string $usrname = null , ?string $password = null): Database { 
            if (self::$instance === null) {
                self::$instance = new Database(
                    $dbn ?? 'mysql:host=localhost;dbname=fan_seat' , 
                    $usrname ?? 'root' ,
                    $password ?? 'rootpass'

                ) ;

            }
            return self::$instance ; 

        }

        public function getconnect(): Pdo{
            return $this -> db ;
        }
        
    }

?>