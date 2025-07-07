<?php
require_once __DIR__ . '/../controllers/PretController.php';
require_once __DIR__.'/../db.php';

$db = getDB();
$pretController = new PretController($db);

Flight::route('GET /pret',[$pretController,'findAll']);