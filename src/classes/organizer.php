<?php

require_once __DIR__ . './user.php';


class Organizer extends User {
     public function __construct(array $data)
    {
        $this->user_id = $data['user_id'];
        $this->first_name = $data['first_name'];
        $this->last_name = $data['last_name'];
        $this->email = $data['email'];
        $this->password = $data['password'];
        $this->role = $data['role'];
        $this->phone = $data['phone'];
        $this->status = $data['status'];
    }

    /* ========= GETTERS ========= */

    public function getUserId(): int{return $this->user_id;}

    public function getFirstName(): string{return $this->first_name;}

    public function getLastName(): string{return $this->last_name;}
    
    public function __tostring(): string {return $this->first_name . ' ' . $this->last_name;}

    public function getEmail(): string{return $this->email;}

    public function getRole(): string{return $this->role;}

    public function getPhone(): string{return $this->phone;}

    /* ========= SETTERS ========= */

    public function setFirstName(string $first_name): void{$this->first_name = $first_name;}

    public function setLastName(string $last_name): void{$this->last_name = $last_name;}

    public function setEmail(string $email): void{$this->email = $email;}

    public function setPhone(string $phone): void{$this->phone = $phone;}

    public function setStatus(int $status): void{$this->status = $status;}


}