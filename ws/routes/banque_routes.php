<?php
require_once __DIR__ . '/../controllers/BanqueController.php';
require_once __DIR__.'/../db.php';

$db = getDB();
$banqueController = new BanqueController($db);

Flight::route('GET /banque/interet',[$banqueController,'findIntererMensuel']);
Flight::route('GET /banques', [$banqueController, 'findAll']);
Flight::route('GET /banques/@id', [$banqueController, 'findById']);
Flight::route('GET /banque/tableau_remboursement',[$banqueController,'getTableauRemboursementPret']);
Flight::route('POST /banque/rembourser',[$banqueController,'faireRemboursement']);