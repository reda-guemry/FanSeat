<?php

include __DIR__ . '/../config/requirefichier.php';

class Authentification
{

    private $connect;

    public function __construct()
    {
        $this->connect = Database::getInstance()->getconnect();
    }

    private function verifyData($data)
    {

        if (empty($data['first_name']) || empty($data['email']) || empty($data['password']) || empty($data['phone'])) {
            return [
                'status' => false,
                'message' => 'Tous les champs obligatoires doivent être remplis'
            ];
        } else if ($data['password'] !== $data['confirm_password']) {
            return [
                'status' => false,
                'message' => 'Les mots de passe ne correspondent pas'
            ];
        } else if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return [
                'status' => false,
                'message' => 'Adresse email invalide'
            ];
        }
        return [
            'status' => true,
            'message' => 'Les données sont valides'
        ];
    }

    private function hashPassword(string $password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    private function verifyByEmail(string $email)
    {

        $sql = 'SELECT id FROM users WHERE email = :email';
        $check = $this->connect->prepare($sql);
        $check->execute([':email' => $email]);

        if ($check->fetch()) {
            return [
                'status' => false,
                'message' => 'Cette adresse email est déjà utilisée'
            ];
        }

        return [
            'status' => true,
            'message' => 'Adresse email disponible'
        ];
    }

    public function register($userData)
    {

        $checkData = $this->verifyData($userData);
        if (!$checkData['status'])
            return $checkData;

        $checkEmail = $this->verifyByEmail($userData['email']);
        if (!$checkEmail['status'])
            return $checkEmail;

        $password = $this->hashPassword($userData['password']);

        $sql = "INSERT INTO users 
                (first_name, last_name, email, password, role, phone) 
                VALUES 
                (:first_name, :last_name, :email, :password, :role, :phone)";

        $insert = $this->connect->prepare($sql);
        $insert->execute([
            ':first_name' => $userData['first_name'],
            ':last_name' => $userData['last_name'],
            ':email' => $userData['email'],
            ':password' => $password,
            ':role' => $userData['role'],
            ':phone' => $userData['phone']
        ]);

        return [
            'status' => true,
            'message' => 'Inscription réussie',
        ];
    }

    public function login($email, $password)
    {

        $sql = 'SELECT * FROM users WHERE email = :email';
        $select = $this->connect->prepare($sql);
        $select->execute([':email' => $email]);

        $user = $select->fetch();

        if (!$user) {
            return [
                'status' => false,
                'message' => 'Utilisateur introuvable'
            ];
        }

        if (!password_verify($password, $user['password'])) {
            return [
                'status' => false,
                'message' => 'Mot de passe incorrect'
            ];
        }

        $this->setSession($user);

        return [
            'status' => true,
            'message' => 'Connexion réussie'
        ];
    }

    private function setSession($user)
    {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['first_name'] = $user['first_name'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];
    }

    public static function checkrole(string $role)
    {
        switch ($role) {
            case 'user':
                return new Acheuteur($_SESSION['user_id']);
                break;
            case 'admin':
                return new Admine($_SESSION['user_id']);
                break;
            case 'organizer':
                return new Organizer($_SESSION['user_id']);
                break;
        }

        header('Location: logine.php');

    }
}
