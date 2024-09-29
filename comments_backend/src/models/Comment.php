<?php

namespace App\Models;

use PDO;
use PDOException;

class Comment
{
    private $db;

    public function __construct()
    {
        $this->db = new Db();  // Подключение через класс Db
    }

    public function getAllComments()
    {
        $sql = "SELECT * FROM Comments.Comments";
        try {
            $conn = $this->db->connect();
            $stmt = $conn->query($sql);
            $comments = $stmt->fetchAll(PDO::FETCH_OBJ);
            $conn = null;
            return $comments;
        } catch (PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function addComment($username, $content)
    {
        $sql = "INSERT INTO Comments.Comments (Comment_username, Comment_content, Comment_datetime) VALUES (:username, :content, :datetime);";
        $datetime = date("Y-m-d H:i:s");
        echo "$username";

        try {
            $conn = $this->db->connect();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':content', $content);
            $stmt->bindParam(':datetime', $datetime);
            $stmt->execute();
            $conn = null;
            return true;
        } catch (PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function deleteComment($id)
    {
        $sql = "DELETE FROM Comments.Comments WHERE Comment_Id = :id";
        try {
            $conn = $this->db->connect();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $conn = null;
            return true;
        } catch (PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
