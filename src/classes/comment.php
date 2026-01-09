<?php
include __DIR__ . '/../config/requirefichier.php';

class Comment {
    private $id;
    private $user_id;
    private $match_id;
    private $comment_review;
    private $comment;

    public function __construct($data = []) {
        $this->id = $data["id"] ?? null;
        $this->user_id = $data["user_id"] ?? null;
        $this->match_id = $data["match_id"] ?? null;
        $this->comment_review = $data["comment_review"] ?? null;
        $this->comment = $data["comment"] ?? '';
    }

    // ======== GETTERS ========
    public function getId(): ?int {
        return $this->id;
    }

    public function getUserId(): ?int {
        return $this->user_id;
    }

    public function getMatchId(): ?int {
        return $this->match_id;
    }

    public function getCommentReview(): ?int {
        return $this->comment_review;
    }

    public function getComment(): string {
        return $this->comment;
    }

    // ======== SETTERS ========
    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setUserId(int $user_id): void {
        $this->user_id = $user_id;
    }

    public function setMatchId(int $match_id): void {
        $this->match_id = $match_id;
    }

    public function setCommentReview(int $comment_review): void {
        $this->comment_review = $comment_review;
    }

    public function setComment(string $comment): void {
        $this->comment = $comment;
    }

    public function saveComment(): void {
        $connect = DAtabase::getInstance() -> getconnect() ;
        $insert = $connect -> prepare ('INSERT INTO comments (user_id , match_id , comment_review , comment)
                                VALUE (:user_id , :match_id , :comment_review , :comment)') ;
        $insert -> execute ( [ 
            ':user_id'=> $this->user_id,
            ':match_id'=> $this->match_id,
            ':comment_review'=> $this->comment_review,
            ':comment'=> $this->comment
        ] ) ;
    }

    public static function getCommentsByMatchId(int $match_id): array {
        $connect = DAtabase::getInstance() -> getconnect() ;
        $select = $connect -> prepare ('SELECT c.*, u.first_name AS user_name
                                                FROM comments c
                                                JOIN users u ON u.id = c.user_id
                                                WHERE c.match_id = :id
                                                ORDER BY c.created_at DESC ') ;
        $select -> execute ( [':id' => $match_id ] ) ;

        return $select -> fetchAll() ;
    }

    public static function avgOfAllComment() {
        $connect = DAtabase::getInstance() -> getconnect() ;
        $select = $connect -> query ('SELECT ROUND(AVG(comment_review) , 1) FROM comments') ;
        return $select -> fetchColumn() ;
    }

}
