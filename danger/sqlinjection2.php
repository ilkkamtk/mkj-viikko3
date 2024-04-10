<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
global $DBH;
require_once __DIR__ . '/../db/dbConnect.php';

$type = $_GET['type'];

$sql = "SELECT * FROM MediaItems WHERE media_type = '$type';";
echo $sql;
$STH = $DBH->query($sql);
while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
    print_r($row);
}
?>