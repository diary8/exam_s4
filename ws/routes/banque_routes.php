<?php
require_once __DIR__ . '/../controllers/BanqueController.php';
require_once __DIR__.'/../db.php';

$db = getDB();
$banqueController = new BanqueController($db);

Flight::route('GET /banque/interet',[$banqueController,'findIntererMensuel']);