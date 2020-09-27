<?php
namespace Src\Model;

use PDO;
use PDOException;

class Post {
    protected $table = 'posts';
    private $db = null;
    
    public $id;
    public $title;
    public $content;
    public $user_id;
    public $created_at;
    public $updated_at;

    public function __construct($db) {
        $this->db = $db;
    }

    public function listAll() {
        $query = "SELECT * FROM posts";

        try {
            $query = $this->db->query($query);
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch(PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function find($id) {
        $query = "SELECT * FROM posts WHERE posts.id = ${id}";

        try {
            $query = $this->db->query($query);
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch(PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function create(Array $input) {
        $query = "
            INSERT INTO posts
                (title, content, user_id)
            VALUES
                (:title, :content, :user_id)
        ";

        try {
            $query = $this->db->prepare($query);
            $query->execute([
                'title' => $input['title'],
                'content' => $input['content'],
                'user_id' => $input['user_id'] ?? null,
            ]);
            return $query->rowCount();
        } catch(PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function update($id, Array $input) {
        $query = "
            UPDATE posts
            SET 
                title = :title,
                content  = :content,
                user_id = :user_id,
            WHERE id = :id;
        ";

        try {
            $query = $this->db->prepare($query);
            $query->execute([
                'title' => $input['title'],
                'content'  => $input['content'],
                'user_id' => $input['user_id'] ?? null,
            ]);
            return $query->rowCount();
        } catch (PDOException $e) {
            exit($e->getMessage());
        }  
    }

    public function delete($id) {
        $query = "
            DELETE FROM posts
            WHERE id = :id;
        ";

        try {
            $query = $this->db->prepare($query);
            $query->execute(['id' => $id]);
            return $query->rowCount();
        } catch(PDOException $e) {
            exit($e->getMessage());
        }
    }
}
