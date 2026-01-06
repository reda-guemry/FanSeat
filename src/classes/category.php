<?php 

include __DIR__ . '/../config/requirefichier.php';

class Category {
    public static function getByMatch($id) {
        $connect = Database::getInstance() ->getconnect() ; 
        
        $sql = $connect -> prepare('SELECT * FROM match_categories WHERE match_id = :id ') ;
        $sql -> execute([':id' => $id]) ;
        
        return $sql -> fetchAll() ;

        
    }
}