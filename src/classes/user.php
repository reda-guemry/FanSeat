<?php


abstract class User
{

    protected int $user_id;
    protected string $first_name;
    protected string $last_name;
    protected string $email;
    protected string $password;
    protected string $role;
    protected string $phone;
    protected int $status;

    abstract function __construct($data);

    /* ========= GETTERS ========= */

    abstract function getUserId(): int;

    abstract function getFirstName(): string;

    abstract function getLastName(): string;

    abstract function __tostring(): string;

    abstract function getEmail(): string;
    abstract function getRole(): string;
    abstract static function getRoleGlobale(): string;

    abstract function getPhone(): string;

    abstract function getStatus(): int;


    /* ========= SETTERS ========= */

    abstract function setFirstName(string $first_name): void;

    abstract function setLastName(string $last_name): void;

    abstract function setEmail(string $email): void;

    abstract function setPhone(string $phone): void;

    public static function getAllUser()
    {
        $connect = Database::getInstance()->getconnect();

        $rows = $connect->prepare('SELECT * FROM users WHERE role = :role');
        $rows -> execute([
            ':role' => static::getRoleGlobale() 
        ]) ;
        
        $rows = $rows -> fetchAll() ;
        
        $users = [] ;

        foreach($rows as $row) {
            $users[] = new static($row) ;
        }

        return $users ; 

    }

}