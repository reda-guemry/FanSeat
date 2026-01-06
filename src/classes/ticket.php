<?php

include __DIR__ . '/../config/requirefichier.php';


class Ticket
{
    private $id;
    private $match_id;
    private $user_id;
    private $ticket_code;
    private $category_id;

    public function __construct($user_id, $match_id, $category_id)
    {
        $this->user_id = $user_id;
        $this->match_id = $match_id;
        $this->category_id = $category_id;
    }

    public function getId()
    {
        return $this->id;
    }
    public function getMatchId()
    {
        return $this->match_id;
    }
    public function getUser()
    {
        return $this->user_id;
    }

    public function getTicketCode()
    {
        return $this->ticket_code;
    }
    public function getCategoryId()
    {
        return $this->category_id;
    }
    private function createTicketCode()
    {
        $this->ticket_code = uniqid();
    }

    private function checkticketuser()
    {
        $connect = Database::getInstance()->getconnect();
        $query = 'SELECT COUNT(*) FROM tickets where user_id = :user_id AND match_id = :macth_id';
        $select = $connect->prepare($query);
        $select->execute([
            ':user_id' => $this->user_id,
            ':macth_id' => $this->match_id
        ]);
        $result = $select->fetchColumn();
        if ($result >= 4) {
            return [
                'status' => false,
                'message' => 'Max tickets for evry achteur et 4'
            ];
        }
        return [
            'status' => false
        ];
    }

    public function save()
    {
        $connect = Database::getInstance()->getconnect();
        $connect->beginTransaction();
        $result = $this->checkticketuser();
        if ($result['message'])
            return $result;

        $this->createTicketCode();
        try {
            $query = 'INSERT INTO tickets (match_id , user_id , ticket_code , cetrgorie_id ) 
                                VALUE (:match_id , :user_id , :ticket_code , :categorie_id)';
            $insert = $connect->prepare($query);
            $insert->execute([
                ':match_id' => $this->match_id,
                ':user_id' => $this->user_id,
                ':ticket_code' => $this->ticket_code,
                ':categorie_id' => $this->category_id
            ]);

            $update = $connect->prepare('UPDATE match_categories SET total_places = total_places - 1 WHERE id = :categorie_id');
            $update->execute([':categorie_id' => $this->category_id]);

            $connect->commit();
            return [
                'status' => true,
                'message' => 'buy tickets succsesful'
            ];

        } catch (PDOException $e) {
            $connect->rollBack();
            return [
                'status' => false,
                'message' => 'Erreur base de données : ' . $e->getMessage()
            ];
        }
    }

}