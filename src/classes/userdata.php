<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . './acheuteur.php';
require_once __DIR__ . './admine.php';
require_once __DIR__ . './organizer.php';

class Userdata
{
    private $connect;

    public function __construct()
    {
        $this->connect = Database::getInstance()->getconnect();
    }

    public function findById(int $id)
    {
        $sql = 'SELECT * FROM users WHERE id = :user_id ';

        $data = $this->connect->prepare($sql);

        $data->execute([':user_id' => $id]);

        $data = $data->fetch();

        switch ($data['role']) {
            case 'user':
                return new Acheuteur($data);
                break;
            case 'admin':
                return new Admine($data);
                break;
            case 'organizer':
                return new Organizer($data);
                break;
        }

    }

}

?>