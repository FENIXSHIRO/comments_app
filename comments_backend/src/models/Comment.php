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
    $sql = "INSERT INTO Comments.Comments (Comment_username, Comment_content, Comment_datetime) VALUES (:Comment_username, :Comment_content, :datetime);";
    $datetime = date("Y-m-d H:i:s");

    try {
        $conn = $this->db->connect();
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':Comment_username', $username);
        $stmt->bindParam(':Comment_content', $content);
        $stmt->bindParam(':datetime', $datetime);
        $stmt->execute();

        // Получаем ID добавленной записи
        $lastInsertId = $conn->lastInsertId();

        // Получаем саму запись по этому ID
        $stmt = $conn->prepare("SELECT * FROM Comments.Comments WHERE Comment_Id = :id");
        $stmt->bindParam(':id', $lastInsertId);
        $stmt->execute();

        // Возвращаем запись
        $comment = $stmt->fetch(PDO::FETCH_ASSOC);

        $conn = null;
        return $comment;
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
