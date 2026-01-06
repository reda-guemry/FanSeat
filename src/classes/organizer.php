<?php
include __DIR__ . '/../config/requirefichier.php';


class Organizer extends User
{
    public const ROLE = 'organizer';

    public function __construct($data)
    {
        if (is_array($data)) {
            $this->setUserData($data);
        } else {
            $connect = Database::getInstance()->getconnect();
            $stmt = $connect->prepare('SELECT * FROM users WHERE id = :user_id');
            $stmt->execute([':user_id' => $data]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->setUserData($row);
        }
    }

    private function setUserData(array $data)
    {
        $this -> user_id = $data['id'] ;
        $this->first_name = $data['first_name'];
        $this->last_name = $data['last_name'];
        $this->email = $data['email'];
        $this->password = $data['password'];
        $this->role = $data['role'];
        $this->phone = $data['phone'];
        $this->status = $data['status'];

    }

    /* GETTERS  */

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getFirstName(): string
    {
        return $this->first_name;
    }

    public function getLastName(): string
    {
        return $this->last_name;
    }

    public function __tostring(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public static function getRoleGlobale(): string
    {
        return self::ROLE;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getStatus(): int
    {
        return $this->status;
    }


    /* SETTERS */

    public function setFirstName(string $first_name): void
    {
        $this->first_name = $first_name;
    }

    public function setLastName(string $last_name): void
    {
        $this->last_name = $last_name;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    public function setStatus(int $status): void
    {
        $this->status = $status;
    }


    public function createMatch(array $data)
    {
        $data['organizer_id'] = $this->user_id;
        return new MatchGame($data);
    }

    public function getCountMatch() {
        $connect = Database::getInstance() ->getconnect();
        $query = $connect -> prepare('SELECT COUNT(*) FROM matches WHERE organizer_id = :id');
        $query -> execute([':id' => $this->getUserId()]);
        return $query -> fetchColumn();   
    }
    public function getCountMatchPending() {
        $connect = Database::getInstance() ->getconnect();
        $query = $connect -> prepare('SELECT COUNT(*) FROM matches WHERE organizer_id = :id AND status = "pending"');
        $query -> execute([':id' => $this->getUserId()]);
        return $query -> fetchColumn();   
    }



}