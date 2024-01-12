<?php
namespace App\models;
use App\models\DynamicCrud;
use App\models\DataBase;
use PDOException;
use PDO;

class WikiModel extends DynamicCrud
{
    
    public function __construct(){
        $conection = new DataBase;
        $pdo = $conection->getconn();
        $this->conn=$pdo;
        parent::__construct('categories');
    }
    public function read($column = "",$keyWord = "") {
        try {
            $query = "SELECT W.*, U.user_name AS author_name, C.category_name AS category_name 
                      FROM wikis W 
                      INNER JOIN categories C ON W.category_id = C.category_id 
                      INNER JOIN users U ON W.author_id = U.user_id;";
            
            if (!empty($condition)) {
                $query .= "$keyWord";
            }

            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $wikis = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $wikis;
     
        } catch (PDOException $e) {
            $this->error = "Read operation failed: " . $e->getMessage();
            return false;
        }
    }
    public function addwiki($wiki, $tags) {
        try {
           $wiki['author_id'] = $_SESSION['user_id'];
            // Insert Wiki
            
            $columns = implode(',', array_keys($wiki));
            $values = implode(',', array_fill(0, count($wiki), '?'));
            $query = "INSERT INTO Wikis ($columns) VALUES ($values)";

            $stmt = $this->conn->prepare($query);
            $stmt->execute(array_values($wiki));

            $user_id = $_SESSION['user_id'];
            $wiki_id_query = "SELECT wiki_id FROM wikis WHERE wikis.author_id = ? ORDER BY wiki_id DESC LIMIT 1";
            $stmt = $this->conn->prepare($wiki_id_query);
            $stmt->execute([$user_id]);
            $wikid = $stmt->fetch(PDO::FETCH_ASSOC);
            $id = $wikid['wiki_id'];
            
            // // Insert WikiTags 
            $addTagsQuery = "INSERT INTO WikiTags (wiki_id, tag_id) VALUES (?, ?)";
            $stmt = $this->conn->prepare($addTagsQuery);
            
            foreach ($tags as $tag): 
                $result = $stmt->execute([$id, $tag]) ;
            endforeach;
    
            return $result;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage(); 
            return false;
        }
    }
    
}