<?php

include __DIR__ . '/../config/requirefichier.php';

require_once __DIR__ . '/../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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

    public function getDataTicket($id)
    {
        $connect = Database::getInstance()->getconnect();
        $query = 'SELECT t.* , m.* , mg.* 
                    FROM tickets t 
                    inner join matches m on m.id = t.match_id 
                    inner join match_categories mg on mg.id = t.cetrgorie_id
                    where t.id = :id ;';
        $query = $connect->prepare($query);
        $query->execute([':id' => $id]);
        return $query->fetch();
    }

    public static function getTicketData(int $id): array
    {
        $connect = Database::getInstance()->getConnect();

        $sql = "SELECT 
                    t.tickets_id,
                    t.ticket_code,
                    mg.price,
                    m.team1_name,
                    m.team2_name,
                    m.team1_short,
                    m.team2_short,
                    m.match_datetime,
                    m.stadium_name,
                    m.city,
                    m.address,
                    m.duration,
                    mg.name AS category_name
                FROM tickets t
                INNER JOIN matches m ON m.id = t.match_id
                INNER JOIN match_categories mg ON mg.id = t.cetrgorie_id
                WHERE t.tickets_id = :id
                LIMIT 1
            ";


        $stmt = $connect->prepare($sql);
        $stmt->execute(['id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    }

    public static function showTicketInBrowser(int $id)
    {
        $data = self::getTicketData($id);
        if (!$data) {
            die('Ticket not found');
        }

        $pdfContent = self::buildTicketPdf($data);


        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="ticket.pdf"');
        echo $pdfContent;
        exit;
    }

    public static function buildTicketPdf(array $ticketData): string
    {
        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->SetMargins(15, 15, 15);

        $pdf->SetFillColor(0, 51, 102);
        $pdf->Rect(0, 0, 210, 45, 'F');

        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('Arial', 'B', 28);
        $pdf->SetXY(15, 12);
        $pdf->Cell(0, 12, 'MATCH TICKET', 0, 1, 'C');

        $pdf->SetFont('Arial', '', 10);
        $pdf->SetXY(15, 28);
        $pdf->Cell(0, 6, 'OFFICIAL MATCH ENTRY PASS', 0, 1, 'C');


        $pdf->SetY(50);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 6, 'TICKET CODE', 0, 1, 'C');

        $pdf->SetFont('Arial', 'B', 16);
        $pdf->SetTextColor(220, 53, 69);
        $pdf->Cell(0, 10, strtoupper($ticketData['ticket_code']), 0, 1, 'C');

        $pdf->SetDrawColor(200, 200, 200);
        $pdf->SetLineWidth(0.5);
        $pdf->Line(40, 72, 170, 72);

        $pdf->SetY(78);
        $pdf->SetTextColor(0, 51, 102);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 8, 'MATCH DETAILS', 0, 1, 'L');

        $pdf->SetTextColor(0, 0, 0);

        $pdf->SetFont('Arial', 'B', 18);
        $pdf->SetTextColor(0, 51, 102);
        $vs_text = $ticketData['team1_name'] . ' VS ' . $ticketData['team2_name'];
        $pdf->Cell(0, 10, $vs_text, 0, 1, 'C');

        $pdf->SetFont('Arial', '', 12);
        $pdf->SetTextColor(100, 100, 100);
        $pdf->Cell(0, 6, '(' . $ticketData['team1_short'] . ' - ' . $ticketData['team2_short'] . ')', 0, 1, 'C');

        $pdf->Ln(3);

        $pdf->SetFillColor(240, 240, 240);
        $pdf->SetDrawColor(200, 200, 200);
        $pdf->Rect(15, $pdf->GetY(), 180, 35, 'FD');

        $boxY = $pdf->GetY() + 5;

        $pdf->SetXY(25, $boxY);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetTextColor(0, 51, 102);
        $pdf->Cell(40, 6, 'DATE & TIME:', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor(0, 0, 0);
        $datetime = new DateTime($ticketData['match_datetime']);
        $pdf->Cell(0, 6, $datetime->format('l, F j, Y - H:i'), 0, 1, 'L');

        $pdf->SetXY(25, $boxY + 9);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetTextColor(0, 51, 102);
        $pdf->Cell(40, 6, 'STADIUM:', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(0, 6, strtoupper($ticketData['stadium_name']), 0, 1, 'L');

        $pdf->SetXY(25, $boxY + 18);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetTextColor(0, 51, 102);
        $pdf->Cell(40, 6, 'LOCATION:', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(0, 6, $ticketData['city'] . ' - ' . $ticketData['address'], 0, 1, 'L');

        $pdf->SetXY(25, $boxY + 27);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetTextColor(0, 51, 102);
        $pdf->Cell(40, 6, 'DURATION:', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(0, 6, $ticketData['duration'] . ' minutes', 0, 1, 'L');

        $pdf->SetY($pdf->GetY() + 15);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->SetTextColor(0, 51, 102);
        $pdf->Cell(0, 8, 'TICKET INFORMATION', 0, 1, 'L');

        $currentY = $pdf->GetY();

        $pdf->SetFillColor(0, 123, 255);
        $pdf->SetDrawColor(0, 123, 255);
        $pdf->Rect(15, $currentY, 85, 25, 'FD');

        $pdf->SetXY(15, $currentY + 5);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(85, 6, 'CATEGORY', 0, 1, 'C');

        $pdf->SetXY(15, $currentY + 13);
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(85, 8, strtoupper($ticketData['category_name']), 0, 0, 'C');

        $pdf->SetFillColor(40, 167, 69);
        $pdf->SetDrawColor(40, 167, 69);
        $pdf->Rect(110, $currentY, 85, 25, 'FD');

        $pdf->SetXY(110, $currentY + 5);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(85, 6, 'PRICE', 0, 1, 'C');

        $pdf->SetXY(110, $currentY + 13);
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(85, 8, '$' . number_format($ticketData['price'], 2), 0, 0, 'C');


        $pdf->SetY($currentY + 35);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 6, 'SCAN QR CODE AT ENTRANCE', 0, 1, 'C');

        // QR Code placeholder box
        $qrY = $pdf->GetY() + 3;
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Rect(80, $qrY, 50, 50, 'D');

        $pdf->SetXY(80, $qrY + 20);
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetTextColor(150, 150, 150);

        $pdf->SetY(250);
        $pdf->SetDrawColor(200, 200, 200);
        $pdf->Line(15, 250, 195, 250);

        $pdf->SetY(253);
        $pdf->SetFont('Arial', 'I', 8);
        $pdf->SetTextColor(100, 100, 100);
        $pdf->MultiCell(
            0,
            4,
            "IMPORTANT: Please arrive 30 minutes before match time. This ticket is non-refundable and non-transferable.
                    Valid ID may be required at entrance. Keep this ticket safe - reprints are not available.",
            0,
            'C'
        );

        $pdf->SetY(267);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(0, 4, 'Created: ' . date('Y-m-d H:i:s'), 0, 0, 'C');

        return $pdf->Output('S');
    }

    public static function sendTicketByMail(int $id, string $email)
    {
        $data = self::getTicketData($id);
        if (!$data) {
            return false;
        }

        $pdfContent = self::buildTicketPdf($data);

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'guemryreda@gmail.com';
        $mail->Password = 'raaufzrfjkmwmwrf';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('guemryreda@gmail.com', 'Fan Seat');
        $mail->addAddress($email);

        $mail->addStringAttachment($pdfContent, 'ticket.pdf');

        $mail->isHTML(true);
        $mail->Subject = 'Votre ticket';
        $mail->Body = '<p>Voici votre ticket </p>';

        return $mail->send();
    }


    public static function getTicketsByUserId($user_id)
    {
        $connect = Database::getInstance()->getConnect();

        $query = 'SELECT t.* , m.* , mg.* 
                    FROM tickets t 
                    inner join matches m on m.id = t.match_id 
                    inner join match_categories mg on mg.id = t.cetrgorie_id
                    where t.user_id = :id ;';
        $query = $connect->prepare($query);
        $query->execute([':id' => $user_id]);
        return $query->fetchAll();
    }

}