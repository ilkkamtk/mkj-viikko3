<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ../index.php');
    exit;
}

global $DBH;
require_once __DIR__ . '/../db/dbConnect.php';

require_once __DIR__ . '/../MediaProject/MediaItemDbOps.class.php';

$mediaItemDbOps = new MediaProject\MediaItemDbOps($DBH);

if(isset($_GET['id'])) {
    if ($mediaItemDbOps->deleteMediaItem($_GET['id'], $_SESSION['user']['user_id'])) {
        header('Location: ../home.php?success=Item deleted');
    } else {
        header('Location: ../home.php?success=Item not deleted');
    }
} else {
    header('Location: ../home.php?success=No hacking allowed.');
}