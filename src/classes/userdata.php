<?php 

    require_once __DIR__ . '/../config/database.php';

    class Userdata {
        private $connect ; 

        public function __construct() {
            $this -> connect = Database::getInstance() -> getconnect() ;
        }

        public function findById(int $id) {
            $sql = 'SELECT * FROM users WHERE id = :user_id ' ; 

            $data = $this -> connect -> prepare($sql) ;

            $data -> execute([':user_id' => $id]) ;

            return $data -> fetch() ;
        }


    }


?>