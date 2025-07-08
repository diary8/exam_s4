<?php
require_once __DIR__ . '/../controllers/PretController.php';
require_once __DIR__ . '/../db.php';

$db = getDB();
$pretController = new PretController($db);

Flight::route('GET /pret/banque', [$pretController, 'findAllByBanqueId']);
Flight::route('GET /pret', [$pretController, 'findAll']);
Flight::route('POST /pret', [$pretController, 'create']);
Flight::route('GET /pret/@id', [$pretController, 'findById']);
Flight::route('GET /pret_client/@id', [$pretController, 'findByIdDetails']);