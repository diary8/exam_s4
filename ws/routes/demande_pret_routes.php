<?php
require_once __DIR__.'/../controllers/DemandePretController.php';
require_once __DIR__.'/../db.php';

$demandeController = new DemandePretController($db);

Flight::route('POST /demandes_pret', [$demandeController, 'create']);
Flight::route('GET /demandes_pret', [$demandeController, 'findAll']);