<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}

global $DBH;
require_once __DIR__ . '/../db/dbConnect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['title']) && isset($_POST['description'])) {
        $data = [
            'title' => $_POST['title'],
            'description' => $_POST['description'],
            'media_id' => $_POST['media_id'],
            'user_id' => $_SESSION['user']['user_id'],
        ];

        $sql = 'UPDATE MediaItems SET title = :title, description = :description WHERE media_id = :media_id AND user_id = :user_id';

        try {
            $STH = $DBH->prepare($sql);
            $STH->execute($data);
            if ($STH->rowCount() === 0) {
                header('Location: ../home.php?success=Item not modified');
                exit;
            }
            header('Location: ../home.php?success=Item modified');
        } catch (PDOException $e){
            echo "Could not modify data in the database.";
            file_put_contents('PDOErrors.txt', 'modifyData.php - ' . $e->getMessage(), FILE_APPEND);
        }
    }
}
