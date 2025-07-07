<?php
require_once __DIR__ . '/../models/ClientModel.php';
require_once __DIR__ . '/../helpers/Utils.php';



class EtudiantController {
    public static function getAll() {
        $clients = ClientModel::getAll();
        Flight::json($clients);
    }

    public static function getById($id) {
        $client = ClientModel::getById($id);
        Flight::json($client);
    }

    public static function delete($id) {
        Etudiant::delete($id);
        Flight::json(['message' => 'Client supprimé']);
    }
}