<?php
include __DIR__ . '/../config/requirefichier.php';



class MatchGame
{
    private $id;
    private $organizer_id;
    private $team1_name;
    private $team1_short;
    private $team1_logo;
    private $team2_name;
    private $team2_short;
    private $team2_logo;
    private $match_datetime;
    private $duration;
    private $stadium_name;
    private $city;
    private $address;
    private $total_places;
    private $status;
    private $categories;
    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? null;
        $this->organizer_id = $data['organizer_id'];
        $this->team1_name = $data['team1_name'];
        $this->team1_short = $data['team1_short'] ?? null;
        $this->team1_logo = $data['team1_logo'];
        $this->team2_name = $data['team2_name'];
        $this->team2_short = $data['team2_short'] ?? null;
        $this->team2_logo = $data['team2_logo'];
        $this->match_datetime = $data['match_datetime'];
        $this->duration = $data['duration'];
        $this->stadium_name = $data['stadium_name'];
        $this->city = $data['city'];
        $this->address = $data['address'] ?? null;
        $this->total_places = $data['total_places'];
        $this->categories = $data['categories'] ?? null;
        $this->status = $data['status'] ?? 'pending';
    }


    public function approve(): void
    {
        $this->status = 'approved';
        $this->updateStatus();
    }

    public function reject(): void
    {
        $this->status = 'rejected';
        $this->updateStatus();
    }

    public function isPublished()
    {
        $this->status === 'approved';
        $this->updateStatus();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrganizerId(): int
    {
        return $this->organizer_id;
    }

    public function getTeam1Name(): string
    {
        return $this->team1_name;
    }

    public function getTeam1Short(): ?string
    {
        return $this->team1_short;
    }

    public function getTeam1Logo(): string
    {
        return $this->team1_logo;
    }

    public function getTeam2Name(): string
    {
        return $this->team2_name;
    }

    public function getTeam2Short(): ?string
    {
        return $this->team2_short;
    }

    public function getTeam2Logo(): string
    {
        return $this->team2_logo;
    }

    public function getMatchDatetime(): string
    {
        return $this->match_datetime;
    }

    public function getFormattedMatchDatetime(): string
    {
        return date('d/m/Y H:i', strtotime($this->match_datetime));
    }

    public function getDuration(): int
    {
        return $this->duration;
    }

    public function getStadiumName(): string
    {
        return $this->stadium_name;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function getTotalPlaces(): int
    {
        return $this->total_places;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getCategories(): ?array
    {
        return $this->categories;
    }

    private function saveLogo()
    {

        $saveImgFile = function ($file) {
            if ($file['error'] === 0) {
                $filename = uniqid() . '_' . $file['name'];
                $pathfile = UPLOAD_DIR . $filename;
                if (move_uploaded_file($file['tmp_name'], $pathfile)) {
                    return $filename;
                }
            }
            return null;
        };

        $this->team1_logo = $saveImgFile($this->team1_logo);
        $this->team2_logo = $saveImgFile($this->team2_logo);

        if (!$this->team1_logo || !$this->team2_logo) {
            return [
                'status' => false,
                'message' => 'Échec du téléchargement des logos. Vérifiez les fichiers et les permissions du dossier.'
            ];
        }
        return ['status' => true];
    }


    public function insertmatch()
    {
        $logoResult = $this->saveLogo();

        if (!$logoResult['status'])
            return $logoResult;

        try {
            $connect = Database::getInstance()->getconnect();
            $sql = 'INSERT INTO matches (organizer_id,team1_name,team1_short,team1_logo,team2_name,team2_short,team2_logo,match_datetime,duration,stadium_name,city,address,total_places,status) VALUES (
                                    :organizer_id,
                                    :team1_name,
                                    :team1_short,
                                    :team1_logo,
                                    :team2_name,
                                    :team2_short,
                                    :team2_logo,
                                    :match_datetime,
                                    :duration,
                                    :stadium_name,
                                    :city,
                                    :address,
                                    :total_places,
                                    :status)';
            $insertnewmacth = $connect->prepare($sql);

            $insertnewmacth->execute([
                ':organizer_id' => $this->organizer_id,
                ':team1_name' => $this->team1_name,
                ':team1_short' => $this->team1_short,
                ':team1_logo' => $this->team1_logo,
                ':team2_name' => $this->team2_name,
                ':team2_short' => $this->team2_short,
                ':team2_logo' => $this->team2_logo,
                ':match_datetime' => $this->match_datetime,
                ':duration' => $this->duration,
                ':stadium_name' => $this->stadium_name,
                ':city' => $this->city,
                ':address' => $this->address,
                ':total_places' => $this->total_places,
                ':status' => $this->status
            ]);

            $this->id = $connect->lastInsertId();

            $catResult = $this->insertCategories();
            if (!$catResult['status'])
                return $catResult;

            return [
                'status' => true,
                'message' => 'Match créé avec succès'
            ];
        } catch (PDOException $e) {
            return [
                'status' => false,
                'message' => 'Erreur base de données : ' . $e->getMessage()
            ];
        }
    }

    private function insertCategories()
    {
        try {
            $db = Database::getInstance()->getconnect();
            $sql = "INSERT INTO match_categories (match_id, name, price, total_places, description)
            VALUES (:match_id, :name, :price, :total_places, :description)";
            $stmt = $db->prepare($sql);

            foreach ($this->categories as $cat) {
                $stmt->execute([
                    ':match_id' => $this->id,
                    ':name' => $cat['name'],
                    ':price' => $cat['price'],
                    ':total_places' => $cat['total_places'],
                    ':description' => $cat['description'] ?? null
                ]);
            }

            return ['status' => true];
        } catch (PDOException $e) {
            return [
                'status' => false,
                'message' => 'Erreur lors de l\'insertion des catégories : ' . $e->getMessage()
            ];
        }
    }


    public static function getMatchesByStatus($statu)
    {
        $db = Database::getInstance()->getConnect();

        $select = $db->prepare('SELECT * FROM matches WHERE  status = :statu ');
        $select->execute([':statu' => $statu]);
        $rows = $select->fetchAll();


        $matches = [];

        foreach ($rows as $row) {
            $matches[] = new MatchGame($row);
        }
        return $matches;
    }

    public static function getMatchesById($id) {
        $db = Database::getInstance()->getconnect();
        $select = $db->prepare('SELECT * FROM matches WHERE id = :id');
        $select->execute([':id'=> $id]);
        $row = $select->fetch();
        $matche = new MatchGame($row);
        return $matche;
    }

    private function updateStatus()
    {
        $connect = Database::getInstance()->getconnect();

        $sql = 'UPDATE matches SET status = :status WHERE id = :id';

        $updateMatche = $connect->prepare($sql);
        $updateMatche->execute([
            ':status' => $this->getStatus(),
            ':id' => $this->getId()
        ]);

    }

    public function getcategoriebyId(){
        $this -> categories = Category::getByMatch($this -> getId()) ; 
    }




}