<?php
global $DBH;
require_once __DIR__ . '/../db/dbConnect.php';

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM Users WHERE username = '$username' AND password = '$password'";
echo $sql;
$STH = $DBH->query($sql);
$user = $STH->fetch(PDO::FETCH_ASSOC);
print_r($user);
?>