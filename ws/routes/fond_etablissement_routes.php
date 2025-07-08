<?php
require_once __DIR__.'/../controllers/FondEtablissementController.php';
require_once __DIR__.'/../db.php';

$fondsController = new FondEtablissementController($db);

Flight::route('GET /fonds/mouvements/@banque_id', [$fondsController, 'getMovements']);
Flight::route('GET /banques', [$fondsController, 'getAllBanks']);
