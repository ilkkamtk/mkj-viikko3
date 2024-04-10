<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
global $DBH;
require_once __DIR__ . '/../db/dbConnect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username']) && isset($_POST['password'])) {

        $sql = "SELECT * FROM Users WHERE username = :username AND login_attempts < 5";
        $data = [
            'username' => $_POST['username'],
        ];
        $STH = $DBH->prepare($sql);
        $STH->execute($data);
        $user = $STH->fetch(PDO::FETCH_ASSOC);
        // print_r($user);
        if (!$user) {
            //header('Location: ../index.php?success=Invalid username or password');
            die('too many fail');
        }
        $sql1 = "UPDATE Users SET login_attempts = login_attempts + 1 WHERE username = :username";
        $data1 = [
            'username' => $_POST['username'],
        ];
        $STH1 = $DBH->prepare($sql1);
        $STH1->execute($data1);

        if (password_verify($_POST['password'], $user['password'])) {
            $sql2 = "UPDATE Users SET login_attempts = 0 WHERE username = :username";
            $data2 = [
                'username' => $_POST['username'],
            ];
            $STH2 = $DBH->prepare($sql2);
            $STH2->execute($data2);

            $_SESSION['user'] = $user;
            print_r($_SESSION['user']);
            // redirect to secret page
            header('Location: ../home.php');
            exit;
        } else {
            echo 'fail pwd';
           header('Location: ../index.php?success=Invalid username or password');
        }
    }
}
?>