<?php
require_once __DIR__ . '/../db.php';

class ClientModel {
    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM client JOIN compte_client c ON client.compte_client_id = c.id");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }   

    public static function getById($id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM client WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public static function delete($id) {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM client WHERE id = ?");
        $stmt->execute([$id]);
    }

    public static function getAge($id){
        $db = getDB();
        $stmt = $db->prepare("SELECT TIMESTAMPDIFF(YEAR, date_de_naissance, CURDATE()) AS age FROM client WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    
}


