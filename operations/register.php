<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
global $DBH;
require_once __DIR__ . '/../db/dbConnect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email'])) {
        $data = [
            'username' => $_POST['username'],
            'password' => password_hash($_POST['password'], PASSWORD_BCRYPT),
            'email' => $_POST['email']
        ];

        $sql = 'INSERT INTO Users (username, password, email, user_level_id) VALUES (:username, :password, :email, 2)';

        try {
            $STH = $DBH->prepare($sql);
            $STH->execute($data);
            header('Location: ../index.php?success=Registration successful');
        } catch (PDOException $e) {
            echo "Could not insert data into the database." . $e->getMessage();
            file_put_contents('PDOErrors.txt', 'register.php - ' . $e->getMessage(), FILE_APPEND);
        }
    }
}
?>
