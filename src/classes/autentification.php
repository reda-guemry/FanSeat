<?php

    require_once __DIR__ . '/../config/database.php';

    class Autentification {
        private $connect ; 

        public function __construct() {
            $this -> connect = Database::getInstance() -> getconnect() ;   
        }

        private function verifydata($data){
            if (empty($data['first_name']) || empty($data['email']) || empty($data['password']) || empty($data['phone'])) {
                return false ;
            } elseif ($data['password'] !== $data['confirm_password']) {
                return false ;
            } elseif (strlen( $data['password'] ) < 6) {
                return false  ;
            } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                return false ;
            }

            return true ;
        }

        private function hashedPassword(string $password){
            return password_hash($password, PASSWORD_DEFAULT);
        }

        private function verifyByMail(string $email){
            $sql = 'SELECT id FROM users WHERE email = :email' ; 

            $check = $this -> connect-> prepare($sql) ;
            $check -> execute(array(':email'=> $email)) ;

            $user = $check -> fetch() ;

            if ($user) {
                return false ;
            }
            return true ;

        }

        public function register($userdata) { 

            $verification = $this -> verifydata($userdata) ;
            if(!$verification)return false ;
            $verification = $this -> verifyByMail( $userdata['email'] ) ;
            if(!$verification)return false ;

            $password = $this -> hashedPassword($userdata['password']);

            $sql = "INSERT INTO users 
                    (first_name, last_name, email, password, role, phone) 
                    VALUES 
                    (:first_name, :last_name, :email, :password, :role, :phone)";

            $isnertUser = $this->connect->prepare($sql);

            $isnertUser->execute([
                ':first_name' => $userdata['first_name'],
                ':last_name'  => $userdata['last_name'],
                ':email'      => $userdata['email'],
                ':password'   => $password,
                ':role'       => $userdata['role'],
                ':phone'      => $userdata['phone']
            ]);

            return $this -> connect -> lastInsertId();
        }

        public function logine($email , $password) { 
            $sql = 'SELECT * FROM users WHERE enail = :email'; 

            $select = $this -> connect -> prepare($sql) ;
            $select -> execute([':email' => $email]) ;

            $user = $select -> fetch() ;

            if(!password_verify ( $password , $user['password'])) return false ;

            $this -> setSesion($user) ; 

            return true ;
        }

        public function setSesion($user){
            $_SESSION['user_id'] = $user['id'] ;
            $_SESSION['email'] = $user['email'] ; 
            $_SESSION['role'] = $user['role'] ;
        }


    }