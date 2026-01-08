<?php

include __DIR__ . '/../config/requirefichier.php';


class Acheuteur extends User
{
    public const ROLE = 'user';

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
        $this->user_id = $data['id'];
        $this->first_name = $data['first_name'];
        $this->last_name = $data['last_name'];
        $this->email = $data['email'];
        $this->password = $data['password'];
        $this->role = self::getRoleGlobale();
        $this->phone = $data['phone'];
        $this->status = $data['status'];

    }

    /* ========= GETTERS ========= */

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
    public function getStatus(): int
    {
        return $this->status;
    }

    public static function getRoleGlobale(): string
    {
        return self::ROLE;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    /* ========= SETTERS ========= */

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

    private function checkData(array $data): array
    {
        $connect = Database::getInstance()->getConnect();

        if (empty($data['first_name'])) {
            return [
                'success' => true,
                'message' => "First name is required"
            ];
        }

        if (empty($data['last_name'])) {
            $errors[] = "Last name is required";
            return [
                'success' => false,
                'message' => "Last name is required"
            ];
        }

        if (
            empty($data['email']) ||
            !filter_var($data['email'], FILTER_VALIDATE_EMAIL)
        ) {
            return [
                'success' => true,
                'message' => "false email is required"
            ];
        }

        if (empty($data['phone'])) {
            return [
                'success' => false,
                'message' => "Phone number is required"
            ];
        }

        $email_check = $connect->prepare(
            "SELECT id FROM users WHERE email = :email AND id != :id"
        );
        $email_check->execute([
            ':email' => $data['email'],
            ':id' => $this->getUserId()
        ]);

        if ($email_check->fetch()) {
            return [
                'success' => false,
                'message' => "Email already exists"
            ];
        }

        return [
            'success' => true
        ];
    }



    public function modifierprofile($data)
    {

        $errors = $this->checkData($data);
        if (isset($data['current_password'])) {
            $errors = $this->modifierpassword($data);
        }

        if ($errors['success']) {
            return $errors;
        }

        $connect = Database::getInstance()->getConnect();

        $sql = "UPDATE users 
            SET first_name = :first_name,
                last_name  = :last_name,
                email      = :email,
                phone      = :phone
            WHERE id = :id";

        $stmt = $connect->prepare($sql);
        $stmt->execute([
            ':first_name' => $data['first_name'],
            ':last_name' => $data['last_name'],
            ':email' => $data['email'],
            ':phone' => $data['phone'],
            ':id' => $this->getUserId()
        ]);



        return [
            'success' => true,
             'message' => "profile updated successfully"
        ];;

    }

    private function modifierpassword($data)
    {
        $connect = Database::getInstance()->getConnect();
        if (!empty($data['current_password']) || !empty($data['confirm_password'])) {

        } else if ($data['new_password'] !== $data['confirm_password']) {

        }
        $select = $connect->prepare('SELECT password from users WHERE id = :id');
        $select->execute([':id' => $this->getUserId()]);
        $user = $select->fetch();

        if (!password_verify($data['current_password'], $user['password'])) {
            return [
                'success' => false,
                'message' => "Cannot update password"
            ];
        }

        $passwordHash = password_hash($data['new_password'], PASSWORD_DEFAULT);
        $stmt = $connect->prepare('UPDATE users SET password = :password WHERE id = :id');
        $stmt->execute([
            ':password' => $passwordHash,
            ':id' => $this->getUserId()
        ]);

        return [
            'success' => true,
            'message' => "Password updated successfully"
        ];
    }

}