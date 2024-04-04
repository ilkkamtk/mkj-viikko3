<?php

namespace MediaProject;

require_once 'MediaItem.class.php';

class MediaItemDbOps {
    private \PDO $DBH;

    public function __construct($DBH) {
        $this->DBH = $DBH;
    }

    public function getMediaItems(): array {
        $sql = 'SELECT * FROM MediaItems;';
        $STH = $this->DBH->query($sql);
        $STH->setFetchMode(\PDO::FETCH_ASSOC);
        $mediaItems = [];
        while ($row = $STH->fetch()) {
            $mediaItems[] = new MediaItem($row);
        }
        return $mediaItems;
    }

    public function insertMediaItem($data): bool {
        $sql = 'INSERT INTO MediaItems (user_id, filename, filesize, media_type, title, description) 
                VALUES (:user_id, :filename, :filesize, :media_type, :title, :description)';
        try {
            $STH = $this->DBH->prepare($sql);
            $STH->execute($data);
            return true;
        } catch (\PDOException $e) {
            file_put_contents('PDOErrors.txt', 'MediaItemDbOps.class.php - ' . $e->getMessage() . PHP_EOL, FILE_APPEND);
            return false;
        }
    }
}